<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$sql_car_usr = "
	SELECT
		vw_usuarios.id_login,
		vw_usuarios.Nome,
		vw_usuarios.Nivel,
		vw_usuarios.excluido
	FROM
		vw_usuarios
	ORDER BY
		vw_usuarios.Nome
	LIMIT 10 OFFSET 11
	";
$query_car_usr=@mysql_query($sql_car_usr);

while($res_car_usr=@mysql_fetch_assoc($query_car_usr)) 
{
	echo $res_car_usr['Nome'] . "<br>";
}

?>