@extends('dashboard.index')
@section('title', 'Modifier une réclamation')

@section('content')
<h2>Modifier Réclamation</h2>
<form action="{{ route('reclamations.update', $reclamation->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Titre</label>
        <input type="text" name="titre" value="{{ $reclamation->titre }}" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required>{{ $reclamation->description }}</textarea>
    </div>
    <div class="mb-3">
        <label>Statut</label>
        <select name="statut" class="form-control">
            <option value="en_attente" {{ $reclamation->statut == 'en_attente' ? 'selected' : '' }}>En attente</option>
            <option value="en_cours" {{ $reclamation->statut == 'en_cours' ? 'selected' : '' }}>En cours</option>
            <option value="resolue" {{ $reclamation->statut == 'resolue' ? 'selected' : '' }}>Résolue</option>
        </select>
    </div>
    <button type="submit" class="btn btn-success">Mettre à jour</button>
</form>
@endsection
