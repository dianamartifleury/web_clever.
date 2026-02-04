<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CookieEvent;
use App\Models\CustomerMetadata;
use Illuminate\Support\Facades\Log;

class CookieEventController extends Controller
{
    public function store(Request $request)
    {
        try {
            // Registrar siempre el evento de cookie (accept/decline)
            $consent = $request->input('consent', $request->cookie('cookie_consent'));

            // Resolver session/visitor id
            $sessionId = $request->input('visitor_id') ?? $request->cookie('visitor_id') ?? session()->getId();

            if (!$sessionId || trim($sessionId) === '') {
                $sessionId = session()->getId();
            }

            // Buscar metadata si existe
            $meta = CustomerMetadata::where('session_id', $sessionId)->first();

            if ($meta) {

                // ★ CAMBIO 1: NO registrar CookieEvent si usuario bloqueado o finalizado
                if (($meta->bot_score ?? 0) >= 50 || ($meta->blocked ?? false)) {
                    Log::info("CookieEvent ignored: user blocked", [
                        'session_id' => $sessionId,
                        'bot_score'  => $meta->bot_score ?? null
                    ]);

                    return response()->json([
                        'status' => 'ignored',
                        'reason' => 'blocked'
                    ], 204);
                }

                if ($meta->finalized ?? false) {
                    Log::info("CookieEvent ignored: metadata finalized", [
                        'session_id' => $sessionId
                    ]);

                    return response()->json([
                        'status' => 'ignored',
                        'reason' => 'finalized'
                    ], 204);
                }

                // SI YA ESTÁ ASOCIADA A CUSTOMER → ignorar (tu lógica original)
                if ($meta->customer_id !== null) {
                    Log::info('CookieEvent ignored: metadata already associated to customer', [
                        'session_id' => $sessionId,
                        'metadata_id' => $meta->id,
                        'customer_id' => $meta->customer_id
                    ]);
                    return response()->json(['status' => 'ignored','reason'=>'already-submitted'], 204);
                }
            }

            // Registrar el CookieEvent (always)
            CookieEvent::create([
                'event_type' => $request->input('type', 'consent'),
                'data'       => $request->except(['_token']),
                'ip'         => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'session_id' => $sessionId,
            ]);

            return response()->json(['status' => 'ok'], 200);

        } catch (\Throwable $e) {
            Log::error('Error CookieEventController: ' . $e->getMessage(), [
                'payload' => $request->all()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
