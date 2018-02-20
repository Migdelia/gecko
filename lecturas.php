<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "lecturas" // ingresar la palabra clave de cada modal ?>

    <div class="container-fluid innpage-<?php echo $filenameID;?>">
      <div class="row">
        <?php include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
      </div>
      <div class="row">
        <?php include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
        <div class="inner-content col-xs-12 col-sm-9">
          <div class="page<?php echo $filenameID; ?>">
            <div class="row">
              <div class="col-xs-12 col-lg-4">
                <h3 class="main-title">
                  <span class="fa-stack fa-md">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-eye fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Lectura') ?>
                  <a href="#" class="btn" style="margin:0 0 0 10px;"><?php echo _('Ver Todos') ?></a>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-8">
                <?php include("inc/buttons.php"); // btns paneles ?>
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
                            <th class="left-align sort-none">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </th>
                            <th class="center-align">
                              <?php echo _('Nombre') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Fecha') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Acciones') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="left-align">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </td>


                            <td class="center-align">Informe 08</td>

                            <td class="center-align">02 - 03 - 2010</td>

                            <td class="center-align">
                              <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Descargar') ?></a>
                              <!-- <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a> -->
                            </td>
                          </tr>
                          <tr>
                            <td class="left-align">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </td>

                            <td class="center-align">Informe 01</td>

                            <td class="center-align">02 - 03 - 2010</td>

                            <td class="center-align">
                              <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Descargar') ?></a>
                              <!-- <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a> -->
                            </td>
                          </tr>
                          <tr>
                            <td class="left-align">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </td>


                            <td class="center-align">Informe 02</td>

                            <td class="center-align">02 - 03 - 2010</td>

                            <td class="center-align">
                              <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Descargar') ?></a>
                              <!-- <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a> -->
                            </td>
                          </tr>
                          <tr>
                            <td class="left-align">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </td>


                            <td class="center-align">Informe 03</td>

                            <td class="center-align">02 - 03 - 2010</td>

                            <td class="center-align">
                              <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Descargar') ?></a>
                              <!-- <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a> -->
                            </td>
                          </tr>
                          <tr>
                            <td class="left-align">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </td>


                            <td class="center-align">Informe 04</td>

                            <td class="center-align">02 - 03 - 2010</td>

                            <td class="center-align">
                              <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Descargar') ?></a>
                              <!-- <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a> -->
                            </td>
                          </tr>
                          <tr>
                            <td class="left-align">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </td>


                            <td class="center-align">Informe 07</td>

                            <td class="center-align">02 - 03 - 2010</td>

                            <td class="center-align">
                              <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Descargar') ?></a>
                              <!-- <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a> -->
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
