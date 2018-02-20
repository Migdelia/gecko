<?php
include "bd.php";
?>
<!DOCTYPE html>
 
<html>
<head>
<title>Main</title>
<meta charset="utf-8">
<link rel="stylesheet" href="estilo.css">

</head>
<body>

<h1>Configuracao rede</h1>

<?php
$pesquisa = "SELECT * FROM Reading order by hwid";
$resultado = mysql_query($pesquisa) or die ("ERRO!");
//$linha=mysql_fetch_array($resultado);

if ($resultado){
	
	echo "<table border='1' width='150' >";
	while ( $pesquisa = mysql_fetch_array($resultado)) 
	{		
			$id = $pesquisa['id'];
			$hwid = $pesquisa['hwid'];
			$ip = $pesquisa["ip"];
			$ip6 = $pesquisa["ip6"];
			$mac = $pesquisa["mac"];
			
			$pesquisaConfig = "SELECT * FROM Config where id=$id";
			$resultadoConfig = mysql_query($pesquisaConfig) or die ("ERRO2!");
			$pesquisaConfig = mysql_fetch_array($resultadoConfig);
			$machineType = $pesquisaConfig["machineType"];

			if($machineType=1)
				$machineType="Servidor";
			else
				$machineType="Cliente";

			if(!$hwid)
				$hwid = 0; 		
			
			if($pesquisa){
			echo "<tr><td><a href='machine.php?id=$id'><img src=images/".$hwid.".jpg />".$id. " - " .$hwid."</a></td><td>$machineType</td><td>$ip</td><td>$ip6</td><td>$mac</td><td><a href='machine.php?id=$id'>Individual</a></td></tr>";
			
			}
		
	}
	echo "</table>";
	
	mysql_close($conexao);
		
	mysql_free_result($resultado);
		
}else{
	die (mysql_error("ERRO"));
}

?>



</body>
 
</html>
