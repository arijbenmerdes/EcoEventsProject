<!-- Modal de modification -->
<div class="modal fade" id="editCampaignModal" tabindex="-1" role="dialog" aria-labelledby="editCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editCampaignModalLabel">Modifier la campagne</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Fermer">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="editCampaignForm">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_title">Titre de la campagne *</label>
                                <input type="text" class="form-control @error('title') is-invalid @enderror"
                                       id="edit_title" name="title" required
                                       placeholder="Titre de la campagne...">
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_type">Type de campagne *</label>
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
                        <label for="edit_description">Description *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="edit_description" name="description" rows="3" required
                                  placeholder="Description de la campagne..."></textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="edit_objective">Objectif principal *</label>
                        <textarea class="form-control @error('objective') is-invalid @enderror"
                                  id="edit_objective" name="objective" rows="2" required
                                  placeholder="Objectif principal de la campagne..."></textarea>
                        @error('objective')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_start_date">Date de début *</label>
                                <input type="datetime-local" class="form-control @error('start_date') is-invalid @enderror"
                                       id="edit_start_date" name="start_date" required>
                                @error('start_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_end_date">Date de fin</label>
                                <input type="datetime-local" class="form-control @error('end_date') is-invalid @enderror"
                                       id="edit_end_date" name="end_date">
                                @error('end_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_ecological_focus">Focus écologique *</label>
                                <select class="form-control @error('ecological_focus') is-invalid @enderror" id="edit_ecological_focus" name="ecological_focus" required>
                                    <option value="">Sélectionnez un focus écologique</option>
                                    @foreach($ecologicalFocuses as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('ecological_focus')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="edit_location">Localisation *</label>
                                <input type="text" class="form-control @error('location') is-invalid @enderror"
                                       id="edit_location" name="location" required
                                       placeholder="Localisation de la campagne...">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="edit_targets">Cibles concernées *</label>
                        <select class="form-control select2-multiple @error('targets') is-invalid @enderror"
                                id="edit_targets" name="targets[]" multiple required>
                            @foreach($targets as $target)
                                <option value="{{ $target->id }}">
                                    {{ $target->nom }}
                                    @if($target->type)
                                        - {{ App\Models\Target::getTypes()[$target->type] ?? $target->type }}
                                    @endif
                                    @if($target->secteur)
                                        / {{ App\Models\Target::getSecteurs()[$target->secteur] ?? $target->secteur }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                        @error('targets')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_budget">Budget (€)</label>
                                <input type="number" step="0.01" min="0"
                                       class="form-control @error('budget') is-invalid @enderror"
                                       id="edit_budget" name="budget"
                                       placeholder="0.00">
                                @error('budget')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_image_url">URL de l'image</label>
                                <input type="url" class="form-control @error('image_url') is-invalid @enderror"
                                       id="edit_image_url" name="image_url"
                                       placeholder="https://example.com/image.jpg">
                                @error('image_url')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="edit_status">Statut *</label>
                                <select class="form-control @error('status') is-invalid @enderror" id="edit_status" name="status" required>
                                    <option value="">Sélectionnez un statut</option>
                                    @foreach($statuses as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
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
