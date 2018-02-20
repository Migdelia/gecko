<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idJogo = $_POST['id'];
$nomeJogo = $_POST['nome'];
$codJogo = $_POST['codigo'];





//busca dados do disp
$sql_up = "UPDATE 
				jogo
			SET
				nome = '".$nomeJogo."',
				codigo = '".$codJogo."'
			WHERE
				id_jogo = '".$idJogo."'";
				
if(@mysql_query($sql_up) )
{
	//$retorno=1;
	exit(utf8_encode(true));
}
else
{
	//$retorno= 0;
	exit(utf8_encode(false));
}

//sleep(1);
//echo $retorno;

?>