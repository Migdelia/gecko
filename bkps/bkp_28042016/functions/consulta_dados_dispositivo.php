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

//consulta o nome do jogo * $return .= $res_disp['GameId'] . ",";
$sql_nomeJogo = "
	SELECT
		nome				
	FROM
		jogo
	WHERE
		id_jogo = " . $res_disp['GameId'];
		
$query_nomeJogo=@mysql_query($sql_nomeJogo);
$res_nomeJogo=@mysql_fetch_assoc($query_nomeJogo);

$return .= $res_nomeJogo['nome'] . ",";

//formata datas 
$return .= date("d-m-Y (H:m:s)", strtotime($res_disp['expirationDate'])). ",";
$return .= date("d-m-Y (H:m:s)", strtotime($res_disp['lastUpdate'])). ","; 

//declara periodo
$return .= $res_disp['period'] . ",";



//consulta o nome do usuario
$sql_nome = "
	SELECT
		nome				
	FROM
		logins
	WHERE
		id_login = " . $res_disp['userId'];
$query_nome=@mysql_query($sql_nome);
$res_nome=@mysql_fetch_assoc($query_nome);

$return .= $res_nome['nome'];


//$return = $sql_disp;
echo $return;

?>