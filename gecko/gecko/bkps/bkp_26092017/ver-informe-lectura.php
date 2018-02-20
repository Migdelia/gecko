<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//
$id_assoc = $_GET['id'];
$dtInicio = $_GET['dI'];
$dtFinal = $_GET['dF'];


//
/*
echo $id_assoc . "<br>";
echo $dtInicio . "<br>";
echo $dtFinal . "<br>";
*/


//Total de Gastos
$totalGastos = 0;

//consulta o id do local
$sql_id_local = "SELECT id_local, observacao, data, semana, data_fechamento, total_desconto, id_operador, id_gerente, pct_local, id_tipo_local, pct_operador, pct_gerente FROM leitura WHERE id_leitura = " . $id_assoc;
$query_id_local=@mysql_query($sql_id_local);
$result_id_local=@mysql_fetch_assoc($query_id_local);



//
if($dtInicio == '')
{
	//consulta as maquinas dessa leitura
	$sql_maquinas = "SELECT
						vw_maquinas.numero,
						vw_maquinas.id_maquina,
						leitura_por_maquina.entrada_oficial_atual as ent_oficial,
						leitura_por_maquina.saida_oficial_atual as sai_oficial,
						leitura_por_maquina.valor_entrada as ent_parcial,
						leitura_por_maquina.valor_saida as sai_parcial,
						leitura_por_maquina.maq_socio,
						leitura_por_maquina.pct_maq_socio as porc_socio,
						leitura_por_maquina.id_jogo,
						leitura_por_maquina.pct_esp_maq as porc_maquina,
						jogo.nome as jogo
					FROM
						leitura_por_maquina
					INNER JOIN
						vw_maquinas
					ON
						leitura_por_maquina.id_maquina = vw_maquinas.id_maquina
					INNER JOIN 
						jogo 
					ON 
						leitura_por_maquina.id_jogo = jogo.id_jogo											
					WHERE
						id_leitura =" . $id_assoc . "
					ORDER BY
						vw_maquinas.ordem_leitura,
						leitura_por_maquina.id_maquina					
						";	
}
else
{
		
	//consulta o total de gastos
	$sql_tot_gastos = "SELECT
							SUM(total_desconto) as total_desconto
						FROM
							leitura
						WHERE
							leitura.`data` >= '" . date("Y-m-d", strtotime($dtInicio)) . "'
						AND leitura.`data` <= '" . date("Y-m-d", strtotime($dtFinal)) . "'
						AND leitura.id_local = " . $result_id_local['id_local'];
						
	$query_tot_gastos=@mysql_query($sql_tot_gastos);
	$result_tot_gastos=@mysql_fetch_assoc($query_tot_gastos);	
	

	//consulta as maquinas dessa leitura
	$sql_maquinas = "SELECT
						vw_maquinas.numero,
						vw_maquinas.id_maquina,
						(leitura_por_maquina.entrada_oficial_atual - leitura_por_maquina.valor_entrada + (sum(leitura_por_maquina.valor_entrada))) as ent_oficial,
						(leitura_por_maquina.saida_oficial_atual - leitura_por_maquina.valor_saida + (sum(leitura_por_maquina.valor_saida))) as sai_oficial,
						sum(leitura_por_maquina.valor_entrada) as ent_parcial,
						sum(leitura_por_maquina.valor_saida) as sai_parcial,
						leitura_por_maquina.maq_socio,
						leitura_por_maquina.pct_maq_socio as porc_socio,
						leitura_por_maquina.id_jogo,
						leitura_por_maquina.pct_esp_maq as porc_maquina,
						jogo.nome as jogo
					FROM
						leitura_por_maquina
					INNER JOIN
						vw_maquinas
					ON
						leitura_por_maquina.id_maquina = vw_maquinas.id_maquina
					INNER JOIN 
						jogo 
					ON 
						leitura_por_maquina.id_jogo = jogo.id_jogo						
					WHERE
						leitura_por_maquina.data_cadastro >= '" . date("Y-m-d", strtotime($dtInicio)) . "'
					AND
						leitura_por_maquina.data_cadastro <= '" . date("Y-m-d", strtotime($dtFinal)) . "'
					AND
						leitura_por_maquina.id_local = " . $result_id_local['id_local'] . "
					GROUP BY
						id_maquina
					ORDER BY
						vw_maquinas.ordem_leitura,
						leitura_por_maquina.id_maquina					
						";	





	
}

	//echo $sql_maquinas . "<br>";
//				
$query_maquinas=@mysql_query($sql_maquinas);

//
if($result_tot_gastos['total_desconto'] == '')
{
	$totalGastos = 	$result_id_local['total_desconto'];
}
else
{
	$totalGastos = 	$result_tot_gastos['total_desconto'];
}


//consulta infos do local
$sql_info_local = "SELECT
					*
				FROM
					local
				WHERE
					id_local = " . $result_id_local['id_local'];
					
$query_info_local=@mysql_query($sql_info_local);
$result_info_local=@mysql_fetch_assoc($query_info_local);



//consulta a leitura seguinte e anterior a esse
$sql_leit_ant = "SELECT
					id_leitura,
					data
				FROM
					leitura
				WHERE
					id_local = ".$result_id_local['id_local']."
				AND id_leitura < ".$id_assoc."
				ORDER BY
					id_leitura DESC
				LIMIT 1";
$query_leit_ant=@mysql_query($sql_leit_ant);
$result_leit_ant=@mysql_fetch_assoc($query_leit_ant);

//
$sql_leit_seguinte = "SELECT
					id_leitura,
					data
				FROM
					leitura
				WHERE
					id_local = ".$result_id_local['id_local']."
				AND id_leitura > ".$id_assoc."
				ORDER BY
					id_leitura
				LIMIT 1";
$query_leit_seguinte=@mysql_query($sql_leit_seguinte);
$result_leit_seguinte=@mysql_fetch_assoc($query_leit_seguinte);	





//ver se a leitura é consolidada.



//consulta gastos de leitura abertos desse operador

if($dtInicio == '')
{
	$sql_gastos_abertos = "SELECT * FROM desconto_leit_fecha WHERE id_leitura_fechamento = ".$id_assoc." AND leitura = 1 AND id_maquina = 0";	
}
else
{
	$sql_gastos_abertos = "SELECT
								desconto_leit_fecha.*
							FROM
								desconto_leit_fecha
							INNER JOIN
								leitura
							ON
								desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura								
							WHERE
								leitura.`data` >= '" . date("Y-m-d", strtotime($dtInicio)) . "'
							AND
								leitura.`data` <= '" . date("Y-m-d", strtotime($dtFinal)) . "'
							AND
								leitura.id_local = " . $result_id_local['id_local'] . "
							AND
								leitura = 1
							AND
								id_maquina = 0";	
}


$query_gastos_abertos=@mysql_query($sql_gastos_abertos);
$num_gastos_abertos = mysql_num_rows($query_gastos_abertos);



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
                <?php	
						echo _('Informe de Lectura');
						//include("inc/buttons-loc-int.php"); 
				?>
                
                <?php 
				/*if($result_leit_ant['id_leitura'] <> ''){ ?>
                <a href="ver-informe-lectura.php?id=<?php echo $result_leit_ant['id_leitura']?>" class="btn" style="margin:0 0 0 10px;"><?php echo _('< Anterior '); ?></a>
                <?php } ?>
                
                <?php if($result_leit_seguinte['id_leitura'] <> ''){ ?>
                <a href="ver-informe-lectura.php?id=<?php echo $result_leit_seguinte['id_leitura']?>" class="btn" style="margin:0 0 0 10px;"><?php echo _('Seguiente > '); ?></a>
                <?php } */?>
              </h3>
            </div>
          
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons-info-lecturas.php"); // btns paneles ?>
              <?php include("inc/modals/modal-select-periodo.php"); // modal para agregar contenido ?>
            </div>
          </div>

            <div class="row">
                <div class="col-xs-12 col-md-12 col-lg-12 ">
                    <div class="col-xs-12 col-md-8 col-lg-8 divInfoLeitPrint">
                      <div class="panel">
                        <div class="panel-heading">
                            <strong><?php echo $result_info_local['nome'];?></strong>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            
                            <?php
							
								//verifica se o esta definida a data inicio e final 
								if($dtInicio == '')
								{
									$dtInicio = $result_leit_ant['data'];
								}
								else
								{
									$id_assoc = "Consolidada";	
								} 
								
								if($dtFinal == '')
								{
									$dtFinal = $result_id_local['data'];
								} 
								else
								{
									$id_assoc = "Consolidada";	
								}								
							
							?>                            
                            
                            
                            <strong>ID:</strong> <?php echo $id_assoc; ?> 
                            <!---
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Semana:</strong> <?php echo $result_id_local['semana'] . " del " . date("m-Y", strtotime($result_id_local['data_fechamento'])); ?>
                            --->
                            
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <strong>Período: &nbsp; </strong> <?php echo date("d-m-Y", strtotime($dtInicio)) . " &nbsp; <strong>-</strong> &nbsp; " . date("d-m-Y", strtotime($dtFinal)); ?>                            
                        </div>
                        <div class="panel-body">
                          <div class="col-xs-12">
                            <div class="table-responsive">
                              <table id="tableTeste" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                      <th class="left-align sort-asc">
                                        <?php echo _('Código') ?>
                                      </th>
                                      <th class="left-align">
                                        <?php echo _('Rol de Entrada') ?>
                                      </th>
                                      <th class="left-align">
                                        <?php echo _('Bruto') ?>
                                      </th>
                                      <th>
                                        <?php echo _('Rol de Salida') ?>
                                      </th>
                                      <th class="left-align">
                                        <?php echo _('Premio') ?>
                                      </th>
                                      <th class="left-align">
                                        <?php echo _('Subtotal') ?>
                                      </th>
                                      <th class="left-align">
                                        <?php echo _('% Local') ?>
                                      </th>
                                      <th class="left-align">
                                        <?php echo _('Total') ?>
                                      </th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <?php
									//declara totais
									$totalBruto = 0;
									$totalPremio = 0;
									$totalDif = 0;
									$totalLocal = 0;
									$totalProprio = 0;
									$i = 0;								
								
									//
									while($result_maq=@mysql_fetch_assoc($query_maquinas))
									{
										//
										if($id_assoc !== 'Consolidada')
										{
											//consulta se essa maquina tem diferenca.
											$sql_dif_maq = "SELECT
																*
															FROM
																desconto_leit_fecha
															WHERE
																id_maquina = ".$result_maq['id_maquina']."
															AND id_leitura_fechamento = ".$id_assoc."
															AND leitura = 1";
											$query_dif_maq=@mysql_query($sql_dif_maq);
											$result_dif_maq=@mysql_fetch_assoc($query_dif_maq);											
										}
										else
										{
											//consulta se essa maquina tem diferenca.
											$sql_dif_maq = "SELECT
																*
															FROM
																desconto_leit_fecha
															WHERE
																id_maquina = ".$result_maq['id_maquina']."
															AND 
																data_desconto >= '" . date("Y-m-d", strtotime($dtInicio)) . "'
															AND 
																data_desconto <= '" . date("Y-m-d", strtotime($dtFinal)) . "'
															AND 
																leitura = 1";
											$query_dif_maq=@mysql_query($sql_dif_maq);
											$result_dif_maq=@mysql_fetch_assoc($query_dif_maq);											
											
										}
										
										
										//echo $sql_dif_maq . "<br>";
										
										//calculos
										$bruto = $result_maq['ent_parcial'];
										$premio = $result_maq['sai_parcial'];
										$subTotal = $bruto - $premio;
										$ult_ent = $result_maq['ent_oficial'] - $bruto;
										$ult_sai = $result_maq['sai_oficial'] - $premio;
										//
										if($result_dif_maq['valor_desconto'] <> 0)
										{
											$dif_maq = $result_dif_maq['valor_desconto'];										
										}
										else
										{
											$dif_maq = 0;	
										}		
										
										//echo $dif_maq . "<br>";						
										
										//soma totais
										$totalBruto = $totalBruto + $bruto;
										$totalPremio = $totalPremio + $premio;
										$totalDif = $totalDif + $dif_maq;
										
										/*Verificar aqui para todos os tipos de locais se a maquina tem pct especial Erico*/
										
										//echo $result_maq['porc_maquina'] . "<br>"; 

										//verifica que tipo de local é
										if($result_id_local['id_tipo_local'] == 1) // rua
										{
											
											
											
											//
											if($result_maq['porc_maquina'] > 0)
											{
												//
												$dif_local = ($dif_maq * $result_maq['porc_maquina']) / 100;
												$dif_propria = ($dif_maq - $dif_local);		
	
												//$result_info_local['percentual']
												$pctLocal = ($subTotal * $result_maq['porc_maquina']) / 100;
												$pctPropria = $subTotal - $pctLocal;																							
											}
											else
											{
												//
												$dif_local = ($dif_maq * $result_id_local['pct_local']) / 100;
												$dif_propria = ($dif_maq - $dif_local);			
												
												//$result_info_local['percentual']
												$pctLocal = ($subTotal * $result_id_local['pct_local']) / 100;
												$pctPropria = $subTotal - $pctLocal;																						
											}
											
											//soma local / proprio
											$totalLocal = $totalLocal + $pctLocal - $dif_local;
											$totalProprio = $totalProprio + $pctPropria - $dif_propria;	
											$totalSala = $totalProprio;
								
										}
										else if($result_id_local['id_tipo_local'] == 2) // proprio com socio
										{
											//verifica se a maquina é de socio
											if($result_maq['maq_socio'] == 'true')
											{
												$pctLocal = ($subTotal * 20) / 100;
												$pctPropria = 0;
											}
											else
											{
												$pctLocal = 0;
												$pctPropria = ($subTotal * 20) / 100;													
											}
											
											
											//soma local / proprio
											$totalLocal = $totalLocal + $pctLocal;
											$totalProprio = $totalProprio + $pctPropria;
											$subTotalBruto = $subTotalBruto + $subTotal;
											$totalSala = $totalSala + (($subTotal * 80) / 100);									
											
										}
										else if($result_id_local['id_tipo_local'] == 3)// lan
										{
											$pctLocal = 0;
											$pctPropria = $subTotal;												
										}
										else if($result_id_local['id_tipo_local'] == 4) // proprio
										{
											//
											$pctLocal = 0;
											$pctPropria = ($subTotal * 20) / 100;													

											
											
											//soma local / proprio
											$totalLocal = $totalLocal + $pctLocal;
											$totalProprio = $totalProprio + $pctPropria;
											$subTotalBruto = $subTotalBruto + $subTotal;
											$totalSala = $totalSala + (($subTotal * 80) / 100);									
											
										}
										else
										{
											$pctLocal = 0;
											$pctPropria = $subTotal;												
										}
										
										

										$i++;
								?>
                                      <tr>
                                        <td class="left-align">
                                        	<strong><?php echo $result_maq['numero'] . "</strong><br><img src='images/".$result_maq['id_jogo'].".png' width='40px;' class='imgPrint' ><span class='txt_jogo'>" . $result_maq['jogo'] . "</span>"; ?>
                                        </td>
                                        <td class="left-align"><strong><u>$ <?php echo number_format($result_maq['ent_oficial'],0,"","."); ?></u></strong><br>$ <?php echo number_format($ult_ent,0,"","."); ?></td>
                                        <td class="left-align">$<?php echo number_format($bruto,0,"","."); ?></td>
                                        <td class="left-align"><strong><u>$ <?php echo number_format($result_maq['sai_oficial'],0,"","."); ?></u></strong><br>$ <?php echo number_format($ult_sai,0,"","."); ?></td>
                                        <td class="left-align">$ <?php echo number_format($premio,0,"","."); ?></td>
                                        <td class="left-align"><strong>$ <?php echo number_format($subTotal,0,"","."); ?></strong></td>
                                        <td class="left-align">$ <?php echo number_format($pctLocal,0,"","."); ?></td>
                                        <td class="left-align"><strong>$ <?php echo number_format($pctPropria,0,"","."); ?></strong></td>
                                      </tr>
                                <?php	
										//verifica se tem diferenca
										if($dif_maq <> 0)
										{
								?>
                                          <tr bgcolor="#FFFFCC">
                                            <td class="left-align"><strong>Diferencia maq (<?php echo $result_dif_maq['id_maquina'];?>):</strong></td>
                                            <td class="left-align" colspan="3"><strong><?php echo $result_dif_maq['descricao']; ?></strong></td>
                                            <td class="left-align"><strong>Valor:</strong></td>
                                            <td class="left-align"><strong>$ <?php echo number_format(($result_dif_maq['valor_desconto'] * (-1)),0,"","."); ?></strong></td>
                                            <td class="left-align">$ <?php echo number_format(($dif_local * (-1)),0,"","."); ?></td>
											<td class="left-align"><strong>$ <?php echo number_format(($dif_propria * (-1)),0,"","."); ?></strong></td>                                            
                                          </tr>                                
                                <?php										
										}
									}
								?>                             
                                </tbody>
                        		<tfoot style="background-color: #0DA4E7;">
                                      <tr>
                                        <td class="left-align" style="color: white"><strong><?php echo number_format($i,0,"","."); ?> Maquinas</strong></td>
                                        <td class="left-align" style="color: white">&nbsp;</td>
                                        <td class="left-align" style="color: white">$ <?php echo number_format($totalBruto,0,"","."); ?></td>
                                        <td class="left-align" style="color: white">&nbsp;</td>
                                        <td class="left-align" style="color: white">$ <?php echo number_format($totalPremio,0,"","."); ?></td>
                                        <td class="left-align" style="color: white">$ <?php echo number_format(($totalBruto - $totalPremio - $totalDif),0,"","."); ?></td>
                                        <td class="left-align" style="color: white">$ <?php echo number_format($totalLocal,0,"","."); ?></td>
                                        <td class="left-align" style="color: white"><strong>$ <?php echo number_format($totalProprio,0,"","."); ?></strong></td>
                                      </tr>                                   
                                </tfoot>                                
                              </table>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
            <!-- </div> -->

            <!-- <div class="row"> -->
                    <div class="col-xs-12 col-md-4 divTotLeit">

                      <div class="panel" >
                        <div class="panel-body">

                          <div class="table-responsive">
                            <table id="tableTeste2" class="table  table-hover">
                              <thead>
                                <tr>
                                  <th class="left-align sort-asc">
                                    <?php echo _('Totalizadores') ?>
                                  </th>
                                  <th class="right-align">Subtotal</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td class="left-align"><?php echo _('Total Entrada'); ?></td>
                                  <td class="right-align">$ <?php echo number_format($totalBruto,0,"","."); ?></td>
                                </tr>
                                <tr>
                                  <td class="left-align"><?php echo _('Total Salida'); ?></td>
                                  <td class="right-align">$ <?php echo number_format($totalPremio,0,"","."); ?></td>
                                </tr>
                                <tr>
                                  <td class="left-align"><?php echo _('Subtotal'); ?></td>
                                  <td class="right-align">$ <?php echo number_format($totalBruto - $totalPremio - $totalDif,0,"","."); ?></td>
                                </tr>    
                                
                                <?php		
									if($result_id_local['id_tipo_local'] <> 4)// proprio com socio
									{
								?>
                                                            
                                <tr>
                                  <td class="left-align"><?php echo _('Total Local'); ?></td>
                                  <td class="right-align">$ <?php echo number_format($totalLocal,0,"","."); ?></td>
                                </tr>     
                                
                                <?php
									}
								?>								
                                
                                                             
                                <tr>
                                  <td class="left-align"><?php echo _('Total Gastos'); ?></td>
                                  <td class="right-align">
                                  	$ <?php	echo number_format($totalGastos,0,"","."); ?>    
                                  </td>
                                </tr>                               
                              
                                                               
                                
                                
                                <?php
									//verifica se é local proprio com socio
									if($result_id_local['id_tipo_local'] == 1) //rua
									{
										$gastos = $totalGastos;
										$totalFinal =  $totalSala - $gastos;
									}
									else if($result_id_local['id_tipo_local'] == 2)// proprio com socio
									{
										//calcula comissao gerente
										$comGerente = ($subTotalBruto * $result_info_local['pct_gerente']) / 100;
										
										//calcula o total Final
										$totalFinal =  ((($totalSala - $comGerente) * 50) /100) + $totalProprio;
										$totalSocio =  ((($totalSala - $comGerente) * 50) /100) + $totalLocal;
								?>
                                    <tr>
                                      <td class="left-align"><?php echo _('Total Sala'); ?></td>
                                      <td class="right-align">$ <?php echo number_format($totalSala,0,"","."); ?></td>
                                    </tr> 
                                    <tr>
                                      <td class="left-align"><?php echo _('Comisión'); ?></td>
                                      <td class="right-align">$ <?php echo number_format($comGerente,0,"","."); ?></td>
                                    </tr> 
                                    <tr>
                                      <td class="left-align"><?php echo _('Total Socio'); ?></td>
                                      <td class="right-align">$ <?php echo number_format($totalSocio,0,"","."); ?></td>
                                    </tr>
                                                                         
                                                                    
                                <?php		
									}
									else if($result_id_local['id_tipo_local'] == 4)// proprio
									{
										//calcula comissao gerente
										$comGerente = ($subTotalBruto * $result_info_local['pct_gerente']) / 100;
										$totalFinal =  $subTotalBruto - $comGerente;
								?>
                                        <tr>
                                          <td class="left-align"><?php echo _('Comisión'); ?></td>
                                          <td class="right-align">$ <?php echo number_format($comGerente,0,"","."); ?></td>
                                        </tr>                           
                                <?php											
									}
								?>


                                <tr>
                                  <td class="left-align"><?php echo _('TOTAL'); ?></td>
                                  <td class="right-align"><strong>$ <?php echo number_format($totalFinal,0,"","."); ?></strong></td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-4 divTotLeit">

                      <div class="panel" >
                        <div class="panel-body">

                        <?php
                        
                        //if($num_gastos_abertos > 0)
                        //{
                            
                        
                        ?>
                        
            
                          <div class="table-responsive">
                            <table id="tableGastos" class="table  table-hover">
                              <thead>
                                <tr>
                                  <th class="left-align sort-asc">
                                    <a><?php echo _('Detalles Gastos') ?></a>
                                  </th>
                                  <th class="left-align sort-asc">
                                    <a><?php echo _('Tipo Doc') ?></a>
                                  </th> 
                                  <th class="left-align sort-asc">
                                    <a>Valor Gasto</a>
                                  </th>                                                    
                                </tr>
                              </thead>
                              <tbody>
                              
                              <?php
            
                                
                                //
                                while($res_gastos_abertos=@mysql_fetch_assoc($query_gastos_abertos)) 
                                {
                                    echo "<tr id='ln_gasto_".$res_gastos_abertos['id_desconto']."'>";
                                    echo "<td class='left-align'>".$res_gastos_abertos['descricao']."</td>";
                                    echo "<td class='left-align'>".$res_gastos_abertos['tipo_doc']."</td>";
                                    echo "<td class='right-align'>$ ".number_format($res_gastos_abertos['valor_desconto'],0,"",".")."</td>";
                                    echo "</tr>";																												
                                }
                              ?>
                              </tbody>
                            </table>
                          </div>
                          
                              
                        <?php
                            //}
                        ?>
                        </div>
                      </div>
                    </div>


                    <div class="col-xs-12 col-md-4 divTotLeit">
                      <div class="panel" >
                        <div class="panel-body">
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
                                  <td class="right-align">$ 0</td>
                                </tr>
                                <tr>
                                  <td class="left-align"><?php echo _('Total diferencia -'); ?></td>
                                  <td class="right-align">$ 0</td>
                                </tr>
                                <tr>
                                  <td class="left-align"><?php echo _('Saldo Diferencia'); ?></td>
                                  <td class="right-align">$ 0</td>
                                </tr>
                                <tr>
                                  <td class="left-align"></td>
                                  <td class="right-align">
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                    
                    <?php 
					
					if($result_id_local['observacao'] !== '')
					{
						
					?> 
                    
                    <div class="col-xs-12 col-md-4">
                      <div class="panel" >
                        <div class="panel-body">
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
                                  <td>
	                                  <?php echo $result_id_local['observacao']; ?>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>                    


					<?php
					}
					
					//
					if($_SESSION['usr_nivel'] <> 11)
					{
					
						//					
						$recsubTotal = $totalBruto - $totalPremio - $totalDif;
						
						//gera recalculo fat bruto
						$sql_up = "UPDATE 
										leitura
									SET
										fat_bruto = ".$recsubTotal."
									WHERE
										leitura.id_leitura = '".$id_assoc."'";
	
	
						//echo $sql_up;
				
						//
						@mysql_query($sql_up);
					}
								
					
					
					
					?>























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

<script language="javascript">

	//exporta para pdf 
	$('#exppdf').click( function() 
	{
		window.print() ;
	} );


/*


	//declara tabela de dados	
	$.fn.dataTableExt.oStdClasses.sPageButton = "btn btn-sm";
	var table = $('#tableTeste').DataTable(
	{	
		aoColumnDefs:[
			{
			'bSortable' : false,
			'aTargets' : [ 0, 1, 2, 3, 4, 5, 6, 7 ]
			//'aTargets' : [ 0, 6 ]
			}
		],	
		aoColumns:[
		  //{ "bSearchable": false },
		  { "bSearchable": false },
		  { "bSearchable": false },
		  { "bSearchable": false },		  
		  { "bSearchable": false },
		  { "bSearchable": false },
		  { "bSearchable": false },
		  { "bSearchable": false },
		  { "bSearchable": false }
		],			
		"bLengthChange": true,
		"dom": '<"top">Brt<"bottom"><"clear">',
		buttons: [
			{ 
				extend: 'pdfHtml5', 
			 	className: 'btn btn-exp',
				text: 'Exportar PDF',
				title: 'Lectura 10722',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                },
				footer: true,
				orientation:'landscape',
				customize : function(doc) {
											doc.pageMargins = [55, 10, 55,10 ];
										  	doc.styles.tableFooter.fontSize = 10;
										  }
			},
			{
				extend: 'excelHtml5',
				className: 'btn btn-exp',
				text: 'Exportar Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5, 6, 7 ]
                },
				footer: true		
			}
		]
	});
	
	//declara tabela de dados	
	$.fn.dataTableExt.oStdClasses.sPageButton = "btn btn-sm";
	var table = $('#tableTeste2').DataTable(
	{	
		aoColumnDefs:[
			{
			'bSortable' : false,
			'aTargets' : [ 0, 1 ]
			}
		],	
		aoColumns:[
		  //{ "bSearchable": false },
		  { "bSearchable": false },
		  { "bSearchable": false }
		],			
		"bLengthChange": true,
		"dom": '<"top">Brt<"bottom"><"clear">',
		buttons: [
			{ 
				extend: 'pdfHtml5', 
			 	className: 'btn btn-exp',
				text: 'Exportar PDF',
				title: 'Totalizadores 10722',
                exportOptions: {
                    columns: [ 0, 1]
                }
			},
			{
				extend: 'excelHtml5',
				className: 'btn btn-exp',
				text: 'Exportar Excel',
                exportOptions: {
                    columns: [ 0, 1]
                }		
			}
		]
	});	
	//exporta para pdf 
	$('#exppdf').click( function() 
	{
		var botoes = document.getElementsByTagName("a");
		for (var i = 0; i < botoes.length; i++) {
			
			//
			if (botoes[i].className === "dt-button buttons-pdf buttons-html5 btn btn-exp") {
				botoes[i].click();
			}
		}
	} );
	
	//exporta para exacel
	$('#expexc').click( function() 
	{
		alert("exportar para pdf");
	});*/
	

</script>