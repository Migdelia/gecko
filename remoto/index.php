<?php
include "bd.php";
?>
<!DOCTYPE html>
 
<html>
<head>
<title>Main</title>
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

<h1>Maquinas</h1>
<a href='net.php'>Rede</a>
<?php

$pesquisa = "SELECT * FROM Reading";
$resultado = mysql_query($pesquisa);
		 
if ($resultado){
	
	echo "<table border='1' width='40' >";
	for($y=1;$y<9;$y++){		
		echo "<tr>";
		for($x=1;$x<9;$x++){
			$pesquisa = mysql_fetch_array($resultado);		
			$id = $pesquisa['id'];
			$hwid = $pesquisa['hwid'];
			if(!$hwid)
				$hwid = 0; 		
			
			if($pesquisa){
			echo "<td><a href='machine.php?id=$id'><img src=images/".$hwid.".png />".$id."</a></td>";			}
			
			}
		echo "</tr>";
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
