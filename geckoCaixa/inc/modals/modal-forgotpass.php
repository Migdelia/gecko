<div id="forgot-modal" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal">
            <div class="valign-wrapper">
              <div class="col-xs-12 col-md-4 col-md-offset-4 logo-login valign">
                <img src="img/logo-login.png" alt="gecko" class="img-responsive">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-md-2 control-label"><?php echo _('Ingrese su correo electrónico, para enviar una nueva contraseña.') ?></label>
              <div class="col-xs-12">
                <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo _('Correo electrónico') ?>" value="">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <button type="submit" class="btn btn-lg btn-raised right"><?php echo _('Enviar contraseña') ?></button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>