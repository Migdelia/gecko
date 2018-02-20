<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');


$dataInicio = $_GET['dtInicio'];
$dataFim = $_GET['dtFinal'];
$idLocal = $_GET['idLocal'];

//$anoIni = $_GET['anoIni'];
/*$semFim = $_GET['semFim'];
$mesFim = $_GET['mesFim'];
$anoFim = $_GET['anoFim'];*/

if($dataInicio == '')
{
	$dataInicio = date("Y-m-d");	
}


if($dataFim == '')
{
	$dataFim = date("Y-m-d");	
}

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
                  <a id="teste" onClick="atuRelatorio('column');" href="#" class="btn" style="margin:0 0 0 10px;"><?php echo _('Barra'); ?></a>
                  <a id="teste" onClick="atuRelatorio('pie');" href="#" class="btn" style="margin:0 0 0 10px;"><?php echo _('Pizza'); ?></a>                 
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons-informes.php"); // btns paneles ?>
              <?php include("inc/modals/modal-select-filtro-promedio.php"); // modal para agregar contenido ?>
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
                        <div class="table-responsive ">
                          <table id="tableInforme" class="table table-striped table-hover locales">
                            <thead>
                              <tr>
                                <th><?php echo _('Local') ?></th>
                                <th><?php echo _('Nº Máquinas') ?></th>
                                <th><?php echo _('Fat Bruto') ?></th>
                                <th><?php echo _('Promedio') ?></th>
                              </tr>
                            </thead>
                            <tbody>                            
                            
                            
                           
                            <?php
				
								
								/*
								//
								$semanas = "";
								for ($i = $semIni; $i <= $semFim; $i++) 
								{
									if($i == $semIni)
									{
										$semanas = $semanas . " leitura.semana = " . $i;	
									}
									else
									{
										$semanas = $semanas . " OR leitura.semana = " . $i;	
									}
									
								}									
								*/

							
							
								//
								/*
								$sqlPromMaq = "SELECT
													COUNT(DISTINCT id_maquina) as qtdMaquinas,
													SUM(valor_entrada) AS entradaTotal,
													SUM(valor_saida) AS saidaTotal,
													`local`.nome,
													((SUM(valor_entrada)) - (SUM(valor_saida))) / COUNT(DISTINCT id_maquina) as promedio
												FROM
													leitura_por_maquina
												INNER JOIN locais_integrados ON leitura_por_maquina.id_local = locais_integrados.id_local
												INNER JOIN leitura ON leitura_por_maquina.id_leitura = leitura.id_leitura
												INNER JOIN `local` ON leitura_por_maquina.id_local = `local`.id_local
												WHERE
												(
													leitura_por_maquina.data_cadastro >= '".date("Y-m-d", strtotime($dataInicio))."'
													AND leitura_por_maquina.data_cadastro <= '".date("Y-m-d", strtotime($dataFim))."'
												)
												GROUP BY
													leitura_por_maquina.id_local
												ORDER BY
													promedio DESC";*/
													
								//idLocal		
								//echo $idLocal . " /// "; 		
								if($idLocal == '' or $idLocal == 'null' or $idLocal == 0)
								{
									//
									$sqlPromMaq = "SELECT
														COUNT(DISTINCT id_maquina) as qtdMaquinas,
														SUM(valor_entrada) AS entradaTotal,
														SUM(valor_saida) AS saidaTotal,
														`local`.nome,
														((SUM(valor_entrada)) - (SUM(valor_saida))) / COUNT(DISTINCT id_maquina) as promedio
													FROM
														leitura_por_maquina
													INNER JOIN leitura ON leitura_por_maquina.id_leitura = leitura.id_leitura
													INNER JOIN `local` ON leitura_por_maquina.id_local = `local`.id_local
													WHERE
													(
														leitura_por_maquina.data_cadastro >= '".date("Y-m-d", strtotime($dataInicio))."'
														AND leitura_por_maquina.data_cadastro <= '".date("Y-m-d", strtotime($dataFim))."'
													)
													GROUP BY
														leitura_por_maquina.id_local
													ORDER BY
														promedio DESC";
								}
								else // 
								{
									$sqlPromMaq = "SELECT
														COUNT(DISTINCT id_maquina) as qtdMaquinas,
														SUM(valor_entrada) AS entradaTotal,
														SUM(valor_saida) AS saidaTotal,
														`local`.nome,
														((SUM(valor_entrada)) - (SUM(valor_saida))) / COUNT(DISTINCT id_maquina) as promedio
													FROM
														leitura_por_maquina
													INNER JOIN leitura ON leitura_por_maquina.id_leitura = leitura.id_leitura
													INNER JOIN `local` ON leitura_por_maquina.id_local = `local`.id_local
													WHERE
													(
														leitura_por_maquina.data_cadastro >= '".date("Y-m-d", strtotime($dataInicio))."'
														AND leitura_por_maquina.data_cadastro <= '".date("Y-m-d", strtotime($dataFim))."'
													)
													AND 
														`local`.id_local IN (". $idLocal .")
													GROUP BY
														leitura_por_maquina.id_local
													ORDER BY
														promedio DESC";									
								}
								//echo $sqlPromMaq; 
								
								//		
								$queryPromMaq=@mysql_query($sqlPromMaq);
								
																
								//
								$teste = "";
								while($rstPromMaq=@mysql_fetch_assoc($queryPromMaq))
								{
									//
									if($rstPromMaq['entradaTotal'] > 0)
									{
									
										//realiza calculos
										$vlFat = $rstPromMaq['entradaTotal'] - $rstPromMaq['saidaTotal'];
										$promMaq = $vlFat / $rstPromMaq['qtdMaquinas'];
										
										//echo $rstPromMaq['nome'] . "<br>";
										
										echo "<tr>";
										echo "<td>".$rstPromMaq['nome']."</td>";
										echo "<td>".$rstPromMaq['qtdMaquinas']."</td>";
										echo "<td>".number_format($vlFat,0,"",".")."</td>";
										echo "<td>".number_format($promMaq,0,"",".")."</td>";
										echo "</tr>";
										
										
										$teste = $teste . "{ name: '".$rstPromMaq['nome']."', y: ".(round($promMaq))."},";
										
									}
								}
								
								
								//echo $teste;
								
							
							?>
                            

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


<script>

	// gráfico informe promedio por máquina
	function realoadGrafico(tipo)
	{
		if(tipo == "pie")
		{
			var pName = "{point.name}: ";
		}
		else
		{
		 	var pName = "";
		}
		
		$('#prom-maquinas').highcharts({
			chart: {
				type: tipo
			},			
			title: {
				text: 'Promedio máquinas'
			},
			subtitle: {
				text: ''
			},
			xAxis: {
				type: 'category'
			},
			yAxis: {
				title: {
					text: 'Promedio máquinas por local'
				}
			},
			legend: {
				enabled: false
			},
			plotOptions: {
				series: {
					borderWidth: 0,
					dataLabels: {
						enabled: true,
						format: pName+'{point.y:,f}'
					}
				}
			},
			tooltip: {
						shared: false,
						formatter: function() {
								 var text = '';
								 if (this.series.name == 'Lectura') {
										 text = this.series.name + ': <br> $' + (this.y) + ' promedio';
								 } else {
										 text = this.series.name + ': <br>' + (this.y) + ' ';
								 }
								 return text;
						 }
				// headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
				// pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>${point.y:0f}</b> promedio<br/>'
			},
			series: [
						{
							type: tipo,
				  name: "Promedio por Maquina",
				  colorByPoint: true,
				  data: [
								<?php echo $teste; ?>
							]
				},
					],
		});		
	}

	
	var tipo = "column";
	realoadGrafico(tipo);
	
	
	
	
	function atuRelatorio(tpGrafico)
	{
		realoadGrafico(tpGrafico);
	}	
	
	
	
	
	
	
	
	//declara tabela de dados	
	$.fn.dataTableExt.oStdClasses.sPageButton = "btn btn-sm";
	var table = $('#tableInforme').DataTable(
	{
        "paging":         false,
		"bProcessing": true,
		"sPaginationType": 'full_numbers',
		//"aLengthMenu": [[20], [20]],
		"order": [[1, "desc"]],
		"oLanguage": {
			"sProcessing": "... Cargando ... ",		
			"sLengthMenu": "Mostrando _MENU_ items por página.",
			"sZeroRecords": "Ningun registro encontrado.",
			"sInfo": "Mostrando de &nbsp; _START_ &nbsp; hasta &nbsp; _END_ &nbsp; de &nbsp; _TOTAL_ &nbsp; items.",
			"sInfoEmpty": "Mostrando de 0 hasta 0 de 0 registros.",
			"sInfoFiltered": "(de un Total de: &nbsp; _MAX_)",
			"sSearch": "Búscar Todos itens:",
			"oPaginate": {
						  "sFirst":    "Primera",
						  "sPrevious": "Anterior",
						  "sNext":     "Seguiente",
						  "sLast":     "Última"
					}
		},		
		aoColumnDefs:[
			{
			'bSortable' : false
			//'aTargets' : [ 4 ]
			//'aTargets' : [ 0, 6 ]
			}
		],	
		aoColumns:[
		  //{ "bSearchable": false },
		  null,
		  null,
		  null,		  
		  null
		],			
		"bLengthChange": true,
		"dom": '<"top">B<"bottom"><"clear">',
		buttons: [
			{ 
				extend: 'pdfHtml5', 
			 	className: 'btn btn-exp',
				text: 'Exportar PDF',
                exportOptions: {
                    columns: [ 0, 1, 2, 3 ]
                },
				
			},
			{
				extend: 'excelHtml5',
				className: 'btn btn-exp',
				text: 'Exportar Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3]
                },			
			}
		]
	});	
	
	
	
	
	//
	$('#exppdf').click( function() 
	{
		window.print() ; /// aquiiiii Erico		
	});
	
	
	
</script>