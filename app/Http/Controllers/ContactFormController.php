<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;

use App\Mail\ContactFormSubmitted;
use App\Models\Customer;
use App\Models\CustomerMetadata;
use App\Models\Category;

class ContactFormController extends Controller
{
    public function create()
    {
        $categories = Category::all();
        return view('partials.contact', compact('categories'));
    }

    public function store(Request $request)
    {
        try {

            /* =========================================================================
             * 1) VERIFICAR CAPTCHA
             * ========================================================================= */
            $hcaptchaToken   = $request->input('h-captcha-response');
            $captchaSuccess  = false;

            if (!empty($hcaptchaToken)) {
                try {
                    $verify = Http::asForm()->post('https://hcaptcha.com/siteverify', [
                        'secret'   => env('HCAPTCHA_SECRET'),
                        'response' => $hcaptchaToken,
                        'remoteip' => $request->ip(),
                    ]);

                    $captchaSuccess = $verify->json()['success'] ?? false;

                } catch (\Throwable $e) {
                    Log::warning("HCaptcha verify failed", ['exception' => $e]);
                }
            }

            /* =========================================================================
             * 2) RESOLVER visitor_id
             * ========================================================================= */
            $sessionId =
                $request->header('X-Visitor-ID')
                ?? $request->input('visitor_id')
                ?? $request->cookie('visitor_id')
                ?? 'v_' . uniqid();

            $existingMeta = CustomerMetadata::where('session_id', $sessionId)->first();

            /* =========================================================================
             * 3) ANTI-BOT SIGNALS
             * ========================================================================= */
            $botScoreFromSignals = 0;
            $signals = json_decode($request->bot_signals ?? '{}', true) ?: [];

            if (($signals['cookies_enabled'] ?? 1) == 0) $botScoreFromSignals += 40;
            if (($signals['mouse_moves'] ?? 1) == 0) $botScoreFromSignals += 20;
            if (($signals['scroll_events'] ?? 1) == 0) $botScoreFromSignals += 10;
            if (($signals['keypress_events'] ?? 1) == 0) $botScoreFromSignals += 10;
            if (($signals['time_spent'] ?? 99999) < 2000) $botScoreFromSignals += 30;

            /* =========================================================================
             * 4) CAPTCHA FALLA → SUMA +30 (+ señales) Y BLOQUEA SI ≥50
             * ========================================================================= */
            if (!$captchaSuccess) {

                $previousScore = $existingMeta->bot_score ?? 0;
                $newBotScore   = $previousScore + 30 + $botScoreFromSignals;
                $blocked       = $newBotScore >= 50;

                if ($existingMeta) {
                    $existingMeta->update([
                        'bot_score'     => $newBotScore,
                        'suspected_bot' => $newBotScore >= 30,
                        'blocked'       => $blocked,
                    ]);
                } else {
                    CustomerMetadata::create([
                        'session_id'        => $sessionId,
                        'registration_date' => now(),
                        'browser_language'  => mb_substr($request->header('Accept-Language') ?? '', 0, 10),
                        'source'            => url()->previous() ?? 'Formulario de contacto',
                        'geolocation'       => ['ip' => $request->ip()],
                        'consent_given'     => true,
                        'suspected_bot'     => $newBotScore >= 30,
                        'bot_score'         => $newBotScore,
                        'blocked'           => $blocked,
                    ]);
                }

                return response()->json([
                    'status'  => 'error',
                    'message' => $blocked
                        ? 'Captcha failed. User blocked.'
                        : 'Captcha failed. Please try again.'
                ], 422);
            }

            /* =========================================================================
             * 5) CAPTCHA OK → PERMITIDO SI bot_score < 50
             * ========================================================================= */
            $botScore = $existingMeta->bot_score ?? 0;

            if ($existingMeta && ($existingMeta->blocked ?? false)) {
                return response()->json([
                    'status'  => 'error',
                    'message' => 'Suspicious activity detected. Submission blocked.'
                ], 403);
            }

            if ($botScore >= 50) {
                $existingMeta?->update([
                    'blocked'       => true,
                    'suspected_bot' => true,
                ]);

                return response()->json([
                    'status'  => 'error',
                    'message' => 'Suspicious activity detected. Submission blocked.'
                ], 403);
            }

            $suspectedBot = $botScore >= 30;

            if ($existingMeta) {
                $existingMeta->update([
                    'bot_score'     => $botScore,
                    'suspected_bot' => $suspectedBot,
                ]);
            }

            /* =========================================================================
             * 6) VALIDACIÓN
             * ========================================================================= */
            $validated = $request->validate([
                'first_name'       => 'nullable|string|max:255',
                'last_name'        => 'nullable|string|max:255',
                'country'          => 'nullable|string|max:255',
                'city'             => 'nullable|string|max:255',
                'phone'            => 'nullable|string|max:50',
                'company'          => 'nullable|string|max:255',
                'email'            => 'required|email|max:255',
                'notes'            => 'nullable|string|max:2000',
                'browser_language' => 'nullable|string|max:10',
                'interests'        => 'nullable|array',
            ]);

            /* =========================================================================
             * 7) CUSTOMER
             * ========================================================================= */
            $emailSearch = strtolower(trim($validated['email']));
            $customer = Customer::where('email_search', $emailSearch)->first() ?? new Customer();

            $customer->first_name = $validated['first_name'] ?? null;
            $customer->last_name  = $validated['last_name'] ?? null;
            $customer->phone      = $validated['phone'] ?? null;
            $customer->company    = $validated['company'] ?? null;
            $customer->country    = $validated['country'] ?? null;
            $customer->city       = $validated['city'] ?? null;
            $customer->notes      = $validated['notes'] ?? null;
            $customer->email      = $validated['email'];

            $customer->save();

            /* =========================================================================
             * 8) INTERESES
             * ========================================================================= */
            if ($request->filled('interests')) {
                $customer->categories()->sync($request->interests);
            }

            /* =========================================================================
             * 9) METADATA FINAL
             * ========================================================================= */
            $consentFlag = ($request->cookie('cookie_consent') === 'accepted');

            if ($existingMeta) {
                if (!$existingMeta->customer_id) {
                    $existingMeta->customer_id = $customer->id;
                }

                $existingMeta->finalized     = true;
                $existingMeta->suspected_bot = $suspectedBot;
                $existingMeta->save();
            } else {
                CustomerMetadata::create([
                    'session_id'        => $sessionId,
                    'customer_id'       => $customer->id,
                    'registration_date' => now(),
                    'browser_language'  => mb_substr($validated['browser_language']
                        ?? $request->header('Accept-Language') ?? '', 0, 10),
                    'source'            => url()->previous() ?? 'Formulario de contacto',
                    'geolocation'       => $consentFlag ? ['ip' => $request->ip()] : null,
                    'consent_given'     => $consentFlag,
                    'suspected_bot'     => $suspectedBot,
                    'bot_score'         => $botScore,
                    'finalized'         => true,
                ]);
            }

            /* =========================================================================
             * 10) ✉️ EMAIL AL ADMIN (NO ROMPE EL FORMULARIO)
             * ========================================================================= */
            try {
                Mail::to('ventas@clevertrading.eu')
                    ->send(new ContactFormSubmitted($customer));
            } catch (\Throwable $mailError) {
                Log::error('Email error', ['exception' => $mailError]);
            }

            /* =========================================================================
             * 11) RESPUESTA FINAL
             * ========================================================================= */
            return response()->json([
                'status'  => 'ok',
                'message' => 'Your message has been sent successfully. Thank you!'
            ], 200);

        } catch (\Throwable $e) {

            Log::error('Error en ContactFormController@store', ['exception' => $e]);

            return response()->json([
                'status'  => 'error',
                'message' => 'Error al procesar la solicitud.',
            ], 500);
        }
    }
}
