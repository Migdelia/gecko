<?php $modal_item = "Maquina" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <h6><?php echo _('Editar Máquina') ?></h6>
              </div>
              <div class="row form-group">
                <label><?php echo _('Número de máquina') ?></label>
                <input type="text" class="form-control" id="input_num<?php echo $modal_item ?>" placeholder="<?php echo _('Número de máquina') ?>" value="">
              </div>
              <div class="row form-group">
                <label><?php echo _('Modelo máquina') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_mod<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Modelo máquina') ?><div class="ripple-container"></div></a>
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
                <label><?php echo _('Interface') ?></label>
                <!-- <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo _('Interface') ?></label> -->
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_interface<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Interface') ?><div class="ripple-container"></div></a>
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
                <label><?php echo _('Local') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_local<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Local') ?><div class="ripple-container"></div></a>
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
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <h6><?php echo _('Registros especiales') ?></h6>
              </div>
              <div class="row form-group">
                <label><?php echo _('Máquina % especial') ?></label>
                <input type="text" class="form-control" id="input_espec<?php echo $modal_item ?>" placeholder="<?php echo _('Máquina % especial') ?>" value="">
              </div>
              <div class="row form-group">
                <div class="checkbox">
                  <?php echo _('Máquina de socio') ?>
                  <label><input type="checkbox"><span class="checkbox-material"></span></label>
                </div>
              </div>
              <div class="row form-group">
                <label><?php echo _('Observaciones de máquina') ?></label>
                <input type="text" class="form-control" id="input_obs<?php echo $modal_item ?>" placeholder="<?php echo _('Observaciones de máquina') ?>" value="">
              </div>
              <div class="row form-group">
                <label><?php echo _('Responsable') ?></label>
                <input type="text" class="form-control" id="input_resp<?php echo $modal_item ?>" placeholder="<?php echo _('Responsable') ?>" value="">
              </div>
              <div class="row form-group">
                <label><?php echo _('Observaciones de máquina') ?></label>
                <input type="text" class="form-control" id="input_obsm<?php echo $modal_item ?>" placeholder="<?php echo _('Observaciones de máquina') ?>" value="">
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Crear Nueva Máquina') ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>