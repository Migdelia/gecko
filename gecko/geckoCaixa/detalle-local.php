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

            <div class="col-xs-12 col-lg-2">
              <h3 class="main-title">
                <span class="fa-stack fa-md">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-building-o fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo _('Locales') ?>
              </h3>
            </div>

            <div class="col-xs-12 col-lg-4">
              <div class="panel">
                <div class="panel-heading">
                  <?php echo _('1/10 Resultados '); ?>
                  <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                    <a href="#" class="btn center-align" style="width: 130px; padding-left: 18px"><?php echo _('Cargar Todos') ?></a>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons.php"); // btns paneles ?>
              <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-md-8">
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
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="table-responsive">
                      <table id="" class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align sort-asc">
                              <?php echo _('Código') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Rol de Entrada') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Bruto') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Rol de Salida') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Premio') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Subtotal') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('% Local') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Total') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="left-align"><?php echo "SKU-". rand(100, 999); ?></td>
                            <!-- <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td> -->
                            <td>
                              <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td>
                            <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo rand(0, 100). "%"; ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>

                        <tr>
                            <td class="left-align"><?php echo "SKU-". rand(100, 999); ?></td>
                            <!-- <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td> -->
                            <td>
                              <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td>
                            <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo rand(0, 100). "%"; ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>

                        <tr>
                            <td class="left-align"><?php echo "SKU-". rand(100, 999); ?></td>
                            <!-- <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td> -->
                            <td>
                              <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td>
                            <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo rand(0, 100). "%"; ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>

                        <tr>
                            <td class="left-align"><?php echo "SKU-". rand(100, 999); ?></td>
                            <!-- <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td> -->
                            <td>
                              <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td>
                            <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo rand(0, 100). "%"; ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>

                        <tr>
                            <td class="left-align"><?php echo "SKU-". rand(100, 999); ?></td>
                            <!-- <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td> -->
                            <td>
                              <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td>
                            <div class="input-group">
                                <div class="row">
                                  <div class="col s12 m12 l12">
                                    <input type="number" class="form-control col-xs-12 col-md-12" placeholder="<?php echo "$ ". rand(0, 9999); ?>">
                                  </div>
                                </div>
                                <div class="row">
                                  <div class="col s10 ">
                                    <?php echo "$ ". rand(0, 9999); ?>
                                  </div>
                                  <div class="col s2">
                                  <a href="#" class"btn btn-xs btn-default" style="color: black"><i class="material-icons">vertical_align_top</i></a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                          <td class="center-align"><?php echo rand(0, 100). "%"; ?></td>
                          <td class="center-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>

                </div>
              </div>
            </div>

            <div class="col-xs-12 col-md-4">

              <div class="panel" >
                <div class="panel-body">

                  <div class="table-responsive">
                    <table class="table  table-hover">
                      <thead>
                        <tr>
                          <th class="left-align sort-asc">
                            <?php echo _('Totalizadores lançamentos') ?>
                          </th>
                          <th class="right-align">Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="left-align"><?php echo _('Efectivo'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Deve'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Despesas'); ?></td>
                          <td class="right-align"><a href="#" class="btn btn-raised btn-sm" data-toggle="#" data-target="#"><?php echo _('Editar'); ?></a></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('TOTAL'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>

                  <div class="table-responsive">
                    <table class="table  table-hover">
                      <thead>
                        <tr>
                          <th class="left-align sort-asc">
                            <?php echo _('Detalhes al deve') ?>
                          </th>
                          <th class="right-align">Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="left-align"><?php echo _('Último pago'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Saldo'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Valor a abonar'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Nuevo Saldo'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>


                  <div class="table-responsive">
                    <table class="table  table-hover">
                      <thead>
                        <tr>
                          <th class="left-align sort-asc">
                            <?php echo _('Diferencias') ?>
                          </th>
                          <th class="right-align">Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="left-align"><?php echo _('Total Diferencia +'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Total diferencia -'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Saldo Diferencia'); ?></td>
                          <td class="right-align"><?php echo "$ ". rand(1000, 9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align"></td>
                          <td class="right-align">
                            <a href="#" class="btn btn-raised btn-sm" data-toggle="#" data-target="#"><?php echo _('Editar'); ?></a>
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                  <div class="table-responsive">
                    <table class="table  table-hover">
                      <thead>
                        <tr>
                          <th class="left-align sort-asc">
                            <?php echo _('Observaciones') ?>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ipsam iure labore incidunt veniam iusto, debitis id temporibus assumenda quisquam. Fugiat quis aperiam suscipit eum cumque labore unde officia, possimus enim!</td>
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