@extends('dashboard.index')
@section('title', 'Créer une réponse')

@section('content')
<h2>Nouvelle Réponse</h2>
<form action="{{ route('reponses.store') }}" method="POST">
    @csrf
    <div class="mb-3">
        <label>Réclamation</label>
        <select name="reclamation_id" class="form-control" required>
            @foreach($reclamations as $rec)
                <option value="{{ $rec->id }}">{{ $rec->titre }}</option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Contenu</label>
        <textarea name="contenu" class="form-control" required></textarea>
    </div>
    
    <button type="submit" class="btn btn-success">Enregistrer</button>
</form>
@endsection
