<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idMaq = $_POST['id_maquina'];
$numMaq = $_POST['input_num_Maquina'];
$codMaq = $_POST['input_cod_Maquina'];
$jogo = $_POST['input_jogo_Maquina'];
$local = $_POST['input_local_Maquina'];
$status = $_POST['input_status_Maquina'];
$dispSeg = $_POST['input_disp_Maquina'];
$ordem = $_POST['input_ordem_Maquina'];
$entrada = $_POST['input_entrada_Maquina'];
$saida = $_POST['input_saida_Maquina'];
$maqParce = $_POST['check_parce'];
$maqSocio = $_POST['check_maquina_socio'];
$pctSocio = $_POST['input_pctSocio_Maquina'];
$pctEsp = $_POST['input_pctEspecial_Maquina'];
$obsMaq = $_POST['input_obs_Maquina'];
$perTpMaq = $_POST['input_per_tipo_maquina']; 
$perPlaca = $_POST['input_per_placa_mae']; 
$perBilheteiro = $_POST['input_per_bilheteiros']; 
$perPendrive = $_POST['input_per_pendrives']; 
$perMonitor = $_POST['input_per_monitores']; 
$perChapas = $_POST['input_per_chapas']; 

//limpa entrada e saida
$entrada = str_replace('.','',$entrada);
$saida = str_replace('.','',$saida);

//verifica se é maquina de parceiro
if($maqParce == 'on')
{
	$maqParce = 1;		
}
else
{
	$maqParce = 0;		
}

//verifica se é maquina de parceiro
if($maqSocio == 'on')
{
	$maqSocio = 1;		
}
else
{
	$maqSocio = 0;		
}


//atualiza maquina
$sql_up = "UPDATE 
				maquinas
			SET
				data_alteracao = '".date("Y-m-d")."',
				id_local = '".$local."',
				obs = '".$obsMaq."',
				excluido = '".$status."',
				id_tipo_maquina = '".$perTpMaq."',
				id_interface = '".$dispSeg."',
				porc_maquina = '".$pctEsp."',
				ordem_leitura = '".$ordem."',
				porc_socio = '".$pctSocio."',
				maq_socio = '".$maqSocio."',
				parceiro = '".$maqParce."',
				entrada_oficial = '".$entrada."',
				saida_oficial = '".$saida."'																											
			WHERE
				id_maquina = '".$idMaq."'";
				

if(@mysql_query($sql_up) )
{
	sleep(1);
	//
	header('Location: ../maquinas.php');
}else{
	exit(utf8_encode('ERRO!'));
}


?>