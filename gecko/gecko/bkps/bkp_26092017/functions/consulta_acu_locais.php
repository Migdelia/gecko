<?php
session_start();
include('../conn/conn.php');
include('functions.php');

//consulta lista de dns
$sql_dns = "SELECT dns, id_local FROM locais_integrados";
$query_dns=@mysql_query($sql_dns);


//
while($res_dns=@mysql_fetch_assoc($query_dns))
{
	//consultar acumulado dos locais.
	$host = $res_dns['dns'];
	$user = "root";
	$pass = "999865";
	$dbas = "leitura";
	if (!$conecta = @mysql_connect($host, $user, $pass) ) 
	{
		//
	}
	else if (!@mysql_select_db($dbas,$conecta)) 
	{
		//
	}
	else
	{
		//consulta qual é o servidor desse local
		$sql_acu = "SELECT * FROM Config WHERE machineType = 1 LIMIT 1";		
		$query_acu=@mysql_query($sql_acu);
		$res_acu=@mysql_fetch_assoc($query_acu);
		
		$AcuAtual = $res_acu['currentAcu'] / 1000;
		$AcuMax = $res_acu['acumuladoMax'] * 1000;
		$jktAtual = $res_acu['jackpotValue'] * 1000;
			
		
		$return .= $res_dns['id_local'] . ",";
		$return .= number_format($AcuAtual,0,"",".") . ",";
		$return .= number_format($AcuMax,0,"",".") . ",";
		$return .= number_format($jktAtual,0,"",".") . "|";			
	}		
}


//$return = "PPK";


echo $return;

?>

