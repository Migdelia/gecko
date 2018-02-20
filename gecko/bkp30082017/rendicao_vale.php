<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
unset($_SESSION['campos']);
$id_fechamento = $_GET['id'];
	
//verifica se a rendicao é parcial
if($id_fechamento=="")
{
	$parcial = "<strong>PARCIAL</strong>";
}
else
{
	$parcial = "";
}

//verifica se eh master
if( ($_SESSION['usr_nivel']==8))
{
	$wh .= " AND leitura.id_login = ".$_SESSION['id_login']."";
}


//consulta nome do local
	$sql_local = "
		SELECT
			local.nome
		FROM
			local
		INNER JOIN
			leitura
		ON
			local.id_local = leitura.id_local
		WHERE
			leitura.id_fechamento = '".$id_fechamento."'
		";
	$query_local=@mysql_query($sql_local);
	$resultado_local=@mysql_fetch_assoc($query_local);




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

	if($id_fechamento=="")
	{
		//declara o ano da leitura
		$ano = date("Y");
		
		//declara a data do fechamento
		$data = date("d-m-Y");

		//declara o nome do responsavel
		$resp = $_SESSION['nome'];
			
	}
	else
	{
		//declara o ano da leitura
		$ano = date("Y", strtotime($resultado_fecha['data_fechamento']));
		
		//declara a data do fechamento
		$data = date("d-m-Y", strtotime($resultado_fecha['data_fechamento']));	
		
		//declara o nome do responsavel
		$resp = $resultado_fecha['responsavel'];
	}
	
	
	
	
	//consulta todos os gastos despesas agrupados por tipo de despesa desse fechamento
	if($id_fechamento=="")
	{
		$sql_gastos_adm = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '0'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 1
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'				
			".$wh."	
			";
	}
	else
	{
		$sql_gastos_adm = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
			WHERE
				leitura.id_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 1
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'								
		";
		
		$sql_gastos_adm_fecha = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto						
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 1
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'							
		";		
		
	}
	
	$query_gastos_adm=@mysql_query($sql_gastos_adm);
	$qtd_res_adm=@mysql_num_rows($query_gastos_adm);

	$query_gastos_adm_fecha=@mysql_query($sql_gastos_adm_fecha);
	$qtd_res_adm_fecha=@mysql_num_rows($query_gastos_adm_fecha);
	
	
	/* rendicao fechamento
			
		UNION
			
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto						
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 1
			AND
				desconto_leit_fecha.id_maquina = 0		
	*/
	
	
	//consulta todos os gastos despesas agrupados por tipo de despesa desse fechamento
	if($id_fechamento=="")
	{
		
		$sql_gastos_mkt = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '0'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 2
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'								
			".$wh."	
			";
	}
	else
	{
	
		
		$sql_gastos_mkt = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 2
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'											
			";
			
		$sql_gastos_mkt_fecha = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto					
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 2
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'												
			";		
	}
				
	$query_gastos_mkt=@mysql_query($sql_gastos_mkt);
	$qtd_res_mkt=@mysql_num_rows($query_gastos_mkt);
	
	$query_gastos_mkt_fecha=@mysql_query($sql_gastos_mkt_fecha);
	$qtd_res_mkt_fecha=@mysql_num_rows($query_gastos_mkt_fecha);		


	/*
			
	UNION
		
		SELECT
			desconto_leit_fecha.data_desconto,
			desconto_leit_fecha.tipo_doc,
			desconto_leit_fecha.num_doc,
			desconto_leit_fecha.descricao,
			desconto_leit_fecha.valor_desconto,
			desconto_leit_fecha.id_descricao,
			tipo_desconto.descricao as centro_custo,
			'Rend Fechamento' as origem
		FROM
			desconto_leit_fecha
		INNER JOIN
			tipo_desconto
		ON
			desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto					
		WHERE
			desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
		AND
			desconto_leit_fecha.fechamento = 1
		AND
			desconto_leit_fecha.id_descricao = 2
		AND
			desconto_leit_fecha.id_maquina = 0										
		
	*/
	

	//consulta todos os gastos despesas agrupados por tipo de despesa desse fechamento
	if($id_fechamento=="")
	{	
		$sql_gastos_pers = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '0'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 3
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'							
			".$wh."	
			";				
	}
	else
	{
	
		$sql_gastos_pers = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 3
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'												
													
		";
		
		$sql_gastos_pers_fecha = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto					
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 3
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'												
													
		";		
	
	}
	
	$query_gastos_pers=@mysql_query($sql_gastos_pers);
	$qtd_res_pers=@mysql_num_rows($query_gastos_pers);
	
	$query_gastos_pers_fecha=@mysql_query($sql_gastos_pers_fecha);
	$qtd_res_pers_fecha=@mysql_num_rows($query_gastos_pers_fecha);	


	/*
	
	
				
		UNION
			
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto					
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 3
			AND
				desconto_leit_fecha.id_maquina = 0	
	
	
	*/
	

	//consulta todos os gastos despesas agrupados por tipo de despesa desse fechamento
	if($id_fechamento=="")
	{
		
		$sql_gastos_man = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '0'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 4
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'							
			".$wh."	
			";
	}	
	else
	{
		$sql_gastos_man = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 4
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'											
				";
				
		$sql_gastos_man_fecha = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto					
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 4
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'										
				";				
	}			
			
	$query_gastos_man=@mysql_query($sql_gastos_man);
	$qtd_res_man=@mysql_num_rows($query_gastos_man);
	
	$query_gastos_man_fecha=@mysql_query($sql_gastos_man_fecha);
	$qtd_res_man_fecha=@mysql_num_rows($query_gastos_man_fecha);	


	/*
	
				
		UNION
			
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto					
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 4
			AND
				desconto_leit_fecha.id_maquina = 0	
	
	*/


	//consulta todos os gastos despesas agrupados por tipo de despesa desse fechamento
	if($id_fechamento=="")
	{	
		$sql_gastos_ext = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '0'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 5
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'								
			".$wh."	
			";				
	}
	else
	{
		$sql_gastos_ext = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Lectura' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				leitura
			ON
				desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura
	
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
	
	
			WHERE
				leitura.id_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.leitura = 1
			AND
				desconto_leit_fecha.id_descricao = 5
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'													
			";
			
		$sql_gastos_ext_fecha = "
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto					
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 5
			AND
				desconto_leit_fecha.id_maquina = 0
			AND 
				desconto_leit_fecha.tipo_doc = 'vale'													
			";			
	}		
			
			
	$query_gastos_ext=@mysql_query($sql_gastos_ext);
	$qtd_res_ext=@mysql_num_rows($query_gastos_ext);
	
	$query_gastos_ext_fecha=@mysql_query($sql_gastos_ext_fecha);
	$qtd_res_ext_fecha=@mysql_num_rows($query_gastos_ext_fecha);	


	/*
	
		UNION
			
			SELECT
				desconto_leit_fecha.data_desconto,
				desconto_leit_fecha.tipo_doc,
				desconto_leit_fecha.num_doc,
				desconto_leit_fecha.descricao,
				desconto_leit_fecha.valor_desconto,
				desconto_leit_fecha.id_descricao,
				tipo_desconto.descricao as centro_custo,
				'Rend Fechamento' as origem
			FROM
				desconto_leit_fecha
			INNER JOIN
				tipo_desconto
			ON
				desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto					
			WHERE
				desconto_leit_fecha.id_leitura_fechamento = '".$id_fechamento."'
			AND
				desconto_leit_fecha.fechamento = 1
			AND
				desconto_leit_fecha.id_descricao = 5
			AND
				desconto_leit_fecha.id_maquina = 0	
	
	*/

	

	/// ------------------------- MONTAR AQUI FECHAMENTO ---------------------------------
	/// --------------------------------------------------------------------------------
	//colspan='11'
	

//declara variavel de total
$total_rendicion = 0;

	//Montando a Tabela com os dados que a aba deverá possuir
	$guias_cont.="\n\t\t\t\t<table border='1' width='100%' bordercolor='#000000' style='border-collapse: collapse' align='center'>";

$guias_cont.="\n\t\t\t\t<tr bgcolor='#c6efce'>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6'>";
		$guias_cont.="\n\t\t\t\t<font size='3'><strong>" . $resultado_local['nome'] . "</strong></font><br />";
		$guias_cont.="\n\t\t\t\tRendicion VALE " . "<strong>" . $id_fechamento . "</strong>" . " - " . $ano ." " . $parcial;
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";

$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	$guias_cont.="\n\t\t\t\t<td align='right' colspan='6'>";
		$guias_cont.="\n\t\t\t\t<strong>Fecha: " . $data;
	$guias_cont.="\n\t\t\t\t</strong></td>";
$guias_cont.="\n\t\t\t\t</tr>";
	
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='2' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t<strong><br />Responsavel<br /></strong>&nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center' bgcolor='#FFFFFF'>";
		$guias_cont.="\n\t\t\t\t" . $resp;
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center' bgcolor='#ffff00'>";
		$guias_cont.="\n\t\t\t\t <strong>Total</strong>:";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center' bgcolor='#FFFFFF'>";
		$guias_cont.="\n\t\t\t\t $ <input label='Total Rendicao' type='text' name='valor_total_rendicao' size='10' id='valor_total_rendicao' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >";
	$guias_cont.="\n\t\t\t\t</td>";			
$guias_cont.="\n\t\t\t\t</tr>";

$guias_cont.="\n\t\t\t\t</table>";

$guias_cont.="\n\t\t\t\t<br /><br />";


	$guias_cont.="\n\t\t\t\t<table border='1' width='100%' bordercolor='#000000' style='border-collapse: collapse' align='center'>";


$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#3b630d'>";
		$guias_cont.="\n\t\t\t\t <br /><strong><font color='white'>RENDICION LECTURA</font></strong> <br />&nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";


//verifica se teve gastos de Adm
if($qtd_res_adm > 0)
{

$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t <strong>ADM</strong>";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				


	$subtot_adm = 0;

	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_adm=@mysql_fetch_assoc($query_gastos_adm))  //aquii
	{
		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_adm['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_adm['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
			if($dados_gastos_adm['tipo_doc'] == 'fatura')
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_adm['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";	
				*/					
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_adm['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_adm['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_adm['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		//atribui valores ao contador
		$subtot_adm = $subtot_adm + $dados_gastos_adm['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_adm['valor_desconto'];
		
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_adm,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr>";
	
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
}

if($qtd_res_mkt > 0)
{
//outro centro de custo
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t MKT";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				

	//declara contador
	$subtot_mkt = 0;

	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_mkt=@mysql_fetch_assoc($query_gastos_mkt))  //aquii
	{

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_mkt['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_mkt['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
		
			if($dados_gastos_mkt['tipo_doc']=="fatura")
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_mkt['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";		
				*/				
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_mkt['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_mkt['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_mkt['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		//atribui valor ao contador
		$subtot_mkt = $subtot_mkt + $dados_gastos_mkt['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_mkt['valor_desconto'];

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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_mkt,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr>";
	
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";}


if($qtd_res_pers > 0)
{	
//outro centro de custo
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t PERSONAL";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				

	//declara contador
	$subtot_pers = 0;

	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_pers=@mysql_fetch_assoc($query_gastos_pers))  //aquii
	{

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_pers['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_pers['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
			if($dados_gastos_pers['tipo_doc'] == 'fatura')
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_pers['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";		
				*/				
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_pers['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_pers['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_pers['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		//atribui valor ao contador
		$subtot_pers = $subtot_pers + $dados_gastos_pers['valor_desconto'];
		$total_rendicion = $total_rendicion + + $dados_gastos_pers['valor_desconto'];

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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_pers,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr>";
	
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
}


if($qtd_res_man > 0)
{	
//outro centro de custo
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t MANUTENCION";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				

	
	//atribui contador
	$subtot_man = 0;
	
	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_man=@mysql_fetch_assoc($query_gastos_man))  //aquii
	{

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_man['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_man['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
			if($dados_gastos_man['tipo_doc'] == 'fatura')
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_man['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";
				*/			
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_man['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_man['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_man['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		//atribui valor ao contador
		$subtot_man = $subtot_man + $dados_gastos_man['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_man['valor_desconto'];

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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_man,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr>";
	
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
}	
	


if($qtd_res_ext > 0)
{	
//outro centro de custo
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t EXTRAS";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				



	//atribui contador 
	$subtot_ext = 0;	
	

	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_ext=@mysql_fetch_assoc($query_gastos_ext))  //aquii
	{

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_ext['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_ext['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
			if($dados_gastos_ext['tipo_doc'] == 'fatura')
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_ext['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";			
				*/			
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_ext['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_ext['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_ext['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		
		//atribui valor ao contador
		$subtot_ext = $subtot_ext + $dados_gastos_ext['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_ext['valor_desconto'];

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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_ext,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";

}	

/*
$guias_cont.="\n\t\t\t\t <input type='hidden' id='tot_rend' name='tot_rend' value='".number_format($total_rendicion,0,"",".")."' />";
*/

	/// ------------------------- MONTAR AQUI FECHAMENTO ---------------------------------
	/// --------------------------FIM ---------------------------------------------------	

	$guias_cont.="\n\t\t\t\t</table>";






	//	daqui em diante
	//  Rendicao fechamento --------------------- Rendicao fechamento
	//  Rendicao fechamento --------------------- Rendicao fechamento
	//  Rendicao fechamento --------------------- Rendicao fechamento	





$guias_cont.="\n\t\t\t\t<br /><br />";


	$guias_cont.="\n\t\t\t\t<table border='1' width='100%' bordercolor='#000000' style='border-collapse: collapse' align='center'>";


$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#3b630d'>";
		$guias_cont.="\n\t\t\t\t <br /><strong><font color='white'>RENDICION FECHAMENTO</font></strong> <br />&nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";


//verifica se teve gastos de Adm
if($qtd_res_adm_fecha > 0)
{

$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t ADM";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				


	$subtot_adm = 0;

	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_adm_fecha=@mysql_fetch_assoc($query_gastos_adm_fecha))  //aquii
	{
		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_adm_fecha['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_adm_fecha['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
			if($dados_gastos_adm_fecha['tipo_doc'] == 'fatura')
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_adm_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";
				*/					
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_adm_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_adm_fecha['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_adm_fecha['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		//atribui valores ao contador
		$subtot_adm = $subtot_adm + $dados_gastos_adm_fecha['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_adm_fecha['valor_desconto'];
		
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_adm,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr>";
	
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
}

if($qtd_res_mkt_fecha > 0)
{
//outro centro de custo
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t MKT";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				

	//declara contador
	$subtot_mkt = 0;

	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_mkt_fecha=@mysql_fetch_assoc($query_gastos_mkt_fecha))  //aquii
	{

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_mkt_fecha['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_mkt_fecha['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
		
			if($dados_gastos_mkt_fecha['tipo_doc']=="fatura")
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_mkt_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";		
				*/				
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_mkt_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_mkt_fecha['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_mkt_fecha['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		//atribui valor ao contador
		$subtot_mkt = $subtot_mkt + $dados_gastos_mkt_fecha['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_mkt_fecha['valor_desconto'];

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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_mkt,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr>";
	
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";}


if($qtd_res_pers_fecha > 0)
{	
//outro centro de custo
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t PERSONAL";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				

	//declara contador
	$subtot_pers = 0;

	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_pers_fecha=@mysql_fetch_assoc($query_gastos_pers_fecha))  //aquii
	{

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_pers_fecha['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_pers_fecha['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
			if($dados_gastos_pers_fecha['tipo_doc'] == 'fatura')
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_pers_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";		
				*/				
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_pers_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_pers_fecha['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_pers_fecha['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		//atribui valor ao contador
		$subtot_pers = $subtot_pers + $dados_gastos_pers_fecha['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_pers_fecha['valor_desconto'];

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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_pers,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr>";
	
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
}


if($qtd_res_man_fecha > 0)
{	
//outro centro de custo
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t MANUTENCION";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				

	
	//atribui contador
	$subtot_man = 0;
	
	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_man_fecha=@mysql_fetch_assoc($query_gastos_man_fecha))  //aquii
	{

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_man_fecha['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_man_fecha['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
			if($dados_gastos_man['tipo_doc'] == 'fatura')
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_man_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";	
				*/					
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_man_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_man_fecha['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_man_fecha['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		//atribui valor ao contador
		$subtot_man = $subtot_man + $dados_gastos_man_fecha['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_man_fecha['valor_desconto'];

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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_man,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr>";
	
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
}	
	


if($qtd_res_ext_fecha > 0)
{	
//outro centro de custo
$guias_cont.="\n\t\t\t\t<tr>";
	$guias_cont.="\n\t\t\t\t<td align='center' colspan='6' bgcolor='#92d050'>";
		$guias_cont.="\n\t\t\t\t EXTRAS";
	$guias_cont.="\n\t\t\t\t</td>";
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF' style='font-weight:bolder;text-align:center;'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fecha";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Origem";
	$guias_cont.="\n\t\t\t\t</td>";	
	/*
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Fatura";
	$guias_cont.="\n\t\t\t\t</td>";
	*/
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Vale";
	$guias_cont.="\n\t\t\t\t</td>";
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Proovedor/Descricao";
	$guias_cont.="\n\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Monto";
	$guias_cont.="\n\t\t\t\t</td>";				



	//atribui contador 
	$subtot_ext = 0;	
	

	//efetuar um loop nos resultados de entradas leit
	while ($dados_gastos_ext_fecha=@mysql_fetch_assoc($query_gastos_ext_fecha))  //aquii
	{

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . date("d-m-Y", strtotime($dados_gastos_ext_fecha['data_desconto']));
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_ext_fecha['origem'];
			$guias_cont.="\n\t\t\t\t</td>";			
			
			if($dados_gastos_ext['tipo_doc'] == 'fatura')
			{
				/*
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_ext_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";					
				$guias_cont.="\n\t\t\t\t</td>";			
				*/			
			}
			else
			{
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t -";
				$guias_cont.="\n\t\t\t\t</td>";
				$guias_cont.="\n\t\t\t\t<td align='center'>";
					$guias_cont.="\n\t\t\t\t " . $dados_gastos_ext_fecha['num_doc'];
				$guias_cont.="\n\t\t\t\t</td>";						
			}			

			
			
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . $dados_gastos_ext_fecha['descricao'];
			$guias_cont.="\n\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t<td align='center'>";
				$guias_cont.="\n\t\t\t\t " . number_format($dados_gastos_ext_fecha['valor_desconto'],0,"",".");
			$guias_cont.="\n\t\t\t\t</td>";																								
		$guias_cont.="\n\t\t\t\t</tr>";
		
		
		//atribui valor ao contador
		$subtot_ext = $subtot_ext + $dados_gastos_ext_fecha['valor_desconto'];
		$total_rendicion = $total_rendicion + $dados_gastos_ext_fecha['valor_desconto'];

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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t &nbsp;";
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";
$guias_cont.="\n\t\t\t\t<tr bgcolor='#FFFFFF'>";
	
	$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t Subtotal";
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
		$guias_cont.="\n\t\t\t\t<td align='center'>";
		$guias_cont.="\n\t\t\t\t $ " . number_format($subtot_ext,0,"",".");
	$guias_cont.="\n\t\t\t\t</td>";				
	
$guias_cont.="\n\t\t\t\t</tr>";

}	


$guias_cont.="\n\t\t\t\t <input type='hidden' id='tot_rend' name='tot_rend' value='".number_format($total_rendicion,0,"",".")."' />";


	/// ------------------------- MONTAR AQUI FECHAMENTO ---------------------------------
	/// --------------------------FIM ---------------------------------------------------	
	
	
	
	


		$guias_cont.="\n\t\t\t\t</table>";


		//envia leitura
		$guias_cont.="\n\t\t\t\t <div align='center'>";
		$guias_cont.="\n\t\t\t\t<button id='rendicao' type='button' class='bt-enviar' style='margin-left:1%;margin-top:30px;' onclick='imprimir();'>Imprimir</button>";				
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
	<meta name="descrição" content="SOGESP - Associação de Obstetrícia e Ginecologia do Estado de São Paulo" />
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
	

	$(document).ready( function() 
	{
		var total_rendicao =$("#tot_rend").attr("value");
		$("#valor_total_rendicao").attr("value",total_rendicao);
	
	});

	function imprimir()
	{
		window.print();
	}



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