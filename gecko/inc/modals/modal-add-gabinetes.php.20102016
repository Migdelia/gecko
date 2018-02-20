<?php $modal_item = "Gabinete" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos del nuevo gabinete.</p>
        <form class="form-horizontal" method="post" action="functions/addGabinete.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripcion') ?></label>
                <input type="text" class="form-control" id="input_descricao_<?php echo $modal_item ?>" name="input_descricao_<?php echo $modal_item ?>" placeholder="<?php echo _('Descripcion') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo') ?></label>
                <input type="text" class="form-control" id="input_cod_<?php echo $modal_item ?>" name="input_cod_<?php echo $modal_item ?>" placeholder="<?php echo _('Codigo') ?>" value="">
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