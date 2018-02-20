<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');


//Lendo a tabela Com os Dados dos Usuarios
$sql_pen = "
	SELECT
		pendrives.*,
		modelos_pendrive.*
	FROM
		pendrives
	INNER JOIN
		modelos_pendrive
	ON
		pendrives.modelo_id = modelos_pendrive.id_modelo
	ORDER BY
		pendrives.serie
	";	


$query_pen=@mysql_query($sql_pen);
$limitRegistros = mysql_num_rows($query_pen);


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "pendrives" // ingresar la palabra clave de cada modal ?>

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
                    <i class="fa fa-random fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Pendrives') ?>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-6">
                <?php include("inc/buttons.php"); // btns paneles ?>
                <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
                <?php include("inc/modals/modal-confrm-actions.php"); // modal para agregar contenido ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel">
                  <div class="panel-heading">
                    <div class="input-wrap">
                      <!--- dropdown de selects 
                      <div class="btn-group white-btn">
                        <?php //include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                      </div>
                      --->
                      
                      <div class="btn-group white-btn" style="left:2%;">
                        <span id="contRegistros">&nbsp;</span>
                      </div>                        
                      
                      <!-- input formulario de busqueda -->
                      <form id="table-1" class="white-form right" onsubmit="return false;">
                        <div class="form-group">
                          <input type="text" id="searchMaq" name="searchMaq" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="panel-body">
                    <div class="table-responsive">
                    
                    <form id="formDados" >
                        <!--- decalra campos como paramentros de contagem -->
                        <input type="hidden" id="numRegAtual" name="numRegAtual" value="10">
                        <input type="hidden" id="totalReg" name="totalReg" value="<?php echo $limitRegistros ?>">
                        <input type="hidden" id="flagFinal" name="flagFinal" value="0">                      
                    
                      <table id="idTabela" class="table table-striped table-hover">
                        <thead>
                          <tr>
                          	<!---
                            <th class="left-align sort-none">
                              <div class="checkbox">
                                <label><input id="select_all" name="select_all" type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </th>--->
                            <th class="center-align">
                              <a href="#"><?php echo _('Serie') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Marca') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Modelo') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Maquina') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Acciones') ?></a>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                        	<?php
							
							$i = 1;
							while($res_pen=@mysql_fetch_assoc($query_pen)) 
							{
								//consulta numero da maquina
								$sql_maquina = "
									SELECT
										numero
									FROM
										maquinas
									WHERE
										id_maquina = ". $res_pen['id_maquina'];	
								
								$query_maquina=@mysql_query($sql_maquina);								
								$res_maquina=@mysql_fetch_assoc($query_maquina);								
								
								
								if($i<=10)
								{
									echo "<tr id='linha_".$i."' >";
								}
								else
								{
									echo "<tr id='linha_".$i."' style='display:none;'>";
								}

								$i++;
								?>
                            <!---
                            <td class="left-align">
                              <div class="checkbox">
                                <label><input type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </td>
                            --->
                            <td class="center-align"><?php echo $res_pen['serie'] ?></td>
                            <td class="center-align"><?php echo $res_pen['marca'] ?></td>
                            <td class="center-align"><?php echo $res_pen['descricao'] ?></td>
                            <td class="center-align"><?php echo $res_maquina['numero'] ?></td>
                            <td class="center-align">
                              <a id="edit_<?php echo $res_pen['id_pendrive'] ?>" href="#" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>" onClick="alimentaEdit(this);"><?php echo _('Editar') ?></a>
                              <a id="ver_<?php echo $res_pen['id_pendrive'] ?>" href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>" onClick="alimentaView(this);"><?php echo _('Ver') ?></a>
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

    <?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
    <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
  </body>
</html>

<script>

	//
	function alimentaEdit(obj)
	{
		var idPendrive = (obj.id).split("_");

		//consulta dados do objeto para preencher modal.
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_dados_pendrive.php', // Informo a URL que será pesquisada.
			data: 'id='+idPendrive[1],
			success: function(html)
			{

				arrayDados = html.split(",");
				
				serie = arrayDados[0];
				modelo = arrayDados[1];
				numMaq = arrayDados[2];
				idMaq = arrayDados[3];
				idPen = arrayDados[4];
				idModelo = arrayDados[5];


				$('#id_pendrive').attr("value", idPen);
				$('#select_modPen_Pendrive').text(modelo);
				$('#input_modPen_Pendrive').attr("value", idModelo);
				$("#edit_serie_Pendrive").attr("value", serie);
				$('#select_maqPen_Pendrive').text(numMaq);
				$('#input_maqPen_Pendrive').attr("value", idMaq);

			}
		});			
	}	


	//
	function alimentaView(obj)
	{
		var idPen = (obj.id).split("_");
		
		var $iframe = $('#view_pendrive');
		$iframe.attr('src','frames/view-pendrives.php?id='+idPen[1]);  		
		
	}

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
						  "sNext":     "Seguiente",
						  "sLast":     "Última"
					}
		},		
		aoColumnDefs:[
			{
			'bSortable' : false,
			'aTargets' : [ 4 ]
			}
		],	
		aoColumns:[
		  null,
		  null,
		  null,
		  null,
		  { "bSearchable": false }
		],			
		"bLengthChange": true,
		"dom": '<"top">Brti<"bottom"p><"clear">',
		//"dom": 'Brtip', * B para aparecer os botoes
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
                    columns: [ 0, 1, 2, 3 ]
                },			
			}
		]		
	});
	

	
	//declara o campo de busca.
	$('#searchMaq').on( 'keyup', function () {
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


/*
	//
	$('#select_all').change(function() {
		var checkboxes = $(this).closest('form').find(':checkbox');
		if($(this).is(':checked')) {
			checkboxes.prop('checked', true);
		} else {
			checkboxes.prop('checked', false);
		}
	});
	
	//atribui a funcao 
	$('#linha_carregar_mais').click( function() 
	{
		$('#linha_carregar_mais').fadeOut("slow");
		$('#linha_loading').fadeIn("slow");
		var flag = $(flagFinal).val();
		
		if(flag == 0)
		{
			setTimeout(function()
			{
				mostraMaisRes();
			},1500);
		}
	});
	
	//
	$(function () 
	{
		var $win = $(window);
	
		$win.scroll(function () 
		{
			var top = $win.scrollTop();
			var lado = $win.height();
			var tamDoc = $(document).height();
			var barraVl = top + lado;
			

			if ($win.scrollTop() == 0)
			{

				return false;	
						
			}
			else if ($win.height() + $win.scrollTop()== $(document).height()) 
			{
				var flag = $(flagFinal).val();
				if(flag == 0)
				{
					//mostra o carregando
					$('#linha_loading').fadeIn("slow");
					$('#linha_carregar_mais').fadeOut("slow");
					
					//verificar se nao chegou no final
					var flag = $(flagFinal).val();
					if(flag == 0)
					{
						setTimeout(function()
						{
							mostraMaisRes();
						},1500);
					}			
				}
			}
		});
	});
	
	function mostraMaisRes()
	{
		//mostra o loading
		$('#linha_loading').fadeOut("slow");
		
		//declara a qtd de reg atual e o limite
		var regAtuais = $(numRegAtual).val();
		var limitRegistros = $(totalReg).val();
	
	
		//verifica se ja nao carregou todos os registros
		if(eval(regAtuais) >= eval(limitRegistros))
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
			var limit = eval(regAtuais)+10;
			while (i <= limit) 
			{
				$('#linha_'+i).fadeIn("slow");
				i++;
			}
			$("#numRegAtual").attr("value", limit);					
		}
		var flag = $(flagFinal).val();
		
		if(flag == 0)
		{		
			$('#linha_carregar_mais').fadeIn("slow");
		}
	}	
	*/	
	
	//
	$('#confCadastro').click(function (){
		location.reload();
	});		

</script>