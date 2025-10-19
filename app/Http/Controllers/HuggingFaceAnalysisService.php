<?php

namespace App\Services;

use App\Models\Experience;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AIAnalysisService
{
    private $apiUrl = 'https://api-inference.huggingface.co/models';
    private $apiToken;

    public function __construct()
    {
        $this->apiToken = env('HUGGING_FACE_TOKEN');
        if (empty($this->apiToken)) {
            throw new \Exception('HUGGING_FACE_TOKEN non configuré');
        }
    }

    /**
     * Analyse une expérience individuelle
     */
    public function analyzeExperience(Experience $experience)
    {
        $data = [
            'testimonial' => $experience->testimonial,
            'strengths' => $experience->strengths,
            'personal_impact' => $experience->personal_impact,
            'improvements' => $experience->improvements,
            'lessons' => $experience->lessons,
            'recommendation' => $experience->recommendation
        ];

        try {
            $sentiment = $this->analyzeSentiment($data);
            $summary = $this->generateSummary($data);

            return [
                'sentiment' => $sentiment,
                'summary' => $summary,
                'success' => true
            ];
        } catch (\Exception $e) {
            Log::error('Erreur analyse expérience: ' . $e->getMessage());
            return [
                'sentiment' => 'erreur',
                'summary' => 'Analyse en attente',
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Analyse une collection d'expériences (pour campagne)
     */
    public function analyzeExperiencesCollection($experiences)
    {
        if ($experiences->isEmpty()) {
            return [
                'summary' => 'Aucune expérience à analyser',
                'sentiment' => 'neutre',
                'success' => false
            ];
        }

        // Combiner tous les textes des expériences
        $allText = $experiences->map(function($exp) {
            return implode('. ', array_filter([
                $exp->testimonial,
                $exp->strengths,
                $exp->personal_impact,
                $exp->improvements,
                $exp->lessons,
                $exp->recommendation
            ]));
        })->implode(" ");

        if (empty(trim($allText))) {
            return [
                'summary' => 'Aucun contenu textuel à analyser',
                'sentiment' => 'neutre',
                'success' => false
            ];
        }

        $data = [
            'testimonial' => $allText,
            'strengths' => '',
            'personal_impact' => '',
            'improvements' => '',
            'lessons' => '',
            'recommendation' => ''
        ];

        try {
            $sentiment = $this->analyzeSentiment($data);
            $summary = $this->generateSummary($data);

            return [
                'summary' => $summary,
                'sentiment' => $sentiment,
                'success' => true
            ];
        } catch (\Exception $e) {
            Log::error('Erreur analyse collection: ' . $e->getMessage());
            return [
                'summary' => 'Analyse temporairement indisponible',
                'sentiment' => 'neutre',
                'success' => false
            ];
        }
    }

    /**
     * Analyse de sentiment
     */
    private function analyzeSentiment(array $data)
    {
        $text = $this->extractTextForAnalysis($data);
        return $this->callSentimentAPI($text);
    }

    /**
     * Génération de résumé
     */
    private function generateSummary(array $data)
    {
        $text = $this->extractTextForAnalysis($data);
        return $this->callSummaryAPI($text);
    }

    /**
     * Extraction du texte pour analyse
     */
    private function extractTextForAnalysis($experience, $maxLength = 1000)
    {
        $textParts = [];
        $fields = ['testimonial','strengths','personal_impact','improvements','lessons','recommendation'];

        foreach ($fields as $field) {
            if (!empty($experience[$field]) && trim($experience[$field]) !== '') {
                $textParts[] = trim($experience[$field]);
            }
        }

        if (empty($textParts)) {
            throw new \Exception('Aucun texte à analyser');
        }

        $combinedText = implode('. ', $textParts);
        
        if ($maxLength && strlen($combinedText) > $maxLength) {
            $combinedText = substr($combinedText, 0, $maxLength);
        }
        
        return $combinedText;
    }

    /**
     * Appels API (méthodes restantes identiques à votre code actuel)
     */
    private function callSentimentAPI($text)
    {
        $response = Http::timeout(30)
            ->retry(2, 100)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken
            ])->post("{$this->apiUrl}/cardiffnlp/twitter-roberta-base-sentiment-latest", [
                'inputs' => $text
            ]);

        if ($response->failed()) {
            throw new \Exception('API Sentiment échouée: ' . $response->status());
        }

        $result = $response->json();
        
        if (!isset($result[0])) {
            throw new \Exception('Format de réponse API Sentiment invalide');
        }

        return $this->interpretSentiment($result[0]);
    }

    private function callSummaryAPI($text)
    {
        $response = Http::timeout(60)
            ->retry(2, 100)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken
            ])->post("{$this->apiUrl}/facebook/bart-large-cnn", [
                'inputs' => $text,
                'parameters' => [
                    'max_length' => 80,
                    'min_length' => 30,
                    'do_sample' => false
                ]
            ]);

        if ($response->failed()) {
            throw new \Exception('API Résumé échouée: ' . $response->status());
        }

        $result = $response->json();
        
        if (!isset($result[0]['summary_text'])) {
            throw new \Exception('Format de réponse API Résumé invalide');
        }

        return $result[0]['summary_text'];
    }

    private function interpretSentiment($scores)
    {
        $sentimentMap = [
            'LABEL_0' => 'negatif',
            'LABEL_1' => 'neutre',
            'LABEL_2' => 'positif'
        ];

        $maxScore = 0;
        $dominant = 'neutre';

        foreach ($scores as $item) {
            if ($item['score'] > $maxScore) {
                $maxScore = $item['score'];
                $dominant = $sentimentMap[$item['label']] ?? 'neutre';
            }
        }

        return $dominant;
    }
}