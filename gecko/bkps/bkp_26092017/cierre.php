<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//limita acesso usuario <> master
if($_SESSION['usr_nivel'] == 1)
{
	$whr = " AND 1 = 1";
}
else
{
	$whr = " AND leitura.id_login = " . $_SESSION['id_login'];
}

//consulta as leituras em aberto
$sql_leituras_abertas = "SELECT
							leitura.*,
							`local`.nome,
							`local`.id_tp_local,
							`local`.percentual
						FROM
							leitura
						INNER JOIN
							`local`
						ON
							leitura.id_local = `local`.id_local
						WHERE
							id_fechamento = 0
							" . $whr . "
						ORDER BY leitura.id_leitura DESC";
$query_leituras_abertas = @mysql_query($sql_leituras_abertas);




//calcula soma de valores de gastos ja inseridos para esse fechamento.
$sql_vl_gastos_fecha = "SELECT
							SUM(valor_desconto) as gastos_fechamento
						FROM
							desconto_leit_fecha
						WHERE
							id_login = ".$_SESSION['id_login']."
						AND
							fechamento = 1
						AND
							id_leitura_fechamento = 0";
$query_vl_gastos_fecha = @mysql_query($sql_vl_gastos_fecha);							
$res_vl_gastos_fecha=@mysql_fetch_assoc($query_vl_gastos_fecha);

//echo $res_vl_gastos_fecha['gastos_fechamento'];



?>
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
            <div class="col-xs-12 col-lg-6">
              <h3 class="main-title">
                <span class="fa-stack fa-md">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-eye fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo _('Cierre') ?>
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons-crear-cierre.php"); // btns paneles ?>
              <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
            </div>
          </div>
          <form name='confirma_fechamento' id='confirma_fechamento' action='add_fechamento.php?c=carregar' method='POST'>
          <div class="row">
            <div class="col-xs-12 col-md-7 ">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <!-- dropdown de selects -->
                    <div class="btn-group white-btn">
                      <?php //include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                      Lecturas en abierto
                    </div>
                  </div>
                </div>
                <div class="panel-body">
                  <div class="table-responsive" style="height:470px;">
                    <table class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="left-align sort-none">
                            <div class="checkbox">
                              <label><input id="checkTodasLeituras" type="checkbox"><span class="checkbox-material"></span></label>
                            </div>
                          </th>
                          <th class="left-align">
                            <?php echo _('Fecha') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Nombre') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Facturación') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Descuentos') ?>
                          </th>                          
                          <th class="left-align">
                            <?php echo _('A pagar') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Lectura') ?>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      	
                        <?php
							//efgetua o loop nas leituras
							$totalFat = 0;
							$totalDescontoFinal = 0;
							while($res_leituras_abertas=@mysql_fetch_assoc($query_leituras_abertas))
							{
								
								
						
								//
								$sqlMaqEsp = "SELECT
													valor_entrada as entradaEsp,
													valor_saida as saidaEsp,
													pct_esp_maq
												FROM
													leitura_por_maquina
												WHERE
													id_local = ".$res_leituras_abertas['id_local']."
												AND
													pct_esp_maq > 0
												AND
													id_leitura = ". $res_leituras_abertas['id_leitura'];
													
								
								$queryMaqEsp = @mysql_query($sqlMaqEsp);
								
								//
								
		
								$totPctEsp = 0;
								$totSubEsp = 0;
								while($resMaqEsp=@mysql_fetch_assoc($queryMaqEsp))
								{
									//
									$subEspMaq = $resMaqEsp['entradaEsp'] - $resMaqEsp['saidaEsp'] . "<br>";
									$pctMaqEsp = ($subEspMaq * ($resMaqEsp['pct_esp_maq'])) / 100;
									
									
									
									$totSubEsp = $totSubEsp + $subEspMaq;
									$totPctEsp = $totPctEsp + $pctMaqEsp;
								}
								
		
		
								//echo $totSubEsp . " /// " . $totPctEsp . "<br>";
								
								$fatNormal = $res_leituras_abertas['fat_bruto'] - $totSubEsp;
								
								//echo $totalDesconto . "<br>";								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								
								//calcula total de descontos a aplicar
								if($res_leituras_abertas['id_tp_local'] == 1)
								{
									$pctLocal = ($fatNormal * $res_leituras_abertas['percentual']) / 100;
									$totalDesconto = $res_leituras_abertas['total_desconto'] + $pctLocal + $totPctEsp;
								}
								
								
						?>
                            <tr>
                                <td class="left-align">
                                    <div class="checkbox">
                                      <label><input type="checkbox" id="chk_bx_<?php echo $res_leituras_abertas['id_leitura'] ?>" name="chk_bx_<?php echo $res_leituras_abertas['id_leitura'] ?>" title="<?php echo ($res_leituras_abertas['fat_bruto'] - $totalDesconto);?>" value="<?php echo $res_leituras_abertas['id_leitura'] ?>" class="checkAll" onClick="totalizadores(this);"><span class="checkbox-material"></span></label>
                                    </div>
                                </td>
                                <td class="left-align">
                                    <?php echo date('d-m-Y', strtotime($res_leituras_abertas['data'])); ?>
                                </td>
                                <td class="left-align">
                                    <?php echo $res_leituras_abertas['nome']; ?>
                                </td>
                                <td class="left-align">
                                    $ <?php echo number_format($res_leituras_abertas['fat_bruto'],0,"","."); ?>	
                                </td>
                                <td class="left-align">
                                    $ <?php echo number_format($totalDesconto,0,"","."); ?>	
                                </td>                            
                                <td class="left-align">
                                    $ <?php echo number_format(($res_leituras_abertas['fat_bruto'] - $totalDesconto),0,"","."); ?>
                                </td>
                                <td class="left-align">
                                    <a href="ver-informe-lectura.php?id=<?php echo $res_leituras_abertas['id_leitura']; ?>" class="btn btn-sm" target="new"><?php echo _('Ver') ?></a>
                                </td>
                            </tr>                        
                        <?php	
							//
							$totalFat = $totalFat + $res_leituras_abertas['fat_bruto'];
							$totalDescontoFinal = $totalDescontoFinal + $totalDesconto;
							
							}
							
							$somaTotalPagar = $totalFat - $totalDescontoFinal;		
						?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-md-5 ">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                  <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#add-modal-gastos"><?php echo _('ingresar gasto') ?></a>
                </form>
              </div>
            </div>
            <div class="panel-body">
              <div class="table-responsive">
                <table id="tableGastos" class="table table-striped table-hover">
                  <thead>
                    <tr>
                      <th class="left-align sort-none">
                        <div class="checkbox">
                          <label><input id="checkTodosGastos" type="checkbox"><span class="checkbox-material"></span></label>
                        </div>
                      </th>                      
                      <th class="left-align">
                        <?php echo _('Detalle') ?>
                      </th>
                      <th class="left-align">
                        <?php echo _('Documento') ?>
                      </th>
                      <th class="left-align">
                        <?php echo _('valor') ?>
                      </th>
                      <th class="left-align">
                        <?php echo _('Excluir') ?>
                      </th>
                    </tr>
                  </thead>
                  <tbody> 
                  
                                   
                  	<?php
				  
				  	//consulta despesas em aberto desse operador
					$sql_gastos_abertos = "SELECT * FROM desconto_leit_fecha WHERE fechamento = 1 AND id_login = ".$_SESSION['id_login']." AND id_maquina = 0 AND id_leitura_fechamento = 0";
					$query_gastos_abertos = @mysql_query($sql_gastos_abertos);
					
					//
					while($res_gastos_abertos=@mysql_fetch_assoc($query_gastos_abertos))
					{
					?>
                		<tr id="ln_gasto_<?php echo $res_gastos_abertos['id_desconto']; ?>">
                        	<td class="left-align">
                            	<div class="checkbox">
                            		<label><input type="checkbox" id="chk_desp_<?php echo $res_gastos_abertos['id_desconto'] ?>" name="checkGastos[]" title="<?php echo $res_gastos_abertos['valor_desconto'];?>" value="<?php echo $res_gastos_abertos['id_desconto'] ?>" onClick="totalizadorGasto(this);"><span class="checkbox-material"></span></label>
                             	</div>                            
                            </td>
                        	<td class="left-align">
                            	<?php echo $res_gastos_abertos['descricao']; ?>
                            </td>
                        	<td class="left-align">
                            	<?php echo $res_gastos_abertos['tipo_doc']; ?>
                            </td>
                        	<td class="left-align">
	                            <?php echo "$ " . number_format($res_gastos_abertos['valor_desconto'],0,"","."); ?>
                            </td>
                        	<td class="left-align">
         	                   <a id="btn_excluir_<?php echo $res_gastos_abertos['id_desconto']; ?>" class="btn btn-sm" target="new" onClick="excluiGasto(this);"><?php echo _('Excluir') ?></a>
                            </td>
                        </tr>
                	<?php						
					}
				  
				  	?>

                  
                  </tbody>                
                </table>
              </div>
            </div>
          </div>
        </div>

      </div>

      <div class="row">

        <div class="col s12 m7">

          <div class="row">

            <div class="col s12 m12 l12">
              <div class="panel">
                    <!-- <div class="panel-heading">
                      <div class="input-wrap">
                        <form id="table-1" class="white-form right">
                          <div class="form-group">
                            <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                          </div>
                        </form>
                      </div>
                    </div> -->
                    <div class="panel-body">
                      <div class="table-responsive">
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th class="left-align" colspan="2">
                                <?php echo _('Totalizadores') ?>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td class="left-align"><?php echo _('Total entradas: ') ?></td>
                              <td class="left-align">$ <span id="totalEntradas">0</span></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo _('Total salidas:') ?></td>
                              <td class="left-align">$ <span id="totalSaidas">0</span></td>
                            </tr>
                            <tr>
                              <td class="left-align"><?php echo _('Total a Pagar') ?></td>
                              <td class="left-align"><strong>$ <span id="totalPagar">0</span></strong></td>
                            </tr>
                          </tbody>
                        </table>
                        <input type="hidden" id="totalGastoFechamento" name="totalGastoFechamento" value="<?php echo $res_vl_gastos_fecha['gastos_fechamento']; ?>" />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>




            </div>
          </div>
          </form>
        </div>

        <?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
        <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
        <?php include("inc/modals/modal-add-gastos.php"); // modal para ver detalles contenido ?>
      </body>
      </html>
     
      
<script language="javascript">
	//
	function totalizadores(obj)
	{

		//
		var totalEntradaAtual = $('#totalEntradas').text();
		var totalSaidaAtual = $('#totalSaidas').text();
		
		//
		var valores = obj.title;
		var novaEntrada = valores;
		//var novaSaida = valores[1];
		
		//limpa valores para calculos
		totalEntradaAtual = totalEntradaAtual.replace('.', '');
		totalEntradaAtual = totalEntradaAtual.replace('.', '');	
		
		//totalSaidaAtual = totalSaidaAtual.replace('.', '');
		//totalSaidaAtual = totalSaidaAtual.replace('.', '');		
				
				
		//verificacoes
		//verifica se o checkbox esta sendo marcado ou desmarcado.
		if(obj.checked)
		{
			//calcula o novo total de entrada
			var novoTotalEntradas = eval(totalEntradaAtual) + eval(novaEntrada);
			//var novoTotalSaidas = eval(totalSaidaAtual) + eval(novaSaida);
		}
		else
		{
			//calcula o novo total de entrada
			var novoTotalEntradas = eval(totalEntradaAtual) - eval(novaEntrada);
			//var novoTotalSaidas = eval(totalSaidaAtual) - eval(novaSaida);
		}
		
		
		//calcula o total a pagar
		//totalPagar = eval(novoTotalEntradas) - eval(novoTotalSaidas);
		totalPagar = eval(novoTotalEntradas);

		
		//trata valores
		novoTotalEntradas = eval(novoTotalEntradas).formatNumber(2,',','.');
		novoTotalEntradas = novoTotalEntradas.replace(',00', '');		
		
		//atribui o valor ao total de entradas
		$('#totalEntradas').text(novoTotalEntradas);

/*
		//trata valores
		novoTotalSaidas = eval(novoTotalSaidas).formatNumber(2,',','.');
		novoTotalSaidas = novoTotalSaidas.replace(',00', '');		
		
		//atribui o valor ao total de entradas
		$('#totalSaidas').text(novoTotalSaidas);
		*/
		
		//trata valores
		totalPagar = eval(totalPagar).formatNumber(2,',','.');
		totalPagar = totalPagar.replace(',00', '');		
		
		//atribui valor final a pagar
		$('#totalPagar').text(totalPagar);
			
	}
	
	//
	function excluiGasto(obj)
	{
		//
		idGasto = obj.id.split('_');
		idGasto = idGasto[2];


		//
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'remove_despesa.php', // Informo a URL que será pesquisada.
			data: 'id_desp='+idGasto,
			//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
			success: function(html)
			{
				retorno = html.split('-');
				
				if(retorno[0] == "true")
				{
					$('#ln_gasto_'+idGasto).remove();
					
					//subtrair valor da desp excluida do total de gastos
					var totGastoFecha = $('#totalGastoFechamento').val();
					
					totGastoFecha = eval(totGastoFecha) - eval(retorno[1]);
					$('#totalGastoFechamento').val(totGastoFecha);
				}
				else
				{
					alert("Error!!");
				}
			}
		});	
	}
	
	//
	$("#checkTodasLeituras").click(function()
	{
		 $("input[type='checkbox'][class='checkAll']").not(this).prop('checked', this.checked);	
		 
		 //pega o valor total de a pagar de todas as leituras.
		 var totFinalPagar = <?php echo $somaTotalPagar;?>;
		
		 //
		 totFinalPagar = eval(totFinalPagar).formatNumber(2,',','.');
		 totFinalPagar = totFinalPagar.replace(',00', '');	
		 
		 //verificar se esta sendo marcado ou desmarcado o checkall
		 if(this.checked == true)
		 {
			 $('#totalEntradas').text(totFinalPagar);	 
		 }
		 else
		 {
			 $('#totalEntradas').text(0);
		 }
		 
		 
		 //recalcula valor final a pagar
		 var entradaTotal = $('#totalEntradas').text();	
		 var saidaTotal = $('#totalSaidas').text();	
		 
		 entradaTotal = entradaTotal.replace('.', '');
		 entradaTotal = entradaTotal.replace('.', '');
		 
		 saidaTotal = saidaTotal.replace('.', '');
		 saidaTotal = saidaTotal.replace('.', '');		 			 
		 
		 
		 novoTotal = eval(entradaTotal) - eval(saidaTotal);
		 
		 
		 novoTotal = eval(novoTotal).formatNumber(2,',','.');
		 novoTotal = novoTotal.replace(',00', '');		 
		 
		 $('#totalPagar').text(novoTotal);		 
		 
	});
	
	
	//
	$("#checkTodosGastos").click(function()
	{
		//alert($('#totalGastoFechamento').val());
		$("input[type='checkbox'][name='checkGastos[]']").not(this).prop('checked', this.checked);	
		
		//atribui valor ao total de saidas
		var totalGastoFecha = $('#totalGastoFechamento').val();	
		
		
		//verificar se esta sendo marcado ou desmarcado
		if(this.checked == true)
		{
			totalGastoFecha = eval(totalGastoFecha).formatNumber(2,',','.');
			totalGastoFecha = totalGastoFecha.replace(',00', '');				
			
			$('#totalSaidas').text(totalGastoFecha);	 
		}
		else
		{
			$('#totalSaidas').text(0);
		}		
		
		
		
		//recalcula valor final a pagar
		var entradaTotal = $('#totalEntradas').text();	
		var saidaTotal = $('#totalSaidas').text();	
		
		entradaTotal = entradaTotal.replace('.', '');
		entradaTotal = entradaTotal.replace('.', '');
		
		saidaTotal = saidaTotal.replace('.', '');
		saidaTotal = saidaTotal.replace('.', '');		 			 
		
		
		novoTotal = eval(entradaTotal) - eval(saidaTotal);
		
		
		novoTotal = eval(novoTotal).formatNumber(2,',','.');
		novoTotal = novoTotal.replace(',00', '');		 
		
		$('#totalPagar').text(novoTotal);			
		
		
	});	
	
	
	//
	$("#btnAddCierre").click(function()
	{
		//alert("vai submeter o fechamento");
		$('#confirma_fechamento').submit();
	});
	
	//function
	function totalizadorGasto(obj)
	{
		
		var totalSaidaAtual = $('#totalSaidas').text();
		var gastoSelecionado = obj.title;
		var totalPagarAtual = $('#totalPagar').text();
		
		//limpa valores
		totalSaidaAtual = totalSaidaAtual.replace('.', '');
		totalSaidaAtual = totalSaidaAtual.replace('.', '');	
		
		totalPagarAtual = totalPagarAtual.replace('.', '');
		totalPagarAtual = totalPagarAtual.replace('.', '');	
		
				

		//verifica se esta sendo marcado ou desmarcado.
		if(obj.checked == true)
		{
			novoValorSaida = eval(totalSaidaAtual) + eval(gastoSelecionado);
			novoValorPagar = eval(totalPagarAtual) - eval(gastoSelecionado);	
		}
		else
		{
			novoValorSaida = eval(totalSaidaAtual) - eval(gastoSelecionado);
			novoValorPagar = eval(totalPagarAtual) + eval(gastoSelecionado);
		}
		
		//
		//trata valores
		novoValorSaida = eval(novoValorSaida).formatNumber(2,',','.');
		novoValorSaida = novoValorSaida.replace(',00', '');	
		
		novoValorPagar = eval(novoValorPagar).formatNumber(2,',','.');
		novoValorPagar = novoValorPagar.replace(',00', '');				
		
		//
		$('#totalSaidas').text(novoValorSaida);
		$('#totalPagar').text(novoValorPagar);

	}
	
	

</script>
      