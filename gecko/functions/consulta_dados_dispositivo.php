<?php
session_start();
include('../conn/connDongle.php');
include('functions.php');
//include('validaLogin.php');

$idDisp = $_POST['id'];	


$return = "";

//busca dados do disp
$sql_disp = "
	SELECT
		*				
	FROM
		StreetDongle
	WHERE
		MachineId = " . $idDisp;
$query_disp=@mysql_query($sql_disp);
$res_disp=@mysql_fetch_assoc($query_disp);


$return .= $res_disp['MachineId'] . ",";

//conecta no banco sys adm
include('../conn/conn.php');
include('validaLogin.php');

//consulta os dados da maquina
$sql_dados_maquina = "
	SELECT
		numero,
		jogo,
		operador
	FROM
		`vw_maquinas`
	WHERE
		`interface` = '".$res_disp['MachineId']."'
	";


$query_dados_maquina=@mysql_query($sql_dados_maquina);
$res_dados_maquina=@mysql_fetch_assoc($query_dados_maquina);

$return .= $res_dados_maquina['jogo'] . ",";

//formata datas 
$return .= date("d-m-Y (H:m:s)", strtotime($res_disp['expirationDate'])). ",";
$return .= date("d-m-Y (H:m:s)", strtotime($res_disp['lastUpdate'])). ","; 

//declara periodo
$return .= $res_disp['period'] . ",";
$return .= $res_dados_maquina['operador'];


//$return = $sql_disp;
echo $return;

?>