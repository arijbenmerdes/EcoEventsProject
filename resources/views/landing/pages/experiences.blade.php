@extends('landing.index')

@section('title', 'Expériences Partagées - EcoEvents')

@section('styles')
<link href="{{ asset('landing/css/campaigns-front.css') }}" rel="stylesheet">
<link href="{{ asset('landing/css/experiences.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Hero Section -->
<div class="container-fluid position-relative p-0">
    @include('landing.partials.navbar')

    <div class="experiences-hero position-relative overflow-hidden">
        <div class="hero-background"></div>
        <div class="container position-relative py-5" style="z-index: 2;">
            <div class="row justify-content-center text-center py-5">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="display-3 fw-bold text-white mb-4 animate-fade-in">
                            <span class="text-warning">Expériences</span> Partagées
                        </h1>
                        <p class="lead text-white mb-4 fs-5 animate-slide-up">
                            Découvrez les témoignages et retours d'expérience de notre communauté écologique.
                        </p>
                        <div class="hero-stats d-flex justify-content-center gap-5 mb-4">
                            <div class="stat-item text-center">
                                <div class="stat-number text-warning fw-bold fs-2">{{ $experiences->total() }}</div>
                                <div class="stat-label text-white">Expériences</div>
                            </div>
                            <div class="stat-item text-center">
                                <div class="stat-number text-warning fw-bold fs-2">{{ $campaigns->count() }}</div>
                                <div class="stat-label text-white">Campagnes</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="container-fluid bg-light py-4 sticky-top filter-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 class="text-primary mb-0">
                    <i class="fas fa-filter me-2"></i>
                    Filtrer les expériences
                </h5>
            </div>
            <div class="col-md-4 text-end">
                <span class="badge bg-primary fs-6">
                    {{ $experiences->total() }} résultat(s)
                </span>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid bg-white border-bottom py-4">
    <div class="container">
        <form action="{{ route('experiences.index') }}" method="GET" class="filter-form">
            <div class="row g-4">
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <label class="form-label fw-bold text-primary">🏷️ Campagne</label>
                    <select name="campaign" class="form-select form-select-lg border-primary">
                        <option value="">Toutes les campagnes</option>
                        @foreach($campaigns as $campaign)
                            <option value="{{ $campaign->id }}" {{ request('campaign') == $campaign->id ? 'selected' : '' }}>
                                {{ $campaign->title }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <label class="form-label fw-bold text-warning">⭐ Note</label>
                    <select name="rating" class="form-select form-select-lg border-warning">
                        <option value="">Toutes les notes</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>
                                {{ $i }} étoile{{ $i > 1 ? 's' : '' }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-xl-4 col-lg-12 col-md-6 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Appliquer
                        </button>
                        <a href="{{ route('experiences.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-refresh me-1"></i>Réinitialiser
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Grille des Expériences -->
<div class="container-fluid py-5 bg-light" id="experiences-grid">
    <div class="container py-5">
        <div class="row g-4">
            @forelse($experiences as $experience)
                <div class="col-xxl-4 col-xl-6 col-lg-6 mb-4">
                    <div class="experience-card">
                        <!-- Header de la carte -->
                        <div class="experience-header">
                            <div class="experience-image-container">
                                @if($experience->image_url)
                                    <img src="{{ $experience->image_url }}"
                                         class="experience-image"
                                         alt="Expérience {{ $experience->campaign->title }}">
                                @else
                                    <div class="experience-image-placeholder">
                                        <i class="fas fa-leaf fa-3x text-white"></i>
                                    </div>
                                @endif
                                <div class="image-gradient-overlay"></div>

                                <!-- Badges -->
                                <div class="floating-badges">
                                    <span class="badge campaign-badge">
                                        {{ $experience->campaign->title }}
                                    </span>
                                    @if($experience->rating)
                                        <span class="badge rating-badge">
                                            ⭐ {{ $experience->rating }}/5
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Corps de la carte -->
                        <div class="experience-body">
                            <!-- Métriques rapides -->
                            @if($experience->hours_contributed || $experience->people_reached || $experience->waste_collected || $experience->trees_planted)
                            <div class="experience-metrics">
                                <div class="row g-2 text-center">
                                    @if($experience->hours_contributed)
                                    <div class="col-3">
                                        <div class="metric-item">
                                            <i class="fas fa-clock text-primary"></i>
                                            <small>{{ $experience->hours_contributed }}h</small>
                                        </div>
                                    </div>
                                    @endif
                                    @if($experience->people_reached)
                                    <div class="col-3">
                                        <div class="metric-item">
                                            <i class="fas fa-users text-success"></i>
                                            <small>{{ $experience->people_reached }}</small>
                                        </div>
                                    </div>
                                    @endif
                                    @if($experience->waste_collected)
                                    <div class="col-3">
                                        <div class="metric-item">
                                            <i class="fas fa-trash text-warning"></i>
                                            <small>{{ $experience->waste_collected }}kg</small>
                                        </div>
                                    </div>
                                    @endif
                                    @if($experience->trees_planted)
                                    <div class="col-3">
                                        <div class="metric-item">
                                            <i class="fas fa-tree text-info"></i>
                                            <small>{{ $experience->trees_planted }}</small>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endif

                            <!-- Témoignage -->
                            @if($experience->testimonial)
                            <div class="testimonial-section">
                                <h6 class="section-title">
                                    <i class="fas fa-quote-left me-2"></i>
                                    Témoignage
                                </h6>
                                <p class="testimonial-text">
                                    {{ Str::limit($experience->testimonial, 200) }}
                                </p>
                            </div>
                            @endif

                            <!-- Points forts -->
                            @if($experience->strengths)
                            <div class="strengths-section">
                                <h6 class="section-title">
                                    <i class="fas fa-thumbs-up me-2"></i>
                                    Points forts
                                </h6>
                                <p class="strengths-text">
                                    {{ Str::limit($experience->strengths, 150) }}
                                </p>
                            </div>
                            @endif

                            <!-- Impact personnel -->
                            @if($experience->personal_impact)
                            <div class="impact-section">
                                <h6 class="section-title">
                                    <i class="fas fa-heart me-2"></i>
                                    Impact personnel
                                </h6>
                                <p class="impact-text">
                                    {{ Str::limit($experience->personal_impact, 180) }}
                                </p>
                            </div>
                            @endif
                        </div>

                        <!-- Footer de la carte -->
                        <div class="experience-footer">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-8">
                                    <div class="experience-meta">
                                        <small class="text-muted">
                                            <i class="fas fa-calendar me-1"></i>
                                            {{ $experience->created_at->format('d/m/Y') }}
                                        </small>
                                        @if($experience->user)
                                        <small class="text-muted ms-3">
                                            <i class="fas fa-user me-1"></i>
                                            {{ $experience->user->name }}
                                        </small>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-4 text-end">
                                    <a href="{{ route('campagnes.share', $experience->campaign_id) }}"
                                       class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-plus me-1"></i>Partager
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12">
                    <div class="empty-state-advanced text-center py-5">
                        <div class="empty-icon mb-4">
                            <i class="fas fa-comments fa-4x text-muted"></i>
                        </div>
                        <h3 class="text-muted mb-3">Aucune expérience partagée</h3>
                        <p class="text-muted mb-4 fs-5">
                            @if(request()->anyFilled(['campaign', 'rating']))
                                Aucune expérience ne correspond à vos critères de recherche.
                            @else
                                Soyez le premier à partager votre expérience !
                            @endif
                        </p>
                        <a href="{{ route('campagnes.front') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-arrow-right me-2"></i>Découvrir les campagnes
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        <!-- @if($experiences->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Navigation des expériences">
                    </nav>
                </div>
            </div>
        @endif -->
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation pour les cartes d'expérience
    const experienceCards = document.querySelectorAll('.experience-card');

    experienceCards.forEach((card, index) => {
        card.style.animationDelay = `${index * 0.1}s`;
    });
});
</script>
@endsection
