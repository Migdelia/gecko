<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$key1 = $_POST['senha1'];	
$key2 = $_POST['senha2'];

$userName = $_POST['nameUsuario'];




//
$sql_add = "INSERT INTO 
					request 
					(
						key1,
						key2,
						flag,
						error,
						userName
					) 
					VALUES
					(
						'".$key1."',
						'".$key2."',
						'0',
						'0',
						'".$userName."'			
					)";

					
if(@mysql_query($sql_add) )
{
	//verifica id inserido
	$idRequest = mysql_insert_id();
	
	//tempo para gerar a senha
	sleep(3);
	
	//consulta se nao teve erro
	$sql_erro = "SELECT 
						error,
						flag
				FROM
						request
				WHERE
						id = " . $idRequest;
	$query_erro=@mysql_query($sql_erro);
	$resultado_erro=@mysql_fetch_assoc($query_erro);
	
	//verifica se processou a solicitacao.
	if($resultado_erro['flag'] == 0)
	{
		$retorno="server";	
	}
	//verifica se teve erro na validacao.
	else if($resultado_erro['error'] == 0)
	{
		//consulta a senha gerada pelo validador.
		$sql_atu = "SELECT 
							password
					FROM
							exitRequest
					WHERE
							idRequest = " . $idRequest;
		
		//executa consulta.
		if($query_atu=@mysql_query($sql_atu) )
		{
			$resultado_atu=@mysql_fetch_assoc($query_atu);
			$retorno = $resultado_atu['password'];
		}			
	}
	else
	{
		$retorno="false";	
	}				
}else{
	$retorno="false";
}	


echo $retorno;

?>
