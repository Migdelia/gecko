<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$idModelo = $_POST['edit_idMod_Chapa'];
$descricao = $_POST['edit_descri_Chapa'];
$codChapa = $_POST['edit_cod_Chapa'];


//busca dados do disp
$sql_up = "UPDATE 
				modelos_chapa
			SET
				codigo = '".$codChapa."',
				descricao = '".$descricao."'
			WHERE
				id_modelo = '".$idModelo."'";
				
		
if(@mysql_query($sql_up) )
{
	//sleep(1);
	//
	//header('Location: ../chapas.php');
	exit(utf8_encode(true));
}
else
{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}


?>