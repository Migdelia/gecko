<div class="container">
  <div class="row log-wrap vhAttr valign-wrapper">
    <div class="valign col-xs-12 col-md-6 col-md-offset-3 col-md-8 col-md-offset-2">
      <div class="well login-component sombra-cuadrada">
        <form class="form-horizontal" action="home.php" method="get">
            <div class="valign-wrapper">
              <div class="logo-login valign">
                <img src="<?php echo $imgurl ?>/logo-login.png" alt="gecko" class="img-responsive">
              </div>
            </div>
            <div class="form-group has-error">
              <label for="inputEmail" class="col-md-2 control-label"><?php echo _('Correo electrónico') ?></label>
              <div class="col-xs-12">
                <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo _('Correo electrónico') ?>" value="">
              </div>
            </div>
            <div class="form-group">
              <label for="inputPassword" class="col-md-2 control-label"><?php echo _('Contraseña') ?></label>
              <div class="col-xs-12">
                <input type="password" class="form-control" id="inputPassword" placeholder="<?php echo _('Contraseña') ?>" value="">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <a href="#" class="forgot" data-toggle="modal" data-target="#forgot-modal"><?php echo _('Olvidé mi contraseña') ?></a>
              </div>
            </div>

            <div class="form-group">
              <div class="col-xs-12">
                <button type="submit" formaction="home.php" class="btn btn-default btn-lg btn-block btn-raised"><?php echo _('Ingresa') ?></button>
              </div>
            </div>
        </form>
      </div>
    </div>
    <div class="bottomfringe"></div>
  </div>
</div>

<?php include("inc/modals/modal-forgotpass.php"); // modal recuperar contraseña ?>