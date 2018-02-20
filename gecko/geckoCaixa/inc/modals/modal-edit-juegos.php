<?php $modal_item = "Juego" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label><?php echo _('Nombre del juego') ?></label>
                <input type="text" class="form-control" id="input_nombre<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre') ?>" value="29">
              </div>
              <div class="row form-group">
                <label><?php echo _('Código del juego') ?></label>
                <input type="text" class="form-control" id="input_code<?php echo $modal_item ?>" placeholder="<?php echo _('Fecha de Expiración') ?>" value="70050">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
            </div>
          </div>
          <div class="row form-group">
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Guardar ') . $modal_item ?></button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>