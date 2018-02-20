<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "lecturas" // ingresar la palabra clave de cada modal ?>

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
                  <i class="fa fa-eye fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo _('Informe de Lectura') ?>
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons.php"); // btns paneles ?>
              <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
              <?php include("inc/modals/modal-download-informe-cierre.php");?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <div class="row">
                      <div class="col-xs-4"><?php echo _('Fechamento Semana: '.date('d-M-Y')); ?></div>
                      <div class="col-xs-4"><?php echo _('Resposavel'). ': Juan Molina' ?></div>
                      <div class="col-xs-4"><?php echo _('Fecha Referente: '.date('d-M-Y')); ?></div>
                    </div>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table  class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align">
                              <div class="row">
                                <?php echo _('General') ?>
                              </div>
                            </th>
                            <th class="left-align" colspan="3">
                              <div class="row">
                                <div class="col-xs-4"><?php echo rand(0,100).'% '.'calabaza: '.rand(0,1500000);?></div>
                                <div class="col-xs-4"><?php echo _('Total Parcial: ').rand(0,1500000);?></div>
                                <div class="col-xs-4"><?php echo _('Total General: ').rand(0,3000000);?></div>
                              </div>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="left-align"><?php echo _('Lectura'); ?></td>
                            <td class="left-align"><?php echo rand(0,1999999); ?></td>
                            <td class="left-align"><?php echo _('Salida'); ?></td>
                            <td class="left-align"><?php echo rand(0,1999999); ?></td>
                          </tr>
                          <tr>
                            <td class="left-align"><?php echo _('Deberes Recibidos'); ?></td>
                            <td class="left-align"><?php echo rand(0,1999999); ?></td>
                            <td class="left-align"><?php echo _('Depósitos'); ?></td>
                            <td class="left-align"><?php echo rand(0,1999999); ?></td>
                          </tr>
                          <tr>
                            <td class="left-align"><?php echo _('Total Entrada'); ?></td>
                            <td class="left-align"><?php echo rand(0,1999999); ?></td>
                            <td class="left-align"><?php echo _('Valor Salida'); ?></td>
                            <td class="left-align"><?php echo rand(0,1999999); ?></td>
                          </tr>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- </div> -->

            <!-- <div class="row"> -->
            <div class="col-xs-12 col-md-6">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <?php echo _('Entradas Lecturas') ?>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table  class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align">
                              <?php echo _('Fecha') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Descripción') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Monto Efectivo') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i <6 ; $i++):?>
                            <tr>
                              <td class="left-align"><?php echo date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days'));?></td>
                              <td class="left-align">Gran Faraón</td>
                              <td class="left-align"><?php echo rand(0,1999999) ?></td>
                            </tr>
                          <?php endfor; ?>
                        </tbody>
                        <tfoot style="background-color: #0DA4E7;">
                          <tr>
                            <td colspan="2"  style="color: white">Subtotal</td>
                            <td class="left-align" style="color: white"><?php echo rand(0,1999999) ?></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-md-6">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <?php echo _('Salidas') ?>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table  class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align sort-asc">
                              <?php echo _('Fecha') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Descripción') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Monto Efectivo') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i <6 ; $i++):?>
                            <tr>
                              <td class="left-align"><?php echo date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days'));?></td>
                              <td class="left-align">Gran Faraón</td>
                              <td class="left-align"><?php echo rand(0,1999999) ?></td>
                            </tr>
                          <?php endfor; ?>
                        </tbody>
                        <tfoot style="background-color: #0DA4E7;">
                          <tr>
                            <td colspan="2" style="color: white">Subtotal</td>
                            <td class="left-align" style="color: white"><?php echo rand(0,1999999) ?></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- </div> -->

            <!-- <div class="row"> -->
            <div class="col-xs-12 col-md-6">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <?php echo _('Entradas debes recibidos') ?>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table  class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align sort-asc">
                              <?php echo _('Fecha') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Descripción') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Monto Efectivo') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i <6 ; $i++):?>
                            <tr>
                              <td class="left-align"><?php echo date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days'));?></td>
                              <td class="left-align">Gran Faraón</td>
                              <td class="left-align"><?php echo rand(0,1999999) ?></td>
                            </tr>
                          <?php endfor; ?>
                        </tbody>
                        <tfoot style="background-color: #0DA4E7;">
                          <tr>
                            <td colspan="2" style="color: white">Subtotal</td>
                            <td class="left-align" style="color: white"><?php echo rand(0,1999999) ?></td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-md-6">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <?php echo _('Formas de pago') ?>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table  class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align sort-asc">
                              <?php echo _('Fecha') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Descripción') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Monto Efectivo') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i <6 ; $i++):?>
                            <tr>
                              <td class="left-align"><?php echo date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days'));?></td>
                              <td class="left-align">Gran Faraón</td>
                              <td class="left-align"><?php echo rand(0,1999999) ?></td>
                            </tr>
                          <?php endfor; ?>
                        </tbody>
                        <tfoot style="background-color: #0DA4E7;">
                          <tr>
                            <td colspan="2" style="color: white">Num Doc</td>
                            <td class="left-align" style="color: white"><?php echo rand(0,1999999) ?></td>
                          </tr>
                        </tfoot>
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
  </div>
</div>
</div>
</body>
