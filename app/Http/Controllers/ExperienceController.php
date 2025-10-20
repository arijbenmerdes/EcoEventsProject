<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Experience;
use App\Services\AIAnalysisService;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Str; 
class ExperienceController extends Controller
{
     protected $aiService;

    public function __construct()
    {
        $this->aiService = new AIAnalysisService();
    }

    public function index(Request $request)
    {
        $query = Experience::with(['user','campaign']);

        if ($request->has('sentiment') && $request->sentiment) {
            $query->where('ai_sentiment', $request->sentiment);
        }

        if ($request->has('campaign') && $request->campaign) {
            $query->where('campaign_id', $request->campaign);
        }

        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        $experiences = $query->orderBy('created_at','desc')->paginate(12);
        $campaigns = Campaign::all();

        return view('landing.pages.experiences', compact('experiences','campaigns'));
    }

    // public function campaignExperiences($id)
    // {
    //     $campaign = Campaign::with('targets')->findOrFail($id);
    //     $experiences = Experience::with(['user','campaign'])
    //         ->where('campaign_id', $id)
    //         ->orderBy('created_at','desc')
    //         ->paginate(12);

    //     $campaignAnalysis = null;

    //     try {
    //         $allText = $experiences->map(function($exp){
    //             return $exp->only(['testimonial','strengths','personal_impact','improvements','lessons','recommendation']);
    //         })->map(function($fields){
    //             return implode('. ', array_filter($fields));
    //         })->implode(" ");

    //         if (!empty(trim($allText))) {
    //             $aiService = new HuggingFaceAnalysisService();
    //             $campaignAnalysis = [
    //                 'summary' => $aiService->generateSummaryOnly(['testimonial'=>$allText]),
    //                 'sentiment' => $aiService->analyzeSentimentOnly(['testimonial'=>$allText])
    //             ];
    //         }
    //     } catch (\Exception $e) {
    //         \Illuminate\Support\Facades\Log::error('Erreur analyse globale: '.$e->getMessage());
    //         $campaignAnalysis = [
    //             'summary' => 'Analyse temporairement indisponible',
    //             'sentiment' => 'neutre'
    //         ];
    //     }

    //     return view('landing.pages.campaign-experiences', compact('experiences','campaign','campaignAnalysis'));
    // }

  /**
     * Store experience avec analyse IA
     */
    public function store(Request $request)
    {
        // Timeout augmenté pour l'analyse française
        set_time_limit(1000);
        ini_set('max_execution_time', 1000);

     $user = Auth::user();

        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'strengths' => 'nullable|string',
            'improvements' => 'nullable|string',
            'testimonial' => 'required|string|min:20',
            'lessons' => 'nullable|string',
            'recommendation' => 'nullable|string',
            'hours_contributed' => 'nullable|numeric|min:0',
            'people_reached' => 'nullable|integer|min:0',
            'waste_collected' => 'nullable|numeric|min:0',
            'trees_planted' => 'nullable|integer|min:0',
            'personal_impact' => 'nullable|string',
            'photo' => 'nullable|image|max:2048',
        ]);

        $validated['user_id'] = $user->id;

        if ($request->hasFile('photo')) {
    $file = $request->file('photo'); // capture une seule fois
    $filename = time() . '_' . $file->getClientOriginalName(); // nom unique
    $file->move(public_path('experiences/photos'), $filename);
    $validated['image_url'] = 'experiences/photos/' . $filename;
}


       
    $experience = Experience::create($validated);

    // 🔥 UTILISER LA VERSION RAPIDE
    $analysis = $this->aiService->analyzeExperience($experience);

    $experience->update([
        'ai_sentiment' => $analysis['sentiment'],
        'ai_summary' => $analysis['summary']
    ]);

    if ($analysis['success']) {
        return redirect()->route('campagnes.front')
            ->with('success', 'Votre expérience a été enregistrée et analysée !');
    } else {
        return redirect()->route('campagnes.front')
            ->with('warning', 'Expérience enregistrée (analyse basique appliquée)');
    }
    }

    public function campaignExperiences($id)
    {
        $campaign = Campaign::with('targets')->findOrFail($id);
        $experiences = Experience::with(['user','campaign'])
            ->where('campaign_id', $id)
            ->orderBy('created_at','desc')
            ->paginate(12);

        // Analyse globale avec API française
        $campaignAnalysis = $this->aiService->analyzeCampaignFrench($experiences);

        return view('landing.pages.campaign-experiences', compact('experiences','campaign','campaignAnalysis'));
    }

    public function generateSummary($id)
    {
        $experience = Experience::findOrFail($id);
        
        // Régénérer avec API française
        $analysis = $this->aiService->analyzeExperience($experience);
        
        if ($analysis['success']) {
            $experience->update(['ai_summary' => $analysis['summary']]);
            return back()->with('success', 'Résumé régénéré avec IA française !');
        } else {
            return back()->with('error', 'Erreur IA: ' . ($analysis['error'] ?? 'Erreur inconnue'));
        }
    }
}