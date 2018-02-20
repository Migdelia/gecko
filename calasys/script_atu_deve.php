<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$idDeve = $_POST['id_deve'];	
$deve = $_POST['vl_deve'];	
$devePago = $_POST['deve_pago'];

	//calcular o novo saldo a ser atualizado.
	$sql_saldo = "
		SELECT
			saldo,
			valor,
			valor_recebido
		FROM
			`deve`
		WHERE
			deve.id_deve = '".$idDeve."'
		";
	$query_saldo=@mysql_query($sql_saldo);
	$result_saldo=@mysql_fetch_assoc($query_saldo);	
	
	$dif = $result_saldo['valor'] - $result_saldo['valor_recebido'];
	$saldoAnt = $result_saldo['saldo'] - $dif;
	$saldoNovo = $saldoAnt + $deve - $devePago;


	//gera aql para atualizar dados.
	$sql_up = "UPDATE deve SET valor=".$deve.", valor_recebido=".$devePago.", saldo=".$saldoNovo." WHERE id_deve=".$idDeve;


if(@mysql_query($sql_up) )
{
	$retorno="true";
}else{
	$retorno="false";
}

echo $retorno;
?>