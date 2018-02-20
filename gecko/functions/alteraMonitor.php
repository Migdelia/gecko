<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$idMonitor = $_POST['id_monitor'];
$idModelo = $_POST['input_modMon_Monitor'];
$serie = $_POST['edit_serie_Monitor'];
$idMaq = $_POST['input_maqMon_Monitor'];


//busca dados do disp
$sql_up = "UPDATE 
				monitores
			SET
				serie = '".$serie."',
				id_modelo = '".$idModelo."',
				id_maquina = '".$idMaq."'
			WHERE
				id_monitor = '".$idMonitor."'";
				

if(@mysql_query($sql_up) )
{
	//sleep(1);
	//
	//header('Location: ../monitores.php');
	exit(utf8_encode(true));
}
else
{
	exit(utf8_encode(false));
}


?>