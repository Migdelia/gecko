
<div class="dashboard">
	<div class="row">
    
    
    
    
		<!-- Panel dashboard 05 -->
		<div class="col-xs-12 col-md-3">
			<div class="panel first">
				<div class="panel-body">
					<div class="table-responsive" style="height:405px; overflow:auto;">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
                                    	<h7><?php echo _('Locales Integrados') ?></h7>&nbsp;&nbsp; <i class="fa fa-building-o"></i>
                                                                        
                                    </th>
									<th>
                                        <form id="formBusca" class="white-form right" onsubmit="return false;">
                                        	<div class="form-group">
                  								<!---
                                            	<a href="" id="filtro_melhoresJogos" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-melhoresJogos"> <?php echo _('Filtro') ?></a> -->
                                        
                                        	</div>
                                        </form>                                     
                                    </th>                                    
								</tr>
							</thead>
							<tbody>

							<?php
								
								$whr= "AND
										(id_login = ". $_SESSION['id_login'] ."
										OR
										id_gerente = ". $_SESSION['id_login'] ."
										OR
										id_admin = ". $_SESSION['id_login'] .")";
							
							
								//consultar todos os locais integrados
								if($_SESSION['usr_nivel'] <> 1)
								{
									$sqlLocaisIntegrados = "SELECT
																vw_maquinas.id_local,
																vw_maquinas.nome,
																(SUM(vw_maquinas.entrada_oficial)) - (SUM(vw_maquinas.saida_oficial)) as leitura_oficial
															FROM
																vw_maquinas
															INNER JOIN
																locais_integrados ON vw_maquinas.id_local = locais_integrados.id_local
															WHERE
																excluido = 'N'
															AND
																(interface > 69999
															AND
																interface < 90000)
															". $whr ."											
															GROUP BY
																id_local
															ORDER BY
																nome";	
								}
								else
								{
									$sqlLocaisIntegrados = "SELECT
																vw_maquinas.id_local,
																vw_maquinas.nome,
																(SUM(vw_maquinas.entrada_oficial)) - (SUM(vw_maquinas.saida_oficial)) as leitura_oficial
															FROM
																vw_maquinas
															INNER JOIN
																locais_integrados ON vw_maquinas.id_local = locais_integrados.id_local
															WHERE
																excluido = 'N'
															AND
																(interface > 69999
															AND
																interface < 90000)												
															GROUP BY
																id_local
															ORDER BY
																nome";									
								}		
														
								$qryLocaisIntegrados=@mysql_query($sqlLocaisIntegrados);		

								
								//
								while($rstLocaisIntegrados=@mysql_fetch_assoc($qryLocaisIntegrados))
								{
									//
									echo "<tr>";
									echo "<td>";									
									
									//
									echo "<img id='img_status_".$rstLocaisIntegrados['id_local']."' src='img/load.gif' width='17px;' >";	
									echo "<input type='hidden' id='hd_".$rstLocaisIntegrados['id_local']."' name='hd_".$rstLocaisIntegrados['id_local']."' value='' /> \n";						
									echo "<input type='hidden' id='hd_leitFeita_".$rstLocaisIntegrados['id_local']."' name='hd_leitFeita_".$rstLocaisIntegrados['id_local']."' value='".$rstLocaisIntegrados['leitura_oficial']."' /> \n";						
									
									echo $rstLocaisIntegrados['nome'];
									echo "</td>";
										  
										  
										  
									//buscar a soma da leitura oficial atual desse local
																		
									
									//colocar span com nome para trocar o valor deposi dos calculo * * $rstLocaisIntegrados['leitura_oficial']
										  
									echo "<td>
											<span id='spanFatLoc_".$rstLocaisIntegrados['id_local']."'>0</span>
										  </td>";									  
									echo "</tr>";									
									
								}
								
								
								

								
	
							?>   
								
		                         
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>  
    
    
		<!-- Panel dashboard 05 -->
		<div class="col-xs-12 col-md-3">
			<div class="panel first">
				<div class="panel-body">
					<div class="table-responsive" style="height:405px; overflow:auto;">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
                                    	<h7><?php echo _('Acumulados') ?></h7> &nbsp;&nbsp; <i class="fa fa-money"></i> 
                                        <form id="formBusca" class="white-form right" onsubmit="return false;">
                                        	<div class="form-group">
                  								<!---
                                            	<a href="" id="filtro_melhoresJogos" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-melhoresJogos"><?php echo _('Filtro') ?></a> -->
                                        
                                        	</div>
                                        </form>                                         
                                    </th>
								</tr>
							</thead>
							<tbody>
							<?php
								//consulta server de cada local itegrado
								if($_SESSION['usr_nivel'] <> 1)
								{
									//
									$sqlListaLocInt = "SELECT
															nome,
															acuGames,
															acumuladoMax,
															jackpotValue
														FROM
															vw_integration 
														WHERE
															machineType = 1 ". $whr;									
								}
								else
								{
									//
									$sqlListaLocInt = "SELECT
															nome,
															acuGames,
															acumuladoMax,
															jackpotValue
														FROM
															vw_integration 
														WHERE
															machineType = 1";										
								}
								
								//echo $sqlListaLocInt;

														
								$qryListaLocInt=@mysql_query($sqlListaLocInt);		

								
								//
								while($rstqryListaLocInt=@mysql_fetch_assoc($qryListaLocInt))
								{
									echo "<tr>";
									echo "<td align='center'>
											<font size='+2'> <strong>".$rstqryListaLocInt['nome']."</strong> 		</font>		<br />
											<font size='+1'> ACU: $ ".number_format($rstqryListaLocInt['acuGames']*100,0,"",".")."</font>			<br />
											<font size='2'> Acu max: $ ".number_format($rstqryListaLocInt['acumuladoMax']*1000,0,"",".")."	</font> &nbsp; / &nbsp; 
											<font size='2'> JKP: $ ".number_format($rstqryListaLocInt['jackpotValue']*1000,0,"",".")."	</font>		<br />
										  </td>";
									echo "</tr>";									
								}													
									
							

								
								
															
								
							?>                            
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>     
    
    
    
		<?php
            //
            if($_SESSION['id_login'] == 11)
            {
        ?>    
    
    
    
		<!-- PAINEL 1 - MAQUINAS ATIVAS -->
    
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-3">
			<div class="panel first">
				<div class="panel-body">
                
                
                
					<div class="table-responsive" style="height:405px; overflow:auto;">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
                                      <h7><?php echo _('Mejores Juegos') ?></h7> &nbsp;&nbsp; <i class="fa fa-thumbs-up"></i>
                                      <!-- dropdown de selects -->
                                                                                                                
                                                        
                                      <!-- input formulario de busqueda -->
                                      <form id="formBusca" class="white-form right" onsubmit="return false;">
                                        <div class="form-group">
                                   
                                   
                                                                   
                                            <!--<a href="" id="filtro_melhoresJogos" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-melhoresJogos"><i class="fa fa-filter"></i> <?php echo _('Filtro') ?></a> -->
    
                                        </div>
                                      </form>                                      
                                    </th>
								</tr>
							</thead>
							<tbody>
							<?php
							
									//consulta jogos
									$sql_mejores_juegos = "SELECT * FROM jogo LIMIT 7";
									$qry_mejores_juegos=@mysql_query($sql_mejores_juegos);		

								
								//
								while($rst_qry_mejores_juegos=@mysql_fetch_assoc($qry_mejores_juegos))
								{

									echo "<tr>";
									echo "<td>";									
									
									//
									echo "<img id='img_status_".$rst_qry_mejores_juegos['id_jogo']."' src='images/".$rst_qry_mejores_juegos['id_jogo'].".png' width='37px;' >";						
									
									echo " &nbsp; &nbsp; " . $rst_qry_mejores_juegos['nome'];
									echo "</td>";
										  
								  
									echo "</tr>";	
									
								}
							?>                            
							</tbody>
						</table>
					</div>
                    
                   
                    
				</div>
			</div>
		</div>
        
        
        
		<!-- Panel dashboard 02 -->
		<div class="col-xs-12 col-md-3">
			<div class="panel first">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
                                    	<h7><?php echo _('Peores Juegos') ?></h7>&nbsp;&nbsp; <i class="fa fa-thumbs-down"></i>
                                    	                                      <!-- input formulario de busqueda -->
                                        <form id="formBusca" class="white-form right" onsubmit="return false;">
                                        	<div class="form-group">
                  
                                            	<a href="" id="filtro_melhoresJogos" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-melhoresJogos"><i class="fa fa-filter"></i> <?php echo _('Filtro') ?></a> 
                                        
                                        	</div>
                                        </form> 
                                    </th>
								</tr>
							</thead>
							<tbody>
							<?php
							/*
								echo "<tr>";
								echo "<td>
										Calabaza Party
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Lady Lucky
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "</tr>";	
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "</tr>";									
									*/														
								
							?>                            
							</tbody>
						</table>
					</div>
                    
                    <div class="panel-body">
                        <div id="piores-jogos" class="graphitem"></div>
                    </div>                      
                    
				</div>
			</div>
		</div>  
        
        
        
		<!-- Panel dashboard 03 -->
		<div class="col-xs-12 col-md-3">
			<div class="panel first">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
                                    	<h7><?php echo _('Mejores Locales') ?></h7>  &nbsp;&nbsp; <i class="fa  fa-thumbs-up"></i>
                                    
                                        <form id="formBusca" class="white-form right" onsubmit="return false;">
                                        	<div class="form-group">
                  
                                            	<a href="" id="filtro_melhoresJogos" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-melhoresJogos"><i class="fa fa-filter"></i> <?php echo _('Filtro') ?></a> 
                                        
                                        	</div>
                                        </form>                                     
                                    
                                    </th>
								</tr>
							</thead>
							<tbody>
							<?php
								/*
								echo "<tr>";
								echo "<td>
										Gran Faraon
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Horus
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Isla del tesoro
									  </td>";
								echo "</tr>";	
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "</tr>";									
									*/														
								
							?>                            
							</tbody>
						</table>
					</div>
                    
                    <div class="panel-body">
                        <div id="melhores-locais" class="graphitem"></div>
                    </div>                     
                    
				</div>
			</div>
		</div>                
        
        
        
        
		<!-- Panel dashboard 04 -->
		<div class="col-xs-12 col-md-3">
			<div class="panel first">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
                                    	<h7><?php echo _('Peores Locales') ?></h7> &nbsp;&nbsp; <i class="fa fa-thumbs-down"></i>
                                    
                                        <form id="formBusca" class="white-form right" onsubmit="return false;">
                                        	<div class="form-group">
                  
                                            	<a href="" id="filtro_melhoresJogos" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-melhoresJogos"><i class="fa fa-filter"></i> <?php echo _('Filtro') ?></a> 
                                        
                                        	</div>
                                        </form>                                     
                                    
                                    
                                    </th>
								</tr>
							</thead>
							<tbody>
							<?php
								/*
								echo "<tr>";
								echo "<td>
										Gran Faraon
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Horus
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Isla del tesoro
									  </td>";
								echo "</tr>";
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "</tr>";										
									*/														
								
							?>                           
							</tbody>
						</table>
					</div>
                    
                    
                    <div class="panel-body">
                        <div id="piores-locais" class="graphitem"></div>
                    </div>                      
				</div>
			</div>
		</div>       
        
        
        
		<!-- Panel dashboard 05 -->
		<div class="col-xs-12 col-md-3">
			<div class="panel first">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
									<th>
                                    	<h7><?php echo _('Máquinas Activas') ?></h7>&nbsp;&nbsp; <i class="fa fa-train"></i> 
                                    
                                        <form id="formBusca" class="white-form right" onsubmit="return false;">
                                        	<div class="form-group">
                  
                                            	<a href="" id="filtro_melhoresJogos" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-melhoresJogos"><i class="fa fa-filter"></i> <?php echo _('Filtro') ?></a> 
                                        
                                        	</div>
                                        </form>                                     
                                    
                                    
                                    </th>
								</tr>
							</thead>
							<tbody>
							<?php
							
								echo "<tr>";
								echo "<td>
										<font size='+6'> <strong>1850</strong> 		</font>		<br />
										<font size='+2'> WPUD 		</font>			<br />
										<font size='+2'> CLP 59.780	</font>		<br />
									  </td>";
								echo "</tr>";	
								
							?>                            
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>  
                
		<!-- Panel dashboard 05 -->
		<div class="col-xs-12 col-md-3">
			<div class="panel first">
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
								<tr>
									<th>
                                    	<h7><?php echo _('Promedio X Máquina') ?></h7> &nbsp;&nbsp; <i class="fa fa-line-chart"></i>
                                                                        
                                    </th>
									<th>
                                        <form id="formBusca" class="white-form right" onsubmit="return false;">
                                        	<div class="form-group">
                  
                                            	<a href="" id="filtro_melhoresJogos" class="btn btn-sm" data-toggle="modal" data-target="#edit-modal-melhoresJogos"><i class="fa fa-filter"></i> <?php echo _('Filtro') ?></a> 
                                        
                                        	</div>
                                        </form>                                  
                                    </th>                                    
								</tr>
								</tr>
							</thead>
							<tbody>
							<?php
							
								echo "<tr>";
								echo "<td>
										Gran Faraon
									  </td>";
								echo "<td>
										$ 25.000
									  </td>";									  
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Horus
									  </td>";
								echo "<td>
										$ 15.000
									  </td>";									  
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Isla del tesoro
									  </td>";
								echo "<td>
										$ 52.000
									  </td>";									  
								echo "</tr>";	
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "<td>
										$ 32.000
									  </td>";									  
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "<td>
										$ 12.000
									  </td>";									  
								echo "</tr>";
								
								echo "<tr>";
								echo "<td>
										Isla del tesoro
									  </td>";
								echo "<td>
										$ 12.000
									  </td>";									  
								echo "</tr>";	
								echo "<tr>";
								echo "<td>
										Magic Troll
									  </td>";
								echo "<td>
										$ 2.000
									  </td>";									  
								echo "</tr>";	
								
								echo "<tr>";
								echo "<td>										
										Magic Troll
									  </td>";
								echo "<td>
										$ 302.000
									  </td>";									  
								echo "</tr>";
								
								echo "<tr>";
								echo "<td>
										Isla del tesoro
									  </td>";
								echo "<td>
										$ 82.000
									  </td>";									  
								echo "</tr>";
								
	
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

<?php
	}
?>

<script type="text/javascript">
	
	//
	
	setInterval(function()
	{
		veriLeitAtual();
	}, 	10000); // 5 segundos


	//
	setInterval(function()
	{
		veriStatus();
	}, 	43000); // 5 segundos

	//declara funcao que sincroniza upTime
	function veriStatus()
	{
		//consulta dados desse dispositivo
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_statusLocal.php', // Informo a URL que será pesquisada.
			data: '',
			success: function(html)
			{
				//alert(html);
				infoLocal = html.split(";");
				limit = eval(infoLocal.length) - 1;

				//
				for (var i = 0; i < limit; i++) 
				{
					dados = infoLocal[i].split(",");
					
					idLocal = dados[0];
					uptime = dados[1];
					
					//declara o uptime
					var upTime = $('#hd_'+idLocal).val();
					var upTimeNovo = uptime;	

					//
					if(upTime > 0)
					{
						//alert("esta definido");
						if(upTimeNovo > upTime)
						{
							$('#img_status_'+idLocal).attr('src','img/greenball.png');	
						}
						else
						{
							//alert("offline");
							$('#img_status_'+idLocal).attr('src','img/redball.png');	
						}						
					}
					
					//
					$('#hd_'+idLocal).attr("value", upTimeNovo);										
				}
			}
		});		
	}



	//declara funcao que sincroniza upTime
	function veriLeitAtual()
	{
		//consulta dados desse dispositivo
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_leitInt.php', // Informo a URL que será pesquisada.
			data: '',
			success: function(html)
			{
				//pegar valor da leitura e comparar com anterior * Erico
				
				
				
				//alert(html);
				
				infoLocal = html.split(";");
				limit = eval(infoLocal.length) - 1;
				


				//
				for (var i = 0; i < limit; i++) 
				{
					dados = infoLocal[i].split(",");
					
					idLocal = dados[0];
					fatNovoLocal = dados[1];
					
					
					//pega valor leitura antigo ** hd_leitFeita_
					var fatAntLocal = $('#hd_leitFeita_'+idLocal).val();
					
					
					//
					lucroDiaLocal = (eval(fatNovoLocal) * 10) - eval(fatAntLocal);
					
					//alert(lucroDiaLocal);
					
					if(lucroDiaLocal < 0)
					{
						lucroDiaLocal = 0;	
					}
					
					lucroDiaLocal = eval(lucroDiaLocal).formatNumber(2,',','.');
					lucroDiaLocal = lucroDiaLocal.replace(',00', '');					
					
					//
					$("#spanFatLoc_"+idLocal).text("$ " + lucroDiaLocal);									
				}
			}
		});		
	}

</script>