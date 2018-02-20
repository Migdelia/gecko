<?php $modal_item = "Pago" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
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
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre de ') . $modal_item ?></label>
                <input type="text" class="form-control" id="input_name<?php echo $modal_item ?>" placeholder="<?php echo _('Ingresar monto nuevo ') . $modal_item ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_pass<?php echo $modal_item ?>" class="control-label"><?php echo _('Contraseña de ') . $modal_item ?></label>
                <input type="text" class="form-control" id="input_pass<?php echo $modal_item ?>" placeholder="<?php echo _('Fecha de inicio de ') . $modal_item ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_mail<?php echo $modal_item ?>" class="control-label"><?php echo _('Email de ') . $modal_item ?></label>
                <input type="text" class="form-control" id="input_mail<?php echo $modal_item ?>" placeholder="<?php echo _('Fecha de término ') . $modal_item ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_log<?php echo $modal_item ?>" class="control-label"><?php echo _('Login de ') . $modal_item ?></label>
                <input type="text" class="form-control" id="input_log<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre ') . $modal_item ?>" value="">
              </div>
              <!-- <div class="row form-group">
                <label for="input_nivel<?php echo $modal_item ?>" class="control-label"><?php echo _('Nivel de ') . $modal_item ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_nivel<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Nivel de ') . $modal_item ?><div class="ripple-container"></div></a>
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
              </div> -->
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