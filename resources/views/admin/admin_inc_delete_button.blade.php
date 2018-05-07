<button type="button" onclick="jQuery('#modal-confirm-delete').modal('show');" class="btn btn-danger pull-right"><i class="glyphicon glyphicon-remove"></i> Elimina</button>

<div class="modal fade" id="modal-confirm-delete" aria-hidden="true" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Eliminazione record</h4>
      </div>
      <div class="modal-body">
        Confermi di voler eliminare in maniera definitiva ed irreversibile il record?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Annulla</button>
        <button type="button" class="btn btn-primary" onclick="jQuery('#record_delete').submit();">Conferma</button>
      </div>
    </div>
  </div>
</div>