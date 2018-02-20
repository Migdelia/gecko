<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

//atribui senha nova e antiga.
$senhaAntiga = md5($_GET['a']);	
$senhaNova = md5($_GET['n']);

//verifica se a senha antiga informada esta correta.
$sql_ver = "
	SELECT
		*
	FROM
		logins
	WHERE
		id_login = ".$_SESSION['id_login']."
	AND
		senha = '".$senhaAntiga."'
	";
	
$query_ver=@mysql_query($sql_ver);
$result_ver=@mysql_fetch_assoc($query_ver);

//verifica se teve resultado.
if($result_ver['id_login'] == $_SESSION['id_login'])
{
	//
	$sql_up = "UPDATE 
					logins
				SET
					senha = '".$senhaNova."'
				WHERE
					id_login = ".$_SESSION['id_login'];
	
	//				
	if(@mysql_query($sql_up) )
	{
		$retorno="";
	}
	else
	{
		$retorno= "Erro!";
	}
}
else
{
	$retorno= "Erro senha Atual!";
}


echo $retorno;

?>