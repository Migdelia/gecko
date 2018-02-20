<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "locales" // ingresar la palabra clave de cada modal ?>

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
                  <i class="fa fa-building-o fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo _('Locales') ?>
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
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
                  <div class="col-xs-12 col-sm-9 col-md-8">
                    <div class="table-responsive">
                      <table  id ="datatable" class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align sort-none">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </th>
                            <th class="left-align sort-asc">
                              <?php echo _('Nombre') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Operador') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Gerente') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Tipo') ?>
                            </th>
                            <th class="left-align" style="width: 160px;">
                              <?php echo _('Acciones') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i < 10 ; $i++): ?>
                            <tr>
                              <td class="left-align">
                                <div class="checkbox">
                                  <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                </div>
                              </td>
                              <td class="left-align">Lorem</td>
                              <td class="left-align">Operador</td>
                              <td class="left-align">Gerente</td>
                              <td class="left-align">Tipo</td>
                              <td class="left-align">
                                <div class="row" style="margin-bottom: 0px;">
                                  <div class="btn-group button-wrap" role="group" aria-label="Justified button group" style="float: initial">
                                  <div class="col s6 left-align">
                                      <a href="#" class="btn" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>"><?php echo _('Editar') ?></a>
                                    </div>
                                    <div class="col s6 right-align">
                                      <a href="#" class="btn" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a>
                                    </div>
                                  </div>
                                </div>
                              </td>

                            </tr>
                          <?php endfor;  ?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-3 col-md-4">
                    <div class="map">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3329.239360691567!2d-70.60857748420987!3d-33.443069904520705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662cf9c694c61c1%3A0x7147910d01e8afb5!2sJulio+Nieto+2005%2C+Providencia%2C+Regi%C3%B3n+Metropolitana!5e0!3m2!1ses-419!2scl!4v1450898500000" width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen></iframe>
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

  <?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
  <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
</body>
</html>