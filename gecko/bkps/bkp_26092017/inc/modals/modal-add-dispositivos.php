<?php $modal_item = "Dispositivo" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel in dolorum voluptatibus necessitatibus atque.</p>
        <form class="form-horizontal">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('ID de la Máquina') ?></label>
                <input type="text" class="form-control" id="input_idmaq<?php echo $modal_item ?>" placeholder="<?php echo _('ID de la Máquina') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_expdate<?php echo $modal_item ?>" class="control-label"><?php echo _('Fecha de Expiración') ?></label>
                <input type="text" class="form-control" id="input_expdate<?php echo $modal_item ?>" placeholder="<?php echo _('Fecha de Expiración') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_periodo<?php echo $modal_item ?>" class="control-label"><?php echo _('Periodo') ?></label>
                <input type="text" class="form-control" id="input_periodo<?php echo $modal_item ?>" placeholder="<?php echo _('Periodo') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_gameid<?php echo $modal_item ?>" class="control-label"><?php echo _('ID del juego') ?></label>
                <input type="text" class="form-control" id="input_gameid<?php echo $modal_item ?>" placeholder="<?php echo _('ID del juego') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_ultact<?php echo $modal_item ?>" class="control-label"><?php echo _('Última Actualización') ?></label>
                <input type="text" class="form-control" id="input_ultact<?php echo $modal_item ?>" placeholder="<?php echo _('Última Actualización') ?>" value="">
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Crear Nuevo ') . $modal_item ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>