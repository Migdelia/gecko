<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$idPendrive = $_POST['id_pendrive'];
$idModelo = $_POST['input_modPen_Pendrive'];
$serie = $_POST['edit_serie_Pendrive'];
$idMaq = $_POST['input_maqPen_Pendrive'];


//busca dados do disp
$sql_up = "UPDATE 
				pendrives
			SET
				serie = '".$serie."',
				modelo_id = '".$idModelo."',
				id_maquina = '".$idMaq."'
			WHERE
				id_pendrive = '".$idPendrive."'";
				
		
		
if(@mysql_query($sql_up) )
{
	//sleep(1);
	//
	//header('Location: ../pendrives.php');
	exit(utf8_encode(true));
}
else
{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}


?>