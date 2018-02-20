<?php
	//rutas
	$imgurl = "img"
?>

<?php
	//imprimir nombre del archivo (para el id)
	$filenameID = ucwords( str_ireplace(array('_', '.php'), array('-', ''), basename($_SERVER['PHP_SELF']) ) );
?>

<?php
	//lengüaje
	putenv('LC_ALL=es_ES');
	setlocale(LC_ALL, 'es_ES');

	// Especifica la ubicación de la tabla de traducciones
	bindtextdomain("default", "./locale");

	textdomain("default");
?>