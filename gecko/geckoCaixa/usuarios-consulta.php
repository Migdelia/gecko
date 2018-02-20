<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "usuarios" // ingresar la palabra clave de cada modal ?>

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
                  <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo _('Usuarios') ?>
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
              <div class="button-wrap">
                <a href="#" class="btn"><?php echo _('Exportar Excel') ?></a>
                <a href="#" class="btn"><?php echo _('Exportar PDF') ?></a>
                <a href="#" class="btn" data-toggle="modal" data-target="#add-modal-Usuarios"><i class="fa fa-plus"></i> <?php echo _('Agregar usuario') ?></a>
              </div>
              <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <!-- dropdown de selects -->
                    <div class="btn-group white-btn">
                      <?php include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                    </div>
                    <!-- input formulario de busqueda -->
                    <form id="table-1" class="white-form right">
                      <div class="form-group">
                        <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                      </div>
                    </form>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="table-responsive">
                    <table id="datatable" class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="center-align sort-none">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </th>
                          <th class="center-align">
                            <?php echo _('Nombre') ?>
                          </th>
                          <th class="center-align">
                            <?php echo _('Nivel') ?>
                          </th>
                          <!-- <th class="center-align" colspan="3">
                            <a href="#" style="padding-right:10%;"><?php echo _('Acciones') ?></a>
                          </th> -->
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#"data-toggle="modal" data-target="#view-modal-Usuarios">Magnam quibusdam laboriosam .</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align">
                            <div class="row">
                              <div class=" btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor.</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor.</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor.</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum doloria quo!</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor?</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolora></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum doloricabo!</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor/a></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor!</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolorollitia.</a></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor?</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>
                          <td class="center-align">
                            <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor.</a>
                          </td>
                          <td class="center-align">Operador</td>
                          <!-- <td class="right-align" colspan="3">
                            <div class="row">
                              <div class="btn-group" role="group" aria-label="Justified button group">
                                <a href="#" class="text" data-toggle="modal" data-target="#view-modal-Usuarios">Lorem ipsum dolor></a>
                              </div>
                            </div>
                          </td> -->
                        </tr>
                        <tr>
                          <td class="center-align" colspan="7">
                            <div class="col-xs-12">
                              <i class="fa fa-spinner fa-spin fa-2x"></i>
                            </div>
                            <div class="col-xs-12">
                              <p class="loading"><?php echo ('Cargando Resultados') ?></p>
                            </div>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
  <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
</body>
</html>