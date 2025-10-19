<?php

namespace App\Http\Controllers;

use App\Models\Reclamation;
use Illuminate\Http\Request;

class ReclamationController extends Controller
{
    public function index()
    {
        $reclamations = Reclamation::all();
        return view('landing.pages.reclamations.index', compact('reclamations'));
    }

    public function create()
    {
        return view('landing.pages.reclamations.create');
    }

    public function store(Request $request)
{
    $validated = $request->validate([
        'titre' => 'required|string|max:255',
        'description' => 'required|string',
        'statut' => 'nullable|in:en_attente,en_cours,resolue',
    ]);

    $validated['statut'] = $validated['statut'] ?? 'en_attente';

    $reclamation = Reclamation::create($validated);

    return redirect()->route('reclamations.index')
                     ->with('success', 'Réclamation créée avec succès.');
}


    public function show(Reclamation $reclamation)
    {
        return view('landing.pages.reclamations.show', compact('reclamation'));
    }

    public function edit(Reclamation $reclamation)
    {
        return view('landing.pages.reclamations.edit', compact('reclamation'));
    }

    public function update(Request $request, Reclamation $reclamation)
    {
        $validated = $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'required|string',
            'statut' => 'required|in:en_attente,en_cours,resolue',
        ]);

        $reclamation->update($validated);

        return redirect()->route('reclamations.index')
                         ->with('success', 'Réclamation mise à jour avec succès.');
    }

    public function destroy(Reclamation $reclamation)
    {
        $reclamation->delete();
        return redirect()->route('reclamations.index')
                         ->with('success', 'Réclamation supprimée avec succès.');
    }
}
