<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\AIRecommendationService;

class EventRecommendationController extends Controller
{
    protected $aiService;

    public function __construct(AIRecommendationService $aiService)
    {
        $this->aiService = $aiService;
    }

    public function recommend($userId)
    {
        $events = $this->aiService->getRecommendations($userId);
return view('events.recommendations', compact('events'));    }
}
