@extends('dashboard.index')
@section('title', 'Modifier une réponse')

@section('content')
<h2>Modifier Réponse</h2>
<form action="{{ route('reponses.update', $reponse->id) }}" method="POST">
    @csrf @method('PUT')
    <div class="mb-3">
        <label>Réclamation</label>
        <select name="reclamation_id" class="form-control">
            @foreach($reclamations as $rec)
                <option value="{{ $rec->id }}" {{ $reponse->reclamation_id == $rec->id ? 'selected' : '' }}>
                    {{ $rec->titre }}
                </option>
            @endforeach
        </select>
    </div>
    <div class="mb-3">
        <label>Contenu</label>
        <textarea name="contenu" class="form-control">{{ $reponse->contenu }}</textarea>
    </div>
    <button type="submit" class="btn btn-success">Mettre à jour</button>
</form>
@endsection
