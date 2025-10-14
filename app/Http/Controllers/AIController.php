<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AIController extends Controller
{
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $message = $request->input('message');

        try {
            $output = null;
            $status = null;

            // Appel du modèle Ollama 3
            // Assure-toi que le modèle s'appelle exactement "llama3" dans Ollama
            exec("ollama run llama3 " . escapeshellarg($message), $output, $status);

            if ($status !== 0) {
                return response()->json([
                    'error' => 'Erreur lors de l’exécution du modèle Ollama 3.'
                ], 500);
            }

            $reply = implode("\n", $output);

            return response()->json(['reply' => $reply]);

        } catch (\Throwable $e) {
            \Log::error('AIController Ollama 3: ' . $e->getMessage());
            return response()->json([
                'error' => 'Une erreur est survenue lors de l’appel à Ollama 3.'
            ], 500);
        }
    }
}