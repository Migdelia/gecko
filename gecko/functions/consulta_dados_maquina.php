<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idMaq = $_POST['id'];	

$return = "";

//busca dados do loc
$sql_maquina = "
	SELECT
		*				
	FROM
		vw_maquinas
	WHERE
		id_maquina = " . $idMaq;
$query_sql_maquina=@mysql_query($sql_maquina);
$res_maquina=@mysql_fetch_assoc($query_sql_maquina);

	//seleciona todos os perifericos dessa maquina
	$sql_gab = "
	SELECT
		maquinas.id_tipo_maquina as id_per,
		'Gabinete' as tipo,
		tipo_maquina.descricao as serie,
		'tipo_maquina' as tabela,
		tipo_maquina.descricao as descricao
	FROM
		maquinas
	INNER JOIN
		tipo_maquina
	ON
		maquinas.id_tipo_maquina = tipo_maquina.id_tipo_maquina
	WHERE
		id_maquina = " . $idMaq;
	$query_gab=@mysql_query($sql_gab);		
		
		
	$sql_placa = "	
	SELECT
		placa_mae.id_placa as id_per,
		'Placa Madre' as tipo,
		placa_mae.serie,
		'placa_mae' as tabela,
		modelos_placa_mae.descricao
	FROM
		placa_mae
	INNER JOIN
		modelos_placa_mae
	ON
		placa_mae.modelo_id = modelos_placa_mae.id_modelo
	WHERE
		id_maquina = " . $idMaq;
	$query_placa=@mysql_query($sql_placa);			
	
	
	$sql_bil = "
	SELECT
		bilheteiros.id_bilheteiro as id_per,
		'Bilheteiro' as tipo,
		bilheteiros.serie,
		'bilheteiros' as tabela,
		modelos_bilheteiro.descricao
	FROM
		bilheteiros
	INNER JOIN
		modelos_bilheteiro
	ON
		bilheteiros.modelo_id = modelos_bilheteiro.id_modelo
	WHERE
		bilheteiros.id_maquina = " . $idMaq;
	$query_bil=@mysql_query($sql_bil);		
		
		
	$sql_pen = "
	SELECT
		pendrives.id_pendrive as id_per,
		'Pendrive' as tipo,
		pendrives.serie,
		'pendrives' as tabela,
		modelos_pendrive.descricao
	FROM
		pendrives
	INNER JOIN
		modelos_pendrive
	ON
		pendrives.modelo_id = modelos_pendrive.id_modelo
	WHERE
		pendrives.id_maquina = " . $idMaq;
	$query_pen=@mysql_query($sql_pen);		
		
		
		
	$sql_mon = "
	SELECT
		monitores.id_monitor as id_per,
		'Monitor' as tipo,
		monitores.serie,
		'monitores' as tabela,
		modelos_monitor.descricao
	FROM
		monitores
	INNER JOIN
		modelos_monitor
	ON
		monitores.id_modelo = modelos_monitor.id_modelo
	WHERE
		monitores.id_maquina = " . $idMaq;	
	$query_mon=@mysql_query($sql_mon);


//echo $sql_disp; [0]
$return .= $res_maquina['numero'] . ","; // 0
$return .= $res_maquina['codigo'] . ","; //1
$return .= $res_maquina['jogo'] . ","; //2
$return .= $res_maquina['nome'] . ","; //3

//nome status
if($res_maquina['excluido'] == 'N')
{
	$return .= "Activo,"; //4
}
else
{
	$return .= "Inactivo,"; //4	
}

//
$return .= $res_maquina['interface'] . ","; //5
$return .= $res_maquina['ordem_leitura'] . ","; //6
$return .= number_format($res_maquina['entrada_oficial'],0,"",".") . ","; //7
$return .= number_format($res_maquina['saida_oficial'],0,"",".") . ","; //8
$return .= $res_maquina['parceiro'] . ","; //9
$return .= $res_maquina['porc_socio'] . ","; //10
$return .= $res_maquina['porc_maquina'] . ","; //11
$return .= $res_maquina['maq_socio'] . ","; //12


//CHAPAS
//consulta todas as chapas
$sqlTodasChapas = "SELECT
				*
			FROM
				modelos_chapa";
$queryTodasChapas=@mysql_query($sqlTodasChapas);				

//
while($resTodasChapas=@mysql_fetch_assoc($queryTodasChapas))
{
	$return .= $resTodasChapas['codigo'] . "-";	
}
$return .= ",";





//consulta chapas dessa maquina
$sqlChapas = "SELECT
				chapas.id_chapa,
				modelos_chapa.descricao,
				modelos_chapa.codigo
			FROM
				chapas
			INNER JOIN
				modelos_chapa
			ON
				chapas.id_modelo = modelos_chapa.id_modelo
			WHERE
				chapas.id_maquina = " . $idMaq;
$queryChapas=@mysql_query($sqlChapas);				

//
while($resChapas=@mysql_fetch_assoc($queryChapas))
{
	$return .= $resChapas['codigo'] . "-";	
}
$return .= ",";
//CHAPAS



//
$qtd_gabs = mysql_num_rows($query_gab);
if($qtd_gabs > 0)
{
	while($res_gab=@mysql_fetch_assoc($query_gab))
	{
		$return .= $res_gab['serie'] . ",";
	}	
}
else
{
	$return .= ",";
}

//
$qtd_placa = mysql_num_rows($query_placa);
if($qtd_placa > 0)
{
	while($res_placa=@mysql_fetch_assoc($query_placa))
	{
		$return .= $res_placa['serie'] . ",";
	}	
}
else
{
	$return .= ",";
}


//
$qtd_bil = mysql_num_rows($query_bil);
if($qtd_bil > 0)
{
	while($res_bil=@mysql_fetch_assoc($query_bil))
	{
		$return .= $res_bil['serie'] . ",";
	}	
}
else
{
	$return .= ",";
}

//
$qtd_pen = mysql_num_rows($query_pen);
if($qtd_pen > 0)
{
	while($res_pen=@mysql_fetch_assoc($query_pen))
	{
		$return .= $res_pen['serie'] . ",";
	}	
}
else
{
	$return .= ",";
}

//
$qtd_mon = mysql_num_rows($query_mon);
if($qtd_mon > 0)
{
	while($res_mon=@mysql_fetch_assoc($query_mon))
	{
		$return .= $res_mon['serie'] . ",";
	}	
}
else
{
	$return .= ",";
}

$return .= $res_maquina['obs'] . ","; 

echo $return;

?>