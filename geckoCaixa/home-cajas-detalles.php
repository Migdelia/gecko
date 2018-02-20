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
                    <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Caja') ?>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-6">
                <?php include("inc/buttons.php"); // btns paneles ?>
              </div>
            </div>
            <?php 

            function totalizar($valor=0){
                $valor = str_replace("$", "", $valor);
                $valor = str_replace(" ", "", $valor);
                $valor = str_replace(".", "", $valor);
                $valor = str_replace(",", ".", $valor);
                return substr_count($valor, "-")>1 ? 0 : $valor;
            }//fin totalizar

            function formato_moneda($valor,$decimales=2,$moneda='$ '){
              if (strlen($valor)==1 && trim($moneda)=='$') {
                return $moneda;
              }else if (substr_count($valor, "-")>1) {
                return $valor;
              }else{
                return $moneda.''.number_format($valor, $decimales, ',', '.');
              }
            }//fin formato_moneda

            //DATOS
            $datos1[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Entrada','detalle'=>'Aporte de caixa','entrada'=>500000,'salida'=>'$','saldo'=>500000);
            $datos1[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Pago','detalle'=>'Pago maquina','entrada'=>'-----','salida'=>100000,'saldo'=>400000);

            $datos2[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Entrada','detalle'=>'Aporte de caixa','entrada'=>800000,'salida'=>'$','saldo'=>800000);
            $datos2[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Pago','detalle'=>'Pago maquina','entrada'=>'-----','salida'=>100000,'saldo'=>700000);
            $datos2[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Pago','detalle'=>'Pago maquina','entrada'=>'-----','salida'=>200,'saldo'=>699800);
            $datos2[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Pago','detalle'=>'Pago maquina','entrada'=>'-----','salida'=>800,'saldo'=>699000);
            $datos2[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Pago','detalle'=>'Pago maquina','entrada'=>'-----','salida'=>9000,'saldo'=>690000);
            $datos2[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Pago','detalle'=>'Pago maquina','entrada'=>'-----','salida'=>90000,'saldo'=>600000);
            $datos2[]=array('hora'=>date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))),'evento'=>'Pago','detalle'=>'Pago maquina','entrada'=>'-----','salida'=>10000,'saldo'=>590000);


             ?>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel">
                  <div class="panel-heading">
                    <div class="input-wrap">
                      <!-- dropdown de selects -->
                      <div class="btn-group white-btn">
                        <strong><?php echo _('Caja') ?>: <?php echo 'SKU- '. rand(0,999);?></strong>
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
                            <th class="left-align">
                              <?php echo _('Hora') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Evento') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Detalle') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Entrada') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Salida') ?>
                            </th>
                            <th class="left-align sort-desc">
                              <?php echo _('Saldo') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $total_entrada = $total_salida = 0;
                            foreach($datos1 as $fila): 
                              $total_entrada += totalizar(formato_moneda($fila['entrada']));
                              $total_salida += totalizar(formato_moneda($fila['salida']));

                           ?>
                            <tr>
                              <td class="left-align"><?php echo $fila['hora']; ?></td>
                                <td class="left-align"><?php echo $fila['evento']; ?></td>
                                <td class="left-align"><?php echo $fila['detalle']; ?></td>
                                <td class="left-align"><?php echo formato_moneda($fila['entrada']); ?></td>
                                <td class="left-align"><?php echo formato_moneda($fila['salida']); ?></td>
                                <td class="left-align"><?php echo formato_moneda($fila['saldo'],2,''); ?></td>
                            </tr>
                          <?php endforeach;?>
                          </tbody>
                          <tfoot>
                          <tr>
                            <th class="left-align" colspan="3">
                              Cierre de caja: <?php echo formato_moneda(400000); ?>
                            </th>
                            
                            <th class="left-align">
                              Total: <?php echo formato_moneda($total_entrada); ?>
                            </th>
                            <th class="left-align">
                              <?php echo formato_moneda($total_salida); ?>
                            </th>
                            <th class="left-align">
                              <br>
                            </th>
                          </tr>
                          </tfoot>
                         </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel">
                  <div class="panel-heading">
                    <div class="input-wrap">
                      <!-- dropdown de selects -->
                      <div class="btn-group white-btn">
                        <strong><?php echo _('Caja') ?>: <?php echo 'SKU- '. rand(0,999);?></strong>
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
                            <th class="left-align">
                              <?php echo _('Hora') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Evento') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Detalle') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Entrada') ?>
                            </th>
                            <th class="left-align">
                              <?php echo _('Salida') ?>
                            </th>
                            <th class="left-align sort-desc">
                              <?php echo _('Saldo') ?>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          
                          <?php 
                            $total_entrada = $total_salida = 0;
                            foreach($datos2 as $fila): 
                              $total_entrada += totalizar(formato_moneda($fila['entrada']));
                              $total_salida += totalizar(formato_moneda($fila['salida']));

                           ?>
                            <tr>
                              <td class="left-align"><?php echo $fila['hora']; ?></td>
                              <td class="left-align"><?php echo $fila['evento']; ?></td>
                              <td class="left-align"><?php echo $fila['detalle']; ?></td>
                              <td class="left-align"><?php echo formato_moneda($fila['entrada']); ?></td>
                              <td class="left-align"><?php echo formato_moneda($fila['salida']); ?></td>
                              <td class="left-align"><?php echo formato_moneda($fila['saldo'],2,''); ?></td>
                            </tr>
                          <?php endforeach;?>
                          </tbody>
                          <tfoot>
                          <tr>
                            <th class="left-align" colspan="3">
                              Cierre de caja: <?php echo formato_moneda(400000); ?>
                            </th>
                            
                            <th class="left-align">
                              Total: <?php echo formato_moneda($total_entrada); ?>
                            </th>
                            <th class="left-align">
                              <?php echo formato_moneda($total_salida); ?>
                            </th>
                            <th class="left-align">
                              <br>
                            </th>
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
    <?php include("inc/modals/modal-cajas-opciones-caja-historico.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-orden.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-actualizar.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-opciones-caja-entradasalida.php"); // modal de opcion de cajas ?>
    <?php include("inc/modals/modal-cajas-creditar-maquina.php");?>
  </body>
</html>