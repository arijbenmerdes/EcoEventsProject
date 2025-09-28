@extends('dashboard.index')

@section('title', $campaign->title)

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-campaign"></i>
            </span>
            {{ $campaign->title }}
        </h3>
        <nav aria-label="breadcrumb">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('campaigns.index') }}">Campagnes</a></li>
                <li class="breadcrumb-item active" aria-current="page">Détails</li>
            </ul>
        </nav>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- CARD INFORMATIONS PRINCIPALES -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informations de la campagne</h4>

                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Type :</strong>
                                <span class="badge badge-info">{{ App\Models\Campaign::getTypes()[$campaign->type] }}</span>
                            </p>
                            <p><strong>Focus écologique :</strong>
                                <span class="badge badge-success">{{ App\Models\Campaign::getEcologicalFocuses()[$campaign->ecological_focus] }}</span>
                            </p>
                            <p><strong>Localisation :</strong> {{ $campaign->location }}</p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Statut :</strong>
                                @php
                                    $statusColors = [
                                        'draft' => 'secondary',
                                        'active' => 'success',
                                        'paused' => 'warning',
                                        'completed' => 'info',
                                        'cancelled' => 'danger'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $statusColors[$campaign->status] }}">
                                    {{ App\Models\Campaign::getStatuses()[$campaign->status] }}
                                </span>
                            </p>
                            <p><strong>Date de début :</strong> {{ $campaign->start_date->format('d/m/Y H:i') }}</p>
                            <p><strong>Date de fin :</strong>
                                {{ $campaign->end_date ? $campaign->end_date->format('d/m/Y H:i') : 'Non définie' }}
                            </p>
                        </div>
                    </div>

                    <div class="mt-3">
                        <h5>Description</h5>
                        <p class="text-justify">{{ $campaign->description }}</p>
                    </div>

                    <div class="mt-3">
                        <h5>Objectif</h5>
                        <p class="text-justify">{{ $campaign->objective }}</p>
                    </div>

                    @if($campaign->budget)
                    <div class="mt-3">
                        <h5>Budget</h5>
                        <p class="h4 text-primary">{{ number_format($campaign->budget, 2, ',', ' ') }} €</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- CARD STATISTIQUES -->
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Statistiques</h4>

                    <div class="text-center">
                        <div class="mb-3">
                            <h2 class="text-primary">{{ $campaign->targets->count() }}</h2>
                            <p class="text-muted">Cibles associées</p>
                        </div>

                        <div class="mb-3">
                            <h2 class="text-success">
                                {{ $campaign->is_ongoing ? 'En cours' : 'Terminée' }}
                            </h2>
                            <p class="text-muted">État</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARD ACTIONS -->
            <div class="card mt-3">
                <div class="card-body">
                    <h4 class="card-title">Actions</h4>

                    <div class="d-grid gap-2">
                        <a href="{{ route('campaigns.edit', $campaign->id) }}" class="btn btn-primary">
                            <i class="mdi mdi-pencil"></i> Modifier
                        </a>
                        <form action="{{ route('campaigns.destroy', $campaign->id) }}" method="POST" class="d-grid">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger"
                                    onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette campagne ?')">
                                <i class="mdi mdi-delete"></i> Supprimer
                            </button>
                        </form>
                        <a href="{{ route('campaigns.index') }}" class="btn btn-light">
                            <i class="mdi mdi-arrow-left"></i> Retour à la liste
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- CARD CIBLES ASSOCIEES -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title d-flex justify-content-between align-items-center">
                        Cibles associées
                        <span class="badge badge-primary">{{ $campaign->targets->count() }}</span>
                    </h4>

                    @if($campaign->targets->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Secteur</th>
                                    <th>Plage d'âge</th>
                                    <th>Profession</th>
                                    <th>Statut</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaign->targets as $target)
                                <tr>
                                    <td>
                                        <strong>{{ $target->nom }}</strong>
                                        @if($target->description)
                                        <br><small class="text-muted">{{ Str::limit($target->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ App\Models\Target::getTypes()[$target->type] }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($target->secteur)
                                        <span class="badge badge-secondary">
                                            {{ App\Models\Target::getSecteurs()[$target->secteur] }}
                                        </span>
                                        @else
                                        <span class="text-muted">Non spécifié</span>
                                        @endif
                                    </td>
                                    <td>{{ $target->plage_age }}</td>
                                    <td>{{ $target->profession ?: 'Non spécifié' }}</td>
                                    <td>
                                        <span class="badge badge-{{ $target->est_actif ? 'success' : 'danger' }}">
                                            {{ $target->est_actif ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @else
                    <div class="text-center text-muted py-4">
                        <i class="mdi mdi-target mdi-48px"></i>
                        <br>
                        Aucune cible associée à cette campagne
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
