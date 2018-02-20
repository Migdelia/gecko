<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "niveles" // ingresar la palabra clave de cada modal ?>

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
                    <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Niveles') ?>
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
                      <div class="btn-group-horizontal left">
                        <a href="#" class="btn btn-raised active"><?php echo _('Master') ?></a>
                        <a href="#" class="btn btn-raised"><?php echo _('Operador') ?></a>
                        <a href="#" class="btn btn-raised"><?php echo _('Administrador') ?></a>
                        <a href="#" class="btn btn-raised"><?php echo _('Gerente') ?></a>
                        <a href="#" class="btn btn-raised"><?php echo _('Todos') ?></a>
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
                    <div class="col-xs-12">
                      <div class="table-responsive">
                        <table id="datatable" class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th class="left-align">
                                <a href="#"><?php echo _('Nombre') ?></a>
                              </th>
                              <th class="sort-none" colspan="3">
                              </th>
                              <th class="center-align">
                                <a href="#"><?php echo _('Activador') ?></a>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Admin</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-map-o"></i>Ciudades</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row active"><a href="#" class="select-user">Adolfo</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-eye"></i>Lectura</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Alberto</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-check-circle-o"></i>Validación</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox" checked="">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Alejandra</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-question-circle"></i>Consulta</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Alessandro</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-building-o"></i>Locales</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Andrés</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-calendar"></i>Fechas</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox" checked="">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Aninha</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-building-o"></i>Locales Integrados</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Claudio</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-tasks"></i>Jefe de Proyectos</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox" checked="">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Dani</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-map-pin"></i>Máquinas</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Daniela</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-file-text-o"></i>Informes</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox" checked="">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Raúl</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-list-ul"></i>Niveles</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Catalina</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-unlock"></i>Ingresar</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox" checked="">
                                  </label>
                                </div>
                              </td>
                            </tr>
                            <tr>
                              <td class="left-align borded-row"><a href="#" class="select-user">Sandra</a></td>
                              <td class="left-align access-row" colspan="3"><i class="fa fa-users"></i>Usuarios</td>
                              <td class="center-align">
                                <div class="togglebutton">
                                  <label>
                                    <input type="checkbox" checked="">
                                  </label>
                                </div>
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
    </div>
  </body>
</html>