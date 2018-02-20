<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idChapa = $_POST['id'];	

//
$return = "";

//consulta modelo placa
$sql_modChapa = "
	SELECT
		id_modelo,
		descricao,
		codigo			
	FROM
		modelos_chapa
	WHERE
		id_modelo = " . $idChapa;
$query_modChapa=@mysql_query($sql_modChapa);
$res_modChapa=@mysql_fetch_assoc($query_modChapa);

//echo $sql_disp;
$return .= $res_modChapa['id_modelo'] . ",";
$return .= $res_modChapa['descricao'] . ",";
$return .= $res_modChapa['codigo'] . ",";


echo $return;

?>