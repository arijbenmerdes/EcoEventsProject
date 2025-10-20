@extends('dashboard.index')
@section('content')
<div class="container">
    <h1>Détails de l'événement</h1>

    <div class="card">
        @if($event->image)
            <img src="{{ asset('storage/' . $event->image) }}" class="card-img-top" alt="{{ $event->title }}">
        @endif
        <div class="card-body">
            <h4 class="card-title">{{ $event->title }}</h4>
            <p><strong>Description :</strong> {{ $event->description ?? 'Aucune' }}</p>
            <p><strong>Participants :</strong> {{ $event->participants_count ?? 0 }}</p>
            <p><strong>Date de début :</strong> {{ optional($event->start_date)->format('d/m/Y H:i') }}</p>
            <p><strong>Date de fin :</strong> {{ optional($event->end_date)->format('d/m/Y H:i') ?? 'Non précisée' }}</p>
            <p><strong>Lieu :</strong> {{ $event->location ?? 'Non précisé' }}</p>
        </div>
    </div>

    <div class="mt-3">
        <a href="{{ route('events.edit', $event->id) }}" class="btn btn-warning">Modifier</a>
        <form action="{{ route('events.destroy', $event->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button class="btn btn-danger" onclick="return confirm('Supprimer cet événement ?')">Supprimer</button>
        </form>
        <a href="{{ route('events.index') }}" class="btn btn-secondary">Retour</a>
    </div>
    <h3>Commentaires</h3>

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<form action="{{ route('events.comment', $event->id) }}" method="POST">
    @csrf
    <div class="mb-2">
        <input type="text" name="user_name" class="form-control" placeholder="Votre nom" required>
    </div>
    <div class="mb-2">
        <textarea name="comment" class="form-control" placeholder="Votre commentaire" required></textarea>
    </div>
    <div class="mb-2">
        <select name="rating" class="form-control">
            <option value="">Note (optionnelle)</option>
            @for($i=1; $i<=5; $i++)
                <option value="{{ $i }}">{{ $i }} étoiles</option>
            @endfor
        </select>
    </div>
    <button type="submit" class="btn btn-primary">Envoyer</button>
</form>

<hr>

@foreach($event->comments as $comment)
    <div class="card mb-2">
        <div class="card-body">
            <strong>{{ $comment->user_name }}</strong> 
            @if($comment->rating) - {{ $comment->rating }} ⭐ @endif
            <p>{{ $comment->comment }}</p>
            <small>{{ $comment->created_at->format('d/m/Y H:i') }}</small>
        </div>
    </div>
@endforeach


</div>
@endsection
