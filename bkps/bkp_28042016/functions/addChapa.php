<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$maquina = $_POST['hd_maquina_Chapa'];
$modelo = $_POST['hd_modelo_Chapa'];


//consulta o id do usuario
$sql_maq = "
	SELECT
		id_maquina
	FROM
		maquinas
	WHERE
		numero = ".$maquina."
	";
	
$query_maq=@mysql_query($sql_maq);
$result_maq=@mysql_fetch_assoc($query_maq);

$idMaquina = $result_maq['id_maquina'];


//consulta o id do usuario
$sql_mod = "
	SELECT
		id_modelo
	FROM
		modelos_chapa
	WHERE
		descricao = '".$modelo."'
	";
	
$query_mod=@mysql_query($sql_mod);
$result_mod=@mysql_fetch_assoc($query_mod);

$idModelo = $result_mod['id_modelo'];


//
$sql_add = "INSERT INTO 
					chapas 
					(
						id_modelo,
						id_maquina
					) 
					VALUES
					(
						'".$idModelo."',
						'".$idMaquina."'												
					)";


					
//				
if(@mysql_query($sql_add) )
{
	sleep(1);
	header('Location: ../chapas.php');
}else{
	exit(utf8_encode('ERRO!'));
}

?>