<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

//recebe data de fechamento * erico 
$idLocalProprio = $_POST['idLocal']; 
$dtFechamento = $_POST['dtRefFech'];
$dtFechamento = date('Y-m-d', strtotime($dtFechamento));


//gera uma lista de ids de leituras com data de fechamento com essa semana:

//
if($idLocalProprio !== '')
{
	//
	$sql_listaLeitura = "SELECT
							id_leitura
						FROM
							leitura
						WHERE
							data_fechamento = '".$dtFechamento."'
						AND
							fechada = ''
						AND
							id_local = " . $idLocalProprio . "
						AND
							id_login = " . $_SESSION['id_login'];	
}
else
{
	$sql_listaLeitura = "SELECT
							id_leitura
						FROM
							leitura
						WHERE
							data_fechamento = '".$dtFechamento."'
						AND
							fechada = ''
						AND
							id_login = " . $_SESSION['id_login'];
	
} 

$qry_listaLeitura=@mysql_query($sql_listaLeitura);

$listaLeitura = '';
while($res_listaLeitura=@mysql_fetch_assoc($qry_listaLeitura))
{
	$listaLeitura = $listaLeitura . $res_listaLeitura['id_leitura'] . ",";
}


/*
//consulta valor da despesa a ser excluida
$sql_vl_desp = "SELECT valor_desconto FROM desconto_leit_fecha WHERE id_desconto = " . $desp;
$query_vl_desp=@mysql_query($sql_vl_desp);
$rst_vl_desp=@mysql_fetch_assoc($query_vl_desp);


//
$sql_add = "DELETE FROM desconto_leit_fecha WHERE id_desconto = " . $desp;

if(@mysql_query($sql_add) )
{
	exit(utf8_encode('true')."-".$rst_vl_desp['valor_desconto']);
}else{
	exit(utf8_encode("false"));
}

*/

	exit(utf8_encode($listaLeitura));
?>