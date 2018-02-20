<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

$idLocal = $_GET['id'];

//consulta o nome do local
$sqlLoc = "SELECT nome FROM local WHERE id_local = " . $idLocal;
$queryLoc=@mysql_query($sqlLoc);
$resLoc=@mysql_fetch_assoc($queryLoc);

?>
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
      <div class="inner-content col-xs-12 col-sm-12">
        <div class="page<?php echo $filenameID; ?>">
          <div class="row">
            <div class="col-xs-12 col-lg-6">
              <h3 class="main-title">
                <span class="fa-stack fa-md">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-building-o fa-stack-1x fa-inverse"></i>
                </span>
                <span id="localSelecionado" title="<?php echo $idLocal; ?>"><?php echo $resLoc['nome']; ?></span>
              </h3>
            </div>
          </div>
          <div class="row">
            <div class="col-xs-12">
              <div class="panel">
                    <div class="panel-body">
                      <div class="col-xs-12 col-md-12">
                        <!-- Lista Máquinas -->
                        <div class="panel">
                            <div class="panel-heading">
                                <a href='#' id='ver_config_maquinas' class='btn btn-sm' onClick='verTodas(this);'>Configuraciones Máquinas >></a>
                            </div>
                            <div id="lstConf" class="panel-body">
                                <div class="table-responsive scrollDetalhe">
                                    <table id="tabelaListaMaquinas" class="table table-striped table-hover maquinas">
                                        <thead>
                                            <tr>
                                                <th><?php echo _('Máq') ?></th>
                                                <th><?php echo _('juego') ?></th>
                                                <th><?php echo _('%') ?></th>
                                                <th><?php echo _('Tipo') ?></th>
                                                <th><?php echo _('Big Min') ?></th>
                                                <th><?php echo _('Big Max') ?></th>
                                                <th><?php echo _('Big Atu') ?></th>
                                                <th><?php echo _('Acu Min') ?></th>
                                                <th><?php echo _('Acu Max') ?></th>
                                                <th><?php echo _('Acu Atu') ?></th>
                                                <th><?php echo _('Jackpot') ?></th>  
                                                <th><?php echo _('Fam Big') ?></th>                                                    
												<th><?php echo _('Fav Big') ?></th>
												<th><?php echo _('Fam') ?></th>
                                                <th><?php echo _('Fav') ?></th>
                                                <th><?php echo _('pk') ?></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        
                                        	<?php
												//consulta configuracoes das maquinas desse local
												$sql_configs = "SELECT numero, id_jogo, interface FROM vw_maquinas WHERE ((id_jogo > 0 AND id_jogo < 10) or (id_jogo > 19 AND id_jogo < 40)) AND id_local = " . $idLocal;
												$query_configs=@mysql_query($sql_configs);
												
												//conecta no integration
												include('conn/connIntegration.php');
												
												//
												while($res_configs=@mysql_fetch_assoc($query_configs))
												{
													//consulta config dessa maquinas
													$sqlConfigMaq = "SELECT * FROM Config WHERE id = " . $res_configs['interface'];	
													$queryConfigMaq=@mysql_query($sqlConfigMaq);
													$resConfigMaq=@mysql_fetch_assoc($queryConfigMaq);
													
													//trata valores
													///////////////
													
													//Tipo maquina
													if($resConfigMaq['machineType'] == 0)
													{
														$tpMaq = 'Cliente';
													}
													else
													{
														$tpMaq = '<strong>Server</strong>';
													}
													
													//Big min
													$bigMin = $resConfigMaq['acumuladoMin'] * 1000;
													$bigMin = number_format($bigMin,0,"",".");
													
													//Big max
													$bigMax = $resConfigMaq['acumuladoMax'] * 1000;
													$bigMax = number_format($bigMax,0,"",".");	
													
													//Big atual
													$bigAtu = ($resConfigMaq['currentAcu'] / 1000);										
													$bigAtu = number_format($bigAtu,0,"",".");	
													
													//Acu min
													$acuMin = $resConfigMaq['acumuladoSMin'] * 1000;
													$acuMin = number_format($acuMin,0,"",".");
													
													//Acu max
													$acuMax = $resConfigMaq['acumuladoSMax'] * 1000;
													$acuMax = number_format($acuMax,0,"",".");	
													
													//Acu atual
													$acuAtu = ($resConfigMaq['currentAcuS'] / 1000);										
													$acuAtu = number_format($acuAtu,0,"",".");
													
													//jackpot
													$jckpt = ($resConfigMaq['jackpotValue'] * 1000);												
													$jckpt = number_format($jckpt,0,"",".");
													
													//fam
													if($resConfigMaq['fam'] == 0)
													{
														$famB = 'NO';	
													}
													else
													{
														$famB = 'SI';	
													}
													
													//fam
													if($resConfigMaq['famS'] == 0)
													{
														$famS = 'NO';	
													}
													else
													{
														$famS = 'SI';	
													}
													
													//fam
													if($resConfigMaq['pk'] == 0)
													{
														$pk = 'NO';	
													}
													else
													{
														$pk = 'SI';	
													}
													
													
													//fav
													//trata o fav Big
													if($resConfigMaq['fav'] == 70000)
													{
														$fav = 'A';	
													}
													else if($resConfigMaq['fav'] == 60000)
													{
														$fav = 'B';
													}	
													else if($resConfigMaq['fav'] == 50000)
													{
														$fav = 'C';
													}	
													else if($resConfigMaq['fav'] == 40000)
													{
														$fav = 'D';
													}
													else if($resConfigMaq['fav'] == 80000)
													{
														$fav = 'D';
													}			
												
													
													//trata o fav
													if($resConfigMaq['favS'] == 20000)
													{
														$favS = 'A';	
													}
													else if($resConfigMaq['favS'] == 15000)
													{
														$favS = 'B';
													}	
													else if($resConfigMaq['favS'] == 10000)
													{
														$favS = 'C';
													}	
													else if($resConfigMaq['favS'] == 5000)
													{
														$favS = 'D';
													}													
													
													
													
																																							
													
													//trata valore
													
													
													
													echo "<tr id='lnMaquina_".$res_configs['interface']."' title='".$res_configs['numero']."' onClick='carregaDetalheMaquinas(this, ".$res_configs['interface'].");'>";
													echo "<td>".$res_configs['numero']."</td>";
													echo "<td><img src='images/".$res_configs['id_jogo'].".png' width='30px;'></td>";
													echo "<td>".$resConfigMaq['percentage']."</td>";
													echo "<td>".$tpMaq."</td>";
													echo "<td>$ ".$bigMin."</td>";
													echo "<td>$ ".$bigMax."</td>";
													echo "<td>$ ".$bigAtu."</td>";
													echo "<td>$ ".$acuMin."</td>";
													echo "<td>$ ".$acuMax."</td>";
													echo "<td>$ ".$acuAtu."</td>";
													echo "<td>$ ".$jckpt."</td>";
													echo "<td>".$famB."</td>";
													echo "<td>".$fav."</td>";
													echo "<td>".$famS."</td>";
													echo "<td>".$favS."</td>";
													echo "<td>".$pk."</td>";
													echo "</tr>";
												}
											?>
                                        </tbody>
                                    </table>
                                
                                <?php
                                    //gera lista de hiddens com uoptime
                                    $sql_maq_uptime = "
                                        SELECT
                                            numero			
                                        FROM
                                            vw_maquinas
                                        WHERE
                                            excluido = 'N'
                                        AND
                                            id_local = ".$idLocal."
                                        ORDER BY
                                            numero";
                                    $query_maq_uptime=@mysql_query($sql_maq_uptime);
								
                                    //									
                                    while($res_maq_uptime=@mysql_fetch_assoc($query_maq_uptime)) 
                                    {
                                        echo "<input type='hidden' id='hd_".$res_maq_uptime['numero']."' name='hd_".$res_maq_uptime['numero']."' value='' /> \n";
                                    }
                                ?>
                                    
                                 </div>
                            </div>
                  		</div>
                      </div>
                  	</div> 
                    
                    
                    
                        <!-- Información máquina -->
                        <div class="panel">
                          <div class="panel-heading">
                            <?php echo _('Config máquina:') ?>
                            &nbsp; &nbsp;
                            <strong><span id="maqSelecionada" title="0">&nbsp;</span></strong>
                          </div>
                          <div id="confDet" class="panel-body">
                            <div class="info-maquina" style="display:none;">
                              <!-- Nav tabs -->
                              <ul class="nav nav-tabs" role="tablist">
								<li role="presentation"><a class="btn btn-raised" href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Configuración</a></li>                                
                              </ul>

                                

                                <!-- Tab Configuraciones -->
                                <div role="tabpanel" class="tab-pane active" id="settings">
                                  <div class="row">
                                    <div class="col-xs-6 col-md-6">
                                      <h6>Configuraciones</h6>
                                    </div>
                                  </div>
                                  
                                  <form class="form-horizontal">
                                  <div id="divConfig" class="row">
                                    <div class="col-xs-12 col-md-12">
                                      <table class="table table-striped table-hover">
                                        <tbody>
                                          <tr>
                                            <td>Tipo Moneda: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_tipoMoeda" name="input_tipoMoeda" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="tipoMoeda_eur" name="tipoMoeda_eur" class="mass-act" onClick="atribuiValor(this);"><?php echo _('EUR') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="tipoMoeda_eur" name="tipoMoeda_eur" class="mass-act" onClick="atribuiValor(this);"><?php echo _('USD') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                              
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Denominacion: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_denom" name="input_denom" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="denom_10" name="denom_10" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.010') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_20" name="denom_20" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.020') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_50" name="denom_50" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.050') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_100" name="denom_100" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.100') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_250" name="denom_250" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.250') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_750" name="denom_750" class="mass-act" onClick="atribuiValor(this);"><?php echo _('0.750') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="denom_1000" name="denom_1000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('1.000') ?></a>
                                                  </li>                                                 
                                                </ul>
                                              </div>  
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Porcentaje: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_pct" name="input_pct" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="pct_8400" name="pct_8400" class="mass-act" onClick="atribuiValor(this);"><?php echo _('84.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8450" name="pct_8450" class="mass-act" onClick="atribuiValor(this);"><?php echo _('84.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8500" name="pct_8500" class="mass-act" onClick="atribuiValor(this);"><?php echo _('85.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8550" name="pct_8550" class="mass-act" onClick="atribuiValor(this);"><?php echo _('85.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8600" name="pct_8600" class="mass-act" onClick="atribuiValor(this);"><?php echo _('86.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8650" name="pct_8650" class="mass-act" onClick="atribuiValor(this);"><?php echo _('86.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8700" name="pct_8700" class="mass-act" onClick="atribuiValor(this);"><?php echo _('87.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8750" name="pct_8750" class="mass-act" onClick="atribuiValor(this);"><?php echo _('87.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8800" name="pct_8800" class="mass-act" onClick="atribuiValor(this);"><?php echo _('88.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8850" name="pct_8850" class="mass-act" onClick="atribuiValor(this);"><?php echo _('88.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8900" name="pct_8900" class="mass-act" onClick="atribuiValor(this);"><?php echo _('89.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_8950" name="pct_8950" class="mass-act" onClick="atribuiValor(this);"><?php echo _('89.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9000" name="pct_9000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('90.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9050" name="pct_9050" class="mass-act" onClick="atribuiValor(this);"><?php echo _('90.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9100" name="pct_9100" class="mass-act" onClick="atribuiValor(this);"><?php echo _('91.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9150" name="pct_9150" class="mass-act" onClick="atribuiValor(this);"><?php echo _('91.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9200" name="pct_9200" class="mass-act" onClick="atribuiValor(this);"><?php echo _('92.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9250" name="pct_9250" class="mass-act" onClick="atribuiValor(this);"><?php echo _('92.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9300" name="pct_9300" class="mass-act" onClick="atribuiValor(this);"><?php echo _('93.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9350" name="pct_9350" class="mass-act" onClick="atribuiValor(this);"><?php echo _('93.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9400" name="pct_9400" class="mass-act" onClick="atribuiValor(this);"><?php echo _('94.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9450" name="pct_9450" class="mass-act" onClick="atribuiValor(this);"><?php echo _('94.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9500" name="pct_9500" class="mass-act" onClick="atribuiValor(this);"><?php echo _('95.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9550" name="pct_9550" class="mass-act" onClick="atribuiValor(this);"><?php echo _('95.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9600" name="pct_9600" class="mass-act" onClick="atribuiValor(this);"><?php echo _('96.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9650" name="pct_9650" class="mass-act" onClick="atribuiValor(this);"><?php echo _('96.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9700" name="pct_9700" class="mass-act" onClick="atribuiValor(this);"><?php echo _('97.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9750" name="pct_9750" class="mass-act" onClick="atribuiValor(this);"><?php echo _('97.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9800" name="pct_9800" class="mass-act" onClick="atribuiValor(this);"><?php echo _('98.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9850" name="pct_9850" class="mass-act" onClick="atribuiValor(this);"><?php echo _('98.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9900" name="pct_9900" class="mass-act" onClick="atribuiValor(this);"><?php echo _('99.000 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_9950" name="pct_9950" class="mass-act" onClick="atribuiValor(this);"><?php echo _('99.050 %') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pct_10000" name="pct_10000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('100.000 %') ?></a>
                                                  </li>                                                                                      
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Tipo Máquina: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_tipoMaq" name="input_tipoMaq" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="tipoMaq_1" name="tipoMaq_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('Server') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="tipoMaq_0" name="tipoMaq_0" class="mass-act" onClick="atribuiValor(this);"><?php echo _('Cliente') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr> 
                                          <tr>
                                            <td>Big Acumulado Min: </td>
                                            <td>
                                             	<input type="text" id="bigAcuMin" name="BigAcuMin" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                           
                                            </td>
                                          </tr>       
                                          <tr>
                                            <td>Big Acumulado Max: </td>
                                            <td>
												<input type="text" id="bigAcuMax" name="bigAcuMax" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                          
                                            </td>
                                          </tr>                                                     
                                          
                                          <tr>
                                            <td>Acumulado Big Actual: </td>
                                            <td>
                                             	<input type="text" id="bigAcuAtu" name="BigAcuAtu" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                          
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Acumulado Simples Min: </td>
                                            <td>
                                              	<input type="text" id="AcuMin" name="AcuMin" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                          
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Acumulado Simples Max: </td>
                                            <td>
                                             	<input type="text" id="AcuMax" name="AcuMax" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                           
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Acumulado Simples Actual: </td>
                                            <td>
                                            	<input type="text" id="AcuAtu" name="AcuAtu" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                           
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Valor del Jackpot: </td>
                                            <td>
                                              	<input type="text" id="vlJack" name="vlJack" value="0" placeholder="Big Acdumulado Min" style="width:150px;" />                                                           
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Limite de Doblar(creditos): </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_LimDobra" name="input_LimDobra" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="LimDobra_20000" name="LimDobra_20000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('2.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_25000" name="LimDobra_25000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('2.500.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_30000" name="LimDobra_30000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('3.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_35000" name="LimDobra_35000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('3.500.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_40000" name="LimDobra_40000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('4.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_45000" name="LimDobra_45000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('4.500.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimDobra_50000" name="LimDobra_40000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('5.000.000') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>DB: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_db" name="input_db" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="db_1" name="db_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('SI') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="db_1" name="db_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('NO') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>FAM Big: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_FamBig" name="input_FamBig" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="FamBig_1" name="FamBig_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('SI') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="FamBig_2" name="FamBig_2" class="mass-act" onClick="atribuiValor(this);"><?php echo _('NO') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>FAV Big: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_FavBig" name="input_FavBig" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="FavBig_A" name="FavBig_A" class="mass-act" onClick="atribuiValor(this);"><?php echo _('A') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="FavBig_B" name="FavBig_B" class="mass-act" onClick="atribuiValor(this);"><?php echo _('B') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="FavBig_C" name="FavBig_C" class="mass-act" onClick="atribuiValor(this);"><?php echo _('C') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="FavBig_D" name="FavBig_D" class="mass-act" onClick="atribuiValor(this);"><?php echo _('D') ?></a>
                                                  </li>                                                  
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>FAM: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_Fam" name="input_Fam" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="Fam_1" name="Fam_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('SI') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="Fam_0" name="Fam_0" class="mass-act" onClick="atribuiValor(this);"><?php echo _('NO') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>FAV: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_Fav" name="input_Fav" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="Fav_A" name="Fav_A" class="mass-act" onClick="atribuiValor(this);"><?php echo _('A') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="Fav_B" name="Fav_B" class="mass-act" onClick="atribuiValor(this);"><?php echo _('B') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="Fav_C" name="Fav_C" class="mass-act" onClick="atribuiValor(this);"><?php echo _('C') ?></a>
                                                  </li>
                                                  <li>
                                                    <a id="Fav_D" name="Fav_D" class="mass-act" onClick="atribuiValor(this);"><?php echo _('D') ?></a>
                                                  </li>                                                  
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Limite Auto-Cobrar, $: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_LimCobrar" name="input_LimCobrar" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="LimCobrar_2000" name="LimCobrar_2000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('2.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimCobrar_2500" name="LimCobrar_2500" class="mass-act" onClick="atribuiValor(this);"><?php echo _('2.500.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimCobrar_3000" name="LimCobrar_3000" class="mass-act" onClick="atribuiValor(this);"><?php echo _('3.000.000') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="LimCobrar_3500" name="LimCobrar_3500" class="mass-act" onClick="atribuiValor(this);"><?php echo _('3.500.000') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                          <tr>
                                            <td>Payout Key: </td>
                                            <td>
                                              <div class="row form-group">
                                                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_pKey" name="input_pKey" class="btn dropdown-btn" style="width:125px;">&nbsp;<div class="ripple-container"></div></a>
                                                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                                                <ul class="dropdown-menu">
                                                  <li>
                                                    <a id="pKey_1" name="pKey_1" class="mass-act" onClick="atribuiValor(this);"><?php echo _('SI') ?></a>
                                                  </li>
                                                  <li class="divider"></li>
                                                  <li>
                                                    <a id="pKey_0" name="pKey_0" class="mass-act" onClick="atribuiValor(this);"><?php echo _('NO') ?></a>
                                                  </li>
                                                </ul>
                                              </div>                                            
                                            </td>
                                          </tr>
                                        </tbody>
                                      </table>
                                    </div>
                                  </div>
                                  <div class="row form-group">
                                    <div class="col-xs-12">
                                      <button id="btnReconfig" name="btnReconfig" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Configurar') . $modal_item ?></button>
                                    </div>
                                  </div>                                  
                                  </form>
                                </div>


                              </div>
                              <!-- fin tabs -->

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
        <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
      </body>
      </html>

<script>
	//carrega / atualiza lista de maquinas
	function carregaMaquinas(id)
	{
		idLocal = id.split("_");
		idLocal = idLocal[1];
		
		//Atualiza lista de maquinas
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_maquinas.php', // Informo a URL que será pesquisada.
			data: 'id='+idLocal,
			success: function(html)
			{	
				//
				var arrayMaq = html.split(";");
				qtdMaq = eval(arrayMaq.length) - 1;
				
				//limpa tabela
				$('#tabelaListaMaquinas tbody tr').remove();
				
				//
				//declara contadores
				var TotalMaq = 0;
				var TotalCreditos = 0;				
				var TotalEntrada = 0;
				var TotalSaida = 0;	
				var TotalLucro = 0;								
				
				//
				for (i = 0; i < qtdMaq; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayMaq[i].split(",");					
					
					//declara o uptime
					var upTime = $('#hd_'+arrayValores[0]).val();
					var upTimeNovo = arrayValores[10];
					
					
					
					/*
					
					if(arrayValores[0] == 2649)
					{
						alert(upTime);
						alert(upTimeNovo);		
					}*/
					
					
					
					
					
					if(upTimeNovo > upTime)
					{
						var cor = 'green';	
					}
					else
					{
						var cor = 'red';
					}
					$('#hd_'+arrayValores[0]).attr("value", arrayValores[10]);
				
					
					//monta a linha				
					$("#tabelaListaMaquinas tbody").append("<tr id='lnMaquina_"+arrayValores[6]+"' onClick='carregaDetalheMaquinas(this, "+arrayValores[2]+");' title='"+arrayValores[0]+"'><td><img src='img/"+cor+"ball.png' width='25px;'></td><td>"+arrayValores[0]+"</td><td><img src='images/"+arrayValores[1]+".png' width='40px;'></td><td>$ "+arrayValores[9]+"</td><td>$ "+arrayValores[3]+"</td><td>$ "+arrayValores[4]+"</td><td>$ "+arrayValores[11]+"</td></tr>");
					
					//alert(arrayValores[9]);
					var creditoIndividual = arrayValores[9];
					creditoIndividual = creditoIndividual.replace('.', '');
					creditoIndividual = creditoIndividual.replace('.', '');	
					TotalCreditos = eval(TotalCreditos) + eval(creditoIndividual);
					
					var entradaIndividual = arrayValores[3];
					entradaIndividual = entradaIndividual.replace('.', '');
					entradaIndividual = entradaIndividual.replace('.', '');	
					TotalEntrada = eval(TotalEntrada) + eval(entradaIndividual);
					
					var saidaIndividual = arrayValores[4];
					saidaIndividual = saidaIndividual.replace('.', '');
					saidaIndividual = saidaIndividual.replace('.', '');	
					TotalSaida = eval(TotalSaida) + eval(saidaIndividual);
					
					var lucroIndividual = arrayValores[11];
					lucroIndividual = lucroIndividual.replace('.', '');
					lucroIndividual = lucroIndividual.replace('.', '');	
					TotalLucro = eval(TotalLucro) + eval(lucroIndividual);															
						
					TotalMaq++;
								
				}
				//
				TotalCreditos = eval(TotalCreditos).formatNumber(2,',','.');
				TotalCreditos = TotalCreditos.replace(',00', '');
				
				TotalEntrada = eval(TotalEntrada).formatNumber(2,',','.');
				TotalEntrada = TotalEntrada.replace(',00', '');	
				
				TotalSaida = eval(TotalSaida).formatNumber(2,',','.');
				TotalSaida = TotalSaida.replace(',00', '');
				
				TotalLucro = eval(TotalLucro).formatNumber(2,',','.');
				TotalLucro = TotalLucro.replace(',00', '');												
				
				//monta linha de totais
				$("#tabelaListaMaquinas tbody").append("<tr id='lnMaquina_Totais'><td><strong>Totales: </strong></td><td><strong>"+TotalMaq+"</strong></td><td>&nbsp;</td><td><strong>$ "+TotalCreditos+"</strong></td><td><strong>$ "+TotalEntrada+"</strong></td><td><strong>$ "+TotalSaida+"</strong></td><td><strong>$ "+TotalLucro+"</strong></td></tr>");				
				

				
				//muda o nome do local selecionado
				$("#localSelecionado").text(arrayValores[7]);
				$("#localSelecionado").attr("title", arrayValores[8]);
			}
		});		
	}
	
	//carrega os detalhes da maquina
	function carregaDetalheMaquinas(obj, disp)
	{
		$('#confDet').slideDown("slow");
		$('#lstConf').slideUp("slow");
		idMaquina = obj.id.split("_");
		idMaquina = idMaquina[1];	
		
		lastPayout(idMaquina);
		lastBill(idMaquina);
		infoAtual(idMaquina);
		statistic(idMaquina);
		lastPrizes(idMaquina);
		configMaq(idMaquina);
		lastGames(idMaquina);
		
		//muda o txt da maquina selecionada
		$("#maqSelecionada").text(obj.title);
		$("#maqSelecionada").attr("title", disp);
		
	}
	
	//function last payout
	function lastPayout(id)
	{
		//consulta ultimos pagos dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_ultimosPagos.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayPagos = html.split(";");
				qtdPagos = eval(arrayPagos.length) - 1;
				
				//limpa tabela
				$('#tabelaUltimosPagos tbody tr').remove();
				
				
				//
				for (i = 0; i < qtdPagos; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayPagos[i].split("/");
					$("#tabelaUltimosPagos tbody").append("<tr><td>"+arrayValores[0]+"</td><td>"+arrayValores[1]+"</td></tr>");					
				}
			}
		});			
	}
	
	//function last bilhetes
	function lastBill(id)
	{
		//consulta ultimos pagos dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_ultimosBilhetes.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayBill = html.split(";");
				qtdBill = eval(arrayBill.length) - 1;
				
				//limpa tabela
				$('#tabelaUltimosBilhetes tbody tr').remove();
				
				
				//
				for (i = 0; i < qtdBill; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayBill[i].split(",");
					$("#tabelaUltimosBilhetes tbody").append("<tr><td>"+arrayValores[0]+"</td><td>"+arrayValores[1]+"</td></tr>");					
				}
			}
		});			
	}	
	
	//function info maquina
	function infoAtual(id)
	{
		//consulta ultimas informacoes
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_infos.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayInfo = html.split(";");
				qtdInfo = eval(arrayInfo.length) - 1;
				
				//limpa tabela
				$('#tabelaInfoAtual tbody tr').remove();
				
				//
				for (i = 0; i < qtdInfo; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayInfo[i].split(",");
					$("#tabelaInfoAtual tbody").append("<tr><td>Num Dispositivo:</td><td>"+arrayValores[0]+"</td></tr><tr><td>Juego:</td><td>"+arrayValores[1]+"</td></tr><tr><td>Fecha Actual:</td><td>"+arrayValores[2]+"</td></tr><tr><td>Fecha Expiración:</td><td>"+arrayValores[3]+"</td></tr><tr><td>IP:</td><td>"+arrayValores[4]+"</td></tr><tr><td>Versión:</td><td>"+arrayValores[5]+"</td></tr><tr><td>Creditos:</td><td>$ "+arrayValores[6]+"</td></tr><tr><td>Creditos Promo:</td><td>$ "+arrayValores[7]+"</td></tr>");					
				}
			}
		});			
	}
	
	//function Statistic
	function statistic(id)
	{
		//consulta ultimas informacoes
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_statistics.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayInfo = html.split(";");
				qtdInfo = eval(arrayInfo.length) - 1;
				
				//limpa tabela
				$('#tabelaStatistic tbody tr').remove();
				
				//
				for (i = 0; i < qtdInfo; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayInfo[i].split(",");
					$("#tabelaStatistic tbody").append("<tr><td>Entrada:</td><td>"+arrayValores[0]+"</td><td>"+arrayValores[0]+"</td></tr><tr><td>Valor Pagado:</td><td>"+arrayValores[1]+"</td><td>"+arrayValores[1]+"</td></tr><tr><td>Valor Jugado:</td><td>"+arrayValores[2]+"</td><td>"+arrayValores[2]+"</td></tr><tr><td>Valor Ganado:</td><td>"+arrayValores[3]+"</td><td>"+arrayValores[3]+"</td></tr><tr><td>Valor Jugadas Dobladas:</td><td>"+arrayValores[4]+"</td><td>"+arrayValores[4]+"</td></tr><tr><td>Valor Dobladas Ganadas:</td><td>"+arrayValores[5]+"</td><td>"+arrayValores[5]+"</td></tr><tr><td>Entrada Promocional:</td><td>"+arrayValores[6]+"</td><td>"+arrayValores[6]+"</td></tr><tr><td>Juegos Jugados:</td><td>"+arrayValores[7]+"</td><td>"+arrayValores[7]+"</td></tr><tr><td>Juegos Ganados:</td><td>"+arrayValores[8]+"</td><td>"+arrayValores[8]+"</td></tr><tr><td>Dobladas Jugadas:</td><td>"+arrayValores[9]+"</td><td>"+arrayValores[9]+"</td></tr><tr><td>Dobladas Ganadas:</td><td>"+arrayValores[10]+"</td><td>"+arrayValores[10]+"</td></tr><tr><td>Jackpot Pagado:</td><td>"+arrayValores[11]+"</td><td>"+arrayValores[11]+"</td></tr><tr><td>Big Acumulado Pagado:</td><td>"+arrayValores[12]+"</td><td>"+arrayValores[12]+"</td></tr><tr><td>Acumulado Pagado:</td><td>"+arrayValores[13]+"</td><td>"+arrayValores[13]+"</td></tr><tr><td>Diferencial:</td><td>"+arrayValores[14]+"</td><td>"+arrayValores[14]+"</td></tr>");					
				}
			}
		});			
	}
	
	
	//function ultimos premios (grandes)
	function lastPrizes(id)
	{
		//consulta ultimos premios dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_ultimosPremios.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayPagos = html.split(";");
				qtdPagos = eval(arrayPagos.length) - 1;
				
				//limpa tabela
				$('#tabelaUltimosPremios tbody tr').remove();
				
				
				//
				for (i = 0; i < qtdPagos; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayPagos[i].split("/");
					$("#tabelaUltimosPremios tbody").append("<tr><td>$ "+arrayValores[0]+"</td><td>"+arrayValores[1]+"</td><td>"+arrayValores[2]+"</td></tr>");					
				}
			}
		});			
	}	
	
	//function carrega config
	function configMaq(id)
	{
		//consulta configs dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_config.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayValores = html.split(",");				
				
				$("#input_tipoMoeda").text(arrayValores[0]);
				$("#input_denom").text(arrayValores[1]);
				$("#input_pct").text(arrayValores[2]);				
				$("#input_tipoMaq").text(arrayValores[3]);
				$("#bigAcuMin").attr("value", arrayValores[4]);
				$("#bigAcuMax").attr("value", arrayValores[5]);
				$("#bigAcuAtu").attr("value", arrayValores[6]);
				$("#AcuMin").attr("value", arrayValores[7]);
				$("#AcuMax").attr("value", arrayValores[8]);			
				$("#AcuAtu").attr("value", arrayValores[9]);
				$("#vlJack").attr("value", arrayValores[10]);
				$("#input_LimDobra").text(arrayValores[11]);
				$("#input_db").text(arrayValores[12]);
				$("#input_FamBig").text(arrayValores[13]);
				$("#input_FavBig").text(arrayValores[14]);				
				$("#input_Fam").text(arrayValores[15]);
				$("#input_Fav").text(arrayValores[16]);
				$("#input_LimCobrar").text(arrayValores[17]);
				$("#input_pKey").text(arrayValores[18]);												
			}
		});		
	}

	//troca valor de uma config
	function atribuiValor(obj)
	{
		//
		var tpCombo = obj.id.split("_");
		tpCombo = tpCombo[0];
		
		$('#input_'+tpCombo).text(obj.text);
		
		//$('#select_'+tpCombo+'_Maquina').text(obj.text);
		//$('#input_'+tpCombo+'_Maquina').attr("value", obj.text);	
	}

	//function ultimos jogos
	function lastGames(id)
	{
		//consulta ultimos pagos dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_ultimosJogos.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayGame = html.split("/");
				qtdGame = eval(arrayGame.length) - 1;
				
				var conteudoDiv = "";

				
				
				//monta todos os jogos
				for (i = 0; i < qtdGame; i++) 
				{
					var arrayValores = arrayGame[i].split(";");

					
					
					//verifica se é a primeira div
					if(i==0)
					{
						var divAtiva = " active";	
					}
					else
					{
						var divAtiva = "";
					}	
					
					//verifica se pagou alguma linha
					if(arrayValores[27] == '')
					{
						linhas = '';	
					}
					else
					{
						var linhas = '';					
						linhas = linhas + "style='";
						linhas = linhas + "background-image:url(images/lineas/linea"+arrayValores[27]+".png)";
						
						//verifica se tem mais linhas
						for(x = 28; x < 47; x++)
						{
							if(arrayValores[x] > 0)
							{
								linhas = linhas + ",url(images/lineas/linea"+arrayValores[x]+".png)";
							}							
						}

						
						
						linhas = linhas + ";";
						linhas = linhas + "background-repeat:no-repeat;'";	

					}
					
					
										
					var conteudoDiv = conteudoDiv + "<div class='item"+divAtiva+"' style='background-image:url(images/reels/fundo.png);background-repeat:no-repeat;background-size:100% auto;' title'"+arrayValores[15]+"'><table "+linhas+"><tr><td><img src='images/reels/"+arrayValores[0]+".png'></td><td><img src='images/reels/"+arrayValores[1]+".png'></td><td><img src='images/reels/"+arrayValores[2]+".png'></td><td><img src='images/reels/"+arrayValores[3]+".png'></td><td><img src='images/reels/"+arrayValores[4]+".png'></td></tr><tr><td><img src='images/reels/"+arrayValores[5]+".png'></td><td><img src='images/reels/"+arrayValores[6]+".png'></td><td><img src='images/reels/"+arrayValores[7]+".png'></td><td><img src='images/reels/"+arrayValores[8]+".png'></td><td><img src='images/reels/"+arrayValores[9]+".png'></td></tr><tr><td><img src='images/reels/"+arrayValores[10]+".png'></td><td><img src='images/reels/"+arrayValores[11]+".png'></td><td><img src='images/reels/"+arrayValores[12]+".png'></td><td><img src='images/reels/"+arrayValores[13]+".png'></td><td><img src='images/reels/"+arrayValores[14]+".png'></td></tr></table><div class='carousel-caption'>Juego: "+(i+1)+" / "+qtdGame+"</div><br><br><div class='col-xs-4 col-md-4'><table class='table table-striped table-hover'><tbody><tr><td>Lineas:</td><td>"+arrayValores[25]+"</td></tr><tr><td>Total Apuesta:</td><td>"+arrayValores[26]+"</td></tr><tr><td>Creditos Anteriores:</td><td>"+arrayValores[15]+"</td></tr><tr><td>Creditos Posteriores:</td><td>"+arrayValores[16]+"</td></tr><tr><td>Total Ganado:</td><td>"+arrayValores[17]+"</td></tr></tbody></table></div><div class='col-xs-4 col-md-4'><table class='table table-striped table-hover'><tbody><tr><td>Premios en Rodillos:</td><td>"+arrayValores[18]+"</td></tr><tr><td>Bonus 1:</td><td>"+arrayValores[19]+"</td></tr><tr><td>Bonus 2:</td><td>"+arrayValores[20]+"</td></tr><tr><td>Bonus 3:</td><td>"+arrayValores[21]+"</td></tr></tbody></table></div><div class='col-xs-4 col-md-4'><table class='table table-striped table-hover'><tbody><tr><td>Big Acumulado Pagado:</td><td>"+arrayValores[22]+"</td></tr><tr><td>Jackpot Pagado:</td><td>"+arrayValores[23]+"</td></tr><tr><td>Acumulado Pagado:</td><td>"+arrayValores[24]+"</td></tr></tbody></table></div></div>";	
				}
				
				$("#div_jogos").html(conteudoDiv);
			}
		});			
	}	

	//reconfigura a maquina
	$('#btnReconfig').click( function (){
	//declara todos os valores para passar
		var arrayValores = '';
		var arrayValores = arrayValores + $(input_tipoMoeda).text() + ';';
		var arrayValores = arrayValores + $(input_denom	).text() + ';';
		var arrayValores = arrayValores + $(input_pct).text() + ';';
		var arrayValores = arrayValores + $(input_tipoMaq).text() + ';';	
		var arrayValores = arrayValores + $('#bigAcuMin').val() + ';';
		var arrayValores = arrayValores + $('#bigAcuMax').val() + ';';
		var arrayValores = arrayValores + $('#bigAcuAtu').val() + ';';
		var arrayValores = arrayValores + $('#AcuMin').val() + ';';
		var arrayValores = arrayValores + $('#AcuMax').val() + ';';
		var arrayValores = arrayValores + $('#AcuAtu').val() + ';';
		var arrayValores = arrayValores + $('#vlJack').val() + ';';
		var arrayValores = arrayValores + $(input_LimDobra).text() + ';';
		var arrayValores = arrayValores + $(input_db).text() + ';';
		var arrayValores = arrayValores + $(input_FamBig).text() + ';';
		var arrayValores = arrayValores + $(input_FavBig).text() + ';';
		var arrayValores = arrayValores + $(input_Fam).text() + ';';
		var arrayValores = arrayValores + $(input_Fav).text() + ';';
		var arrayValores = arrayValores + $(input_LimCobrar).text() + ';';
		var arrayValores = arrayValores + $(input_pKey).text() + ';';
		var arrayValores = arrayValores + $('#maqSelecionada').attr('title') + ';';	
		
		var idLoc = $('#localSelecionado').attr('title');
		
																		
		//consulta ultimos pagos dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/reconfig_online.php', // Informo a URL que será pesquisada.
			data: 'valores='+arrayValores+'&idLocal='+idLoc,
			success: function(html)
			{	
				if(html==0)
				{
					alert("Error!");	
				}
				else
				{
					$('#divConfig').fadeOut("slow");
					
					
					
					//atribui a maquina selecionada
					var idDisp = $('#maqSelecionada').attr("title");
					var idMaquina = idDisp; //buscar numero da placa selecionada.
					
					setTimeout(
					function() 
					{
						configMaq(idMaquina);
						$('#divConfig').fadeIn("slow");
						location.reload();
					}, 3000);																
				}

			}
		});	
		
		return false;	
	});
	
	/*
	//consulta status 
	setInterval(function()
	{
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_statusLocal.php', // Informo a URL que será pesquisada.
			data: '',
			success: function(html)
			{	
				//
				var arrayStatus = html.split(";");
				qtdLoc = eval(arrayStatus.length) - 1;
				
				//
				for (i = 0; i < qtdLoc; i++) 
				{
					//pega novos valores
					var arrayValores = arrayStatus[i].split(",");

					//consulta o ultimo uptime desse local
					var upTime = $('#status_loc_'+arrayValores[0]).val();
					
					
					//verifica se o uptime atual é maior que o antigo
					if(upTime < arrayValores[1])
					{
						//alert("maior = Online");
						$('#imgLoc_'+arrayValores[0]).attr('src','img/greenball.png');
						$("#txtStatus_"+arrayValores[0]).text('Online');
					}
					else
					{
						//alert("igual = off");	
						$('#imgLoc_'+arrayValores[0]).attr('src','img/redball.png');
						$("#txtStatus_"+arrayValores[0]).text('Offline');
					}
					
					//guarda uptime de cada maquina
					$('#status_loc_'+arrayValores[0]).attr("value", arrayValores[1]);	
				}				
			}
		});
		
		//sincroniza algumas informacoes
		//pegar o id do ultimo local selecionado.
		var idLocalSelecionado = $("#localSelecionado").attr("title");
		var idMaquina = $("#maqSelecionada").attr("title");

		
		//roda funcoes sincronizadoras
		carregaMaquinas('lnLocal_'+idLocalSelecionado);	//efetuar isso em cada maquina	
		infoAtual(idMaquina);
		statistic(idMaquina);
		lastBill(idMaquina);
		lastPayout(idMaquina);
		lastPrizes(idMaquina);
		
				
	}, 3000);*/
	
	
	$('#ver_config_maquinas').click( function (){
		$('#lstConf').slideDown("slow");
		$('#confDet').slideUp("slow");
	});
	



</script>