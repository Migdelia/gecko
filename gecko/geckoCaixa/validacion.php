<!DOCTYPE html>
<html>
<head>
	<title>Gecko</title>
	<?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
	<?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
	<div class="container-fluid innpage-<?php echo $filenameID; ?>">
		<div class="row">
			<?php include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
		</div>
		<div class="row">
			<?php include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
			<div class="inner-content col-xs-12 col-sm-9">
			<?php include("inc/secccion-validar.php"); // el contenido de esta vista de panel de escritorio del usaurio ?>
			</div>
		</div>
	</div>
	<?php include("inc/modals/modal-maqlecturas.php"); // modal recuperar contraseña ?>
</body>
</html>