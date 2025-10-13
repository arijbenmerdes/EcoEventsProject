@extends('landing.index')

@section('title', 'Partager mon expérience - ' . $campagne->title . ' - EcoEvents')


@section('styles')
<link href="{{ asset('landing/css/campaigns-front.css') }}" rel="stylesheet">
<link href="{{ asset('landing/css/partager-experience.css') }}" rel="stylesheet">
@endsection
@section('content')
<!-- Hero Section Identique aux autres pages -->
<div class="container-fluid position-relative p-0">
    @include('landing.partials.navbar')

    <div class="share-hero position-relative overflow-hidden">
        <div class="share-hero-background"></div>
        <div class="container position-relative py-5" style="z-index: 2;">
            <div class="row justify-content-center text-center py-5">
                <div class="col-lg-8">
                    <div class="share-hero-content">
                        <h1 class="display-3 fw-bold text-white mb-4 animate-fade-in">
                            Partagez votre <span class="text-warning">Expérience</span>
                        </h1>
                        <p class="lead text-white mb-4 fs-5 animate-slide-up">
                            Inspirez d'autres personnes en partageant votre aventure écologique.<br>
                        </p>
                        <div class="hero-stats d-flex justify-content-center gap-5 mb-4">
                            <div class="stat-item text-center">
                                <div class="stat-number text-warning fw-bold fs-2">
                                    <i class="fas fa-users"></i>
                                </div>
                                <div class="stat-label text-white">Rejoignez la Communauté</div>
                            </div>
                            <div class="stat-item text-center">
                                <div class="stat-number text-warning fw-bold fs-2">
                                    <i class="fas fa-leaf"></i>
                                </div>
                                <div class="stat-label text-white">Inspirez le Changement</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Section Formulaire de Partage -->
<div class="share-experience-section">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="experience-form-container">
                    <!-- En-tête -->
                    <div class="experience-header">
                        <h1>📝 Partager mon expérience</h1>
                        <p class="lead mb-0">Racontez votre participation à cette campagne écologique</p>
                    </div>

                    <!-- Aperçu de la campagne -->
                    <div class="campaign-preview">
                        <h3>Campagne : {{ $campagne->title }}</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Type :</strong> {{ \App\Models\Campaign::getTypes()[$campagne->type] }}</p>
                                <p><strong>Focus :</strong> {{ \App\Models\Campaign::getEcologicalFocuses()[$campagne->ecological_focus] }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Localisation :</strong> {{ $campagne->location }}</p>
                                <p><strong>Période :</strong> {{ $campagne->start_date->format('d/m/Y') }} - {{ $campagne->end_date ? $campagne->end_date->format('d/m/Y') : 'En cours' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Indicateur de progression -->
                    <div class="progress-indicator">
                        <div class="progress-step">
                            <div class="step-number active">1</div>
                            <div class="step-label active">Évaluation</div>
                        </div>
                        <div class="progress-step">
                            <div class="step-number">2</div>
                            <div class="step-label">Témoignage</div>
                        </div>
                        <div class="progress-step">
                            <div class="step-number">3</div>
                            <div class="step-label">Photos</div>
                        </div>
                        <div class="progress-step">
                            <div class="step-number">4</div>
                            <div class="step-label">Impact</div>
                        </div>
                    </div>

                <form method="POST" action="{{ route('experience.store') }}" enctype="multipart/form-data" class="experience-form" id="experienceForm">
                            @csrf
                            <input type="hidden" name="campaign_id" value="{{ $campagne->id }}">
                            <input type="hidden" name="rating" id="ratingInput">

                            <!-- Section 1: Évaluation -->
                            <div class="form-section">
                                <h3>🎯 Comment évaluez-vous cette expérience ?</h3>
                                <div class="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <div class="rating-star" data-rating="{{ $i }}">⭐</div>
                                    @endfor
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Points forts de la campagne</label>
                                    <textarea class="form-control experience-textarea" name="strengths" placeholder="Qu'avez-vous particulièrement apprécié ? Quels aspects étaient les plus motivants ?"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Suggestions d'amélioration</label>
                                    <textarea class="form-control experience-textarea" name="improvements" placeholder="Avez-vous des suggestions pour améliorer cette campagne ?"></textarea>
                                </div>
                            </div>

                            <!-- Section 2: Témoignage -->
                            <div class="form-section">
                                <h3>📖 Partagez votre histoire</h3>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Votre expérience détaillée</label>
                                    <textarea class="form-control experience-textarea" name="testimonial" placeholder="Racontez votre expérience personnelle : comment vous vous êtes impliqué, ce que vous avez accompli, les défis rencontrés, les moments marquants..."></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Leçon apprise</label>
                                    <textarea class="form-control experience-textarea" name="lessons" placeholder="Qu'avez-vous appris grâce à cette expérience ?"></textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Recommandation</label>
                                    <textarea class="form-control experience-textarea" name="recommendation" placeholder="Recommanderiez-vous cette expérience à d'autres personnes ? Pourquoi ?"></textarea>
                                </div>
                            </div>

                            <!-- Section 3: Photo -->
                            <div class="form-section">
                                <h3>📸 Partagez une photo</h3>
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Téléversez une photo de votre expérience</label>
                                    <input type="file" name="photo" accept="image/*" class="form-control">
                                </div>
                            </div>

                            <!-- Section 4: Impact -->
                            <div class="form-section">
                                <h3>🌱 Mesurez votre impact</h3>

                                <div class="impact-metrics row">
                                    <div class="col-md-12 mb-3">
                                        <label>Heures consacrées</label>
                                        <input type="number" name="hours_contributed" min="0" step="0.5" class="form-control" placeholder="0">
                                    </div>

                                    <div class="col-md-12 mb-12">
                                        <label>Personnes sensibilisées</label>
                                        <input type="number" name="people_reached" min="0" class="form-control" placeholder="0">
                                    </div>

                                    <div class="col-md-12 mb-12">
                                        <label>Déchets collectés (kg)</label>
                                        <input type="number" name="waste_collected" min="0" step="0.1" class="form-control" placeholder="0">
                                    </div>

                                    <div class="col-md-12 mb-12">
                                        <label>Arbres plantés</label>
                                        <input type="number" name="trees_planted" min="0" class="form-control" placeholder="0">
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Impact personnel</label>
                                    <textarea class="form-control experience-textarea" name="personal_impact" placeholder="Comment cette expérience a-t-elle changé votre vision ou vos habitudes ?"></textarea>
                                </div>
                            </div>

                            <!-- Boutons -->
                            <div class="row mt-5">
                                <div class="col-md-6">
                                    <a href="{{ route('campagnes.front') }}" class="btn btn-outline-secondary w-100">
                                        <i class="fas fa-arrow-left me-2"></i> Retour aux campagnes
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn btn-success w-100">
                                        <i class="fas fa-paper-plane me-2"></i> Publier mon expérience
                                    </button>
                                </div>
                            </div>
                        </form>

                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Système d'évaluation par étoiles
    const stars = document.querySelectorAll('.rating-star');
    const ratingInput = document.getElementById('ratingInput');

    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.getAttribute('data-rating');
            ratingInput.value = rating;

            stars.forEach(s => {
                s.classList.toggle('active', s.getAttribute('data-rating') <= rating);
            });
        });
    });
});
</script>

@endsection
