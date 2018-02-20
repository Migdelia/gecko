<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "perfil" // ingresar la palabra clave de cada modal ?>

  <div class="container-fluid innpage-<?php echo $filenameID; ?>">
    <div class="row">
      <?php include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
    </div>
    <div class="row">
      <?php include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
      <div class="inner-content col-xs-12 col-sm-9">
        <div class="page<?php echo $filenameID; ?>">
          <div class="row">
            <div class="col-xs-12 col-lg-6">
              <h3 class="main-title">
                <span class="fa-stack fa-md">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo $filenameID; ?>
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="panel">
                <div class="panel-heading">
                </div>

                <div class="panel-body">
                  <div class="row">
                    <div class="list-group">
                      <div class="list-group-item">
                        <div class="row-picture">
                          <a href="#" data-toggle="modal" data-target="#edit-fotoperfil">
                            <img class="circle big-avatar" src="<?php echo $imgurl ?>/default.jpg" alt="icon">
                          </a>
                        </div>
                        <div class="row-content">
                          <h2 class="list-group-item-heading">Perfil</h2>
                          <h2 class="list-group-item-heading">Fernando Campos</h2>
                          <p class="list-group-item-text">Admin</p>
                        </div>
                      </div>
                    </div>
                    <div class="input-wrap">
                      <div class="col-xs-12 col-md-6">
                        <!-- input formulario -->
                        <form id="userinfo" class="campos-usuario">

                          <div class="form-group">
                            <div class="input-group">
                              <div class="col-xs12 col-md-6">
                                <input type="text" id="addon1" class="form-control"  placeholder="<?php echo _('Nombre') ?>">
                              </div>
                              <div class="col-xs12 col-md-6">
                                <span class="input-group-btn">
                                  <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#edit-name"><?php echo _('Cambiar Nombre') ?><div class="ripple-container"></div></button>
                                </span>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="input-group">
                              <div class="col-xs12 col-md-6">
                                <input type="mail" class="form-control" placeholder="<?php echo _('Correo electrónico') ?>">
                              </div>
                              <div class="col-xs12 col-md-6">
                                <span class="input-group-btn">
                                  <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#edit-mail"><?php echo _('Cambiar Correo') ?><div class="ripple-container"></div></button>
                                </span>
                              </div>
                            </div>
                          </div>

                          <div class="form-group">
                            <div class="input-group">
                            <div class="col-xs12 col-md-6">
                              <input type="text" id="addon1" class="form-control"  placeholder="<?php echo _('Contraseña') ?>">
                              </div>
                              <div class="col-xs12 col-md-6" >
                              <span class="input-group-btn">
                                <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#edit-password"><?php echo _('Cambiar Contraseña') ?><div class="ripple-container"></div></button>
                              </span>
                              </div>
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="col-xs-12">
                        <a href="#" class="btn btn-lg right" ><?php echo _('Guardar cambios') ?></a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Foto perfil -->
  <div id="edit-fotoperfil" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5><?php echo _('Cambiar Foto perfil') ?></h5>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="row form-group">
                  <div class="input-group">
                    <input type="text" readonly id="addon1" class="form-control" placeholder="<?php echo _('Seleccionar imagen') ?>">
                    <input type="file" multiple id="atachfile">
                  </div>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Guardar ') ?></button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- Nombre -->
  <div id="edit-name" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5><?php echo _('Cambiar Nombre de Usuario') ?></h5>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="row form-group">
                  <label for="input_name" class="control-label"><?php echo _('Cambiar nombre') ?></label>
                  <input type="text" class="form-control" id="input_name" placeholder="<?php echo _('Cambiar nombre') ?>" value="">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Guardar ') ?></button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- Correo -->
  <div id="edit-mail" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5><?php echo _('Cambiar Correo Electrónico del Usuario') ?></h5>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="row form-group">
                  <label for="input_name" class="control-label"><?php echo _('Cambiar correo') ?></label>
                  <input type="text" class="form-control" id="input_name" placeholder="<?php echo _('Cambiar correo') ?>" value="">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Guardar ') ?></button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
  <!-- Contraseña -->
  <div id="edit-password" class="modal fade" tabindex="-1" style="display: none;">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
          <h5><?php echo _('Cambiar Contraseña') ?></h5>
        </div>
        <div class="modal-body">
          <form class="form-horizontal">
            <div class="row">
              <div class="col-xs-12 col-md-6">
                <div class="row form-group">
                  <label for="input_pass" class="control-label"><?php echo _('Contraseña actual') ?></label>
                  <input type="text" class="form-control" id="input_pass" placeholder="<?php echo _('Contraseña actual') ?>" value="">
                </div>
                <div class="row form-group">
                  <label for="input_pass2" class="control-label"><?php echo _('Nueva Contraseña') ?></label>
                  <input type="text" class="form-control" id="input_pass2" placeholder="<?php echo _('Nueva Contraseña') ?>" value="">
                </div>
                <div class="row form-group">
                  <label for="input_pass3" class="control-label"><?php echo _('Confirmar Nueva Contraseña') ?></label>
                  <input type="text" class="form-control" id="input_pass3" placeholder="<?php echo _('Confirmar Nueva Contraseña') ?>" value="">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Guardar ') ?></button>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</body>
</html>