<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CustomerMetadata;
use Illuminate\Support\Facades\Log;

class CustomerMetadataController extends Controller
{
    protected function generateVisitorId(): string
    {
        try {
            return 'v_' . bin2hex(random_bytes(5));
        } catch (\Throwable $e) {
            return 'v_' . uniqid();
        }
    }

    /* =========================================================================
     * STORE CONSENT
     * ========================================================================= */
    public function storeConsent(Request $request)
    {
        try {
            $consentFlag = ($request->input('consent') === 'accepted');

            $sessionId =
                ($request->filled('visitor_id') ? urldecode($request->visitor_id) : null)
                ?? ($request->hasCookie('visitor_id') ? urldecode($request->cookie('visitor_id')) : null)
                ?? $this->generateVisitorId();

            $rawLang = (string) ($request->header('Accept-Language') ?? '');
            $browserLang = mb_substr(preg_replace('/\s+/', '', $rawLang), 0, 10);

            $source = mb_substr(($request->headers->get('referer') ?? url()->current()), 0, 255);

            $metadata = CustomerMetadata::where('session_id', $sessionId)->first();

            if ($metadata && (($metadata->blocked ?? false) || ($metadata->finalized ?? false))) {
                return response()->json(['status' => 'ignored'], 204);
            }

            if (!$metadata) {
                $metadata = CustomerMetadata::create([
                    'session_id'        => $sessionId,
                    'registration_date' => now(),
                    'consent_given'     => $consentFlag,
                    'browser_language'  => $browserLang,
                    'source'            => $source,
                ]);
            } else {
                $metadata->update([
                    'consent_given'    => $consentFlag,
                    'browser_language' => $browserLang,
                    'source'           => $source,
                ]);
            }

            if ($consentFlag) {

                $geoInput = $request->input('geolocation');

                $metadata->update([
                    'geolocation' => [
                        'ip'       => $request->ip(),
                        'lat'      => $geoInput['lat'] ?? null,
                        'lon'      => $geoInput['lon'] ?? null,
                        'accuracy' => $geoInput['accuracy'] ?? null,
                    ]
                ]);

            } else {

                $metadata->update([
                    'geolocation'   => null,
                    'digital_trace' => null,
                ]);
            }

            return response()->json(['status' => 'ok'], 200);

        } catch (\Throwable $e) {

            Log::error("storeConsent ERROR", ['exception' => $e]);
            return response()->json(['status' => 'error'], 500);
        }
    }


    /* =========================================================================
     * STORE TRACE
     * ========================================================================= */
    public function storeTrace(Request $request)
    {
        try {
            $eventType = $request->input('type', 'trace');
            $href = (string) $request->input('href', '');
            $path = parse_url($href, PHP_URL_PATH) ?? '';

            // ❌ Nunca registrar rutas internas
            $ignoredPrefixes = [
                "/dashboard",
                "/customers",
                "/admin",
                "/filter",
                "/metadata",
            ];

            foreach ($ignoredPrefixes as $pfx) {
                if ($path !== '' && str_starts_with($path, $pfx)) {
                    return response()->json(['status' => 'ignored'], 204);
                }
            }

            $sessionId =
                ($request->filled('visitor_id') ? urldecode($request->visitor_id) : null)
                ?? ($request->hasCookie('visitor_id') ? urldecode($request->cookie('visitor_id')) : null);

            if (!$sessionId) {
                return response()->json(['status' => 'ignored'], 204);
            }

            $metadata = CustomerMetadata::where('session_id', $sessionId)->first();

            if (!$metadata) {
                return response()->json(['status' => 'ignored'], 204);
            }

            // ❌ No registrar nada si ya está finalizado
            if ($metadata->finalized) {
                return response()->json(['status' => 'ignored'], 204);
            }

            // ❌ No registrar si está bloqueado
            if (($metadata->bot_score ?? 0) >= 50 || ($metadata->blocked ?? false)) {
                return response()->json(['status' => 'ignored'], 204);
            }

            if (!$metadata->consent_given) {
                return response()->json(['status' => 'ignored'], 204);
            }

            // Añadir nuevo evento
            $trace = is_array($metadata->digital_trace) ? $metadata->digital_trace : [];

            $trace[] = [
                'type'      => $eventType,
                'text'      => mb_substr($request->input('text', ''), 0, 200),
                'href'      => $href ?: null,
                'timestamp' => $request->input('timestamp', now()->toIso8601String()),
            ];

            $metadata->update(['digital_trace' => $trace]);

            return response()->json(['status' => 'ok'], 200);

        } catch (\Throwable $e) {
            Log::error("storeTrace ERROR", ['exception' => $e]);
            return response()->json(['status' => 'error'], 500);
        }
    }


    /* =========================================================================
     * INDEX
     * ========================================================================= */
    public function index()
    {
        return view('customers.metadata', [
            'metadataItems' => CustomerMetadata::orderBy('id','desc')->get()
        ]);
    }
}
