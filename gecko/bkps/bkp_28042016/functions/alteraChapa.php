<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$idChapa = $_POST['id_chapa'];
$idModelo = $_POST['input_modChapa_Chapa'];
$serie = $_POST['edit_serie_Chapa'];
$idMaq = $_POST['input_maqChapa_Chapa'];




//busca dados do disp
$sql_up = "UPDATE 
				chapas
			SET
				id_modelo = '".$idModelo."',
				id_maquina = '".$idMaq."'
			WHERE
				id_chapa = '".$idChapa."'";
				
		
if(@mysql_query($sql_up) )
{
	sleep(1);
	//
	header('Location: ../chapas.php');
}
else
{
	exit(utf8_encode('ERRO!'));
}


?>