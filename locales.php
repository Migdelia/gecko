<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');


//$_SESSION['usr_nivel']
//echo $_SESSION['usr_nivel'];

//limita acesso usuario <> master
if($_SESSION['usr_nivel'] == 1 or $_SESSION['usr_nivel'] == 10)
{
	$whr = " AND 1 = 1";
}
else
{
	$whr = " AND (`local`.id_login = " . $_SESSION['id_login'] . " OR `local`.id_gerente = " . $_SESSION['id_login'] . " OR `local`.id_admin = " . $_SESSION['id_login'] . ")";
}
//Lendo a tabela Com os Dados dos locais
$sql_local = "
	SELECT
		`local`.id_local,
		`local`.nome,
		logins.nome as operador,
		`local`.id_gerente,
		tipo_local.tp_local,
		`local`.endereco,
		regiao.nome_cidade
	FROM
		`local`
		INNER JOIN
			logins
		ON
			`local`.id_login = logins.id_login
		INNER JOIN
			tipo_local
		ON
			`local`.id_tp_local = tipo_local.id_tp_local
		INNER JOIN
			regiao
		ON
		`local`.id_regiao = regiao.id_cidade
	WHERE
		`local`.excluido = 'N'
	" . $whr . "
	ORDER BY
		nome
	";	
	


$query_local=@mysql_query($sql_local);
$limitRegistros = mysql_num_rows($query_local);


?>
<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "locales" // ingresar la palabra clave de cada modal ?>

  <div class="container-fluid innpage-<?php echo $filenameID; ?>">
    <div class="row">
      <?php include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
    </div>
    <div class="row">
      <?php include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
      <div class="inner-content col-xs-12 col-sm-9">
        <div class="lectura">
          <div class="row">
            <div class="col-xs-12 col-lg-6">
              <h3 class="main-title">
                <span class="fa-stack fa-md">
                  <i class="fa fa-circle fa-stack-2x"></i>
                  <i class="fa fa-building-o fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo _('Locales') ?>
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
                    <!-- dropdown de selects 
                    <div class="btn-group white-btn">
                      <?php //include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                    </div>-->
                    
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
                          <input type="text" id="searchLocal" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                        </div>
                      </form>
                  </div>
                </div>


                <div class="panel-body">
                  <div class="row">

                    <div class="col-xs-12 col-md-8" style="padding-left: 0px">
                      <div class="table-responsive">
                        <form id="formDados" >
                            <!-- decalra campos como paramentros de contagem -->
                            <input type="hidden" id="numRegAtual" name="numRegAtual" value="10">
                            <input type="hidden" id="totalReg" name="totalReg" value="<?php echo $limitRegistros ?>">
                            <input type="hidden" id="flagFinal" name="flagFinal" value="0"> 
                        <table id="idTabela" class="table table-striped table-hover table-condensed">
                          <thead>
                            <tr>
                              <!--
                              <th class="left-align sort-none">
                                <div class="checkbox">
                                  <label><input id="select_all" name="select_all" type="checkbox"><span class="checkbox-material"></span></label>
                                </div>
                              </th>-->
                              <th class="left-align sort-asc">
                                <?php echo _('Local') ?>
                              </th>
                              <th class="left-align">
                                <?php echo _('Operador') ?>
                              </th>
                              <th class="left-align">
                                <?php echo _('Gerente') ?>
                              </th>
                              <th class="left-align">
                                <?php echo _('Acciones') ?>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                        	<?php

							while($res_local=@mysql_fetch_assoc($query_local)) 
							{

								echo "<tr id='linha_".$i."'  title='".$res_local['endereco']. "+" . $res_local['nome_cidade'] . "' onClick='mudaLocal(this, ".$res_local['id_local'].");' style='cursor: pointer' >";

								?>
                              <!--
                              <td class="left-align">
                                <div class="checkbox">
                                  <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                </div>
                              </td>-->
                              <td class="left-align"><?php echo $res_local['nome'] ?></td>
                              <td class="center-align"><?php echo $res_local['operador'] ?></td>
                              
                              <?php
							  	//consulta nome do gerente
								$sql_ger = "
									SELECT
										nome
									FROM
										logins
									WHERE
										id_login = " . $res_local['id_gerente'] ;
								$query_ger=@mysql_query($sql_ger);
								$res_ger=@mysql_fetch_assoc($query_ger)
							  
							  ?>
                              
                              
                              <td class="center-align"><?php echo $res_ger['nome'] ?></td>
                          
                              <td>
                              
                              <?php
							  
									//
									if($_SESSION['usr_nivel'] <> 8 and $_SESSION['usr_nivel'] <> 9)
									{
							  ?>
                              
                                <a href="#" <?php echo "id='".$res_local['id_local']."'" ?> class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>" onClick="alimentaModal(this);" title="Editar"><i class="fa fa-edit"></i></a>
                                
                                
								<?php
									}
								?>                                
                                
                                
                                
                                <a <?php echo "id=ver_'".$res_local['id_local']."'" ?> href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>" onClick="alimentaView(this);" title="Ver"><i class="fa fa-eye"></i></a>
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

                    <div class="col-xs-12 col-md-2">
                      <div class="table-responsive">
						<!--- 
                        <form>
                          <div class="form-group is-empty ui-widget">
                            <label for="tags"></label> <input id="myInputSearchField" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                            <span class="material-input"></span>
                          </div>
                        </form>
						-->
                        <table id="tabelaMaq" class="table table-striped table-hover">
                          <thead>
                            <tr>                          
                              <th class="left-align">
                                <?php echo _('Máquinas: ') ?>
                                <span id="nomeLocal"></span>
                              </th>
                            </tr>
                          </thead>
                          <tbody>

                          </tbody>
                        </table>

                      </div>
                    </div>



                    <div class="col-xs-12 col-md-2">
                      <div class="map">
                        <iframe id="frameMap" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18326865.80954878!2d-71.76481787907089!3d-37.535484842928454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c5410425af2f%3A0x505e1131102b91d!2sChile!5e0!3m2!1ses-419!2scl!4v1450904897219" width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen></iframe>
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

  <?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
  <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
  <?php include("inc/modals/modal-view-maquinas.php"); // modal para ver detalles contenido ?>
</body>
</html>
<script>

	//
	function alimentaView(obj)
	{
		var idLoc = (obj.id).split("_");
		
		var $iframe = $('#view_local');
		$iframe.attr('src','frames/view-local.php?id='+idLoc[1]);  		
		
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
						  "sNext":     "Siguiente",
						  "sLast":     "Última"
					}
		},	
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
                    columns: [ 0, 1, 2 ]
                },			
			}
		]		
	});
	

	
	//declara o campo de busca.
	$('#searchLocal').on( 'keyup', function () {
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
	*/
	//
	function mudaLocal(obj, idLocal)
	{
		//busca maquinas desse local
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_maquinas_local.php', // Informo a URL que será pesquisada.
			data: 'id='+idLocal,
			success: function(html)
			{
				
				//alert(html);
					
				var arrayMaq = html.split(",");
				qtdMaq = eval(arrayMaq.length) - 1;


				
				$('#tabelaMaq tbody tr').remove();
				
				
				//
				for (i = 0; i < qtdMaq; i++) 
				{
					detalhe = arrayMaq[i];
					
					infoMaq = detalhe.split("|");
					//alert(infoMaq[1]);
					
					$("#tabelaMaq tbody").append("<tr style='cursor: pointer' onClick='infoMaquina("+infoMaq[1]+");'><td height='57' class='left-align'>"+infoMaq[0]+"</td></tr>");					
				}
				
				
				
				//
				$('#nomeLocal').text(arrayMaq[qtdMaq]);
			}
		});
	
		
		//
		//MUDA MAPA
		//
		var $iframe = $('#frameMap');
		
		var zoomCidade = '1d3329';
		var endereco = obj.title + '+Chile';
		
		$iframe.attr('src','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!'+zoomCidade+'.239360691567!2d-70.60857748420987!3d-33.443069904520705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662cf9c694c61c1%3A0x7147910d01e8afb5!2s'+endereco+'!5e0!3m2!1ses-419!2scl!4v1450898500000'); 
		
		
	}
	
	
	//
	function infoMaquina(idMaq)
	{
		
		//alert(idMaq);
		
		var $iframe = $('#view_maq');
		$iframe.attr('src','frames/view-maquina.php?id='+idMaq); 
		
				
		
		//alert("Mostra Modal de info da maquina");
		
		
		$('#view-modal-Maquinas').modal('toggle');		
	}
	
	
	//
	function alimentaModal(obj)
	{
		jQuery(document).ready( function( $ ) {

			$.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'functions/consulta_dados_local.php', // Informo a URL que será pesquisada.
				data: 'id='+obj.id,
				success: function(html)
				{
					arrayDados = html.split("|");
					
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
					var id_admin = arrayDados[17];	
																			
					
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
					
					$("#edit_tipo_"+nomeObj).attr("value", id_tp_local);
					$("#edit_ger_"+nomeObj).attr("value", id_gerente);
					$("#edit_comOpe_"+nomeObj).attr("value", pct_operador);
					$("#edit_comGer_"+nomeObj).attr("value", pct_gerente);
					$("#edit_admin_"+nomeObj).attr("value", id_admin);
					
					
					//$("#edit_cidade_"+nomeObj).attr("value", id_regiao);
					
					$('#select2-edit_cidade_'+nomeObj+'-container').text(id_regiao);
					$("#edit_cidade_"+nomeObj+" option[value='"+id_regiao+"']").attr('selected', 'selected');
					//$("#hd_edit_cidade_"+nomeObj).attr("value", id_regiao);					
					
					
					$("#select_ope_"+nomeObj).text(id_login);
					$("#select_ger_"+nomeObj).text(id_gerente);
					$("#select_tipo_"+nomeObj).text(id_tp_local);
					$("#select_status_"+nomeObj).text(excluido);
					$("#select_admin_"+nomeObj).text(id_admin);
	
				}
			});	
		});		
	}
	/*
	//mostrar todos resultados.
	$('#carregarTodos').click( function() 
	{
		mostrarTodos();
	});
	
	//
	$('#searchLocal').keyup( function() 
	{	
		mostrarTodos();
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
			
			//soma contador de registros atuais
			$('#regAtual').text(limit);						
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
		
</script>>>>>>>