<?php
//Tema a ser utilizado pelo sistema
$theme = "jquery-ui_ui-lightness.css";

//Define o local onde o sistema será conectado (local ou remoto)
//$acesso = 'local';
//$acesso = 'localhost';
$acesso = 'remoto';

//Configuraçoes do sistema
ini_set('zlib.output_compression',1);
setlocale(LC_CTYPE,"pt_BR");
date_default_timezone_set( "America/Sao_Paulo" );
$charset = "utf-8";
header("Content-Type: text/html; charset=".$charset, true);
$description = 'Calabaza ';

//Quantidade de Filtros de criterios na pesquisa de relatorio personalizados
$_SESSION['qtd_pesquisa_relatorio']=4;

//Conexao e Link Utilizado para inserir a folha de estilo no e-mail
if ($acesso=='remoto') {
	$lnk = "/calabaza";
	$mail_from = "eafrade@gmail.com";
	$host = "calasys.cor2yfouvoqs.sa-east-1.rds.amazonaws.com";
	$user = "calasys";
	$pass = "cala*999865";
	$dbas = "calabaza";
	//$dominio = 'http://www.calasys.com.br/calabaza/';	
	$dominio = 'http://calasys.dyndns.info';	
}else if($acesso=='localhost') {
	$lnk = "/calabaza";
	$mail_from = "eafrade@gmail.com";
	$host = "127.0.0.1";
	$user = "root";
	$pass = "999865";
	$dbas = "calabaza";
	$dominio = 'http://localhost/calabaza/';	
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
if (!$conecta = @mysql_connect($host, $user, $pass) ) {
	exit("<script>alert('Occorreu um problema ao acessar as Informaçoes.\\nEntre em contato com o administrador do sistema');window.location='".$dominio."'</script>");
}else if (!@mysql_select_db($dbas,$conecta)) {
	exit("<script>alert('Occorreu um problema ao acessar as Informaçoes.\\nEntre em contato com o administrador do sistema');window.location='".$dominio."'</script>");
}?>
