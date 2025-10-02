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

                    <!-- Formulaire de partage -->
                    <form class="experience-form" id="experienceForm">
                        @csrf
                        <input type="hidden" name="campaign_id" value="{{ $campagne->id }}">

                        <!-- Section 1: Évaluation -->
                        <div class="form-section">
                            <h3>🎯 Comment évaluez-vous cette expérience ?</h3>

                            <div class="rating-stars">
                                <div class="rating-star" data-rating="1">⭐</div>
                                <div class="rating-star" data-rating="2">⭐</div>
                                <div class="rating-star" data-rating="3">⭐</div>
                                <div class="rating-star" data-rating="4">⭐</div>
                                <div class="rating-star" data-rating="5">⭐</div>
                            </div>
                            <input type="hidden" name="rating" id="ratingInput">

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

                        <!-- Section 3: Photos -->
                        <div class="form-section">
                            <h3>📸 Partagez vos photos</h3>

                            <div class="photo-upload-area" id="photoUploadArea">
                                <i class="fas fa-cloud-upload-alt"></i>
                                <h4>Glissez-déposez vos photos ici</h4>
                                <p class="text-muted">ou cliquez pour sélectionner des fichiers</p>
                                <input type="file" id="photoInput" multiple accept="image/*" style="display: none;">
                            </div>

                            <div class="uploaded-photos" id="uploadedPhotos">
                                <!-- Les photos uploadées apparaîtront ici -->
                            </div>
                        </div>

                        <!-- Section 4: Impact -->
                        <div class="form-section">
                            <h3>🌱 Mesurez votre impact</h3>

                            <div class="impact-metrics">
                                <div class="metric-input">
                                    <label>Heures consacrées</label>
                                    <input type="number" name="hours_contributed" min="0" step="0.5" placeholder="0">
                                </div>

                                <div class="metric-input">
                                    <label>Personnes sensibilisées</label>
                                    <input type="number" name="people_reached" min="0" placeholder="0">
                                </div>

                                <div class="metric-input">
                                    <label>Déchets collectés (kg)</label>
                                    <input type="number" name="waste_collected" min="0" step="0.1" placeholder="0">
                                </div>

                                <div class="metric-input">
                                    <label>Arbres plantés</label>
                                    <input type="number" name="trees_planted" min="0" placeholder="0">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Impact personnel</label>
                                <textarea class="form-control experience-textarea" name="personal_impact" placeholder="Comment cette expérience a-t-elle changé votre vision ou vos habitudes ?"></textarea>
                            </div>
                        </div>

                        <!-- Boutons d'action -->
                        <div class="row mt-5">
                            <div class="col-md-6">
                                <a href="{{ route('campagnes.front') }}" class="back-to-campaign">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Retour aux campagnes
                                </a>
                            </div>
                            <div class="col-md-6">
                                <button type="submit" class="submit-experience-btn">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Publier mon expérience
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

            // Mettre à jour l'affichage des étoiles
            stars.forEach(s => {
                if (s.getAttribute('data-rating') <= rating) {
                    s.classList.add('active');
                } else {
                    s.classList.remove('active');
                }
            });
        });
    });

    // Upload de photos
    const photoUploadArea = document.getElementById('photoUploadArea');
    const photoInput = document.getElementById('photoInput');
    const uploadedPhotos = document.getElementById('uploadedPhotos');

    photoUploadArea.addEventListener('click', () => photoInput.click());

    photoUploadArea.addEventListener('dragover', (e) => {
        e.preventDefault();
        photoUploadArea.style.borderColor = '#2ecc71';
        photoUploadArea.style.background = 'rgba(46, 204, 113, 0.1)';
    });

    photoUploadArea.addEventListener('dragleave', () => {
        photoUploadArea.style.borderColor = '#bdc3c7';
        photoUploadArea.style.background = 'transparent';
    });

    photoUploadArea.addEventListener('drop', (e) => {
        e.preventDefault();
        handleFiles(e.dataTransfer.files);
    });

    photoInput.addEventListener('change', (e) => {
        handleFiles(e.target.files);
    });

    function handleFiles(files) {
        Array.from(files).forEach(file => {
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const photoPreview = document.createElement('div');
                    photoPreview.className = 'photo-preview';
                    photoPreview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="remove-photo" onclick="this.parentElement.remove()">
                            <i class="fas fa-times"></i>
                        </button>
                    `;
                    uploadedPhotos.appendChild(photoPreview);
                };
                reader.readAsDataURL(file);
            }
        });
    }

    // Validation du formulaire
    document.getElementById('experienceForm').addEventListener('submit', function(e) {
        e.preventDefault();

        // Ici vous ajouteriez l'envoi AJAX vers votre backend
        alert('Votre expérience a été partagée avec succès !');
        window.location.href = "{{ route('campagnes.front') }}";
    });
});
</script>
@endsection
