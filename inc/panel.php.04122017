<?php

//verifica se é master
if($_SESSION['usr_nivel'] == 1)
{
	$whr = " 1 = 1 ";
}
else
{
	$whr = " (vw_maquinas.id_login = ". $_SESSION['id_login'] ." OR  vw_maquinas.id_gerente = " . $_SESSION['id_login']  ." OR  vw_maquinas.id_admin = " . $_SESSION['id_login'] . ")";	
}


//consulta as dez maquinas a mais tempo sem leitura.
$sql_maq_sin_leitura = "
SELECT
	vw_maquinas.id_maquina,
	vw_maquinas.numero,
	vw_maquinas.nome,
	vw_maquinas.id_ultima_leitura,
	leitura.`data`
FROM
	vw_maquinas
INNER JOIN
	leitura
ON
	vw_maquinas.id_ultima_leitura = leitura.id_leitura
WHERE
	vw_maquinas.excluido = 'N'
AND
	vw_maquinas.id_ultima_leitura > 1
AND
	". $whr ."
ORDER BY
	vw_maquinas.id_ultima_leitura
LIMIT
	10
	";	

	


$query_maq_sin_leitura=@mysql_query($sql_maq_sin_leitura);
$limitRegistros = mysql_num_rows($query_maq_sin_leitura);



/*
//verifica se é master
if($_SESSION['usr_nivel'] == 1)
{*/
		
?>

<div class="dashboard">
	<div class="row">
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-6">
			<div class="panel first">
				<div class="panel-heading">
					<i class="fa fa-tachometer"></i> <?php echo _('Máquinas sin lectura') ?>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table id="tabelaMaquinas" class="table table-striped table-hover">
							<thead>
								<tr>
									<th><a href="#"><?php echo _('Máquina') ?></a></th>
									<th class="center-align"><a href="#"><?php echo _('Nombre del Local') ?></a></th>
									<th class="center-align"><a href="#"><?php echo _('Última Lectura') ?></a></th>
									<th class="center-align"><a href="#"><?php echo _('Acciones') ?></a></th>
								</tr>
							</thead>
							<tbody>
                            
							<?php
								while($res_maq_sin_leitura=@mysql_fetch_assoc($query_maq_sin_leitura)) 
								{
									echo "<tr>";
									echo "<td>".$res_maq_sin_leitura['numero']."</td>";
									echo "<td class='center-align'>".$res_maq_sin_leitura['nome']."</td>";
									echo "<td class='center-align'>".date("d-m-Y", strtotime($res_maq_sin_leitura['data']))."</td>";
									echo "<td class='center-align'>
										<a href='#' id='btnVer_".$res_maq_sin_leitura['id_maquina']."' class='btn btn-raised btn-sm' data-toggle='modal' data-target='#maqnolectura-modal' onclick='alimentaModal(this);'> Ver </a>
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
		<!-- Panel dashboard 01 
		<div class="col-xs-12 col-md-6">
			<div class="panel second">
				<div class="panel-heading">
					<i class="fa fa-line-chart"></i> <?php echo _('Ingreso por local de la última semana') ?>
				</div>
				<div class="panel-body">
					<div id="graph-incomes" class="graphitem"></div>
				</div>
			</div>
		</div>-->
        
        <!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-6">
			<div class="panel second">
				<div class="panel-heading">
					<i class="fa fa-building-o"></i> <?php echo _('Locales: &nbsp; Acumulados / Status') ?>
				</div>
        
        
        
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th colspan="2"><a ><?php echo _('Locales') ?></a></th>
                                    <th><a ><?php echo _('Acumulado Max') ?></a></th>
									<th><a ><?php echo _('Acu Sistema') ?></a></th>
                                    <th class="right-align"><a ><?php echo _('En línea') ?></a></th>
								</tr>
							</thead>
                            <tbody>
                            <?php
								//verifica se é master
								if($_SESSION['usr_nivel'] == 1)
								{
									$whr = " 1 = 1 ";
								}
								else
								{
									$whr = " (local.id_login = ". $_SESSION['id_login'] ." OR  local.id_gerente = " . $_SESSION['id_login'] ." OR  local.id_admin = " . $_SESSION['id_login'] . ")";	
								}								
							
							
								//consulta locais integrados
								$sql_loc_inte = "SELECT locais_integrados.*, local.nome FROM locais_integrados INNER JOIN `local` ON locais_integrados.id_local = `local`.id_local WHERE " . $whr;
								$query_loc_inte=@mysql_query($sql_loc_inte);
								
								//
								while($res_loc_inte=@mysql_fetch_assoc($query_loc_inte)) 
								{			
													
									//consulta o nome do local
									$sql_nome_local = "SELECT nome FROM local WHERE id_local = " . $res_loc_inte['id_local'];
									$query_nome_local=@mysql_query($sql_nome_local);
									$res_nome_local=@mysql_fetch_assoc($query_nome_local);
									
									echo "<tr>";
									echo "<td colspan='2'>".$res_nome_local['nome']."</td>";
									echo "<td><strong>$";
									?>
                                    
									<span id="acuMax_<?php echo $res_loc_inte['id_local']; ?>" style="font-size:11px;">0</span>
									
									<?php
									echo "</strong></td>";
									
									echo "<td><strong>$";
									?>
                                    
									<span id="acu_<?php echo $res_loc_inte['id_local']; ?>" style="font-size:13px;">0</span>
									
									<?php
									echo "</strong></td>";									
									
									echo "<td class='right-align'><img id='img_status_".$res_loc_inte['id_local']."' src='img/load.gif' width='32'></td>";
									echo "</tr>";
									echo "<input type='hidden' id='hd_".$res_loc_inte['id_local']."' name='hd_".$res_loc_inte['id_local']."' value='' /> \n";
									
								}								
							?>
							</tbody>
						</table>
					</div>
				</div>
        
               
			</div>
		</div>
        

		<?php
			//consulta lucro locais integrados
			$sql_res_locInte = "SELECT 
									locais_integrados.id_local
								FROM 
									locais_integrados"; 
									
			//
			$query_res_locInte=@mysql_query($sql_res_locInte);  
									
			//	
			$contGrafico = '';	
			$subTotLocal = 0;				
			while($res_res_locInte=@mysql_fetch_assoc($query_res_locInte))
			{
				//consulta nome do local.
				$sql_nome_int = "SELECT nome FROM local WHERE id_local = " . $res_res_locInte['id_local'];
				$qry_nome_int=@mysql_query($sql_nome_int);
				$res_nome_int=@mysql_fetch_assoc($qry_nome_int);
				
				//consulta valores de entrada atual. 
				$sql_info_total_atual = "SELECT
											SUM(entrada_oficial) - SUM(saida_oficial) as subTotLocal
										FROM
											maquinas
										WHERE
											id_local = " . $res_res_locInte['id_local'];

				$qry_info_total_atual=@mysql_query($sql_info_total_atual);
				$res_info_total_atual=@mysql_fetch_assoc($qry_info_total_atual);
				
				//
				$subTotAtu = $res_info_total_atual['subTotLocal'];
				
				//consulta todas as dongles desse local.
				$sql_todasDongles = "SELECT
										interface.numero
									FROM
										interface
									INNER JOIN
										maquinas
									ON
										interface.id_maquina = maquinas.id_maquina
									WHERE
										maquinas.id_local = " . $res_res_locInte['id_local'];
				
				$qry_todasDongle=@mysql_query($sql_todasDongles);

				
				
				//
				while($res_todasDongles=@mysql_fetch_assoc($qry_todasDongle))
				{
					include('conn/connIntegration.php');
					//echo $res_todasDongles['numero'] . "//";
					//consulta valor individual de cada dongle.
					$sql_subTotDongle = "SELECT
											creditIn - creditOut as subDongle
										FROM
											Statistic
										WHERE
											id = " . $res_todasDongles['numero'];
					$qry_subTotDongle=@mysql_query($sql_subTotDongle);
					$res_subTotDongle=@mysql_fetch_assoc($qry_subTotDongle);
					
					
					//echo $res_subTotDongle['subDongle'] . "<br />";
					
					
					//soma dongles desse local
					$subTotLocal = $subTotLocal + $res_subTotDongle['subDongle'];
					
					//reconecta no calasys
					include('conn/conn.php');					

				}			
				
				//verificar aqui *Erico - nao soma o que nao ém dongle.	
				//echo "antigo: " . $subTotAtu . "// ";
				//echo "novo: " . $subTotLocal . "<br />";
				
				$subTotLocal = 0;
				
				
				
				
				
				/*
				//busca novos valores 
				//conecta no banco da dongle.
				//session_start();
				include('conn/connDongle.php.php');
				
				$sql_dadoDongle = "select * from StreetDongle where MachineId = " . $res_res_locInte['numero'];
				
				
				echo $sql_dadoDongle . "<br />";
				
				
				$contGrafico .= "{
								name: '".$res_nome_int['nome']."',
								y: ".$res_info_total_atual['subTotLocal'].",
								drilldown: '".$res_nome_int['nome']."'
							},";	*/		
			}
	
	
			if($_SESSION['id_login']==11)
			{
			  
        ?>

        
        
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-6">
			<div class="panel fourth">
				<div class="panel-heading">
					<i class="fa fa-bar-chart"></i> <?php echo _('Resumen Locales Integrados Diario') ?>
				</div>
				<div class="panel-body">
					<div id="graph-resultado-locInt" class="graphitem"></div>
				</div>
			</div>
		</div> 
        
        
        <?php 
		
			}
		
		?>
               
	</div>
	</div>
</div>

<?php
//}

?>

<script type="text/javascript">

	//declara tabela de dados	
	var table = $('#tabelaMaquinas').DataTable(
	{
		"bLengthChange": false,
		"dom": '<"top">rt<"bottom"l><"clear">',
		//"dom": 'Brtip', * B para aparecer os botoes	
		aoColumnDefs:[
			{
			'bSortable' : false,
			'aTargets' : [ 3 ]
			}
		]		
	});
	
	
	//alimenta numero do disp no modal.
	function alimentaModal(obj)
	{
		var idDisp = obj.id;

		arrayDados = idDisp.split("_");
		
		idDisp = arrayDados[1];
		
		$('#numDisp').text(idDisp);
		
		//consulta dados desse dispositivo
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_dados_sem_leitura.php', // Informo a URL que será pesquisada.
			data: 'id='+idDisp,
			success: function(html)
			{
				arrayDados = html.split(",");
				
				numMaquina = arrayDados[0];
				numDisp = arrayDados[1];
				tipoDisp = arrayDados[2];
				periodo = arrayDados[3];
				dataExp = arrayDados[4];
				ope = arrayDados[5];
				jogo = arrayDados[6];


				$('#numMaq').text(numMaquina);
				$('#numDisp').text(numDisp);
				$('#tpDisp').text(tipoDisp);
				$('#periodoVal').text(periodo);
				$('#dtExpDisp').text(dataExp);
				$('#opeDisp').text(ope);
				$('#jogoDisp').text(jogo);
			}
		});		
	}
	
	
	
	setInterval(function()
	{
		//consulta dados desse dispositivo
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_acu_locais.php', // Informo a URL que será pesquisada.
			data: '',
			success: function(html)
			{
				
				//alert(html);
				dadosLocal = html.split("|");
				
				limit = eval(dadosLocal.length) - 1;
				
				//alert(limit);
				
				//
				for (var i = 0; i < limit; i++) 
				{
					dados = dadosLocal[i].split(",");
					
					idLocal = dados[0];
					acuAtual = dados[1];
					jkptAtual = dados[3];
					acuMax = dados[2];
					//alert(dadosLocal[i]);
					
					$('#acu_'+idLocal).text(acuAtual);
					$('#acuMax_'+idLocal).text(acuMax);
					//$('#jPot_'+idLocal).text(jkptAtual);
				}
				
			}
		});	
	}, 	10000); // 10 segundos
	

	//
	setTimeout(function()
	{
		//consulta dados desse dispositivo
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_online_statusLocal.php', // Informo a URL que será pesquisada.
			data: '',
			success: function(html)
			{
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
		
					$('#hd_'+idLocal).attr("value", upTimeNovo);										
					
					//alert(idLocal + " // " + upTime + " // " + upTimeNovo);
				}
			}
		});	
	}, 	5000); // 5 segundos		*/
	
	
	//
	setTimeout(function()
	{
		veriStatus();
	}, 	5000); // 38 segundos	


	//
	setInterval(function()
	{
		veriStatus();
	}, 	38000); // 38 segundos	
	
	
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
		

					//alert(idLocal + "//" + upTimeNovo + "//" + upTime);
					
					if(upTimeNovo > upTime)
					{
						$('#img_status_'+idLocal).attr('src','img/greenball.png');	
					}
					else
					{
						//alert("offline");
						$('#img_status_'+idLocal).attr('src','img/redball.png');	
					}
					$('#hd_'+idLocal).attr("value", upTimeNovo);										
					
					//alert(idLocal + " // " + upTime + " // " + upTimeNovo);
				}
			}
		});		
	}
	
	
	
	
	
	//gráfico 2
	$('#graph-resultado-locInt').highcharts({
        chart: {
            type: 'column'
        },
        title: {
            text: '31, Julio 2017'
        },
        /*subtitle: {
            text: 'Click the columns to view versions. Source: <a href="http://netmarketshare.com">netmarketshare.com</a>.'
        },*/
        xAxis: {
            type: 'category'
        },
        yAxis: {
            title: {
                text: 'SubTotales Locales'
            }

        },
        legend: {
            enabled: false
        },
        plotOptions: {
            series: {
                borderWidth: 0,
                dataLabels: {
                    enabled: true,
                    format: '{point.y:,f}'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}</b> of total<br/>'
        },

        series: [{
            name: "Brands",
            colorByPoint: true,
            data: [<?php echo $contGrafico;?>]
        }]
    });	
	
</script>