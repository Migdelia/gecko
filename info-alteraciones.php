<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//
$dtInicio = $_GET['dI'];
$dtFinal = $_GET['dF'];

if($dtInicio <> '')
{
	$dtInicio = $dtInicio . " 00:00:00";
}

if($dtFinal <> '')
{
	$dtFinal = $dtFinal . " 23:59:59";
}
	

//echo $dtInicio . "<br>";
//echo date("Y-m-d H:i:s", strtotime($dtFinal)) . "<br>";

	

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
                <?php echo _('Informe de Edicion de Maquinas') ?>
                <!--- <a href="#" class="btn" style="margin:0 0 0 10px;"><?php echo _('Ver Todos') ?></a> --->
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
              <?php include("inc/modals/modal-select-periodo-info.php"); // modal para agregar contenido ?>
              <?php include("inc/modals/modal-view-maquinas.php"); // modal para ver detalles contenido ?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <!-- dropdown de selects -->
                    <div class="btn-group white-btn">
                    	<span id="contRegistros">&nbsp;</span>
                        <!---<?php include("inc/dropdown-informe.php"); // btns acciones másivas ?> --->
                    </div>
                    <!-- input formulario de busqueda -->
                    <form id="table-1" class="white-form right" onsubmit="return false;">
                      <div class="form-group">
                        <input id="searchEdit" type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                      </div>
                    </form>
                  </div>
                </div>


				<?php
					
					//
					if($dtInicio == '' and $dtFinal == '')
					{
						//consulta edicoes em maquinas
						$sql_edit = "SELECT
										logins.nome,
										maquinas.numero,
										maquinas.id_maquina,
										interface.numero as num_disp,
										historico_troca_inter.*
									FROM 
										historico_troca_inter
									INNER JOIN
										maquinas
									ON
										historico_troca_inter.id_maq = maquinas.id_maquina
									INNER JOIN
										logins
									ON
										historico_troca_inter.id_login = logins.id_login
									INNER JOIN
										interface
									ON
										historico_troca_inter.id_interface_nova =interface.id_interface
									ORDER BY
										`data` DESC
									LIMIT 
										4000";
					}
					else
					{
							
						$sql_edit = "SELECT
										logins.nome,
										maquinas.numero,
										maquinas.id_maquina,
										interface.numero as num_disp,
										historico_troca_inter.*
									FROM 
										historico_troca_inter
									INNER JOIN
										maquinas
									ON
										historico_troca_inter.id_maq = maquinas.id_maquina
									INNER JOIN
										logins
									ON
										historico_troca_inter.id_login = logins.id_login
									INNER JOIN
										interface
									ON
										historico_troca_inter.id_interface_nova =interface.id_interface
									WHERE 
										`data` >= '".date("Y-m-d H:i:s", strtotime($dtInicio))."'
									AND	
										`data` <= '".date("Y-m-d H:i:s", strtotime($dtFinal))."'";						
							
					}
				

					$query_edit=@mysql_query($sql_edit);
				?>



                <div class="panel-body">
                  <div class="table-responsive">
                    <table id="tableInforme" class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="left-align">
                            <?php echo _('Maquina') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Disp Actual') ?>
                          </th>                           
                          <th class="left-align">
                            <?php echo _('Lectura Ant') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Lectura Nueva') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Fecha') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Usuario') ?>
                          </th>                                                                                                                                 
                        </tr>
                      </thead>
                      <tbody>
                      
                      
						<?php
							//
							while($result_edit=@mysql_fetch_assoc($query_edit))
							{
						?>
                              <tr>
                                <td class="left-align">
                                  <a href="#" id="ver_<?php echo $result_edit['id_maquina'] ?>"  style="color:#095570;" data-toggle="modal" data-target="#view-modal-Maquinas" onClick="alimentaView(this);"><strong><?php echo $result_edit['numero']; ?></strong></a>
                                  <?php //echo $result_edit['numero']; * aqui erico ?>
                                </td>
                                <td class="left-align">
                                  <?php 
								  
								  	//consulta numero da interface antiga
									$sql_IntAnt = "SELECT numero FROM interface WHERE id_interface = " . $result_edit['id_interface_ant'];
									$query_IntAnt=@mysql_query($sql_IntAnt);
									$result_IntAnt=@mysql_fetch_assoc($query_IntAnt);
								  
								  	//echo $result_edit['id_interface_ant'] . " / " . $result_edit['num_disp']; 
									echo $result_IntAnt['numero'] . " / " .  $result_edit['num_disp']; 
								  ?>
                                </td>                            
                                <td class="left-align">
                                	<a href="ver-informe-lectura.php?id=<?php echo $result_edit['id_ultima_leitura'];?>" target="_blank" style="color:#095570;">
                                    	<?php echo "$ " . number_format($result_edit['entrada_ant'],0,"",".") . " / $ " . number_format($result_edit['saida_ant'],0,"","."); ?>
                                    </a>
                                </td>
                                <td class="left-align">
                                    <?php echo "$ " . number_format($result_edit['entrada_nov'],0,"",".") . " / $ " . number_format($result_edit['saida_nov'],0,"","."); ?>
                                </td>
                                <td class="left-align" data-order="<?php echo $result_edit['data']; ?>">
                                    <?php echo date("d-m-Y H:i", strtotime($result_edit['data'])); ?>
                                </td>
                                <td class="left-align">
                                    <?php echo $result_edit['nome']; ?>
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
        </div>
      </div>
    </div>
  </body>
  
  
<script>
	//declara tabela de dados	
	$.fn.dataTableExt.oStdClasses.sPageButton = "btn btn-sm";
	var table = $('#tableInforme').DataTable(
	{
        "paging":         true,
		"bProcessing": true,
		"sPaginationType": 'full_numbers',
		"aLengthMenu": [[20], [20]],
		"order": [[4, "desc"]],
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
						  "sNext":     "Siguiente",
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
		  null,
		  null,
		  null
		],			
		"bLengthChange": true,
		"dom": '<"top">Brti<"bottom"p><"clear">',
		buttons: [
			{ 
				extend: 'pdfHtml5', 
			 	className: 'btn btn-exp',
				text: 'Exportar PDF',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },
				
			},
			{
				extend: 'excelHtml5',
				className: 'btn btn-exp',
				text: 'Exportar Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4, 5 ]
                },			
			}
		]
	});
	

	//declara o campo de busca.
	$('#searchEdit').on( 'keyup', function () {
		table
			.search( this.value )
			.draw();
	} );
	
	
	
	//atribui a funcao do exp PDF do datatable.
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
	}	
	
</script>
