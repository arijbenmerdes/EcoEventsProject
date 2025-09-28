<!-- Modal de suppression -->
<div class="modal fade" id="deleteCampaignModal" tabindex="-1" role="dialog" aria-labelledby="deleteCampaignModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteCampaignModalLabel">Confirmer la suppression</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" id="deleteCampaignForm">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>Êtes-vous sûr de vouloir supprimer la campagne :</p>
                    <p class="font-weight-bold campaign-title"></p>
                    <p class="text-danger">
                        <i class="mdi mdi-alert-circle-outline"></i>
                        Cette action est irréversible !
                    </p>
                    <div class="alert alert-warning">
                        <i class="mdi mdi-alert"></i>
                        Toutes les données associées à cette campagne seront également supprimées.
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>
