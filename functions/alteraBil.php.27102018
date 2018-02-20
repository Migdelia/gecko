<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$idBil = $_POST['id_bilheteiro'];
$idModelo = $_POST['input_modBil_Billetero'];
$serie = $_POST['edit_serie_Billetero'];
$idMaq = $_POST['input_maqBil_Billetero'];

echo $idBil . "<br />";
echo $idModelo . "<br />";
echo $serie . "<br />";
echo $idMaq . "<br />"; 


//busca dados do disp
$sql_up = "UPDATE 
				bilheteiros
			SET
				serie = '".$serie."',
				modelo_id = '".$idModelo."',
				id_maquina = '".$idMaq."'
			WHERE
				id_bilheteiro = '".$idBil."'";
	
		
if(@mysql_query($sql_up) )
{
	sleep(1);
	//
	header('Location: ../billeteros.php');
}
else
{
	exit(utf8_encode('ERRO!'));
}


?>