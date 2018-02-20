<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$codigo = $_POST['input_insCodigo_Chapa'];
$descricao = $_POST['input_insDescri_Chapa'];


//
$sql_add = "INSERT INTO 
					modelos_chapa 
					(
						codigo,
						descricao
					) 
					VALUES
					(
						'".$codigo."',
						'".$descricao."'												
					)";


					
//				
if(@mysql_query($sql_add) )
{
	//sleep(1);
	//header('Location: ../chapas.php');
	exit(utf8_encode(true));
}else{
	exit(utf8_encode(false));
}

?>