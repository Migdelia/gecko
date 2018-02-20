<?php
session_start();
include('../conn/conn.php');


$idLocal = $_POST['idLocal'];

//consulta o dyndns desse local
$sql_dns = "SELECT dns FROM locais_integrados WHERE id_local = " . $idLocal;
$query_dns=@mysql_query($sql_dns);
$res_dns=@mysql_fetch_assoc($query_dns);


//conn banco local
$lnk = "/gecko";
$mail_from = "sistema@calabazachile.com";
$host = $res_dns['dns'];
$user = "root";
$pass = "999865";
$dbas = "leitura";
$dominio = 'http://calasys.dyndns.org/gecko';

$conecta = @mysql_connect($host, $user, $pass);
@mysql_select_db($dbas,$conecta);


//include('../conn/connLocalIntegrado.php');
include('functions.php');


//recebe os valores
$arrayValores = $_POST['valores'];
$valor = explode(';',$arrayValores);


//
//trata valores
//
//trata denomination
$denomination = ($valor[1]*100);

//trata pct
$percentage = ($valor[2]*100);

//trata tipo de maquina
if($valor[3] == 'Server')
{
	$tpMaq = 1;	
}
else
{
	$tpMaq = 0;	
}

//trata db
if($valor[12] == 'SI')
{
	$db = 1;	
}
else
{
	$db = 0;	
}

//trata FamBig
if($valor[13] == 'SI')
{
	$famBig = 1;	
}
else
{
	$famBig = 0;	
}

//trata fav big
if($valor[14] == 'A')
{
	$favBig = 70000;
}
else if($valor[14] == 'B')
{
	$favBig = 60000;
}
else if($valor[14] == 'C')
{
	$favBig = 50000;
}
else if($valor[14] == 'D')
{
	$favBig = 40000;	
}

//trata FamBig
if($valor[15] == 'SI')
{
	$fam = 1;	
}
else
{
	$fam = 0;	
}


//trata fav big
if($valor[16] == 'A')
{
	$fav = 20000;
}
else if($valor[16] == 'B')
{
	$fav = 15000;
}
else if($valor[16] == 'C')
{
	$fav = 10000;
}
else if($valor[16] == 'D')
{
	$fav = 5000;	
}

//trata PK
if($valor[18] == 'SI')
{
	$pk = 1;	
}
else
{
	$pk = 0;	
}


//limpa valor
$limPago = str_replace(".","",$valor[17]);
$limPago = ($limPago / 1000);

$insert = "INSERT INTO reConfig (
	id,
	currencyName,
	denomination,
	percentage,
	machineType,
	acumuladoMin,
	acumuladoMax,
	currentAcu,
	acumuladoSMin,
	acumuladoSMax,
	currentAcuS,
	jackpotValue,
	limDouble,
	db,
	fam,
	fav,
	famS,
	favS,
	payoutLim,
	billValid,
	pk,
	percentageBingo
)
VALUES
	(
		'$valor[19]',
		'$',
		'$denomination',
		'$percentage',
		'$tpMaq',
		'$valor[4]',
		'$valor[5]',
		'$valor[6]',
		'$valor[7]',
		'$valor[8]',
		'$valor[9]',
		'$valor[10]',
		'$valor[11]',
		'$db',
		'$famBig',
		'$favBig',
		'$fam',
		'$fav',
		'$limPago',
		'',
		'$pk',
		13
	)";


if(@mysql_query($insert) )
{
	//
	//header('Location: ../ciudades.php');
	$return = 1;
}else{
	//exit(utf8_encode('ERRO!'));
	$return = 0;
}
//$return = $insert;


echo $return;

?>