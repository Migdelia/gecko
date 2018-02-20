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
			logins.nome as responsavel,
			logins.percentual as pct_operador
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
	
	//declara o nome do responsavel
	$resp = $resultado_fecha['responsavel'];

	//SOMA TODOS FATURAMENTO E DEVES DESSE FECHAMENTO
	$sql_fat = "
		SELECT
			SUM(faturamento_bruto) AS faturamento,
			SUM(valor_recebido) AS deve_recebido	
		FROM
			vw_leitura
		WHERE
			vw_leitura.id_fechamento = '".$id_fechamento."'
		";
	$query_fat=@mysql_query($sql_fat);
	$resultado_fat=@mysql_fetch_assoc($query_fat);	

	//Declara valor de faturamento
	$fat = $resultado_fat['faturamento'];
	$deve_rec = $resultado_fat['deve_recebido'];
	

	
	
	//consulta os dados das leituras agrupados por cidade
	$sql_leit = "
		SELECT 
			vw_leitura.data, 
			vw_leitura.nome as nome_cidade,
			vw_leitura.faturamento_bruto as fat_cidade,
			vw_leitura.id_local
		FROM 
			vw_leitura
		INNER JOIN
			regiao
		ON
			vw_leitura.id_regiao = regiao.id_cidade
		WHERE 
			vw_leitura.id_fechamento = '".$id_fechamento."'  
		";
	$query_leit=@mysql_query($sql_leit);
	//$resultado_leit=@mysql_fetch_assoc($query_leit);
	


	//lista todos os deves recebidos desse faturamento agrupados por local //CONTINUAR DAQUIII
	$sql_dev_rec = "
		SELECT
			SUM(vw_leitura.valor_recebido) AS deve_recebido,
			vw_leitura.nome,
			vw_leitura.data
		FROM
			vw_leitura
		WHERE
			vw_leitura.id_fechamento = '".$id_fechamento."'
		AND
			vw_leitura.valor_recebido != 0
		GROUP BY 
			vw_leitura.id_local
		";
	$query_dev_rec=@mysql_query($sql_dev_rec);



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
		AND
			desconto_leit_fecha.id_maquina = 0
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
			SUM(deve) AS deve	
		FROM
			vw_leitura
		WHERE
			vw_leitura.id_fechamento = '".$id_fechamento."'
		";
	$query_deve=@mysql_query($sql_deve);
	$resultado_deve=@mysql_fetch_assoc($query_deve);


	//atribui o deve ao total de descontos
	$tot_descontos_geral = $tot_gastos + $resultado_deve['deve'];
	

	//lista todos as despesas desse faturamento agrupados por cidade
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
	

	//lista todos as despesas desse faturamento agrupados por cidade
	$sql_dif = "
	
		SELECT
			desconto_leit_fecha.data_desconto,
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
			desconto_leit_fecha.id_maquina <> 0	
		
		";
	$query_dif=@mysql_query($sql_dif);
	$resultado_dif=@mysql_fetch_assoc($query_dif);
	

	$fat = $fat - $resultado_dif['valor_desconto'];
	
	//calcula o total de entrada
	$tot_ent = $fat + $deve_rec;

	//lista todos os deves desse fechamento agrupados por local //CONTINUAR DAQUIII
	$sql_dev_detalhe = "
		SELECT
			vw_leitura.deve,
			vw_leitura.nome,
			vw_leitura.data
		FROM
			vw_leitura
		WHERE
			vw_leitura.id_fechamento = '".$id_fechamento."'
		AND
			vw_leitura.deve != 0
		GROUP BY 
			vw_leitura.id_local
		";
	$query_dev_detalhe=@mysql_query($sql_dev_detalhe);


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



	//Verifica se tem jogos com porcentagem especial
	$sql_jog = "
			SELECT
				sum(vw_leitura_maquina.valor_entrada) as entrada,
				sum(vw_leitura_maquina.valor_saida) as saida,
				sum(vw_leitura_maquina.valor_entrada) - sum(vw_leitura_maquina.valor_saida) as fat_jogos
			FROM
				vw_leitura_maquina
			INNER JOIN
				jogo
			ON
				vw_leitura_maquina.jogo = jogo.nome
			INNER JOIN
				leitura
			ON
				vw_leitura_maquina.id_leitura = leitura.id_leitura
			WHERE
				leitura.id_fechamento = '".$id_fechamento."'
			AND
				jogo.porcentagem <> 0
		";
	$query_jog=@mysql_query($sql_jog);
	$resultado_jog=@mysql_fetch_assoc($query_jog);
	
	$porc_jog = (($resultado_jog['fat_jogos'] - $resultado_dif['valor_desconto']) * 10 ) / 100;

	//declara total a pagar
	$total_pagar = 0;
	$total_pagar = $tot_ent - $tot_descontos_geral;
	
	
	/// ------------------------- MONTAR AQUI FECHAMENTO ---------------------------------
	/// --------------------------------------------------------------------------------
	
	
$guias_cont.="\n\t\t\t\t<tr height='50' bgcolor='#c6efce' style='font-size:18px; color:#00802d;'>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='11'>";
		$guias_cont.="\n\t\t\t\t<strong>Fechamento Semanal " . $ano . "</strong>";;
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";

$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-size:14px;'>";
	$guias_cont.="\n\t\t\t\t<td align='right' colspan='11'>";
		$guias_cont.="\n\t\t\t\t<font color='#00802d' size='4'> Fecha Referente: </font> &nbsp;<strong>" . $data. "</strong> &nbsp;";
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
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='3' rowspan='2' bgcolor='#ffff00'>";
		$guias_cont.="\n\t\t\t\t Total a pagar: <strong>$</strong>"."<input id='total_final' value='' size='8' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:13px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='2' bgcolor='#FFFFFF'>";
		$guias_cont.="\n\t\t\t\t\t\t Total&nbsp;Especie: " . "<input id='total_a_pagar' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";
	$guias_cont.="\n\t\t\t\t</td>";			
$guias_cont.="\n\t\t\t\t</tr>";

$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='12'>";
		$guias_cont.="\n\t\t\t\t Total de Dep: ";
		$guias_cont.="\n\t\t\t\t\t\t " . "<input id='total_de_dep' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";		
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
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
		$guias_cont.="\n\t\t\t\t $ " . number_format($fat,0,"",".");
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
		$guias_cont.="\n\t\t\t\t $ " . number_format($deve_rec,0,"",".");
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
		$guias_cont.="\n\t\t\t\t TOT ENTRADA ";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='2' bgcolor='#FFFFFF'>";
		//$guias_cont.="\n\t\t\t\t $ " . number_format($tot_ent,0,"",".");
		$guias_cont.="\n\t\t\t\t\t\t $"."<input id='total_geral_entradas' value='".number_format($tot_ent,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";
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
			
			
			
			//efetuar um loop nos resultados de entradas leit
			while ($dados_leit=@mysql_fetch_assoc($query_leit))  //aquii
			{
				$fat = $dados_leit['fat_cidade'] - $resultado_dif['valor_desconto'];
				$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_leit['data']));
					$guias_cont.="\n\t\t\t\t</td>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . $dados_leit['nome_cidade'];
					$guias_cont.="\n\t\t\t\t</td>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . number_format($fat,0,"",".");
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
				
				//soma os contadores
				$sub_total = $sub_total + $dados_leit['fat_cidade'];
				$sub_tot_efetivo = $sub_tot_efetivo + $dados_leit['fat_cidade'];
				
				$id_local = $dados_leit['id_local'];
			}
			
			
			/*
			//efetuar um loop nos resultados de entradas leit
			while ($dados_forma_pago=@mysql_fetch_assoc($query_forma_pago))  //aquii
			{

				$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($data));
					$guias_cont.="\n\t\t\t\t</td>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . $dados_forma_pago['id_pago'];
					$guias_cont.="\n\t\t\t\t</td>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . number_format($dados_forma_pago['valor_din'],0,"",".");
					$guias_cont.="\n\t\t\t\t</td>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . number_format($dados_forma_pago['valor_cheq'],0,"",".");
					$guias_cont.="\n\t\t\t\t</td>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t &nbsp;";
					$guias_cont.="\n\t\t\t\t</td>";																								
				$guias_cont.="\n\t\t\t\t</tr>";
				
				//soma os contadores
				$sub_total = $sub_total + $dados_leit['fat_cidade'];
				$sub_tot_efetivo = $sub_tot_efetivo + $dados_leit['fat_cidade'];
			}
*/
			
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
			$guias_cont.="\n\t\t\t\t</tr>";
			
			$sub_total = $sub_total - $resultado_dif['valor_desconto'];
			
			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
				$guias_cont.="\n\t\t\t\t<td align='right' colspan='2'>";
					$guias_cont.="\n\t\t\t\t Sub Total: ";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center' colspan='3'>";
					$guias_cont.="\n\t\t\t\t $ " . number_format($sub_total,0,"",".");
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
				/*
				$guias_cont.="\n\t\t\t\t<td align='center' colspan='2'>";
					$guias_cont.="\n\t\t\t\t cheque";
				$guias_cont.="\n\t\t\t\t</td>";
				*/								
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
				$vl_tot_rend = $vl_tot_rend + $dados_gastos_geral['valor_desconto'];

			}
			
			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($data));
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t Rendicao <strong>" .$id_fechamento ."</strong>";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . number_format($tot_gastos,0,"",".");
				$guias_cont.="\n\t\t\t\t</td>";																						
			$guias_cont.="\n\t\t\t\t</tr>";
			
			//$tot_saidas = $tot_saidas + $vl_tot_rend;
			$tot_saidas = $tot_saidas + $tot_gastos;
			

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
			
			//calcula e mostra rendicao do operador
			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t Comissao Jogos";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t $ " . number_format($porc_jog,0,"",".");
				$guias_cont.="\n\t\t\t\t</td>";																					
			$guias_cont.="\n\t\t\t\t</tr>";
			
			//$tot_saidas = $tot_saidas + $vl_tot_rend;
			$tot_saidas = $tot_saidas + $porc_jog;
			
			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t Lucro Local";
				$guias_cont.="\n\t\t\t\t</td>";


				//calcula o lucro do local
				$lucro_local = (($fat - $tot_gastos - $porc_jog) * 10) / 100;
				
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t $ " . number_format($lucro_local,0,"",".");
				$guias_cont.="\n\t\t\t\t</td>";
																						
			$guias_cont.="\n\t\t\t\t</tr>";
			
			$tot_saidas = $tot_saidas + $lucro_local;

			$tot_gastos = $tot_gastos + $com_ope;

			//calcula lucro do socio
			$lucro_socio = (($fat - $tot_gastos - $porc_jog - $lucro_local) * 50 ) / 100;
			
			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t Lucro socio";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t $ " . number_format($lucro_socio,0,"",".");
				$guias_cont.="\n\t\t\t\t</td>";																
			$guias_cont.="\n\t\t\t\t</tr>";			
				
			$tot_saidas = $tot_saidas + $lucro_socio;


			$com_ope = ($lucro_socio * 6) / 100;
			
			$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t Comissao Operador";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t $ " . number_format($com_ope,0,"",".");
				$guias_cont.="\n\t\t\t\t</td>";																
			$guias_cont.="\n\t\t\t\t</tr>";			
				
			$tot_saidas = $tot_saidas + $com_ope;	
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
			
			$tot_gastos = $tot_saidas;
			
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
		$guias_cont.="\n\t\t\t\t &nbsp;";
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
			while ($dados_dev_rec=@mysql_fetch_assoc($query_dev_rec))  
			{

				$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_dev_rec['data']));
					$guias_cont.="\n\t\t\t\t</td>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . $dados_dev_rec['nome'];
					$guias_cont.="\n\t\t\t\t</td>";
					$guias_cont.="\n\t\t\t\t<td align='center'>";
						$guias_cont.="\n\t\t\t\t " . number_format($dados_dev_rec['deve_recebido'],0,"",".");
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
				
				//soma os contadores
				$sub_total_dev_rec = $sub_total_dev_rec + $dados_dev_rec['deve_recebido'];
				$sub_tot_efetivo_dev = $sub_tot_efetivo_dev + $dados_dev_rec['deve_recebido'];

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
			
			//atribui contadores
			$sub_total_dev = 0;

			$tot_dep = 0;
			$vl_especie = 0;
			while ($dados_forma_pago=@mysql_fetch_assoc($query_forma_pago))  //aquii
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
		$guias_cont.="\n\t\t\t\t</table>";
		//fim da tabela de Saidas
		
	$guias_cont.="\n\t\t\t\t</td>";	


$guias_cont.="\n\t\t\t\t</tr>";

	
$total_geral_descontos = $tot_dep + $tot_saidas;
$guias_cont.="<input type='hidden' id='total_saidas' value='".number_format($total_geral_descontos,0,"",".")."' />";
$guias_cont.="<input type='hidden' id='total_parcial_saida' value='".number_format($tot_saidas,0,"",".")."' />";
$guias_cont.="<input type='hidden' id='total_depositos' value='".number_format($tot_dep,0,"",".")."' />";
$guias_cont.="<input type='hidden' id='vl_especie' value='".number_format($vl_especie,0,"",".")."' />";

$vl_a_pagar = $vl_especie + $tot_dep;
$guias_cont.="<input type='hidden' id='vl_final' value='".number_format($vl_a_pagar,0,"",".")."' />";
$guias_cont.="<input type='hidden' id='vl_tot_entradas' value='".number_format($tot_ent,0,"",".")."' />";


	
	
	
	
	
	
	

	/// ------------------------- MONTAR AQUI FECHAMENTO ---------------------------------
	/// --------------------------FIM ---------------------------------------------------	
	
	
	
	


		$guias_cont.="\n\t\t\t\t</table>";


		//ver rendicao
		$guias_cont.="\n\t\t\t\t <div align='center'>";
		$guias_cont.="\n\t\t\t\t<button id='rendicao' type='button' class='bt-enviar' style='margin-left:0%;margin-top:30px;'>Rendicao</button>";
		$guias_cont.="\n\t\t\t\t<button id='pago' type='button' class='bt-enviar' style='margin-left:3%;margin-top:30px;'>Pago</button>";				
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
		var vlentradas = $("#vl_tot_entradas").attr("value");
		
		
		//calcula valor final a mostrar
		//limpa valores para calculos
		vlentradas = "'" + vlentradas + "'";
		vlentradas = vlentradas.replace( ".", "");
		vlentradas = vlentradas.replace( ".", "");
		vlentradas = vlentradas.split(",");
		vlentradas = vlentradas[0].replace( "'", "");
		vlentradas = vlentradas.replace( "'", "");
		
		descontos = "'" + descontos + "'";
		descontos = descontos.replace( ".", "");
		descontos = descontos.replace( ".", "");
		descontos = descontos.split(",");
		descontos = descontos[0].replace( "'", "");
		descontos = descontos.replace( "'", "");				
		
		vlfinal = vlentradas - descontos;
		
		if(vlfinal < 0)
		{
			vlfinal = 0;
		}
		
		vlfinal = vlfinal.formatNumber(2,',','.');
		vlfinal = vlfinal.split(",");
		vlfinal = vlfinal[0];
		
		descontos = eval(descontos);
		descontos = descontos.formatNumber(2,',','.');
		descontos = descontos.split(",");
		descontos = descontos[0];		
	
		$("#total_geral_saidas").attr("value",descontos);
		$("#total_geral_dep").attr("value",depositos);
		$("#total_parc_saidas").attr("value",sai_parc);
		$("#total_de_dep").attr("value",depositos);
		$("#total_a_pagar").attr("value",especie);		
		$("#total_final").attr("value",vlfinal);

	
		$("#rendicao").click(function(event){
			location="rendicao.php?id=<?= $id_fechamento ?>";
		});
		
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