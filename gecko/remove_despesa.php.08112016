<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$desp = $_POST['id_desp'];


	$sql_add = "DELETE FROM desconto_leit_fecha WHERE id_desconto = $desp";
	

if(@mysql_query($sql_add) )
{
	exit(utf8_encode('true'));
}else{
	exit(utf8_encode("false"));
}
?>