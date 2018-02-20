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
                <a href="#" class="btn" style="margin:0 0 0 10px;"><?php echo _('Ver Todos') ?></a>
              </h3>
            </div>
            <!-- <div class="col-xs-12 col-lg-3">
              <div class="panel">
                <div class="panel-heading" style="min-height: 37px; padding: 0px; width: 280px;">

                  <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                  </div>
                </div>
              </div>
            </div> -->
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons.php"); // btns paneles ?>
              <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
              <?php include("inc/modals/modal-download-informe-cierre.php"); // modal para agregar contenido ?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <!-- dropdown de selects -->
                    <div class="btn-group white-btn">
                      <?php include("inc/dropdown-informe.php"); // btns acciones másivas ?>
                    </div>
                    <?php echo _('1/10 Resultados '); ?>
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
                    <table id="datatable1" class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="left-align">
                            <?php echo _('Informe') ?>
                          </th>
                          <th class="left-align" colspan="3">
                            <?php echo _('Fecha') ?>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php for ($i=0; $i < 10; $i++):?>
                          <tr>
                            <td class="left-align">
                              <?php echo _('Informe de Lectura ').rand(0,20);?>
                            </td>
                            <td class="left-align">
                              <?php echo date('Y-m-d', strtotime( '+'.mt_rand(0,30).' days')); ?>
                            </td>
                            <td></td>
                            <td class="right-align">
                              <!-- <div class="row"> -->
                              <!-- <div class="btn-group" role="group" aria-label="Justified button group"> -->
                              <!-- <div class="col s6 m6 l6"> -->
                              <a href="#" class="btn btn-default" role="button" style="color: white" data-toggle="modal" data-target="#download-informe-cierre-modal"> <?php echo _('Descargar') ?></a>


                              <!-- </div> -->
                              <!-- <div class="col s6 m6 l6"> -->
                              <a href="ver-informe-cierre.php" class="btn btn-default" role="button" style="color: white"><?php echo _('Ver') ?></a>
                              <!-- </div> -->
                              <!-- </div> -->
                              <!-- </div> -->
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
  </body>
