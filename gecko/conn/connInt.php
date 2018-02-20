<?php


$host = "186.67.7.150";
$user = "web";
$pass = "webPw14379";
$dbas = "machines";
//$dominio = 'http://jabulani.dyndns.org';	
$dominio = 'localhost/geckochile';	




//Conexao com o Banco
if (!$conecta = @mysql_connect($host, $user, $pass) ) 
{
	exit("<script>alert('Ha ocurrido un problema al acceder a la información.\\Entre en contacto con el administrador del sistema');window.location='".$dominio."'</script>");
}
else if (!@mysql_select_db($dbas,$conecta)) 
{
	exit("<script>alert('Ha ocurrido un problema al acceder a la información.\\Entre en contacto con el administrador del sistema');window.location='".$dominio."'</script>");
}


?>

