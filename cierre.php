<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//pega o tipo de local.
$tipoLocal = $_POST['postTpLocal'];

//pega a semana de fechamento para comparar com as leituras
$dtFechamento = $_POST['datepicker'];

//pega o local se for proprio ou com socio
$idLocalProprio = $_POST['postLocal'];

//echo $idLocalProprio;


//limita acesso usuario <> master
if($_SESSION['usr_nivel'] == 1)
{
	$whr = " AND 1 = 1";
}
else
{
	//
	if($idLocalProprio <> 0)
	{
		$whr = " AND leitura.id_login = " . $_SESSION['id_login'] . " AND leitura.id_local = " . $idLocalProprio;		
	}
	else
	{
		$whr = " AND leitura.id_login = " . $_SESSION['id_login'];		
	}
}

//consulta as leituras em aberto
$sql_leituras_abertas = "SELECT
							leitura.*,
							`local`.id_local,
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

//echo $sql_leituras_abertas;




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


//gerar lista de locais a serem fechados.



// fazer isso somente para RUA  
if($tipoLocal == 1)
{
	//	
	/*$sqlListaLocaisFechar = "SELECT
								id_local
							FROM
								`local`
							WHERE
								id_login = ".$_SESSION['id_login']."
							OR
								id_gerente = ".$_SESSION['id_login']."
							AND
								id_tp_local = 1 
							AND
								excluido = 'N'";*/
								
	$sqlListaLocaisFechar = "SELECT
								id_local
							FROM
								`local`
							WHERE
								id_login = ".$_SESSION['id_login']."
							AND
								id_tp_local = 1 
							AND
								excluido = 'N'";								
								
	$qryListaLocaisFechar = @mysql_query($sqlListaLocaisFechar);	
	
	//echo $sqlListaLocaisFechar;

	//
	$lstCompletaLocais = '';
	while($resListaLocaisFechar=@mysql_fetch_assoc($qryListaLocaisFechar))	
	{
		$lstCompletaLocais = $lstCompletaLocais . $resListaLocaisFechar['id_local'] . ",";
	}	
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
          <input type="hidden" id="hdListaTotalLocais" name="hdListaTotalLocais" value="<?php echo $lstCompletaLocais; ?>" />
          <input type="hidden" id="hdDtFechamento" name="hdDtFechamento" value="<?php echo $dtFechamento ?>" />
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
                                      <label><input type="checkbox" id="chk_bx_<?php echo $res_leituras_abertas['id_leitura'] ?>" name="chk_bx_<?php echo $res_leituras_abertas['id_leitura'] ?>" title="<?php echo ($res_leituras_abertas['fat_bruto'] - $totalDesconto);?>" value="<?php echo $res_leituras_abertas['id_leitura'] ?>" class="chk_bx_leituras[]" list="<?php echo $res_leituras_abertas['id_local'] ?>" onClick="totalizadores(this);"><span class="checkbox-material"></span></label>
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
                                    <a href="ver-informe-lectura.php?id=<?php echo $res_leituras_abertas['id_leitura']; ?>" class="btn btn-sm" target="new" title="Ver"><i class="fa fa-eye"></i> </a>
                                </td>
                            </tr>                        
                        <?php	
							//
							$totalFat = $totalFat + $res_leituras_abertas['fat_bruto'];
							$totalDescontoFinal = $totalDescontoFinal + $totalDesconto;
							
							
							//zera variaveis
							$pctLocal = 0;
							$totPctEsp = 0;
							$fatNormal = 0;
							$totalDesconto = 0;
							
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
                  <a href="#" class="btn btn-sm" data-toggle="modal" data-target="#add-modal-gastos" title="Ingresar Gasto"><i class="fa fa-plus"></i> <?php echo _('Ingresar Gasto') ?></a>
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
		var novaEntrada = Math.ceil(valores);
		//var novaSaida = valores[1];

		//alert(novaEntrada);
		
		//limpa valores para calculos
		totalEntradaAtual = totalEntradaAtual.replace('.', '');
		totalEntradaAtual = totalEntradaAtual.replace('.', '');
		totalEntradaAtual = totalEntradaAtual.replace('.', '');	
		
		totalSaidaAtual = totalSaidaAtual.replace('.', '');
		totalSaidaAtual = totalSaidaAtual.replace('.', '');	
		totalSaidaAtual = totalSaidaAtual.replace('.', '');		
				
			
				
		//verificacoes
		//verifica se o checkbox esta sendo marcado ou desmarcado.
		if(obj.checked)
		{
			//calcula o novo total de entrada
			var novoTotalEntradas = eval(totalEntradaAtual) + eval(novaEntrada);
		}
		else
		{
			//calcula o novo total de entrada
			var novoTotalEntradas = eval(totalEntradaAtual) - eval(novaEntrada);		
		}
		
		
		
		
		//calcula o total a pagar
		totalPagar = eval(novoTotalEntradas) - eval(totalSaidaAtual);

		
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
		//alert("selecionar tudo");
		 $("input[type='checkbox'][class='chk_bx_leituras[]']").not(this).prop('checked', this.checked);	
		 
		 //pega o valor total de a pagar de todas as leituras.
		 var totFinalPagar = <?php echo $somaTotalPagar;?>;
		 totFinalPagar = Math.ceil(totFinalPagar);
		 //alert(totFinalPagar);
		
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
		//verificar se a saida superam 74 % da entrada
		var entradaTotal = $('#totalEntradas').text();	
		var saidaTotal = $('#totalSaidas').text();
		
		
		//limpa valores
		 entradaTotal = entradaTotal.replace('.', '');
		 entradaTotal = entradaTotal.replace('.', '');
		 entradaTotal = entradaTotal.replace('.', '');
		 
		 saidaTotal = saidaTotal.replace('.', '');
		 saidaTotal = saidaTotal.replace('.', '');
		 saidaTotal = saidaTotal.replace('.', '');		 
		 
		 //declara limite de gasto
		 limSaida = eval(entradaTotal) * 0.74;
		 		 		
		
		 //verifica se esta dentro do limite de gastos
		 if(eval(saidaTotal) > eval(limSaida))
		 {
			//Limite superado 
			alert("Error! Limite de gastos superado!");
		 }
		 else
		 {
			//verificar se é rua 
			tipoLocal = <?php echo $tipoLocal; ?>;

			//rua
			if(tipoLocal == 1)
			{
				 //
				 listaTotalLocais = $('#hdListaTotalLocais').val();
				 
				 //efetua looping em todos os locais.
				 listaTotalLocais = listaTotalLocais.split(',');
				 qtdLocaisTotal = listaTotalLocais.length - 1;
				 
				 
				 //verifica se todos os locais estam selecionados.
				 flagFaltaLocal = 0;
				 //alert(qtdLocaisTotal);
				 for (var i = 0; i < qtdLocaisTotal; i++)
				 {
					 //alert("comeco ciclo");
					 //verifica se estao todas as leitura
					$("input[class='chk_bx_leituras[]']:checked").each(function(){
						//
						//alert($(this).attr("list") + " = = " + listaTotalLocais[i]);
						if($(this).attr("list") == listaTotalLocais[i])
						{
							 //alert("tem local");
							 //alert("mudar flag")
							 flagFaltaLocal = 1;
						}
						else
						{
							//alert("NAO TEM LOCAL");
							//break;
						}
					});
					
					//
					if(flagFaltaLocal == 0)
					{
						//interromper --- falta leitura.	
						alert("Error! Hay que ingresar por lo menos una lectura de cada local.");
						break;
					}
					else
					{
						flagFaltaLocal = 0;
					}
					
					
					
					//ver se chegou no fim
					if(i+1 == qtdLocaisTotal)
					{
						
						//verificar se todas as leituras em aberto dessa semana desse operador estao selecionadas.
						
						//pegar data de fechamento
						dataFechamento = $('#hdDtFechamento').val();
						dataFechamento = dataFechamento.split(',');

						//alert(dataFechamento[0]);
										
						//
						jQuery.ajax(
						{
							type: "POST", // Defino o método de envio POST / GET
							url: 'leituras_fechamentoAtual.php', // Informo a URL que será pesquisada.
							data: 'dtRefFech='+dataFechamento[0],
							//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
							success: function(html)
							{
								//retorno
								listaLeitura = html.split(',');
								qtdLeituras = listaLeitura.length - 1;
								
								
								//ver tamanho da array
								flagLeituraMarcada = 0;
								for(var i = 0; i < qtdLeituras; i++)
								{
									//
									if($("#chk_bx_"+listaLeitura[i]).is(":checked") == false)
									{
										flagLeituraMarcada = 1;
									}
								}
			
								//
								if(flagLeituraMarcada == 0)
								{
									//deixa fechar
									//alert("Pode Fechar");
									$('#confirma_fechamento').submit();
								}
								else
								{
									//erro, pode fechar
									alert("Favor seleccionar todas las lecturas de esa semana!");
									
								}
							}
						});
					}
				 }				
			}
			else // proprio e com socio
			{
				//verificar se todas as leituras em aberto dessa semana desse operador estao selecionadas.
				
				//pegar data de fechamento
				dataFechamento = $('#hdDtFechamento').val();
				dataFechamento = dataFechamento.split(',');
	
				//alert(dataFechamento[0]);
				idLocalProprio = <?php echo $idLocalProprio; ?>;
				
				//alert(idLocalProprio);
								
				//
				jQuery.ajax(
				{
					type: "POST", // Defino o método de envio POST / GET
					url: 'leituras_fechamentoAtual.php', // Informo a URL que será pesquisada.
					data: 'dtRefFech='+dataFechamento[0]+'&idLocal='+idLocalProprio,
					//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
					success: function(html)
					{
						//retorno
						listaLeitura = html.split(',');
						qtdLeituras = listaLeitura.length - 1;
						
						
						//ver tamanho da array
						flagLeituraMarcada = 0;
						for(var i = 0; i < qtdLeituras; i++)
						{
							//
							if($("#chk_bx_"+listaLeitura[i]).is(":checked") == false)
							{
								flagLeituraMarcada = 1;
							}
						}
	
						//
						if(flagLeituraMarcada == 0)
						{
							//deixa fechar
							$('#confirma_fechamento').submit();
						}
						else
						{
							//erro, pode fechar
							alert("Favor seleccionar todas las lecturas de esa semana!");
							
						}
					}
				});				
			}
		 }
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
      