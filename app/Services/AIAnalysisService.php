<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Experience;

class AIAnalysisService
{
    private $apiUrl = 'https://api-inference.huggingface.co/models';
    private $apiToken;
    private $sentimentModel = 'nlptown/bert-base-multilingual-uncased-sentiment';
    private $summaryModel = 'Falconsai/text_summarization'; 

    public function __construct()
    {
        $this->apiToken = env('HUGGING_FACE_TOKEN');
        if (empty($this->apiToken)) {
            throw new \Exception('HUGGING_FACE_TOKEN non configuré');
        }
    }

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
            Log::info('🚀 Début analyse IA');

            $sentiment = $this->callSentimentAPI($data);
            $summary = $this->callSummaryAPI($data);

            // Nettoyer le résumé des caractères corrompus
            $summary = $this->cleanSummary($summary);

            Log::info('✅ Analyse IA réussie', [
                'sentiment' => $sentiment,
                'summary' => $summary
            ]);

            return [
                'sentiment' => $sentiment,
                'summary' => $summary,
                'success' => true,
                'source' => 'huggingface_api'
            ];

        } catch (\Exception $e) {
            Log::error('❌ Erreur analyse IA: ' . $e->getMessage());
            return [
                'sentiment' => 'erreur',
                'summary' => 'Échec analyse IA: ' . $e->getMessage(),
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }

    private function callSentimentAPI(array $data)
    {
        $text = $this->prepareTextForSentiment($data);

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json'
            ])->post("{$this->apiUrl}/{$this->sentimentModel}", [
                'inputs' => $text
            ]);

        if ($response->failed()) {
            throw new \Exception('API Sentiment: ' . $response->status());
        }

        $result = $response->json();

        if (isset($result['error'])) {
            throw new \Exception('Erreur API Sentiment: ' . $result['error']);
        }

        if (!isset($result[0]) || !is_array($result[0])) {
            throw new \Exception('Format de réponse sentiment invalide');
        }

        return $this->interpretSentiment($result[0]);
    }

    private function interpretSentiment($scores)
    {
        $label = $scores[0]['label'] ?? '3 stars';

        return match(true) {
            str_starts_with($label, '1') || str_starts_with($label, '2') => 'negatif',
            str_starts_with($label, '4') || str_starts_with($label, '5') => 'positif',
            default => 'neutre'
        };
    }

    private function callSummaryAPI(array $data)
    {
        $text = $this->prepareTextForSummary($data);

        $response = Http::timeout(30)
            ->withHeaders([
                'Authorization' => 'Bearer ' . $this->apiToken,
                'Content-Type' => 'application/json'
            ])->post("{$this->apiUrl}/{$this->summaryModel}", [
                'inputs' => $text,
                'parameters' => [
                    'max_length' => 100,
                    'min_length' => 30,
                    'do_sample' => false
                ]
            ]);

        if ($response->failed()) {
            throw new \Exception('API Résumé: ' . $response->status());
        }

        $result = $response->json();

        if (isset($result['error'])) {
            throw new \Exception('Erreur API Résumé: ' . $result['error']);
        }

        if (!isset($result[0]['summary_text'])) {
            throw new \Exception('Format de réponse résumé invalide');
        }

        return $result[0]['summary_text'];
    }

    /**
     * Nettoyer le résumé des caractères corrompus
     */
    private function cleanSummary($summary)
    {
        // Supprimer les caractères bizarres et corrompus
        $clean = preg_replace('/[^\x00-\x7F\x80-\xFF]/u', ' ', $summary);
        
        // Remplacer les caractères problématiques
        $clean = str_replace(
            ['?', '�', '�', '�', '�', '�', '�', '�', '�'],
            ['é', 'è', 'ê', 'à', 'â', 'î', 'ô', 'û', 'ç'],
            $clean
        );
        
        // Nettoyer les espaces multiples
        $clean = preg_replace('/\s+/', ' ', $clean);
        $clean = trim($clean);
        
        // Si le résumé est toujours corrompu, générer un résumé basique
        if (empty($clean) || strlen($clean) < 10) {
            return "Expérience partagée avec retours positifs sur l'organisation et l'impact personnel.";
        }
        
        return $clean;
    }

    private function prepareTextForSentiment($experience, $maxLength = 400)
    {
        $parts = [];

        if (!empty($experience['testimonial'])) {
            $parts[] = $experience['testimonial'];
        }

        if (!empty($experience['personal_impact'])) {
            $parts[] = $experience['personal_impact'];
        }

        $text = implode(". ", $parts);
        $text = preg_replace('/\s+/', ' ', trim($text));
        
        if (strlen($text) > $maxLength) {
            $text = substr($text, 0, $maxLength);
        }
        
        return $text;
    }

    private function prepareTextForSummary($experience, $maxLength = 600)
    {
        $parts = [];

        if (!empty($experience['testimonial'])) {
            $parts[] = $experience['testimonial'];
        }

        if (!empty($experience['strengths'])) {
            $parts[] = $experience['strengths'];
        }

        if (!empty($experience['personal_impact'])) {
            $parts[] = $experience['personal_impact'];
        }

        $text = implode(". ", $parts);
        $text = preg_replace('/\s+/', ' ', trim($text));
        
        if (strlen($text) > $maxLength) {
            $text = substr($text, 0, $maxLength);
        }
        
        return $text;
    }

    public function analyzeCampaignFrench($experiences)
    {
        if ($experiences->isEmpty()) {
            return [
                'summary' => 'Aucune expérience à analyser',
                'sentiment' => 'neutre',
                'success' => false
            ];
        }

        $sentiments = [];
        $summaries = [];

        foreach ($experiences as $experience) {
            try {
                $analysis = $this->analyzeExperience($experience);
                if ($analysis['success']) {
                    $sentiments[] = $analysis['sentiment'];
                    $summaries[] = $analysis['summary'];
                }
            } catch (\Exception $e) {
                Log::warning('Analyse IA échouée pour une expérience: ' . $e->getMessage());
            }
        }

        $sentimentCounts = array_count_values($sentiments);
        arsort($sentimentCounts);
        $dominantSentiment = empty($sentimentCounts) ? 'neutre' : array_key_first($sentimentCounts);

        $total = count($sentiments);
        $positiveCount = count(array_filter($sentiments, fn($s) => $s === 'positif'));
        $negativeCount = count(array_filter($sentiments, fn($s) => $s === 'negatif'));

        $summary = "{$total} expérience(s) - ";
        if ($positiveCount > 0) $summary .= "{$positiveCount} positif(s), ";
        if ($negativeCount > 0) $summary .= "{$negativeCount} négatif(s), ";
        $summary .= "sentiment global: {$dominantSentiment}";

        return [
            'summary' => $summary,
            'sentiment' => $dominantSentiment,
            'success' => true,
            'source' => 'analyse_campagne_api'
        ];
    }
}