<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Target;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function index()
    {
         $campaigns = Campaign::with(['targets'])->withCount('targets')->get();

    $types = Campaign::getTypes();
    $ecologicalFocuses = Campaign::getEcologicalFocuses();
    $statuses = Campaign::getStatuses();
    $targets = \App\Models\Target::all();

    return view('dashboard.pages.campaigns.index', compact(
        'campaigns',
        'types',
        'ecologicalFocuses',
        'statuses',
        'targets'
    ));
    }

    public function create()
    {
        $targets = Target::actif()->get();

        return view('dashboard.pages.campaigns.create', [
            'targets' => $targets,
            'types' => Campaign::getTypes(),
            'ecologicalFocuses' => Campaign::getEcologicalFocuses(),
            'statuses' => Campaign::getStatuses()
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objective' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'type' => 'required|in:' . implode(',', array_keys(Campaign::getTypes())),
            'ecological_focus' => 'required|in:' . implode(',', array_keys(Campaign::getEcologicalFocuses())),
            'location' => 'required|string|max:255',
            'targets' => 'required|array|min:1',
            'targets.*' => 'exists:targets,id',
            'image_url' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $targets = $data['targets'];
        unset($data['targets']); // Retirer les targets du data principal

        $data['created_by'] = Auth::id();
        $data['status'] = Campaign::STATUS_DRAFT;

        $campaign = Campaign::create($data);

        // Attacher les cibles sélectionnées
        $campaign->targets()->attach($targets);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campagne créée avec succès.');
    }

    public function show(string $id)
    {
        $campaign = Campaign::with(['targets', 'creator'])->findOrFail($id);
        return view('dashboard.pages.campaigns.show', compact('campaign'));
    }

    public function edit(string $id)
    {
       $campaigns = Campaign::withCount('targets')->latest()->paginate(10);

        // Ajoutez ces variables
        $types = Campaign::getTypes();
        $ecologicalFocuses = Campaign::getEcologicalFocuses();
        $statuses = Campaign::getStatuses();
        $targets = Target::all();

        return view('dashboard.pages.campaigns.index', compact(
            'campaigns',
            'types',
            'ecologicalFocuses',
            'statuses',
            'targets'
        ));
    }

    public function update(Request $request, string $id)
    {
        $campaign = Campaign::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'objective' => 'required|string|max:500',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'budget' => 'nullable|numeric|min:0',
            'status' => 'required|in:' . implode(',', array_keys(Campaign::getStatuses())),
            'type' => 'required|in:' . implode(',', array_keys(Campaign::getTypes())),
            'ecological_focus' => 'required|in:' . implode(',', array_keys(Campaign::getEcologicalFocuses())),
            'location' => 'required|string|max:255',
            'targets' => 'required|array|min:1',
            'targets.*' => 'exists:targets,id',
            'image_url' => 'nullable|url'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $data = $validator->validated();
        $targets = $data['targets'];
        unset($data['targets']);

        $campaign->update($data);

        // Synchroniser les cibles
        $campaign->targets()->sync($targets);

        return redirect()->route('campaigns.index')
            ->with('success', 'Campagne modifiée avec succès.');
    }

    public function destroy(string $id)
    {
        $campaign = Campaign::findOrFail($id);
        $targetsCount = $campaign->targets()->count();

        $campaign->delete();

        $message = 'Campagne supprimée avec succès.';
        if ($targetsCount > 0) {
            $message .= " Les associations avec $targetsCount cible(s) ont été supprimées.";
        }

        return redirect()->route('campaigns.index')
            ->with('success', $message);
    }
}
