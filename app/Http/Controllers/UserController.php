<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Event;
use App\Models\EventComment;
use App\Http\Requests\StoreCommentRequest;

class UserController extends Controller
{
    // Page principale du tableau de bord utilisateur
    public function dashboard()
    {
        $events = Event::all();
        return view('user.dashboard', compact('events'));
    }

    // Page de la liste complète des événements
    public function index()
{
    $events = \App\Models\Event::all();
    return view('user.events.index', compact('events'));
}

public function showEvent($id)
{
    $event = \App\Models\Event::findOrFail($id);
    return view('user.events.show', compact('event'));
}


    public function edit()
    {
        return view('user.edit', ['user' => Auth::user()]);
    }
 public function destroyComment(Event $event, EventComment $comment)
    {
        // Optionnel : vérifier si c'est le même utilisateur
        if($comment->user_name !== Auth::user()->name){
            return redirect()->back()->with('error', 'Vous ne pouvez pas supprimer ce commentaire.');
        }

        $comment->delete();
        return redirect()->route('user.events.show', $event->id)
                         ->with('success', 'Commentaire supprimé avec succès !');
    }

    // Formulaire pour modifier un commentaire
    public function editComment(Event $event, EventComment $comment)
    {
        // Vérifier si utilisateur
        if($comment->user_name !== Auth::user()->name){
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier ce commentaire.');
        }

        return view('user.events.edit_comment', compact('event', 'comment'));
    }

    // Mettre à jour le commentaire
    public function updateComment(Request $request, Event $event, EventComment $comment)
    {
        if($comment->user_name !== Auth::user()->name){
            return redirect()->back()->with('error', 'Vous ne pouvez pas modifier ce commentaire.');
        }

        $request->validate([
            'comment' => 'required|string',
            'rating' => 'nullable|integer|min:1|max:5',
        ]);

        $comment->update([
            'comment' => $request->comment,
            'rating' => $request->rating,
        ]);

        return redirect()->route('user.events.show', $event->id)
                         ->with('success', 'Commentaire mis à jour !');
    }
public function storeComment(StoreCommentRequest $request, Event $event)
{
    

    // Création du commentaire
    $event->comments()->create([
        'user_name' => $request->user_name,
        'comment' => $request->comment,
        'rating' => $request->rating,
    ]);

    // Redirection sur la même page avec message
    return redirect()->route('user.events.show', $event->id)
                     ->with('success', 'Commentaire ajouté avec succès !');
}



public function searchUserEvents(Request $request)
{
    $query = $request->input('query', '');
    $events = empty($query)
        ? Event::all()
        : Event::where('title', 'like', '%' . $query . '%')->get();

    return view('user.events.partials.events_cards', compact('events'));
}


    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => "required|email|max:255|unique:users,email,{$user->id}",
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('user.dashboard')->with('success', 'Profil mis à jour avec succès.');
    }
}
