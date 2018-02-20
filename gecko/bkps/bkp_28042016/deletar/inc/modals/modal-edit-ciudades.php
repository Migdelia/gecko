<?php $modal_item = "Ciudad" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
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
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre') ?></label>
                <input type="text" class="form-control" id="input_nombre<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre') ?>" value="Lorem">
              </div>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>
                <input type="text" class="form-control" id="input_operador<?php echo $modal_item ?>" placeholder="<?php echo _('Operador') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>
                <input type="text" class="form-control" id="input_gerente<?php echo $modal_item ?>" placeholder="<?php echo _('Gerente') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo') ?></label>
                <input type="text" class="form-control" id="input_tipo<?php echo $modal_item ?>" placeholder="Tipo" value="">
              </div>
              <div class="row form-group">
                <label for="input_maquina<?php echo $modal_item ?>" class="control-label"><?php echo _('Máquina de local') ?></label>
                <input type="text" class="form-control" id="input_maquina<?php echo $modal_item ?>" placeholder="Máquina de local" value="VM-900">
              </div>
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