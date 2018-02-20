<?php
	$lnk = "";
	$mail_from = "e.porchat@calabazachile.com";
	$host = "localhost";
	$user = "root";
	$pass = "cala*999865";
	$dbas = "dongle_SysDongleV2";
	//$dominio = 'http://jabulani.dyndns.org';	
	$dominio = 'localhost/geckochile';	




//Conexao com o Banco
if (!$conecta = @mysql_connect($host, $user, $pass) ) 
{
	exit("<script>alert('Occorreu um problema ao acessar as Informaçoes.\\nEntre em contato com o administrador do sistema');window.location='".$dominio."'</script>");
}
else if (!@mysql_select_db($dbas,$conecta)) 
{
	exit("<script>alert('Occorreu um problema ao acessar as Informaçoes.\\nEntre em contato com o administrador do sistema');window.location='".$dominio."'</script>");
}
?>