<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AiChatService;

class AiChatController extends Controller
{
    protected AiChatService $aiService;

    public function __construct(AiChatService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function ask(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
        ]);

        try {
            $message = $request->input('message');

            // Usar el session_id de Laravel (o generar uno si no existe)
            $sessionId = session()->getId();

            // Comprobar si ya se ha saludado
            $saludoPrevio = session()->get('saludado', false);

            // Obtener conocimientos relevantes
            $knowledgeMatches = $this->aiService->getRelevantKnowledge($message);

            // Generar respuesta y pasar flag de saludo solo si no se ha saludado
            $answer = $this->aiService->ask($message, $knowledgeMatches, $sessionId, !$saludoPrevio);

            // Marcar que ya se saludó
            if (!$saludoPrevio) {
                session(['saludado' => true]);
            }

        } catch (\Throwable $e) {
            return response()->json([
                'answer' => 'Error al generar la respuesta: '.$e->getMessage()
            ], 500);
        }

        return response()->json(['answer' => (string) $answer]);
    }
}
