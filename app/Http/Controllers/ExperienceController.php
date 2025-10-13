<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Experience;
use Illuminate\Support\Facades\Auth;

class ExperienceController extends Controller
{
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
