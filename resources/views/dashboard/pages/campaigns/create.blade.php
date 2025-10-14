<!-- Modal de création -->
<div class="modal fade" id="createCampaignModal" tabindex="-1" role="dialog" aria-labelledby="createCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createCampaignModalLabel">Créer une nouvelle campagne</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('campaigns.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_title">Titre de la campagne *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="create_title" name="title" value="{{ old('title') }}" required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_type">Type de campagne *</label>
                                <select class="form-control @error('type') is-invalid @enderror" id="create_type" name="type" required>
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
                        <label for="create_description">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="create_description" name="description" rows="3" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="create_objective">Objectif principal *</label>
                        <textarea class="form-control @error('objective') is-invalid @enderror"
                                  id="create_objective" name="objective" rows="2" required>{{ old('objective') }}</textarea>
                        @error('objective')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_start_date">Date de début *</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                                       id="create_start_date" name="start_date" value="{{ old('start_date') }}" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_end_date">Date de fin</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                                       id="create_end_date" name="end_date" value="{{ old('end_date') }}">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_ecological_focus">Focus écologique *</label>
                                <select class="form-control @error('ecological_focus') is-invalid @enderror"
                                        id="create_ecological_focus" name="ecological_focus" required>
                                    <option value="">Sélectionnez un focus</option>
                                    @foreach($ecologicalFocuses as $key => $value)
                                        <option value="{{ $key }}" {{ old('ecological_focus') == $key ? 'selected' : '' }}>
                                            {{ $value }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('ecological_focus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_location">Localisation *</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                       id="create_location" name="location" value="{{ old('location') }}" required>
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                  <div class="form-group">
    <label for="create_targets">Cibles concernées *</label>
    <select class="form-control select2-multiple @error('targets') is-invalid @enderror"
            id="create_targets" name="targets[]" multiple required>
        @foreach($targets as $target)
            <option value="{{ $target->id }}" {{ in_array($target->id, old('targets', [])) ? 'selected' : '' }}>
                {{ $target->nom }}
                @if($target->type)
                    - {{ App\Models\Target::getTypes()[$target->type] }}
                @endif
                @if($target->secteur)
                    / {{ App\Models\Target::getSecteurs()[$target->secteur] }}
                @endif
            </option>
        @endforeach
    </select>
    <small class="form-text text-muted">
        <i class="mdi mdi-information-outline"></i>
        Vous pouvez sélectionner plusieurs cibles. La recherche est disponible.
    </small>
    @error('targets')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>


                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_budget">Budget (€)</label>
                                <input type="number" step="0.01" min="0" class="form-control @error('budget') is-invalid @enderror"
                                       id="create_budget" name="budget" value="{{ old('budget') }}">
                                @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="create_image_url">URL de l'image</label>
                                <input type="url" class="form-control @error('image_url') is-invalid @enderror"
                                       id="create_image_url" name="image_url" value="{{ old('image_url') }}">
                                @error('image_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- <div class="form-group">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="create_confirm" required>
                            <label class="form-check-label" for="create_confirm">
                                Je confirme que les informations saisies sont correctes
                            </label>
                        </div>
                    </div> -->
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-gradient-primary">Créer la campagne</button>
                </div>
            </form>
        </div>
    </div>
</div>
