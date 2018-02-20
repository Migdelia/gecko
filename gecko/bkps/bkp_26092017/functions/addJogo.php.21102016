<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idJogo = $_POST['input_id_Juego'];
$codJOgo = $_POST['input_codigo_Juego'];
$nomeJogo = $_POST['input_name_Juego'];
$pctEspJogo = $_POST['input_pct_Juego'];

//
$sql_add = "INSERT INTO 
					jogo 
					(
						id_jogo,
						nome,
						codigo,
						porcentagem
					) 
					VALUES
					(
						'".$idJogo."',
						'".$nomeJogo."',
						'".$codJOgo."',
						'".$pctEspJogo."'												
					)";
	

					
//				
if(@mysql_query($sql_add) )
{
	sleep(1);
	header('Location: ../juegos.php');
}else{
	exit(utf8_encode('ERRO!'));
}
?>