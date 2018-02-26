<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$data_fechamento = $_POST['data_fechamento'];
$id_fechamento = $_POST['id_fechamento'];
$fechada = $_POST['fechada'];
$id_leitura = $_POST['id_leitura'];


//busca dados do disp
$sql_up = "UPDATE 
				leitura
			SET
				data_fechamento = '".$data_fechamento."',
				fechada = '".$fechada."',
				id_fechamento = '".$id_fechamento."'

			WHERE
				id_leitura = '".$id_leitura."'";
				
		
if(@mysql_query($sql_up) )
{
	//sleep(1);
	//
	//header('Location: ../chapas.php');
	exit(utf8_encode(1));
}
else
{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(0));
}


?>