<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//recebe POST
$idLogin = $_POST['id'];	
$idMenu = $_POST['nivel'];	
$status = $_POST['status'];
$idNivel = 1; // mudar para dinamico	
$tpMenu = $_POST['tipoMenu'];



	//verifica se esse acesso esta criado.
	$sql_exi_acesso = "
		SELECT
			*				
		FROM
			acesso
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
							acesso 
							(
								id_nivel,
								id_menu,
								acesso,
								id_login,
								tipo_menu
							) 
							VALUES
							(
								'1',
								'".$idMenu."',
								'".$status."',
								'".$idLogin."',
								'".$tpMenu."'			
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
						acesso
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



echo $return;

?>