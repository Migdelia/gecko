<?php
session_start();
include('../conn/conn.php');
include('functions.php');
//include('validaLogin.php');

$idMaq = $_POST['id'];	


//busca dados do disp
$sql_disp = "
	SELECT
		interface as numero,
		operador,
		numero as maquina
	FROM
		vw_maquinas
	WHERE
		id_maquina = " . $idMaq;
$query_disp=@mysql_query($sql_disp);
$res_disp=@mysql_fetch_assoc($query_disp);

$operador = $res_disp['operador'];

//verifica se é dongle o interface
if($res_disp['numero'] > 69999 and $res_disp['numero'] < 90000)
{
	$tipoDisp = "Dongle";
	include('../conn/connDongle.php');
	
	//consulta dados da interface
	$sql_dongle = "SELECT MachineId, GameId, period, expirationDate FROM StreetDongle WHERE MachineId = " . $res_disp['numero'];
	$query_dongle=@mysql_query($sql_dongle);
	$res_dongle=@mysql_fetch_assoc($query_dongle);
	
	$numDisp = $res_dongle['MachineId'];
	$periodo = $res_dongle['period'];
	$expiracao = date('d-m-Y', strtotime($res_dongle['expirationDate']));
	$jogo = $res_dongle['GameId'];
}
else
{
	$tipoDisp = "Interface";
	include('../conn/connInt.php');
	
	//consulta dados da interface
	$sql_int = "SELECT id, title, period, expirationDate FROM Machine WHERE id = " . $res_disp['numero'];
	$query_int=@mysql_query($sql_int);
	$res_int=@mysql_fetch_assoc($query_int);
	
	$numDisp = $res_int['id'];
	$periodo = $res_int['period'];
	$expiracao = date('d-m-Y', strtotime($res_int['expirationDate']));
	$jogo = $res_int['title'];
}


//array de retorno
$return .= $res_disp['maquina'] . ",";
$return .= $numDisp . ",";
$return .= $tipoDisp . ",";
$return .= $periodo . ",";
$return .= $expiracao . ",";
$return .= $operador . ",";
$return .= $jogo . ",";



//$return = $res_disp['numero'];
echo $return;
?>