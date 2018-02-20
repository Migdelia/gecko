<?php
//
$id_disp = $_GET['xx'];
$entrada = $_GET['yy'];
$saida = $_GET['zz'];

//
header('Location:../gecko/atualizainfo.php?xx=' . $id_disp . '&yy=' . $entrada . "&zz=" . $saida);
	
?>
