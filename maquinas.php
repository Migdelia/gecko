<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');


//limita acesso usuario <> master
if($_SESSION['usr_nivel'] == 1 or $_SESSION['usr_nivel'] == 10)
{
	$whr = "1 = 1";
}
else
{
	$whr = " 1 = 1 AND (vw_maquinas.id_login = " . $_SESSION['id_login'] . " OR vw_maquinas.id_gerente = " . $_SESSION['id_login'] . " OR vw_maquinas.id_admin = " . $_SESSION['id_login'] . ")";
}



//Lendo a tabela Com os Dados dos Usuarios
$sql_maq = "
	SELECT
		*
	FROM
		vw_maquinas
	WHERE
		" . $whr . "
	ORDER BY
		numero
	";	


$query_maq=@mysql_query($sql_maq);
$limitRegistros = mysql_num_rows($query_maq);


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <link href="css/jquery-ui.css" rel="stylesheet">
    
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "maquinas" // ingresar la palabra clave de cada modal ?>

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
                    <i class="fa fa-train fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Máquinas') ?>
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
                      <div class="btn-group white-btn">
                        <span id="contRegistros">&nbsp;</span>
                      </div>                                          
                      <!-- dropdown de selects -->
                      <!---
                      <div class="btn-group white-btn">
                        <?php //include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                      </div>
                      -->
                      
                      <!-- TESTE DE VER TODOS -->
                      <!---
                      <div class="btn-group white-btn" style="left:20%;">
                        <span id="regAtual">10</span> &nbsp; 
                        <span> de </span> &nbsp; 
                        <span id="regTotal"><?php echo $limitRegistros ?></span>  &nbsp;
                        <span> Resultados &nbsp; </span>
                      </div>
                      -->
                      <!---
                      <div class="btn-group" role="group" aria-label="Button group with nested dropdown" style="left:20%;">
						<a id="carregarTodos" class="btn center-align" style="width: 130px; padding-left: 18px"><?php echo _('Cargar Todos') ?></a>
                      </div>
                      -->                      
                      <!--- TESTE DE VER TODOS -->                      
                      
                      
                      <!-- input formulario de busqueda -->
                      <form id="form_busca" class="white-form right" onsubmit="return false;">
                        <div class="form-group">
                          <input type="text" id="searchMaq" name="searchMaq" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="panel-body">
                    <div id="divResultados" class="table-responsive" style="height:35px;">
                    
                    
                      <table id="idTabela" class="table table-striped table-hover">
                        <thead>
                          <tr>
                          	<!---
                            <th class="left-align sort-none">
                              <div class="checkbox">
                                <label><input id="select_all" name="select_all" type="checkbox" ><span class="checkbox-material"></span></label>
                              </div>
                            </th>-->
                            <th class="center-align">
                              <a href="#"><?php echo _('Máquina') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Juego') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Local') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Disp Seguridad') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Responsable') ?></a>
                            </th>
                            <th class="center-align">
                              <a href="#"><?php echo _('Acciones') ?></a>
                            </th>
                          </tr>
                        </thead>
                        <tbody id="listaResultados">
                        	<?php
							

							$i = 1;
							while($res_maq=@mysql_fetch_assoc($query_maq)) 
							{	
							?>

                              <tr id='linha_<?php echo $i ?>'>
                            <!---                                
                                <td class="left-align">
                                  <div class="checkbox">
                                    <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                  </div>
                                </td>-->
                                <td class="center-align"><?php echo $res_maq['numero'] ?></td>
                                <td class="center-align">(<?php echo $res_maq['jogo'] ?>)</td>
                                <td class="center-align"><?php echo $res_maq['nome'] ?></td>
                                <td class="center-align"><?php echo $res_maq['interface'] ?></td>
                                <td class="center-align"><?php echo $res_maq['operador'] ?></td>
                                <td class="center-align">

								<?php
                    
                                    //
                                    if($_SESSION['usr_nivel'] <> 8 and $_SESSION['usr_nivel'] <> 9)
                                    {
                                ?>                                
                                                    
                                
                                  <a href="#" id="ver_<?php echo $res_maq['id_maquina'] ?>" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>" onClick="alimentaEdit(this);" title="Editar"><i class="fa fa-edit"></i></a>
                                  
								<?php
                                    }
                                ?>	                                  
                                  
                                  <a href="#" id="ver_<?php echo $res_maq['id_maquina'] ?>" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>" onClick="alimentaView(this);" title="Ver"><i class="fa fa-eye"></i></a>
                                </td>
                              </tr>
                          
							<?php		
								$i++;				
                                } 
						                    
                            ?>                            

                        </tbody>
                      </table>
                      
                    
                    <form id="formDados" >
                        <!--- decalra campos como paramentros de contagem -->
                        <input type="hidden" id="numRegAtual" name="numRegAtual" value="20">
                        <input type="hidden" id="totalReg" name="totalReg" value="<?php echo $limitRegistros ?>">
                        <input type="hidden" id="flagFinal" name="flagFinal" value="0">                        
                      </form>
                      
                    <!---
                    <table id="tabelaLoading" class="table table-striped table-hover">
                        
                        <tr id="linha_carregar_mais" style="cursor:pointer;">
                          <td>&nbsp; </td>
                          <td>&nbsp; </td>
                          <td class="center-align">
                            <div class="col-xs-12">
                              <?php echo ('Carregar mais ...') ?>
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
                              <?php echo (' Final ') ?>
                            </div>
                          </td>
                          <td>&nbsp; </td>
                          <td>&nbsp; </td>
                        </tr>                        
                    </table>
                    --->                       
                      
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


<script src="js/jquery-ui.js"></script>
<script>

	//
	function alimentaView(obj)
	{
		var idMaq = (obj.id).split("_");
		
		var $iframe = $('#view_maq');
		$iframe.attr('src','frames/view-maquina.php?id='+idMaq[1]);  		
		
	}
	
	//
	function alimentaEdit(obj)
	{
		var idMaq = (obj.id).split("_");
		idMaq = idMaq[1];
		
		jQuery(document).ready( function( $ ) {

			$.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'functions/consulta_dados_maquina.php', // Informo a URL que será pesquisada.
				data: 'id='+idMaq,
				success: function(html)
				{
					arrayDados = html.split(",");
					
					var numero = arrayDados[0];
					var codigo = arrayDados[1];
					var jogo = arrayDados[2];
					var nomeLocal = arrayDados[3];
					var status = arrayDados[4];
					var dispositivo = arrayDados[5];
					var ordem = arrayDados[6];
					var entrada = arrayDados[7];
					var saida = arrayDados[8];
					var parceiro = arrayDados[9];
					var pct_socio = arrayDados[10];
					var pct_maquina = arrayDados[11];
					var maq_socio = arrayDados[12];
					var gabinete = arrayDados[15];
					var placaMae = arrayDados[16];
					var bilheteiro = arrayDados[17];
					var pendrive = arrayDados[18];
					var monitor = arrayDados[19];
					var todasChapas = arrayDados[13];		
					var chapa = arrayDados[14];	
					
					var obs = arrayDados[20];	




	/*


alert("Nome Local: " + nomeLocal);
alert("Disp: " + dispositivo);

					alert("Numero: " + numero);
					alert("Codigo: " + codigo);
					alert("Jogo: " + jogo);
					alert("Nome Local: " + nomeLocal)
					alert("Status: " + status);
					alert("Disp: " + dispositivo);
					alert("Ordem: " + ordem);
					alert("Entrada: " + entrada);
					alert("Saida: " + saida);
					alert("Parceiro: " + parceiro);
					alert("pct Socio: " + pct_socio);
					alert("Pct Maq: " + pct_maquina);
					alert("Maq Soc: " + maq_socio);
					alert("Gab: " + gabinete);
					alert("Placa Mae: " + placaMae);
					alert("Bilheteiro: " + bilheteiro);
					alert("Pendrive: " + pendrive);
					alert("Monitor: " + monitor);
					alert("chapas: " + todasChapas);		
					alert("chapa: " + chapa);	

					*/



					//declara a lista de chapas
					//desmarca todas as chapas
					if(todasChapas !== '')
					{					
						arrayTodasChapas = todasChapas.split("-");
						qtdTodasChapas = ((arrayTodasChapas.length)-1);
						var y = 0;
					
						while (y < qtdTodasChapas) 
						{
							//marca check de chapas
							$("#check_chapa_"+arrayTodasChapas[y]).prop("checked", "");
							y++;
						}
					}
					
					
					
					//marca as dessa maquina
					if(chapa !== '')
					{
						arrayChapas = chapa.split("-");
						qtdChapas = ((arrayChapas.length)-1);
						var z = 0;
						while (z < qtdChapas) 
						{
							//marca check de chapas
							$("#check_chapa_"+arrayChapas[z]).prop("checked", "checked");
							z++;
						}
					}


					var nomeObj = "Maquina";

					
					$("#id_maquina").attr("value", idMaq);
					
					
					$("#input_num_"+nomeObj).attr("value", numero);
					$("#input_cod_"+nomeObj).attr("value", codigo);
					$("#input_jogo_"+nomeObj).attr("value", jogo);

					//atribui o nome do local ao campo
					$('#select2-input_local_'+nomeObj+'-container').text(nomeLocal);
					$("#input_local_"+nomeObj+" option[value='"+nomeLocal+"']").attr('selected', 'selected');
					$("#hd_input_local_"+nomeObj).attr("value", nomeLocal);
					
					//
					$("#select_status_"+nomeObj).text(status);
					$("#input_status_"+nomeObj).attr("value", status);

					
					//atribui o numero do disp ao campo
					$('#select2-input_disp_'+nomeObj+'-container').text(dispositivo);
					$("#input_disp_"+nomeObj+" option[value='"+dispositivo+"']").attr('selected', 'selected');
					$("#hd_input_disp_"+nomeObj).attr("value", dispositivo);				
					
					
					$("#input_ordem_"+nomeObj).attr("value", ordem);
					$("#input_entrada_"+nomeObj).attr("value", entrada);
					$("#input_saida_"+nomeObj).attr("value", saida);
					$("#check_maquina_socio"+nomeObj).attr("value", parceiro);
					$("#input_pctSocio_"+nomeObj).attr("value", pct_socio);
					$("#input_pctEspecial_"+nomeObj).attr("value", pct_maquina);
					
					
					//atribui o nome do local ao campo
					$('#select2-input_gab_'+nomeObj+'-container').text(gabinete);
					$("#input_gab_"+nomeObj+" option[value='"+gabinete+"']").attr('selected', 'selected');	
					
					
					//atribui o nome da placa mae
					if(placaMae == '' || placaMae == undefined)
					{
						$('#select2-input_placa_'+nomeObj+'-container').text('Ninguno');
						$("#input_placa_"+nomeObj+" option[value='Ninguno']").attr('selected', 'selected');						
					}
					else
					{
						$('#select2-input_placa_'+nomeObj+'-container').text(placaMae);
						$("#input_placa_"+nomeObj+" option[value='"+placaMae+"']").attr('selected', 'selected');						
					}

					
					//atribui o serie do bilheteiro
					if(bilheteiro == '' || bilheteiro == undefined)
					{
						$('#select2-input_bil_'+nomeObj+'-container').text('Ninguno');
						$("#input_bil_"+nomeObj+" option[value='Ninguno']").attr('selected', 'selected');					
					}
					else
					{
						$('#select2-input_bil_'+nomeObj+'-container').text(bilheteiro);
						$("#input_bil_"+nomeObj+" option[value='"+bilheteiro+"']").attr('selected', 'selected');						
					}					
	
					
					//atribui o serie do pendrive
					if(pendrive == '' || pendrive == undefined)
					{
						$('#select2-input_pen_'+nomeObj+'-container').text('Ninguno');
						$("#input_pen_"+nomeObj+" option[value='Ninguno']").attr('selected', 'selected');						
					}
					else
					{
						$('#select2-input_pen_'+nomeObj+'-container').text(pendrive);
						$("#input_pen_"+nomeObj+" option[value='"+pendrive+"']").attr('selected', 'selected');						
					}						
					

					
					//atribui o serie do monitor
					if(monitor == '' || monitor == undefined)
					{
						$('#select2-input_mon_'+nomeObj+'-container').text('Ninguno');
						$("#input_mon_"+nomeObj+" option[value='Ninguno']").attr('selected', 'selected');					
					}
					else
					{
						$('#select2-input_mon_'+nomeObj+'-container').text(monitor);
						$("#input_mon_"+nomeObj+" option[value='"+monitor+"']").attr('selected', 'selected');						
					}						
																									
					


					$("#select_chapa_"+nomeObj).text(chapa);					
					$("#input_chapa_"+nomeObj).attr("value", chapa);
					
									
					
					//checkbox
					if(parceiro == 1)
					{
						$("#check_parce").prop("checked", "checked");
					}
					else
					{
						$("#check_parce").prop("checked", "");
					}
					
					
					//
					if(maq_socio == 1)
					{
						$("#check_maquina_socio").prop("checked", "checked");
					}
					else
					{
						$("#check_maquina_socio").prop("checked", "");	
					}					



					$("#input_obs_"+nomeObj).attr("value", obs);
					
					/*					
					var id_local = obj.id;
					var rut = arrayDados[1];
					var nome = arrayDados[2];
					var razao_social = arrayDados[3];	
					var inclusao = arrayDados[4];
					var ordem = arrayDados[5];
					var excluido = arrayDados[6];
					var endereco = arrayDados[7];	
					var responsavel = arrayDados[8];
					var contato = arrayDados[9];	
					var id_login = arrayDados[10];
					var percentual = arrayDados[11];
					var id_regiao = arrayDados[12];
					var id_tp_local = arrayDados[13];	
					var id_gerente = arrayDados[14];
					var pct_operador = arrayDados[15];
					var pct_gerente = arrayDados[16];																						
					

					var nomeObj = "Local";
	
					$("#edit_id_"+nomeObj).attr("value", id_local);
					$("#id_"+nomeObj).attr("value", id_local);
					$("#edit_rut_"+nomeObj).attr("value", rut);
					$("#edit_id_"+nomeObj).attr("value", id_local);
					$("#edit_rut_"+nomeObj).attr("value", rut);
					$("#edit_nome_"+nomeObj).attr("value", nome);
					$("#edit_rs_"+nomeObj).attr("value", razao_social);
					$("#edit_incluido_"+nomeObj).attr("value", inclusao);
					$("#edit_orden_"+nomeObj).attr("value", ordem);
					$("#edit_status_"+nomeObj).attr("value", excluido);
					$("#edit_end_"+nomeObj).attr("value", endereco);
					$("#edit_resp_"+nomeObj).attr("value", responsavel);
					$("#edit_cont_"+nomeObj).attr("value", contato);
					$("#edit_ope_"+nomeObj).attr("value", id_login);
					$("#edit_pct_"+nomeObj).attr("value", percentual);
					$("#edit_cidade_"+nomeObj).attr("value", id_regiao);
					$("#edit_tipo_"+nomeObj).attr("value", id_tp_local);
					$("#edit_ger_"+nomeObj).attr("value", id_gerente);
					$("#edit_comOpe_"+nomeObj).attr("value", pct_operador);
					$("#edit_comGer_"+nomeObj).attr("value", pct_gerente);
					*/
				}
			});	
		});	
		
	}	

	//declara tabela de dados	
	$.fn.dataTableExt.oStdClasses.sPageButton = "btn btn-sm";
	var table = $('#idTabela').DataTable(
	{
        "paging": true,
		"bProcessing": true,
		"sPaginationType": 'full_numbers',
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
	});
	
	//mostra o contador de registros exibidos
	setInterval(function()
	{
		$('#contRegistros').text($('#idTabela_info').text());
		$('#divResultados').height('auto');
		
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
			},500);
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
						},500);
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

			//soma os contadores de registro 
			var regTotais = $(regTotal).text();

			//
			if(limit >= regTotais)
			{
				$('#regAtual').text(regTotais);
			}
			else
			{
				$('#regAtual').text(limit);
			}
			//soma os contadores de registro
							
		}
		var flag = $(flagFinal).val();
		
		if(flag == 0)
		{		
			$('#linha_carregar_mais').fadeIn("slow");
		}
	}		
	
	
	//mostrar todos resultados.
	$('#carregarTodos').click( function() 
	{
		mostrarTodos();
	});
	
	//
	$('#searchMaq').keyup( function() 
	{	
		//verificar se nao foram mostrados todos os resultados
		//declara a qtd de reg atual e o limite
		var regAtuais = $(numRegAtual).val();
		var limitRegistros = $(totalReg).val();//mudar
	
	
		//verifica se ja nao carregou todos os registros
		if(regAtuais < limitRegistros)
		{
			mostrarTodos();
		}		
	});
	
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



	// Input Autocompletable LOCAL
	var resLocais = $('#listaLocais').val();
	arrayLocais = resLocais.split(",");
		
	//
	var listaLocais = new Array();
	//
	var i = 0;
	var limit = ((arrayLocais.length)-1);
	while (i <= limit) 
	{
		listaLocais[i] = "" + arrayLocais[i] + "";
		i++;
	}	
	//
	$("#inputAdd_local_Maquina").autocomplete({
	   source : listaLocais,
		appendTo : $('#add-modal-Maquinas'),
		minLength: 1
	});
	
	
	// Input Autocompletable DISP
	var resDisp = $('#listaDisp').val();
	arrayDisp = resDisp.split(",");
		
	//
	var listaDisp = new Array();
	//
	var i = 0;
	var limit = ((arrayDisp.length)-1);
	while (i <= limit) 
	{
		listaDisp[i] = "" + arrayDisp[i] + "";
		i++;
	}	
	//
	$("#inputAdd_disp_Maquina").autocomplete({
	   source : listaDisp,
		appendTo : $('#add-modal-Maquinas'),
		minLength: 1
	});	*/

	//
	$('#confCadastro').click(function (){
		location.reload();
	});	

</script>