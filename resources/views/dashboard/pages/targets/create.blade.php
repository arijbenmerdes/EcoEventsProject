<!-- Modal de création -->
<div class="modal fade" id="createTargetModal" tabindex="-1" role="dialog" aria-labelledby="createTargetModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createTargetModalLabel">Créer une nouvelle cible</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('targets.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nom">Nom de la cible *</label>
                                <input type="text" class="form-control @error('nom') is-invalid @enderror"
                                       id="nom" name="nom" value="{{ old('nom') }}" required>
                                @error('nom')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="type">Type *</label>
                                <select class="form-control @error('type') is-invalid @enderror" id="type" name="type" required>
                                    <option value="">Sélectionnez un type</option>
                                    @foreach($types as $key => $value)
                                        <option value="{{ $key }}" {{ old('type') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Description de la cible...">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="age_min">Âge minimum</label>
                                <input type="number" class="form-control @error('age_min') is-invalid @enderror"
                                       id="age_min" name="age_min" min="0" value="{{ old('age_min') }}"
                                       placeholder="Ex: 18">
                                @error('age_min')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="age_max">Âge maximum</label>
                                <input type="number" class="form-control @error('age_max') is-invalid @enderror"
                                       id="age_max" name="age_max" min="0" value="{{ old('age_max') }}"
                                       placeholder="Ex: 65">
                                @error('age_max')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="profession">Profession</label>
                                <input type="text" class="form-control @error('profession') is-invalid @enderror"
                                       id="profession" name="profession" value="{{ old('profession') }}"
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
                                <label for="secteur">Secteur d'activité</label>
                                <select class="form-control @error('secteur') is-invalid @enderror" id="secteur" name="secteur">
                                    <option value="">Sélectionnez un secteur</option>
                                    @foreach($secteurs as $key => $value)
                                        <option value="{{ $key }}" {{ old('secteur') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
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
                                    <input class="form-check-input" type="checkbox" id="est_actif" name="est_actif"
                                           value="1" {{ old('est_actif', true) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="est_actif">
                                        Cible active
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-gradient-primary">Créer la cible</button>
                </div>
            </form>
        </div>
    </div>
</div>
