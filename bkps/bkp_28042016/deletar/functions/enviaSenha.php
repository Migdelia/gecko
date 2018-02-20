<?php
include('../conn/conn.php');

$Nome = "nome PPK";
$Mail = "email PPK";
$Tel = "tel PPK";
$Lugar = "lugar PPK";
$Tipo = "tipo PPK";
$Data = "data PPK";
$Publico = "publico PPK";
$Obs = "obs PPK";



$para      = 'e.porchat@calabazachile.com';

$titulo = 'titulo PPK ';


$mensaje = 'Teste da PPK ';

$cabeceras = 'From:' . $Mail . "\r\n" .
    'Reply-To: ' . $Mail . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

if(mail($para, $titulo, $mensaje, $cabeceras))
{
	echo "Mandou";
}
else
{
	echo "Nao mandou";
}



?>
