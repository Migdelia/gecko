<?php $modal_item = "Local" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
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
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo de local') ?></label>
                <input type="text" class="form-control" id="input_tipo<?php echo $modal_item ?>" placeholder="<?php echo _('Tipo de local') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>
                <input type="text" class="form-control" id="input_gerente<?php echo $modal_item ?>" placeholder="<?php echo _('Gerente') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>
                <input type="text" class="form-control" id="input_operador<?php echo $modal_item ?>" placeholder="<?php echo _('Operador') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_pctual<?php echo $modal_item ?>" class="control-label"><?php echo _('Porcentual local') ?></label>
                <input type="text" class="form-control" id="input_pctual<?php echo $modal_item ?>" placeholder="<?php echo _('Porcentual local') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre Operador') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_gerente<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Nombre Operador') ?><div class="ripple-container"></div></a>
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
                <label for="input_pctelocal<?php echo $modal_item ?>" class="control-label"><?php echo _('Porcentual local') ?></label>
                <input type="text" class="form-control" id="input_pctelocal<?php echo $modal_item ?>" placeholder="<?php echo _('Porcentual local') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_ocomision<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión operador') ?></label>
                <input type="text" class="form-control" id="input_ocomision<?php echo $modal_item ?>" placeholder="<?php echo _('Comisión operador') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_gcomision<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión gerente') ?></label>
                <input type="text" class="form-control" id="input_gcomision<?php echo $modal_item ?>" placeholder="<?php echo _('Comisión gerente') ?>" value="">
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