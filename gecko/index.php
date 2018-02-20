<?php
	//recebe senha qr
	$senhaQR = $_GET['s'];	
	$codVer = $_GET['v'];
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Gecko</title>
		<?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
	</head>

	<body class="body login">
		<?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po ?>
		<div class="container-fluid">
			<div class="row">
				<?php include("inc/login.php"); // se llama el contenido de la pantalla login ?>
			</div>
		</div>
	</body>
</html>