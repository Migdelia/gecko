<?php
include "bd.php";

$Temp = $_POST['currencyName'];
$Temp = explode("-",$Temp);

switch ($Temp[1]){
	case 1:
		$currencyName = "$";
		break;
	case 2:
		$currencyName = "EUR";
		break;
	case 3:
		$currencyName = "USD";
		break;
}

$denomination = $_POST['denomination'];
$percentage = $_POST['percentage'];
$machineType = $_POST['machineType'];
$acumuladoMin = $_POST['acumuladoMin'];
$acumuladoMax = $_POST['acumuladoMax'];
$currentAcu = $_POST['currentAcu'];
$acumuladoSMin = $_POST['acumuladoSMin'];
$acumuladoSMax = $_POST['acumuladoSMax'];
$currentAcuS = $_POST['currentAcuS'];
$jackpotValue = $_POST['jackpotValue'];
$limDouble = $_POST['limDouble'];
$db = $_POST['db'];
$fam = $_POST['fam'];
$fav = $_POST['fav'];
$famS = $_POST['famS'];
$favS = $_POST['favS'];
$payoutLim = $_POST['payoutLim'];;
$billValid = "";
$pk = $_POST['pk'];
$percentageBingo = $_POST['percentageBingo'];

$pesquisa = "INSERT INTO reConfig (id, currencyName, denomination, percentage, machineType, acumuladoMin, acumuladoMax, currentAcu, acumuladoSMin, acumuladoSMax, currentAcuS, jackpotValue, limDouble, db, fam, fav, famS, favS, payoutLim, billValid, pk, percentageBingo ) VALUES ('$Temp[0]', '$currencyName', '$denomination', '$percentage', '$machineType', '$acumuladoMin', '$acumuladoMax', '$currentAcu', '$acumuladoSMin', '$acumuladoSMax', '$currentAcuS', '$jackpotValue', '$limDouble', '$db', '$fam', '$fav', '$famS', '$favS', '$payoutLim', '$billValid', '$pk', '$percentageBingo' )"; 
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$linha=mysql_fetch_array($resultado);

echo $pesquisa;

//header("Location: configuration.php?id=$Temp[0]");

?>


