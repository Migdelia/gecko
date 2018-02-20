<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$desp = $_POST['id_desp'];

//consulta valor da despesa a ser excluida / e id da leitura
$sql_vl_desp = "SELECT valor_desconto, id_leitura_fechamento FROM desconto_leit_fecha WHERE id_desconto = " . $desp;
$query_vl_desp=@mysql_query($sql_vl_desp);
$rst_vl_desp=@mysql_fetch_assoc($query_vl_desp);


//
$sql_add = "DELETE FROM desconto_leit_fecha WHERE id_desconto = " . $desp;

//
if(@mysql_query($sql_add) )
{
	//atualiza o valor do total_desconto dessa leitura
	$sql_vlAtual_desconto = "SELECT total_desconto FROM leitura WHERE id_leitura = " . $rst_vl_desp['id_leitura_fechamento'];
	$qry_vlAtual_desconto=@mysql_query($sql_vlAtual_desconto);
	$rst_vlAtual_desconto=@mysql_fetch_assoc($qry_vlAtual_desconto);
	
	//
	$nv_valor_desc = $rst_vlAtual_desconto['total_desconto'] - $rst_vl_desp['valor_desconto'];
	
	
	//atualiza o total_desconto da leitura
	$sql_upd_leit = "UPDATE 
						leitura
					SET 
						total_desconto = ".$nv_valor_desc."
					WHERE
						id_leitura = " . $rst_vl_desp['id_leitura_fechamento'];
	@mysql_query($sql_upd_leit);
	
	
	exit(utf8_encode('true')."-".$rst_vl_desp['valor_desconto']);
}else{
	exit(utf8_encode("false"));
}
?>