<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//
$dtInicio = $_GET['dI'];
$dtFinal = $_GET['dF'];

//
if($dtInicio <> '')
{
	$dtInicio = $dtInicio . " 00:00:00";
}
else
{
	$dtInicio = date("d-m-Y h:i:s");
}

//
if($dtFinal <> '')
{
	$dtFinal = $dtFinal . " 23:59:59";
}
else
{
	$dtFinal = date("d-m-Y h:i:s");
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
                <?php echo _('Informe de Creditos Promocionales') ?>
                <!--- <a href="#" class="btn" style="margin:0 0 0 10px;"><?php echo _('Ver Todos') ?></a> --->
              </h3>
            </div>
 
            <div class="col-xs-12 col-lg-6">
              <?php include("inc/buttons-informes.php"); // btns paneles ?> 
              <?php include("inc/modals/modal-select-periodo-promo.php"); // modal para agregar contenido ?>
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

                <div class="panel-body">
                  <div class="table-responsive">
                    <table id="tableInforme" class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="left-align">
                            <?php echo _('Local') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Maquina') ?>
                          </th>                           
                          <th class="left-align">
                            <?php echo _('Valor') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Fecha') ?>
                          </th>                                                                                                                                
                        </tr>
                      </thead>
                      <tbody>
                      
                      
						<?php
							//
							include('conn/connLocalHorus.php');
							
							//
							$sqlCreditosPromo = "SELECT
													creditosPromo.id,
													creditosPromo.valorPromo,
													creditosPromo.dataPromo,
													maquinas.numero
												FROM
													creditosPromo
												INNER JOIN 
													maquinas
												WHERE
													creditosPromo.id = maquinas.id_interface
												AND
													creditosPromo.dataPromo >= '".date("Y-m-d H:i:s", strtotime($dtInicio))."'
												AND
													creditosPromo.dataPromo <= '".date("Y-m-d H:i:s", strtotime($dtFinal))."'";
							$queryCreditosPromo=@mysql_query($sqlCreditosPromo);		
							
							
							//echo $sqlCreditosPromo . "<br>";				
						
							//
							while($rstCreditosPromo=@mysql_fetch_assoc($queryCreditosPromo))
							{
						?>
                              <tr>
                                <td class="left-align">
                                  Horus
                                </td>
                                <td class="left-align">
                                	<?php echo $rstCreditosPromo['numero']; ?>
                                </td>                            
                                <td class="left-align">
                                	<?php echo "$ " . number_format($rstCreditosPromo['valorPromo']*10,0,"","."); ?>
                                </td>
                                <td class="left-align">
                                    <?php echo date("d-m-Y H:i:s", strtotime($rstCreditosPromo['dataPromo'])); ?>
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
		"order": [[3, "desc"]],
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
