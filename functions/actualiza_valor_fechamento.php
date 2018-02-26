<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$id_fechamento = $_POST['id'];
$total_pagar = $_POST['pagar'];



//busca dados do disp
$sql_up = "UPDATE 
				fechamento
			SET
				valor_total= '".$total_pagar."'
				
			WHERE
				id_fechamento = '".$id_fechamento."'";
				
		
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