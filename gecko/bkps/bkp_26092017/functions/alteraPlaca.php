<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$idPlaca = $_POST['id_placa_mae'];
$idModelo = $_POST['input_modPlac_Placa'];
$serie = $_POST['edit_serie_Placa'];
$idMaq = $_POST['input_maqPlac_Placa'];




//busca dados do disp
$sql_up = "UPDATE 
				placa_mae
			SET
				serie = '".$serie."',
				modelo_id = '".$idModelo."',
				id_maquina = '".$idMaq."'
			WHERE
				id_placa = '".$idPlaca."'";
				
				
		
if(@mysql_query($sql_up) )
{
	//sleep(1);
	//
	//header('Location: ../placas.php');
	exit(utf8_encode(true));
}
else
{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}


?>