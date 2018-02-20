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
	$retorno=1;
}
else
{
	$retorno= 0;
}

sleep(1);
echo $retorno;
?>