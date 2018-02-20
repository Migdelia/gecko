<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idUsu = $_POST['id'];
$nome = $_POST['nome'];
$mail = $_POST['email'];
$status = $_POST['status'];
$nivel = $_POST['nivel'];
$senha = $_POST['senhaUsu'];

//consulta senha atual para ver se atualizou ou nao
$sql_senha = "
	SELECT
		senha
	FROM
		logins
	WHERE
		id_login = '".$idUsu."'
	";
	
$query_senha=@mysql_query($sql_senha);
$result_senha=@mysql_fetch_assoc($query_senha);


//compara as senhas
if($result_senha['senha'] !== $senha)
{
	//criptografa a senha
	$senha = md5($senha);
}

//
if($status == 'Ativo')
{
	$status = 'N';	
}
else
{
	$status = 'S';	
}

//consulta o id do nivel
$sql_nivel = "
	SELECT
		id_nivel
	FROM
		nivel
	WHERE
		descricao = '".$nivel."'
	";
	
$query_nivel=@mysql_query($sql_nivel);
$result_nivel=@mysql_fetch_assoc($query_nivel);


//busca dados do disp
$sql_up = "UPDATE 
				logins
			SET
				nome = '".$nome."',
				email = '".$mail."',
				excluido = '".$status."',
				id_nivel = '".$result_nivel['id_nivel']."',
				senha = '".$senha."'
			WHERE
				id_login = '".$idUsu."'";
				
if(@mysql_query($sql_up) )
{
	$retorno=1;
}
else
{
	$retorno= 0;
}

sleep(1);
echo $retorno;
?>