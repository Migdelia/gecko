<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$serie = $_POST['add_serie_Billetero'];
$maquina = $_POST['hd_maquina_Billetero'];
$modelo = $_POST['hd_modelo_Billetero'];



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
		modelos_bilheteiro
	WHERE
		descricao = '".$modelo."'
	";
	
$query_mod=@mysql_query($sql_mod);
$result_mod=@mysql_fetch_assoc($query_mod);

$idModelo = $result_mod['id_modelo'];


//
$sql_add = "INSERT INTO 
					bilheteiros 
					(
						serie,
						modelo_id,
						id_maquina
					) 
					VALUES
					(
						'".$serie."',
						'".$idModelo."',
						'".$idMaquina."'												
					)";
					


//				
if(@mysql_query($sql_add) )
{
	sleep(1);
	header('Location: ../billeteros.php');
}else{
	exit(utf8_encode('ERRO!'));
}

?>