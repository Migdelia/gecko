<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');


//Lendo a tabela Com os Dados dos Usuarios

//verifica se eh master
if($_SESSION['usr_nivel'] == 1)
{
	$sql_usr = "
		SELECT
			vw_usuarios.id_login,
			vw_usuarios.Nome,
			vw_usuarios.Nivel,
			vw_usuarios.excluido
		FROM
			vw_usuarios
		ORDER BY
			vw_usuarios.Nome
		";	
}
else
{
	$sql_usr = "
		SELECT
			vw_usuarios.id_login,
			vw_usuarios.Nome,
			vw_usuarios.Nivel,
			vw_usuarios.excluido
		FROM
			vw_usuarios
		WHERE
			vw_usuarios.id_nivel <> 1
		ORDER BY
			vw_usuarios.Nome
		";		
}



$query_usr=@mysql_query($sql_usr);
$limitRegistros = mysql_num_rows($query_usr);


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "usuarios" // ingresar la palabra clave de cada modal ?>

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
                    <i class="fa fa-users fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Usuarios') ?>
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
                        <?php //include("inc/dropdown-actions-usuarios.php"); // btns acciones másivas ?>
                      </div>-->
                      
                      
                      <!--- info cont -->
                      <div class="btn-group white-btn" style="left:2%;">
                        
                        <span id="contRegistros">&nbsp;</span>
                        
                      </div>                   
                      <!--- info cont-->                        
                      
                      
                      
                      <!-- input formulario de busqueda -->
                      <form id="table-1" class="white-form right" onsubmit="return false;">
                        <div class="form-group">
                          <input id="searchUsuario" name="searchUsuario" type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="panel-body">
                  	<form id="formDados" >
                        <!--- decalra campos como paramentros de contagem -->
                        <input type="hidden" id="numRegAtual" name="numRegAtual" value="10">
                        <input type="hidden" id="totalReg" name="totalReg" value="<?php echo $limitRegistros ?>">
                        <input type="hidden" id="flagFinal" name="flagFinal" value="0">
                                            
                    
                    <div id="conteudo" class="table-responsive" style="overflow-x:visible;">
                      <table id="idTabela" class="table table-striped table-hover">
                        <thead>
                          <tr>
                          	<!--- 
                            <th class="left-align sort-none">
                              <div class="checkbox">
                                <label><input id="select_all" type="checkbox"><span class="checkbox-material"></span></label>
                              </div>
                            </th>
                            -->
                            <th class="left-align">
                              <a><?php echo _('Nombre') ?></a>
                            </th>
                            <th class="left-align">
                              <a><?php echo _('Nivel') ?></a>
                            </th>
                            <th class="left-align">
                              <a><?php echo _('Estatus') ?></a>
                            </th>                                               
                            <th class="right-align" colspan="2">
                              <a style="padding-right:10%;"><?php echo _('Acciones') ?></a>
                            </th>
                          </tr>
                        </thead>
                        <tbody>
                        

                            
                        	<?php
							
								//$i = 1;
								while($res_usr=@mysql_fetch_assoc($query_usr)) 
								{
									/*
									if($i<=10)
									{
										echo "<tr id='linha_".$i."' >";
									}
									else
									{
										echo "<tr id='linha_".$i."' style='display:none;'>";
									}*/
									
									echo "<tr id='linha_".$i."' >";

									
									?>
                                      <!---
                                        <td class="left-align">
                                          <div class="checkbox">
                                            <label>
                                            <input id="check_<?php //echo $res_usr['id_login'] ?>" type="checkbox" value="<?php //echo $res_usr['Nome'] ?>">
                                            <span class="checkbox-material"></span>
                                            </label>
                                          </div>
                                        </td>-->
                                        <td class="left-align"><?php echo $res_usr['Nome'] ?></td>
                                        <td class="left-align"><?php echo $res_usr['Nivel'] ?></td>
                                        <td class="left-align">
										<?php 
											if($res_usr['excluido'] == "N")
											{
												echo "Ativo";
											}
											else
											{
												echo "Inativo";	
											} ?>
                                        </td>                                      
                                        <td class="right-align" colspan="2">
                                          <a <?php echo "id=edit_'".$res_usr['id_login']."'" ?> class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>" onClick="modalEdit(this);" title="Editar">
										  	<i class="fa fa-edit"></i>
                                           </a>
                                          <a <?php echo "id=ver_'".$res_usr['id_login']."'" ?> class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>" onClick="modalVer(this);" title="Ver">
										  	<i class="fa fa-eye"></i>
                                           </a>
                                        </td>
                                      </tr>                                    
									<?php						
								}                        
							?>                          
                        </tbody>
                      </table>
                      
                      <!---
                      <table id="tabelaLoading" class="table table-striped table-hover">
                            
                            <tr id="linha_carregar_mais" style="cursor:pointer;">
                              <td>&nbsp; </td>
                              <td>&nbsp; </td>
                              <td class="center-align">
                                <div class="col-xs-12">
                                  <?php //echo ('Carregar mais ...') ?>
                                </div>
                              </td>
                              <td>&nbsp; </td>
                              <td>&nbsp; </td>
                            </tr>                            
                                              
                            <tr id="linha_loading" style="display:none;">
                              <td class="center-align" colspan="7">
                                <div class="col-xs-12">
                                  <i class="fa fa-spinner fa-spin fa-2x"></i>
                                </div>

                              </td>
                            </tr>
                            <tr id="linha_fim" style="display:none;">
                              <td>&nbsp; </td>
                              <td>&nbsp; </td>
                              <td class="center-align">
                                <div class="col-xs-12">
                                  <?php //echo (' Final ') ?>
                                </div>
                              </td>
                              <td>&nbsp; </td>
                              <td>&nbsp; </td>
                            </tr>                        
                      </table>
                      --->
                      
                    </div>
                    </form>
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

<script type="text/javascript">

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
			//'aTargets' : [ 0, 4 ]
			}
		],	
		aoColumns:[
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
                    columns: [ 0, 1, 2 ]
                },
				
			},
			{
				extend: 'excelHtml5',
				className: 'btn btn-exp',
				text: 'Exportar Excel',
                exportOptions: {
                    columns: [ 0, 1, 2]
                },			
			}
		]		
	});
	

	
	//declara o campo de busca.
	$('#searchUsuario').on( 'keyup', function () {
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


	//
	function modalEdit(obj)
	{
		var idUsu = obj.id.split("_");
		idUsu = idUsu[1];		
		
		jQuery(document).ready( function( $ ) {
			//consulta dados do objeto para preencher modal.
			$.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'functions/consulta_dados_usuario.php', // Informo a URL que será pesquisada.
				data: 'id='+idUsu,
				success: function(html)
				{
					arrayDados = html.split(",");
					
					login = arrayDados[0];
					nome = arrayDados[1];
					email = arrayDados[2];
					status = arrayDados[3];
					nivel = arrayDados[4];
					senha = arrayDados[5];
					
					
					$("#input_id_Usuario").attr("value", login);
					$("#input_name_Usuario").attr("value", nome);
					$("#input_mail_Usuario").attr("value", email);
					$('#input_exclu_Usuario').text(status);
					$('#input_nivel_Usuario').text(nivel);
					$("#input_pass_Usuario").attr("value", senha);
					
				}
			});								

			
		});
	}
	
	
	//
	function modalVer(obj)
	{
		var idUsu = obj.id.split("_");
		idUsu = idUsu[1];
		
		jQuery(document).ready( function( $ ) {
			//consulta dados do objeto para preencher modal.
			$.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'functions/consulta_dados_usuario.php', // Informo a URL que será pesquisada.
				data: 'id='+idUsu,
				success: function(html)
				{
					arrayDados = html.split(",");
					
					login = arrayDados[0];
					nome = arrayDados[1];
					email = arrayDados[2];
					status = arrayDados[3];
					nivel = arrayDados[4];
					//senha = arrayDados[5];
					usuario = arrayDados[6];
					dataAdd = arrayDados[7];


					$('#idLogin').text(login);
					$('#usuNome').text(nome);
					$('#usuEmail').text(email);
					$('#usuStatus').text(status);
					$('#usuNivel').text(nivel);
					$('#usuInclusao').text(dataAdd);
					$('#usuario').text(usuario);															

					
				}
			});								

			
		});
	}	
	
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
	
	//declara funcao massiva
	function acaoMassiva(obj)
	{
		//pegar qual acao massiva esta sendo selecionada.
		var acao = obj.id;
		
		//ativa a troca de nivel
		if(acao == "Desativar")
		{
			$('#div_combo_nivel').fadeOut("slow");
		}
		else
		{
			$('#div_combo_nivel').fadeIn("slow");
		}

		var contAcao = "";
		$("input:checkbox:checked").each(function(){
			//cada elemento seleccionado
			contAcao = contAcao + $(this).val() + "</br>";
			
		});

		//alimenta a msg de confirmacao.
		$('#tpAcao').html(acao);	
		$('#cont_acao').html(contAcao);	
		
	}

	//
	function atribuiNivel(obj)
	{
		$('#input_nivel_Usuario').text(obj.text);
	}
	
	//
	function atribuiNivelMassivo(obj)
	{
		$('#input_nivel_massivo_Usuario').text(obj.text);
	}	
	
	//
	$('#confAcao').click( function() 
	{
		//verifica que tipo de acao massiva vai executar * continuar aqui * erico
		var acaoTipo = $(tpAcao).text();	
		
		//
		if(acaoTipo == "Desativar")
		{
			listIds = "";
			
			//
			$("input:checkbox:checked").each(function(){
				//cada elemento seleccionado
				var idUsu = this.id.split("_");
				listIds = listIds + idUsu[1] + ",";	
			});
			listIds = listIds.substring(0,listIds.length - 1);				
			
			//Chama tela para alteracao massiva *alert(listIds);
			$.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'functions/acao_massiva.php', // Informo a URL que será pesquisada.
				data: 'ids='+listIds+'&tpAcao='+acaoTipo,
				success: function(html)
				{
					if(html == 1)
					{
						location.reload();
					}
					else
					{
						alert("Erro!");	
					}								
				}
			});					
		}
		else
		{
			listIds = "";
			
			//pegar nivel novo
			var novoNivel = $(input_nivel_massivo_Usuario).text();
			
			//
			if(novoNivel == "Nivel de Usuario")
			{
				return false;
			}
			
			//
			$("input:checkbox:checked").each(function(){
				//cada elemento seleccionado
				var idUsu = this.id.split("_");
				listIds = listIds + idUsu[1] + ",";	
			});
			listIds = listIds.substring(0,listIds.length - 1);		
			
			//Chama tela para alteracao massiva *alert(listIds);
			$.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'functions/acao_massiva.php', // Informo a URL que será pesquisada.
				data: 'ids='+listIds+'&nivel='+novoNivel+'&tpAcao='+acaoTipo,
				success: function(html)
				{
					if(html == 1)
					{
						location.reload();
					}
					else
					{
						alert("Erro!");	
					}											
				}
			});			
		}
	});	

</script>