<?php
session_start();
include('../conn/conn.php');
include('functions.php');
//include('validaLogin.php');

//
$idMaq = $_POST['id'];


//pegar o id do local
$sql_local = "SELECT id_local from vw_maquinas WHERE interface = " . $idMaq;
$query_local=@mysql_query($sql_local);
$res_local=@mysql_fetch_assoc($query_local);

//
$idLoc = $res_local['id_local'];


//pegar o dns desse local
$sql_dns = "SELECT dns FROM locais_integrados WHERE id_local = " . $idLoc;
$query_dns=@mysql_query($sql_dns);
$res_dns=@mysql_fetch_assoc($query_dns);


//conecta no local
session_start();
include('../conn/connLocalIntegrado.php');




$return = "";


//consulta dados
$sql_bill = "SELECT value, date FROM lastBills WHERE id = " . $idMaq . " ORDER BY date DESC LIMIT 50";
$query_bill=@mysql_query($sql_bill);

//
while($res_bill=@mysql_fetch_assoc($query_bill)) 
{
	$return .= $res_bill['value'] . ",";
	$return .= date('H:i:s (d-m-Y)', strtotime($res_bill['date'])) . ";";
}


//$return = $sql_statistic;
echo $return;

?>