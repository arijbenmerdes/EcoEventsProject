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







</div>
@endsection
