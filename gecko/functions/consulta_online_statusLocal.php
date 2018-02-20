<?php
session_start();
include('../conn/connIntegration.php');
include('functions.php');
//include('validaLogin.php');

$return = "";


//consulta dados
$sql_info = "SELECT * FROM siteUp";
$query_info=@mysql_query($sql_info);



//
while($res_info=@mysql_fetch_assoc($query_info)) 
{
	$return .= $res_info['id_local'] . ",";
	$return .= $res_info['uptime'] . ";";	
}


//$return = $sql_statistic;
echo $return;

?>