<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/connDongle.php');
//include('functions/validaLogin.php');


//Lendo a tabela de dongles
$sql_dongle = "
	SELECT
		MachineId,
		GameId,
		period,
		expirationDate,
		lastUpdate,
		userId
	FROM
		StreetDongle
	ORDER BY
		MachineId
	";		


	
$query_dongle=@mysql_query($sql_dongle);
$limitRegistros = mysql_num_rows($query_dongle);

include('conn/conn.php');
include('functions/validaLogin.php');

?>
<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "dispositivos" // ingresar la palabra clave de cada modal ?>

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
                    <i class="fa fa-user-secret fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Dongles') ?>
                </h3>
              </div>
              
             
              
              
              <div class="col-xs-12 col-lg-6">
                <?php include("inc/buttons.php"); // btns paneles ?>
                <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel">
                  <div class="panel-heading">
                    <div class="input-wrap">
                      <!-- dropdown de selects
                      <div class="btn-group white-btn">
                        <?php //include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                      </div>
                       -->
                      <!-- input formulario de busqueda -->
                      
                      
                      <div class="btn-group white-btn" style="left:2%;">
                        
                        <span id="contRegistros">&nbsp;</span>
                        
                      </div>                       
                      
                      
                      <!--- TESTE DE VER TODOS 
                      <div class="btn-group white-btn" style="left:20%;">
                        <span id="regAtual">10</span> &nbsp; 
                        <span> de </span> &nbsp; 
                        <span id="regTotal"><?php echo $limitRegistros ?></span>  &nbsp;
                        <span> Resultados &nbsp; </span>
                      </div>
                      <div class="btn-group" role="group" aria-label="Button group with nested dropdown" style="left:20%;">
						<a id="carregarTodos" class="btn center-align" style="width: 130px; padding-left: 18px"><?php echo _('Cargar Todos') ?></a>
                      </div>                      
                      TESTE DE VER TODOS -->                      
                      
                      
                      <form id="table-1" class="white-form right" onsubmit="return false;">
                        <div class="form-group">
                          <input type="text" id="searchDispositivo" name="searchDispositivo" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                        </div>
                        
                        <input type="hidden" id="numRegAtual" name="numRegAtual" value="10">
                        <input type="hidden" id="totalReg" name="totalReg" value="<?php echo $limitRegistros ?>">
                        <input type="hidden" id="flagFinal" name="flagFinal" value="0">                        
                        
                      </form>
                    </div>
                  </div>
                  <div class="panel-body">
                    <div class="col-xs-12">
                      <div class="table-responsive">
                      	<form id="formDados" >
                        <table id="idTabela" class="table table-striped table-hover">
                          <thead>
                            <tr>
                            <!---
                              <th class="left-align sort-none">
                                <div class="checkbox">
                                  <label><input id="select_all" type="checkbox"><span class="checkbox-material"></span></label>
                                </div>
                              </th>-->
                              <th class="center-align sort-asc">
                                <a ><?php echo _('Id Dongle') ?></a>
                              </th>
                              <th class="center-align">
                                <a ><?php echo _('Juego') ?></a>
                              </th>
                              <th class="center-align">
                                <a ><?php echo _('Periodo') ?></a>
                              </th>
                              <th class="center-align">
                                <a ><?php echo _('Fecha de Expiración') ?></a>
                              </th>
                              <th class="center-align">
                                <a ><?php echo _('Máquina') ?></a>
                              </th>                               
                              <th class="center-align">
                                <a ><?php echo _('Usuario') ?></a>
                              </th>                              
                              <th class="center-align">
                                <a ><?php echo _('Acciones') ?></a>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                          
                        	<?php
								while($res_dongle=@mysql_fetch_assoc($query_dongle)) 
								{

									echo "<tr id='linha_".$i."' >";
						
									?>
                                      <!---
                                        <td class="left-align">
                                          <div class="checkbox">
                                            <label><input type="checkbox" id="check_<?php echo $res_dongle['MachineId'] ?>"><span class="checkbox-material"></span></label>
                                          </div>
                                        </td>-->
                                        <td class="center-align"><?php echo $res_dongle['MachineId'] ?></td>
                                        
                                        <?php
										
											//consulta os dados da maquina
											$sql_dados_maquina = "
												SELECT
													numero,
													jogo,
													operador
												FROM
													`vw_maquinas`
												WHERE
													`interface` = '".$res_dongle['MachineId']."'
												";
								
								
											$query_dados_maquina=@mysql_query($sql_dados_maquina);
											$res_dados_maquina=@mysql_fetch_assoc($query_dados_maquina);
											
																			
											
										
										?>
                                        
                                        
                                        <td class="center-align"><?php echo $res_dados_maquina['jogo'] ?></td>
                                        <td class="center-align"><?php echo $res_dongle['period'] ?></td>
                                        
                                        <?php
											//verifica se inicializou a dongle
											if($res_dongle['expirationDate'] == 0)
											{
												$dataExp = "Não inicializada";
											}
											else
											{
												$dataExp = date("d-m-Y", strtotime($res_dongle['expirationDate']));
											}
										?>
                                        
                                        <td class="center-align"><?php echo $dataExp ?></td>
                                        <td class="center-align"><?php echo $res_dados_maquina['numero'] ?></td>
                                        <td class="center-align"><?php echo $res_dados_maquina['operador'] ?></td>
                                        <td class="center-align">
                                          <a <?php echo "id='".$res_dongle['MachineId']."'" ?> href="#" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>" onClick="alimentaModal(this);" title="Editar"><i class="fa fa-edit"></i></a>
                                          <a href="#" id="ver_<?php echo $res_dongle['MachineId'] ?>" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>" onClick="alimentaView(this);" title="Ver"><i class="fa fa-eye"></i></a>
                                        </td>
                                      </tr>                                    
									<?php						
								}                        
							?>                           
                          
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
    </div>

    <?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
    <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
  </body>
</html>

<script type="text/javascript" charset="utf-8">
	//declara tabela de dados	
	$.fn.dataTableExt.oStdClasses.sPageButton = "btn btn-sm";	
	var table = $('#idTabela').DataTable(
	{
        "paging": true,
		"aLengthMenu": [[20], [20]],
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
			'aTargets' : [ 6 ]
			}
		],
		aoColumns:[
		  null,
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
	$('#searchDispositivo').on( 'keyup', function () {
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
	} );
	
	//mostra o contador de registros exibidos
	setInterval(function()
	{
		$('#contRegistros').text($('#idTabela_info').text());
	}, 500);
	$('#idTabela_info').hide();	
	

	function alimentaModal(obj)
	{
		jQuery(document).ready( function( $ ) {
			//consulta dados do objeto para preencher modal.
			$.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'functions/consulta_dados_dispositivo.php', // Informo a URL que será pesquisada.
				data: 'id='+obj.id,
				success: function(html)
				{
					arrayDados = html.split(",");
					
					id = arrayDados[0];
					game = arrayDados[1];
					expDate = arrayDados[2];
					lastUp = arrayDados[3];
					period = arrayDados[4];
					user = arrayDados[5];

					
					$("#input_id_Dispositivo").attr("value", id);
					$("#input_game_Dispositivo").attr("value", game);
					$("#input_expdate_Dispositivo").attr("value", expDate);
					$("#input_ultact_Dispositivo").attr("value", lastUp);
					$("#input_periodo_Dispositivo").attr("value", period);
					$('#input_user_Dispositivo').text(user);
				}
			});								

			
		});
	}
	
	//
	function alimentaView(obj)
	{
		var idDisp = (obj.id).split("_");

		
		var $iframe = $('#view_disp');
		$iframe.attr('src','frames/view-dispositivo.php?id='+idDisp[1]);  		
		
	}
	
	/*
	//mostrar todos resultados.
	$('#carregarTodos').click( function() 
	{
		mostrarTodos();
	});*/
	
	//
	$('#searchDispositivo').keyup( function() 
	{	
		//verificar se nao foram mostrados todos os resultados
		//declara a qtd de reg atual e o limite *atualizar
		var regAtuais = $(numRegAtual).val();
		var limitRegistros = $(totalReg).val();//mudar
	
	
		//verifica se ja nao carregou todos os registros
		if(regAtuais < limitRegistros)
		{
			mostrarTodos();
		}
	});
	
	/*
	//function mostra tudo
	function mostrarTodos()
	{
		//mostra o loading
		$('#linha_loading').fadeOut("slow");
		
		//declara a qtd de reg atual e o limite
		var regAtuais = $(numRegAtual).val();
		var limitRegistros = $(totalReg).val();//mudar
	
	
		//verifica se ja nao carregou todos os registros
		if(regAtuais >= limitRegistros)
		{
			//
			$('#linha_fim').fadeIn("slow");
			$("#flagFinal").attr("value", 1);	
			$('#linha_carregar_mais').fadeOut("slow");	
		}
		else
		{
			//
			var i = eval(regAtuais)+1;
			var limit = eval(limitRegistros) ;
			while (i <= limit) 
			{
				$('#linha_'+i).fadeIn("slow");
				i++;
			}
			$("#numRegAtual").attr("value", limit);	
			
			//soma contador de registros atuais *atualizar
			$('#regAtual').text(limit);								
		}
		var flag = $(flagFinal).val();
		
		if(flag == 0)
		{		
			$('#linha_carregar_mais').fadeIn("slow");
		}		
	}	
		*/	
	
</script>
	
