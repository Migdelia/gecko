<?php
	$lnk = "";
	$mail_from = "e.porchat@calabazachile.com";
	$host = "calasys.cor2yfouvoqs.sa-east-1.rds.amazonaws.com";
	$user = "calasys";
	$pass = "cala*999865";
	$dbas = "dongle_SysDongleV2";
	$dominio = 'http://jabulani.dyndns.org';	
	//$dominio = 'calasys.ccvwjaneutp4.us-east-1.rds.amazonaws.com';//'localhost/geckochile';	




//Conexao com o Banco
if (!$conecta = @mysql_connect($host, $user, $pass) ) 
{
	exit("<script>alert('Ha ocurrido un problema al acceder a la información.\\nEntre en contacto con el administrador del sistema');window.location='".$dominio."'</script>");
}
else if (!@mysql_select_db($dbas,$conecta)) 
{
	exit("<script>alert('Ha ocurrido un problema al acceder a la información.\\nEntre en contacto con el administrador del sistema');window.location='".$dominio."'</script>");
}
?>
