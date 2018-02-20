<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//recebe o tipo de acao a executar
$acaoTipo = $_POST['tpAcao'];
$listUsu = $_POST['ids'];
$listUsu = explode(",", $listUsu);


$flagErro = 0;
if($acaoTipo == "Desativar")
{
	//
	foreach ($listUsu as $valor) 
	{
		$sql_up = "UPDATE 
						logins
					SET
						excluido = 'S'
					WHERE
						id_login = '".$valor."'";
								
		if(@mysql_query($sql_up) )
		{
			$retorno = 1;
		}
		else
		{
			$retorno = 0;
			$flagErro = 1;
		}	
	}
}
else
{
	$nvNivel = $_POST['nivel'];
	
	//consulta o id do nivel
	$sql_nivel = "
		SELECT
			id_nivel
		FROM
			nivel
		WHERE
			descricao = '".$nvNivel."'
		";
		
	$query_nivel=@mysql_query($sql_nivel);
	$result_nivel=@mysql_fetch_assoc($query_nivel);
	
	
	//
	foreach ($listUsu as $valor) 
	{
		$sql_up = "UPDATE 
						logins
					SET
						id_nivel = '".$result_nivel['id_nivel']."'
					WHERE
						id_login = '".$valor."'";
								
		if(@mysql_query($sql_up) )
		{
			$retorno = 1;
		}
		else
		{
			$retorno = 0;
			$flagErro = 1;
		}	
	}
}



sleep(1);


//
if($flagErro == 1)
{
	$retorno = 0;
}


echo $retorno;
?>