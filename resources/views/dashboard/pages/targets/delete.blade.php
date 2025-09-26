<!-- Modal de suppression -->
<div class="modal fade" id="deleteTargetModal" tabindex="-1" role="dialog" aria-labelledby="deleteTargetModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTargetModalLabel">Confirmer la suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="deleteTargetForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer la cible :</p>
                    <p class="font-weight-bold target-name"></p>
                    <p class="text-danger">
                        <i class="mdi mdi-alert-circle-outline"></i>
                        Cette action est irréversible !
                    </p>
                    <div class="alert alert-warning" id="campaignsWarning" style="display: none;">
                        <i class="mdi mdi-alert"></i>
                        <span id="campaignsCount"></span> campagne(s) associée(s) à cette cible seront affectées.
                    </div>
                    <div class="alert alert-danger" id="deleteWarning" style="display: none;">
                        <i class="mdi mdi-alert"></i>
                        Impossible de supprimer cette cible car elle est associée à des campagnes.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger" id="deleteButton">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>
