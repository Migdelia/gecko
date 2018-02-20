<?php
session_start();
include('../conn/conn.php');
include('functions.php');
//include('validaLogin.php');

$idMaq = $_POST['id'];
$idLoc = $_POST['idLocal'];
$return = "";

//pegar o dns desse local
$sql_dns = "SELECT dns FROM locais_integrados WHERE id_local = " . $idLoc;
$query_dns=@mysql_query($sql_dns);
$res_dns=@mysql_fetch_assoc($query_dns);


//conectar no local.
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
	//consulta dados Ultimos jogos 
	$sql_game = "SELECT * FROM lastGames WHERE id = " . $idMaq . " ORDER BY `index` DESC LIMIT 50";
	$query_game=@mysql_query($sql_game);

	//
	while($res_game=@mysql_fetch_assoc($query_game)) 
	{
		$return .= $res_game["symbols"];
		$return .= $res_game["creditsBefore"] . ";";//15
		$return .= $res_game["creditsAfter"] . ";";//16
		$return .= $res_game["totalWin"] . ";";//17
		$return .= $res_game["winReels"] . ";";//18
		$return .= $res_game["winBonus1"] . ";";//19
		$return .= $res_game["winBonus2"] . ";";//20
		$return .= $res_game["winBonus3"] . ";";//21
		$return .= $res_game["acumuladoPaid"] . ";";//22
		$return .= $res_game["jackpotPaid"] . ";";//23
		$return .= $res_game["acumuladoPaid"] . ";";//24	
		$return .= $res_game["linesBet"] . ";";//25
		$return .= $res_game["totalBet"] . ";";//26	
		$return .= $res_game["linesGain"];//27		
		$return .= "/";
	}	
}






//$return = $sql_statistic;
echo $return;

?>