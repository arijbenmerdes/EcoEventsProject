@extends('dashboard.index')

@section('content')
<div class="container">
    <h1>Détails de l'événement</h1>

    <div class="card">
        <div class="card-header">
            {{ $event->title }}
        </div>
        <div class="card-body">
            <p><strong>Description :</strong> {{ $event->description ?? 'Aucune' }}</p>
            <p><strong>Date de début :</strong> {{ $event->start_date }}</p>
            <p><strong>Date de fin :</strong> {{ $event->end_date ?? 'Non précisé' }}</p>
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
</div>
@endsection
