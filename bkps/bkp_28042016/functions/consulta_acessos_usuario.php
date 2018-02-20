<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idLogin = $_POST['id'];	


$return = "";

//busca acessos desse usuario
$sql_acesso_usuario = "
	SELECT
		*				
	FROM
		acesso
	WHERE
		id_login = " . $idLogin;
$query_acesso_usuario=@mysql_query($sql_acesso_usuario);
//$res_acesso_usuario=@mysql_fetch_assoc($query_acesso_usuario);

//
while($res_acesso_usuario=@mysql_fetch_assoc($query_acesso_usuario)) 
{
	$return .= $res_acesso_usuario['id_menu'] . "-";
	$return .= $res_acesso_usuario['tipo_menu'] . "-";
	$return .= $res_acesso_usuario['acesso'] . ",";	
}


echo $return;

?>