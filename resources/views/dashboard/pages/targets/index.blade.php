@extends('dashboard.index')

@section('title', 'Gestion des Cibles')

@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            <span class="page-title-icon bg-gradient-primary text-white me-2">
                <i class="mdi mdi-target"></i>
            </span>
            Gestion des Cibles
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

            <!-- CARD PRINCIPALE -->
            <div class="card">
                <div class="card-body">
                    <!-- BOUTON ET TITRE -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h4 class="card-title">Liste des Cibles</h4>
                        <button type="button" class="btn btn-gradient-primary" data-toggle="modal" data-target="#createTargetModal">
                            <i class="mdi mdi-plus"></i> Nouvelle Cible
                        </button>
                    </div>

                    <!-- TABLEAU DES CIBLES -->
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Type</th>
                                    <th>Secteur</th>
                                    <th>Plage d'âge</th>
                                    <th>Profession</th>
                                    <th>Campagnes</th>
                                    <th>Statut</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($targets as $target)
                                <tr>
                                    <td>
                                        <strong>{{ $target->nom }}</strong>
                                        @if($target->description)
                                            <br><small class="text-muted">{{ Str::limit($target->description, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge badge-info">
                                            {{ $types[$target->type] ?? $target->type }}
                                        </span>
                                    </td>
                                    <td>
                                        @if($target->secteur)
                                            <span class="badge badge-secondary">
                                                {{ $secteurs[$target->secteur] ?? $target->secteur }}
                                            </span>
                                        @else
                                            <span class="text-muted">Non spécifié</span>
                                        @endif
                                    </td>
                                    <td>{{ $target->plage_age }}</td>
                                    <td>{{ $target->profession ?? 'Non spécifié' }}</td>
                                    <td>
                                        <span class="badge badge-primary">{{ $target->campaigns_count }}</span>
                                    </td>
                                    <td>
                                        <span class="badge {{ $target->est_actif ? 'badge-info' : 'badge-danger' }}">
                                            {{ $target->est_actif ? 'Actif' : 'Inactif' }}
                                        </span>
                                    </td>
                                    <td>
                                        <!-- Bouton édition -->
                                        <button type="button" class="btn btn-sm btn-primary"
                                                data-toggle="modal"
                                                data-target="#editTargetModal"
                                                data-id="{{ $target->id }}"
                                                data-nom="{{ $target->nom }}"
                                                data-description="{{ $target->description }}"
                                                data-type="{{ $target->type }}"
                                                data-age-min="{{ $target->age_min }}"
                                                data-age-max="{{ $target->age_max }}"
                                                data-profession="{{ $target->profession }}"
                                                data-secteur="{{ $target->secteur }}"
                                                data-est-actif="{{ $target->est_actif }}">
                                            <i class="mdi mdi-pencil"></i>
                                        </button>

                                        <!-- Bouton activation/désactivation -->
                                        <form action="{{ route('targets.toggle-activation', $target->id) }}"
                                              method="POST" class="d-inline">
                                            @csrf
                                            @method('PATCH')
<button type="submit" class="btn btn-sm {{ $target->est_actif ? 'btn-warning' : 'btn-gradient-primary' }}">                                                <i class="mdi {{ $target->est_actif ? 'mdi-toggle-switch-off' : 'mdi-toggle-switch' }}"></i>
                                            </button>
                                        </form>

                                        <!-- Bouton suppression -->
                                        <button type="button" class="btn btn-sm btn-danger"
                                                data-toggle="modal"
                                                data-target="#deleteTargetModal"
                                                data-id="{{ $target->id }}"
                                                data-nom="{{ $target->nom }}"
                                                data-campaigns-count="{{ $target->campaigns_count }}">
                                            <i class="mdi mdi-delete"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach

                                @if($targets->isEmpty())
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Aucune cible trouvée.
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $targets->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- INCLUSION DES MODALS -->
@include('dashboard.pages.targets.create')
@include('dashboard.pages.targets.edit')
@include('dashboard.pages.targets.delete')

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Modal d'édition
    const editButtons = document.querySelectorAll('[data-target="#editTargetModal"]');
    const editForm = document.getElementById('editTargetForm');

    editButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.dataset.id;
            editForm.action = '/targets/' + targetId;

            // Remplir les champs du formulaire
            document.getElementById('edit_nom').value = this.dataset.nom || '';
            document.getElementById('edit_description').value = this.dataset.description || '';
            document.getElementById('edit_type').value = this.dataset.type || '';
            document.getElementById('edit_age_min').value = this.dataset.ageMin || '';
            document.getElementById('edit_age_max').value = this.dataset.ageMax || '';
            document.getElementById('edit_profession').value = this.dataset.profession || '';
            document.getElementById('edit_secteur').value = this.dataset.secteur || '';

            // Gérer la checkbox est_actif
            const estActifCheckbox = document.getElementById('edit_est_actif');
            if (estActifCheckbox) {
                estActifCheckbox.checked = this.dataset.estActif === '1';
            }
        });
    });

    // Modal de suppression
    const deleteButtons = document.querySelectorAll('[data-target="#deleteTargetModal"]');
    const deleteForm = document.getElementById('deleteTargetForm');
    const targetNameElement = document.querySelector('.target-name');
    const campaignsWarning = document.getElementById('campaignsWarning');
    const campaignsCountElement = document.getElementById('campaignsCount');

    deleteButtons.forEach(button => {
        button.addEventListener('click', function () {
            const targetId = this.dataset.id;
            deleteForm.action = '/targets/' + targetId;

            // Remplir le nom dans le message de confirmation
            targetNameElement.textContent = this.dataset.nom;

            // Afficher l'alerte si des campagnes sont associées
            const campaignsCount = parseInt(this.dataset.campaignsCount) || 0;
            if (campaignsCount > 0) {
                campaignsWarning.style.display = 'block';
                campaignsCountElement.textContent = campaignsCount;
            } else {
                campaignsWarning.style.display = 'none';
            }
        });
    });
});
</script>
@endsection
