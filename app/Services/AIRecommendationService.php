<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class AIRecommendationService
{
    public function getRecommendations($userId)
    {
        $response = Http::post('http://127.0.0.1:5000/recommend', [
            'user_id' => $userId
        ]);

        return $response->json();
    }
}
