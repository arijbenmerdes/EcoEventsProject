<?php
namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
    /**
     * Afficher toutes les expériences partagées
     */
    public function index(Request $request)
    {
           $query = Experience::with(['user', 'campaign']);


        // Filtrage par campagne
        if ($request->has('campaign') && $request->campaign) {
            $query->where('campaign_id', $request->campaign);
        }

        // Filtrage par note
        if ($request->has('rating') && $request->rating) {
            $query->where('rating', $request->rating);
        }

        $experiences = $query->orderBy('created_at', 'desc')
                           ->paginate(12);

    $campaigns = Campaign::all();

        return view('landing.pages.experiences', compact('experiences', 'campaigns'));
    }
public function campaignExperiences($id)
{
    $campaign = Campaign::with('targets')->findOrFail($id);

    $experiences = Experience::with(['user', 'campaign'])
        ->where('campaign_id', $id)
        ->orderBy('created_at', 'desc')
        ->paginate(12);

    return view('landing.pages.campaign-experiences', compact('experiences', 'campaign'));
}
    public function store(Request $request)
    {
        // Debug: Vérifiez l'utilisateur
    $user = \App\Models\User::find(1);
    if (!$user) {
        // Créer un utilisateur temporaire
        $user = \App\Models\User::create([
            'name' => 'Utilisateur Test',
            'email' => 'test@ecoevents.com',
            'password' => bcrypt('password123')
        ]);
    }
        $validated = $request->validate([
            'campaign_id' => 'required|exists:campaigns,id',
            'rating' => 'nullable|integer|min:1|max:5',
            'strengths' => 'nullable|string',
            'improvements' => 'nullable|string',
            'testimonial' => 'nullable|string',
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
            $path = $request->file('photo')->store('experiences/photos', 'public');
            $validated['image_url'] = asset('storage/' . $path);
        }

        Experience::create($validated);

        return redirect()->route('campagnes.front')->with('success', 'Votre expérience a été enregistrée avec succès !');
    }
}
