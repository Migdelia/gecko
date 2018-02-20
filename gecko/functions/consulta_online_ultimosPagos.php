<?php
session_start();
include('../conn/conn.php');
include('functions.php');
//include('validaLogin.php');

$idMaq = $_POST['id'];


//pegar o id do local
$sql_local = "SELECT id_local from vw_maquinas WHERE interface = " . $idMaq;
$query_local=@mysql_query($sql_local);
$res_local=@mysql_fetch_assoc($query_local);

$idLoc = $res_local['id_local'];


//pegar o dns desse local
$sql_dns = "SELECT dns FROM locais_integrados WHERE id_local = " . $idLoc;
$query_dns=@mysql_query($sql_dns);
$res_dns=@mysql_fetch_assoc($query_dns);



//conecta no local
session_start();
include('../conn/connLocalIntegrado.php');


//
$return = "";

//consulta dados // dentro do local
$sql_payout = "SELECT value, date FROM lastPayouts WHERE id = " . $idMaq  . " ORDER BY date DESC LIMIT 50";
$query_payout=@mysql_query($sql_payout);

//
while($res_payout=@mysql_fetch_assoc($query_payout)) 
{
	$return .= $res_payout['value'] . "/";
	$return .= date('H:i:s (d-m-Y)', strtotime($res_payout['date'])) . ";";
}


//$return = $sql_statistic;
echo $return;

?>