<?php
session_start();
include('../conn/conn.php');
include('../functions/lg_validador.php');

//$ids = explode('_',($_GET['ida']) );
$ent_1 = $_GET['ent1'];
$sai_1 = $_GET['sai1'];
$ent_2 = $_GET['ent2'];
$sai_2 = $_GET['sai2'];
$ant = $_GET['int_ant'];
$nov = $_GET['int_nov'];
$id_maq = $_GET['idmaq'];
$ult_leit = $_GET['id_leit'];



			
//inseri historico de troca de plaquinha
$sql_add_hist = "INSERT INTO 
				historico_troca_inter (
						id_interface_ant,
						id_interface_nova,
						entrada_ant,
						saida_ant,
						entrada_nov,
						saida_nov,
						id_maq,
						id_login,
						data,
						id_ultima_leitura
						) 
				VALUES(
						'".$ant."',
						'".$nov."',
						'".$ent_1."',
						'".$sai_1."',
						'".$ent_2."',
						'".$sai_2."',
						'".$id_maq."',
						'".$_SESSION['id_login']."',
						now(),
						'".$ult_leit."'
						)";
						
if ( @mysql_query($sql_add_hist) ) {
	echo "OK";
}else{
	echo "no";
}	


/*						
//inseri historico de troca de plaquinha
$sql_add_hist = "INSERT INTO 
				historico_troca_inter (
						id_interface_ant,
						id_interface_nova,
						entrada_ant,
						saida_ant,
						entrada_nov,
						saida_nov,
						id_maq,
						id_login,
						data,
						id_ultima_leitura
						) 
				VALUES(
						'".$res_int_atual['id_interface']."',
						'".$res_inter['id_interface']."',
						'1',
						'2',
						'3',
						'4',
						'".$_POST['value']."',
						'".$_SESSION['id_login']."',
						now(),
						'".$res_ult_leit['id_leitura']."'
						)";
						
						
if (!@mysql_query($sql_add_hist) ) 
{
	$erro.= "Erro ao desvincular interface\\nEntre em contato com o Administrador.";
	echo "<script language='javascript'>alert('".$erro."');</script>";
}	
*/

?>