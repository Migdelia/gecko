<?php
//define o tipo de acesso
$acesso = 'remoto';



//Configuraçoes do sistema
ini_set('zlib.output_compression',1);
setlocale(LC_CTYPE,"pt_BR");
date_default_timezone_set( "America/Sao_Paulo" );
$charset = "utf-8";
header("Content-Type: text/html; charset=".$charset, true);



//Conexao e Link Utilizado para inserir a folha de estilo no e-mail
if ($acesso=='remoto') {
	$lnk = "/gecko";
	$mail_from = "sistema@calabazachile.com";
	$host = "localhost";
	$user = "root";
	$pass = "cala*999865";
	$dbas = "calabaza";
	$dominio = 'http://calasys.dyndns.org/gecko';	

}else if($acesso=='localhost') {
	$lnk = "/geckoChile";
	$mail_from = "sistema@calabazachile.com";
	$host = "127.0.0.1";
	$user = "root";
	$pass = "";
	$dbas = "calabaza";
	$dominio = 'http://localhost/geckoChile/';	

}else{

	$lnk = "/calabaza";
	$mail_from = "eafrade@gmail.com";
	$host = "127.0.0.1";
	$user = "root";
	$pass = "999865";
	$dbas = "calabaza";
	$dominio = 'http://localhost/calabaza/';	

}



//Conexao com o Banco

if (!$conecta = @mysql_connect($host, $user, $pass) ) 
{
	exit("<script>alert('Occorreu um problema ao acessar as Informaçoes.\\nEntre em contato com o administrador do sistema');window.location='".$dominio."'</script>");

}
else if (!@mysql_select_db($dbas,$conecta)) {
	exit("<script>alert('Occorreu um problema ao acessar as Informaçoes.\\nEntre em contato com o administrador do sistema');window.location='".$dominio."'</script>");
}
?>