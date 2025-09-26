<?php

namespace App\Http\Controllers;

use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TargetController extends Controller
{
    public function index()
    {
        $targets = Target::withCount('campaigns')
                    ->latest()
                    ->paginate(15);

    $types = Target::getTypes();
    $secteurs = Target::getSecteurs();

    return view('dashboard.pages.targets.index', compact('targets', 'types', 'secteurs'));
    }

    public function create()
    {
        return view('dashboard.pages.targets.create', [
            'types' => Target::getTypes(),
            'secteurs' => Target::getSecteurs()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255|unique:targets,nom',
            'description' => 'nullable|string',
            'type' => 'required|in:' . implode(',', array_keys(Target::getTypes())),
            'age_min' => 'nullable|integer|min:0',
            'age_max' => 'nullable|integer|min:0|gte:age_min',
            'profession' => 'nullable|string|max:255',
            'secteur' => 'nullable|in:' . implode(',', array_keys(Target::getSecteurs())),
            'est_actif' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        Target::create($validator->validated());

        return redirect()->route('targets.index')
            ->with('success', 'Cible créée avec succès.');
    }

    public function edit(string $id)
    {
        $target = Target::findOrFail($id);

        return view('dashboard.pages.targets.edit', [
            'target' => $target,
            'types' => Target::getTypes(),
            'secteurs' => Target::getSecteurs()
        ]);
    }

    public function update(Request $request, string $id)
    {
        $target = Target::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:255|unique:targets,nom,' . $target->id,
            'description' => 'nullable|string',
            'type' => 'required|in:' . implode(',', array_keys(Target::getTypes())),
            'age_min' => 'nullable|integer|min:0',
            'age_max' => 'nullable|integer|min:0|gte:age_min',
            'profession' => 'nullable|string|max:255',
            'secteur' => 'nullable|in:' . implode(',', array_keys(Target::getSecteurs())),
            'est_actif' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $target->update($validator->validated());

        return redirect()->route('targets.index')
            ->with('success', 'Cible modifiée avec succès.');
    }

    public function destroy(string $id)
    {
        $target = Target::findOrFail($id);
        $campaignsCount = $target->campaigns()->count();

        if ($campaignsCount > 0) {
            return redirect()->route('targets.index')
                ->with('error', 'Impossible de supprimer cette cible car elle est associée à ' . $campaignsCount . ' campagne(s).');
        }

        $target->delete();

        return redirect()->route('targets.index')
            ->with('success', 'Cible supprimée avec succès.');
    }

    public function toggleActivation(string $id)
    {
        $target = Target::findOrFail($id);
        $target->update(['est_actif' => !$target->est_actif]);

        $status = $target->est_actif ? 'activée' : 'désactivée';
        return redirect()->route('targets.index')
            ->with('success', "Cible $status avec succès.");
    }
}
