<?php $modal_item = "Juego" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos del nuevo juego.</p>
        <form class="form-horizontal" method="post" action="functions/addJogo.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('ID Juego') ?></label>
                <input type="text" class="form-control" id="input_id_<?php echo $modal_item ?>" name="input_id_<?php echo $modal_item ?>" placeholder="<?php echo _('ID Juego') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_codigo<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo del juego') ?></label>
                <input type="text" class="form-control" id="input_codigo_<?php echo $modal_item ?>" name="input_codigo_<?php echo $modal_item ?>" placeholder="<?php echo _('Codigo del juego') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre del juego') ?></label>
                <input type="text" class="form-control" id="input_name_<?php echo $modal_item ?>" name="input_name_<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre del juego') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_codigo<?php echo $modal_item ?>" class="control-label"><?php echo _('Porcentaje Juego') ?></label>
                <input type="text" class="form-control" id="input_pct_<?php echo $modal_item ?>" name="input_pct_<?php echo $modal_item ?>" placeholder="<?php echo _('Porcentaje Juego') ?>" value="">
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