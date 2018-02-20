<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idChapa = $_POST['id'];	

//
$return = "";

//busca dados do disp
$sql_chapa = "
	SELECT
		*				
	FROM
		chapas
	WHERE
		id_chapa = " . $idChapa;
$query_chapa=@mysql_query($sql_chapa);
$res_chapa=@mysql_fetch_assoc($query_chapa);

//consulta numero da maquina
$sql_idMaq = "
	SELECT
		id_maquina,
		numero			
	FROM
		maquinas
	WHERE
		id_maquina = " . $res_chapa['id_maquina'];
$query_idMaq=@mysql_query($sql_idMaq);
$res_idMaq=@mysql_fetch_assoc($query_idMaq);

//consulta modelo placa
$sql_modChapa = "
	SELECT
		id_modelo,
		descricao				
	FROM
		modelos_chapa
	WHERE
		id_modelo = " . $res_chapa['id_modelo'];
$query_modChapa=@mysql_query($sql_modChapa);
$res_modChapa=@mysql_fetch_assoc($query_modChapa);

//echo $sql_disp;
$return .= $res_chapa['id_chapa'] . ",";
$return .= $res_modChapa['descricao'] . ",";
$return .= $res_idMaq['numero'] . ",";
$return .= $res_idMaq['id_maquina'] . ",";
$return .= $res_chapa['id_chapa'] . ",";
$return .= $res_modChapa['id_modelo'] . ",";


echo $return;

?>