<?php $modal_item = "Lecturas" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel in dolorum voluptatibus necessitatibus atque.</p>
        <form class="form-horizontal">
          <div class="row">
            <div class="col-xs-12 col-lg-6">
              <div class="row form-group">
                <label for="input_selec<?php echo $modal_item ?>" class="control-label"><?php echo _('Seleccionar local') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_selec<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Seleccionar local') ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#" class="mass-act"><?php echo _('Action 1') ?></a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="#" class="mass-act"><?php echo _('Action 2') ?></a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="#" class="mass-act"><?php echo _('Action 3') ?></a>
                  </li>
                </ul>
              </div>
              <div class="row form-group">
                <label for="input_busq<?php echo $modal_item ?>" class="col-md-2 control-label"><?php echo _('Buscar local') ?></label>
                <input type="text" class="form-control" id="input_busq<?php echo $modal_item ?>" placeholder="<?php echo _('Buscar local') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12">
              <div class="row form-group">
                <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Siguiente') ?></button>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>