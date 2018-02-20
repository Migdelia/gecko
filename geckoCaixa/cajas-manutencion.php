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
                    <i class="fa fa-cogs fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Manutencion') ?>
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
                    <div class="table-responsive manutencion">
                      <table id="datatable" class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th></th>
                            <th><?php echo _('Id') ?></th>
                            <th><?php echo _('Imagen') ?></th>
                            <th><?php echo _('Maquina') ?></th>
                            <th><?php echo _('Denominacion') ?></th>
                            <th><?php echo _('Tipo') ?></th>
                            <th><?php echo _('% Bingo') ?></th>
                            <th><?php echo _('Min Bingo') ?></th>
                            <th><?php echo _('Max Bingo') ?></th>
                            <th><?php echo _('Fam') ?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>
                                <div class="checkbox">
                                    <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                </div>
                            </td>
                            <td>996</td>
                            <td><img src="img/4.png" alt="" /></td>
                            <td>vmld-1562</td>
                            <td>94.000%</td>
                            <td>Server</td>
                            <td> - </td>
                            <td>350</td>
                            <td>400</td>
                            <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
                          </tr>
                          <tr>
                              <td>
                                  <div class="checkbox">
                                      <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                              </td>
                              <td>996</td>
                              <td><img src="img/4.png" alt="" /></td>
                              <td>vmld-1562</td>
                              <td>94.000%</td>
                              <td>Server</td>
                              <td> - </td>
                              <td>350</td>
                              <td>400</td>
                              <td>Si</td>
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
