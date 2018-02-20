<?php
include "bd.php";
?>

<!DOCTYPE html>
 
<html>
<head>
<title>Status</title>
<meta charset="utf-8">
<link rel="stylesheet" href="estilo.css">
<script type="text/JavaScript">
	<!--

	function doLoad()
	{
	setTimeout( "refresh()", 5*1000 );
	}

	function refresh()
	{
	window.location.href = window.location;
	}
	//-->
</script>

</head>
<body onload="doLoad();" background=#003333>
<h1>Status</h1>

<?php

$idMaquina = $_GET['id'];
if ($idMaquina <= 0) {
	header("index.php");
	exit;
}

$pesquisa = "SELECT * FROM Reading WHERE id = " . $idMaquina;
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$linha=mysql_fetch_array($resultado);

$uptime = $linha["uptime"];

$issueDate = $linha["issueDate"];
$ip = $linha["ip"];
$ip6 = $linha["ip6"];
$mac = $linha["mac"];

$getCredits = $linha["getCredits"];
$hwid = $linha["hwid"];
if(!$hwid)
	$hwid = 0; 
$tmp1 = $issueDate;
usleep(2000000);
$pesquisa = "SELECT * FROM Reading WHERE id = " . $idMaquina;
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$linha2=mysql_fetch_array($resultado);
$tmp2 = $linha2["issueDate"]; 

if($tmp1 == $tmp2)
	$on = "Offline";
else
	$on = "Online";

echo $on;

?>

<div id=imgMachine background-color=red;  >
<img src=images/<?php echo $hwid; ?>.png  />
</div>

<table border="1"><tr><td>ID </td><td>Creditos</td><td>Uptime </td><td>Ip </td><td>Ipv6</td><td>Mac</td></tr>
<tr><td><?php echo $idMaquina; ?></td><td><?php echo $getCredits; ?></td><td><?php echo gmdate("H:i:s", $uptime); ?></td><td><?php echo $ip; ?></td><td><?php echo $ip6; ?></td><td><?php echo $mac; ?></td></tr>
</table>

<a href=credits.php?id=<?php echo $idMaquina; ?> >Crédito</a>
<a href=statistic.php?id=<?php echo $idMaquina; ?>>Estatisticas</a>
<a href=configuration.php?id=<?php echo $idMaquina; ?>>Configuracao</a>
<a href=lastpayouts.php?id=<?php echo $idMaquina; ?>>Last Payouts</a>
<a href=lastbills.php?id=<?php echo $idMaquina; ?>>Last Bills</a>
<a href=lastprizes.php?id=<?php echo $idMaquina; ?>>Last Prizes</a>
<a href=lastgames.php?id=<?php echo $idMaquina; ?>&gameID=1>Last Games</a>
<a href=index.php>Voltar</a>

</body>
 
</html>
