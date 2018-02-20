<?php

//declara senha QR
$senhaQR = $_GET['s'];
$codVer = $_GET['v'];

header('Location: http://calasys.dyndns.org/gecko/validacion.php?s='.$senhaQR.'&v='.$codVer);




?>
