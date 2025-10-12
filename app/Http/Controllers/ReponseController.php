<?php

namespace App\Http\Controllers;

use App\Models\Reponse;
use App\Models\Reclamation;
use Illuminate\Http\Request;

class ReponseController extends Controller
{
    public function index()
    {
        $reponses = Reponse::with('reclamation')->get();
        return view('dashboard.pages.reponses.index', compact('reponses'));
    }

    public function create()
    {
        $reclamations = Reclamation::all();
        return view('dashboard.pages.reponses.create', compact('reclamations'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contenu' => 'required|string',
            'reclamation_id' => 'required|exists:reclamations,id'
        ]);

        Reponse::create($request->all());

        return redirect()->route('reponses.index')->with('success', 'Réponse ajoutée avec succès.');
    }

    public function show(Reponse $reponse)
    {
        return view('dashboard.pages.reponses.show', compact('reponse'));
    }

    public function edit(Reponse $reponse)
    {
        $reclamations = Reclamation::all();
        return view('dashboard.pages.reponses.edit', compact('reponse', 'reclamations'));
    }

    public function update(Request $request, Reponse $reponse)
    {
        $request->validate([
            'contenu' => 'required|string',
        ]);

        $reponse->update($request->all());

        return redirect()->route('reponses.index')->with('success', 'Réponse mise à jour avec succès.');
    }

    public function destroy(Reponse $reponse)
    {
        $reponse->delete();
        return redirect()->route('reponses.index')->with('success', 'Réponse supprimée avec succès.');
    }
}
