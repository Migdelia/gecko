<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');


//Lendo a tabela Com os Dados dos Usuarios
$sql_cidade = "
	SELECT
		*
	FROM
		regiao
	ORDER BY
		nome_cidade
	";	


$query_cidade=@mysql_query($sql_cidade);
$limitRegistros = mysql_num_rows($query_cidade);


?>
<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "ciudades" // ingresar la palabra clave de cada modal ?>

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
                   <i class="fa fa-map fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Ciudad') ?>
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
                 
                    
                      <!-- dropdown de selects -->
                      <div class="btn-group white-btn">
                        <?php //include("inc/dropdown-actions.php"); // btns acciones másivas ?>
                      </div>
                      
                      
                      <!--- info cont --->
                      <div class="btn-group white-btn" style="left:2%;">
                        
                        <span id="contRegistros">&nbsp;</span>
                        
                      </div>                   
                      <!--- info cont--->   

                      
                      
                      <!-- input formulario de busqueda -->
                      <form id="formBusca" class="white-form right" onsubmit="return false;">
                        <div class="form-group">
                          <input id="searchCidade" name="searchCidade" type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                        </div>
                      </form>
                    </div>
                  </div>
                  <div class="panel-body">
                    <div class="col-xs-12 col-sm-9 col-md-8">
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
                              <th class="left-align sort-asc">
                                <a href="#"><?php echo _('Nombre') ?></a>
                              </th>
                              <th class="center-align">
                                <a href="#"><?php echo _('Excluido') ?></a>
                              </th>
                              <th class="center-align">
                                <a href="#"><?php echo _('Acciones') ?></a>
                              </th>
                            </tr>
                          </thead>
                          <tbody>
                            
                        	<?php
							
							$i = 1;
							while($res_cidades=@mysql_fetch_assoc($query_cidade)) 
							{
									echo "<tr id='linha_".$i."' title='".$res_cidades['nome_cidade']."'  onClick='mudaCidade(this);'>";
								?>
                                <!---
                              <td class="left-align">
                                <div class="checkbox">
                                  <label><input type="checkbox"><span class="checkbox-material"></span></label>
                                </div>
                              </td>--->
                              <td class="left-align"><?php echo $res_cidades['nome_cidade']; ?></td>
                              
                              
                              
                              <td class="center-align"><?php if($res_cidades['excluido'] == "S"){echo "Inactivo";}else{echo "Activo";} ?></td>
                              <td class="center-align">
                                <a href="" <?php echo "id='".$res_cidades['id_cidade']."'" ?> class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-<?php echo $filenameID ?>" onClick="alimentaModal(this);"><?php echo _('Editar') ?></a>
                                <a <?php echo "id=ver_'".$res_cidades['id_cidade']."'" ?> href="#" class="btn btn-sm" data-toggle="modal" data-target="#view-modal-<?php echo $filenameID ?>" onClick="modalVer(this);"><?php echo _('Ver') ?></a>
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
                    <div class="col-xs-12 col-sm-3 col-md-4">
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

    <?php include("inc/modals/modal-edit-" . $file_name . ".php"); // modal para editar contenido ?>
    <?php include("inc/modals/modal-view-" . $file_name . ".php"); // modal para ver detalles contenido ?>
  </body>
</html>


<script>

	//teste maps
	function mudaCidade(obj)
	{
		var $iframe = $('#frameMap');
		
		var zoomCidade = '1d100329';
		var endereco = obj.title + '+Chile';
		
		$iframe.attr('src','https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!'+zoomCidade+'.239360691567!2d-70.60857748420987!3d-33.443069904520705!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662cf9c694c61c1%3A0x7147910d01e8afb5!2s'+endereco+'!5e0!3m2!1ses-419!2scl!4v1450898500000');  
	}	
	
	
	
	
	//teste maps

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
			'aTargets' : [ 2 ]
			}
		],	
		aoColumns:[
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
                    columns: [ 0, 1 ]
                },
				
			},
			{
				extend: 'excelHtml5',
				className: 'btn btn-exp',
				text: 'Exportar Excel',
                exportOptions: {
                    columns: [ 0, 1 ]
                },			
			}
		]		
	});
	

	
	//declara o campo de busca.
	$('#searchCidade').on( 'keyup', function (e) {
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
			
			//soma os contadores de registro
			var regTotais = $(regTotal).text();

			
			if(limit >= regTotais)
			{
				$('#regAtual').text(regTotais);
			}
			else
			{
				$('#regAtual').text(limit);
			}
		}
		var flag = $(flagFinal).val();
		
		if(flag == 0)
		{		
			$('#linha_carregar_mais').fadeIn("slow");
		}
	}		
	*/
	
	//
	function alimentaModal(obj)
	{
		//consulta dados do objeto para preencher modal.
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_dados_cidade.php', // Informo a URL que será pesquisada.
			data: 'id='+obj.id,
			success: function(html)
			{
				
				arrayDados = html.split(",");
				
				nome = arrayDados[0];
				status = arrayDados[1];
				
				$("#input_edit_Ciudad").attr("value", nome);
				$("#input_status_Ciudad").text(status);
				$("#id_cidade_atual").attr("value", obj.id);
				$("#status_Ciudad").attr("value", status);




			}
		});						
	}	
	
	
	//
	function modalVer(obj)
	{

		var idCidade = obj.id.split("_");
		idCidade = idCidade[1];
		

		
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_dados_cidade.php', // Informo a URL que será pesquisada.
			data: 'id='+idCidade,
			success: function(html)
			{
				arrayDados = html.split(",");
				
				nome = arrayDados[0];
				status = arrayDados[1];
				id = arrayDados[2];
				listaLocal = arrayDados[3];
				qtdLoc = arrayDados[4];


				$('#vw_id_cidade').text(id);
				$('#vw_nome_cidade').text(nome);
				$('#vw_status_cidade').text(status);
				$('#vw_qtd_loc').text(qtdLoc);														



				//limpa tabela
				$('#locCidade tbody tr').remove();
				
				var arrayValores = listaLocal.split("|");
				
				//alert(arrayValores[0]);
				
				//
				for (i = 0; i < qtdLoc; i++) 
				{
					//alert(arrayMaq[i]);
					$("#locCidade tbody").append("<tr><td>"+arrayValores[i]+"</td></tr>");					
				}


				
			}
		});						
	}	
	
	/*
	//mostrar todos resultados.
	$('#carregarTodos').click( function() 
	{
		mostrarTodos();
	});
	
	//
	$('#searchCidade').keyup( function() 
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
	}*/

	$('#confCadastro').click(function (){
		location.reload();
	});

</script>