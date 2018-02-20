<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$nomeCidade = $_POST['input_add_Ciudad'];


//
$sql_add = "INSERT INTO 
					regiao 
					(
						nome_cidade,
						excluido
					) 
					VALUES
					(
						'".$nomeCidade."',
						'N'				
					)";
					
if(@mysql_query($sql_add) )
{
	//
	header('Location: ../ciudades.php');
}else{
	exit(utf8_encode('ERRO!'));
}

?>