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
        'image_url', // ✅ URL de la photo
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }
}
