<!-- Modal d'édition -->
<div class="modal fade" id="editTargetModal" tabindex="-1" role="dialog" aria-labelledby="editTargetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editTargetModalLabel">Modifier la cible</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="editTargetForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_nom">Nom de la cible *</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                       id="edit_nom" name="nom" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_type">Type *</label>
                                <select class="form-control @error('type') is-invalid @enderror" id="edit_type" name="type" required>
                                    <option value="">Sélectionnez un type</option>
                                    @foreach($types as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="edit_description" name="description" rows="3"
                                  placeholder="Description de la cible..."></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_age_min">Âge minimum</label>
                                <input type="number" class="form-control @error('age_min') is-invalid @enderror"
                                       id="edit_age_min" name="age_min" min="0"
                                       placeholder="Ex: 18">
                                @error('age_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="edit_age_max">Âge maximum</label>
                                <input type="number" class="form-control @error('age_max') is-invalid @enderror"
                                       id="edit_age_max" name="age_max" min="0"
                                       placeholder="Ex: 65">
                                @error('age_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_profession">Profession</label>
                                <input type="text" class="form-control @error('profession') is-invalid @enderror"
                                       id="edit_profession" name="profession"
                                       placeholder="Ex: Étudiant, Cadre, Retraité...">
                                @error('profession')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_secteur">Secteur d'activité</label>
                                <select class="form-control @error('secteur') is-invalid @enderror" id="edit_secteur" name="secteur">
                                    <option value="">Sélectionnez un secteur</option>
                                    @foreach($secteurs as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('secteur')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Statut</label>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="edit_est_actif" name="est_actif" value="1">
                                    <label class="form-check-label" for="edit_est_actif">
                                        Cible active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-gradient-primary">Mettre à jour</button>
                </div>
            </form>
        </div>
    </div>
</div>
