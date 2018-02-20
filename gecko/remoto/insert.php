<?php
include "bd.php";

$Credit = $_POST['credit'];
if ($Credit <= 0) {
	header("index.php");
	exit;
}

$Credit = explode("-",$Credit);

$pesquisa = "UPDATE Reading set addCredits=".$Credit[1]." where id=" . $Credit[0];
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$linha=mysql_fetch_array($resultado);


header("Location: credits.php?id=$Credit[0]");

?>


