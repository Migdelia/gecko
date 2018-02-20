<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idUsu = $_POST['id'];
$parametro = $_POST['param'];
$flag = $_POST['flag'];


if($flag == "nome")
{
	//busca dados do disp
	$sql_up = "UPDATE 
					logins
				SET
					nome = '".$parametro."'
				WHERE
					id_login = '".$idUsu."'";	
}
else if($flag == "email")
{
	//busca dados do disp
	$sql_up = "UPDATE 
					logins
				SET
					email = '".$parametro."'
				WHERE
					id_login = '".$idUsu."'";		
}
else if($flag == "senha")
{
	//verifica se a senha atual informada esta correta.
	//criptografa senha para comparar 
	$senhaCrip = md5($_POST['senhaAnt']);

	//consulta senha
	$sql = @mysql_query("SELECT logins.id_login, logins.senha FROM logins WHERE logins.id_login='".$idUsu."' AND md5(logins.senha)='".md5($senhaCrip)."' AND logins.excluido='N'");	
	$existe = @mysql_fetch_assoc($sql);
	
	if(md5($senhaCrip)==md5($existe['senha']))
	{
		//busca dados do disp
		$sql_up = "UPDATE 
						logins
					SET
						senha = '".md5($parametro)."'
					WHERE
						id_login = '".$idUsu."'";			
	}
	else
	{
		$retorno = 2; // senha antiga invalida.
	}
}

//verifica se a senha antiga esta OK
if($retorno <> 2)
{
	if(@mysql_query($sql_up) )
	{
		$retorno=1;
	}
	else
	{
		$retorno= 0;
	}	
}
				

sleep(1);
echo $retorno;
?>