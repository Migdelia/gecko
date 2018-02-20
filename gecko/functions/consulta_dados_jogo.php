<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idJogo = $_POST['id'];	

//
$return = "";

//busca dados do disp
$sql_jogos = "
	SELECT
		*				
	FROM
		jogo
	WHERE
		id_jogo = " . $idJogo;
$query_jogos=@mysql_query($sql_jogos);
$res_jogos=@mysql_fetch_assoc($query_jogos);

//echo $sql_disp;
$return .= $res_jogos['id_jogo'] . ",";
$return .= $res_jogos['nome'] . ",";
$return .= $res_jogos['codigo'] . ",";


echo $return;

?>