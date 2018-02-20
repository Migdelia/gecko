<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idLocal = $_POST['id'];	


$return = "";

//busca dados do loc
$sql_maquinas = "
	SELECT
		codigo,
		numero,
		nome,
		id_maquina		
	FROM
		vw_maquinas
	WHERE
		id_local = ". $idLocal ."
	AND
		excluido = 'N'";
$query_maquinas=@mysql_query($sql_maquinas);

//
while($res_maquina=@mysql_fetch_assoc($query_maquinas)) 
{
	$return .=  $res_maquina['codigo'] . " - " . $res_maquina['numero'] . " | " . $res_maquina['id_maquina'] . ", ";
	$nomeLocal = $res_maquina['nome'];
}

$return .=  $nomeLocal;

echo $return;

?>