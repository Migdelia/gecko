<?php
session_start();
include('../conn/connIntegration.php');
include('functions.php');
//include('validaLogin.php');

$idMaq = $_POST['id'];
$return = "";



//consulta dados
$sql_info = "SELECT * FROM Statistic WHERE id = " . $idMaq;
$query_info=@mysql_query($sql_info);


//conecta no calaSys
//include('../conn/conn.php');

//
while($res_info=@mysql_fetch_assoc($query_info)) 
{
	//declara diferencial
	$diferencial = $res_info['creditIn'] - $res_info['creditOut'];
	
	$return .= $res_info['creditIn'] . ",";
	$return .= $res_info['creditOut'] . ",";
	$return .= $res_info['vPlayed'] . ",";
	$return .= $res_info['vWon'] . ",";
	$return .= $res_info['vdPlayed'] . ",";
	$return .= $res_info['vdWon'] . ",";	
	$return .= $res_info['promoIn'] . ",";
	$return .= $res_info['gPlayed'] . ",";	
	$return .= $res_info['gWon'] . ",";
	$return .= $res_info['dPlayed'] . ",";
	$return .= $res_info['dWon'] . ",";
	$return .= $res_info['jPaid']  . ",";	
	$return .= $res_info['aPaid']  . ",";
	$return .= $res_info['asPaid']  . ",";
	$return .= $diferencial  . ",";
}

$return .= ";";

//$return = $sql_statistic;
echo $return;

?>