@extends('dashboard.index')
@section('title', 'Détails Réclamation')

@section('content')
<h2>Détails Réclamation</h2>
<p><strong>Titre :</strong> {{ $reclamation->titre }}</p>
<p><strong>Description :</strong> {{ $reclamation->description }}</p>
<p><strong>Statut :</strong> {{ $reclamation->statut }}</p>
<a href="{{ route('reclamations.index') }}" class="btn btn-secondary">Retour</a>
@endsection
