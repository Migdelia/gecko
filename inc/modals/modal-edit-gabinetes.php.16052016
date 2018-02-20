<?php $modal_item = "Gabinetes" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditGab" method="post" action="functions/alteraGabinete.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_id<?php echo $modal_item ?>" class="control-label"><?php echo _('Id Gabinete') ?></label>
                <input type="text" class="form-control" id="input_id_<?php echo $modal_item ?>" placeholder="<?php echo _('Id Gabinete') ?>" value="" readonly="readonly">
              </div>            
              <div class="row form-group">
                <label for="input_desc<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripcion Gabinete') ?></label>
                <input type="text" class="form-control" id="input_desc_<?php echo $modal_item ?>" placeholder="<?php echo _('Descripcion Gabinete') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_cod<?php echo $modal_item ?>" class="control-label"><?php echo _('Cod Gabinete') ?></label>
                <input type="text" class="form-control" id="input_cod_<?php echo $modal_item ?>" placeholder="<?php echo _('Cod Gabinete') ?>" value="" readonly="readonly">
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
