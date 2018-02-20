<?php
session_start();
include('../conn/connIntegration.php');
include('functions.php');
//include('validaLogin.php');

$idMaq = $_POST['id'];
$return = "";



//consulta dados
$sql_info = "SELECT * FROM Reading WHERE id = " . $idMaq;
$query_info=@mysql_query($sql_info);


//conecta no calaSys
include('../conn/conn.php');

//
while($res_info=@mysql_fetch_assoc($query_info)) 
{
	//calcula a data de expiracao
	$qtdias = "+ ". $res_info['dateExpires'] ." days";
	$dataExp = date('d-m-Y h:i:s', strtotime($qtdias, strtotime($res_info['issueDate'])));;

	//consulta nome do jogo
	$sql_jogo = "SELECT nome FROM jogo WHERE id_jogo = " . $res_info['hwid'];
	$query_jogo=@mysql_query($sql_jogo);
	$res_jogo=@mysql_fetch_assoc($query_jogo);
	
	
	
	$return .= $res_info['id'] . ",";
	$return .= $res_info['hwid'] . ",";
	$return .= $res_jogo['nome'] . ",";
	$return .= $dataExp  . ",";
	$return .= $res_info['ip']  . ",";
	$return .= $res_info['version']  . ",";	
	$return .= number_format($res_info['getCredits'],0,"",".")  . ",";
	$return .= number_format($res_info['getPromo'],0,"",".")  . ",";	
}

$return .= ";";

//$return = $sql_statistic;
echo $return;

?>