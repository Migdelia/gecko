<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idPlaca = $_POST['id'];	

//
$return = "";

//busca dados do disp
$sql_placa = "
	SELECT
		*				
	FROM
		placa_mae
	WHERE
		id_placa = " . $idPlaca;
$query_placa=@mysql_query($sql_placa);
$res_placa=@mysql_fetch_assoc($query_placa);

//consulta numero da maquina
$sql_idMaq = "
	SELECT
		id_maquina,
		numero			
	FROM
		maquinas
	WHERE
		id_maquina = " . $res_placa['id_maquina'];
$query_idMaq=@mysql_query($sql_idMaq);
$res_idMaq=@mysql_fetch_assoc($query_idMaq);

//consulta modelo placa
$sql_modPlaca = "
	SELECT
		id_modelo,
		descricao				
	FROM
		modelos_placa_mae
	WHERE
		id_modelo = " . $res_placa['modelo_id'];
$query_modPlaca=@mysql_query($sql_modPlaca);
$res_modPlaca=@mysql_fetch_assoc($query_modPlaca);

//echo $sql_disp;
$return .= $res_placa['serie'] . ",";
$return .= $res_modPlaca['descricao'] . ",";
$return .= $res_idMaq['numero'] . ",";
$return .= $res_idMaq['id_maquina'] . ",";
$return .= $res_placa['id_placa'] . ",";
$return .= $res_modPlaca['id_modelo'] . ",";





echo $return;

?>