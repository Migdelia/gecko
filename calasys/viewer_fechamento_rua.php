<?php

session_start();

include('conn/conn.php');

include('functions/functions.php');

include('functions/lg_validador.php');

unset($_SESSION['campos']);

$id_fechamento = $_GET['id'];



//formatar numero para casas de mil

//number_format($dados_ult_ent['valor_entrada_total'],0,"",".")



//Definindo em qual aba devera ficar o campo retornado na select

$abas = array(

	'Local'			=>'Fechamento',

	'Maquinas'			=>'Fechamento'



);





//Montando as Abas

$itens_guia = array_count_values($abas);

$guias="\n\t\t\t<ul>";

$guias_cont="";

$cont=1;

$jquery_jed="";









foreach($itens_guia as $key=>$val) {

	//Montando as Guias das Abas

	$guias.="\n\t\t\t\t<li><a href='#tabs-".$cont."'>".$key."</a></li>";

	//Montando o Conteudo de Cada Aba

	$guias_cont.="\n\t\t\t<div id='tabs-".$cont."'>";





	//monta o form

	$guias_cont.="\n\t\t\t\t<form name='create_leitura' id='create_leitura' action='add_leitura.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";

	

	

	//Reponsavel por Montar o Quadro de Historico das leitura

	if ($key=='Fechamento') {	

	

	//Montando a Tabela com os dados que a aba dever� possuir

	$guias_cont.="\n\t\t\t\t<table border='1' width='100%' bordercolor='#000000' style='border-collapse: collapse' align='center'>";

	





	//consulta todos os dados desse fechamento

	$sql_fecha = "

		SELECT

			fechamento.data_fechamento,

			logins.nome as responsavel

		FROM

			fechamento

		INNER JOIN

			logins

		ON

			fechamento.id_login = logins.id_login

		WHERE

			fechamento.id_fechamento = '".$id_fechamento."'

		";

	$query_fecha=@mysql_query($sql_fecha);

	$resultado_fecha=@mysql_fetch_assoc($query_fecha);

	



	

	//declara o ano da leitura

	$ano = date("Y", strtotime($resultado_fecha['data_fechamento']));

	

	//declara a data do fechamento

	$data = date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));

	

	//consulta responsavel leitura

	$sql_responsa = "

		SELECT

			`local`.id_login,

			leitura.semana,

			leitura.data_fechamento,

			logins.nome,
			
			leitura.pct_operador,
			
			leitura.id_local

		FROM

			`local`

		INNER JOIN logins ON `local`.id_login = logins.id_login

		INNER JOIN `leitura` ON `local`.id_local = `leitura`.id_local

		WHERE

			leitura.id_fechamento = '".$id_fechamento."'

		LIMIT

			1

		";

	$query_responsa=@mysql_query($sql_responsa);

	$resultado_responsa=@mysql_fetch_assoc($query_responsa);	



	//echo $sql_responsa;



	//declara a data do fechamento

	$data_fechamento = date("d-m-Y", strtotime($resultado_responsa['data_fechamento']));

	$semana_fechamento = $resultado_responsa['semana'];

	

	//declara o nome do responsavel

	$resp = $resultado_responsa['nome'];

	$id_resp = $resultado_responsa['id_login'];

	

	

	

	//SOMA TODAS AS DESPESAS do FECHAMENTO

	$sql_dif_fecha = "

		SELECT

			desconto_leit_fecha.valor_desconto

		FROM

			desconto_leit_fecha

		INNER JOIN

			leitura

		ON

			desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura

		WHERE

			leitura.id_fechamento = '".$id_fechamento."'

		AND

			desconto_leit_fecha.leitura = 1

		AND

			desconto_leit_fecha.id_maquina = 0	

		";

	$query_dif_fecha=@mysql_query($sql_dif_fecha);

	$resultado_dif_fecha=@mysql_fetch_assoc($query_dif_fecha);

	



	

	//lista todos os deves recebidos desse faturamento agrupados por local //CONTINUAR DAQUIII

	$sql_dev_rec = "

		SELECT

			SUM(deve.valor_recebido) as deve_recebido,

			`local`.nome,

			leitura.`data`

		FROM

			leitura

		INNER JOIN

			deve

		ON

			leitura.id_leitura = deve.id_leitura

		INNER JOIN

			`local`

		ON

			leitura.id_local = `local`.id_local

		WHERE

			leitura.id_fechamento = '".$id_fechamento."'

		AND 

			deve.valor_recebido != 0

			";

	$query_dev_rec=@mysql_query($sql_dev_rec);	

	$resultado_dev_rec=@mysql_fetch_assoc($query_dev_rec);

	

	//Declara valor de deve recebido

	$deve_rec = $resultado_dev_rec['deve_recebido'];

	
	//
	if($_SESSION['id_nivel'] == 8)
	{
		$id_resp == $_SESSION['id_login'];
	}
	
	//echo $resultado_responsa['id_local'] . "<br />";
	
	
	if($resultado_responsa['id_local'] == 223)
	{
		
		
		
	//consulta os dados das leituras desse fechamento
	$sql_leit = "

			SELECT

				leitura.id_leitura,

				leitura.`data`,

				`local`.nome AS nome_cidade,

				leitura.fat_bruto AS fat_cidade,

				leitura.id_leitura,

				leitura.pct_local as percentual,

				leitura.id_tipo_local as id_tp_local,

				leitura.id_local,

				leitura.pct_operador,

				leitura.pct_gerente,				

				'leit_norm' AS status,

				(

					SELECT

						(

							sum(`lpm`.`valor_entrada`)- sum(`lpm`.`valor_saida`)

						)

					FROM

						(

							`leitura_por_maquina` `lpm`

							JOIN `maquinas` ON(

								(

									`lpm`.`id_maquina` = `maquinas`.`id_maquina`

								)

							)

						)

					WHERE

						(

							(

								`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`

							)

							AND(`maquinas`.`porc_socio` <> 0)

						)

					GROUP BY

						`lpm`.`id_leitura`

				)AS `faturamento_socio`

			FROM

				leitura

			INNER JOIN

				`local`

			ON

				leitura.id_local = `local`.id_local

			INNER JOIN

				leitura_por_maquina

			ON

				leitura.id_leitura = leitura_por_maquina.id_leitura

			WHERE

				leitura.id_fechamento = '".$id_fechamento."'
	
		GROUP BY

			leitura.id_leitura			

		";		
	}
	else
	{

	
	
		//consulta os dados das leituras desse fechamento
		$sql_leit = "
	
				SELECT
	
					leitura.id_leitura,
	
					leitura.`data`,
	
					`local`.nome AS nome_cidade,
	
					leitura.fat_bruto AS fat_cidade,
	
					leitura.id_leitura,
	
					leitura.pct_local as percentual,
	
					leitura.id_tipo_local as id_tp_local,
	
					leitura.id_local,
	
					leitura.pct_operador,
	
					leitura.pct_gerente,				
	
					'leit_norm' AS status,
	
					(
	
						SELECT
	
							(
	
								sum(`lpm`.`valor_entrada`)- sum(`lpm`.`valor_saida`)
	
							)
	
						FROM
	
							(
	
								`leitura_por_maquina` `lpm`
	
								JOIN `maquinas` ON(
	
									(
	
										`lpm`.`id_maquina` = `maquinas`.`id_maquina`
	
									)
	
								)
	
							)
	
						WHERE
	
							(
	
								(
	
									`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`
	
								)
	
								AND(`maquinas`.`porc_socio` <> 0)
	
							)
	
						GROUP BY
	
							`lpm`.`id_leitura`
	
					)AS `faturamento_socio`
	
				FROM
	
					leitura
	
				INNER JOIN
	
					`local`
	
				ON
	
					leitura.id_local = `local`.id_local
	
				INNER JOIN
	
					leitura_por_maquina
	
				ON
	
					leitura.id_leitura = leitura_por_maquina.id_leitura
	
				WHERE
	
					leitura.id_fechamento = '".$id_fechamento."'
	
			
	
			UNION
	
			
	
				SELECT
	
					leitura.id_leitura,
	
					leitura.`data`,
	
					`local`.nome AS nome_cidade,
	
					leitura.fat_bruto AS fat_cidade,
	
					leitura.id_leitura,
	
					leitura.pct_local as percentual,
	
					leitura.id_tipo_local as id_tp_local,
	
					leitura.id_local,
	
					leitura.pct_operador,
	
					leitura.pct_gerente,				
	
					'leit_ext' AS status,
	
					(
	
						SELECT
	
							(
	
								sum(`lpm`.`valor_entrada`)- sum(`lpm`.`valor_saida`)
	
							)
	
						FROM
	
							(
	
								`leitura_por_maquina` `lpm`
	
								JOIN `maquinas` ON(
	
									(
	
										`lpm`.`id_maquina` = `maquinas`.`id_maquina`
	
									)
	
								)
	
							)
	
						WHERE
	
							(
	
								(
	
									`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`
	
								)
	
								AND(`maquinas`.`porc_socio` <> 0)
	
							)
	
						GROUP BY
	
							`lpm`.`id_leitura`
	
					)AS `faturamento_socio`
	
				FROM
	
					leitura
	
				INNER JOIN
	
					`local`
	
				ON
	
					leitura.id_local = `local`.id_local
	
				INNER JOIN
	
					leitura_por_maquina
	
				ON
	
					leitura.id_leitura = leitura_por_maquina.id_leitura
	
				WHERE
	
					leitura.id_operador = " . $id_resp ."
	
				AND
	
					leitura.data_fechamento = '". $resultado_responsa['data_fechamento'] ."'
	
				AND
	
					leitura.id_tipo_local <> 1
	
				AND
	
					leitura.fechada = 1	
	
			GROUP BY
	
				leitura.id_leitura			
	
			";
			
		
	}
			

	$query_leit=@mysql_query($sql_leit);

	//$resultado_leit=@mysql_fetch_assoc($query_leit);



	//echo $sql_leit . "<br /><br />";



	//soma todos os descontos das leituras desse fechamento.

	$sql_desc_leit = "

		SELECT

			SUM(desconto_leit_fecha.valor_desconto) as tot_desc_leit

		FROM

			desconto_leit_fecha

		INNER JOIN

			leitura

		ON

			desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura

		WHERE

			leitura.id_fechamento = '".$id_fechamento."'

		AND

			desconto_leit_fecha.leitura = 1

		";

	$query_desc_leit=@mysql_query($sql_desc_leit);

	$resultado_desc_leit=@mysql_fetch_assoc($query_desc_leit);







	

	//soma todos os descontos desse fechamento.

	$sql_desc_fecha = "

		SELECT

			SUM(desconto_leit_fecha.valor_desconto) as tot_desc_fecha

		FROM

			desconto_leit_fecha

		WHERE

			desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'

		AND

			desconto_leit_fecha.fechamento = 1

		";

	$query_desc_fecha=@mysql_query($sql_desc_fecha);

	$resultado_desc_fecha=@mysql_fetch_assoc($query_desc_fecha);	





	//declara o total de descontos

	$tot_desc_leit = 0;

	$tot_desc_leit = $resultado_desc_leit['tot_desc_leit'];

	

	$tot_desc_fecha = 0;

	$tot_desc_fecha = $resultado_desc_fecha['tot_desc_fecha'];





	$tot_gastos = $tot_desc_leit + $tot_desc_fecha;





	//SOMA TODOS DEVES DESSE FECHAMENTO

	$sql_deve = "

		SELECT

			SUM(deve.valor)AS deve

		FROM

			deve

		INNER JOIN

			leitura

		ON

			deve.id_leitura = leitura.id_leitura

		WHERE

			leitura.id_fechamento = '".$id_fechamento."'

		";

	$query_deve=@mysql_query($sql_deve);

	$resultado_deve=@mysql_fetch_assoc($query_deve);



	//echo $sql_deve;



	//atribui o deve ao total de descontos

	$tot_descontos_geral = $tot_gastos + $resultado_deve['deve'];

	



	//lista todos as despesas desse faturamento agrupados por cidade

	/*

	$sql_gastos_geral = "

	

		SELECT

			desconto_leit_fecha.data_desconto,

			desconto_leit_fecha.valor_desconto,

			'Rend Lectura' as origem

		FROM

			desconto_leit_fecha

		INNER JOIN

			leitura

		ON

			desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura

		WHERE

			leitura.id_fechamento = '".$id_fechamento."'

		AND

			desconto_leit_fecha.leitura = 1

		AND

			desconto_leit_fecha.id_maquina = 0

			

	UNION

		

		SELECT

			desconto_leit_fecha.data_desconto,

			desconto_leit_fecha.valor_desconto,

			'Rend Fechamento' as origem

		FROM

			desconto_leit_fecha			

		WHERE

			desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'

		AND

			desconto_leit_fecha.fechamento = 1		

		

		";

	$query_gastos_geral=@mysql_query($sql_gastos_geral);

	*/

	$sql_gastos_geral = "

		SELECT

			desconto_leit_fecha.data_desconto,

			desconto_leit_fecha.valor_desconto,

			'Rend Fechamento' as origem

		FROM

			desconto_leit_fecha			

		WHERE

			desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'

		AND

			desconto_leit_fecha.fechamento = 1		

		

		";

	$query_gastos_geral=@mysql_query($sql_gastos_geral);	





	//lista todos os deves desse fechamento agrupados por local //CONTINUAR DAQUIII

	$sql_dev_detalhe = "

		SELECT

			deve.valor_recebido,

			`local`.nome,

			leitura.`data`

		FROM

			leitura

		INNER JOIN `local` ON leitura.id_local = `local`.id_local

		INNER JOIN deve ON leitura.id_leitura = deve.id_leitura

		WHERE

			leitura.id_fechamento = '".$id_fechamento."'

		AND

			deve.valor_recebido <> 0

		";

	$query_dev_detalhe=@mysql_query($sql_dev_detalhe);



	/*

	//busca detalhe de pagamento desse fechamento

	$sql_forma_pago = "

		SELECT

			*

		FROM

			pago_fechamento

		WHERE

			id_fechamento = '".$id_fechamento."'

		";

	$query_forma_pago=@mysql_query($sql_forma_pago);	

	*/









	//declara total a pagar

	$total_pagar = 0;

	$total_pagar = $tot_ent - $tot_descontos_geral;

	

	

	/// ------------------------- MONTAR AQUI FECHAMENTO ---------------------------------

	/// --------------------------------------------------------------------------------

	//colspan='11'

	

	

$guias_cont.="\n\t\t\t\t<tr height='50' bgcolor='#c6efce' style='font-size:18px; color:#00802d;'>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='11'>";

		$guias_cont.="\n\t\t\t\t<strong>Fechamento Semana: " . $semana_fechamento . " de " . date("M-Y", strtotime($data_fechamento)) . "</strong>";

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";



$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-size:14px;'>";

	$guias_cont.="\n\t\t\t\t<td align='right' colspan='11'>";

		$guias_cont.="\n\t\t\t\t<font color='#00802d' size='4'> Fecha Realizado: </font> &nbsp;<strong>" . $data. "</strong> &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";

	

$guias_cont.="\n\t\t\t\t<tr>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' rowspan='2' bgcolor='#92d050'>";

		$guias_cont.="\n\t\t\t\tResponsavel &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='2' rowspan='2' bgcolor='#FFFFFF'>";

		$guias_cont.="\n\t\t\t\t" . $resp;

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' rowspan='2'>";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";	

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='1' rowspan='2' bgcolor='#ffff00'>";

		$guias_cont.="\n\t\t\t\t <br />Total a pagar: <strong>$</strong>"."<input id='total_final' value='' size='8' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:13px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  ><br />&nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

	/*

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='2' bgcolor='#FFFFFF'>";

		$guias_cont.="\n\t\t\t\t\t\t Total&nbsp;Especie: " . "<input id='total_a_pagar' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";

	$guias_cont.="\n\t\t\t\t</td>";	

	*/		

$guias_cont.="\n\t\t\t\t</tr>";



$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='12'>";

		$guias_cont.="\n\t\t\t\t &nbsp; ";	

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";

/*

$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='12'>";

		$guias_cont.="\n\t\t\t\t Total de Dep: ";

		$guias_cont.="\n\t\t\t\t\t\t " . "<input id='total_de_dep' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";		

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";

*/

$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='12'>";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";



$guias_cont.="\n\t\t\t\t<tr>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='11' bgcolor='#92d050'>";

		$guias_cont.="\n\t\t\t\t General";

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";



$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='11'>";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";



$guias_cont.="\n\t\t\t\t<tr>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#f2f2f2'>";

		$guias_cont.="\n\t\t\t\t Lectura";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='2' bgcolor='#FFFFFF'>";

		$guias_cont.="\n\t\t\t\t $" . "<input id='vl_leituras' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";

	$guias_cont.="\n\t\t\t\t</td>";	

	$guias_cont.="\n\t\t\t\t<td align='center'>";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#e6b9b8'>";

		$guias_cont.="\n\t\t\t\t Salidas";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#FFFFFF'>";

		$guias_cont.="\n\t\t\t\t\t\t" . "<input id='total_parc_saidas' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";

	$guias_cont.="\n\t\t\t\t</td>";		

$guias_cont.="\n\t\t\t\t</tr>";

$guias_cont.="\n\t\t\t\t<tr>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#f2f2f2'>";

		$guias_cont.="\n\t\t\t\t Debes Recebidos";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t $ " . "<input id='vl_fn_dev_rec' value='".number_format($deve_rec,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";

	$guias_cont.="\n\t\t\t\t</td>";	

	$guias_cont.="\n\t\t\t\t<td align='center'>";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#e6b9b8'>";

		$guias_cont.="\n\t\t\t\t Depositos";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t\t\t" . "<input id='total_geral_dep' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";

	$guias_cont.="\n\t\t\t\t</td>";		

$guias_cont.="\n\t\t\t\t</tr>";

$guias_cont.="\n\t\t\t\t<tr>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#ccccff'>";

		$guias_cont.="\n\t\t\t\t TOT ENTRADA";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='2' bgcolor='#FFFFFF'>";

		//$guias_cont.="\n\t\t\t\t $ " . number_format($tot_ent,0,"",".");

		$guias_cont.="\n\t\t\t\t\t\t $"."<input id='total_geral_entradas' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";

	$guias_cont.="\n\t\t\t\t</td>";	

	$guias_cont.="\n\t\t\t\t<td align='center'>";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#d99795'>";

		$guias_cont.="\n\t\t\t\t Valor Salida";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t\t\t" . "<input id='total_geral_saidas' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";

	$guias_cont.="\n\t\t\t\t</td>";		

$guias_cont.="\n\t\t\t\t</tr>";



$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='11'>";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";





$guias_cont.="\n\t\t\t\t<tr>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='5'>";

	

		//comeco da entrada de Lecturas

		$guias_cont.="\n\t\t\t\t<table border='1' width='100%' bordercolor='#000000' style='border-collapse: collapse'>";

			$guias_cont.="\n\t\t\t\t<tr>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='5' bgcolor='#e5e0ec'>";

					$guias_cont.="\n\t\t\t\t ENTRADAS Lecturas";

				$guias_cont.="\n\t\t\t\t</td>";					

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#ccccff'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";			

				$guias_cont.="\n\t\t\t\t<td align='center' >";

					$guias_cont.="\n\t\t\t\t efetivo";

				$guias_cont.="\n\t\t\t\t</td>";

				/*

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t cheque";

				$guias_cont.="\n\t\t\t\t</td>";

				*/									

			$guias_cont.="\n\t\t\t\t</tr>";			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#ccccff'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Fecha";

				$guias_cont.="\n\t\t\t\t</td>";	

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Descricion";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Monto";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";

				/*

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Monto";

				$guias_cont.="\n\t\t\t\t</td>";			

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Fecha";

				$guias_cont.="\n\t\t\t\t</td>";

				*/																				

			$guias_cont.="\n\t\t\t\t</tr>";

			

			//declara o subtotal das leituras

			$sub_total = 0;

			$sub_tot_efetivo = 0;

			$vl_tot_fn_fat_loc = 0;

			

			

			//efetuar um loop nos resultados de entradas leit

			while ($dados_leit=@mysql_fetch_assoc($query_leit))  //aquii

			{





				//CONSULTA MAQUINAS COM PORCENTAGEM ESPECIAL

				$sql_porc_esp = "

					SELECT

						(

							sum(

								leitura_por_maquina.valor_entrada

							)- sum(

								leitura_por_maquina.valor_saida

							)

						)AS faturamento,

						leitura_por_maquina.pct_esp_maq as porc_maquina

					FROM

						leitura_por_maquina

					INNER JOIN maquinas ON leitura_por_maquina.id_maquina = maquinas.id_maquina

					

					WHERE

						leitura_por_maquina.id_leitura = '".$dados_leit['id_leitura']."'

					AND 

						leitura_por_maquina.pct_esp_maq <> 0	

				";

				$query_porc_esp = @mysql_query($sql_porc_esp);

				$res_porc_esp=@mysql_fetch_assoc($query_porc_esp);

			



				//consulta diferenca

				$sql_dif = "

					SELECT

						SUM(desconto_leit_fecha.valor_desconto) as valor_desconto

					FROM

						desconto_leit_fecha

					WHERE

						desconto_leit_fecha.id_maquina <> 0

					AND

						desconto_leit_fecha.id_leitura_fechamento = '".$dados_leit['id_leitura']."'

					AND

						desconto_leit_fecha.leitura = 1		

				";

				$query_dif = @mysql_query($sql_dif);

				$res_dif=@mysql_fetch_assoc($query_dif);



				//echo $dados_leit['status'] . "<br />";



				if($dados_leit['status'] == "leit_ext")

				{

					//echo "maquina externa";

					if($dados_leit['id_tp_local'] == 4)

					{

						$fat_cidade = ($dados_leit['fat_cidade'] * 20) / 100;

						//$fat_cidade = (($dados_leit['fat_cidade'] - $res_dif['valor_desconto'])* 20) / 100; * comentado 28-04-2015

						//$fat_leit_ext = ($dados_leit['fat_cidade'] * 20) / 100;

					}

					else

					{

						//subtrair faturamento dessas maquinas do faturamento do local

						$fat_cidade = $dados_leit['fat_cidade'];

						$fat_cidade = $fat_cidade - $res_dif['valor_desconto'];

						$fat_cidade = $fat_cidade - $res_porc_esp['faturamento'];	

						$fat_cidade = $fat_cidade - $dados_leit['faturamento_socio'];

						$fat_cidade = ($fat_cidade * 20 ) / 100;

						

						//consulta faturamento das maquinas de calabaza desse leitura.

						//$fat_leit_ext = $dados_leit['fat_cidade'] - $dados_leit['faturamento_socio'];

						//$fat_leit_ext = ($fat_leit_ext * 20) / 100;														

					}			

				}

				else

				{

				

					//se o local tiver maquinas com porcentagem especial

					if($res_porc_esp['faturamento'] == "")
					{

						$fat_cidade = $dados_leit['fat_cidade'] - $res_dif['valor_desconto']; /// aqui ERICO

						//echo $res_dif['valor_desconto'];

					}

					else

					{

						

						//subtrair faturamento dessas maquinas do faturamento do local

						$fat_cidade = $dados_leit['fat_cidade'] - $res_dif['valor_desconto'];

						$fat_cidade = $fat_cidade - $res_porc_esp['faturamento'];

					}				

				
				}







			



				/*

				

				//verifica se tem diferenca

				if($dados_leit['status'] !== "leit_ext")

				{

					if($res_dif['valor_desconto'] == "")

					{

						$fat_cidade = $fat_cidade;

					}

					else

					{

						$fat_cidade = $fat_cidade - $res_dif['valor_desconto'];

					}

				}

				else

				{

					$fat_cidade = $fat_cidade - $res_dif['valor_desconto'];

				}

				echo $fat_cidade . "<br />";

				*/

				

				if($dados_leit['id_local'] !== '101')

				{
					
						//SOMA TODAS despesas da leitura

						$sql_desp_leit = "

							SELECT

								SUM(desconto_leit_fecha.valor_desconto) AS valor_desconto

							FROM

								desconto_leit_fecha

							WHERE

								desconto_leit_fecha.id_leitura_fechamento = '".$dados_leit['id_leitura']."'

							AND

								desconto_leit_fecha.leitura = 1

							AND

								desconto_leit_fecha.id_maquina = 0	

							";

						$query_desp_leit=@mysql_query($sql_desp_leit);

						$resultado_desp_leit=@mysql_fetch_assoc($query_desp_leit);	


						//desconto
						if($resultado_desp_leit['valor_desconto'] > 0)
						{
							//diferenca * $res_dif['valor_desconto']
							if($res_dif['valor_desconto'] <> 0)
							{
								$corLinha = "#FF0000";	
							}
							else
							{
								$corLinha = "#FF9900";	
							}							
						}
						else
						{
							//diferenca * $res_dif['valor_desconto']
							if($res_dif['valor_desconto'] <> 0)
							{
								$corLinha = "#FFFF00";	
							}
							else
							{
								$corLinha = "#FFFFFF";	
							}	
						}
						
						
					
					

					$guias_cont.="\n\t\t\t\t<tr bgcolor='".$corLinha."'>";

						$guias_cont.="\n\t\t\t\t<td align='center'>";

							$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_leit['data'])). " &nbsp; <strong><a href='detalhes_leitura.php?id=".$dados_leit['id_leitura']."'>(" . $dados_leit['id_leitura'] . ")</a></strong>";

						$guias_cont.="\n\t\t\t\t </td>";

						$guias_cont.="\n\t\t\t\t<td align='center'>";

							if($dados_leit['status'] == "leit_ext")

							{

								$guias_cont.="\n\t\t\t\t " . $dados_leit['nome_cidade'] . " (20 % Calabaza)";

							}

							else

							{

								$guias_cont.="\n\t\t\t\t " . $dados_leit['nome_cidade'];

							}

						$guias_cont.="\n\t\t\t\t</td>";

						

						if($dados_leit['status'] !== "leit_ext")

						{	

							//calcula lucro local


							$vl_fat_local = ($fat_cidade * $dados_leit['percentual']) / 100;

							

							//se o local tiver maquinas com porcentagem especial

							if($res_porc_esp['faturamento'] == "")

							{

								$vl_fat_local = $vl_fat_local;

							}

							else

							{

								//soma soh o sub total das maquinas especiais

								$sub_porc_maq_esp = (($res_porc_esp['faturamento'] * $res_porc_esp['porc_maquina']) / 100);

								$vl_fat_local = $vl_fat_local + $sub_porc_maq_esp;

								$fat_cidade = $fat_cidade + $res_porc_esp['faturamento'];

							}

												

						

							$fat_cidade = $fat_cidade - $vl_fat_local;

						}			

					

						//echo $fat_cidade . " *** <br />";



						

						//verifica se tem despesa

						if($resultado_desp_leit['valor_desconto'] == "")

						{

							$desp_leit= 0;

						}

						else

						{

							$desp_leit= $resultado_desp_leit['valor_desconto'];

						}

										

						if($dados_leit['status'] !== "leit_ext")

						{			
			
							$fat_cidade = $fat_cidade - $resultado_desp_leit['valor_desconto'];

						}

						

	

						if($dados_leit['status'] == "leit_ext")
						{

							$id_loc_ext = $dados_leit['id_local'];


							////aqui Erico
							
							if($dados_leit['id_tp_local'] == 4)

							{
								//$fat_leit_ext = (($dados_leit['fat_cidade'] - $desp_leit) * 20) / 100;
								//$fat_leit_ext = (($dados_leit['fat_cidade'] - $desp_leit - $dados_leit['faturamento_socio']) * 20) / 100;

								
								$fat_leit_ext = (($dados_leit['fat_cidade'] - $desp_leit) * 20) / 100;

								$pct_loc_ext = (($dados_leit['fat_cidade'] - $desp_leit));

							}
							
							
							if($dados_leit['id_tp_local'] == 6)

							{
								//$fat_leit_ext = (($dados_leit['fat_cidade'] - $desp_leit) * 20) / 100;
								//$fat_leit_ext = (($dados_leit['fat_cidade'] - $desp_leit - $dados_leit['faturamento_socio']) * 20) / 100;

								
								//$fat_leit_ext = (($dados_leit['fat_cidade'] - $desp_leit) * 20) / 100;

								//$pct_loc_ext = (($dados_leit['fat_cidade'] - $desp_leit));
								
								
								
			
								//consultar o valor do local dessa leitua
								$sql_vlLocalEsp = "SELECT
														ROUND(SUM((((valor_entrada - valor_saida) * pct_esp_maq) / 100)))  as pctLocal
													FROM
														leitura_por_maquina
													WHERE
														id_leitura = " . $dados_leit['id_leitura'];
								$qry_vlLocalEsp=@mysql_query($sql_vlLocalEsp);
								$res_vlLocalEsp=@mysql_fetch_assoc($qry_vlLocalEsp);
								
								//
								$fat_leit_ext = $res_vlLocalEsp['pctLocal'];	
								$pct_loc_ext = (($dados_leit['fat_cidade'] - $desp_leit));							
			
								
								

							}							

							else

							{ 
								//consulta faturamento das maquinas de calabaza desse leitura.
								//$fat_leit_ext = $dados_leit['fat_cidade'] - $dados_leit['faturamento_socio'] - $desp_leit;
								$fat_leit_ext = $dados_leit['fat_cidade'] - $desp_leit;

								$pct_loc_ext = $fat_leit_ext;
								
								//	echo $dados_leit['faturamento_socio'] . "<br />";								

								$fat_leit_ext = ($fat_leit_ext * 20) / 100;	

							}

							

							

							$guias_cont.="\n\t\t\t\t<td align='center'>";

								$guias_cont.="\n\t\t\t\t" . number_format($fat_leit_ext,0,"",".");

							$guias_cont.="\n\t\t\t\t</td>";		
							
							$fat_cidade = $fat_leit_ext;		

						}

						else

						{
							//echo $fat_cidade . "<br />";
							$guias_cont.="\n\t\t\t\t<td align='center'>";

								$guias_cont.="\n\t\t\t\t" . number_format($fat_cidade,0,"",".");

							$guias_cont.="\n\t\t\t\t</td>";					

						}

																					

					$guias_cont.="\n\t\t\t\t</tr>";		

					

					//echo $fat_cidade . "<br />";

						

					//soma os contadores

					$sub_total = $sub_total + $fat_cidade;

					$sub_tot_efetivo = $sub_tot_efetivo + $fat_cidade;

					

					//atribui o total para os locais

					$vl_tot_fn_fat_loc = $vl_tot_fn_fat_loc + $vl_fat_local;					

							

				}



				//�rico * refazer calculo de comissao por operador e gerente ****

				//calcular porcentagem de ger e ope por local de acordo as novas porceentagens

				//incrementar contador por cada comissao



				//calcula a % do cadastro.

				$nova_pct_ope = ($fat_cidade * $dados_leit['pct_operador']) / 100;

				

				$det_com.="\n\t\t\t\t<div id='div_detalhe_com' style='display:block;'><strong>";

				

				$det_com.= $dados_leit['nome_cidade'] . " : $</strong>"  .  number_format($nova_pct_ope,0,"",".") . "<br />";



				

				//echo $dados_leit['id_tp_local'] . "<br />";
				//
				/*
				if($dados_leit['id_tp_local'] == 6)
				{
					$novo_total_comissao = 0;	
				}
				else
				{
					$novo_total_comissao = $novo_total_comissao + $nova_pct_ope;	
				}*/

				$novo_total_comissao = $novo_total_comissao + $nova_pct_ope;
				

			}

			

				$det_com.="\n\t\t\t\t</div>";

			//echo "<br /><br /><br /><br />" . number_format($novo_total_comissao,0,"",".");

					

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";																						

			$guias_cont.="\n\t\t\t\t</tr>";



			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";																									

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='right' colspan='2'>";

					$guias_cont.="\n\t\t\t\t Sub Total: ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='3'>";

					$guias_cont.="\n\t\t\t\t $ " . number_format($sub_total,0,"",".");

					$guias_cont.="<input type='hidden' id='tot_leitura' value='".number_format($sub_total,0,"",".")."' />";

				$guias_cont.="\n\t\t\t\t</td>";																									

			$guias_cont.="\n\t\t\t\t</tr>";			

																					

		$guias_cont.="\n\t\t\t\t</table>";

		//fim da tabela de Entrada / leituras

		

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' >";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' align='center' colspan='5'>";





		//comeco da Saidas

		$guias_cont.="\n\t\t\t\t<table border='1' width='100%' bordercolor='#000000' style='border-collapse: collapse'>";

			$guias_cont.="\n\t\t\t\t<tr>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='5' bgcolor='#e6b9b8'>";

					$guias_cont.="\n\t\t\t\t SALIDAS";

				$guias_cont.="\n\t\t\t\t</td>";					

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#e6b9b8'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";			

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t efetivo";

				$guias_cont.="\n\t\t\t\t</td>";							

			$guias_cont.="\n\t\t\t\t</tr>";			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#e6b9b8'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Fecha";

				$guias_cont.="\n\t\t\t\t</td>";	

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Descricion";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Monto";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";																			

			$guias_cont.="\n\t\t\t\t</tr>";

			

			

			//aqui

			//efetuar um loop nos resultados de entradas leit

			$vl_tot_rend=0;

			$tot_saidas = 0;

			while ($dados_gastos_geral=@mysql_fetch_assoc($query_gastos_geral))  //aquii

			{

				$dados_gastos_geral = $dados_gastos_geral['valor_desconto'];

				$vl_tot_rend = $vl_tot_rend + $dados_gastos_geral;

			}

			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($data));

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Rendicao <strong>" .$id_fechamento ."</strong>";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t " . number_format($vl_tot_rend,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";																						

			$guias_cont.="\n\t\t\t\t</tr>";

			

			//$tot_saidas = $tot_saidas + $vl_tot_rend;

			//$tot_gastos = $tot_gastos + $vl_tot_rend;

			



			if($resultado_deve['deve']!=="0")

			{



				$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

					$guias_cont.="\n\t\t\t\t<td align='center'>";

						$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));

					$guias_cont.="\n\t\t\t\t</td>";

					$guias_cont.="\n\t\t\t\t<td align='center'>";

						$guias_cont.="\n\t\t\t\t Deve";

					$guias_cont.="\n\t\t\t\t</td>";

					$guias_cont.="\n\t\t\t\t<td align='center'>";

						$guias_cont.="\n\t\t\t\t $ " . number_format($resultado_deve['deve'],0,"",".");

					$guias_cont.="\n\t\t\t\t</td>";																	

				$guias_cont.="\n\t\t\t\t</tr>";

				

				$tot_saidas = $tot_saidas + $resultado_deve['deve'];

			

			}		





			//calcula comissao

			$com_ope = ($sub_total * $resultado_responsa['pct_operador']) / 100;

			

			//teste comissao sob 20 % local

			if($pct_loc_ext <> 0)

			{

				

				$com_ope_loc = $pct_loc_ext;

				

				//consultar % operador sob esse local

				$sql_pct_ope = "

					SELECT

						pct_operador

					FROM

						leitura

					WHERE

						leitura.id_login = '".$id_resp."' 

					AND

						leitura.id_local = '".$id_loc_ext."'

					";

				$query_pct_ope=@mysql_query($sql_pct_ope);

				$resultado_pct_ope=@mysql_fetch_assoc($query_pct_ope);

				

				

				$com_ope_loc = ($com_ope_loc * $resultado_pct_ope['pct_operador']) / 100;

				$com_ope = $com_ope - $com_ope_loc;

			}			

						

			

			//calcula e mostra rendicao do operador

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t <a id='detalhe_comissao' href='#'><strong>Comissao Operador >></strong></a>";

				$guias_cont.="\n\t\t\t\t</td>";

								

				

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					//$guias_cont.="\n\t\t\t\t $ " . number_format($com_ope + $com_ope_loc,0,"",".");

					$guias_cont.="\n\t\t\t\t $ " . number_format($novo_total_comissao,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";																					

			$guias_cont.="\n\t\t\t\t</tr>";

			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t" . $det_com;

				$guias_cont.="\n\t\t\t\t</td>";

								

				

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					//$guias_cont.="\n\t\t\t\t $ " . number_format($com_ope + $com_ope_loc,0,"",".");

					$guias_cont.="\n\t\t\t\t ";

				$guias_cont.="\n\t\t\t\t</td>";																					

			$guias_cont.="\n\t\t\t\t</tr>";			

			



			

			/*

			//calcula e mostra comissao do operador sob os 20 %

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Comissao Operador 2";

				$guias_cont.="\n\t\t\t\t</td>";			

				

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t $ " . number_format($com_ope_loc,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";																					

			$guias_cont.="\n\t\t\t\t</tr>";			

			*/

			

			//$tot_saidas = $tot_saidas + $com_ope;

			//$tot_gastos = $vl_tot_rend + $com_ope + $com_ope_loc + $resultado_deve['deve'];

			$tot_gastos = $vl_tot_rend + $novo_total_comissao + $resultado_deve['deve'];

			

			

			/*

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Comissao Gerente";

				$guias_cont.="\n\t\t\t\t</td>";

				

				//calcula comissao

				$com_ger = ($fat * 5) / 100;

				

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t $ " . number_format($com_ger,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";

																						

			$guias_cont.="\n\t\t\t\t</tr>";

			

			*/

			

			//$tot_saidas = $tot_saidas + $com_ger;



			

			

			

			//buscar se existe maquinas de socio nesse fechamento para descontar 20%

			$sql_leit_maq_soc = "

				SELECT

					leitura_por_maquina.id_leitura,

					leitura_por_maquina.valor_entrada - leitura_por_maquina.valor_saida AS sub_total,

					leitura_por_maquina.pct_maq_socio as porc_socio

				FROM

					leitura_por_maquina

				INNER JOIN 

					maquinas 

				ON 

					leitura_por_maquina.id_maquina = maquinas.id_maquina

				INNER JOIN

					leitura

				ON

					leitura_por_maquina.id_leitura = leitura.id_leitura

				WHERE

					leitura.id_fechamento = '".$id_fechamento."'

				AND 

					leitura_por_maquina.maq_socio = 'true'

				";

			$query_leit_maq_soc=@mysql_query($sql_leit_maq_soc);	

			

			

			$vl_tot_porc_socio=0;

			while ($dados_leit_maq_soc=@mysql_fetch_assoc($query_leit_maq_soc))  //aquii

			{

				$vl_tot_porc_socio = $vl_tot_porc_socio + (($dados_leit_maq_soc['sub_total'] * 20) /100);



			}

				

			/*		

				

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t % Maq Socio";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t $ " . number_format($vl_tot_porc_socio,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";																

			$guias_cont.="\n\t\t\t\t</tr>";

			

			$tot_saidas = $tot_saidas + $vl_tot_porc_socio;

			

			*/

			

			//calcula parte do socio a ser descontada / *Erico

			//$desc_socio = ((($fat - $com_ger - $vl_tot_rend) *50) /100) - $vl_tot_porc_socio;



			

			$desc_socio = ((($fat - $vl_tot_rend) * 50) /100) - $vl_tot_porc_socio;

			

			

			/*

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Lucro Locais";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					//$guias_cont.="\n\t\t\t\t $ " . number_format($desc_socio,0,"",".");

					$guias_cont.="\n\t\t\t\t $ " . number_format($vl_tot_fn_fat_loc,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";																

			$guias_cont.="\n\t\t\t\t</tr>";			

			*/

			$tot_saidas = $tot_saidas + $desc_socio;	

		//fim comissao operador

			



			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				/*

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				*/																							

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				/*

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				*/																										

			$guias_cont.="\n\t\t\t\t</tr>";

			

			//$tot_gastos = $tot_saidas;

			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='right' colspan='2'>";

					$guias_cont.="\n\t\t\t\t Sub Total: ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='1'>";

					$guias_cont.="\n\t\t\t\t $ " . number_format($tot_gastos,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";																									

			$guias_cont.="\n\t\t\t\t</tr>";													

		$guias_cont.="\n\t\t\t\t</table>";

		//fim da tabela de Saidas

		

	$guias_cont.="\n\t\t\t\t</td>";	

$guias_cont.="\n\t\t\t\t</tr>";







$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

	$guias_cont.="\n\t\t\t\t<td align='center' colspan='11'>";

		$guias_cont.="\n\t\t\t\t &nbsp; ";

	$guias_cont.="\n\t\t\t\t</td>";

$guias_cont.="\n\t\t\t\t</tr>";



$guias_cont.="\n\t\t\t\t<tr>";



	$guias_cont.="\n\t\t\t\t<td align='center' colspan='5'>";

	

		//comeco da entrada de Lecturas

		$guias_cont.="\n\t\t\t\t<table border='1' width='100%' bordercolor='#000000' style='border-collapse: collapse'>";

			$guias_cont.="\n\t\t\t\t<tr>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='5' bgcolor='#e5e0ec'>";

					$guias_cont.="\n\t\t\t\t ENTRADAS Debes Recibidos";

				$guias_cont.="\n\t\t\t\t</td>";					

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#ccccff'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";			

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t efetivo";

				$guias_cont.="\n\t\t\t\t</td>";

				/*

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t cheque";

				$guias_cont.="\n\t\t\t\t</td>";

				*/								

			$guias_cont.="\n\t\t\t\t</tr>";			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#ccccff'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Fecha";

				$guias_cont.="\n\t\t\t\t</td>";	

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Descricion";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";

				/*

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Monto";

				$guias_cont.="\n\t\t\t\t</td>";

				*/

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Monto";

				$guias_cont.="\n\t\t\t\t</td>";

				/*			

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Fecha";

				$guias_cont.="\n\t\t\t\t</td>";

				*/																				

			$guias_cont.="\n\t\t\t\t</tr>";



			//declara o subtotal das leituras

			$sub_total_dev_rec = 0;

			$sub_tot_efetivo_dev = 0;		

			

			//efetuar um loop nos resultados de entradas DE DEVE

			while ($dados_dev_rec=@mysql_fetch_assoc($query_dev_detalhe))  

			{



				$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

					$guias_cont.="\n\t\t\t\t<td align='center'>";

						$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_dev_rec['data']));

					$guias_cont.="\n\t\t\t\t</td>";

					$guias_cont.="\n\t\t\t\t<td align='center'>";

						$guias_cont.="\n\t\t\t\t " . $dados_dev_rec['nome'];

					$guias_cont.="\n\t\t\t\t</td>";

					$guias_cont.="\n\t\t\t\t<td align='center'>";

						$guias_cont.="\n\t\t\t\t " . number_format($dados_dev_rec['valor_recebido'],0,"",".");

					$guias_cont.="\n\t\t\t\t</td>";																						

				$guias_cont.="\n\t\t\t\t</tr>";

				

				//soma os contadores

				$sub_total_dev_rec = $sub_total_dev_rec + $dados_dev_rec['valor_recebido'];

				$sub_tot_efetivo_dev = $sub_tot_efetivo_dev + $dados_dev_rec['valor_recebido'];



			}			

			

			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				/*

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				*/																							

			$guias_cont.="\n\t\t\t\t</tr>";



			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp; ";

				$guias_cont.="\n\t\t\t\t</td>";

				/*

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				*/																										

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='right' colspan='2'>";

					$guias_cont.="\n\t\t\t\t Sub Total: ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='1'>";

					$guias_cont.="\n\t\t\t\t $ " . number_format($sub_tot_efetivo_dev,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";																									

			$guias_cont.="\n\t\t\t\t</tr>";			

																					

		$guias_cont.="\n\t\t\t\t</table>";

		//fim da tabela de Entrada / leituras

		

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' >";

		$guias_cont.="\n\t\t\t\t &nbsp;";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t</td>";

	$guias_cont.="\n\t\t\t\t<td align='center' align='center' colspan='5'>";





		//comeco da Saidas

		$guias_cont.="\n\t\t\t\t<table border='1' width='100%' bordercolor='#000000' style='border-collapse: collapse'>";



			$guias_cont.="\n\t\t\t\t<tr bgcolor='#e6b9b8'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='5'>";

					$guias_cont.="\n\t\t\t\t Forma de Pago";

				$guias_cont.="\n\t\t\t\t</td>";					

			$guias_cont.="\n\t\t\t\t</tr>";			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#e6b9b8'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Efetivo";

				$guias_cont.="\n\t\t\t\t</td>";	

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Cheque";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Deposito";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Deposito com Cheque";

				$guias_cont.="\n\t\t\t\t</td>";				

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Deve";

				$guias_cont.="\n\t\t\t\t</td>";																					

			$guias_cont.="\n\t\t\t\t</tr>";

			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp; ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";																								

			$guias_cont.="\n\t\t\t\t</tr>";	

			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Num Doc:";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td colspan='4' align='center'>";

					$guias_cont.="\n\t\t\t\t ";

				$guias_cont.="\n\t\t\t\t</td>";																							

			$guias_cont.="\n\t\t\t\t</tr>";						



			/*

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#e6b9b8'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='5'>";

					$guias_cont.="\n\t\t\t\t SALIDAS Depositos en cuenta";

				$guias_cont.="\n\t\t\t\t</td>";					

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#e6b9b8'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";			

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t efetivo";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t cheque";

				$guias_cont.="\n\t\t\t\t</td>";									

			$guias_cont.="\n\t\t\t\t</tr>";			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#e6b9b8'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Fecha";

				$guias_cont.="\n\t\t\t\t</td>";	

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Descricion";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Monto";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Monto";

				$guias_cont.="\n\t\t\t\t</td>";				

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t Fecha";

				$guias_cont.="\n\t\t\t\t</td>";																					

			$guias_cont.="\n\t\t\t\t</tr>";

			

			*/

			

			//atribui contadores

			$sub_total_dev = 0;



			$tot_dep = 0;

			$vl_especie = 0;

			/*

			while ($dados_forma_pago=@mysql_fetch_assoc($query_forma_pago))  //aquii

			{

				if($dados_forma_pago['valor_dep'] != 0)

				{

					$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

						$guias_cont.="\n\t\t\t\t<td align='center'>";

							$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($data));

						$guias_cont.="\n\t\t\t\t</td>";

						$guias_cont.="\n\t\t\t\t<td align='center'>";

							$guias_cont.="\n\t\t\t\t " . $dados_forma_pago['id_pago'];

						$guias_cont.="\n\t\t\t\t</td>";

						$guias_cont.="\n\t\t\t\t<td align='center'>";

							$guias_cont.="\n\t\t\t\t " . number_format($dados_forma_pago['valor_dep'],0,"",".");

						$guias_cont.="\n\t\t\t\t</td>";

						$guias_cont.="\n\t\t\t\t<td align='center'>";

							$guias_cont.="\n\t\t\t\t &nbsp; ";

						$guias_cont.="\n\t\t\t\t</td>";

						$guias_cont.="\n\t\t\t\t<td align='center'>";

							$guias_cont.="\n\t\t\t\t &nbsp;";

						$guias_cont.="\n\t\t\t\t</td>";																								

					$guias_cont.="\n\t\t\t\t</tr>";				

				}



				//soma os contadores

				$sub_total = $sub_total + $dados_leit['fat_cidade'];

				$sub_tot_efetivo = $sub_tot_efetivo + $dados_leit['fat_cidade'];

				

				$tot_dep = $tot_dep + $dados_forma_pago['valor_dep'];

				

				$vl_especie = $dados_forma_pago['valor_din'] + $dados_forma_pago['valor_cheq'];				

				

			}

			

			

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";																								

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='3'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";

					$guias_cont.="\n\t\t\t\t &nbsp;";

				$guias_cont.="\n\t\t\t\t</td>";																											

			$guias_cont.="\n\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";

				$guias_cont.="\n\t\t\t\t<td align='right' colspan='3'>";

					$guias_cont.="\n\t\t\t\t Sub Total: ";

				$guias_cont.="\n\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t<td align='center' colspan='3'>";

					$guias_cont.="\n\t\t\t\t $" . number_format($tot_dep,0,"",".");

				$guias_cont.="\n\t\t\t\t</td>";																									

			$guias_cont.="\n\t\t\t\t</tr>";	

			*/												

		$guias_cont.="\n\t\t\t\t</table>";

		//fim da tabela de Saidas

		

	$guias_cont.="\n\t\t\t\t</td>";	





$guias_cont.="\n\t\t\t\t</tr>";



	

$total_geral_descontos = $tot_dep + $tot_gastos;

$guias_cont.="<input type='hidden' id='total_saidas' value='".number_format($total_geral_descontos,0,"",".")."' />";

$guias_cont.="<input type='hidden' id='total_parcial_saida' value='".number_format($tot_gastos,0,"",".")."' />";

$guias_cont.="<input type='hidden' id='total_depositos' value='".number_format($tot_dep,0,"",".")."' />";

$guias_cont.="<input type='hidden' id='vl_especie' value='".number_format($vl_especie,0,"",".")."' />";



$vl_a_pagar = $vl_especie + $tot_dep;

$guias_cont.="<input type='hidden' id='vl_final' value='".number_format($vl_a_pagar,0,"",".")."' />";





	

	

	

	

	

	

	



	/// ------------------------- MONTAR AQUI FECHAMENTO ---------------------------------

	/// --------------------------FIM ---------------------------------------------------	

	

	

	

	





		$guias_cont.="\n\t\t\t\t</table>";





		//ver rendicao

		$guias_cont.="\n\t\t\t\t <div align='center'><br />";

		$guias_cont.="\n\t\t\t\t<a href='rendicao.php?id=".$id_fechamento."' target='_blank' id='rendicao' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:0;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:45px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'><br />Rendicao F</a>";

		//$guias_cont.="\n\t\t\t\t<button id='pago' type='button' class='bt-enviar' style='margin-left:3%;margin-top:30px;'>Pago</button>";

		$guias_cont.="\n\t\t\t\t<a href='rendicao_vale.php?id=".$id_fechamento."' target='_blank' id='rendicao_vale' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:100px;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:45px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'><br />Rendicao V</a>";

		$guias_cont.="\n\t\t\t\t </div>";

		

		

		

		

		/*

		//envia leitura

		$guias_cont.="\n\t\t\t\t <div align='center'>";

		$guias_cont.="\n\t\t\t\t<button id='imprimir' type='button' class='bt-enviar' style='margin-left:1%;margin-top:30px;'>Imprimir</button>";				

		$guias_cont.="\n\t\t\t\t </div>";

		*/

	}

	

	

	//fecha form

	$guias_cont.="\n\t\t\t</form>";

	

	$guias_cont.="\n\t\t\t</div>";		

	$cont++;

}

$guias.="\n\t\t\t</ul>\n";



@mysql_free_result($query_nivel);

@mysql_free_result($query_usr);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta name="url" content="http://www.sogesp.com.br/">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<meta name="descri��o" content="SOGESP - Associa��o de Obstetr�cia e Ginecologia do Estado de S�o Paulo" />

	<meta name="robots" content="noindex,nofollow">

	<title>..::Administrativo - Usu&aacute;rios e Acessos::..</title>

	<script type="text/javascript" src="js/jquery.js"></script>

	<script type="text/javascript" src="js/jquery.dimensions.js"></script>

	<script type="text/javascript" src="js/jquery.positionBy.js"></script>

	<script type="text/javascript" src="js/jquery.jdMenu.js"></script>

	<script type="text/javascript" src="js/jquery-ui-1.8.3.js"></script>

	<script type="text/javascript" src="js/media/jquery.jeditable.js"></script>

	<script type="text/javascript" src="js/media/jquery.jeditable.datepicker.js"></script>

	<script type="text/javascript" src="js/jquery.cookie.js"></script>

	<script type="text/javascript" language="javascript" src="js/ajax.js"></script>

	<script type="text/javascript" language="javascript" src="js/functions.js"></script>

	<script type="text/javascript" charset="utf-8">



	$(function(){

		// Tabs

		$('#tabs').tabs({

			cookie: {

				// store cookie for a day, without, it would be a session cookie

				expires: 1

			}		

		});

		//hover states on the static widgets

		$('#dialog_link, ul#icons li').hover(

			function() { $(this).addClass('ui-state-hover'); }, 

			function() { $(this).removeClass('ui-state-hover'); }

		);

	});

	

	//

	$(document).ready(function() {

	

		var descontos = $("#total_saidas").attr("value");

		var depositos = $("#total_depositos").attr("value");

		var sai_parc = $("#total_parcial_saida").attr("value");

		var especie = $("#vl_especie").attr("value");

		var vlfinal = $("#vl_final").attr("value");

		var leitura = $("#tot_leitura").attr("value");

		var deve_rec = $("#vl_fn_dev_rec").attr("value");

		





	

		$("#total_geral_saidas").attr("value",descontos);

		$("#total_geral_dep").attr("value",depositos);

		$("#total_parc_saidas").attr("value",sai_parc);

		$("#total_de_dep").attr("value",depositos);

		$("#total_a_pagar").attr("value",especie);		

		$("#vl_leituras").attr("value",leitura);

		

		//limpa valores para calculos

		deve_rec = "'" + deve_rec + "'";

		deve_rec = deve_rec.replace( ".", "");

		deve_rec = deve_rec.replace( ".", "");

		deve_rec = deve_rec.split(",");

		deve_rec = deve_rec[0].replace( "'", "");

		deve_rec = deve_rec.replace( "'", "");

		

		leitura = "'" + leitura + "'";

		leitura = leitura.replace( ".", "");

		leitura = leitura.replace( ".", "");

		leitura = leitura.split(",");

		leitura = leitura[0].replace( "'", "");

		leitura = leitura.replace( "'", "");		

		

		var vl_fn_ent = eval(leitura) + eval(deve_rec);

		

		//formata valor para mostrar

		vl_fn_ent = vl_fn_ent.formatNumber(2,',','.');

		vl_fn_ent = vl_fn_ent.split(",");

		vl_fn_ent = vl_fn_ent[0];

				

		$("#total_geral_entradas").attr("value",vl_fn_ent);

		var tot_ger_sai = $("#total_geral_saidas").attr("value");

		

		//limpa valores para calculos

		vl_fn_ent = "'" + vl_fn_ent + "'";

		vl_fn_ent = vl_fn_ent.replace( ".", "");

		vl_fn_ent = vl_fn_ent.replace( ".", "");

		vl_fn_ent = vl_fn_ent.split(",");

		vl_fn_ent = vl_fn_ent[0].replace( "'", "");

		vl_fn_ent = vl_fn_ent.replace( "'", "");

		

		tot_ger_sai = "'" + tot_ger_sai + "'";

		tot_ger_sai = tot_ger_sai.replace( ".", "");

		tot_ger_sai = tot_ger_sai.replace( ".", "");

		tot_ger_sai = tot_ger_sai.split(",");

		tot_ger_sai = tot_ger_sai[0].replace( "'", "");

		tot_ger_sai = tot_ger_sai.replace( "'", "");

		

		//calcula

		var total = vl_fn_ent - tot_ger_sai;

		

		//formata valor para mostrar

		total = total.formatNumber(2,',','.');

		total = total.split(",");

		total = total[0];		

		

		$("#total_final").attr("value",total);

		

		

		//esconde a div

		$('#div_detalhe_com').fadeOut("slow");

		var flag_detalhe_visivel = 0;

		$("#detalhe_comissao").click(function(event){

			if(flag_detalhe_visivel == 0)

			{

				$('#div_detalhe_com').fadeIn("slow");

				flag_detalhe_visivel = 1;	

			}

			else

			{

				$('#div_detalhe_com').fadeOut("slow");

				flag_detalhe_visivel = 0;					

			}

		});		



		/*

		$("#rendicao").click(function(event){

			location="rendicao.php?id=<?= $id_fechamento ?>";

		});



		$("#rendicao_vale").click(function(event){

			location="rendicao_vale.php?id=<?= $id_fechamento ?>";

		});	*/	

		

		$("#pago").click(function(event){

			location="viewer_pago.php?id=<?= $id_fechamento ?>";

		});			

		

	});	

	





	</script>

	<style type="text/css">

		/*demo page css*/

		@import "css/media/themes/smoothness/<?=$theme?>";

		#tabs{ font-size: 12px;margin: 10px;}

		.demoHeaders { margin-top: 2em; }

		#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}

		#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}

		ul#icons {margin: 0; padding: 0;}

		ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}

		ul#icons span.ui-icon {float: left; margin: 0 4px;}

		b {color:#FF0000;}

		#ui-datepicker-div {font-size:13px}

	</style>	



	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />

	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

	<link href="css/estilos.css" rel="stylesheet" type="text/css" />

	<noscript>

		<meta http-equiv="REFRESH" content="0;url=http://www.inscricaofacil.com.br/nojavascript.html" />

	</noscript>

</head>

<body>

	<?php

		echo menu_builder();	

	?>

	<div id='div_conteudo'>

		<!-- Tabs -->

		<div id="tabs">

			<?=$guias;?>

			<?=$guias_cont;?>

		</div>

	</div>

</body>

</html>