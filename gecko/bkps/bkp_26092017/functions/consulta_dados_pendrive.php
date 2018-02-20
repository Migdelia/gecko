<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idPendrive = $_POST['id'];	

//
$return = "";

//busca dados do disp
$sql_pen = "
	SELECT
		*				
	FROM
		pendrives
	WHERE
		id_pendrive = " . $idPendrive;
$query_pen=@mysql_query($sql_pen);
$res_pen=@mysql_fetch_assoc($query_pen);

//consulta numero da maquina
$sql_idMaq = "
	SELECT
		id_maquina,
		numero			
	FROM
		maquinas
	WHERE
		id_maquina = " . $res_pen['id_maquina'];
$query_idMaq=@mysql_query($sql_idMaq);
$res_idMaq=@mysql_fetch_assoc($query_idMaq);

//consulta modelo placa
$sql_modPen = "
	SELECT
		id_modelo,
		descricao,
		marca		
	FROM
		modelos_pendrive
	WHERE
		id_modelo = " . $res_pen['modelo_id'];
$query_modPen=@mysql_query($sql_modPen);
$res_modPen=@mysql_fetch_assoc($query_modPen);

//echo $sql_disp;
$return .= $res_pen['serie'] . ",";
$return .= $res_modPen['descricao'] . ",";
$return .= $res_idMaq['numero'] . ",";
$return .= $res_idMaq['id_maquina'] . ",";
$return .= $res_pen['id_pendrive'] . ",";
$return .= $res_modPen['id_modelo'] . ",";


echo $return;

?>