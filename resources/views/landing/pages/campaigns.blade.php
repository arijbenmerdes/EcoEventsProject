@extends('landing.index')

@section('title', 'Campagnes Écologiques - EcoEvents')

@section('styles')
<link href="{{ asset('landing/css/campaigns-front.css') }}" rel="stylesheet">
@endsection

@section('content')
<!-- Hero Section Écologique -->
<div class="container-fluid position-relative p-0">
    @include('landing.partials.navbar')

    <div class="ecological-hero position-relative overflow-hidden">
        <div class="hero-background"></div>
        <div class="container position-relative py-5" style="z-index: 2;">
            <div class="row justify-content-center text-center py-5">
                <div class="col-lg-8">
                    <div class="hero-content">
                        <h1 class="display-3 fw-bold text-white mb-4 animate-fade-in">
                            Nos <span class="text-warning">Campagnes</span> Écologiques
                        </h1>
                        <p class="lead text-white mb-4 fs-5 animate-slide-up">
                            Rejoignez le mouvement pour un avenir durable. Découvrez nos initiatives
                            et participez à la transformation écologique.
                        </p>
                        <div class="hero-stats d-flex justify-content-center gap-5 mb-4">
                            <div class="stat-item text-center">
                                <div class="stat-number text-warning fw-bold fs-2">{{ $campaigns->count() }}</div>
                                <div class="stat-label text-white">Campagnes Actives</div>
                            </div>
                            <div class="stat-item text-center">
                                @php
                                    $totalTargets = 0;
                                    foreach($campaigns as $campagne) {
                                        $totalTargets += $campagne->targets->count();
                                    }
                                @endphp
                                <div class="stat-number text-warning fw-bold fs-2">{{ $totalTargets }}</div>
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

<!-- Section Filtres Avancés -->
<div class="container-fluid bg-light py-4 sticky-top filter-section">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h5 class="text-primary mb-0">
                    <i class="fas fa-filter me-2"></i>
                    Trouvez la campagne qui vous correspond
                </h5>
            </div>
            <div class="col-md-4 text-end">
                <span class="badge bg-primary fs-6">
                    {{ $campaigns->count() }} résultat(s)
                </span>
            </div>
        </div>
    </div>
</div>

<!-- Filtres Détaillés -->
<div class="container-fluid bg-white border-bottom py-4">
    <div class="container">
        <form action="{{ route('campagnes.front') }}" method="GET" class="filter-form">
            <div class="row g-4">
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <label class="form-label fw-bold text-primary">🌱 Type d'action</label>
                    <select name="type" class="form-select form-select-lg border-primary">
                        <option value="">Tous les types</option>
                        @foreach(\App\Models\Campaign::getTypes() as $value => $label)
                            <option value="{{ $value }}" {{ request('type') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <label class="form-label fw-bold text-success">🎯 Focus écologique</label>
                    <select name="ecological_focus" class="form-select form-select-lg border-success">
                        <option value="">Tous les domaines</option>
                        @foreach(\App\Models\Campaign::getEcologicalFocuses() as $value => $label)
                            <option value="{{ $value }}" {{ request('ecological_focus') == $value ? 'selected' : '' }}>
                                {{ $label }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <label class="form-label fw-bold text-info">📅 Statut</label>
                    <select name="status" class="form-select form-select-lg border-info">
                        <option value="">Tous les statuts</option>
                        <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>🚀 En cours</option>
                        <option value="upcoming" {{ request('status') == 'upcoming' ? 'selected' : '' }}>📅 À venir</option>
                    </select>
                </div>
                <div class="col-xl-3 col-lg-12 col-md-6 d-flex align-items-end">
                    <div class="d-grid gap-2 w-100">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-search me-2"></i>Appliquer
                        </button>
                        <a href="{{ route('campagnes.front') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="fas fa-refresh me-1"></i>Réinitialiser
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Grille des Campagnes -->
<div class="container-fluid py-5 bg-light" id="campagnes-grid">
    <div class="container py-5">
        <div class="row g-4">
            @forelse($campaigns as $campagne)
                <div class="col-xxl-4 col-xl-6 col-lg-6 mb-4">
                    <div class="campaign-card-advanced">
                        <!-- Header de la carte -->
                        <div class="campaign-header position-relative">
                            <div class="campaign-image-container">
                                <img src="{{ $campagne->image_url ? asset('storage/' . $campagne->image_url) : asset('landing/img/campaign-default.jpg') }}"
                                     class="campaign-image"
                                     alt="{{ $campagne->title }}">
                                <div class="image-gradient-overlay"></div>

                                <!-- Badges flottants -->
                                <div class="floating-badges">
                                    <span class="badge type-badge">
                                        <i class="fas fa-tag me-1"></i>
                                        {{ \App\Models\Campaign::getTypes()[$campagne->type] }}
                                    </span>
                                    <span class="badge focus-badge">
                                        <i class="fas fa-leaf me-1"></i>
                                        {{ \App\Models\Campaign::getEcologicalFocuses()[$campagne->ecological_focus] }}
                                    </span>
                                </div>

                                <!-- Statut -->
                                <div class="status-indicator">
                                    @if($campagne->status === \App\Models\Campaign::STATUS_ACTIVE && $campagne->is_ongoing)
                                        <span class="status-badge live">
                                            <i class="fas fa-play-circle me-1"></i>En direct
                                        </span>
                                    @elseif($campagne->status === \App\Models\Campaign::STATUS_ACTIVE && $campagne->start_date > now())
                                        <span class="status-badge upcoming">
                                            <i class="fas fa-clock me-1"></i>À venir
                                        </span>
                                    @else
                                        <span class="status-badge draft">
                                            {{ \App\Models\Campaign::getStatuses()[$campagne->status] }}
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Corps de la carte avec scroll -->
                        <div class="campaign-body">
                            <!-- Titre -->
                            <h3 class="campaign-title">{{ $campagne->title }}</h3>

                            <!-- Description COMPLÈTE -->
                            <div class="campaign-description-full">
                                <h6 class="section-title">
                                    <i class="fas fa-align-left me-2"></i>
                                    Description
                                </h6>
                                <p class="description-text">{{ $campagne->description }}</p>
                            </div>

                            <!-- Objectif COMPLET -->
                            <div class="campaign-objective-full">
                                <h6 class="section-title">
                                    <i class="fas fa-bullseye me-2"></i>
                                    Objectif Principal
                                </h6>
                                <p class="objective-text">{{ $campagne->objective }}</p>
                            </div>

                            <!-- Informations Détaillées -->
                            <div class="campaign-details-grid">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <div class="detail-item">
                                            <i class="fas fa-calendar-start"></i>
                                            <div>
                                                <small class="text-muted">Date de début</small>
                                                <div class="fw-bold">{{ $campagne->start_date->format('d/m/Y à H:i') }}</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="detail-item">
                                            <i class="fas fa-calendar-end"></i>
                                            <div>
                                                <small class="text-muted">Date de fin</small>
                                                <div class="fw-bold">
                                                    {{ $campagne->end_date ? $campagne->end_date->format('d/m/Y à H:i') : 'Indéfinie' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Budget Détail -->
                            @if($campagne->budget)
                            <div class="budget-detail">
                                <h6 class="section-title">
                                    <i class="fas fa-coins me-2"></i>
                                    Budget Alloué
                                </h6>
                                <div class="budget-amount text-success">
                                    {{ number_format($campagne->budget, 2, ',', ' ') }} €
                                </div>
                            </div>
                            @endif

                            <!-- Localisation Détail -->
                            @if($campagne->location)
                            <div class="location-detail">
                                <h6 class="section-title">
                                    <i class="fas fa-map-marker-alt me-2"></i>
                                    Localisation
                                </h6>
                                <div class="location-text">{{ $campagne->location }}</div>
                            </div>
                            @endif

                            <!-- Statut Complet -->
                            <div class="status-detail">
                                <h6 class="section-title">
                                    <i class="fas fa-info-circle me-2"></i>
                                    Statut Détaillé
                                </h6>
                                <div class="status-info">
                                    <span class="badge bg-{{ $campagne->status === 'active' ? 'success' : 'secondary' }} me-2">
                                        {{ \App\Models\Campaign::getStatuses()[$campagne->status] }}
                                    </span>
                                    @if($campagne->is_ongoing)
                                        <span class="badge bg-success">
                                            <i class="fas fa-running me-1"></i>En cours
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <!-- Cibles COMPLÈTES -->
                            @if($campagne->targets->count() > 0)
                                <div class="campaign-targets-full">
                                    <h6 class="section-title">
                                        <i class="fas fa-crosshairs me-2"></i>
                                        Publics Cibles ({{ $campagne->targets->count() }})
                                    </h6>
                                    <div class="targets-grid">
                                        @foreach($campagne->targets as $target)
                                            <div class="target-card">
                                                <div class="target-header">
                                                    <strong class="target-name">{{ $target->nom }}</strong>
                                                    <span class="target-type-badge">
                                                        {{ \App\Models\Target::getTypes()[$target->type] }}
                                                    </span>
                                                </div>
                                                <div class="target-details">
                                                    <small class="text-muted">
                                                        <i class="fas fa-industry me-1"></i>
                                                        {{ \App\Models\Target::getSecteurs()[$target->secteur] }}
                                                    </small>
                                                    @if($target->age_min || $target->age_max)
                                                    <small class="text-muted">
                                                        <i class="fas fa-user me-1"></i>
                                                        {{ $target->plage_age }}
                                                    </small>
                                                    @endif
                                                </div>
                                                @if($target->description)
                                                <div class="target-description">
                                                    <small>{{ Str::limit($target->description, 80) }}</small>
                                                </div>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Métriques Avancées -->
                            <div class="advanced-metrics">
                                <h6 class="section-title">
                                    <i class="fas fa-chart-bar me-2"></i>
                                    Métriques
                                </h6>
                                <div class="metrics-grid">
                                    <div class="metric-advanced">
                                        <div class="metric-icon">
                                            <i class="fas fa-users text-primary"></i>
                                        </div>
                                        <div class="metric-content">
                                            <div class="metric-value">{{ $campagne->targets->count() }}</div>
                                            <div class="metric-label">Publics Cibles</div>
                                        </div>
                                    </div>
                                    <div class="metric-advanced">
                                        <div class="metric-icon">
                                            <i class="fas fa-calendar-day text-success"></i>
                                        </div>
                                        <div class="metric-content">
                                            <div class="metric-value">
                                                {{ $campagne->start_date->diffInDays($campagne->end_date ?? now()) }}
                                            </div>
                                            <div class="metric-label">Jours</div>
                                        </div>
                                    </div>
                                    <!-- <div class="metric-advanced">
                                        <div class="metric-icon">
                                            <i class="fas fa-eye text-info"></i>
                                        </div>
                                        <div class="metric-content">
                                            <div class="metric-value">{{ rand(50, 500) }}</div>
                                            <div class="metric-label">Vues</div>
                                        </div>
                                    </div> -->
                                </div>
                            </div>
                        </div>

                        <!-- Footer de la carte -->
                        <div class="campaign-footer">
                            <div class="row g-2 align-items-center">
                                <div class="col-md-8">
                                    <div class="campaign-meta-info">
                                        <small class="text-muted">
                                            <i class="fas fa-clock me-1"></i>
                                            Créée le {{ $campagne->created_at->format('d/m/Y') }}
                                        </small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="action-buttons">
                                        @if($campagne->is_ongoing)
    <button class="btn btn-success participate-btn">
        <i class="fas fa-hand-holding-heart me-1"></i>Participer
    </button>
@else
    <a href="{{ route('campagnes.share', $campagne->id) }}" class="btn btn-outline-primary details-btn">
        <i class="fas fa-share-alt me-1"></i>Partager mon expérience
    </a>
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
                            <i class="fas fa-search fa-4x text-muted"></i>
                        </div>
                        <h3 class="text-muted mb-3">Aucune campagne trouvée</h3>
                        <p class="text-muted mb-4 fs-5">
                            @if(request()->anyFilled(['type', 'ecological_focus', 'status']))
                                Aucune campagne ne correspond à vos critères de recherche.
                            @else
                                Aucune campagne active pour le moment. Revenez bientôt !
                            @endif
                        </p>
                        <a href="{{ route('campagnes.front') }}" class="btn btn-primary btn-lg rounded-pill px-4">
                            <i class="fas fa-refresh me-2"></i>Voir toutes les campagnes
                        </a>
                    </div>
                </div>
            @endforelse
        </div>

        @if($campaigns->hasPages())
            <div class="row mt-5">
                <div class="col-12">
                    <nav aria-label="Navigation des campagnes">
                        {{ $campaigns->links('vendor.pagination.bootstrap-5') }}
                    </nav>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- CTA Section -->

@endsection
