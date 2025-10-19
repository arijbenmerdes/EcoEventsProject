<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event; // ⚠️ N'oublie pas d'importer le modèle
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EventsExport;
use App\Http\Requests\StoreEventRequest;
use Illuminate\Support\Facades\DB; 
class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $events = Event::all();
        return view('dashboard.pages.events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       
 return view('dashboard.pages.events.create');

       
        
        

    }
   public function search(Request $request)
{
    $query = $request->input('query', '');

    // Si le champ de recherche est vide, récupérer tous les événements
    if (empty($query)) {
        $events = Event::all();
    } else {
        // Recherche dynamique par titre (commence par)
        $events = Event::where('title', 'like', $query . '%')->get();
    }

    // Retourner la vue partielle (render() pour AJAX)
    return view('dashboard.pages.events.partials.events_cards', compact('events'))->render();
}

    /**
     * Store a newly created resource in storage.
     */
  public function store(StoreEventRequest $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'participants_count' => 'nullable|integer|min:0',
        'location' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
    $data['image'] = $request->file('image')->store('events', 'public');
}


    Event::create($data);

    return redirect()->route('events.index')->with('success', 'Événement créé avec succès.');
}
public function stats()
{
    // Statistiques : nombre d’événements et total des participants par mois
    $stats = DB::table('events')
        ->selectRaw('MONTH(start_date) as month, COUNT(*) as event_count, SUM(participants_count) as total_participants')
        ->groupBy('month')
        ->orderBy('month')
        ->get();

    // Pour afficher les mois en clair (Janvier, Février, etc.)
    $months = [
        1 => 'Janvier', 2 => 'Février', 3 => 'Mars', 4 => 'Avril',
        5 => 'Mai', 6 => 'Juin', 7 => 'Juillet', 8 => 'Août',
        9 => 'Septembre', 10 => 'Octobre', 11 => 'Novembre', 12 => 'Décembre'
    ];

    return view('dashboard.pages.events.stats', compact('stats', 'months'));
}

public function storeComment(Request $request, Event $event)
{
    $request->validate([
        'user_name' => 'required|string|max:255',
        'comment' => 'required|string',
        'rating' => 'nullable|integer|min:1|max:5',
    ]);

    $event->comments()->create($request->all());

    return redirect()->route('events.show', $event->id)->with('success', 'Commentaire ajouté !');
}
public function exportPdf()
{
    $events = Event::all();
    $pdf = Pdf::loadView('dashboard.pages.events.exports.pdf', compact('events'));
    return $pdf->download('events.pdf');
}
public function exportExcel()
{
    return Excel::download(new EventsExport, 'events.xlsx');
}
    /**
     * Display the specified resource.
     */
    public function show(Event $event)
    {
        return view('dashboard.pages.events.show', compact('event'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Event $event)
    {
        return view('dashboard.pages.events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     */
public function update(StoreEventRequest $request, Event $event)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'start_date' => 'required|date',
        'end_date' => 'nullable|date|after_or_equal:start_date',
        'participants_count' => 'nullable|integer|min:0',
        'location' => 'nullable|string',
        'image' => 'nullable|image|max:2048',
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('events', 'public');
    }

    $event->update($data);

    return redirect()->route('events.index')->with('success', 'Événement mis à jour avec succès.');
}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Event $event)
    {
        $event->delete();
        return redirect()->route('events.index')->with('success', 'Événement supprimé avec succès.');
    }
    public function getEvents()
    {
        $events = Event::select('id', 'title as title', 'start_date as start', 'end_date as end')
            ->get();

        return response()->json($events);
    }
}
