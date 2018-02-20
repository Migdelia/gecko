<?php 

//cria log de acesso
function log_acesso( $dados ){
	$login= $dados['login'];
	$senha= $dados['senha'];

	// Pegando o IP do client no lugar do proxy
	$endip= ($_SERVER['HTTP_X_FORWARDED_FOR']!=''?str_replace(',',' ',$_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['REMOTE_ADDR']);
	$data = date('Y-m-d');
	$hora = date('H:i:s');
	$status = $dados['status'];
	$link = "http://".$_SERVER['HTTP_HOST'].$dados['link'];
	$sql_lac = "INSERT INTO log_acesso(login,senha,ip,data,hora,status,link) VALUES ('".$login."','".$senha."','".$endip."','".$data."','".$hora."','".$status."','".$link."')";

	@mysql_query($sql_lac);
}

?>