<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idLogin = $_POST['id'];	


$return = "";

//busca dados do disp
$sql_usuarios = "
	SELECT
		*				
	FROM
		logins
	WHERE
		id_login = " . $idLogin;
$query_usuarios=@mysql_query($sql_usuarios);
$res_usuarios=@mysql_fetch_assoc($query_usuarios);

//echo $sql_disp;
$return .= $res_usuarios['id_login'] . ",";
$return .= $res_usuarios['nome'] . ",";
$return .= $res_usuarios['email'] . ",";


//muda a nomenclatura
if($res_usuarios['excluido'] == 'N')
{
	$return .= "Ativo,";	
}
else
{
	$return .= "Inativo,";
}


//busca nome do nivel
$sql_nivel = "
	SELECT
		descricao				
	FROM
		nivel
	WHERE
		id_nivel = " . $res_usuarios['id_nivel'];
$query_nivel=@mysql_query($sql_nivel);
$res_nivel=@mysql_fetch_assoc($query_nivel);

$return .= $res_nivel['descricao'] . ",";
$return .= $res_usuarios['senha'] . ",";
$return .= $res_usuarios['usuario'] . ",";
$return .= date("d-m-Y", strtotime($res_usuarios['inclusao']));


echo $return;

?>