<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//recebe POST
$idLogin = $_POST['id'];	
$idMenu = $_POST['nivel'];	
$status = $_POST['status'];

//consulta o nivel de acesso do usuario que esta sendo alterado no sistema.
$sql_nivel_user = "SELECT id_nivel FROM logins WHERE id_login = " . $idLogin;
$query_nivel_user=@mysql_query($sql_nivel_user);
$res_nivel_user=@mysql_fetch_assoc($query_nivel_user);

//
$idNivel = $res_nivel_user['id_nivel']; 


//verifica se é menu ou subMenu
if($idMenu > 999) // submenu
{
	//verifica se esse acesso esta criado.
	$sql_exi_acesso = "
		SELECT
			*				
		FROM
			acesso_sub
		WHERE
			id_nivel = ".$idNivel."
		AND
			id_login = ".$idLogin."
		AND
			id_menu = ".$idMenu."
			";
	$query_exi_acesso=@mysql_query($sql_exi_acesso);
	$res_exi_acesso=@mysql_fetch_assoc($query_exi_acesso);
	
	//verifica se ja existe o acesso solicitado.
	if($res_exi_acesso['id_acesso'] == "")
	{
		//cria acesso
		$sql_add = "INSERT INTO 
							acesso_sub
							(
								id_nivel,
								id_menu,
								acesso,
								id_login
							) 
							VALUES
							(
								'".$idNivel."',
								'".$idMenu."',
								'".$status."',
								'".$idLogin."'			
							)";
							
		if(@mysql_query($sql_add) )
		{
			$return = 1;
		}else{
			$return = 0;
		}	
	}
	else
	{
		//altera acesso
		$sql_up = "UPDATE 
						acesso_sub
					SET
						acesso = '".$status."'					
					WHERE
						id_login = ".$idLogin."
					AND
						id_menu = ". $idMenu;
						
		if(@mysql_query($sql_up) )
		{
			$return = 1;
		}
		else
		{
			$return = 0;
		}
	}	
}
else // Menu
{
	//verifica se esse acesso esta criado.
	$sql_exi_acesso = "
		SELECT
			*				
		FROM
			acesso_novo
		WHERE
			id_nivel = ".$idNivel."
		AND
			id_login = ".$idLogin."
		AND
			id_menu = ".$idMenu."
			";
	$query_exi_acesso=@mysql_query($sql_exi_acesso);
	$res_exi_acesso=@mysql_fetch_assoc($query_exi_acesso);
	
	//verifica se ja existe o acesso solicitado.
	if($res_exi_acesso['id_acesso'] == "")
	{
		//cria acesso
		$sql_add = "INSERT INTO 
							acesso_novo
							(
								id_nivel,
								id_menu,
								acesso,
								id_login
							) 
							VALUES
							(
								'".$idNivel."',
								'".$idMenu."',
								'".$status."',
								'".$idLogin."'			
							)";
							
		if(@mysql_query($sql_add) )
		{
			$return = 1;
		}else{
			$return = 0;
		}	
	}
	else
	{
		//altera acesso
		$sql_up = "UPDATE 
						acesso_novo
					SET
						acesso = '".$status."'					
					WHERE
						id_login = ".$idLogin."
					AND
						id_menu = ". $idMenu;
						
		if(@mysql_query($sql_up) )
		{
			$return = 1;
		}
		else
		{
			$return = 0;
		}
	}	
}



echo $return;

?>