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
                                    <img src="{{  asset($experience->image_url) }}"
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

                        <!-- ✅ SECTION ANALYSE IA CORRIGÉE (une seule section) -->
                        <div class="ai-analysis-section mt-3 p-3 border-start border-4 border-primary bg-light rounded">
                            <div class="d-flex align-items-center mb-2">
                                <i class="fas fa-robot text-primary me-2 fs-5"></i>
                                <h6 class="mb-0 text-primary fw-bold">Analyse Intelligente</h6>
                            </div>
                            
                            {{-- Résumé IA --}}
                            <div class="mb-3">
                                @if($experience->ai_summary === 'Analyse en attente' || $experience->ai_sentiment === 'erreur')
                                    <div class="alert alert-warning py-2 mb-2">
                                        <small class="d-flex align-items-center">
                                            <i class="fas fa-sync-alt me-2 text-warning"></i>
                                            <span>Analyse en cours de génération...</span>
                                        </small>
                                    </div>
                                    <form action="{{ route('experiences.generate-summary', $experience->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-primary">
                                            <i class="fas fa-bolt me-1"></i> Générer l'analyse IA
                                        </button>
                                    </form>
                                @else
                                    <p class="mb-1"><small class="text-muted">📋 Résumé IA:</small></p>
                                    <p class="mb-0 fs-6 text-dark">{{ $experience->ai_summary }}</p>
                                @endif
                            </div>

                            {{-- Sentiment IA --}}
                            <div class="d-flex align-items-center justify-content-between">
                                <small class="text-muted">🎭 Sentiment détecté:</small>
                                @if($experience->ai_sentiment === 'erreur')
                                    <span class="badge bg-warning px-3 py-1">
                                        <i class="fas fa-clock me-1"></i> En attente
                                    </span>
                                @else
                                    <span class="badge bg-{{ $experience->sentiment_color }} px-3 py-1 fw-normal">
                                        {{ $experience->sentiment_icon }} 
                                        {{ ucfirst($experience->ai_sentiment) }}
                                    </span>
                                @endif
                            </div>
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

        <!-- ✅ SECTION ANALYSE GLOBALE DE LA CAMPAGNE -->
        @if($campaignAnalysis && $experiences->total() > 0)
            <div class="row mt-5">
                <div class="col-12">
                    <div class="global-analysis-card p-4 bg-primary text-white rounded shadow">
                        <div class="d-flex align-items-center mb-3">
                            <i class="fas fa-chart-bar fa-2x me-3 text-warning"></i>
                            <h4 class="text-white mb-0">Analyse Globale de la Campagne</h4>
                        </div>
                        
                        @if($campaignAnalysis['success'])
                            <div class="analysis-content">
                                <p class="fs-5 mb-3">{{ $campaignAnalysis['summary'] }}</p>
                                <div class="d-flex align-items-center justify-content-between">
                                    <span class="fs-6">Sentiment global détecté :</span>
                                    <span class="badge bg-{{ $campaignAnalysis['sentiment'] === 'positif' ? 'success' : ($campaignAnalysis['sentiment'] === 'negatif' ? 'danger' : 'secondary') }} fs-6 px-3 py-2">
                                        @if($campaignAnalysis['sentiment'] === 'positif') 😊 Positif
                                        @elseif($campaignAnalysis['sentiment'] === 'negatif') 😔 Négatif  
                                        @else 😐 Neutre
                                        @endif
                                    </span>
                                </div>
                            </div>
                        @else
                            <div class="analysis-fallback">
                                <div class="alert alert-warning mb-3">
                                    <i class="fas fa-info-circle me-2"></i>
                                    {{ $campaignAnalysis['summary'] }}
                                </div>
                                <p class="mb-0 text-light">
                                    <small>
                                        <i class="fas fa-lightbulb me-1"></i>
                                        L'analyse se base sur {{ $experiences->total() }} expérience(s) partagée(s)
                                    </small>
                                </p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endif

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