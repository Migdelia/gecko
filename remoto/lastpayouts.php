<?php
include "bd.php";
?>

<!DOCTYPE html>
 
<html>
<head>
<title>Last Payouts</title>
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
<h1>Last Payouts</h1>

<?php

$idMaquina = $_GET['id'];
if ($idMaquina <= 0) {
	header("index.php");
	exit;
}

$pesquisa = "SELECT * FROM lastPayouts WHERE id = " . $idMaquina;
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$num_rows = mysql_num_rows($resultado);

?>

<h2><?php echo $idMaquina; ?></h2>
<table border=1 ><tr><td>Date </td><td>Value </td></tr>
<?php 
for( $x=0;$x<$num_rows;$x++)
{ 

	$linha=mysql_fetch_array($resultado);
	$date = $linha["date"];
	$value = $linha["value"];

	echo "<tr><td>";
	echo $date;
	echo "</td><td>";
	echo $value;
	echo "</td></tr>";
}
?>

</table>

<a href=index.php>Voltar</a>

</body>
 
</html>
