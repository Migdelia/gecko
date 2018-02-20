<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$descricao = $_POST['input_descricao_Gabinete'];
$codGab = $_POST['input_cod_Gabinete'];


//
$sql_add = "INSERT INTO 
					tipo_maquina 
					(
						descricao,
						codigo
					) 
					VALUES
					(
						'".$descricao."',
						'".$codGab."'											
					)";
	

					
//				
if(@mysql_query($sql_add) )
{
	sleep(1);
	header('Location: ../gabinetes.php');
}else{
	exit(utf8_encode('ERRO!'));
}
?>