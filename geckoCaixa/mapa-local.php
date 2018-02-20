<!DOCTYPE html>
<html>
<head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "mapa-local" // ingresar la palabra clave de cada modal ?>

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
                            <!-- <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?> -->
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="panel">
                                <div class="panel-heading">
                                    <div class="input-wrap">
                                        <!-- dropdown de selects -->
                                        <div class="btn-group white-btn">
                                            <div class="btn-group white-btn">
                                                <?php include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                                            </div>
                                            <div class="btn-group white-btn">
                                                <?php include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                                            </div>
                                            <!-- modal-actions.php -->
                                            <!-- <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" class="btn">Acción masiva<div class="ripple-container"></div></a>
                                            <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a> -->
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="#" class="mass-act" data-toggle="modal" data-target="#massaction-modal">Action 1</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="#" class="mass-act" data-toggle="modal" data-target="#massaction-modal">Action 2</a>
                                                </li>
                                                <li class="divider"></li>
                                                <li>
                                                    <a href="#" class="mass-act" data-toggle="modal" data-target="#massaction-modal">Action 3</a>
                                                </li>
                                            </ul>

                                            <div id="massaction-modal" class="modal fade" tabindex="-1" style="display: none;">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                            <h5>Confirma que quiere Ejecutar la acción</h5>
                                                        </div>
                                                        <div class="modal-body">
                                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel in dolorum voluptatibus necessitatibus atque.</p>
                                                            <div class="row form-group">
                                                                <div class="col-xs-12">
                                                                    <button type="submit" class="btn send btn-sm btn-raised col-xs-12 col-md-4 right">Confirmar</button>
                                                                    <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-sm btn-raised col-xs-12 col-md-4 right">Cancelar</button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>                      </div>
                                            <!-- input formulario de busqueda -->
                                            <form id="table-1" class="white-form right">
                                                <div class="form-group is-empty">
                                                    <input type="text" class="form-control col-md-8" placeholder="Búsqueda">
                                                    <span class="material-input"></span>
                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <br>

                                    <div class="panel-body">
                                        <div class="col-xs-12 col-md-9">
                                            <!-- lista locales -->
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <i class="material-icons">store</i> <?php echo _('Lista Locales') ?>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive scroll">
                                                        <table class="table table-striped table-hover locales">
                                                            <thead>
                                                                <tr data-local="01">
                                                                    <th><?php echo _('Local') ?></th>
                                                                    <th><?php echo _('Ciudad') ?></th>
                                                                    <th><?php echo _('Saldo') ?></th>
                                                                    <th><?php echo _('Cajas Abiertas') ?></th>
                                                                    <th class="right-align"><?php echo _('Estado Conexión') ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr data-local="02">
                                                                    <td>Isla del tesoro</td>
                                                                    <td>Arica</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/redball.png" alt=""> Offline</td>
                                                                </tr>
                                                                <tr data-local="03">
                                                                    <td>Cathedral</td>
                                                                    <td>San Bernardo</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/greenball.png" alt=""> Online</td>
                                                                </tr>
                                                                <tr data-local="04">
                                                                    <td>Blue Space</td>
                                                                    <td>Talcahuano</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/redball.png" alt=""> Offline</td>
                                                                </tr>
                                                                <tr data-local="05">
                                                                    <td>Gran Faraón</td>
                                                                    <td>Valparaíso</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/greenball.png" alt=""> Online</td>
                                                                </tr>
                                                                <tr data-local="06">
                                                                    <td>Fantastic</td>
                                                                    <td>Santiago</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/greenball.png" alt=""> Online</td>
                                                                </tr>
                                                                <tr data-local="05">
                                                                    <td>Gran Faraón</td>
                                                                    <td>Valparaíso</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/greenball.png" alt=""> Online</td>
                                                                </tr>
                                                                <tr data-local="06">
                                                                    <td>Fantastic</td>
                                                                    <td>Santiago</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/greenball.png" alt=""> Online</td>
                                                                </tr>
                                                                <tr data-local="05">
                                                                    <td>Gran Faraón</td>
                                                                    <td>Valparaíso</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/greenball.png" alt=""> Online</td>
                                                                </tr>
                                                                <tr data-local="06">
                                                                    <td>Fantastic</td>
                                                                    <td>Santiago</td>
                                                                    <td><?php echo rand(0,9999) ?></td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align"><img src="img/greenball.png" alt=""> Online</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Lista Máquinas -->
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <?php echo _('Lista Máquinas Local') ?>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="table-responsive scroll">
                                                        <table class="table table-striped table-hover maquinas" style="display:none;">
                                                            <thead>
                                                                <tr>
                                                                    <th><?php echo _('Fecha') ?></th>
                                                                    <th><?php echo _('Nombre') ?></th>
                                                                    <th><?php echo _('Total facturamiento') ?></th>
                                                                    <th><?php echo _('Id') ?></th>
                                                                    <th><?php echo _('Datos') ?></th>
                                                                    <th class="right-align"><?php echo _('Operador') ?></th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                                <tr>
                                                                    <td>2015-11-27</td>
                                                                    <td>Blue space talcahuano</td>
                                                                    <td><?php echo rand(0,9999)?></td>
                                                                    <td>sku-6294</td>
                                                                    <td><?php echo rand(0,100)?></td>
                                                                    <td class="right-align">Leonardo</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>

                                            <!-- Información máquina -->
                                            <div class="panel">
                                                <div class="panel-heading">
                                                    <?php echo _('Información máquinas Local') ?>
                                                </div>
                                                <div class="panel-body">
                                                    <div class="info-maquina" style="display:none;">
                                                        <!-- Nav tabs -->
                                                        <ul class="nav nav-tabs" role="tablist">
                                                            <li role="presentation" class="active"><a class="btn btn-raised" href="#config" aria-controls="config" role="tab" data-toggle="tab">Configuración</a></li>
                                                            <li role="presentation"><a class="btn btn-raised" href="#last_pay" aria-controls="last_pay" role="tab" data-toggle="tab">Últimos pagos</a></li>
                                                            <li role="presentation"><a class="btn btn-raised" href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Configuración</a></li>
                                                            <li role="presentation"><a class="btn btn-raised" href="#money" aria-controls="money" role="tab" data-toggle="tab">Billetes ingresados</a></li>
                                                            <li role="presentation"><a class="btn btn-raised" href="#games" aria-controls="games" role="tab" data-toggle="tab">Juegos</a></li>
                                                            <li role="presentation"><a class="btn btn-raised" href="#stats" aria-controls="stats" role="tab" data-toggle="tab">Estadísticas</a></li>
                                                        </ul>

                                                        <!-- Tab panes -->
                                                        <div class="tab-content">
                                                            <!-- Tab Configuración Maquina -->
                                                            <div role="tabpanel" class="tab-pane active" id="config">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-md-12">
                                                                        <h6>Configuración Máquina</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-3 col-md-3">
                                                                        <table class="table table-striped table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Config 1:</td>
                                                                                    <td>Valor 1</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 1:</td>
                                                                                    <td>Valor 1</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 1:</td>
                                                                                    <td>Valor 1</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-3 col-md-3">
                                                                        <table class="table table-striped table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Config 2:</td>
                                                                                    <td>Valor 2</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 2:</td>
                                                                                    <td>Valor 2</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 2:</td>
                                                                                    <td>Valor 2</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-3 col-md-3">
                                                                        <table class="table table-striped table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Config 3:</td>
                                                                                    <td>Valor 3</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 3:</td>
                                                                                    <td>Valor 3</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 3:</td>
                                                                                    <td>Valor 3</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-3 col-md-3">
                                                                        <table class="table table-striped table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Config 4:</td>
                                                                                    <td>Valor 4</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 4:</td>
                                                                                    <td>Valor 4</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 4:</td>
                                                                                    <td>Valor 4</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Tab Ultimos pagos -->
                                                            <div role="tabpanel" class="tab-pane" id="last_pay">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-md-12">
                                                                        <h6>Últimos pagos</h6>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped table-hover locales">
                                                                                <thead>
                                                                                    <tr data-local="01">
                                                                                        <th><?php echo _('Local') ?></th>
                                                                                        <th><?php echo _('Ciudad') ?></th>
                                                                                        <th><?php echo _('Saldo') ?></th>
                                                                                        <th><?php echo _('Cajas Abiertas') ?></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr data-local="02">
                                                                                        <td>Isla del tesoro</td>
                                                                                        <td>Arica</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                    <tr data-local="03">
                                                                                        <td>Cathedral</td>
                                                                                        <td>San Bernardo</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                    <tr data-local="04">
                                                                                        <td>Blue Space</td>
                                                                                        <td>Talcahuano</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                    <tr data-local="05">
                                                                                        <td>Gran Faraón</td>
                                                                                        <td>Valparaíso</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                    <tr data-local="06">
                                                                                        <td>Fantastic</td>
                                                                                        <td>Santiago</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Tab Configuraciones -->
                                                            <div role="tabpanel" class="tab-pane" id="settings">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-md-12">
                                                                        <h6>Configuraciones</h6>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-xs-3 col-md-3">
                                                                        <table class="table table-striped table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Config 1:</td>
                                                                                    <td>Valor 1</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 1:</td>
                                                                                    <td>Valor 1</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 1:</td>
                                                                                    <td>Valor 1</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-3 col-md-3">
                                                                        <table class="table table-striped table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Config 2:</td>
                                                                                    <td>Valor 2</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 2:</td>
                                                                                    <td>Valor 2</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 2:</td>
                                                                                    <td>Valor 2</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-3 col-md-3">
                                                                        <table class="table table-striped table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Config 3:</td>
                                                                                    <td>Valor 3</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 3:</td>
                                                                                    <td>Valor 3</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 3:</td>
                                                                                    <td>Valor 3</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="col-xs-3 col-md-3">
                                                                        <table class="table table-striped table-hover">
                                                                            <tbody>
                                                                                <tr>
                                                                                    <td>Config 4:</td>
                                                                                    <td>Valor 4</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 4:</td>
                                                                                    <td>Valor 4</td>
                                                                                </tr>
                                                                                <tr>
                                                                                    <td>Config 4:</td>
                                                                                    <td>Valor 4</td>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Tab Billetes Ingresados -->
                                                            <div role="tabpanel" class="tab-pane" id="money">
                                                                <h6>Billetes ingresados</h6>
                                                                <div class="table-responsive">
                                                                    <table class="table table-striped table-hover locales">
                                                                        <thead>
                                                                            <tr data-local="01">
                                                                                <th><?php echo _('Local') ?></th>
                                                                                <th><?php echo _('Ciudad') ?></th>
                                                                                <th><?php echo _('Saldo') ?></th>
                                                                                <th><?php echo _('Cajas Abiertas') ?></th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <tr data-local="02">
                                                                                <td>Isla del tesoro</td>
                                                                                <td>Arica</td>
                                                                                <td><?php echo rand(0,9999) ?></td>
                                                                                <td><?php echo rand(0,100)?></td>
                                                                            </tr>
                                                                            <tr data-local="03">
                                                                                <td>Cathedral</td>
                                                                                <td>San Bernardo</td>
                                                                                <td><?php echo rand(0,9999) ?></td>
                                                                                <td><?php echo rand(0,100)?></td>
                                                                            </tr>
                                                                            <tr data-local="04">
                                                                                <td>Blue Space</td>
                                                                                <td>Talcahuano</td>
                                                                                <td><?php echo rand(0,9999) ?></td>
                                                                                <td><?php echo rand(0,100)?></td>
                                                                            </tr>
                                                                            <tr data-local="05">
                                                                                <td>Gran Faraón</td>
                                                                                <td>Valparaíso</td>
                                                                                <td><?php echo rand(0,9999) ?></td>
                                                                                <td><?php echo rand(0,100)?></td>
                                                                            </tr>
                                                                            <tr data-local="06">
                                                                                <td>Fantastic</td>
                                                                                <td>Santiago</td>
                                                                                <td><?php echo rand(0,9999) ?></td>
                                                                                <td><?php echo rand(0,100)?></td>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>

                                                            <!-- Tab Juegos -->
                                                            <div role="tabpanel" class="tab-pane" id="games">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-md-12">
                                                                        <h6>Juegos</h6>

                                                                        <!-- Slider Imágenes -->
                                                                        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                                                            <!-- Indicators -->
                                                                            <ol class="carousel-indicators">
                                                                                <li data-target="#carousel-example-generic" data-slide-to="0" class="active"></li>
                                                                                <!-- <li data-target="#carousel-example-generic" data-slide-to="1"></li>
                                                                                <li data-target="#carousel-example-generic" data-slide-to="2"></li> -->
                                                                            </ol>

                                                                            <!-- Wrapper for slides -->
                                                                            <div class="carousel-inner" role="listbox">
                                                                                <div class="item active">
                                                                                    <div class="games">
                                                                                        <div class="bg-game">
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item">
                                                                                    <div class="games">
                                                                                        <div class="bg-game">
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="item">
                                                                                    <div class="games">
                                                                                        <div class="bg-game">
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                            <div class="game-img">
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                                <img src="img/k1.png" alt="" />
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Controls -->
                                                                            <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
                                                                                <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                                                                <span class="sr-only">Anterior</span>
                                                                            </a>
                                                                            <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
                                                                                <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                                                                <span class="sr-only">Siguiente</span>
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Tab Estadísticas -->
                                                            <div role="tabpanel" class="tab-pane" id="stats">
                                                                <div class="row">
                                                                    <div class="col-xs-12 col-md-12">
                                                                        <h6>Estadísticas</h6>
                                                                        <div class="table-responsive">
                                                                            <table class="table table-striped table-hover locales">
                                                                                <thead>
                                                                                    <tr data-local="01">
                                                                                        <th><?php echo _('Local') ?></th>
                                                                                        <th><?php echo _('Ciudad') ?></th>
                                                                                        <th><?php echo _('Saldo') ?></th>
                                                                                        <th><?php echo _('Cajas Abiertas') ?></th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr data-local="02">
                                                                                        <td>Isla del tesoro</td>
                                                                                        <td>Arica</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                    <tr data-local="03">
                                                                                        <td>Cathedral</td>
                                                                                        <td>San Bernardo</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                    <tr data-local="04">
                                                                                        <td>Blue Space</td>
                                                                                        <td>Talcahuano</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                    <tr data-local="05">
                                                                                        <td>Gran Faraón</td>
                                                                                        <td>Valparaíso</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                    <tr data-local="06">
                                                                                        <td>Fantastic</td>
                                                                                        <td>Santiago</td>
                                                                                        <td><?php echo rand(0,9999) ?></td>
                                                                                        <td><?php echo rand(0,100)?></td>
                                                                                    </tr>
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                        <!-- fin tabs -->

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-md-3">
                                            <div class="map">
                                                <iframe src="https://www.google.com/maps/d/embed?mid=zKfaA2WVftsM.kpuYbG2LWLcM" width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                                                <!-- <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18326865.80954878!2d-71.76481787907089!3d-37.535484842928454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c5410425af2f%3A0x505e1131102b91d!2sChile!5e0!3m2!1ses-419!2scl!4v1450904897219" width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen=""></iframe> -->
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
        </body>
        </html>
