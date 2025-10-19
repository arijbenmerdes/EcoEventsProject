@extends('dashboard.index')
@section('title', 'Créer une réclamation')

@section('content')
<h2>Nouvelle Réclamation</h2>
<form action="{{ route('reclamations.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Titre</label>
        <input type="text" name="titre" class="form-control" required>
    </div>
    <div class="mb-3">
        <label>Description</label>
        <textarea name="description" class="form-control" required></textarea>
    </div>
    <div class="mb-3">
        <label>Statut</label>
        <select name="statut" class="form-control" required>
            <option value="en_attente" selected>En attente</option>
            <option value="en_cours">En cours</option>
            <option value="resolue">Résolue</option>
        </select>
    </div>

    <button type="submit" class="btn btn-success">Enregistrer</button>
</form>

@endsection
