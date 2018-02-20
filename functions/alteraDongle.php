<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$idDisp = $_POST['id'];
$nvPeriodo = $_POST['perAtu'];
$nomeUser = $_POST['user'];

/*

//consulta o id do usuario
$sql_usuario = "
	SELECT
		id_login
	FROM
		logins
	WHERE
		nome = '".$nomeUser."'
	";
	
$query_usuario=@mysql_query($sql_usuario);
$result_usuario=@mysql_fetch_assoc($query_usuario);


include('../conn/connDongle.php');

//busca dados do disp
$sql_up = "UPDATE 
				StreetDongle
			SET
				period = '".$nvPeriodo."',
				userId = '".$result_usuario['id_login']."'
			WHERE
				MachineId = ".$idDisp;
				
if(@mysql_query($sql_up) )
{
	$retorno=1;
}
else
{
	$retorno= 0;
}

echo $retorno;
*/
?>