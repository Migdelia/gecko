<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//limita acesso usuario <> master
if($_SESSION['usr_nivel'] == 1)
{
	$whr = " 1 = 1";
}
else
{
	//verificar se é operador, administrador, gerente
	$whr = " fechamento.id_login = " . $_SESSION['id_login'] . " OR leitura.id_login = " . $_SESSION['id_login'] . " OR leitura.id_operador = " . $_SESSION['id_login'] . " OR leitura.id_gerente = " . $_SESSION['id_login'] . " OR leitura.id_admin = " . $_SESSION['id_login'] . "";
}


//verifica se é administrador
if($_SESSION['usr_nivel'] == 9)
{

	//consulta os fechamentos 
	$sql_fechamentos = "SELECT DISTINCT
							fechamento.*,
							logins.nome
						FROM
							leitura
						INNER JOIN `local` ON leitura.id_local = `local`.id_local
						INNER JOIN fechamento ON leitura.id_fechamento = fechamento.id_fechamento
						INNER JOIN	logins ON	leitura.id_login = logins.id_login
						WHERE
							`local`.id_admin = " . $_SESSION['id_login'] . "
						ORDER BY
							id_fechamento DESC";
	
}

else
{
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
						INNER JOIN 
							leitura 
						ON 
							fechamento.id_fechamento = leitura.id_fechamento							
						WHERE
							" . $whr . "
						GROUP BY
							fechamento.id_fechamento							
						ORDER BY
							id_fechamento DESC"
							
							
							
							
							
							
							;
							
		
}
							
							//echo $sql_fechamentos;
						
$query_fechamento=@mysql_query($sql_fechamentos);


?>

<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "cierre" // ingresar la palabra clave de cada modal ?>

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
                  <?php echo _('Cierres') ?>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-6">
                <?php include("inc/buttons-cierre.php"); // btns paneles ?>
                <?php include("inc/modals/modal-add-cierre.php"); // modal para agregar contenido ?>
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
                    	<?php //include("inc/dropdown-informe.php"); // btns acciones másivas ?>
                    </div>
                    <!-- input formulario de busqueda -->
                    <form id="table-1" class="white-form right" onsubmit="return false;">
                      <div class="form-group">
                        <input type="text" id="searchFechamento" name="searchFechamento" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                      </div>
                    </form>
                  </div>
                </div>

                <div class="panel-body">
                  <div class="table-responsive">
                    <table id="tableFechamentos" class="table table-striped table-hover">
                      <thead>
                        <tr>
                          <th class="left-align">
                            <?php echo _('ID Cierre') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Fecha') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Fecha') ?>
                          </th>
                          <th class="left-align">
                            <?php echo _('Responsable') ?>
                          </th> 
                          <th class="left-align">
                            <?php echo _('$') ?>
                          </th>                          
                          <th class="left-align"><?php echo _('Acciones') ?>
                          </th>
                        </tr>
                      </thead>
                      <tbody>
                      
						<?php
							//
							while($res_fechamento=@mysql_fetch_assoc($query_fechamento)) 
							{
						?>
                              <tr>
                                <td class="left-align">
                                    <?php echo $res_fechamento['id_fechamento']; ?>
                                </td>
                                <td class="left-align">
                                    <?php echo date("d-m-Y", strtotime($res_fechamento['data_fechamento'])); ?>
                                </td>
                                <td class="left-align">
                                
                                	<?php
										//consulta leitura desse fechamento
										$sql_leit = "SELECT semana, data_fechamento FROM leitura WHERE id_fechamento =  " . $res_fechamento['id_fechamento'] . " LIMIT 1";
										$query_leit=@mysql_query($sql_leit);
										$res_leit=@mysql_fetch_assoc($query_leit);
										
										echo "Semana: " . $res_leit['semana'] . " / " . date("M-Y", strtotime($res_leit['data_fechamento']));
									?>
                                </td>
                                <td class="left-align">
                                    <?php echo $res_fechamento['nome']; ?>
                                </td>
                                 <td class="left-align">
                                    <?php  
                                    if($res_fechamento['valor_total']<0){
                            	    echo "$ <b style='color:red';>" . number_format($res_fechamento['valor_total'],0,"","."); "</b>";

                                    }else{
                            	      echo "$ " . number_format($res_fechamento['valor_total'],0,"","."); 

                                    }
                                    ?>
                                </td>                            
                                <td class="right-align">
                                  <!--- <a href="#" class="btn btn-default" role="button" style="color: white" data-toggle="modal" data-target="#download-informe-cierre-modal"> <?php echo _('Descargar') ?></a> -->
                                  <a target="_blank" href="ver-informe-cierre.php?id=<?php echo $res_fechamento['id_fechamento']; ?>" class="btn btn-default" role="button" style="color: white" title="Ver"><i class="fa fa-eye"></i> </a>
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
	var table = $('#tableFechamentos').DataTable(
	{
        "paging":         true,
		"bProcessing": true,
		"sPaginationType": 'full_numbers',
		"aLengthMenu": [[20], [20]],
		"order": [[0, "desc"]],
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
			'bSortable' : false,
			'aTargets' : [ 5 ]
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
		  { "bSearchable": false }
		],			
		"bLengthChange": true,
		"dom": '<"top">Brti<"bottom"p><"clear">',
		buttons: [
			{ 
				extend: 'pdfHtml5', 
			 	className: 'btn btn-exp',
				text: 'Exportar PDF',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                },
				
			},
			{
				extend: 'excelHtml5',
				className: 'btn btn-exp',
				text: 'Exportar Excel',
                exportOptions: {
                    columns: [ 0, 1, 2, 3, 4 ]
                },			
			}
		]
	});
	

	//declara o campo de busca.
	$('#searchFechamento').on( 'keyup', function () {
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
		$('#contRegistros').text($('#tableFechamentos_info').text());
		
	}, 500);
	$('#tableFechamentos_info').hide();	
	
</script>
