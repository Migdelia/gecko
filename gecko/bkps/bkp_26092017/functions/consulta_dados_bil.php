<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idBil = $_POST['id'];	

//
$return = "";

//busca dados do disp
$sql_bil = "
	SELECT
		*				
	FROM
		bilheteiros
	WHERE
		id_bilheteiro = " . $idBil;
$query_bil=@mysql_query($sql_bil);
$res_bil=@mysql_fetch_assoc($query_bil);

//consulta numero da maquina
$sql_idMaq = "
	SELECT
		id_maquina,
		numero			
	FROM
		maquinas
	WHERE
		id_maquina = " . $res_bil['id_maquina'];
$query_idMaq=@mysql_query($sql_idMaq);
$res_idMaq=@mysql_fetch_assoc($query_idMaq);

//consulta modelo bilheteiro
$sql_modBil = "
	SELECT
		id_modelo,
		descricao				
	FROM
		modelos_bilheteiro
	WHERE
		id_modelo = " . $res_bil['modelo_id'];
$query_modBil=@mysql_query($sql_modBil);
$res_modBil=@mysql_fetch_assoc($query_modBil);

//echo $sql_disp;
$return .= $res_bil['serie'] . ",";
$return .= $res_modBil['descricao'] . ",";
$return .= $res_idMaq['numero'] . ",";
$return .= $res_idMaq['id_maquina'] . ",";
$return .= $res_bil['id_bilheteiro'] . ",";
$return .= $res_modBil['id_modelo'] . ",";


echo $return;

?>