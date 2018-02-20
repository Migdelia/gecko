<?php
include "bd.php";
?>

<!DOCTYPE html>
 
<html>
<head>
        <title>Last Games</title>
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
     
     
<body>
<h1>Last Games</h1>

<?php

$idMaquina = $_GET['id'];
if ($idMaquina <= 0) {
	header("index.php");
	exit;
}
$gameID = $_GET['gameID'];
if ($gameID <= 0) {
	header("index.php");
	exit;
}

//$selectFirst = "SELECT * FROM lastGames  WHERE id = '" .$idMaquina. "' order by game desc limit 1 ";
$selectFirst = "SELECT * FROM lastGames  WHERE id = '" .$idMaquina. "'";
$result = mysql_query($selectFirst) or die ("ERROR!");
$line=mysql_fetch_array($result);
$num_rows = mysql_num_rows($result);

//$gameID = 2;
$pesquisa = "SELECT * FROM lastGames  WHERE id = '" .$idMaquina. "' AND game = " .$gameID;
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$linha=mysql_fetch_array($resultado);
//$num_rows = mysql_num_rows($resultado);


$game = $linha["game"];
//$maxGame = $line["maxGame"];
$maxGame = $num_rows;
$totalBet = $linha["totalBet"];
$linesBet = $linha["linesBet"];
$linesGain = $linha["linesGain"];
$symbols = $linha["symbols"];
$creditsBefore = $linha["creditsBefore"];
$creditsAfter = $linha["creditsAfter"];
$totalWin = $linha["totalWin"];
$winReels = $linha["winReels"];
$winBonus1 = $linha["winBonus1"];
$winBonus2 = $linha["winBonus2"];
$winBonus3 = $linha["winBonus3"];
$acumuladoPaid = $linha["acumuladoPaid"];
$jackpotPaid = $linha["jackpotPaid"];
$acumuladoSPaid = $linha["acumuladoSPaid"];

$symbolsTmp = explode(";", $symbols);

$previous = $gameID - 1;
if ( $previous <= 0 )
	$previous = $maxGame;

$next = $gameID + 1;
if( $next > $maxGame )
	$next = 1;
	
//echo $num_rows;

/*
echo $symbolsTmp[0]; // 1
echo $symbolsTmp[1]; // 2
echo $symbolsTmp[2]; // 3
echo $symbolsTmp[3]; // 4
echo $symbolsTmp[4]; // 5
echo $symbolsTmp[5]; // 6
echo $symbolsTmp[6]; // 7
echo $symbolsTmp[7]; // 8
echo $symbolsTmp[8]; // 9
echo $symbolsTmp[9]; // 10
echo $symbolsTmp[10]; // 11
echo $symbolsTmp[11]; // 12
echo $symbolsTmp[12]; // 13
echo $symbolsTmp[13]; // 14
echo $symbolsTmp[14]; // 15
*/
?>

<h2>ID: <?php echo $idMaquina; ?></h2>
<p>Game <?php echo $game; ?>/<?php echo $maxGame; ?></p>
<p>Total bet <?php echo $totalBet; ?></p>
<p>Lines <?php echo $linesBet; ?></p>
<table border=1 ><tr>
<tr><td><img src="images/reels/<?php echo $symbolsTmp[0]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[1]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[2]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[3]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[4]; ?>.png"></td></tr>
<tr><td><img src="images/reels/<?php echo $symbolsTmp[5]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[6]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[7]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[8]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[9]; ?>.png"></td></tr>
<tr><td><img src="images/reels/<?php echo $symbolsTmp[10]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[11]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[12]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[13]; ?>.png"></td><td><img src="images/reels/<?php echo $symbolsTmp[14]; ?>.png"></td></tr>
</table>
<a href=lastgames.php?id=<?php echo $idMaquina; ?>&gameID=<?php echo $previous; ?> >Back</a>
<a href=lastgames.php?id=<?php echo $idMaquina; ?>&gameID=<?php echo $next; ?> >Next</a>

<p>Credits Before <?php echo $creditsBefore; ?></p>
<p>Credits After <?php echo $creditsAfter; ?></p>
<p>Total Win <?php echo $totalWin; ?></p>
<p>Win Reels <?php echo $winReels; ?></p>
<p>Win Bonus 1 <?php echo $winBonus1; ?></p>
<p>Win Bonus 2 <?php echo $winBonus2; ?></p>
<p>Win Bonus 3 <?php echo $winBonus3; ?></p>
<p>Acumulado Big Paid <?php echo $acumuladoPaid; ?></p>
<p>Jackpot Paid <?php echo $jackpotPaid; ?></p>
<p>Acumulado Single Paid <?php echo $acumuladoSPaid; ?></p>

<a href=index.php>Voltar</a>

</body>
 
</html>
