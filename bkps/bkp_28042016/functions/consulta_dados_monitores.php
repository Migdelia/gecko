<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idMon = $_POST['id'];	

//
$return = "";

//busca dados do disp
$sql_Monitor = "
	SELECT
		*				
	FROM
		monitores
	WHERE
		id_monitor = " . $idMon;
$query_monitor=@mysql_query($sql_Monitor);
$res_monitor=@mysql_fetch_assoc($query_monitor);

//consulta numero da maquina
$sql_idMaq = "
	SELECT
		id_maquina,
		numero			
	FROM
		maquinas
	WHERE
		id_maquina = " . $res_monitor['id_maquina'];
$query_idMaq=@mysql_query($sql_idMaq);
$res_idMaq=@mysql_fetch_assoc($query_idMaq);

//consulta modelo placa
$sql_modMon = "
	SELECT
		id_modelo,
		descricao				
	FROM
		modelos_monitor
	WHERE
		id_modelo = " . $res_monitor['id_modelo'];
$query_modMon=@mysql_query($sql_modMon);
$res_modMon=@mysql_fetch_assoc($query_modMon);



//echo $sql_disp;
$return .= $res_monitor['serie'] . ",";
$return .= $res_modMon['descricao'] . ",";
$return .= $res_idMaq['numero'] . ",";
$return .= $res_idMaq['id_maquina'] . ",";
$return .= $res_monitor['id_monitor'] . ",";
$return .= $res_modMon['id_modelo'] . ",";



echo $return;

?>