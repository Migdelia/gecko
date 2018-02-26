<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//$id_assoc = 77;
$id_leitura = $_GET['id'];
$repLeit = 0;
$leitOnline = 0;


$sql_leitura = "
SELECT * 
from leitura_por_maquina
 where 
 id_leitura = '".$id_leitura."' ";

$query_lec = @mysql_query($sql_leitura);

while ($result_lec=@mysql_fetch_assoc($query_lec)) {

	$id_assoc= $result_lec['id_local'];
}



$sql_loc = "
	SELECT
		local.nome,
		local.percentual,
		local.id_tp_local
	FROM
		`local`
	WHERE
		local.id_local IS NOT NULL
		AND `id_local` = '".$id_assoc."'
	";



	
$query_loc=@mysql_query($sql_loc);
$result_loc=@mysql_fetch_assoc($query_loc);


//consulta ultima leitura desse local
$sql_ult_id = "
	SELECT
		max(id_leitura) as id_leitura
	FROM
		leitura
	WHERE
		id_local= ".$id_assoc."
	";

$query_ult_id=@mysql_query($sql_ult_id);
$rst_ult_id=@mysql_fetch_assoc($query_ult_id);


//
$sql_maq = "SELECT
	leitura_por_maquina.id_maquina,
	maquinas.numero,
	leitura_por_maquina.id_jogo,
	leitura_por_maquina.num_disp as interface,
	leitura_por_maquina.pct_esp_maq as porc_maquina,
	leitura_por_maquina.pct_maq_socio as maq_socio,
	leitura_por_maquina.valor_entrada,
	leitura_por_maquina.valor_saida,
	'' AS entrada_nova,
	'' AS saida_nova,
	leitura_por_maquina.entrada_oficial_atual AS valor_entrada_total,
	leitura_por_maquina.saida_oficial_atual AS valor_saida_total,
	leitura_por_maquina.id_leitura,
	leitura_por_maquina.ordem_leitura,
	'normal' AS STATUS
FROM
	leitura_por_maquina
INNER JOIN maquinas ON leitura_por_maquina.id_maquina = maquinas.id_maquina
WHERE
	leitura_por_maquina.id_maquina IS NOT NULL
AND leitura_por_maquina.id_local = '".$id_assoc."'
AND leitura_por_maquina.id_leitura = '".$id_leitura."'
GROUP BY
	maquinas.id_maquina
ORDER BY
	ordem_leitura,
	numero";
$query_maq=@mysql_query($sql_maq);
$NumMaq = mysql_num_rows($query_maq);


//echo $sql_maq;

//cria lista de plaquinhas desse local
$sql_int = "
	SELECT
		interface.numero
	FROM
		interface
	INNER JOIN
		maquinas
	ON
		interface.id_maquina = maquinas.id_maquina
	WHERE
		maquinas.id_local = '".$id_assoc."'
	";

	
$query_int=@mysql_query($sql_int);


//cria a lista de interfaces
$list_plaq = "";
$cont_plaq = 0;
while($result_int=@mysql_fetch_assoc($query_int)) 
{
	$list_plaq .= "-" . $result_int['numero'] . ";";
	$cont_plaq++;
}

//consulta dados do saldo
$sql_deve = "SELECT * FROM deve WHERE id_leitura = " . $rst_ult_id['id_leitura'];
$query_deve=@mysql_query($sql_deve);
$rst_deve=@mysql_fetch_assoc($query_deve);

//declara valores (deves)
$saldoDeve = $rst_deve['saldo'];
$ultDevePago = $rst_deve['valor_recebido'];

// Extraer Subtotal Anterior
$sql_datos_anterior= "SELECT
			vw_maquinas.id_maquina,
			vw_maquinas.codigo,
			vw_maquinas.numero,
			vw_maquinas.id_jogo,
			vw_maquinas.interface,
			vw_maquinas.porc_maquina,
			vw_maquinas.maq_socio,
			leitura_por_maquina.valor_entrada,
			leitura_por_maquina.valor_saida,
			'' AS entrada_nova,
			'' AS saida_nova,
			vw_maquinas.entrada_oficial AS valor_entrada_total,
			vw_maquinas.saida_oficial AS valor_saida_total,
			leitura_por_maquina.id_leitura,
			vw_maquinas.ordem_leitura,
			'normal' AS STATUS
		FROM
			`vw_maquinas`
		INNER JOIN leitura_por_maquina ON vw_maquinas.id_maquina = leitura_por_maquina.id_maquina
		WHERE
			vw_maquinas.id_maquina IS NOT NULL
		AND 
			vw_maquinas.id_local = '".$id_assoc."'
			AND 
			leitura_por_maquina.id_leitura = '".$id_leitura."'
		GROUP BY
			vw_maquinas.id_maquina
		ORDER BY
			ordem_leitura,
			numero		";


$query_datos_anterior=@mysql_query($sql_datos_anterior);
while($result_ant=@mysql_fetch_assoc($query_datos_anterior)) 
{
	$entrada = $result_ant['valor_entrada'];
	$salida = $result_ant['valor_saida'];

	$totalentrada = $totalentrada + $entrada;
	$totalsalida = $totalsalida + $salida;
	$subtotal_ant = $totalentrada - $totalsalida;

}


?>
<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "lectura" // ingresar la palabra clave de cada modal ?>

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
                  <i class="fa fa-edit fa-stack-1x fa-inverse"></i>
                </span>
                <?php
                	
					 echo "<a href='ver-informe-lectura.php?id=$id_leitura'  title='Volver a la lectura'><i class='fa fa-arrow-circle-left' style='font-size:30px;'></i></a> (".$result_loc['nome'].")";
					
					
				?>
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons-guardar-lectura.php"); // btns paneles ?>
              <?php include("inc/modals/modal-actions-lectura-edit.php"); // modal para agregar contenido ?>
              <?php include("inc/modals/modal-actions-lectura-alert.php"); ?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12 col-md-8">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <!-- dropdown de selects -->
                    <div class="btn-group white-btn">
                      
                    </div>                                      
                  </div>                 
                </div>
                <div class="panel-body">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="table-responsive">
                      <form id="formNovaLeitura" name="formNovaLeitura" action="" method="post">
                      <table id="tabelaLeitura" class="table table-striped table-hover">
                        <thead> 
                          <tr>
                            <th class="left-align sort-asc">
                              <a href="#"><?php echo _('Numero') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Entrada') ?></a>
                            </th>
                            <th class="center-align">
                              <?php echo _('Bruto') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Salida') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Premio') ?>
                            </th>
                            <th class="center-align">
                              <?php echo _('Sub') ?>
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
                        <?php
                   

							//declara a variavel de ids das maquinas
							$NumeroLinhas = mysql_num_rows($query_maq);
							//$guias_cont.="<input type='hidden' id='qtd_maq' value='". $NumeroLinhas ."' />";
							$vl_ids_maq = ""; 

							//
							$totalDifNeg = 0;
							$totalDifPos = 0;
							
							$totalEntrada = 0;
							$totalSaida = 0;
							$totalSubTotal = 0;
							$totalLocal = 0;
							$totalFinal = 0;
						
							while($result_maq=@mysql_fetch_assoc($query_maq)) 
							{

								    $entrada = $result_maq['valor_entrada'];
									$entradaAtual= $result_maq['valor_entrada_total'];
									$saidaAtual= $result_maq['valor_saida_total'];
									$salida= $result_maq['valor_saida'];

									$valor= $result_maq['valor_entrada'];

								
									//echo $valor . "//<br>";
									

									$valor_entrada_actual= $entradaAtual - $entrada;

									$valor_salida_actual = $saidaAtual - $salida;

								
									$subtotal= $valor - $salida;


						
								//verifica se é local integrado
								if($flagLocalIntegrado == 1)
								{
									//conecta no integration
									include('conn/connIntegration.php');
									
									//consulta entrada e saida
									//echo "maq: " . $result_maq['numero'] . " / " .  $result_maq['interface'] . "<br>";
									$sql_dadosAtuais = "SELECT
															creditIn,
															creditOut,
															lastUpdate
														FROM
															Statistic
														WHERE
															id = " . $result_maq['interface'];
															
									$query_dadosAtuais=@mysql_query($sql_dadosAtuais);	
									$rst_dadosAtuais=@mysql_fetch_assoc($query_dadosAtuais);
									
									
									//
									if($rst_dadosAtuais['creditIn'] == '')
									{
										$entradaAtual = 0;		
									}
									else
									{
										$entradaAtual = $rst_dadosAtuais['creditIn'] * 10;
									}
									
									
									//
									if($rst_dadosAtuais['creditOut'] == '')
									{
										$saidaAtual = 0;		
									}
									else
									{
										$saidaAtual = $rst_dadosAtuais['creditOut'] * 10;
									}									
																						
									
									//reconecta no calasys
									include('conn/conn.php');
								}
								else if($leitOnline == 1)//verificar se é leitura online.
								{
									//busca informacoes do sysDongle.
									include('conn/connDongle.php');
									
									//consulta entrada e saida
									//echo "maq: " . $result_maq['numero'] . " / " .  $result_maq['interface'] . "<br>";
									$sql_dadosAtuais = "SELECT
															creditIn,
															creditOut,
															lastUpdate
														FROM
															StreetDongle
														WHERE
															MachineId = " . $result_maq['interface'];
															
									$query_dadosAtuais=@mysql_query($sql_dadosAtuais);	
									$rst_dadosAtuais=@mysql_fetch_assoc($query_dadosAtuais);
									
									




									//tambem consultar na interface
									if($rst_dadosAtuais['creditIn'] == '')
									{
										//busca informacoes das interfaces.
										include('conn/connInt.php');
											
										$sql_dadosAtuais = "SELECT
																moneyIn,
																moneyOut,
																lastMoneyInOutUpdate
															FROM
																Machine
															WHERE
																id = " . $result_maq['interface'];
																
										$query_dadosAtuais=@mysql_query($sql_dadosAtuais);	
										$rst_dadosAtuais=@mysql_fetch_assoc($query_dadosAtuais);
										
										
										//
										if($rst_dadosAtuais['moneyIn'] == '')
										{
											$entradaAtual = 0;		
										}
										else
										{
											$entradaAtual = $rst_dadosAtuais['moneyIn'] * 1000;
										}
										
										
										//
										if($rst_dadosAtuais['moneyOut'] == '')
										{
											$saidaAtual = 0;		
										}
										else
										{
											$saidaAtual = $rst_dadosAtuais['moneyOut'] * 1000;
										}																			
									}
									else
									{
										//
										if($rst_dadosAtuais['creditIn'] == '')
										{
											$entradaAtual = 0;		
										}
										else
										{
											$entradaAtual = $rst_dadosAtuais['creditIn'] * 10;
										}
										
										
										//
										if($rst_dadosAtuais['creditOut'] == '')
										{
											$saidaAtual = 0;		
										}
										else
										{
											$saidaAtual = $rst_dadosAtuais['creditOut'] * 10;
										}										
									}
													
									
									//reconecta no calasys
									include('conn/conn.php');									
									
								}
								
								
								
								
								//declara valor da array com id das maquinas 
								if($linha < $NumeroLinhas)
								{
									$vl_ids_maq = $vl_ids_maq . $result_maq['id_maquina'] . ",";
								}
								else
								{
									$vl_ids_maq = $vl_ids_maq . $result_maq['id_maquina'];
								}								
								
								
						?>
                                <tr id="ln_<?php echo $result_maq['id_maquina']; if($rst_dadosAtuais['lastUpdate'] <> ''){?>" title="Actualizado: <?php echo date("d-m-Y H:i", strtotime($rst_dadosAtuais['lastUpdate']));} ?>">
                                	<td class="left-align"><strong><?php echo $result_maq['numero'] . "</strong><br><span style='font-size:10px;'>(".$result_maq['interface'].")</span><br><img src='images/".$result_maq['id_jogo'].".png' width='40px;' >"; ?></td>
                                	<td>
                                    	<?php
											//verifica se é para repetir a leitura
											if($repLeit == 1)
											{
												echo "<input id='".$result_maq['id_maquina']."_ent' name='".$result_maq['id_maquina']."_ent' type='text'  placeholder='$' size='1' onKeyUp='editaBruto(this);' onBlur='calculaBruto(this);' value='".number_format($result_maq['valor_entrada_total'],0,"",".")."' style='font-size:12px;'>";	
											}
											else if($flagLocalIntegrado == 1)
											{
												echo "<strong><input id='".$result_maq['id_maquina']."_ent' name='".$result_maq['id_maquina']."_ent' type='text'  placeholder='$' size='1' onKeyUp='editaBruto(this);' onBlur='calculaBruto(this);' value='".number_format($entradaAtual,0,"",".")."' style='font-size:12px;'></strong>";													
											}
											else if($leitOnline == 1)
											{
												echo "<strong><input id='".$result_maq['id_maquina']."_ent' name='".$result_maq['id_maquina']."_ent' type='text'  placeholder='$' size='1' onKeyUp='editaBruto(this);' onBlur='calculaBruto(this);' value='".number_format($entradaAtual,0,"",".")."' style='font-size:12px;'></strong>";													
											}											
											else
											{

												echo "<input id='".$result_maq['id_maquina']."_ent' name='".$result_maq['id_maquina']."_ent' type='text'  placeholder='$' size='1' onKeyUp='editaBruto(this);' onBlur='calculaBruto(this);' value='".number_format($entradaAtual,0,"",".")."' style='font-size:12px;'>";													
											}											
										?>
                                		<br>
                                        <a id="rpt_ent_<?php echo $result_maq['id_maquina']?>" class"btn btn-xs btn-default" title="<?php echo number_format($result_maq['valor_entrada_total'],0,"","."); ?>" style="color: black;cursor:pointer;" onClick="repeteValor(this);">
                                        	<i class="material-icons">vertical_align_top</i>
                                       	</a>
                                        <span id="<?php echo $result_maq['id_maquina']?>_ent_ant">
											<?php echo number_format($valor_entrada_actual,0,"","."); ?>
                                        </span>
                                	</td>
                                	<td class="center-align">
                                    	$ <span id="<?php echo $result_maq['id_maquina']?>_bruto">
											
                                            
											<?php 
												
												//
												if($repLeit == 1)
												{
													$brutoInd = 0;
												}
												else
												{
													if($entradaAtual == 0)
													{
														$brutoInd = 0;	
													}
													else
													{
														$brutoInd = $entradaAtual - $result_maq['valor_entrada_total'];
													}													
												}
													
													

											
												echo number_format($valor,0,"","."); 
												
											?>
                                            
                                            
                                          </span>
                                    </td> 
                                    <input type="hidden" id="<?php echo $result_maq['id_maquina']?>_bruto_ant" name="<?php echo $result_maq['id_maquina']?>_bruto_ant" value="0">
                                	<td>
                                    	<?php
											//verifica se é para repetir a leitura
											if($repLeit == 1)
											{
												echo "<input id='".$result_maq['id_maquina']."_sai' name='".$result_maq['id_maquina']."_sai' type='text'  placeholder='$' size='1' onKeyUp='editaPremio(this);' onBlur='calculaPremio(this);' value='".number_format($result_maq['valor_saida_total'],0,"",".")."' style='font-size:12px;'>";	
											}
											else if($flagLocalIntegrado == 1)
											{
												echo "<strong><input id='".$result_maq['id_maquina']."_sai' name='".$result_maq['id_maquina']."_sai' type='text'  placeholder='$' size='1' onKeyUp='editaPremio(this);' onBlur='calculaPremio(this);' value='".number_format($saidaAtual,0,"",".")."' style='font-size:12px;'></strong>";													
											}
											else if($leitOnline == 1)
											{
												echo "<strong><input id='".$result_maq['id_maquina']."_sai' name='".$result_maq['id_maquina']."_sai' type='text'  placeholder='$' size='1' onKeyUp='editaPremio(this);' onBlur='calculaPremio(this);' value='".number_format($saidaAtual,0,"",".")."' style='font-size:12px;'></strong>";													
											}											
											else
											{
												echo "<input id='".$result_maq['id_maquina']."_sai' name='".$result_maq['id_maquina']."_sai' type='text'  placeholder='$' size='1' onKeyUp='editaPremio(this);' onBlur='calculaPremio(this);' value='".number_format($saidaAtual,0,"",".")."' style='font-size:12px;'>";													
											}
										?>                                    
                                        <br>
                                        <a id="rpt_sai_<?php echo $result_maq['id_maquina']?>" title="<?php echo number_format($result_maq['valor_saida_total'],0,"","."); ?>" class"btn btn-xs btn-default" style="color: black;cursor:pointer;"  onClick="repeteValor(this);"><i class="material-icons">vertical_align_top</i></a>
                                		<span id="<?php echo $result_maq['id_maquina']?>_sai_ant">
                                			<?php echo number_format($valor_salida_actual,0,"","."); ?></span>
                                	</td>
                                	<td class="center-align">
                                    	$ <span id="<?php echo $result_maq['id_maquina']?>_premio">
									
											<?php 
											
												//
												if($repLeit == 1)
												{
													$premioInd = 0;	
												}
												else
												{
													if($saidaAtual == 0)
													{
														$premioInd = 0;	
													}
													else
													{
														$premioInd = $saidaAtual - $result_maq['valor_saida_total'];
													}
												}
												

											
												echo number_format($salida,0,"","."); 
												
											?>                                    
                                    
                                        </span>
                                    </td>
                                    <input type="hidden" id="<?php echo $result_maq['id_maquina']?>_premio_ant" name="<?php echo $result_maq['id_maquina']?>_premio_ant" value="0">
                                	<td class="center-align">
                                    	<strong>$ 
                                        	<span id="<?php echo $result_maq['id_maquina']?>_sub">
												<?php 
													$subInd = $brutoInd - $premioInd;
													echo number_format($subtotal,0,"",".");
												?>
                                            </span>
                                        </strong>
                                    </td>
                                	<td class="center-align">
                                    	$
                                        <span id="<?php echo $result_maq['id_maquina']?>_pct_maq" title="<?php echo $result_loc['percentual']?>">
                                        	<?php
												
												//verificar o tipo de local
												if($result_loc['id_tp_local'] == 1)//rua
												{
													//calcula percentual da maquina
													$pctMaqInd = ($subInd * $result_loc['percentual']) / 100;
												}
												else if($result_loc['id_tp_local'] == 2)//proprio com socio
												{
													//verificar se a maquina é de socio ou propria ** aquiiiiiiii Erico -- trazer maq socio. -- result_maq
													if($result_maq['maq_socio'] == 0)
													{
														$pctMaqInd = 0;														
													}
													else
													{
														$pctMaqInd = ($subInd * 20) / 100;
													}
												}												
												else
												{
													//calcula percentual da maquina
													$pctMaqInd = 0;
												}

												echo number_format($pctMaqInd,0,"",".");
											?>
                                        </span>
                                    </td>
                                	<td class="center-align">
                                    	<strong>
                                                $
                                            <span id="<?php echo $result_maq['id_maquina']?>_tot_maq">
                                                <?php
												//verificar o tipo de local
													if($result_loc['id_tp_local'] == 1)//rua
													{
														//calcula percentual da maquina
														$totMaqInd = $subInd - $pctMaqInd;
													}
													else if($result_loc['id_tp_local'] == 2)//proprio com socio
													{
														//verificar se a maquina é de socio ou propria ** aquiiiiiiii Erico -- trazer maq socio. -- result_maq
														if($result_maq['maq_socio'] == 0)
														{
															$totMaqInd = $subInd - (($subInd * 80) / 100);														
														}
														else
														{
															$totMaqInd = 0;	
														}
													}
													else
													{
														//calcula percentual da maquina
														$totMaqInd = 0;
													}
	
													echo number_format($total,0,"",".");																																						
												?>
                                            </span>
                                        </strong></td>
                                </tr>                        


								<?php 
									//consulta se tem alguma diferenca dessa maquina aberta
									$sql_dif_maq_aberta = "SELECT * FROM desconto_leit_fecha WHERE id_maquina = " . $result_maq['id_maquina'] . " AND leitura = 1 AND id_leitura_fechamento = 0";
									$query_dif_maq_aberta=@mysql_query($sql_dif_maq_aberta);

									//echo $sql_dif_maq_aberta;
									
									//
									$totalDifMaq = 0;
									while($res_dif_maq_aberta=@mysql_fetch_assoc($query_dif_maq_aberta)) 
									{
										echo"<tr id='ln_dif_".$res_dif_maq_aberta['id_maquina']."'>
												<td>
													<strong>Diferencia maq:</strong>
												</td>
												<td>
													Descripcion:
												</td>
												<td colspan='3'>
													".$res_dif_maq_aberta['descricao']."
												</td>
												<td colspan='2'>
													<strong>$ ".number_format(($res_dif_maq_aberta['valor_desconto']*-1),0,"",".")."</strong>
												</td>
												<td>
													<a id='dif_".$res_dif_maq_aberta['id_desconto']."' class='btn btn-raised btn-sm' title='".$res_dif_maq_aberta['id_maquina']."' data-target='#edit-modal-diferenca' onclick='excluiDif(this);'>Excluir</a>
													
												</td>
											</tr>";
											
											//soma os totais
											$totalDifNeg = $totalDifNeg + $res_dif_maq_aberta['valor_desconto'];
											$totalDifMaq = $totalDifMaq + $res_dif_maq_aberta['valor_desconto'];									
									}
									echo "<input type='hidden' id='totalDifMaq_".$result_maq['id_maquina']."' name='totalDifMaq_".$result_maq['id_maquina']."' value='".$totalDifMaq."' >";
								?>



						<?php
							//soma totais.
							$totalEntrada = $totalEntrada + $valor;
							$totalSaida = $totalSaida + $salida;
							$totalSubTotal = $totalEntrada - $totalSaida;
							$totalLocal = $totalLocal + $pctMaqInd;
							$totalFinal = $totalSubTotal;							
							 
							}

						?>   
                        </tbody>
                        
                        
                        <tfoot style="background-color: #0DA4E7;">
                          <tr>
                            <td  style="color: white" class="left-align"><strong><?php echo $NumMaq; ?> Maquinas</strong></td>
                            <td style="color: white">&nbsp;</td>
                            <td style="color: white" center-align>$ <span id="totalEntradaFoot"><?php echo number_format($totalEntrada,0,"",".");?></span></td>
                            <td style="color: white">&nbsp;</td>
                            <td style="color: white" class="center-align">$ <span id="totalSaidaFoot"><?php echo number_format($totalSaida,0,"",".");?></span></td>
							<td style="color: white" class="center-align"><strong>$<span id="totalSubtotalFoot"><?php echo number_format($totalSubTotal,0,"",".");?></span></strong></td>
							<td style="color: white" class="center-align">$ <span id="totalLocalFoot"><?php echo number_format($totalLocal,0,"",".");?></span></td>
							<td style="color: white" class="center-align"><strong>$ <span id="totalFinalFoot"><?php echo number_format($totalFinal,0,"",".");?></span></strong></td>
                          </tr>
                        </tfoot>
                                                
                        
                        
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
                            <a><?php echo _('Totalizadores lanzamientos') ?></a>
                          </th>
                          <th class="right-align">Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="left-align"><?php echo _('Total Entrada'); ?></td>
                          <td class="right-align">$ <span id="total_entrada"><?php echo number_format($totalEntrada,0,"",".");?></span></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Total Salida'); ?></td>
                          <td class="right-align">$ <span id="total_saida"><?php echo number_format($totalSaida,0,"",".");?></span></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Subtotal'); ?></td>
                          <td class="right-align"><strong>$ <span id="sub_total"><?php echo number_format($totalSubTotal,0,"",".");?></span></strong></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Total Gastos'); ?></td>
                          <td class="right-align">$ <span id="total_gastos">0</span></td>
                        </tr>                        
                        <tr>
                          <td class="left-align"><?php echo _('Total Local'); ?></td>
                          <td class="right-align">$ <span id="total_local"><?php echo number_format($totalLocal,0,"",".");?></span></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Total'); ?></td>
                          <td class="right-align"><strong>$ <span id="total_final"><?php echo number_format($totalFinal,0,"",".");?></span></strong></td>
                        </tr>                        
                      </tbody>
                    </table>
                  </div>

                  
                  <?php
				  	//
				  	if($result_loc['id_tp_local'] <> 1)
					{
						echo "<div class='table-responsive' style='display:none;'>";
					}
					else
					{
	                	echo "<div class='table-responsive'>";						
					}
				  ?>
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
                          <th class="right-align">
                          	<a href="#" class="btn btn-raised btn-sm" data-toggle="modal" data-target="#add-modal-gastos"><?php echo _('+ Gasto'); ?></a>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      
                      <?php
					  	//consulta gastos de leitura abertos desse operador
						$sql_gastos_abertos = "SELECT * FROM desconto_leit_fecha WHERE id_login = " . $_SESSION['id_login'] . " AND leitura = 1 AND id_leitura_fechamento = 0 AND id_maquina = 0";
						$query_gastos_abertos=@mysql_query($sql_gastos_abertos);
						
						//
						$totalGastos = 0;
						while($res_gastos_abertos=@mysql_fetch_assoc($query_gastos_abertos)) 
						{
							echo "<tr id='ln_gasto_".$res_gastos_abertos['id_desconto']."'>";
							echo "<td class='left-align'>".$res_gastos_abertos['descricao']."</td>";
							echo "<td class='left-align'>".$res_gastos_abertos['tipo_doc']."</td>";
							echo "<td class='right-align'>$ ".number_format($res_gastos_abertos['valor_desconto'],0,"",".")."</td>";
							echo "<td class='left-align'><a id='gasto_".$res_gastos_abertos['id_desconto']."' class='btn btn-sm' target='new' onClick='excluiGasto(this);'> Excluir </a></td>";
							echo "</tr>";	
							
							$totalGastos = $totalGastos + $res_gastos_abertos['valor_desconto'];
						}
						echo "<input type='hidden' id='hd_total_gasto' name='hd_total_gasto' value='".number_format($totalGastos,0,"",".")."' >";
					  ?>
                      </tbody>
                    </table>
                    
                  </div>
				<div class="table-responsive">
                    <table class="table  table-hover">
                      <thead>
                        <tr>
                          <th class="left-align sort-asc">
                            <a><?php echo _('Diferencias') ?></a>
                          </th>
                          <th class="right-align">Subtotal</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td class="left-align"><?php echo _('Total Diferencia +'); ?></td>
                          <td class="right-align"><strong>$ <span id="tot_dif_pos">0</span></strong></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Total diferencia -'); ?></td>
                          <td class="right-align"><strong>$ <span id="tot_dif_neg"><?php echo number_format($totalDifNeg,0,"",".");?></span></strong></td>
                        </tr>
                        <tr>
                          <td class="left-align"><?php echo _('Saldo Diferencia'); ?></td>
                          <td class="right-align"><strong>$ <span id="tot_vl_dif"><?php echo number_format($totalDifPos - $totalDifNeg,0,"",".");?></span></strong></td>
                        </tr>
                        <tr>
                          <td class="left-align"></td>
                          <td class="right-align">
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
                            <a><?php echo _('Observaciones') ?></a>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          
                          <td>
                          
                          	<?php
								//
								$sql_obs = "SELECT
												observacao
											FROM
												leitura
											WHERE
												id_leitura = " . $id_leitura;

								$query_obs = @mysql_query($sql_obs);
								$result_obs=@mysql_fetch_assoc($query_obs);												
												
							?>
                          
                          	<textarea id="obs" name="obs" rows="4" cols="50"><?php echo $result_obs['observacao']; ?></textarea>
						  </td>
                        </tr>
                      </tbody>
                    </table>
                    </form>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<?php include("inc/modals/modal-edit-deve.php"); // modal para editar contenido ?>
<?php include("inc/modals/modal-edit-diferenca.php"); // modal para editar contenido ?>
<?php include("inc/modals/modal-add-gastos-leitura.php"); // modal para editar contenido ?>
<?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
</body>
</html>

<script>
	//edita Bruto
	function editaBruto(obj)
	{
		var entNova = obj.value;
		
		
		//limpa valor
		entNova = entNova.replace('.', '');
		entNova = entNova.replace('.', '');		

		
		//formata nova entrada
		if(entNova == '')
		{
			entNova = 0;
		}
		
		//trata valor
		var digVerif = entNova.substring(0,1);
		if(digVerif == 0)
		{
			entNova = entNova.replace('0', '');
		}	
		//trata valor
		var digVerif = entNova.substring(0,1);
		if(digVerif == 0)
		{
			entNova = entNova.replace('0', '');
		}				
		
		//
		if(entNova == '')
		{
			entNova = 0;
		}
		else
		{
			entNova = eval(entNova).formatNumber(2,',','.');
			entNova = entNova.replace(',00', '');			
		}
		
		//atribui os valores novos
		$('#'+obj.id).val(entNova);
	}


	//calcula Bruto
	function calculaBruto(obj, rptTp, maqRpt)
	{
		if(obj !== 'rpt')//calculo normal
		{
			arrayObj = obj.id.split("_");
			idMaq = arrayObj[0];
			tipoValor = arrayObj[1];
			novaEntrada = obj.value;
		}
		else // repetir
		{
			idMaq = maqRpt;
			tipoValor = rptTp;
			novaEntrada = $('#'+idMaq+'_ent_ant').text();
		}
		



		//guarda o bruto atual
		var bruto = $('#'+idMaq+'_bruto').text();
		bruto = bruto.replace('.', '');
		bruto = bruto.replace('.', '');
		if(bruto >= 0)
		{
			$('#'+idMaq+'_bruto_ant').attr("value", bruto);			
		}	
		
		
		//pega o valor da entrada anterior
		var entAnt = $('#'+idMaq+'_'+tipoValor+'_ant').text();
		var entNova = novaEntrada;

		
		//limpa valor
		entAnt = entAnt.replace('.', '');
		entAnt = entAnt.replace('.', '');
		
		entNova = entNova.replace('.', '');
		entNova = entNova.replace('.', '');		
		
		
		//verificar se oo novo valor é maior que o da ultima leitura.
		if(eval(entNova) < eval(entAnt) || entNova == '')
		{
			$('#'+obj.id).focus();
			
			//atribuir class de erro * pendente
			//$('#'+obj.id).addClass("has-error");		
			return false;		
		} 		
		
		//calcula bruto
		var bruto = eval(entNova) - eval(entAnt);
		
		//formatar pontos
		bruto = eval(bruto).formatNumber(2,',','.');
		bruto = bruto.replace(',00', '');
		
		//formata nova entrada
		if(entNova == '')
		{
			entNova = 0;
		}
		entNova = eval(entNova).formatNumber(2,',','.');
		entNova = entNova.replace(',00', '');
		
		//atribui os valores novos
		$('#'+idMaq+'_bruto').text(bruto);
		$('#'+idMaq+'_'+tipoValor).val(entNova);
		
		//chama funcoes totalizadoras 
		calcSub(idMaq);
		calcPctMaq(idMaq);
		calcTotalizadores(idMaq, tipoValor);
	}
	
	
	//edita Premio
	function editaPremio(obj)
	{
		var saiNova = obj.value;
		
		//limpa valor
		saiNova = saiNova.replace('.', '');
		saiNova = saiNova.replace('.', '');		
		
		//formata nova entrada
		if(saiNova == '')
		{
			saiNova = 0;	
		}
		
		
		//trata valor
		var digVerif = saiNova.substring(0,1);
		if(digVerif == 0)
		{
			saiNova = saiNova.replace('0', '');
		}
		//trata valor
		var digVerif = saiNova.substring(0,1);
		if(digVerif == 0)
		{
			saiNova = saiNova.replace('0', '');
		}					
		
		//
		if(saiNova == '')
		{
			saiNova = 0;
		}
		else
		{
			saiNova = eval(saiNova).formatNumber(2,',','.');
			saiNova = saiNova.replace(',00', '');			
		}

		
		//atribui os valores novos
		$('#'+obj.id).val(saiNova);
	}	
	
	//calcula Premio
	function calculaPremio(obj, rptTp, maqRpt)
	{
		if(obj !== 'rpt')//calculo normal
		{
			arrayObj = obj.id.split("_");
			idMaq = arrayObj[0];
			tipoValor = arrayObj[1];
			novaSaida = obj.value;
		}
		else // repetir
		{
			idMaq = maqRpt;
			tipoValor = rptTp;
			novaSaida = $('#'+idMaq+'_sai_ant').text();
		}
		
		
		//guarda o premio atual
		var premio = $('#'+idMaq+'_premio').text();
		premio = premio.replace('.', '');
		premio = premio.replace('.', '');		
		if(premio >= 0)
		{
			$('#'+idMaq+'_premio_ant').attr("value", premio);			
		}				

		
		//pega o valor da saida anterior
		var saiAnt = $('#'+idMaq+'_'+tipoValor+'_ant').text();
		var saiNova = novaSaida;

		//limpa valor
		saiAnt = saiAnt.replace('.', '');
		saiAnt = saiAnt.replace('.', '');
		
		saiNova = saiNova.replace('.', '');
		saiNova = saiNova.replace('.', '');	
		
		
		//verificar se oo novo valor é maior que o da ultima leitura.
		if(eval(saiNova) < eval(saiAnt)  || saiNova == '')
		{
			$('#'+obj.id).focus();
			
			//atribuir class de erro * pendente
			//$('#'+obj.id).addClass("has-error");			
			return false;	
		} 			
			
		
		//calcula premio
		var premio = eval(saiNova) - eval(saiAnt);
		
		//formatar pontos
		premio = eval(premio).formatNumber(2,',','.');
		premio = premio.replace(',00', '');
		
		//formata nova saida
		if(saiNova == '')
		{
			saiNova = 0;
		}
		saiNova = eval(saiNova).formatNumber(2,',','.');
		saiNova = saiNova.replace(',00', '');
		
		//atribui os valores novos
		$('#'+idMaq+'_premio').text(premio);
		$('#'+idMaq+'_'+tipoValor).val(saiNova);
		
		//chama funcoes totalizadoras
		calcSub(idMaq);
		calcPctMaq(idMaq);
		calcTotalizadores(idMaq,tipoValor);	
	}
	
	//calcula Sub-Total
	function calcSub(id)
	{
		//declara bruto e premio dessa maquina
		var bruto = $('#'+id+'_bruto').text();
		var premio = $('#'+id+'_premio').text();
		var totalDifMaq = $('#totalDifMaq_'+id).val();

		
		//limpa valor
		bruto = bruto.replace('.', '');
		bruto = bruto.replace('.', '');
		
		premio = premio.replace('.', '');
		premio = premio.replace('.', '');
		
		
		//calcula SubTotal
		var subTotMaq = eval(bruto) - eval(premio) - eval(totalDifMaq);
		
		//formata valor SubTotal
		subTotMaq = eval(subTotMaq).formatNumber(2,',','.');
		subTotMaq = subTotMaq.replace(',00', '');
		
		//atribui novo sub dessa maq
		$('#'+id+'_sub').text(subTotMaq);
	}
	
	//calcula Pct local dessa maquina
	function calcPctMaq(id)
	{
		var pctMaqLoc = $('#'+id+'_pct_maq').prop("title");
		var subTotalMaq = $('#'+id+'_sub').text();
		
		//limpa valor
		subTotalMaq = subTotalMaq.replace('.', '');
		subTotalMaq = subTotalMaq.replace('.', '');	
		
		//calcula PctLocal
		var pctLocal = ((eval(subTotalMaq) * eval(pctMaqLoc)) / 100);
		
		//lucro 
		var lucro = eval(subTotalMaq) - eval(pctLocal);
		
		//arredonda
		pctLocal = pctLocal.toFixed(0);	
		lucro = lucro.toFixed(0);		

		//formata valores
		pctLocal = eval(pctLocal).formatNumber(2,',','.');
		pctLocal = pctLocal.replace(',00', '');
		
		lucro = eval(lucro).formatNumber(2,',','.');
		lucro = lucro.replace(',00', '');				
				
		//atribui novo sub dessa maq
		//$('#'+id+'_pct_maq').text(pctLocal);
		$('#'+id+'_tot_maq').text(lucro);	
		
		calculaTotalLocal(pctLocal, id);
	}	

	//
	function calculaTotalLocal(novoVl, idMaq)
	{
		valorAtualTotLoc = $('#total_local').text();
		
		valorAtualTotLoc = valorAtualTotLoc.replace('.', '');
		valorAtualTotLoc = valorAtualTotLoc.replace('.', '');
		
		novoVl = novoVl.replace('.', '');
		novoVl = novoVl.replace('.', '');

		
		//pegar o valor atual do pct individual
		var pctIndMaq = $('#'+idMaq+'_pct_maq').text();
		pctIndMaq = pctIndMaq.replace('.', '');
		pctIndMaq = pctIndMaq.replace('.', '');		
		
		
		//revisar essa conta
		//alert(valorAtualTotLoc);
		//alert(pctIndMaq);
		//alert(novoVl);
		vlLocal = eval(valorAtualTotLoc) - eval(pctIndMaq) + eval(novoVl);		

		
		vlLocal = eval(vlLocal).formatNumber(2,',','.');
		vlLocal = vlLocal.replace(',00', '');			
		
		$('#total_local').text(vlLocal);
		$('#totalLocalFoot').text(vlLocal);
		
		
		//formata valores
		novoVl = eval(novoVl).formatNumber(2,',','.');
		novoVl = novoVl.replace(',00', '');		
		$('#'+idMaq+'_pct_maq').text(novoVl);		
	}	
	
	//calcula Totalizadores Finais // entrada / saida
	function calcTotalizadores(id, tipo)
	{
		
		if(tipo == 'ent')
		{
			// total_entrada		
			var totalEntradas = $('#total_entrada').text();	
			var bruto = $('#'+id+'_bruto').text();
			var brutoAnt = $('#'+id+'_bruto_ant').attr("value");

				
			//limpa valor
			totalEntradas = totalEntradas.replace('.', '');
			totalEntradas = totalEntradas.replace('.', '');	
			
			bruto = bruto.replace('.', '');
			bruto = bruto.replace('.', '');	
			
			//brutoAnt = brutoAnt.replace('.', '');
			//brutoAnt = brutoAnt.replace('.', '');						
									
	
			//
			if(bruto >= 0)
			{
				//
				var novoTotalEntradas = eval(totalEntradas) - eval(brutoAnt) + eval(bruto);	
	
				//formata valores
				novoTotalEntradas = eval(novoTotalEntradas).formatNumber(2,',','.');
				novoTotalEntradas = novoTotalEntradas.replace(',00', '');		
				
				//atribui valor ao contador
				$('#total_entrada').text(novoTotalEntradas);
				$('#totalEntradaFoot').text(novoTotalEntradas);					
			}
		}
		else if(tipo == 'sai')
		{
			// total_saida		
			var totalSaidas = $('#total_saida').text();	
			var premio = $('#'+id+'_premio').text();
			var premioAnt = $('#'+id+'_premio_ant').attr("value");
			
	
			//limpa valor
			totalSaidas = totalSaidas .replace('.', '');
			totalSaidas = totalSaidas.replace('.', '');	
			
			premio = premio.replace('.', '');
			premio = premio.replace('.', '');	
			
			//premioAnt = premioAnt.replace('.', '');
			//premioAnt = premioAnt.replace('.', '');
					


			//
			if(premio >= 0)
			{
				//
				var novoTotalSaidas = eval(totalSaidas) - eval(premioAnt) + eval(premio);	
				
	
				//formata valores
				novoTotalSaidas = eval(novoTotalSaidas).formatNumber(2,',','.');
				novoTotalSaidas = novoTotalSaidas.replace(',00', '');		
				
				//atribui valor ao contador
				$('#total_saida').text(novoTotalSaidas);
				$('#totalSaidaFoot').text(novoTotalSaidas);					
			}			
		}
		
		//pega entrada e saida
		var totalFinalEntrada = $('#total_entrada').text();
		var totalFinalSaida = $('#total_saida').text();
		var totalDifFinal = $('#tot_vl_dif').text();	

		
		totalFinalEntrada = totalFinalEntrada.replace('.', '');
		totalFinalEntrada = totalFinalEntrada.replace('.', '');	
		
		totalFinalSaida = totalFinalSaida.replace('.', '');
		totalFinalSaida = totalFinalSaida.replace('.', '');	
		
		totalDifFinal = totalDifFinal.replace('.', '');
		totalDifFinal = totalDifFinal.replace('.', '');							
		
		//
		if(eval(totalDifFinal) < 0)
		{
			totalDifFinal = totalDifFinal * (-1);
		}
		
		//verificar se a diferenca é positiva ou negativa * aquiii
		if($("input[name='tipo_operacao_dif']:checked").val() == 1)
		{
			var totalFinalSub =  eval(totalFinalEntrada) - eval(totalFinalSaida) + eval(totalDifFinal);
		}
		else
		{
			var totalFinalSub =  eval(totalFinalEntrada) - eval(totalFinalSaida) - eval(totalDifFinal);
		}
		
		

		totalFinalSub = eval(totalFinalSub).formatNumber(2,',','.');
		totalFinalSub = totalFinalSub.replace(',00', '');		
		
		
		$('#sub_total').text(totalFinalSub);
		$('#totalSubtotalFoot').text(totalFinalSub);
		
				
		calcTotalFinal();
	}
	
	
	//calcula Sub-Total
	function calcTotalFinal()
	{
		var Subtotal = $('#sub_total').text();
		var totalLocal = $('#total_local').text();
		var totalGastos = $('#total_gastos').text();
		
		//
		Subtotal = Subtotal.replace('.', '');
		Subtotal = Subtotal.replace('.', '');	
		
		totalLocal = totalLocal.replace('.', '');
		totalLocal = totalLocal.replace('.', '');
		
		totalGastos = totalGastos.replace('.', '');
		totalGastos = totalGastos.replace('.', '');		
		
		var totalFinalFoot = eval(Subtotal) - eval(totalLocal);		
		var totalFinal = eval(Subtotal) - eval(totalLocal) - eval(totalGastos);		

		totalFinal = eval(totalFinal).formatNumber(2,',','.');
		totalFinal = totalFinal.replace(',00', '');
		
		totalFinalFoot = eval(totalFinalFoot).formatNumber(2,',','.');
		totalFinalFoot = totalFinalFoot.replace(',00', '');		

		$('#total_final').text(totalFinal);	
		$('#totalFinalFoot').text(totalFinalFoot);		
    }	
	
	
	//
	function repeteValor(obj)
	{
		var arrayRpt = obj.id.split('_');
		nomeCampo = arrayRpt[2]+'_'+arrayRpt[1];
		
		//		
		$('#'+nomeCampo).val(obj.title);
		
		//
		if(arrayRpt[1] == 'ent')
		{
			calculaBruto('rpt',arrayRpt[1],arrayRpt[2]);
		}
		else
		{
			calculaPremio('rpt',arrayRpt[1],arrayRpt[2]);	
		}
		
		//calcTotalizadores(arrayRpt[2], arrayRpt[1]);
	}	
	
	
	$('#confirmar').click( function ()
	{
		
		//verifica se foi selecionada uma semana 	
		var flagSemana = "<?=$dataRef?>";
		var diaFecha = "<?=$dataRef?>";
		//
		var id_loc = "<?=$id_assoc?>";
		var leitura = "<?=$id_leitura?>";
		var subtotal = $('#sub_total').text();

		subtotal = subtotal.replace('.', '');
		subtotal = subtotal.replace('.', '');	


		var subtotal_anterior ="<?=$subtotal_ant?>";
		var ids_maq = "<?=$vl_ids_maq?>";
		var cont = 0;
		var param_leitura = "";
		
		
		//
		while (cont< "<?=$NumeroLinhas?>")
		{
			//declara o obj
			var quebra=ids_maq.split(",");
			var id_obj = quebra[cont];

			
			//pega o valor de entrada
			//alert(id_obj);
			var obj_ent = id_obj + "_ent";
			
			//alert(obj_ent);
			var vl_obj_ent = $("#" + obj_ent + "").val();
			
			
			//pega o valor de saida
			var obj_sai = id_obj + "_sai";
			var vl_obj_sai = $("#" + obj_sai + "").val();
		
					
			//retira pontos para gravar no banco de dados
			var vl_obj_ent = vl_obj_ent.replace(".","");
			var vl_obj_ent = vl_obj_ent.replace(".","");
			var vl_obj_ent = vl_obj_ent.replace(".","");
		
			//
			var vl_obj_sai = vl_obj_sai.replace(".","");
			var vl_obj_sai = vl_obj_sai.replace(".","");
			var vl_obj_sai = vl_obj_sai.replace(".","");	
			
			//arruma valores para importacao online. tirando os espacos.
			vl_obj_ent = eval(vl_obj_ent);
			vl_obj_sai = eval(vl_obj_sai);																				
		
			//concatena valores para passar									
			var param_leitura = param_leitura + vl_obj_ent;																		
			var param_leitura = param_leitura + ",";																		
			var param_leitura = param_leitura + vl_obj_sai;																																				
			var param_leitura = param_leitura + "/";									
			cont++;
		}


		//		
		var num_lin = "<?=$NumeroLinhas?>";
		var saldo_deve = $("#deve_atual").text();
		var saldo_deve = saldo_deve.replace(".","");
		var saldo_deve = saldo_deve.replace(".","");	
		
		var deve = $("#deve").text();
		var obs = $("#obs").val();	
		var abn_dev = $("#abono").text();	
		
		

		//
		var semSel = flagSemana.split(",");
		semSel = semSel[0].split("-");
		semSel = semSel[0];
		
		//calcula semana
		semSel = eval(semSel) / 7;


		if((parseFloat(semSel) == parseInt(semSel)) && !isNaN(semSel))
		{
			semSel = semSel;
		} 
		else
		{
			var semSel = semSel.toString();
			var semSel = semSel.split(".");
			semSel = eval(semSel[0]) + 1;
		}
		
		//var semSel = '2'; // verificar aqui **** erico
		

		
		//busca faturamento bruto
		var fatBruto = $('#sub_total').text();
		var fatBruto = fatBruto.replace(".","");
		var fatBruto = fatBruto.replace(".","");
		var fatBruto = fatBruto.replace(".","");									
		
		//
		$("#confirmar").attr('disabled','disabled');


		//
		$.post('edit_leitura.php', {loc:id_loc,ids:ids_maq,vl_maq:param_leitura,qtd:num_lin,dev:deve,subttl:subtotal,subtotalanterior:subtotal_anterior,sld_dev:saldo_deve,obs:obs,abono:abn_dev,semana:semSel,dia_fecha:diaFecha,fat_bruto:fatBruto,idLeit:leitura},function(json){

		if(json>0)
			{
				$("#lc_nome").val("");
						
	
				$('#massaction-modal').modal('hide');
				$('#modal-alert').modal({});
				
				
				//alert("funcionou");
				//location="ver-informe-lectura.php?id="+json;
			}
			else
			{
				alert("Error!");
		    	location.reload();
			}
		});

	});


	//
	function excluiGasto(obj)
	{
		//
		idGasto = obj.id.split('_');
		idGasto = idGasto[1];

		//
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'remove_despesa.php', // Informo a URL que será pesquisada.
			data: 'id_desp='+idGasto,
			//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
			success: function(html)
			{
				retorno = html.split("-");
				if(retorno[0] == "true")
				{
					//
					$('#ln_gasto_'+idGasto).remove();
					
					
					//recalcular total de gasto 
					var totalGastoAtual = $('#total_gastos').text();	
					totalGastoAtual = totalGastoAtual.replace('.', '');
					totalGastoAtual = totalGastoAtual.replace('.', '');	
								
					//				
					totalGastoAtual = totalGastoAtual - retorno[1];
					
					//atribui novo total de gasto
					totalGastoAtual = eval(totalGastoAtual).formatNumber(2,',','.');
					totalGastoAtual = totalGastoAtual.replace(',00', '');					
					$('#total_gastos').text(totalGastoAtual);	
					
					
					//recalcula total
					var vlFinalAtual = $('#total_final').text();
					vlFinalAtual = vlFinalAtual.replace('.', '');
					vlFinalAtual = vlFinalAtual.replace('.', '');					
					
					//calcula novo total
					novoVlFinal = eval(vlFinalAtual) + eval(retorno[1]);	
					
					novoVlFinal = eval(novoVlFinal).formatNumber(2,',','.');
					novoVlFinal = novoVlFinal.replace(',00', '');						
					$('#total_final').text(novoVlFinal);				
					
				}
				else
				{
					alert("Error!!");
				}
			}
		});
	}
	
	
	//exclui diferenca
	function excluiDif(obj)
	{
		//
		idDif = obj.id.split('_');
		idDif = idDif[1];
		
		//
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'remove_despesa.php', // Informo a URL que será pesquisada.
			data: 'id_desp='+idDif,
			//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
			success: function(html)
			{
				resposta = html.split("-");
				if(resposta[0] == "true")
				{
					//
					$('#ln_dif_'+obj.title).remove();
					
					
					//atualiza o total de diferenca neg e total
					var vlDifNegTotalizador = $('#tot_dif_neg').text();	
					vlDifNegTotalizador = vlDifNegTotalizador.replace('.', '');
					vlDifNegTotalizador = vlDifNegTotalizador.replace('.', '');	
					
					vlDifNegTotalizador = eval(vlDifNegTotalizador) - eval(resposta[1]);
					
					vlDifNegTotalizador = eval(vlDifNegTotalizador).formatNumber(2,',','.');
					vlDifNegTotalizador = vlDifNegTotalizador.replace(',00', '');					
					
					$('#tot_dif_neg').text(vlDifNegTotalizador);		
					
					
					
					//atualiza o total de diferenca final
					var vlDifTotalizador = $('#tot_vl_dif').text();	
					vlDifTotalizador = vlDifTotalizador.replace('.', '');
					vlDifTotalizador = vlDifTotalizador.replace('.', '');	
					
					vlDifTotalizador = eval(vlDifTotalizador) + eval(resposta[1]);
					
					vlDifTotalizador = eval(vlDifTotalizador).formatNumber(2,',','.');
					vlDifTotalizador = vlDifTotalizador.replace(',00', '');					
					
					$('#tot_vl_dif').text(vlDifTotalizador);									
					
					
					
					
					
					
					//atribui valor de diferenca ao total de dif dessa maquina. * aquiiii
					var vlAntDifMaq = $('#totalDifMaq_'+obj.title).val();				
					totDifMaq = eval(vlAntDifMaq) - eval(resposta[1]);
					$('#totalDifMaq_'+obj.title).val(totDifMaq);						
					
					//recalcula total dessa maquina
					calcSub(obj.title);
					calcPctMaq(obj.title);
					calcTotalizadores(obj.title);					
				}
				else
				{
					alert("Error!!");
				}
			}
		});				
	}	
	
	//
	$('#total_gastos').text($('#hd_total_gasto').val());
	
	//
	if($('#hd_total_gasto').val() > 0)
	{
		$('#total_final').text("-" + $('#hd_total_gasto').val());	
	}
	
	//
	$('#btnOk').click( function ()
	{
		location="ver-informe-lectura.php?id="+<?=$id_leitura?>;	
	});
	
		
</script>