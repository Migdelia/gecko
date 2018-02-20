<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');


$entOfiNova = $_POST['ent'];	
$saiOfiNova = $_POST['sai'];
$entVelha = $_POST['entAnt']; 
$saiVelha = $_POST['saiAnt']; 
$motivo = $_POST['mot'];
$idMaq = $_POST['id']; 
$idLogin = $_SESSION['id_login'];

$sql_up = "UPDATE 
					maquinas
					SET
						entrada_oficial = ".$entOfiNova.",
						saida_oficial = ".$saiOfiNova."
					WHERE
						maquinas.id_maquina = ".$idMaq."";
						
						
			
					if(@mysql_query($sql_up) )
					{
						$sql_add = "INSERT INTO 
											historico_troca_leitura 
											(
												id_maquina,
												id_login,
												id_motivo,
												entrada_ant,
												saida_ant,
												entrada_nov,
												saida_nov
											) 
											VALUES
											(
												'".$idMaq."',
												'".$idLogin."',
												'".$motivo."',
												'".$entVelha."',
												'".$saiVelha."',
												'".$entOfiNova."',
												'".$saiOfiNova."'					
											)";
											
						if(@mysql_query($sql_add) )
						{
							$retorno="true";
						}else{
							$retorno="false";
						}	
					}
					else
					{
						$retorno="false";
					}

echo $retorno;
?>
