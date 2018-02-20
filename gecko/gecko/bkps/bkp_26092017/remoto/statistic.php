<?php
include "bd.php";
?>

<!DOCTYPE html>
 
<html>
<head>
        <title>Estatisticas</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="estilo.css">
</head>
     
     
<body>
<h1>Estatisticas</h1>

<?php

$idMaquina = $_GET['id'];
if ($idMaquina <= 0) {
	header("index.php");
	exit;
}

$pesquisa = "SELECT * FROM Statistic WHERE id = " . $idMaquina;
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$linha=mysql_fetch_array($resultado);

$creditIn = $linha["creditIn"];
$creditOut = $linha["creditOut"];
$moneyInWhole = $linha["moneyInWhole"];
$moneyInCents = $linha["moneyInCents"];
$moneyOutWhole = $linha["moneyOutWhole"];
$moneyOutCents = $linha["moneyOutCents"];
$moneyIn = $linha["moneyIn"];
$moneyOut = $linha["moneyOut"];
$vPlayed = $linha["vPlayed"];
$vWon = $linha["vWon"];
$vdPlayed = $linha["vdPlayed"];
$vdWon = $linha["vdWon"];
$gPlayed = $linha["gPlayed"];
$gWon = $linha["gWon"];
$dPlayed = $linha["dPlayed"];
$dWon = $linha["dWon"];
$jPaid = $linha["jPaid"];
$aPaid = $linha["aPaid"];
$asPaid = $linha["asPaid"];
$aJ = $linha["aJ"];
$aA = $linha["aA"];
$aAS = $linha["aAS"];

?>

<h2><?php echo $idMaquina; ?></h2>
<table border=1 >
<tr><td>Credit In </td><td> Credit Out </td><td> Money In Whole </td><td> Money In Cents </td><td> Money Out Whole </td><td> Money Out Cents </td><td> Money In </td><td> Money Out </td><td> V Played </td><td> V Won </td><td> Vd Played </td></tr>
<tr><td><?php echo $creditIn; ?></td><td><?php echo $creditOut; ?></td><td><?php echo $moneyInWhole; ?></td><td><?php echo $moneyInCents; ?></td><td><?php echo $moneyOutWhole; ?></td><td><?php echo $moneyOutCents; ?></td><td><?php echo $moneyIn; ?></td><td><?php echo $moneyOut; ?></td><td><?php echo $vPlayed; ?></td><td><?php echo $vWon; ?></td><td><?php echo $vdPlayed; ?></td></tr>
<tr><td> Vd Won </td><td> G Played </td><td> G Won </td><td> D Played </td><td> D Won </td><td> J Paid </td><td> A Paid </td><td> AS Paid </td><td> AJ </td><td> AA </td><td> AS </td></tr>
<tr><td><?php echo $vdWon; ?></td><td><?php echo $gPlayed; ?></td><td><?php echo $gWon; ?></td><td><?php echo $dPlayed; ?></td><td><?php echo $dWon; ?></td><td><?php echo $jPaid; ?></td><td><?php echo $aPaid; ?></td><td><?php echo $asPaid; ?></td><td><?php echo $aJ; ?></td><td><?php echo $aA; ?></td><td><?php echo $aS; ?></td></tr>
</table>

<a href=index.php>Voltar</a>

</body>
 
</html>
