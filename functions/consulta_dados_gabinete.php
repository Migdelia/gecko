<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idGab = $_POST['id'];	

//
$return = "";

//busca dados do disp
$sql_gab = "
	SELECT
		*				
	FROM
		tipo_maquina
	WHERE
		id_tipo_maquina = " . $idGab;
$query_gab=@mysql_query($sql_gab);
$res_gab=@mysql_fetch_assoc($query_gab);

//echo $sql_disp;
$return .= $res_gab['id_tipo_maquina'] . ",";
$return .= $res_gab['descricao'] . ",";
$return .= $res_gab['codigo'] . ",";

echo $return;

?>