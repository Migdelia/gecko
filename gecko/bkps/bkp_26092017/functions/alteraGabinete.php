<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$idTpGab = $_POST['input_id_Gabinetes'];
$descricao = $_POST['input_desc_Gabinetes'];
$cod = $_POST['input_cod_Gabinetes'];



//busca dados do disp
$sql_up = "UPDATE 
				tipo_maquina
			SET
				descricao = '".$descricao."',
				codigo = '".$cod."'
			WHERE
				id_tipo_maquina = '".$idTpGab."'";

//
if(@mysql_query($sql_up) )
{
	//sleep(1);
	//
	//header('Location: ../gabinetes.php');
	exit(utf8_encode(true));
}
else
{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}

?>