<?php
include "bd.php";

$idMaquina = $_GET['id'];
if ($idMaquina <= 0) {
	header("index.php");
	exit;
}

$pesquisa = "SELECT * FROM Reading WHERE id = " . $idMaquina;
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$linha=mysql_fetch_array($resultado);

$getCredits = $linha["getCredits"];

?>
<!DOCTYPE html>
 
<html>
<head>
<title>Creditos</title>
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
<body onload="doLoad();">
<h1>Maquina <?php echo $idMaquina; ?></h1>
<h2>Credito atual: <?php echo $getCredits; ?></h2>

<form id="formulario" name="formulario" action="insert.php" method="post" enctype="multipart/form-data">
<label>Creditos </label><select name="credit">
<option value ="<?php echo $idMaquina.'-'.$credito=100; ?>" selected >100</option>
<option value ="<?php echo $idMaquina.'-'.$credito=200; ?>">200</option>
<option value ="<?php echo $idMaquina.'-'.$credito=500; ?>">500</option>
<option value ="<?php echo $idMaquina.'-'.$credito=1000; ?>">1000</option>
<option value ="<?php echo $idMaquina.'-'.$credito=2000; ?>">2000</option>
</select>

<button type="submit">Inserir</button>

</form>

<a href=index.php>Voltar</a>


</body>
 
</html>
