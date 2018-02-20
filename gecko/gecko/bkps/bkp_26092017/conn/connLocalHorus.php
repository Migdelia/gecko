<?php

//Configuraçoes do sistema
ini_set('zlib.output_compression',1);
setlocale(LC_CTYPE,"pt_BR");
date_default_timezone_set( "America/Sao_Paulo" );
$charset = "utf-8";
header("Content-Type: text/html; charset=".$charset, true);


$lnk = "/gecko";
$mail_from = "sistema@calabazachile.com";
//$host = $res_dns['dns'];
$host = 'calahorus.dyndns.org';
$user = "root";
$pass = "999865";
$dbas = "leitura";
$dominio = 'http://calasys.dyndns.org/gecko';	



//Conexao com o Banco

if (!$conecta = @mysql_connect($host, $user, $pass) ) 
{
	exit("<script>alert('Occorreu um problema ao acessar as Informaçoes.\\nEntre em contato com o administrador do sistema');window.location='".$dominio."'</script>");

}
else if (!@mysql_select_db($dbas,$conecta)) {
	exit("<script>alert('Occorreu um problema ao acessar as Informaçoes.\\nEntre em contato com o administrador do sistema');window.location='".$dominio."'</script>");
}
?>