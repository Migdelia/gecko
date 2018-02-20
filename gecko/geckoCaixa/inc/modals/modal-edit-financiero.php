<?php $modal_item = "Financiero" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
          <div class="row">
            <div class="col-xs-12 col-md-12">
              <div class="row form-group">
                <!-- <label for="input_id<?php echo $modal_item ?>" class="control-label"><?php echo _('ID de usuario') ?></label> -->
                <label><?php echo _('ID de usuario') ?></label>
                <input type="text" class="form-control" id="input_id<?php echo $modal_item ?>" placeholder="<?php echo _('John Doe') ?>" >
              </div>
              <div class="row form-group">
                <label><?php echo _('Correo Electrónico') ?></label>
                <input type="text" class="form-control" id="input_mail<?php echo $modal_item ?>" placeholder="<?php echo _('Pago') ?>" >
              </div>
              <div class="row form-group">
                <label><?php echo _('Nueva contraseña') ?></label>
                <input type="text" class="form-control" id="input_pass<?php echo $modal_item ?>" placeholder="<?php echo _('Subscripción') ?>">
              </div>
            </div>
            <!-- <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre de usuario') ?></label>
                <input type="text" class="form-control" id="input_name<?php echo $modal_item ?>" placeholder="Nombre de usuario" value="">
              </div>
              <div class="row form-group">
                <label for="input_exclu<?php echo $modal_item ?>" class="control-label"><?php echo _('Exclusión') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_exclu<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Exclusión') ?><div class="ripple-container"></div></a>
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
              </div>
            </div> -->
          </div>
          <div class="row form-group">
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Editar ') . $modal_item ?></button>
            <!-- <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Resetear Contraseña') ?></button> -->
          </div>
        </form>
      </div>
    </div>
  </div>
</div>