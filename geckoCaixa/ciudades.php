<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "ciudades" // ingresar la palabra clave de cada modal ?>

  <div class="container-fluid innpage-<?php echo $filenameID; ?>">
    <div class="row">
      <?php include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
    </div>
    <div class="row">
      <?php include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
      <div class="inner-content col-xs-12 col-sm-9">
        <div class="lectura">
          <div class="row">
            <div class="col-xs-12 col-lg-6">
              <h3 class="main-title">
                <span class="fa-stack fa-md">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-map-o fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo _('Ciudades') ?>
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
                    <!-- <form class="white-form right">
                      <div class="form-group">
                        <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                      </div>
                    </form> -->
                  </div>
                </div>


                <div class="panel-body">
                  <div class="row" >

                    <div class="col-xs-12 col-md-6 col-lg-7" style="padding-left: 0px">
                      <div class="table-responsive">
                        <form>
                          <div class="form-group is-empty ui-widget">
                            <label for="tags"></label>
                            <select id="myInputSearchField" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                                <option value="1">Arica</option>
                                <option value="2">Antofagasta</option>
                                <option value="3">La Serena</option>
                                <option value="4">Coquimbo</option>
                                <option value="5">Valparaiso</option>
                                <option value="6">option1</option>
                                <option value="7">option2</option>
                                <option value="8">option3</option>
                                <option value="9">option5</option>
                            </select>
                            <span class="material-input"></span>
                          </div>
                        </form>

                        <table class="table table-striped table-hover table-condensed">
                          <thead>
                            <tr>
                              <th class="left-align sort-none">
                                <div class="checkbox">
                                  <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                </div>
                              </th>
                              <th class="left-align sort-asc">
                                <?php echo _('ID') ?>
                              </th>
                              <th class="left-align">
                                <?php echo _('Ciudades') ?>
                              </th>
                              <th class="left-align">
                                <?php echo _('Excluido') ?>
                              </th>
                              <th class="left-align" style="width: 300px;">
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
                                <td class="left-align">0001</td>
                                <td class="left-align">Antofagasta</td>
                                <td class="left-align">Activado</td>
                                <td class="left-align">
                                  <div class="row" style="margin-bottom: 0px;">
                                    <div class="btn-group" role="group" aria-label="Justified button group">
                                      <div class="col-xs-7 col-md-6 left-align">
                                       <a href="#" class="btn" role="button" style="color: white;" data-toggle="modal" data-target="#download-informe-cierre-modal"> <?php echo _('Descargar') ?></a>
                                     </div>
                                     <div class="col-xs-5 col-md-6 right-align">
                                      <a href="ver-informe-cierre.php" class="btn" role="button" style="color: white"><?php echo _('Ver') ?></a>
                                    </div>

                                  </div>
                                </div>
                              </td>
                            </tr>

                          <?php endfor;?>
                        </tbody>
                      </table>
                    </div>
                  </div>

                  <div class="col-xs-12 col-md-2 col-lg-2">
                    <div class="table-responsive">

                      <form>
                        <div class="form-group is-empty ui-widget">
                          <label for="tags"></label> <input id="myInputSearchField" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                          <span class="material-input"></span>
                        </div>
                      </form>


                      <table  class="table table-striped table-hover">
                        <thead>
                          <tr>
                            <th class="left-align">
                              <?php echo _('Máquinas') ?>
                            </th>
                            <th><div class="checkbox">
                              <label ><input type="checkbox"><span class="checkbox-material"></span></label>
                            </div></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php for ($i=0; $i <10 ; $i++) :?>
                            <tr>
                              <td colspan="2" class="left-align" style="margin-bottom: 0px; height:43px;"><?php echo 'SKU-'.rand(0,999) ?></td>
                            </tr>
                          <?php  endfor;?>
                        </tbody>
                      </table>

                    </div>
                  </div>

                  <div class="col-xs-12 col-md-4 col-lg-3">
                    <div class="map">
                      <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18326865.80954878!2d-71.76481787907089!3d-37.535484842928454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c5410425af2f%3A0x505e1131102b91d!2sChile!5e0!3m2!1ses-419!2scl!4v1450904897219" width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen></iframe>
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

<?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
<?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
<script type="text/javascript">
    $(document).ready(function() {
        $('select').select2();
    });
</script>
</body>
</html>
