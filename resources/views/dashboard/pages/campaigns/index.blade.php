@extends('dashboard.index')

@section('title', 'Gestion des Campagnes')

@section('content')
<div class="content-wrapper">
   <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-target"></i>
            </span>
            Gestion des Campagnes
        </h3>
    </div>

    <div class="row">
        <div class="col-12">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert">
                        <span>&times;</span>
                    </button>
                </div>
            @endif
 <!-- FILTRE ET RECHERCHE -->
<form method="GET" action="{{ route('campaigns.index') }}" class="mb-3">
    <div class="d-flex flex-wrap align-items-end gap-2">
        <!-- Recherche -->
        <div class="flex-grow-1" style="min-width: 200px;">
            <input type="text" name="search" class="form-control" placeholder="Rechercher..." value="{{ request('search') }}">
        </div>

       <!-- Type -->
<div style="min-width: 200px;">
    <select name="type" class="form-control" style="height: 45px;">
        <option value="">Tous les types</option>
        @foreach($types as $key => $value)
            <option value="{{ $key }}" {{ request('type') == $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>

<!-- Focus écologique -->
<div style="min-width: 200px; margin-left: 10px;">
    <select name="ecological_focus" class="form-control" style="height: 45px;">
        <option value="">Tous les focuses</option>
        @foreach($ecologicalFocuses as $key => $value)
            <option value="{{ $key }}" {{ request('ecological_focus') == $key ? 'selected' : '' }}>
                {{ $value }}
            </option>
        @endforeach
    </select>
</div>


        <!-- Boutons -->
        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">Filtrer</button>
            <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">Réinitialiser</a>
        </div>
    </div>
</form>

            <!-- CARD PRINCIPALE -->
            <div class="card">
                <div class="card-body">
                    <!-- BOUTON ET TITRE -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Liste des Campagnes</h4>
                        <button type="button" class="btn btn-gradient-primary" data-toggle="modal" data-target="#createCampaignModal">
                            <i class="mdi mdi-plus"></i> Nouvelle Campagne
                        </button>
                    </div>

                    <!-- TABLEAU DES CAMPAGNES -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Titre</th>
                                    <th>Type</th>
                                    <th>Focus écologique</th>
                                    <th>Localisation</th>
                                    <th>Nombre de cibles</th>
                                    <th>Statut</th>
                                    <th>Date début</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($campaigns as $campaign)
                                <tr>
                                    <td>
                                        <strong>{{ $campaign->title }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($campaign->objective, 50) }}</small>
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ App\Models\Campaign::getTypes()[$campaign->type] }}
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge badge-success">
                                            {{ App\Models\Campaign::getEcologicalFocuses()[$campaign->ecological_focus] }}
                                        </span>
                                    </td>
                                    <td>{{ $campaign->location }}</td>
                                    <td>
                                        <span class="badge badge-primary">{{ $campaign->targets_count }}</span>
                                    </td>
                                    <td>
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
                                    </td>
                                    <td>{{ $campaign->start_date->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- <a href="{{ route('campaigns.show', $campaign->id) }}"
                                               class="btn btn-sm btn-info" title="Voir">
                                                <i class="mdi mdi-eye"></i>
                                            </a> -->
                                            <!-- Bouton édition -->
                                            <button type="button" class="btn btn-sm btn-primary"
                                                    data-toggle="modal"
                                                    data-target="#editCampaignModal"
                                                    data-id="{{ $campaign->id }}"
                                                    data-title="{{ $campaign->title }}"
                                                    data-type="{{ $campaign->type }}"
                                                    data-description="{{ $campaign->description }}"
                                                    data-objective="{{ $campaign->objective }}"
                                                    data-start-date="{{ $campaign->start_date->format('Y-m-d\TH:i') }}"
                                                    data-end-date="{{ $campaign->end_date ? $campaign->end_date->format('Y-m-d\TH:i') : '' }}"
                                                    data-ecological-focus="{{ $campaign->ecological_focus }}"
                                                    data-location="{{ $campaign->location }}"
                                                    data-budget="{{ $campaign->budget }}"
                                                    data-image-url="{{ $campaign->image_url }}"
                                                    data-status="{{ $campaign->status }}"
                                                    data-targets="{{ $campaign->targets->pluck('id')->toJson() }}"
                                                    title="Modifier">
                                                <i class="mdi mdi-pencil"></i>
                                            </button>
                                            <!-- Bouton suppression -->
                                            <button type="button" class="btn btn-sm btn-danger"
                                                    data-toggle="modal"
                                                    data-target="#deleteCampaignModal"
                                                    data-id="{{ $campaign->id }}"
                                                    data-title="{{ $campaign->title }}"
                                                    title="Supprimer">
                                                <i class="mdi mdi-delete"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach

                                @if($campaigns->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">
                                        <i class="mdi mdi-campaign-off mdi-48px"></i>
                                        <br>
                                        Aucune campagne trouvée.
                                        <br>

                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('dashboard.pages.campaigns.create', [
    'types' => $types ?? [],
    'ecologicalFocuses' => $ecologicalFocuses ?? [],
    'targets' => $targets ?? collect()
])

@include('dashboard.pages.campaigns.edit', [
    'types' => $types ?? [],
    'ecologicalFocuses' => $ecologicalFocuses ?? [],
    'statuses' => $statuses ?? [],
    'targets' => $targets ?? collect()
])
@include('dashboard.pages.campaigns.delete')

@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Auto-dismiss alerts
    setTimeout(function() {
        $('.alert').alert('close');
    }, 5000);

    // Initialisation de Select2
    $('.select2-multiple').select2({
        placeholder: "Sélectionnez les cibles",
        allowClear: true
    });

    // Modal d'édition
    const editButtons = document.querySelectorAll('[data-target="#editCampaignModal"]');
    const editForm = document.getElementById('editCampaignForm');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const campaignId = this.dataset.id;
            editForm.action = '/campaigns/' + campaignId;

            // Remplir les champs du formulaire
            document.getElementById('edit_title').value = this.dataset.title || '';
            document.getElementById('edit_type').value = this.dataset.type || '';
            document.getElementById('edit_description').value = this.dataset.description || '';
            document.getElementById('edit_objective').value = this.dataset.objective || '';
            document.getElementById('edit_start_date').value = this.dataset.startDate || '';
            document.getElementById('edit_end_date').value = this.dataset.endDate || '';
            document.getElementById('edit_ecological_focus').value = this.dataset.ecologicalFocus || '';
            document.getElementById('edit_location').value = this.dataset.location || '';
            document.getElementById('edit_budget').value = this.dataset.budget || '';
            document.getElementById('edit_image_url').value = this.dataset.imageUrl || '';
            document.getElementById('edit_status').value = this.dataset.status || '';

            // Remplir les cibles (Select2)
            const targets = JSON.parse(this.dataset.targets || '[]');
            $('#edit_targets').val(targets).trigger('change');

            // Re-initialiser Select2 pour le modal d'édition
            $('#edit_targets').select2({
                placeholder: "Sélectionnez les cibles",
                allowClear: true
            });
        });
    });

    // Modal de suppression
    const deleteButtons = document.querySelectorAll('[data-target="#deleteCampaignModal"]');
    const deleteForm = document.getElementById('deleteCampaignForm');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const campaignId = this.dataset.id;
            deleteForm.action = '/campaigns/' + campaignId;

            // Remplir le nom dans le message de confirmation
            const campaignTitle = this.dataset.title || '';
            const titleElement = deleteForm.querySelector('.campaign-title');
            if (titleElement) {
                titleElement.textContent = campaignTitle;
            }
        });
    });

    // Validation des dates
    $('#edit_start_date, #edit_end_date').change(function() {
        const startDate = new Date($('#edit_start_date').val());
        const endDate = new Date($('#edit_end_date').val());

        if (startDate && endDate && startDate > endDate) {
            alert('La date de début doit être antérieure à la date de fin');
            $(this).val('');
        }
    });

    $('#create_start_date, #create_end_date').change(function() {
        const startDate = new Date($('#create_start_date').val());
        const endDate = new Date($('#create_end_date').val());

        if (startDate && endDate && startDate > endDate) {
            alert('La date de début doit être antérieure à la date de fin');
            $(this).val('');
        }
    });
});
</script>
@endsection
