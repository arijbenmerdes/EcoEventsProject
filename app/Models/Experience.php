<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    protected $fillable = [
        'user_id',
        'campaign_id',
        'rating',
        'strengths',
        'improvements',
        'testimonial',
        'lessons',
        'recommendation',
        'hours_contributed',
        'people_reached',
        'waste_collected',
        'trees_planted',
        'personal_impact',
        'image_url',
        'ai_summary',
        'ai_sentiment'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function getSentimentColorAttribute()
    {
        return match($this->ai_sentiment) {
            'positif' => 'success',
            'negatif' => 'danger',
            default => 'secondary'
        };
    }

    public function getSentimentIconAttribute()
    {
        return match($this->ai_sentiment) {
            'positif' => '😊',
            'negatif' => '😔',
            default => '😐'
        };
    }

public function analyzeWithAI()
{
    $aiService = new \App\Services\AIAnalysisService();
    $analysis = $aiService->analyzeExperience($this);
    
    $this->update([
        'ai_sentiment' => $analysis['sentiment'],
        'ai_summary' => $analysis['summary']
    ]);
    
    return $analysis['success'];
}
}
