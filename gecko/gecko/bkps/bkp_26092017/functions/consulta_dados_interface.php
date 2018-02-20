<?php
session_start();
include('../conn/conn.php');
include('functions.php');

$idInt = $_POST['id'];	


$return = "";

//busca dados do disp
$sql_int = "
	SELECT
		*				
	FROM
		interface
	WHERE
		id_interface = " . $idInt;
$query_int=@mysql_query($sql_int);
$res_int=@mysql_fetch_assoc($query_int);


$return .= $res_int['numero'] . ",";

$sql_jogo = "SELECT nome FROM jogo WHERE id_jogo = ". $res_int['id_jogo'];
$query_jogo=@mysql_query($sql_jogo);
$res_jogo=@mysql_fetch_assoc($query_jogo);

$return .= $res_jogo['nome'] . ",";


$sql_maquina = "SELECT numero FROM maquinas WHERE id_maquina = ". $res_int['id_maquina'];
$query_maquina=@mysql_query($sql_maquina);
$res_maquina=@mysql_fetch_assoc($query_maquina);

$return .= $res_maquina['numero'] . ",";
$return .= $res_int['serie'];


//$return = $sql_disp;
echo $return;

?>