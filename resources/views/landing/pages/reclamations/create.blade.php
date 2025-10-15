@extends('landing.index')
@section('title', 'Créer une réclamation')
@section('styles')
<link href="{{ asset('landing/css/campaigns-front.css') }}" rel="stylesheet">
@endsection
@section('content')

<div class="container-fluid position-relative p-0">
    @include('landing.partials.navbar')

    <div class="ecological-hero position-relative overflow-hidden">
        <div class="hero-background"></div>
        <div class="container position-relative py-5" style="z-index: 2;">
            <div class="row justify-content-center text-center py-5">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="display-3 fw-bold text-white mb-4 animate-fade-in">
                            Nos <span class="text-warning">Reclamations</span> 
                        </h1>
                        <p class="lead text-white mb-4 fs-5 animate-slide-up">
                            Rejoignez le mouvement pour un avenir durable. Découvrez nos initiatives
                            et participez à la transformation écologique.
                        </p>
                        <div class="hero-stats d-flex justify-content-center gap-5 mb-4">
                            <div class="stat-item text-center">
                                
                                <div class="stat-label text-white">Campagnes Actives</div>
                            </div>
                            <div class="stat-item text-center">
                               
                               
                                <div class="stat-label text-white">Communautés Touchées</div>
                            </div>
                        </div>
                        <a href="#campagnes-grid" class="btn btn-warning btn-lg rounded-pill px-5 py-3 fw-bold animate-bounce">
                            <i class="fas fa-seedling me-2"></i>Explorer les Actions
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
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
