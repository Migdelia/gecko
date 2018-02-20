<?php $modal_item = "Juego" // ingresar la palabra clave de cada modal ?>
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
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre del juego') ?></label>
                <input type="text" class="form-control" id="input_name<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre del juego') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_codigo<?php echo $modal_item ?>" class="control-label"><?php echo _('Código del juego') ?></label>
                <input type="text" class="form-control" id="input_codigo<?php echo $modal_item ?>" placeholder="<?php echo _('Código del juego') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
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