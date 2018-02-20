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
              <div class="col-xs-12 col-lg-4">
                <h3 class="main-title">
                  <span class="fa-stack fa-md">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-eye fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Informes'); ?>
                  <a href="#" class="btn" style="margin:0 0 0 10px;"><?php echo _('Ver Todos '); ?></a>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-8">
                <?php include("inc/buttons.php"); // btns paneles ?>
                <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel">
                  <div class="panel-heading">Promedio Máquinas por Operador</div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-12 col-lg-12">
                        <!-- Gráfico promedio maquinas por operador -->
                        <div id="prom-maquinas" class="graphitem"></div>
                      </div>
                    </div>
                  <div class="panel-body">
                    <div class="row">
                      <div class="col-xs-12 col-lg-12">
                        <!-- Detalle promedio maquina por operador -->
                        <div class="table-responsive scroll">
                          <table class="table table-striped table-hover locales">
                            <thead>
                              <tr>
                                <th><?php echo _('Nombre') ?></th>
                                <th><?php echo _('Total Máquinas Operador') ?></th>
                                <th><?php echo _('Total Máquinas Lectura') ?></th>
                                <th><?php echo _('Facturación') ?></th>
                                <th><?php echo _('Promedio por Lectura') ?></th>
                                <th><?php echo _('Promedio Total') ?></th>
                              </tr>
                            </thead>
                            <tbody>
                              <tr>
                                <td>Nico Vega</td>
                                <td>27</td>
                                <td>27</td>
                                <td>$5.938.040</td>
                                <td>$219.927</td>
                                <td>$219.927</td>
                              </tr>
                              <tr>
                                <td>Nicolas Salas</td>
                                <td>55</td>
                                <td>55</td>
                                <td>$10.307.330</td>
                                <td>$187.406</td>
                                <td>$187.406</td>
                              </tr>
                              <tr>
                                <td>Eduardo Palma</td>
                                <td>33</td>
                                <td>33</td>
                                <td>$4.129.310</td>
                                <td>$125.131</td>
                                <td>$125.131</td>
                              </tr>
                              <tr>
                                <td>Seba Local</td>
                                <td>273</td>
                                <td>273</td>
                                <td>$32.526.020</td>
                                <td>$119.275</td>
                                <td>$119.275</td>
                              </tr>
                              <tr>
                                <td>Claudio jarufe</td>
                                <td>57</td>
                                <td>57</td>
                                <td>$5.406.120</td>
                                <td>$94.844</td>
                                <td>$94.844</td>
                              </tr>
                              <tr>
                                <td>Sebastian Tesmer</td>
                                <td>44</td>
                                <td>44</td>
                                <td>$3.855.770</td>
                                <td>$87.631</td>
                                <td>$87.631</td>
                              </tr>
                              <tr>
                                <td>Claudio Vallauri</td>
                                <td>38</td>
                                <td>38</td>
                                <td>$1.117.090</td>
                                <td>$39.896</td>
                                <td>$39.896</td>
                              </tr>
                              <tr>
                                <td>Improta</td>
                                <td>170</td>
                                <td>208</td>
                                <td>$5.389.727</td>
                                <td>$25.912</td>
                                <td>$25.912</td>
                              </tr>
                              <tr>
                                <td>Marcio</td>
                                <td>144</td>
                                <td>144</td>
                                <td>$4.484.070</td>
                                <td>$31.139</td>
                                <td>$31.139</td>
                              </tr>
                              <tr>
                                <td>Leonardo Aristoteles</td>
                                <td>84</td>
                                <td>84</td>
                                <td>$2.043.605</td>
                                <td>$24.329</td>
                                <td>$24.329</td>
                              </tr>
                              <tr>
                                <td>Leo Local</td>
                                <td>31</td>
                                <td>31</td>
                                <td>$0</td>
                                <td>$0</td>
                                <td>$0</td>
                              </tr>
                              <tr class="active blue">
                                <td><strong>Total promedio:</strong></td>
                                <td><strong>997</strong></td>
                                <td><strong>1.035</strong></td>
                                <td><strong>$78.172.982</strong></td>
                                <td><strong>$75.529</strong></td>
                                <td><strong>$78.408</strong></td>
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
    </div>
  </body>
</html>
