<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$nomeUsuario = $_POST['input_nameUsuario'];
$senhaUsuario = $_POST['input_passUsuario'];
$emailUsuario = $_POST['input_mailUsuario'];
$loginUsuario = $_POST['input_logUsuario'];
$nivelUsuario = $_POST['input_vl_nivelUsuario'];

//consulta o id do nivel
$sql_nivel = "
	SELECT
		id_nivel
	FROM
		nivel
	WHERE
		descricao = '".$nivelUsuario."'
	";
	
$query_nivel=@mysql_query($sql_nivel);
$result_nivel=@mysql_fetch_assoc($query_nivel);

//
$sql_add = "INSERT INTO 
					logins 
					(
						id_nivel,
						nome,
						usuario,
						email,
						inclusao,
						excluido,
						senha
					) 
					VALUES
					(
						'".$result_nivel['id_nivel']."',
						'".$nomeUsuario."',
						'".$loginUsuario."',
						'".$emailUsuario."',
						'".date('Y-m-d')."',
						'N',
						'".md5($senhaUsuario)."'					
					)";
					
if(@mysql_query($sql_add) )
{
	
	header('Location: ../usuarios.php');
}else{
	exit(utf8_encode('ERRO!'));
}

?>