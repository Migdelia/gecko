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
                <?php echo _('Lectura') ?>
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons.php"); // btns paneles ?>
              <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12 col-md-7 ">
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
                            <?php echo _('Data') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Nombre') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Faturamento') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Local') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Valor a pagar') ?>
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


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                        <tr>
                          <td class="left-align">
                            <div class="checkbox">
                              <label><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </td>


                          <td class="left-align">Informe 08</td>

                          <td class="left-align">02 - 03 - 2010</td>
                          <td>Local <?php echo rand(0,9999); ?></td>

                          <td>Local <?php echo'Local '.rand(0,20); ?></td>
                          <td>Local <?php echo rand(0,9999); ?></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-md-5 ">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <!-- dropdown de selects -->

                    <!-- input formulario de busqueda -->
                    <form id="table-1" class="white-form right">
                    <!--   <div class="form-group">

                  </div> -->
                </form>
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="datatable1" class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th class="left-align">
                        <?php echo _('Incluir') ?>
                      </th>
                      <th class="left-align">
                        <?php echo _('Valor despensa') ?>
                      </th>
                      <th class="left-align">
                        <?php echo _('Documento') ?>
                      </th>
                      <th class="left-align">
                        <?php echo _('Número') ?>
                      </th>
                      <th class="left-align">
                        <?php echo _('Excluir') ?>
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



                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>



                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>



                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>



                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>



                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>



                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>



                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>




                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>




                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>
                    <tr>
                      <td class="left-align">
                        <div class="checkbox">
                          <label><input type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </td>




                      <td class="left-align"><?php echo rand(0,9999); ?></td>

                      <td class="left-align">
                        <?php echo _('Boleta'); ?>
                      </td>

                      <td class="left-align">
                        <?php echo 'SKU-'.rand(0,9999); ?>
                      </td>

                      <td class="left-align">
                        <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#download-modal-<?php echo $filenameID ?>"><?php echo _('Excluir') ?></a>
                      </td>

                    </tr>

                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col s12 m7">

          <div class="row">

            <div class="col s12 m6 l6">
              <div class="panel">
                    <!-- <div class="panel-heading">
                      <div class="input-wrap">
                        <form id="table-1" class="white-form right">
                          <div class="form-group">
                            <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                          </div>
                        </form>
                      </div>
                    </div> -->
                    <div class="panel-body">
                      <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th class="left-align" colspan="2">
                                <?php echo _('Totalizadores salidas') ?>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="left-align"><?php echo _('Total faturamento') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo _('Deve pago') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo _('Total a sumar') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col s12 m6 l6">
                  <div class="panel">
                    <!-- <div class="panel-heading">
                      <div class="input-wrap">
                        <form id="table-1" class="white-form right">
                          <div class="form-group">
                            <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                          </div>
                        </form>
                      </div>
                    </div> -->
                    <div class="panel-body">
                      <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th class="left-align" colspan="2">
                                <?php echo _('Totalizadores salidas') ?>
                              </th>

                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="left-align"><?php echo _('Total deves') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo _('Total desc + dif') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo _('Total a subtrair') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                  </div>
                </div>



              </div>

            </div>

            <div class="col s12 m5 l5">
              <div class="panel">
                    <!-- <div class="panel-heading">
                      <div class="input-wrap">
                        <form id="table-1" class="white-form right">
                          <div class="form-group">
                            <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                          </div>
                        </form>
                      </div>
                    </div> -->
                    <div class="panel-body">
                      <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th class="left-align">
                                <?php echo _('Total a pagar') ?>
                              </th>
                              <th class="left-align" colspan="2">
                                <!-- <?php echo _('Totalizadores salidas') ?> -->
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="left-align"><?php echo _('Subtotal') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo _('Comissao') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo _('Total ') ?></td>
                              <td class="left-align"><?php echo '$ '.rand(0,9999) ?></td>
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

        <?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
        <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
      </body>
      </html>