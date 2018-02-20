<?php $modal_item = "Ciudad" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nueva ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel in dolorum voluptatibus necessitatibus atque.</p>
        <form class="form-horizontal">
          <div class="row form-group">
            <label for="input<?php echo $modal_item ?>" class="col-md-2 control-label"><?php echo _('Ingresa ') . $modal_item ?></label>
            <div class="col-xs-12 col-lg-8 col-lg-offset-2">
              <input type="text" class="form-control" id="input<?php echo $modal_item ?>" placeholder="<?php echo _('Ingresa ') . $modal_item ?>" value="">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12 col-lg-8 col-lg-offset-2">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Agregar Nueva ') . $modal_item ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>