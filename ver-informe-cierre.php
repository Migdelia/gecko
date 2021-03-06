<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//pega o id do fechamento
$id_fechamento = $_GET['id'];


//consulta responsavel leitura
$sql_responsa = "
	SELECT
		leitura.id_login,
		leitura.id_tipo_local AS id_tp_local,
		leitura.semana,
		leitura.data_fechamento,
		logins.nome
	FROM
		leitura
	INNER JOIN logins ON leitura.id_operador = logins.id_login
	WHERE
		leitura.id_fechamento = '".$id_fechamento."'
	LIMIT 1			
	";
$query_responsa=@mysql_query($sql_responsa);
$resultado_responsa=@mysql_fetch_assoc($query_responsa);

//echo $sql_responsa;

//declara o nome do responsavel
$resp = $resultado_responsa['nome'];
$id_resp = $resultado_responsa['id_login'];


//consulta os fechamentos 
$sql_fechamentos = "SELECT
						fechamento.*,
						logins.nome
					FROM
						fechamento
					INNER JOIN
						logins
					ON
						fechamento.id_login = logins.id_login
					WHERE
						fechamento.id_fechamento = ". $id_fechamento ."
					ORDER BY
						id_fechamento DESC";
$query_fechamento=@mysql_query($sql_fechamentos);
$res_fechamento=@mysql_fetch_assoc($query_fechamento);

//echo $sql_fechamentos ;


if($resultado_responsa['id_tp_local'] == 1)
{
	//consulta os dados das leituras desse fechamento

	$sql_leit = "SELECT
					leitura.id_leitura,
					leitura.`data`,
					leitura.fat_bruto,
					leitura.total_desconto,
					`local`.nome,
					leitura.id_leitura,
					leitura.pct_local as percentual,
					leitura.id_tipo_local as id_tp_local,
					'1' AS id_tp_local_especial,
					leitura.id_local,
					leitura.pct_operador,
					leitura.pct_gerente,				
					'leit_norm' AS status,
					(
						SELECT
							(
								sum(`lpm`.`valor_entrada`)- sum(`lpm`.`valor_saida`)
							)
						FROM
							(
								`leitura_por_maquina` `lpm`
								JOIN `maquinas` ON(
									(
										`lpm`.`id_maquina` = `maquinas`.`id_maquina`
									)
								)
							)
						WHERE
							(
								(
									`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`
								)
								AND(`maquinas`.`porc_socio` <> 0)
							)
						GROUP BY
							`lpm`.`id_leitura`
					)AS `faturamento_socio`
				FROM
					leitura
				INNER JOIN
					`local`
				ON
					leitura.id_local = `local`.id_local
				INNER JOIN
					leitura_por_maquina
				ON
					leitura.id_leitura = leitura_por_maquina.id_leitura
				WHERE
					leitura.id_fechamento = '".$id_fechamento."'
			UNION
				SELECT
					leitura.id_leitura,
					leitura.`data`,
					leitura.fat_bruto,
					leitura.total_desconto,
					`local`.nome,
					leitura.id_leitura,
					leitura.pct_local as percentual,
					'1' AS id_tp_local,
					leitura.id_tipo_local AS id_tp_local_especial,
					leitura.id_local,
					leitura.pct_operador,
					leitura.pct_gerente,				
					'leit_ext' AS status,
					(
						SELECT
							(
								sum(`lpm`.`valor_entrada`)- sum(`lpm`.`valor_saida`)
							)
						FROM
							(
								`leitura_por_maquina` `lpm`
								JOIN `maquinas` ON(
									(
										`lpm`.`id_maquina` = `maquinas`.`id_maquina`
									)
								)
							)
						WHERE
							(
								(
									`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`
								)
								AND(`maquinas`.`porc_socio` <> 0)
							)
						GROUP BY
							`lpm`.`id_leitura`
					)AS `faturamento_socio`
				FROM
					leitura
				INNER JOIN
					`local`
				ON
					leitura.id_local = `local`.id_local
				INNER JOIN
					leitura_por_maquina
				ON
					leitura.id_leitura = leitura_por_maquina.id_leitura
				WHERE
					leitura.id_operador = " . $id_resp ."
				AND
					leitura.data_fechamento = '". $resultado_responsa['data_fechamento'] ."'
				AND
					leitura.id_tipo_local <> 1
				AND
					leitura.fechada = 1	
			GROUP BY
				leitura.id_leitura";
				
				//echo $sql_leit;	
}
else if($resultado_responsa['id_tp_local'] == 6)
{
	//
	$sql_leit = "SELECT
					leitura.id_leitura,
					leitura.`data`,
					leitura.fat_bruto,
					leitura.total_desconto,
					`local`.nome,
					leitura.id_leitura,
					leitura.pct_local as percentual,
					leitura.id_tipo_local as id_tp_local,
					leitura.id_local,
					leitura.pct_operador,
					leitura.pct_gerente,				
					'leit_norm' AS status,
					(
						SELECT
							(
								sum(`lpm`.`valor_entrada`)- sum(`lpm`.`valor_saida`)
							)
						FROM
							(
								`leitura_por_maquina` `lpm`
								JOIN `maquinas` ON(
									(
										`lpm`.`id_maquina` = `maquinas`.`id_maquina`
									)
								)
							)
						WHERE
							(
								(
									`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`
								)
								AND(`maquinas`.`porc_socio` <> 0)
							)
						GROUP BY
							`lpm`.`id_leitura`
					)AS `faturamento_socio`
				FROM
					leitura
				INNER JOIN
					`local`
				ON
					leitura.id_local = `local`.id_local
				INNER JOIN
					leitura_por_maquina
				ON
					leitura.id_leitura = leitura_por_maquina.id_leitura
				WHERE
					leitura.id_fechamento = '".$id_fechamento."'
			GROUP BY
				leitura.id_leitura";	
}
else
{

	//consulta leitura desse fechamento
	$sql_leit = "SELECT
					leitura.*,
					`local`.nome,
					leitura.id_tipo_local as id_tp_local,
					leitura.pct_local as percentual,
					leitura.pct_operador,
					leitura.pct_gerente
				FROM
					leitura
				INNER JOIN
					`local`
				ON
					leitura.id_local = `local`.id_local
				WHERE
					id_fechamento =  " . $id_fechamento;
}

$query_leit=@mysql_query($sql_leit);	

//echo $sql_leit;

//
$sql_info_fecha = "SELECT semana, data_fechamento FROM leitura WHERE id_fechamento =  " . $id_fechamento . " LIMIT 1";

//echo $sql_info_fecha . "////<br>"; 
$query_info_fecha=@mysql_query($sql_info_fecha);
$res_info_fecha=@mysql_fetch_assoc($query_info_fecha);


//consulta gastos desse fechamento
$sql_gastos_fecha = "SELECT
						SUM(valor_desconto) as desconto
					FROM
						desconto_leit_fecha
					WHERE
						id_leitura_fechamento = ".$id_fechamento."
					AND
						fechamento = 1";
$query_gastos_fecha=@mysql_query($sql_gastos_fecha);
$res_gastos_fecha=@mysql_fetch_assoc($query_gastos_fecha);


// *aquiiiii
?>

<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings-print.php"); // se llaman todos los metatags, css y librerías js ?>
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
                <?php echo _('Informe de Cierre') ?>
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons-info-cierre.php"); // btns paneles ?>
              <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
             
            </div>
          </div>

          <div id="relFechamento" class="row">
            <div class="col-xs-12">
              <div class="panel">
                <div class="panel-heading" style="height:0px;">
                  <div class="input-wrap">
                    <div class="row">
                      <div class="col-xs-4"><?php echo _('<strong>Cierre Semana</strong>: '.$res_info_fecha['semana']) . " de " . date("M-Y", strtotime($res_info_fecha['data_fechamento'])); ?></div>
                      <div class="col-xs-4"><?php echo _('<strong>Responsable</strong>'). ': ' . $res_fechamento['nome'] ?></div>
                      <div class="col-xs-4"><?php echo _('<strong>Fecha de Cierre:</strong> '.date("d-m-Y", strtotime($res_fechamento['data_fechamento']))); ?></div>
                    </div>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="col-xs-12">
                    <div class="table-responsive">
                      <table  class="table table-striped table-hover">
                        <thead>
                          <tr>
                          	<!---
                            <th class="left-align">
                              <div class="row">
                                <?php echo _('General') ?>
                              </div>
                            </th>-->
                            <th class="left-align" colspan="4">
                              <div class="row">
                                <div class="col-xs-12" style="font-size:18px;">
									<?php echo _('Total a Pagar: $ ');?>
                                    <span id="totalPagar"></span>
                                </div>
                              </div>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td class="left-align"><?php echo _('<strong>Total Entrada:</strong>'); ?></td>
                            <td class="left-align">$ <span id="totalEntrada"></span></td>
                            <td class="left-align"><?php echo _('<strong>Total Salida: </strong>'); ?></td>
                            <td class="left-align">$ <span id="totalSaida"></span></td>
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
            <div class="col-xs-12 col-md-6 divInfoPrint">
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
                            <th class="left-align">&nbsp;
                            	    	
                            </th>     
                            <th class="left-align tdInvisible">
                              <?php echo _('Ver') ?>
                            </th>                            
                          </tr>
                        </thead>
                        <tbody>
						
                        <?php
							$totalLeituras = 0;
							$totalCom = 0;
							$idTipoLocal = 0;
							while($dados_leit=@mysql_fetch_assoc($query_leit))
							{
								//declara o tipo de local
								if($idTipoLocal == 0)
								{
									$idTipoLocal = $dados_leit['id_tp_local'];
								}
								
								
								//
								$sql_dif = "SELECT
												SUM(
													desconto_leit_fecha.valor_desconto
												) as total_diferenca
											FROM
												desconto_leit_fecha
											WHERE
												id_maquina <> 0
											AND id_leitura_fechamento = ".$dados_leit['id_leitura']."
											AND leitura = 1";
								$query_dif=@mysql_query($sql_dif);
								$res_dif=@mysql_fetch_assoc($query_dif);
								
								//echo $res_dif['total_diferenca'] . "<br>";
								
								//
								$sql_des = "SELECT
												SUM(
													desconto_leit_fecha.valor_desconto
												) as total_desp
											FROM
												desconto_leit_fecha
											WHERE
												id_maquina = 0
											AND id_leitura_fechamento = ".$dados_leit['id_leitura']."
											AND leitura = 1";
								$query_des=@mysql_query($sql_des);
								$res_des=@mysql_fetch_assoc($query_des);								
								
								
								
								
								
								//calcula o valor a pagar por leitura
								if($dados_leit['id_tp_local'] == 1) //rua
								{
									//verifica se tem desconto
									$desconto = $res_des['total_desp'];
									$diferenca = $res_dif['total_diferenca'];
									
									
									//echo $desconto . " --- <br>";
									
									//echo $dados_leit['status'] . "  ---- <br>";
									
									//calcula valor final da leitura
									if($dados_leit['status'] == 'leit_ext')
									{	
																		
										$vl_leitura = $dados_leit['fat_bruto'];
										$vl_leitura = $vl_leitura - $desconto;
										$vl_leitura = ($vl_leitura * 20 ) / 100;
										
										//echo $vl_leitura . "///<br>";
										
										// verifica o tipo de local especial
										
										if($dados_leit['id_tp_local_especial'] == 6)
										{
											//
											//$vl_leitura = $dados_leit['fat_bruto'];	
											//$vl_leitura = 0;
											
											//consultar o valor do local dessa leitua
											$sql_vlLocalEsp = "SELECT
																	ROUND(SUM((((valor_entrada - valor_saida) * pct_esp_maq) / 100)))  as pctLocal
																FROM
																	leitura_por_maquina
																WHERE
																	id_leitura = " . $dados_leit['id_leitura'];
											$qry_vlLocalEsp=@mysql_query($sql_vlLocalEsp);
											$res_vlLocalEsp=@mysql_fetch_assoc($qry_vlLocalEsp);
											
											//
											$vl_leitura = $res_vlLocalEsp['pctLocal'];
																	
																	
											
											
										}
										
										
										
									}
									else
									{
										/*verificar se esse leitura tem alguma maquina especial --- Erico*Erico */ 
										
										
										//verifica se tem maquinas com pct especial
										$sql_maq_esp = "SELECT
															leitura_por_maquina.valor_entrada - leitura_por_maquina.valor_saida as fat_especial,
															leitura_por_maquina.pct_esp_maq as porc_maquina
														FROM
															leitura_por_maquina
														WHERE
															id_leitura = ". $dados_leit['id_leitura'] ."
														AND
															leitura_por_maquina.pct_esp_maq > 0";
															
										$query_maq_esp=@mysql_query($sql_maq_esp);
										$NumeroLinhasMaqEsp = mysql_num_rows($query_maq_esp);															
										
										//
										if($NumeroLinhasMaqEsp > 0)
										{
											//echo $dados_leit['id_leitura'] . "//" . $fatBruto . "<br>";
											
											//soma fat especial
											$fatEspecialBruto = 0;
											$fatEspecialPct = 0;
											while($dados_maq_esp=@mysql_fetch_assoc($query_maq_esp))
											{
												$fatEspecialBruto = $fatEspecialBruto + $dados_maq_esp['fat_especial'];
												$fatEspecialPct = $fatEspecialPct + (($dados_maq_esp['fat_especial'] * $dados_maq_esp['porc_maquina']) / 100);
											}
											//
											$fatNormal = $dados_leit['fat_bruto'] - $fatEspecialBruto;
											
											//
											$vl_leitura_normal = ($fatNormal - (($fatNormal * $dados_leit['percentual']) / 100)) - $desconto;
											$vl_leitura_especial = ($fatEspecialBruto - $fatEspecialPct);
											
											
											//echo $fatNormal . " --- " . $fatEspecialBruto . "<br>";

											//
											$vl_leitura = $vl_leitura_normal + $vl_leitura_especial;
											
											
										}
										else
										{
										
											//echo $dados_leit['fat_bruto'] . " // " . $diferenca . "<br>";	
											
											//
											if($diferenca >= 0)
											{
											
												//$fatBruto = $dados_leit['fat_bruto'] - $diferenca;											
												$fatBruto = $dados_leit['fat_bruto'];											
											}
											else
											{
												$fatBruto = $dados_leit['fat_bruto'];											
											}
											$vl_leitura = ($fatBruto - (($fatBruto * $dados_leit['percentual']) / 100)) - $desconto;									
										}
									}
																		
									//calcula valor total de comissao operador
									$totalCom = $totalCom + (($vl_leitura * $dados_leit['pct_operador']) / 100);
									
									//soma o total leituras
									$totalLeituras = $totalLeituras + $vl_leitura;
								}
								else if($dados_leit['id_tp_local'] == 2)//proprio com socio
								{
									//verifica se tem desconto
									$desconto = $res_des['total_desp'];
									$diferenca = $res_dif['total_diferenca'];
									
									//calcula valor final da leitura
									$vl_leitura = ($dados_leit['fat_bruto'] - $desconto);
									
									//calcula valor total de comissao operador
									$totalCom = $totalCom + (($vl_leitura * $dados_leit['pct_gerente']) / 100);
									
									//soma o total leituras
									$totalLeituras = $totalLeituras + $vl_leitura;									
								}
								else if($dados_leit['id_tp_local'] == 4)//proprio
								{
									//verifica se tem desconto
									$desconto = $res_des['total_desp'];
									$diferenca = $res_dif['total_diferenca'];
									
									//echo "descontos: " . $desconto . "<br>";
									//echo "diferenca: " . $diferenca;
									
									//calcula valor final da leitura
									//$vl_leitura = ($dados_leit['fat_bruto'] - $desconto);
									$vl_leitura = ($dados_leit['fat_bruto']);
									
									//calcula valor total de comissao operador
									$totalCom = $totalCom + (($vl_leitura * $dados_leit['pct_gerente']) / 100);
									
									//soma o total leituras
									$totalLeituras = $totalLeituras + $vl_leitura;									
								}
								else if($dados_leit['id_tp_local'] == 6) //especial
								{
									//verifica se tem desconto
									$desconto = $res_des['total_desp'];
									$diferenca = $res_dif['total_diferenca'];
									
									//echo $desconto . " --- <br>";
									
									//echo $dados_leit['status'] . "  ---- <br>";
									
									//calcula valor final da leitura
									if($dados_leit['status'] == 'leit_ext')
									{										
										$vl_leitura = $dados_leit['fat_bruto'];
										$vl_leitura = $vl_leitura - $desconto;
										$vl_leitura = ($vl_leitura * 20 ) / 100;
									}
									else
									{
										/*verificar se esse leitura tem alguma maquina especial --- Erico*/ 
										
										
										//verifica se tem maquinas com pct especial
										$sql_maq_esp = "SELECT
															leitura_por_maquina.valor_entrada - leitura_por_maquina.valor_saida as fat_especial,
															leitura_por_maquina.pct_esp_maq as porc_maquina
														FROM
															leitura_por_maquina
														WHERE
															id_leitura = ". $dados_leit['id_leitura'] ."
														AND
															leitura_por_maquina.pct_esp_maq > 0";
															
										$query_maq_esp=@mysql_query($sql_maq_esp);
										$NumeroLinhasMaqEsp = mysql_num_rows($query_maq_esp);															
										
										//
										if($NumeroLinhasMaqEsp > 0)
										{
											//echo $dados_leit['id_leitura'] . "//" . $fatBruto . "<br>";
											
											//soma fat especial
											$fatEspecialBruto = 0;
											$fatEspecialPct = 0;
											while($dados_maq_esp=@mysql_fetch_assoc($query_maq_esp))
											{
												$fatEspecialBruto = $fatEspecialBruto + $dados_maq_esp['fat_especial'];
												$fatEspecialPct = $fatEspecialPct + (($dados_maq_esp['fat_especial'] * $dados_maq_esp['porc_maquina']) / 100);
											}
											//
											$fatNormal = $dados_leit['fat_bruto'] - $fatEspecialBruto;
											
											//
											$vl_leitura_normal = ($fatNormal - (($fatNormal * $dados_leit['percentual']) / 100)) - $desconto;
											$vl_leitura_especial = ($fatEspecialBruto - $fatEspecialPct);
											
											
											//echo $fatNormal . " --- " . $fatEspecialBruto . "<br>";

											//
											$vl_leitura = $vl_leitura_normal + $vl_leitura_especial;
											
											
										}
										else
										{
											
											
											//$fatBruto = $dados_leit['fat_bruto'] - $diferenca;
											$fatBruto = $dados_leit['fat_bruto'] - $diferenca;
											$vl_leitura = ($fatBruto - (($fatBruto * $dados_leit['percentual']) / 100)) - $desconto;									
										}
									}
																		
									//calcula valor total de comissao operador
									if($dados_leit['id_tp_local'] == 6)
									{
										$totalCom = $totalCom + ((0 * $dados_leit['pct_operador']) / 100);										
									}
									else
									{
										$totalCom = $totalCom + (($vl_leitura * $dados_leit['pct_operador']) / 100);
									}
									
									//soma o total leituras
									$totalLeituras = $totalLeituras + $vl_leitura;
								}
																
						?>
                                <tr>
                                  <td class="left-align"><?php echo date("d-m-Y", strtotime($dados_leit['data']));?></td>
                                  <td class="left-align"><?php echo $dados_leit['nome'];?></td>
                                  <td class="left-align"><?php 
                                   if($vl_leitura<0){
                            	    echo "$ <b style='color:red';>" . number_format($vl_leitura,0,"","."); "</b>";

                                    }else{
                            	      echo "$ " . number_format($vl_leitura,0,"","."); 

                                    }
                                    ?>
                                   
                                   </td>
                                  <td class="left-align">
									  <?php
									  	//
										if($desconto > 0 and $diferenca > 0) // diferenca e desconto / vermelho
										{
											echo "<img src='img/redball.png' width='20' title=''>";	
										}
										else
										{
											if($desconto > 0) // desconto / laranja
											{
												//consulta gastos dessa leituera
												$sql_detalhe_gastos = "SELECT * FROM desconto_leit_fecha WHERE id_leitura_fechamento = " . $dados_leit['id_leitura'] . " AND leitura = 1 AND id_maquina = 0";
												$query_detalhe_gastos=@mysql_query($sql_detalhe_gastos);												
												
												//
												echo "<img src='img/orangeball.png' width='20' title='Gastos de Lectura: ";
												while($dados_detalhe_gastos=@mysql_fetch_assoc($query_detalhe_gastos))
												{
													echo "
- " . $dados_detalhe_gastos['descricao'] . "($ " . number_format($dados_detalhe_gastos['valor_desconto'],0,"",".") . ")";
												}
												
												echo "'>";	
											}
											else if($diferenca > 0) // diferenca / amarelo
											{
												//consulta gastos dessa leituera
												$sql_detalhe_dif = "SELECT * FROM desconto_leit_fecha WHERE id_leitura_fechamento = " . $dados_leit['id_leitura'] . " AND leitura = 1 AND id_maquina <> 0";
												$query_detalhe_dif=@mysql_query($sql_detalhe_dif);												
												
												//
												echo "<img src='img/yellowball.png' width='20' title='Diferencia de Maquina: ";
												while($dados_detalhe_dif=@mysql_fetch_assoc($query_detalhe_dif))
												{
													echo "
- " . $dados_detalhe_dif['descricao'] . "($ " . number_format($dados_detalhe_dif['valor_desconto'],0,"",".") . ")";
												}
												
												echo "'>";														
											}											
										}
                                      ?>
                                  </td>
                                  <td class="left-align tdInvisible">
                                  <a href="ver-informe-lectura.php?id=<?php echo $dados_leit['id_leitura']; ?>" class="btn btn-sm" target="_blank" title="Ver"><i class="fa fa-eye"></i></a>
                                  </td>
                                  
                                </tr>                        
                        <?php	
							}
						?>                        	
                        </tbody>
                        <tfoot style="background-color: #0DA4E7;">
                          <tr>
                            <td colspan="2"  style="color: white">Subtotal</td>
                            <td class="left-align" style="color: white"><strong>$ <span id="totalLeitura"><?php echo number_format($totalLeituras,0,"","."); ?></span></strong></td>
                            <td>&nbsp;</td>
                            <td class="tdInvisible">&nbsp;</td>
                          </tr>
                        </tfoot>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-md-6 divInfoPrint">
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
                            <th class="left-align tdInvisible">
                              <?php echo _('Detalle') ?>
                            </th>                            
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td class="left-align"><?php echo date("d-m-Y", strtotime($res_fechamento['data_fechamento']));?></td>
                              <td class="left-align">Rendición de <strong>cierre</strong></td>
                              <td class="left-align"><?php 
                               if($res_gastos_fecha['desconto']<0){
                            	echo "$ <b style='color:red';>" . number_format($res_gastos_fecha['desconto'],0,"","."); "</b>";

                               }else{
                            	 echo "$ " . number_format($res_gastos_fecha['desconto'],0,"","."); 

                               }

                              ?></td>
                              <td class="left-align tdInvisible"><a id="ver_rendicao" class="btn btn-sm" target="_blank" title="Ver">Ver</a></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo date("d-m-Y", strtotime($res_fechamento['data_fechamento']));?></td>
                              <td class="left-align">Comisión</td>
                              <td class="left-align"><?php 
                               if ($totalCom<0) {
                               echo "$ <b style='color:red';>" . number_format($totalCom,0,"","."); "</b>";
                               }else{
                            	 echo "$ " . number_format($totalCom,0,"","."); 

                               }

                               ?></td>
                              <td class="left-align tdInvisible"><a id="ver_comissao" class="btn btn-sm" target="_blank" title="Ver">Ver</a></td>
                            </tr> 
                            
                            
                            <!--- só mostra em caso de local com socio -->
                            <?php
								if($idTipoLocal == 2 or $idTipoLocal == 4)
								{
									//buscar se existe maquinas de socio nesse fechamento para descontar 20%
									$sql_leit_maq_soc = "
										SELECT
											leitura_por_maquina.id_leitura,
											leitura_por_maquina.valor_entrada - leitura_por_maquina.valor_saida AS sub_total,
											leitura_por_maquina.pct_maq_socio as porc_socio
										FROM
											leitura_por_maquina
										INNER JOIN leitura ON leitura_por_maquina.id_leitura = leitura.id_leitura
										WHERE
											leitura.id_fechamento = '".$id_fechamento."'
										AND
											leitura_por_maquina.maq_socio = 'true'
										";
									$query_leit_maq_soc=@mysql_query($sql_leit_maq_soc);	
									
									$vl_tot_porc_socio=0;
									while ($dados_leit_maq_soc=@mysql_fetch_assoc($query_leit_maq_soc))  //aquii
									{
										$vl_tot_porc_socio = $vl_tot_porc_socio + (($dados_leit_maq_soc['sub_total'] * 20) /100);
									}									
															
									
									//echo $totalLeituras;
									//$lucroSocio = ((((($totalLeituras * 80) / 100) - $totalCom - $res_gastos_fecha['desconto']) *50) /100) + $vl_tot_porc_socio;	
									$lucroSocio = 0;
									//echo $lucroSocio . " ---<br>";
									
									//calcula pct de calabaza
									//echo $totalLeituras;
									$pctCalabaza = ($totalLeituras * 20) / 100;
									//$pctCalabaza = $pctCalabaza - $vl_tot_porc_socio;	
										/*
									if($idTipoLocal == 2)//com socio
									{
								
							?>
                            
                            <tr>
                              <td class="left-align"><?php echo date("d-m-Y", strtotime($res_fechamento['data_fechamento']));?></td>
                              <td class="left-align">Lucro Socio</td>
                              <td class="left-align">$ <?php echo number_format($lucroSocio,0,"",".") ?></td>
                              <td class="left-align tdInvisible">&nbsp;</a></td>
                            </tr> 
                            
							<?php
									}
									*/
							?>
                            <tr>
                              <td class="left-align"><?php echo date("d-m-Y", strtotime($res_fechamento['data_fechamento']));?></td>
                              <td class="left-align">20% Calabaza</td>
                              <td class="left-align"><?php 
                              	if($pctCalabaza<0){
                            	echo "$ <b style='color:red';>" . number_format($pctCalabaza,0,"","."); "</b>";
 								}else{
                            	 echo "$ " . number_format($pctCalabaza,0,"","."); 

                            	}
                             ?></td>
                              <td class="left-align tdInvisible">&nbsp;</a></td>
                            </tr>
                            <?php									
								}
							?>
                            
                            <!-- só mostra em caso de local com socio -->                                                                                    
                        </tbody>
                        
                        <?php
							if($idTipoLocal == 2)//com socio
							{							
								//soma total de saidas
								$totalSaidas = $totalCom + $res_gastos_fecha['desconto'] + $lucroSocio + $pctCalabaza;
							}
							else if($idTipoLocal == 4)
							{
								//soma total de saidas
								$totalSaidas = $totalCom + $res_gastos_fecha['desconto'] + $pctCalabaza;
							}
							else
							{
								//soma total de saidas
								$totalSaidas = $totalCom + $res_gastos_fecha['desconto'];								
							}
							
						?>
                        
                        <tfoot style="background-color: #0DA4E7;">
                          <tr>
                            <td style="color: white">&nbsp;</td>
                            <td style="color: white" class="left-align"><strong>Subtotal: </strong></td>
                            <td class="left-align" style="color: white"><strong>$ <span id="totalGastos"><?php echo number_format($totalSaidas,0,"",".") ?></span></strong></td>
                            <td style="color: white" class="tdInvisible">&nbsp;</td>
                          </tr>
                        </tfoot>
                      </table>
                      
  
            
					<?php
                    
                        //consulta gastos (faturas / boletas)
                        $sql_detalhe_gastos_vale = "SELECT
                                                        desconto_leit_fecha.*,
                                                        'Lectura' as tipo
                                                    FROM
                                                        desconto_leit_fecha
                                                    INNER JOIN
                                                        leitura
                                                    ON
                                                        desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
                                                    WHERE
                                                        desconto_leit_fecha.leitura = 1
                                                    AND 
                                                        leitura.id_fechamento = ". $id_fechamento ."
                                                    AND 
                                                        tipo_doc == 'vale'
                                                UNION
                                                    SELECT
                                                        *, 'Cierre' AS tipo
                                                    FROM
                                                        desconto_leit_fecha
                                                    WHERE
                                                        fechamento = 1
                                                    AND 
                                                        id_leitura_fechamento = ". $id_fechamento ."
                                                    AND 
                                                        tipo_doc == 'vale'																
                                                    
                                                    ORDER BY 
                                                        id_descricao,
                                                        tipo";
                        $query_detalhe_gastos_vale=@mysql_query($sql_detalhe_gastos_vale);
                        $NumeroLinhasVale = mysql_num_rows($query_detalhe_gastos_vale);
                        
                    
                    ?>
                    <div id="div_detalhe_comissao" class="col-xs-12 col-md-12" style="display:none;">
                      <div class="panel">
                        <div class="panel-heading">
                          <div class="input-wrap">
                            <?php echo _('Detalle comisión') ?>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="col-xs-12">
                            <div class="table-responsive">
                              <table  class="table table-striped table-hover">
                                <thead>
                                  <tr>
                                    <th class="left-align sort-asc">
                                      <?php echo _('Local') ?>
                                    </th> 
                                    <th class="left-align sort-asc">
                                      <?php echo _('$ Valor') ?>
                                    </th>                                                      
                                  </tr>
                                </thead>
                                <tbody>
                                    <tr class="left-align sort-asc">
                                        <td class="left-align">
                                          <strong><?php echo _('Fecha') ?></strong>                            
                                        </td> 
                                        <td class="left-align">
                                          <strong><?php echo _('Valor') ?></strong>                            
                                        </td> 
                                    </tr>  
                                    
                                    
                                    <?php
                                        //
                                        $query_comissao_leitura=@mysql_query($sql_leit);
                                        
                                        //
                                        $tot_comissao = 0;
                                        while($dados_comissao_leitura=@mysql_fetch_assoc($query_comissao_leitura))
                                        {
                                            //verifica o tipo de local
                                            if($idTipoLocal == 1)
                                            {
                                                //calcula comissao do operador desse local
                                                //verifica se tem desconto
                                                $desconto = $dados_comissao_leitura['total_desconto'];
                                                $diferenca = $dados_comissao_leitura['total_diferenca'];
                                                
                                                //calcula valor final da leitura
												if($dados_comissao_leitura['status'] == 'leit_ext')
												{
													$fatSoc = ($dados_comissao_leitura['faturamento_socio'] * 20) / 100;
												}
												else
												{
													$fatSoc = 0;
												}
												
												
												
												
												//consultar faturamento de maquinas especiais *** erico
												//verifica se tem maquinas com pct especial
												$sql_maq_esp = "SELECT
																	leitura_por_maquina.valor_entrada - leitura_por_maquina.valor_saida as fat_especial,
																	leitura_por_maquina.pct_esp_maq as porc_maquina
																FROM
																	leitura_por_maquina
																WHERE
																	id_leitura = ". $dados_comissao_leitura['id_leitura'] ."
																AND
																	leitura_por_maquina.pct_esp_maq > 0";
																	
												$query_maq_esp=@mysql_query($sql_maq_esp);
												$NumeroLinhasMaqEsp = mysql_num_rows($query_maq_esp);		
												
												
												//
												if($NumeroLinhasMaqEsp > 0)
												{
													
													//soma fat especial
													$fatEspecialBruto = 0;
													$fatEspecialPct = 0;
													while($dados_maq_esp=@mysql_fetch_assoc($query_maq_esp))
													{
														$fatEspecialBruto = $fatEspecialBruto + $dados_maq_esp['fat_especial'];
														$fatEspecialPct = $fatEspecialPct + (($dados_maq_esp['fat_especial'] * $dados_maq_esp['porc_maquina']) / 100);
													}
													//
													$fatNormal = $dados_comissao_leitura['fat_bruto'] - $fatEspecialBruto;
													
													//
													$vl_leitura_normal = ($fatNormal - (($fatNormal * $dados_comissao_leitura['percentual']) / 100)) - $desconto;
													$vl_leitura_especial = ($fatEspecialBruto - $fatEspecialPct);
													
													
													//echo $fatNormal . " --- " . $fatEspecialBruto . "<br>";
		
													//
													$vl_leitura = $vl_leitura_normal + $vl_leitura_especial;
													
													
												}
												else
												{
													
												
													$vl_leitura = ($dados_comissao_leitura['fat_bruto'] - (($dados_comissao_leitura['fat_bruto'] * $dados_comissao_leitura['percentual']) / 100)) - $desconto;

												}												
												

												
												
												
												if($dados_comissao_leitura['id_tp_local_especial'] == 6)
												{
													//consultar o valor do local dessa leitua
													$sql_vlLocalEsp = "SELECT
																			ROUND(SUM((((valor_entrada - valor_saida) * pct_esp_maq) / 100)))  as pctLocal
																		FROM
																			leitura_por_maquina
																		WHERE
																			id_leitura = " . $dados_comissao_leitura['id_leitura'];
													$qry_vlLocalEsp=@mysql_query($sql_vlLocalEsp);
													$res_vlLocalEsp=@mysql_fetch_assoc($qry_vlLocalEsp);
													
													//
													$vl_leitura = $res_vlLocalEsp['pctLocal'];												
	 
													
													//calcula valor total de comissao operador
													//echo $vl_leitura . "<br>";
													$comissao_por_local = ($vl_leitura * $dados_comissao_leitura['pct_operador']) / 100;
												}
												else
												{
													//calcula valor total de comissao operador
													$comissao_por_local = ($vl_leitura * $dados_comissao_leitura['pct_operador']) / 100;													
												}											
                                            }
																					
                    
                    
                    
                                                echo "<tr class='left-align sort-asc'>";
                                                echo "<td class='left-align'>";
                                                echo $dados_comissao_leitura['nome'];
                                                echo "</td>";
                                                echo "<td class='left-align'>";	
                                                if($comissao_por_local<0){
                            	               	echo "$ <b style='color:red';>" . number_format($comissao_por_local,0,"","."); "</b>";

                            					}else{
                            	 				echo "$ " . number_format($comissao_por_local,0,"","."); 

                           						}
				
                                               
                                                echo "</td>";
                                                echo "</tr>";	
                                                
                                                //
                                                $tot_comissao = $tot_comissao + $comissao_por_local;
                    
                    
                                        }
                                    ?>
                                    
                                    
                                                            
                                </tbody>
                                <tfoot style="background-color: #0DA4E7;">
                                  <tr>
                                    <td class="left-align" style="color: white"><strong>Subtotal: </strong></td>
                                    <td class="left-align" style="color: white"><strong>$ <span id="totalLeitura"><?php echo number_format($tot_comissao,0,"","."); ?></span></strong></td>
                    
                                  </tr> 
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                      
                      
                      
                      
                      
                      
                              
                    <?php
                        //consulta gastos (faturas / boletas)
                        $sql_detalhe_gastos_fat = "SELECT
                                                        desconto_leit_fecha.*,
                                                        'Lectura' as tipo
                                                    FROM
                                                        desconto_leit_fecha
                                                    INNER JOIN
                                                        leitura
                                                    ON
                                                        desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
                                                    WHERE
                                                        desconto_leit_fecha.leitura = 1
                                                    AND 
                                                        leitura.id_fechamento = ". $id_fechamento ."
                                                    AND 
                                                        tipo_doc <> 'vale'
                                                UNION
                                                    SELECT
                                                        *, 'Cierre' AS tipo
                                                    FROM
                                                        desconto_leit_fecha
                                                    WHERE
                                                        fechamento = 1
                                                    AND 
                                                        id_leitura_fechamento = ". $id_fechamento ."
                                                    AND 
                                                        tipo_doc <> 'vale'																
                                                    
                                                    ORDER BY 
                                                        id_descricao,
                                                        tipo";
                        $query_detalhe_gastos_fat=@mysql_query($sql_detalhe_gastos_fat);
                        $NumeroLinhasFat = mysql_num_rows($query_detalhe_gastos_fat);
					
                        
                        //
                        if($NumeroLinhasFat > 0)
                        {				
                        
                    ?>
                    <div id="div_rend_fat" class="col-xs-12 col-md-12" style="display:none;">
                      <div class="panel">
                        <div class="panel-heading">
                          <div class="input-wrap">
                            <?php echo _('Detalle Rendición <strong>Facturas / Boletas</strong>') ?>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="col-xs-12">
                            <div class="table-responsive">
                              <table  class="table table-striped table-hover">
                                <thead>
                                  <tr>
                                    <th class="left-align">
                                      <strong><?php echo _('Fecha') ?></strong>                            
                                    </th> 
                                    <th class="left-align">
                                      <strong><?php echo _('Tipo') ?></strong>                            
                                    </th> 
                                    <th class="left-align">
                                      <strong><?php echo _('Num Doc') ?></strong>                            
                                    </th> 
                                    <th class="left-align">
                                      <strong><?php echo _('Detalle') ?></strong>                            
                                    </th> 
                                    <th class="left-align">
                                      <strong><?php echo _('$ valor') ?></strong>                            
                                    </th>                         
                                  </tr>
                                </thead>
                                <tbody>
                                    
                                        
                                          
                                                                                 
                                      
                                    
                                    
                                    <?php
                                        
                                        //
                                        $tot_gast_fat = 0;
										$centroCusto = 1;
										$doc_adm = 0;
										$doc_mkt = 0;
										$doc_man = 0;
										$doc_pes = 0;
										$doc_ext = 0;										
                                        while($dados_detalhe_gastos_fat=@mysql_fetch_assoc($query_detalhe_gastos_fat))
                                        {
											//
											$centroCustoNovo = $dados_detalhe_gastos_fat['id_descricao'];
											
											//
											if($centroCusto !== $centroCustoNovo)
											{
												echo "<tr class='left-align sort-asc'>";
												echo "<td colspan='4' class='left-align sort-asc' bgcolor='#007BB3' style='color:#FFF;'>";
												
												//consulta nome centro de custo
												$sql_nome_cc = "SELECT id_desconto, descricao FROM tipo_desconto WHERE id_desconto = " . $centroCustoNovo;
												$query_nome_cc=@mysql_query($sql_nome_cc);
												$res_nome_cc=@mysql_fetch_assoc($query_nome_cc);
												
												echo "<strong> " . $res_nome_cc['descricao'] . " </strong>";
												echo "</td>";
												echo "<td class='left-align sort-asc' bgcolor='#007BB3' style='color:#FFF;'>";
												echo "<strong><span id='sp_doc_".$res_nome_cc['id_desconto']."'></span></strong>";
												echo "</td>";												
												echo "</tr>";
												$centroCusto = $dados_detalhe_gastos_fat['id_descricao'];												
											}
											
											//
                                            echo "<tr class='left-align sort-asc'>";
                                            echo "<td class='left-align'>";
                                            echo date("d-m-Y", strtotime($dados_detalhe_gastos_fat['data_desconto']));
                                            echo "</td>";
                                            echo "<td class='left-align'>";
                                            echo $dados_detalhe_gastos_fat['tipo'];
                                            echo "</td>";
                                            echo "<td class='left-align'>";
                                            echo $dados_detalhe_gastos_fat['num_doc'];
                                            echo "</td>";
                                            echo "<td class='left-align'>";
                                            echo $dados_detalhe_gastos_fat['descricao'];
                                            echo "</td>";
                                            echo "<td class='left-align'>";
                                            if($dados_detalhe_gastos_fat['valor_desconto']<0){
                            	            echo "$ <b style='color:red';>" . number_format($dados_detalhe_gastos_fat['valor_desconto'],0,"","."); "</b>";

                                            }else{
                            				 echo "$ " . number_format($dados_detalhe_gastos_fat['valor_desconto'],0,"","."); 
 
                            				}

                                            echo "</td>";
                                            echo "</tr>";	
                                            
                                            //
                                            $tot_gast_fat = $tot_gast_fat + $dados_detalhe_gastos_fat['valor_desconto'];
											
											//
											if($centroCusto == 1) //adm
											{
												$doc_adm = $doc_adm + $dados_detalhe_gastos_fat['valor_desconto'];
											}
											else if($centroCusto == 2)// mkt
											{
												$doc_mkt = $doc_mkt + $dados_detalhe_gastos_fat['valor_desconto'];
											}
											else if($centroCusto == 3)//personal
											{
												$doc_per = $doc_per + $dados_detalhe_gastos_fat['valor_desconto'];
											}
											else if($centroCusto == 4)//mantencion
											{
												$doc_man = $doc_man + $dados_detalhe_gastos_fat['valor_desconto'];
											}	
											else if($centroCusto == 5)//extra
											{
												$doc_ext = $doc_ext + $dados_detalhe_gastos_fat['valor_desconto'];
											}											
                                        }
                                    ?>
                                    
                                    <input type="hidden" id="hd_doc_adm" name="hd_doc_adm" value="<?php echo number_format($doc_adm,0,"","."); ?>" >
                                    <input type="hidden" id="hd_doc_mkt" name="hd_doc_mkt" value="<?php echo number_format($doc_mkt,0,"","."); ?>" >
                                    <input type="hidden" id="hd_doc_per" name="hd_doc_per" value="<?php echo number_format($doc_per,0,"","."); ?>" >
                                    <input type="hidden" id="hd_doc_Man" name="hd_doc_Man" value="<?php echo number_format($doc_man,0,"","."); ?>" >
                                    <input type="hidden" id="hd_doc_ext" name="hd_doc_ext" value="<?php echo number_format($doc_ext,0,"","."); ?>" >                                    
                                                            
                                </tbody>
                                <tfoot style="background-color: #0DA4E7;">
                                  <tr>
                                    <td colspan="2"  style="color: white">&nbsp;</td>
                                    <td style="color: white">&nbsp;</td>
                                    <td class="left-align" style="color: white"><strong>Subtotal: </strong></td>
                                    <td class="left-align" style="color: white"><strong>$ <span id="totalLeitura"><?php echo number_format($tot_gast_fat,0,"","."); ?></span></strong></td>
                    
                                  </tr> 
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                    
                    <?php
                        }
                    
                        //consulta gastos (faturas / boletas)
                        $sql_detalhe_gastos_vale = "SELECT
                                                        desconto_leit_fecha.*,
                                                        'Lectura' as tipo
                                                    FROM
                                                        desconto_leit_fecha
                                                    INNER JOIN
                                                        leitura
                                                    ON
                                                        desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
                                                    WHERE
                                                        desconto_leit_fecha.leitura = 1
                                                    AND 
                                                        leitura.id_fechamento = ". $id_fechamento ."
                                                    AND 
                                                        tipo_doc = 'vale'
                                                UNION
                                                    SELECT
                                                        *, 'Cierre' AS tipo
                                                    FROM
                                                        desconto_leit_fecha
                                                    WHERE
                                                        fechamento = 1
                                                    AND 
                                                        id_leitura_fechamento = ". $id_fechamento ."
                                                    AND 
                                                        tipo_doc = 'vale'																
                                                    
                                                    ORDER BY 
                                                        id_descricao,
                                                        tipo";
                        $query_detalhe_gastos_vale=@mysql_query($sql_detalhe_gastos_vale);
                        $NumeroLinhasVale = mysql_num_rows($query_detalhe_gastos_vale);
                    
                        //
                        if($NumeroLinhasVale > 0)
                        {
                    
                    ?>
                        <div class="panel-heading">
                          <div class="input-wrap">
                            <?php echo _('Detalle Rendición <strong>Vale </strong>') ?>
                          </div>
                        </div>
                        <div class="panel-body">
                          <div class="col-xs-12">
                            <div class="table-responsive">
                              <table  class="table table-striped table-hover">
                                <thead>
                                    <tr class="left-align sort-asc">
                                        <th class="left-align">
                                          <strong><?php echo _('Fecha') ?></strong>                            
                                        </th> 
                                        <th class="left-align">
                                          <strong><?php echo _('Tipo') ?></strong>                            
                                        </th> 
                                        <th class="left-align">
                                          <strong><?php echo _('Num Doc') ?></strong>                            
                                        </th> 
                                        <th class="left-align">
                                          <strong><?php echo _('Detalle') ?></strong>                            
                                        </th> 
                                        <th class="left-align">
                                          <strong><?php echo _('$valor') ?></strong>                            
                                        </th> 
                                    </tr>  
                                </thead>
                                <tbody>

                                    
                                    
                                    <?php
                    
                    
                                        
                                        //
                                        $tot_gast_vale = 0;
										$vale_adm = 0;
										$vale_mkt = 0;
										$vale_man = 0;
										$vale_pes = 0;
										$vale_ext = 0;
										$centroCusto = 1;
                                        while($dados_detalhe_gastos_vale=@mysql_fetch_assoc($query_detalhe_gastos_vale))
                                        {
											//
											$centroCustoNovo = $dados_detalhe_gastos_vale['id_descricao'];
											
											//
											if($centroCusto !== $centroCustoNovo)
											{
												
												//echo "mudou de centro de costo <br>"; // colocar o contador em 0
												
												echo "<tr class='left-align sort-asc'>";
												echo "<td colspan='4' class='left-align sort-asc' bgcolor='#007BB3' style='color:#FFF;'>";
												
												//consulta nome centro de custo
												$sql_nome_cc = "SELECT id_desconto, descricao FROM tipo_desconto WHERE id_desconto = " . $centroCustoNovo;
												$query_nome_cc=@mysql_query($sql_nome_cc);
												$res_nome_cc=@mysql_fetch_assoc($query_nome_cc);
												
												echo "<strong> " . $res_nome_cc['descricao'] . " </strong>";
												echo "</td>";
												echo "<td class='left-align sort-asc' bgcolor='#007BB3' style='color:#FFF;'>";
												echo "<strong><span id='sp_vale_".$res_nome_cc['id_desconto']."'></span></strong>";
												echo "</td>";												
												echo "</tr>";
												$centroCusto = $dados_detalhe_gastos_vale['id_descricao'];	
									
											}								
											
                                            echo "<tr class='left-align sort-asc'>";
                                            echo "<td class='left-align'>";
                                            echo date("d-m-Y", strtotime($dados_detalhe_gastos_vale['data_desconto']));
                                            echo "</td>";
                                            echo "<td class='left-align'>";
                                            echo $dados_detalhe_gastos_vale['tipo'];
                                            echo "</td>";
                                            echo "<td class='left-align'>";
                                            echo $dados_detalhe_gastos_vale['num_doc'];
                                            echo "</td>";
                                            echo "<td class='left-align'>";
                                            echo $dados_detalhe_gastos_vale['descricao'];
                                            echo "</td>";
                                            echo "<td class='left-align'>";
                                            if($dados_detalhe_gastos_vale['valor_desconto']<0){
                            	            echo "$ <b style='color:red';>" . number_format($dados_detalhe_gastos_vale['valor_desconto'],0,"","."); "</b>";

                                            }else{
                            	            echo "$ " . number_format($dados_detalhe_gastos_vale['valor_desconto'],0,"","."); 

                           					 }

                                            echo "</td>";
                                            echo "</tr>";	
                                            
                                            //
                                            $tot_gast_vale = $tot_gast_vale + $dados_detalhe_gastos_vale['valor_desconto'];		


											
											//
											if($centroCusto == 1) //adm
											{
												$vale_adm = $vale_adm + $dados_detalhe_gastos_vale['valor_desconto'];
											}
											else if($centroCusto == 2)// mkt
											{
												$vale_mkt = $vale_mkt + $dados_detalhe_gastos_vale['valor_desconto'];
											}
											else if($centroCusto == 3)//personal
											{
												$vale_per = $vale_per + $dados_detalhe_gastos_vale['valor_desconto'];
											}
											else if($centroCusto == 4)//mantencion
											{
												$vale_man = $vale_man + $dados_detalhe_gastos_vale['valor_desconto'];
											}	
											else if($centroCusto == 5)//extra
											{
												$vale_ext = $vale_ext + $dados_detalhe_gastos_vale['valor_desconto'];
											}																														
                                        }	
										
						
																																								
                                    ?>
                                    
                                    <input type="hidden" id="hd_vale_Adm" name="hd_vale_Adm" value="<?php echo number_format($vale_adm,0,"","."); ?>" >
                                    <input type="hidden" id="hd_vale_Mkt" name="hd_vale_Mkt" value="<?php echo number_format($vale_mkt,0,"","."); ?>" >
                                    <input type="hidden" id="hd_vale_Per" name="hd_vale_Per" value="<?php echo number_format($vale_per,0,"","."); ?>" >
                                    <input type="hidden" id="hd_vale_Man" name="hd_vale_Man" value="<?php echo number_format($vale_man,0,"","."); ?>" >
                                    <input type="hidden" id="hd_vale_Ext" name="hd_vale_Ext" value="<?php echo number_format($vale_ext,0,"","."); ?>" >
                                                            
                                </tbody>
                                <tfoot style="background-color: #0DA4E7;">
                                  <tr>
                                    <td colspan="2"  style="color: white">&nbsp;</td>
                                    <td style="color: white">&nbsp;</td>
                                    <td class="left-align" style="color: white"><strong>Subtotal: </strong></td>
                                    <td class="left-align" style="color: white"><strong>$ <span id="totalLeitura"><?php echo number_format($tot_gast_vale,0,"","."); ?></span></strong></td>
                    
                                  </tr> 
                                </tfoot>
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    
                    <?php
                        }
                    ?>
                              

                      
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
            
            


            <!-- </div> -->

            <!-- <div class="row"> -->
            
            <!--
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
            
            -->
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>
</body>


<script language="javascript">

	setTimeout(
	function() 
	{
		//
		var totalEntrada = $('#totalLeitura').text();
		$("#totalEntrada").text(totalEntrada);
		
		var totalSaida = $('#totalGastos').text();
		$("#totalSaida").text(totalSaida);
		
		
		//limpa valores
		totalEntrada = totalEntrada.replace('.', '');
		totalEntrada = totalEntrada.replace('.', '');
		
		totalSaida = totalSaida.replace('.', '');
		totalSaida = totalSaida.replace('.', '');					
		
		//calcula total
		var totalPagar = eval(totalEntrada) - eval(totalSaida);
		
		//formata e atribui o total
		totalPagar = eval(totalPagar).formatNumber(2,',','.');
		totalPagar = totalPagar.replace(',00', '');		
		
		$("#totalPagar").text(totalPagar);
		
		totalPagar = totalPagar.replace('.', '');
		totalPagar = totalPagar.replace('.', '');

		var id_fech = "<?=$id_fechamento?>";

		$.post('functions/actualiza_valor_fechamento.php',{id:id_fech,pagar:totalPagar},function(json){
			
		  });	

		//pega os valores 
		docAdm = $("#hd_doc_adm").val();
		docMkt = $("#hd_doc_mkt").val();
		docPer = $("#hd_doc_per").val();
		docMan = $("#hd_doc_Man").val();
		docExt = $("#hd_doc_Ext").val();
		
		//atribui
		$("#sp_doc_1").text(docAdm);
		$("#sp_doc_2").text(docMkt);
		$("#sp_doc_3").text(docPer);
		$("#sp_doc_4").text(docMan);
		$("#sp_doc_5").text(docExt);


		//pega os valores 
		valeAdm = $("#hd_vale_Adm").val();
		valeMkt = $("#hd_vale_Mkt").val();
		valePer = $("#hd_vale_Per").val();
		valeMan = $("#hd_vale_Man").val();
		valeExt = $("#hd_vale_Ext").val();
		

		
		//atribui
		$("#sp_vale_1").text(valeAdm);
		$("#sp_vale_2").text(valeMkt);
		$("#sp_vale_3").text(valePer);
		$("#sp_vale_4").text(valeMan);
		$("#sp_vale_5").text(valeExt);
		
	}, 1000);
	
	
	//
	$('#exppdf').click( function() 
	{
		window.print() ; /// aquiiiii Erico		
	});


	//
	$('#ver_rendicao').click( function() 
	{

		//
		if($(this).text() == 'Ver')
		{
			$('#div_rend_fat').slideDown("slow");
			//$('#div_rend_vale').slideDown("slow");		
			
			//mudar o botao DE VER RENDICAO para ocultar
			$(this).text("Ocultar");
		}
		else
		{
			$('#div_rend_fat').slideUp("slow");
			//$('#div_rend_vale').slideUp("slow");		
			
			//mudar o botao DE VER RENDICAO para ocultar
			$(this).text("Ver");
		}
	});
	
	//
	$('#ver_comissao').click( function() 
	{
		//
		if($(this).text() == 'Ver')
		{
			$('#div_detalhe_comissao').slideDown("slow");
			
			//mudar o botao DE VER RENDICAO para ocultar
			$(this).text("Ocultar");
		}
		else
		{
			$('#div_detalhe_comissao').slideUp("slow");		
			
			//mudar o botao DE VER RENDICAO para ocultar
			$(this).text("Ver");
		}		
		
	});	
	


</script>