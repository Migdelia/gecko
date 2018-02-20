<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$desp = $_POST['id_desp'];

//consulta valor da despesa a ser excluida
$sql_vl_desp = "SELECT valor_desconto FROM desconto_leit_fecha WHERE id_desconto = " . $desp;
$query_vl_desp=@mysql_query($sql_vl_desp);
$rst_vl_desp=@mysql_fetch_assoc($query_vl_desp);


//
$sql_add = "DELETE FROM desconto_leit_fecha WHERE id_desconto = " . $desp;

if(@mysql_query($sql_add) )
{
	exit(utf8_encode('true')."-".$rst_vl_desp['valor_desconto']);
}else{
	exit(utf8_encode("false"));
}
?>