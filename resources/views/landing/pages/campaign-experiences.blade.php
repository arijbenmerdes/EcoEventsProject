@extends('landing.index')

@section('title', 'Expériences - ' . $campaign->title . ' - EcoEvents')

@section('styles')
<link href="{{ asset('landing/css/campaigns-front.css') }}" rel="stylesheet">
<link href="{{ asset('landing/css/experiences.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Hero Section -->
<div class="container-fluid position-relative p-0">
    @include('landing.partials.navbar')

    <div class="campaign-experiences-hero position-relative overflow-hidden">
        <div class="hero-background"></div>
        <div class="container position-relative py-5" style="z-index: 2;">
            <div class="row justify-content-center text-center py-5">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="display-3 fw-bold text-white mb-4 animate-fade-in">
                            Expériences - <span class="text-warning">{{ $campaign->title }}</span>
                        </h1>
                        <p class="lead text-white mb-4 fs-5 animate-slide-up">
                            Découvrez les témoignages des participants de cette campagne écologique.
                        </p>
                        <div class="hero-stats d-flex justify-content-center gap-5 mb-4">
                            <div class="stat-item text-center">
                                <div class="stat-number text-warning fw-bold fs-2">{{ $experiences->total() }}</div>
                                <div class="stat-label text-white">Expériences</div>
                            </div>
                            <div class="stat-item text-center">
                                <div class="stat-number text-warning fw-bold fs-2">{{ $campaign->targets->count() }}</div>
                                <div class="stat-label text-white">Publics cibles</div>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <a href="{{ route('campagnes.front') }}" class="btn btn-outline-light btn-lg">
                                <i class="fas fa-arrow-left me-2"></i>Retour aux campagnes
                            </a>
                            <a href="{{ route('campagnes.share', $campaign->id) }}" class="btn btn-warning btn-lg">
                                <i class="fas fa-share-alt me-2"></i>Partager mon expérience
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Informations de la campagne -->
<div class="container-fluid bg-light py-4">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h4 class="text-primary mb-2">{{ $campaign->title }}</h4>
                <p class="text-muted mb-0">{{ Str::limit($campaign->description, 150) }}</p>
            </div>
            <div class="col-md-4 text-end">
                <div class="campaign-info-badges">
                    <span class="badge bg-primary me-2">
                        <i class="fas fa-tag me-1"></i>
                        {{ \App\Models\Campaign::getTypes()[$campaign->type] }}
                    </span>
                    <span class="badge bg-success">
                        <i class="fas fa-leaf me-1"></i>
                        {{ \App\Models\Campaign::getEcologicalFocuses()[$campaign->ecological_focus] }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Grille des Expériences -->
<div class="container-fluid py-5 bg-white" id="experiences-grid">
    <div class="container py-5">
        @if($experiences->total() > 0)
            <div class="row mb-4">
                <div class="col-12">
                    <h3 class="text-center mb-4">
                        <i class="fas fa-comments text-primary me-2"></i>
                        {{ $experiences->total() }} expérience(s) partagée(s)
                    </h3>
                </div>
            </div>
        @endif

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
                        <h3 class="text-muted mb-3">Aucune expérience partagée pour cette campagne</h3>
                        <p class="text-muted mb-4 fs-5">
                            Soyez le premier à partager votre expérience !
                        </p>
                        <a href="{{ route('campagnes.share', $campaign->id) }}" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-share-alt me-2"></i>Partager mon expérience
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if($experiences->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Navigation des expériences">
                        {{ $experiences->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>
@endsection
