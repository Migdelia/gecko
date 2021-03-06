<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

$dataRel = $_POST['dataFinal'];

$dataRelIni = "01-" . $dataRel;
$dataRelFim = "31-" . $dataRel;
 

//echo " //// " . date("Y-m-d", strtotime($dataRelIni));

//
$sql_ingressos_totais = "SELECT
							`local`.id_local,
							`local`.id_tp_local,
							'Calabaza' as nome,
							ROUND(SUM(leitura.fat_bruto - ((leitura.fat_bruto * leitura.pct_local) / 100))) as ingrTotal,
							SUM(leitura.total_diferenca) as difTotal,
							SUM(leitura.total_desconto) as descTotal
						FROM
							leitura
						INNER JOIN
							`local`
						ON
							leitura.id_local = `local`.id_local
						WHERE
							leitura.data_fechamento >= '".date("Y-m-d", strtotime($dataRelIni))."'
						AND
							leitura.data_fechamento <= '".date("Y-m-d", strtotime($dataRelFim))."'
						AND
							(
							leitura.id_tipo_local = 1
							or 
							leitura.id_tipo_local = 6
							)
						AND
							(leitura.id_login = 37
							or
							leitura.id_login = 30
							or
							leitura.id_login = 16
							or 
							leitura.id_login = 52)
						
					UNION
						
						SELECT
							`local`.id_local,
							`local`.id_tp_local,
							`local`.nome,
							SUM(leitura.fat_bruto) as ingrTotal,
							SUM(leitura.total_diferenca) as difTotal,
							SUM(leitura.total_desconto) as descTotal
						FROM
							leitura
						INNER JOIN
							`local`
						ON
							leitura.id_local = `local`.id_local
						WHERE
							leitura.data_fechamento >= '".date("Y-m-d", strtotime($dataRelIni))."'
						AND
							leitura.data_fechamento <= '".date("Y-m-d", strtotime($dataRelFim))."'
						AND
							(
							leitura.id_tipo_local = 4
							OR
							leitura.id_tipo_local = 2
							)
						GROUP BY
							`local`.id_local
						";

$qry_nome_locais=@mysql_query($sql_ingressos_totais);	
$qry_ingressos_totais=@mysql_query($sql_ingressos_totais);

/*
//
$sql_ingressos_rua = "SELECT
						`local`.nome as nome,
						ROUND(SUM(leitura.fat_bruto) - (SUM(leitura.fat_bruto)) * leitura.pct_local / 100) as ingrTotal,
						SUM(leitura.total_diferenca) as difTotal,
						SUM(leitura.total_desconto) as descTotal
					FROM
						leitura
					INNER JOIN
						`local`
					ON
						leitura.id_local = `local`.id_local
					WHERE
						leitura.data_fechamento >= '2017-07-01'
					AND
						leitura.data_fechamento <= '2017-07-31'
					AND
						(
						leitura.id_tipo_local = 1
						)
					AND
						(leitura.id_login = 37
						or
						leitura.id_login = 30
						or
						leitura.id_login = 16
						or 
						leitura.id_login = 52)
					GROUP BY
						`local`.id_local";

$qry_ingressos_rua=@mysql_query($sql_ingressos_rua);	

//
$totFatRua = 0;
while($rst_ingressos_rua=@mysql_fetch_assoc($qry_ingressos_rua))
{
	$totFatRua = $totFatRua + $rst_ingressos_rua['ingrTotal'] - $rst_ingressos_rua['descTotal'];
	$fatLeit = $rst_ingressos_rua['ingrTotal'] - $rst_ingressos_rua['descTotal'];
	//echo $rst_ingressos_rua["nome"] . " ---- " . $rst_ingressos_rua['ingrTotal'] . " // " . $rst_ingressos_rua['descTotal'] . " // /// //" . $fatLeit . "<br>";						
}

//echo "<br><br>Leo Improta: $ " . number_format($totFatRua,0,"",".") . "<br>";

*/
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
                <?php echo _('Informe de Estado y Resultados') ?>
                <!--- <a href="#" class="btn" style="margin:0 0 0 10px;"><?php echo _('Ver Todos') ?></a> -->
              </h3>
            </div>
            <!-- <div class="col-xs-12 col-lg-3">
              <div class="panel">
                <div class="panel-heading" style="min-height: 37px; padding: 0px; width: 280px;">

                  <div class="btn-group" role="group" aria-label="Button group with nested dropdown">

                  </div>
                </div>
              </div>
            </div> -->
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons-informes.php"); // btns paneles ?> 
              <?php include("inc/modals/modal-select-mes-info.php"); // modal para agregar contenido ?>
              <?php include("inc/modals/modal-view-maquinas.php"); // modal para ver detalles contenido ?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <!-- dropdown de selects -->
                    <!---
                    <div class="btn-group white-btn">
                    	<span id="contRegistros">&nbsp;</span>
                        <?php include("inc/dropdown-informe.php"); // btns acciones másivas ?> 
                    </div>--->
                    <!-- input formulario de busqueda 
                    <form id="table-1" class="white-form right" onsubmit="return false;">
                      <div class="form-group">
                        <input id="searchEdit" type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                      </div>
                    </form>-->
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
                    <?php echo date("M-Y", strtotime($dataRelIni)); ?>
                  </div>
                </div>




                <div class="panel-body">
                  <div class="table-responsive">
                    <table id="tableInforme" class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="left-align">
                            <?php echo _('Cuenta') ?>
                          </th>

                               
                          <?php
						  
							//
							$listaIdLocais = '';
							while($rst_nomes_locais=@mysql_fetch_assoc($qry_nome_locais))
							{
								//
                            	echo "<th class='left-align'>";
                                echo $rst_nomes_locais['nome'];
                            	echo "</th>";		
								
								//gera lista de ids de local.	
								$listaIdLocais = $listaIdLocais . $rst_nomes_locais['id_local'] . ",";			
							}
							
							//echo $listaIdLocais;
						
							  
						  ?>                        
                           
                           <input type="hidden" id="hdListaIdLocais" name="hdListaIdLocais" value="<?php echo $listaIdLocais;?>"        
                                                   
                        </tr>
                      </thead>
                      <tbody>
                      		
                          <tr>       
                            <td class="left-align">
                              <strong>Ingresos Totales</strong>
                            </td>
                            
                            <?php 
							
								//
								$listaIdLocais = explode(",",$listaIdLocais);
								
								$tamLista = sizeof($listaIdLocais);
								
								//
								for ($i = 1; $i < $tamLista; $i++)
								{
									//echo $i . "<br>";
									if($i == 1)
									{
										echo "<td class='left-align'>";
										echo "<span id='spTotalGestor'></span>";	
										echo "</td> ";
									}
									else
									{
										echo "<td class='left-align'>&nbsp; ";
										echo "<span id='sp_Local_".$listaIdLocais[$i]."'></span>";
										echo "</td>";										
									}
								}
								//echo $teste[0];
							
							?>
                                   

                           

                          </tr>	
                          <tr>
                            <td class="left-align">
                              Locales
                            </td>                         
							  <?php
                              
    
                                //
								$pctLocais = 0;
								$listComOpeGer = '';
								$listaPctSocio = '';
								$totalGestor = 0;
								$listValoresLocais = '';
                                while($rst_ingressos_totais=@mysql_fetch_assoc($qry_ingressos_totais))
                                {
                                    //
									$ingrTot = $rst_ingressos_totais['ingrTotal']  - $rst_ingressos_totais['descTotal'];
									//$ingrTot = $rst_ingressos_totais['ingrTotal'] - $rst_ingressos_totais['difTotal'];
									if($rst_ingressos_totais['nome'] !== 'Calabaza')
									{									
										$ingrFinal = $ingrTot - (($ingrTot *20) / 100);
									}
									else
									{
										$ingrFinal = $ingrTot;
									}
    
                                    echo "<td class='left-align'>";
                                    echo "$ " . number_format($ingrFinal,0,"",".");
                                    echo "</td>";	
									
									$listValoresLocais = $listValoresLocais . "$ " . number_format($ingrFinal,0,"",".") . ",";
									
									//
									if($rst_ingressos_totais['nome'] == 'Calabaza')
									{
										$totalGestor = $ingrFinal;
									}						
                                    
									//echo $ingrTot  . "<br>";
									if($rst_ingressos_totais['nome'] !== 'Calabaza')
									{
										$pctLocais = $pctLocais + (($ingrTot * 20) / 100);
									}
									
									//
									$listComOpeGer = $listComOpeGer . (($ingrTot *5) / 100) . ',';	
									
									//verifica se é local proprio com socio.
									if($rst_ingressos_totais['id_tp_local'] == 2)
									{
										$pctSocio = ((($ingrTot * 80) / 100) - (($ingrTot * 5) / 100)) / 2;
									}
									else
									{
										$pctSocio = 0;	
									}
									
									//
									$listaPctSocio = $listaPctSocio . $pctSocio . ",";
									
                                }
                              ?>  
                          		<input type="hidden" id="hdListaValoresLocais" name="hdListaValoresLocais" value="<?php echo $listValoresLocais; ?>"    
                          </tr>	  
                          <tr>
                            <td class="left-align">
                            	20 % Locales
                            </td>
                            <td class="left-align">
                            	<?php 
									echo "$ " . number_format($pctLocais,0,"","."); 
								
									//
									$totalGestor = $totalGestor + $pctLocais;
								?>  
                            </td>                            
                            <td class="left-align" bgcolor="#CCCCCC">
                            	<input type="hidden" id="hdTotalGestor" name="hdTotalGestor" value="$ <?php echo number_format($totalGestor,0,"","."); ?>" />
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- - 
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- - 
                            </td>                                                                                                                                            
                          </tr>	  
                          <tr>
                            <td class="left-align">&nbsp;
                              
                            </td>
                            <td class="left-align">&nbsp;
                              
                            </td>                            
                            <td class="left-align">&nbsp;
                                
                            </td>
                            <td class="left-align">&nbsp;
                                
                            </td>
                            <td class="left-align" data-order="<?php echo $result_edit['data']; ?>">&nbsp;
                                
                            </td>
                            <td class="left-align" data-order="<?php echo $result_edit['data']; ?>">&nbsp;
                                
                            </td>
                            <td class="left-align" data-order="<?php echo $result_edit['data']; ?>">&nbsp;
                                
                            </td>
                            <td class="left-align" data-order="<?php echo $result_edit['data']; ?>">&nbsp;
                                
                            </td>
                            <td class="left-align" data-order="<?php echo $result_edit['data']; ?>">&nbsp;
                                
                            </td>                                                                                                                                            
                          </tr>	  
                          <tr>
                            <td class="left-align">
                              % Ger / Ope
                            </td>
                            
                            
                            
                            <?php 
							
								//
								$listComOpeGer = explode(",", $listComOpeGer); 
								$tamListCom = count($listComOpeGer) - 2;
								
								//
								//echo $tamLista;
								
								for ($i = 0; $i <= $tamListCom; $i++) 
								{
									//
									echo "<td class='left-align'>";
									echo "$ " . number_format($listComOpeGer[$i],0,"",".");
									echo "</td>";
								}

							?>
                            
                                                                                                         
                          </tr>	  
                          <tr>
                            <td class="left-align">
                              % Gestor
                            </td>
                            <td class="left-align">&nbsp;
                            	<?php 
									$totalGestor = $totalGestor * 0.10;
									echo "$ " . number_format($totalGestor,0,"",".");
								?>
                            </td>                            
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>
                            <td class="left-align" bgcolor="#CCCCCC">
                            	- -
                            </td>                            
                          </tr>	  
                          <tr>
                            <td class="left-align">
                              % Parceiro / Socio
                            </td>
                            
                            <?php
                            
								$listaPctSocio = explode(",", $listaPctSocio); 			
								$tamListaSoc = count($listaPctSocio) - 2;
								
								//
								//echo $tamArray;
								
								for ($i = 0; $i <= $tamListaSoc; $i++) 
								{  
									//
									$vlSocio = $listaPctSocio[$i];
									if($vlSocio == 0)
									{								
										echo "<td class='left-align' bgcolor='#CCCCCC'>";
										echo " - - ";	
										echo "</td>";	
									}	
									else
									{
										echo "<td class='left-align'>";
										echo "$ " . number_format($vlSocio,0,"",".");
										echo "</td>";											
									}						
								}
                            
							?>
                          </tr>	  
                          <tr>
                            <td class="left-align">
                              Rendición Locales 
                            </td>
                            <!---
                            <td class="left-align">
                            	$ 2.354.925                              
                            </td>      
                            <td class="left-align">&nbsp;
                             	$ $ 3.067.088
                            </td>
                            <td class="left-align">&nbsp;
                              	$ 495.706
                            </td>
                            <td class="left-align">&nbsp;
                              	$ 5.531.296
                            </td>
                            <td class="left-align">&nbsp;
                              	$ 5.715.867
                            </td>
                            <td class="left-align">&nbsp;
                              	$ 2.370.108
                            </td>
                            <td class="left-align">&nbsp;
                              	$ 1.892.413
                            </td>
                            <td class="left-align">&nbsp;
                              	$ 5.131.843
                            </td>                            --->                                                                                                                                                                        
                            
                            <?php
								//
								//echo $listaIdLocais[0] . " /// ";
								$tamLista = $tamLista - 1;
								
								for ($i = 0; $i < $tamLista; $i++) 
								{
									//consulta o tipo de local desse local
									$sqlTipoLocal = "SELECT
														id_tp_local
													FROM
														`local`
													WHERE
														id_local = " . $listaIdLocais[$i];
									$qryTipoLocal=@mysql_query($sqlTipoLocal);
									$rstTipoLocal=@mysql_fetch_assoc($qryTipoLocal);
									
									//
									if($rstTipoLocal['id_tp_local'] == 1 or $rstTipoLocal['id_tp_local'] == 6) // rua
									{
										//consulta despesas dos locais de rua desse mes
										//gera lista de ids de fechamentos desse mes de RUA
										$sql_listaFechaRua = "SELECT
																	fechamento.id_fechamento
																FROM
																	fechamento
																INNER JOIN
																	leitura
																ON
																	fechamento.id_fechamento = leitura.id_fechamento
																WHERE
																	(fechamento.data_fechamento >= '".date("Y-m-d", strtotime($dataRelIni))."'
																		AND
																	 fechamento.data_fechamento <= '".date("Y-m-d", strtotime($dataRelFim))."')
																AND
																	(leitura.id_tipo_local = 1 
																	OR
																	leitura.id_tipo_local = 6)
																GROUP BY
																	fechamento.id_fechamento";
																	
										$qry_listaFechaRua=@mysql_query($sql_listaFechaRua);
										//
										$totDespRua = 0;
										while($rst_listaFechaRua=@mysql_fetch_assoc($qry_listaFechaRua))
										{
											//
											//echo $rst_listaFechaRua['id_fechamento'] . "<br>";
											
											//consulta despesas desse fechamento
											$sql_despFechaRua = "SELECT
																	valor_desconto
																FROM
																	desconto_leit_fecha
																WHERE
																	fechamento = 1
																AND
																	id_leitura_fechamento = " . $rst_listaFechaRua['id_fechamento'];
											$qry_despFechaRua=@mysql_query($sql_despFechaRua);
											$rst_despFechaRua=@mysql_fetch_assoc($qry_despFechaRua);
											
											//
											$totDespRua = $totDespRua + $rst_despFechaRua['valor_desconto'];
										}
										
										//echo $totDespRua . " //// "; 
										
										
										
										/*
										
										SELECT DISTINCT
											desconto_leit_fecha.id_desconto,
											desconto_leit_fecha.valor_desconto
										FROM
											desconto_leit_fecha
										INNER JOIN
											fechamento
										ON
											desconto_leit_fecha.id_leitura_fechamento = fechamento.id_fechamento
										INNER JOIN
											leitura
										ON
											fechamento.id_fechamento = leitura.id_fechamento
										WHERE
											desconto_leit_fecha.fechamento = 1
										AND
											(fechamento.data_fechamento >= '2017-07-01'
										AND
											fechamento.data_fechamento <= '2017-07-31')
										AND
											(leitura.id_tipo_local = 1 or leitura.id_tipo_local = 6)
										*/
										
										
										//somar todas as despesas 
										echo "<td class='left-align'>";
										echo "$ " . number_format($totDespRua,0,"",".");
										echo "</td>";																			
									}
									else // local
									{
										//gera lista de ids de fechamento desse local
										$sql_listaFechamentos = "SELECT
																	id_fechamento
																FROM
																	leitura
																WHERE
																	id_local = " . $listaIdLocais[$i] . "
																AND
																	(data_fechamento >= '".date("Y-m-d", strtotime($dataRelIni))."' 
																	AND
																	data_fechamento <= '".date("Y-m-d", strtotime($dataRelFim))."')
																GROUP BY
																	id_fechamento";
																	
										$qry_listaFechamentos=@mysql_query($sql_listaFechamentos);	
										
										//
										$totDescLoc = 0;
										while($rst_listaFechamentos=@mysql_fetch_assoc($qry_listaFechamentos))
										{	
											//
											$slq_totalGastoFechamento = "SELECT
																			SUM(valor_desconto) as totDesconto
																		FROM
																			desconto_leit_fecha
																		WHERE
																			fechamento = 1
																		AND
																			id_leitura_fechamento = " . $rst_listaFechamentos['id_fechamento'];
																			
											$qry_totalGastoFechamento=@mysql_query($slq_totalGastoFechamento);
											$rst_totalGastoFechamento=@mysql_fetch_assoc($qry_totalGastoFechamento);
											
											$totDescLoc = $totDescLoc + $rst_totalGastoFechamento['totDesconto'];
										}										
																														
										
										//
										echo "<td class='left-align'>";
										echo "$ " . number_format($totDescLoc,0,"",".");
										echo "</td>";											
									}
									

																		
									/*if($i <> 0)
									{
										//
										$sql_listaFechamentos = "SELECT
																	id_fechamento
																FROM
																	leitura
																WHERE
																	id_local = " . $listaIdLocais[$i] . "
																AND
																	(data_fechamento >= '2017-07-01' 
																	AND
																	data_fechamento <= '2017-07-31')
																GROUP BY
																	id_fechamento";
																	
										$qry_listaFechamentos=@mysql_query($sql_listaFechamentos);	
										
										//echo $sql_listaFechamentos . "<br>";	
										
										//
										$totDescLoc = 0;
										while($rst_listaFechamentos=@mysql_fetch_assoc($qry_listaFechamentos))
										{	
											//
											$slq_totalGastoFechamento = "SELECT
																			SUM(valor_desconto) as totDesconto
																		FROM
																			desconto_leit_fecha
																		WHERE
																			fechamento = 1
																		AND
																			id_leitura_fechamento = " . $rst_listaFechamentos['id_fechamento'];
																			
											$qry_totalGastoFechamento=@mysql_query($slq_totalGastoFechamento);
											$rst_totalGastoFechamento=@mysql_fetch_assoc($qry_totalGastoFechamento);
											
											$totDescLoc = $totDescLoc + $rst_totalGastoFechamento['totDesconto'];
										}
										
										//
										echo "<td class='left-align'>";
										echo "$ " . number_format($totDescLoc,0,"",".");
										echo "<td'>";										
									}*/
								}
								

								

								


							?>

                                                                                                                                           
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
  </body>
  
  
<script>
	//
	totalGestor = $(hdTotalGestor).val();

	$("#spTotalGestor").text(totalGestor);
	//$("#localSelecionado").text(arrayValores[7]);
	
	
	
	//atribui valores de locais totais
	listaIdLocais = $("#hdListaIdLocais").val();
	listaIdLocais = (listaIdLocais).split(",");
	
	
	listaVlLocais = $("#hdListaValoresLocais").val();
	listaVlLocais = (listaVlLocais).split(",");	
	
	//
	tamListaId = listaIdLocais.length - 1;
	
	
	//
	for(var i = 1; i <= tamListaId; i++)
	{
		$("#sp_Local_"+listaIdLocais[i]).text(listaVlLocais[i-1]);
	}
	


	//alert($('#hdListaValoresLocais').val());
	
	
	//atribui a funcao do exp PDF do datatable.
	$('#exppdf').click( function() 
	{
		window.print() ; 
		
		/*var botoes = document.getElementsByTagName("a");
		for (var i = 0; i < botoes.length; i++) {
			
			//
			if (botoes[i].className === "dt-button buttons-pdf buttons-html5 btn btn-exp") {
				botoes[i].click();
			}
		}*/
	} );
	
	//atribui a funcao do exp XLS do datatable.
	$('#expexc').click( function() 
	{
		var botoes = document.getElementsByTagName("a");
		for (var i = 0; i < botoes.length; i++) {
			
			//
			if (botoes[i].className === "dt-button buttons-excel buttons-html5 btn btn-exp") {
				botoes[i].click();
			}
		}
	});
	
	
	/*
	//mostra o contador de registros exibidos
	setInterval(function()
	{
		$('#contRegistros').text($('#tableInforme_info').text());
		
	}, 500);
	$('#tableInforme_info').hide();		
	
	
	//
	function alimentaView(obj)
	{
		var idMaq = (obj.id).split("_");
		
		var $iframe = $('#view_maq');
		$iframe.attr('src','frames/view-maquina.php?id='+idMaq[1]);  		
	}	*/
	
</script>
