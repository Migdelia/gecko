<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "maquinas" // ingresar la palabra clave de cada modal ?>

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
                    <i class="fa fa-map-pin fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Máquinas') ?>
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
                    <div class="table-responsive">
                      <table id="datatable" class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align sort-none">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </th>
                            <th class="left-align">
                              <?php echo _('Máquinas') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Local') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Interface') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Responsable') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Acciones') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php for ($i=0; $i <10 ; $i++):?>
                          <tr>
                            <td class="left-align">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </td>
                            <td class="left-align">C-Fruit</td>
                            <td class="left-align">Lorem</td>
                            <td class="left-align">5555</td>
                            <td class="left-align">Ipsum Sitamet</td>
                            <td class="left-align">


                            <div class="row">
                                <div class="btn-group" role="group" aria-label="Justified button group">
                                  <a style="width: 80px;" href="#" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>"><?php echo _('Editar') ?></a>
                              <a style="width: 80px;" href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a>
                                </div>
                              </div>


                            <!--   <div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
                              <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>"><?php echo _('Editar') ?></a>
                              <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>"><?php echo _('Ver') ?></a> -->
                            </div>
                            </td>
                          </tr>
                          <?php endfor;?>
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