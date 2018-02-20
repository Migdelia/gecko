<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <div class="container-fluid innpage-<?php echo $filenameID; ?>">
      <div class="row">
        <?php include("inc/navbar-cajas.php"); // primera sección de contenido, barra de navegación ?>
      </div>
      <div class="row">
        <?php include("inc/sidebar-cajas.php"); // segunda sección de contenido, el menú lateral ?>
        <div class="inner-content col-xs-12 col-sm-10">
            <div class="row">
              <div class="col-xs-12 col-lg-6">
                <h3 class="main-title">
                  <span class="fa-stack fa-md">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-clock-o fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Controles') ?>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-6">
                <?php include("inc/buttons.php"); // btns paneles ?>
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
                            <th>
                              <?php echo _('Id') ?>
                            </th>
                            <th>
                              <?php echo _('Game ID') ?>
                            </th>
                            <th>
                              <?php echo _('Pago Jackpot') ?>
                            </th>
                            <th>
                              <?php echo _('Pago Acumulado') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>1414</td>
                            <td>9</td>
                            <td>$123412342</td>
                            <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
                          </tr>
                          <tr>
                              <td>1414</td>
                              <td>9</td>
                              <td>$123412342</td>
                              <td>$353434643</td>
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
    <?php include("inc/modals/modal-cajas-opciones-caja-historico.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-orden.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-actualizar.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-entradasalida.php");?>
    <?php include("inc/modals/modals-cajas-maquina-estados.php");?>
  </body>
</html>
