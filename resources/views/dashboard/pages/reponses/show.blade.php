@extends('dashboard.index')
@section('title', 'Détails Réponse')

@section('content')
<h2>Détails Réponse</h2>
<p><strong>Réclamation :</strong> {{ $reponse->reclamation->titre }}</p>
<p><strong>Contenu :</strong> {{ $reponse->contenu }}</p>
<a href="{{ route('reponses.index') }}" class="btn btn-secondary">Retour</a>
@endsection
