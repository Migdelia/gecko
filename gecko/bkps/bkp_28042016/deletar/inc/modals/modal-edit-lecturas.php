<?php $modal_item = "Lecturas" // ingresar la palabra clave de cada modal ?>
<div id="download-modal-<?php echo $modal_item ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Confirmar Descarga de Informes');?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <!-- <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre') ?></label>
                <input type="text" class="form-control" id="input_nombre<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre') ?>" value="Lorem">
              </div>
              <div class="row form-group">
                <label for="input_usuario<?php echo $modal_item ?>" class="control-label"><?php echo _('Usuario') ?></label>
                <input type="text" class="form-control" id="input_usuario<?php echo $modal_item ?>" placeholder="<?php echo _('Usuario') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_local<?php echo $modal_item ?>" class="control-label"><?php echo _('Local') ?></label>
                <input type="text" class="form-control" id="input_local<?php echo $modal_item ?>" placeholder="<?php echo _('Local') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_semana<?php echo $modal_item ?>" class="control-label"><?php echo _('Semana') ?></label>
                <input type="text" class="form-control" id="input_semana<?php echo $modal_item ?>" placeholder="<?php echo _('Semana') ?>" value="">
              </div>
            </div>
          </div> -->
          <div class="row form-group">
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 left"><?php echo _('Cancelar '); ?></button>
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Descargar '); ?></button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>