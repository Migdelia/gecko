<?php
//Fechamento de sessao ao fechar o navegador
session_start();
//include('conn/conn.php');
//include('functions/validaLogin.php');
?>
<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "local Integrado" // ingresar la palabra clave de cada modal ?>

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
                  <i class="fa fa-building-o fa-stack-1x fa-inverse"></i>
                </span>
                <?php echo _('Locales Integrados') ?>				              
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">
              <?php //include("inc/buttons-loc-int.php"); // btns paneles ?>
            </div>
          </div>

          <div class="row">
            <div class="col-xs-12">
              <div class="panel">
                    <div class="panel-body">
                      <div class="col-xs-12 col-md-4">
                        <!-- lista locales -->
                        <div class="panel">
                  				<div class="panel-heading">
                  					<i class="material-icons">store</i> <?php echo _('Lista Locales') ?>
                  				</div>
                  				<div class="panel-body">
                  					<!--- <div class="table-responsive scroll"> --->
                                    <div class="table-responsive">
                                    
                  						<table class="table table-striped table-hover locales">
                  							<thead>
                  								<tr data-local="01">
                  								<tr data-local="01">
                                                	<th>&nbsp;</th>
                  									<th><?php echo _('Local') ?></th>
                  									 <th>&nbsp;</th>
                  								</tr>
                  								</tr>
                  							</thead>
                  							<tbody>
											<?php
												
												//
												if($_SESSION['usr_nivel'] == 1)
												{
													//consulta locais integrados
													$sql_locais_int = "
														SELECT
															*
														FROM
															locais_integrados														
														";														
												}
												else
												{
													//consulta locais integrados
													$sql_locais_int = "
														SELECT
																*
														FROM
																locais_integrados
														INNER JOIN
																`local`
														ON
																locais_integrados.id_local = `local`.id_local
														WHERE
																`local`.id_login = ".$_SESSION['id_login']."
														OR
																`local`.id_gerente = ".$_SESSION['id_login']."
														OR
																`local`.id_admin = ".$_SESSION['id_login']."															
														";													
												}
											

                                                    
                                                $query_locais_int=@mysql_query($sql_locais_int);
                                                
                                                //
                                                while($res_locais_int=@mysql_fetch_assoc($query_locais_int)) 
                                                {
                                                    
                                                    //consulta dados do local
                                                    $sql_dados_local = "
                                                        SELECT
															id_local,
                                                            nome,
                                                            nome_cidade
                                                        FROM 
                                                            vw_local
                                                        WHERE
                                                            id_local = ".$res_locais_int['id_local'];
                                                    $query_dados_local=@mysql_query($sql_dados_local);
                                                    $res_dados_local=@mysql_fetch_assoc($query_dados_local);
                                                    
                    
													echo "<tr id='lnLocal_".$res_dados_local['id_local']."' data-local='".$res_dados_local['id_local']."' onClick='carregaMaquinas(this.id);'>";

													echo "<td class='right-align'>
															<input type='hidden' id='status_loc_".$res_dados_local['id_local']."' name='status_loc_".$res_dados_local['id_local']."' value='0' />
															<img id='imgLoc_".$res_dados_local['id_local']."' src='img/redball.png' alt=''>
															
														  </td>";

													//echo "<tr id='lnLocal_".$res_dados_local['id_local']."' data-local='".$res_dados_local['id_local']."'>";
													echo "<td>".$res_dados_local['nome']."</td>";
													//echo "<td><a href='#' id='detalhe_".$res_dados_local['id_local']."' class='btn btn-sm' onClick='detalheLocal(this);'>Info</a></td>";
													//echo "<td>".$res_dados_local['nome_cidade']."</td>";
													
													
													
													
													//bloquear administradores.
													if($_SESSION['usr_nivel'] <> 8 or $_SESSION['id_login'] == 30)
													{
														echo "<td><a href='#' id='detalhe_".$res_dados_local['id_local']."' class='btn btn-sm' onClick='configLocal(this);'>Config</a></td>";		
														
													}
													else
													{
														echo "<td>&nbsp;</td>";		
														
													}
													
													
													
													
												
												
													
																								
													echo "</tr>";
													
													//gera lista de hiddens com uptime
													$sql_maq_uptime = "
														SELECT
															numero			
														FROM
															vw_maquinas
														WHERE
															excluido = 'N'
														AND
															id_local = ".$res_dados_local['id_local']."
														ORDER BY
															numero";
													$query_maq_uptime=@mysql_query($sql_maq_uptime);
				
													//									
													while($res_maq_uptime=@mysql_fetch_assoc($query_maq_uptime)) 
													{
														echo "<input type='hidden' id='hd_".$res_maq_uptime['numero']."' name='hd_".$res_maq_uptime['numero']."' value='' /> \n";
													}													
                  								
             
                                                }												
                                            ?>

                  							</tbody>
                  						</table>
                  					</div>
                  				</div>
                  			</div>
                      </div>
                      
                      
                      <div class="col-xs-12 col-md-1">
                        &nbsp;
                      </div>                      
                      
                      <div class="col-xs-12 col-md-7">
                        <!-- lista locales -->
                        <div class="panel">
                  				<div class="panel-heading">
                  					<?php echo _('Lista Máquinas Local: ') ?>
                                    &nbsp; &nbsp;
                                    <strong><span id="localSelecionado" title="0">&nbsp;</span></strong>
                                    &nbsp; &nbsp; 
                                    <i id="carregandoLocal" class="fa fa-cog fa-spin " style="display:none;"></i>
                                    <i class="fa fa-tv" style="position:absolute; right:10%;cursor:pointer;" onClick="fullScreen();" title=""></i>
                  				</div>
                  				<div class="panel-body">
                  					<!--- <div class="table-responsive scroll"> --->
                                    <div class="table-responsive">
                  						<table id="tabelaListaMaquinas" class="table table-striped table-hover maquinas" style="display:none;">
                                        <thead>
                                            <tr>
                                                <th><?php echo _('Status') ?></th>
                                                <th><?php echo _('Máquina') ?></th>
                                                <th><?php echo _('Juego') ?></th>
                                                <th><?php echo _('$ Actual') ?></th>
                                                <th><?php echo _('Entrada') ?></th>
                                                <th><?php echo _('Salida') ?></th>
                                                <th><?php echo _('$ Lucro') ?></th>                                                    
                                            </tr>
                                        </thead>
                  							<tbody>
                                                <tr>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>
                                                    <td>&nbsp;</td>	
                                                    <td>&nbsp;</td>													
                                                </tr>                                          
                  							</tbody>
                  						</table> 
                  					</div>
                  				</div>
                  		</div>
                      </div>                      


					  <!---
                      <div class="col-xs-12 col-md-3">
                        <div class="map">
                          
                          <iframe src="https://www.google.com/maps/d/embed?mid=1IHCfmm5uw43ZuppPK79XMTDmnvs" width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen=""></iframe>
                          
                          

                        </div>
                      </div>
                      --->
                      
                      <!-- OLD <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d18326865.80954878!2d-71.76481787907089!3d-37.535484842928454!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9662c5410425af2f%3A0x505e1131102b91d!2sChile!5e0!3m2!1ses-419!2scl!4v1450904897219" width="100%" height="650px" frameborder="0" style="border:0" allowfullscreen=""></iframe> -->                      

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php include("inc/modals/modal-view-locales-integrados.php"); // modal para ver detalles contenido ?>
      </body>
      </html>

<script>

	//carrega / atualiza lista de maquinas
	function carregaMaquinas(id)
	{
		$('#carregandoLocal').fadeIn("slow");
		
		idLocal = id.split("_");
		idLocal = idLocal[1];
		
		
		//pega a data inicial e a final 
		var dataInicial = $('#dataInicio').val();
		var dataFinal = $('#dataFim').val();

		
		
		//Atualiza lista de maquinas
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_maquinas.php', // Informo a URL que será pesquisada.
			data: 'id='+idLocal,
			success: function(html)
			{	
				//
				var arrayMaq = html.split(";");
				qtdMaq = eval(arrayMaq.length) - 1;
				
				//limpa tabela
				$('#tabelaListaMaquinas tbody tr').remove();
				
				//
				//declara contadores
				var TotalMaq = 0;
				var TotalCreditos = 0;				
				var TotalEntrada = 0;
				var TotalSaida = 0;	
				var TotalLucro = 0;								
				
				//
				for (i = 0; i < qtdMaq; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayMaq[i].split(",");					
					
					//declara o uptime
					var upTime = $('#hd_'+arrayValores[0]).val();
					var upTimeNovo = arrayValores[10];
					
					
					
					/*
					
					if(arrayValores[0] == 2649)
					{
						alert(upTime);
						alert(upTimeNovo);		
					}*/

					//alert(upTime);
					
					
					if(upTimeNovo > upTime)
					{
						var cor = 'green';	
					}
					else
					{
						var cor = 'red';
					}
					$('#hd_'+arrayValores[0]).attr("value", arrayValores[10]);
				
					
					//monta a linha				
					$("#tabelaListaMaquinas tbody").append("<tr id='lnMaquina_"+arrayValores[6]+"' onClick='carregaDetalheMaquinas(this, "+arrayValores[2]+");' title='"+arrayValores[0]+"' data-toggle='modal' data-target='#view-modal-locales-integrados'><td><img src='img/"+cor+"ball.png' width='25px;'></td><td>"+arrayValores[0]+"</td><td><img src='images/"+arrayValores[1]+".png' width='40px;'></td><td>$ "+arrayValores[9]+"</td><td>$ "+arrayValores[3]+"</td><td>$ "+arrayValores[4]+"</td><td>$ "+arrayValores[11]+"</td></tr>");
					
					//alert(arrayValores[9]);
					var creditoIndividual = arrayValores[9];
					creditoIndividual = creditoIndividual.replace('.', '');
					creditoIndividual = creditoIndividual.replace('.', '');	
					TotalCreditos = eval(TotalCreditos) + eval(creditoIndividual);
					
					var entradaIndividual = arrayValores[3];
					entradaIndividual = entradaIndividual.replace('.', '');
					entradaIndividual = entradaIndividual.replace('.', '');	
					TotalEntrada = eval(TotalEntrada) + eval(entradaIndividual);
					
					var saidaIndividual = arrayValores[4];
					saidaIndividual = saidaIndividual.replace('.', '');
					saidaIndividual = saidaIndividual.replace('.', '');	
					TotalSaida = eval(TotalSaida) + eval(saidaIndividual);
					
					var lucroIndividual = arrayValores[11];
					lucroIndividual = lucroIndividual.replace('.', '');
					lucroIndividual = lucroIndividual.replace('.', '');	
					TotalLucro = eval(TotalLucro) + eval(lucroIndividual);															
						
					TotalMaq++;
								
				}
				//
				TotalCreditos = eval(TotalCreditos).formatNumber(2,',','.');
				TotalCreditos = TotalCreditos.replace(',00', '');
				
				TotalEntrada = eval(TotalEntrada).formatNumber(2,',','.');
				TotalEntrada = TotalEntrada.replace(',00', '');	
				
				TotalSaida = eval(TotalSaida).formatNumber(2,',','.');
				TotalSaida = TotalSaida.replace(',00', '');
				
				TotalLucro = eval(TotalLucro).formatNumber(2,',','.');
				TotalLucro = TotalLucro.replace(',00', '');												
				
				//monta linha de totais
				$("#tabelaListaMaquinas tbody").prepend("<tr id='lnMaquina_Totais'><td><strong>Totales: </strong></td><td><strong>"+TotalMaq+"</strong></td><td>&nbsp;</td><td><strong>$ "+TotalCreditos+"</strong></td><td><strong>$ "+TotalEntrada+"</strong></td><td><strong>$ "+TotalSaida+"</strong></td><td><strong>$ "+TotalLucro+"</strong></td></tr>");				
				

				
				//muda o nome do local selecionado
				$("#localSelecionado").text(arrayValores[7]);
				$("#localSelecionado").attr("title", arrayValores[8]);
			}
		});	
		
		$('#carregandoLocal').fadeOut("slow");			
	}
	
	//carrega os detalhes da maquina
	function carregaDetalheMaquinas(obj, disp)
	{
		
		
		
		//teste 
		$('#conteudoOnline').fadeOut("fast");
		$('#loadingInfo').fadeIn("slow");
		
		
		setTimeout(
		function() 
		{
			$('#loadingInfo').fadeOut("fast");
		}, 4000);
		
		setTimeout(
		function() 
		{
			$('#conteudoOnline').fadeIn("slow");
		}, 4200);					
		
		
		
		
		
		//
		//$("#div_jogos").html("");		
		
		//limpa tabela de pagos
		$('#tabelaUltimosPagos tbody tr').remove();
		
		//limpa tabela Bilhetes
		$('#tabelaUltimosBilhetes tbody tr').remove();		
		
		//limpa tabela Premios
		$('#tabelaUltimosPremios tbody tr').remove();		
		
		idMaquina = obj.id.split("_");
		idMaquina = idMaquina[1];	
		
		lastPayout(idMaquina);
		lastBill(idMaquina);
		infoAtual(idMaquina);
		statistic(idMaquina);
		lastPrizes(idMaquina);
		configMaq(idMaquina);
		lastGames(idMaquina);
		
		//muda o txt da maquina selecionada
		$("#maqSelecionada").text(obj.title);
		$("#maqSelecionada").attr("title", disp);
		
	}
	
	//function last payout
	function lastPayout(id)
	{
		//consulta ultimos pagos dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_ultimosPagos.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayPagos = html.split(";");
				qtdPagos = eval(arrayPagos.length) - 1;
				
				//limpa tabela
				$('#tabelaUltimosPagos tbody tr').remove();
				
				
				//
				for (i = 0; i < qtdPagos; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayPagos[i].split("/");
					$("#tabelaUltimosPagos tbody").append("<tr><td>"+arrayValores[0]+"</td><td>"+arrayValores[1]+"</td></tr>");					
				}
			}
		});			
	}
	
	//function last bilhetes
	function lastBill(id)
	{
		//consulta ultimos pagos dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_ultimosBilhetes.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	

				//
				var arrayBill = html.split(";");
				qtdBill = eval(arrayBill.length) - 1;
				
				//limpa tabela
				$('#tabelaUltimosBilhetes tbody tr').remove();
				
				
				//
				for (i = 0; i < qtdBill; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayBill[i].split(",");
					$("#tabelaUltimosBilhetes tbody").append("<tr><td>"+arrayValores[0]+"</td><td>"+arrayValores[1]+"</td></tr>");					
				}
			}
		});			
	}	
	
	//function info maquina
	function infoAtual(id)
	{
		//consulta ultimas informacoes
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_infos.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayInfo = html.split(";");
				qtdInfo = eval(arrayInfo.length) - 1;
				
				//limpa tabela
				$('#tabelaInfoAtual tbody tr').remove();
				
				//
				for (i = 0; i < qtdInfo; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayInfo[i].split(",");
					$("#tabelaInfoAtual tbody").append("<tr><td>Num Dispositivo:</td><td>"+arrayValores[0]+"</td></tr><tr><td>Juego:</td><td>"+arrayValores[1]+"</td></tr><tr><td>Fecha Actual:</td><td>"+arrayValores[2]+"</td></tr><tr><td>Fecha Expiración:</td><td>"+arrayValores[3]+"</td></tr><tr><td>IP:</td><td>"+arrayValores[4]+"</td></tr><tr><td>Versión:</td><td>"+arrayValores[5]+"</td></tr><tr><td>Creditos:</td><td>$ "+arrayValores[6]+"</td></tr><tr><td>Creditos Promo:</td><td>$ "+arrayValores[7]+"</td></tr>");					
				}
			}
		});			
	}
	
	//function Statistic
	function statistic(id)
	{
		//consulta ultimas informacoes
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_statistics.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayInfo = html.split(";");
				qtdInfo = eval(arrayInfo.length) - 1;
				
				//limpa tabela
				$('#tabelaStatistic tbody tr').remove();
				
				//
				for (i = 0; i < qtdInfo; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayInfo[i].split(",");
					$("#tabelaStatistic tbody").append("<tr><td>Entrada:</td><td>"+arrayValores[0]+"</td><td>"+arrayValores[0]+"</td></tr><tr><td>Valor Pagado:</td><td>"+arrayValores[1]+"</td><td>"+arrayValores[1]+"</td></tr><tr><td>Valor Jugado:</td><td>"+arrayValores[2]+"</td><td>"+arrayValores[2]+"</td></tr><tr><td>Valor Ganado:</td><td>"+arrayValores[3]+"</td><td>"+arrayValores[3]+"</td></tr><tr><td>Valor Jugadas Dobladas:</td><td>"+arrayValores[4]+"</td><td>"+arrayValores[4]+"</td></tr><tr><td>Valor Dobladas Ganadas:</td><td>"+arrayValores[5]+"</td><td>"+arrayValores[5]+"</td></tr><tr><td>Entrada Promocional:</td><td>"+arrayValores[6]+"</td><td>"+arrayValores[6]+"</td></tr><tr><td>Juegos Jugados:</td><td>"+arrayValores[7]+"</td><td>"+arrayValores[7]+"</td></tr><tr><td>Juegos Ganados:</td><td>"+arrayValores[8]+"</td><td>"+arrayValores[8]+"</td></tr><tr><td>Dobladas Jugadas:</td><td>"+arrayValores[9]+"</td><td>"+arrayValores[9]+"</td></tr><tr><td>Dobladas Ganadas:</td><td>"+arrayValores[10]+"</td><td>"+arrayValores[10]+"</td></tr><tr><td>Jackpot Pagado:</td><td>"+arrayValores[11]+"</td><td>"+arrayValores[11]+"</td></tr><tr><td>Big Acumulado Pagado:</td><td>"+arrayValores[12]+"</td><td>"+arrayValores[12]+"</td></tr><tr><td>Acumulado Pagado:</td><td>"+arrayValores[13]+"</td><td>"+arrayValores[13]+"</td></tr><tr><td>Diferencial:</td><td>"+arrayValores[14]+"</td><td>"+arrayValores[14]+"</td></tr>");					
				}
			}
		});			
	}
	
	
	//function ultimos premios (grandes)
	function lastPrizes(id)
	{
		//consulta ultimos premios dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_ultimosPremios.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayPagos = html.split(";");
				qtdPagos = eval(arrayPagos.length) - 1;
				
				//limpa tabela
				$('#tabelaUltimosPremios tbody tr').remove();
				
				
				//
				for (i = 0; i < qtdPagos; i++) 
				{
					//alert(arrayMaq[i]);
					var arrayValores = arrayPagos[i].split("/");
					$("#tabelaUltimosPremios tbody").append("<tr><td>$ "+arrayValores[0]+"</td><td>"+arrayValores[1]+"</td><td>"+arrayValores[2]+"</td></tr>");					
				}
			}
		});			
	}	
	
	//function carrega config
	function configMaq(id)
	{
		//consulta configs dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_config.php', // Informo a URL que será pesquisada.
			data: 'id='+id,
			success: function(html)
			{	
				//
				var arrayValores = html.split(",");				
				
				$("#input_tipoMoeda").text(arrayValores[0]);
				$("#input_denom").text(arrayValores[1]);
				$("#input_pct").text(arrayValores[2]);				
				$("#input_tipoMaq").text(arrayValores[3]);
				$("#bigAcuMin").attr("value", arrayValores[4]);
				$("#bigAcuMax").attr("value", arrayValores[5]);
				$("#bigAcuAtu").attr("value", arrayValores[6]);
				$("#AcuMin").attr("value", arrayValores[7]);
				$("#AcuMax").attr("value", arrayValores[8]);			
				$("#AcuAtu").attr("value", arrayValores[9]);
				$("#vlJack").attr("value", arrayValores[10]);
				$("#input_LimDobra").text(arrayValores[11]);
				$("#input_db").text(arrayValores[12]);
				$("#input_FamBig").text(arrayValores[13]);
				$("#input_FavBig").text(arrayValores[14]);				
				$("#input_Fam").text(arrayValores[15]);
				$("#input_Fav").text(arrayValores[16]);
				$("#input_LimCobrar").text(arrayValores[17]);
				$("#input_pKey").text(arrayValores[18]);												
			}
		});		
	}

	//troca valor de uma config
	function atribuiValor(obj)
	{
		//
		var tpCombo = obj.id.split("_");
		tpCombo = tpCombo[0];
		
		$('#input_'+tpCombo).text(obj.text);
		
		//$('#select_'+tpCombo+'_Maquina').text(obj.text);
		//$('#input_'+tpCombo+'_Maquina').attr("value", obj.text);	
	}

	//function ultimos jogos
	function lastGames(id)
	{
		var idLoc = $('#localSelecionado').attr('title');	
		
		//consulta ultimos pagos dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_ultimosJogos.php', // Informo a URL que será pesquisada.
			data: 'id='+id+'&idLocal='+idLoc,
			success: function(html)
			{	
				//
				var arrayGame = html.split("/");
				qtdGame = eval(arrayGame.length) - 1;
				
				var conteudoDiv = "";

				
				
				//monta todos os jogos
				for (i = 0; i < qtdGame; i++) 
				{
					var arrayValores = arrayGame[i].split(";");

					
					
					//verifica se é a primeira div
					if(i==0)
					{
						var divAtiva = " active";	
					}
					else
					{
						var divAtiva = "";
					}	
					
					//verifica se pagou alguma linha
					if(arrayValores[27] == '')
					{
						linhas = '';	
					}
					else
					{
						var linhas = '';					
						linhas = linhas + "style='";
						linhas = linhas + "background-image:url(images/lineas/linea"+arrayValores[27]+".png)";
						
						//verifica se tem mais linhas
						for(x = 28; x < 47; x++)
						{
							if(arrayValores[x] > 0)
							{
								linhas = linhas + ",url(images/lineas/linea"+arrayValores[x]+".png)";
							}							
						}

						
						
						linhas = linhas + ";";
						linhas = linhas + "background-repeat:no-repeat;'";	

					}
					
					
										
					var conteudoDiv = conteudoDiv + "<div class='item"+divAtiva+"' style='background-image:url(images/reels/fundo.png);background-repeat:no-repeat;background-size:100% auto;' title'"+arrayValores[15]+"'><table "+linhas+"><tr><td><img src='images/reels/"+arrayValores[0]+".png' width='100'></td><td><img src='images/reels/"+arrayValores[1]+".png' width='100'></td><td><img src='images/reels/"+arrayValores[2]+".png' width='100'></td><td><img src='images/reels/"+arrayValores[3]+".png' width='100'></td><td><img src='images/reels/"+arrayValores[4]+".png' width='104'></td></tr><tr><td><img src='images/reels/"+arrayValores[5]+".png' width='104'></td><td><img src='images/reels/"+arrayValores[6]+".png' width='104'></td><td><img src='images/reels/"+arrayValores[7]+".png' width='104'></td><td><img src='images/reels/"+arrayValores[8]+".png' width='104'></td><td><img src='images/reels/"+arrayValores[9]+".png' width='104'></td></tr><tr><td><img src='images/reels/"+arrayValores[10]+".png' width='104'></td><td><img src='images/reels/"+arrayValores[11]+".png' width='104'></td><td><img src='images/reels/"+arrayValores[12]+".png' width='104'></td><td><img src='images/reels/"+arrayValores[13]+".png' width='104'></td><td><img src='images/reels/"+arrayValores[14]+".png' width='104'></td></tr></table><div class='carousel-caption'>Juego: "+(i+1)+" / "+qtdGame+"</div><br><br><div class='col-xs-4 col-md-4'><table class='table table-striped table-hover'><tbody><tr><td>Lineas:</td><td>"+arrayValores[25]+"</td></tr><tr><td>Total Apuesta:</td><td>"+arrayValores[26]+"</td></tr><tr><td>Creditos Anteriores:</td><td>"+arrayValores[15]+"</td></tr><tr><td>Creditos Posteriores:</td><td>"+arrayValores[16]+"</td></tr><tr><td>Total Ganado:</td><td>"+arrayValores[17]+"</td></tr></tbody></table></div><div class='col-xs-4 col-md-4'><table class='table table-striped table-hover'><tbody><tr><td>Premios en Rodillos:</td><td>"+arrayValores[18]+"</td></tr><tr><td>Bonus 1:</td><td>"+arrayValores[19]+"</td></tr><tr><td>Bonus 2:</td><td>"+arrayValores[20]+"</td></tr><tr><td>Bonus 3:</td><td>"+arrayValores[21]+"</td></tr></tbody></table></div><div class='col-xs-4 col-md-4'><table class='table table-striped table-hover'><tbody><tr><td>Big Acumulado Pagado:</td><td>"+arrayValores[22]+"</td></tr><tr><td>Jackpot Pagado:</td><td>"+arrayValores[23]+"</td></tr><tr><td>Acumulado Pagado:</td><td>"+arrayValores[24]+"</td></tr></tbody></table></div></div>";	
				}
				
				$("#div_jogos").html(conteudoDiv);
			}
		});			
	}	

	//reconfigura a maquina
	$('#btnReconfig').click( function (){
	//declara todos os valores para passar
		var arrayValores = '';
		var arrayValores = arrayValores + $(input_tipoMoeda).text() + ';';
		var arrayValores = arrayValores + $(input_denom	).text() + ';';
		var arrayValores = arrayValores + $(input_pct).text() + ';';
		var arrayValores = arrayValores + $(input_tipoMaq).text() + ';';	
		var arrayValores = arrayValores + $('#bigAcuMin').val() + ';';
		var arrayValores = arrayValores + $('#bigAcuMax').val() + ';';
		var arrayValores = arrayValores + $('#bigAcuAtu').val() + ';';
		var arrayValores = arrayValores + $('#AcuMin').val() + ';';
		var arrayValores = arrayValores + $('#AcuMax').val() + ';';
		var arrayValores = arrayValores + $('#AcuAtu').val() + ';';
		var arrayValores = arrayValores + $('#vlJack').val() + ';';
		var arrayValores = arrayValores + $(input_LimDobra).text() + ';';
		var arrayValores = arrayValores + $(input_db).text() + ';';
		var arrayValores = arrayValores + $(input_FamBig).text() + ';';
		var arrayValores = arrayValores + $(input_FavBig).text() + ';';
		var arrayValores = arrayValores + $(input_Fam).text() + ';';
		var arrayValores = arrayValores + $(input_Fav).text() + ';';
		var arrayValores = arrayValores + $(input_LimCobrar).text() + ';';
		var arrayValores = arrayValores + $(input_pKey).text() + ';';
		var arrayValores = arrayValores + $('#maqSelecionada').attr('title') + ';';	
		
		
		var idLoc = $('#localSelecionado').attr('title');	


		//consulta ultimos pagos dessa maquina
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/reconfig_online.php', // Informo a URL que será pesquisada.
			data: 'valores='+arrayValores+'&idLocal='+idLoc,
			success: function(html)
			{	
				if(html==0)
				{
					alert("Error!");	
				}
				else
				{
					$('#divConfig').fadeOut("slow");
					
					
					
					//atribui a maquina selecionada
					var idDisp = $('#maqSelecionada').attr("title");
					var idMaquina = idDisp; //buscar numero da placa selecionada.
					
					setTimeout(
					function() 
					{
						configMaq(idMaquina);
						$('#divConfig').fadeIn("slow");
					}, 25000);																
				}

			}
		});	
		
		return false;	
	});
	
	//
	setInterval(function()
	{
		buscaInfos();
	}, 	38000); // 38 segundos
	

	setTimeout(function()
	{
		buscaInfos();
	}, 	3000);	 // 3 segundos

	/*
	setTimeout(function()
	{
		buscaInfos();
	}, 	13000);	 // 13 segundos*/
	
	//consulta status 
	//setInterval(function()
	function buscaInfos()
	{
		//alert(dataFinal);
		
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_statusLocal.php', // Informo a URL que será pesquisada.
			data: '',
			success: function(html)
			{	
				//
				var arrayStatus = html.split(";");
				qtdLoc = eval(arrayStatus.length) - 1;
				
				//
				for (i = 0; i < qtdLoc; i++) 
				{
					//pega novos valores
					var arrayValores = arrayStatus[i].split(",");

					//consulta o ultimo uptime desse local
					var upTime = $('#status_loc_'+arrayValores[0]).val();
					
					
					//verifica se o uptime atual é maior que o antigo
					if(upTime < arrayValores[1])
					{
						//alert("maior = Online");
						$('#imgLoc_'+arrayValores[0]).attr('src','img/greenball.png');
						//$("#txtStatus_"+arrayValores[0]).text('Online');
					}
					else
					{
						//alert("igual = off");	
						$('#imgLoc_'+arrayValores[0]).attr('src','img/redball.png');
						//$("#txtStatus_"+arrayValores[0]).text('Offline');
					}
					
					//guarda uptime de cada maquina
					$('#status_loc_'+arrayValores[0]).attr("value", arrayValores[1]);	
				}				
			}
		});
		
		//sincroniza algumas informacoes
		//pegar o id do ultimo local selecionado.
		var idLocalSelecionado = $("#localSelecionado").attr("title");
		var idMaquina = $("#maqSelecionada").attr("title");

		if(idLocalSelecionado > 0)
		{
			//roda funcoes sincronizadoras
			carregaMaquinas('lnLocal_'+idLocalSelecionado);	//efetuar isso em cada maquina	
			infoAtual(idMaquina);
			//statistic(idMaquina);
			//lastBill(idMaquina);
			//lastPayout(idMaquina);
			//lastPrizes(idMaquina);
			
		}
	}
				
	//}, 25000);
	
	
	function detalheLocal(obj)
	{
		idLocal = (obj).split("_");
		idLocal = idLocal[1];
		window.open('detalle-local-online.php?id='+idLocal,'_blank','width=100%','height=100%');
	}
	
	function configLocal(obj)
	{
		idLocal = (obj.id).split("_");
		idLocal = idLocal[1];
		window.open('config-local-online.php?id='+idLocal,'_blank','width=100%','height=100%');
	}	

	//
	function fullScreen()
	{
		idLocalSelecionado = $("#localSelecionado").attr("title");
		detalheLocal("detalheLocal_"+idLocalSelecionado);	
	}		
	
</script>