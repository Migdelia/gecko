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
$perTpMaq = $_POST['input_gab_Maquina']; 
$perPlaca = $_POST['input_placa_Maquina']; 
$perBilheteiro = $_POST['input_bil_Maquina']; 
$perPendrive = $_POST['input_pen_Maquina']; 
$perMonitor = $_POST['input_mon_Maquina']; 
//consulta todas as chapas
$sqlTodasChapas = "SELECT
				*
			FROM
				modelos_chapa";
$queryTodasChapas=@mysql_query($sqlTodasChapas);				

//.
while($resTodasChapas=@mysql_fetch_assoc($queryTodasChapas))
{
	$txt = 'check_chapa_'.$resTodasChapas['codigo'];
	
	$statusChapa = $_POST[$txt];
	//echo "chapa: " . $resTodasChapas['codigo'] . " = " . $statusChapa . "<br /><br />";
	
	
	//verifica se é adicionar essa chapa a essa maquina
	if($statusChapa == 'on')
	{
		//verifica se essa maquina ja tem essa chapa associada
		$sqlExisteChapa = "SELECT
							modelos_chapa.id_modelo
						FROM
							chapas
						INNER JOIN
							modelos_chapa
						ON
							chapas.id_modelo = modelos_chapa.id_modelo
						WHERE
							chapas.id_maquina = ".$idMaq."
						AND
							modelos_chapa.codigo = " . $resTodasChapas['codigo'];
		$queryExisteChapa=@mysql_query($sqlExisteChapa);
		$resExisteChapa=@mysql_fetch_assoc($queryExisteChapa);
		$qtdRes = mysql_num_rows($queryExisteChapa);
		
		//verfica se tem que adicionar essa chapa a essa maquina
		if($qtdRes == 0)
		{
			$sqlAddChapa = "INSERT INTO 
									chapas 
									(
										id_modelo,
										id_maquina
									)
									VALUES
									(
										".$resTodasChapas['id_modelo'].",
										".$idMaq."
									)";
			
								
			if(!@mysql_query($sqlAddChapa) )
			{
				exit(utf8_encode('ERRO!'));
			}											
		}
	}
	else
	{
			$sqlExcluiChapa = "DELETE FROM
									chapas
								WHERE
									id_modelo = ".$resTodasChapas['id_modelo']."
								AND
									id_maquina = " . $idMaq;
			if(!@mysql_query($sqlExcluiChapa) )
			{
				exit(utf8_encode('ERRO!'));
			}		
	}
}




//limpa entrada e saida
$entrada = str_replace('.','',$entrada);
$saida = str_replace('.','',$saida);

//verifica se é maquina de parceiro
if($maqParce == 'true')
{
	$maqParce = 1;		
}
else
{
	$maqParce = 0;		
}

//verifica se é maquina de parceiro
if($maqSocio == 'true')
{
	$maqSocio = 1;		
}
else
{
	$maqSocio = 0;		
}

if($status == 'Activo')
{
	$excluido = "N";	
}
else
{
	$excluido = "S";	
}

//consulta o id do local.
$sql_local = "SELECT id_local FROM local WHERE nome = '". $local ."'";
$query_local=@mysql_query($sql_local);
$res_local=@mysql_fetch_assoc($query_local);

//consulta o id do gabinete.
$sql_gab = "SELECT id_tipo_maquina FROM tipo_maquina WHERE descricao = '". $perTpMaq ."'";
$query_gab=@mysql_query($sql_gab);
$res_gab=@mysql_fetch_assoc($query_gab);

//consulta o id da placa.
$sql_placa = "SELECT id_placa FROM placa_mae WHERE serie = '". $perPlaca ."'";
$query_placa=@mysql_query($sql_placa);
$res_placa=@mysql_fetch_assoc($query_placa);

//consulta o id do bilheteiro.
$sql_bil = "SELECT id_bilheteiro FROM bilheteiros WHERE serie = '". $perBilheteiro ."'";
$query_bil=@mysql_query($sql_bil);
$res_bil=@mysql_fetch_assoc($query_bil);

//consulta o id do pendrive.
$sql_pen = "SELECT id_pendrive FROM pendrives WHERE serie = '". $perPendrive ."'";
$query_pen=@mysql_query($sql_pen);
$res_pen=@mysql_fetch_assoc($query_pen);

//consulta o id do monitor.
$sql_mon = "SELECT id_monitor FROM monitores WHERE serie = '". $perMonitor ."'";
$query_mon=@mysql_query($sql_mon);
$res_mon=@mysql_fetch_assoc($query_mon);


/*
echo  "Id Maquina:" . $idMaq . "<br>";
echo  "Numero:" . $numMaq . "<br>";
//echo  "Codigo:" . $codMaq . "<br>";
//echo  "Jogo:" . $jogo . "<br>";
echo  "Local:" . $res_local['id_local'] . "<br>";
echo  "status:" . $excluido . "<br>";
echo  "disp Seg:" . $dispSeg . "<br>";
echo  "ordem leitura:" . $ordem . "<br>";
echo  "Entrada:" . $entrada . "<br>";
echo  "Saida:" . $saida . "<br>";
echo  "Maquina parceiro:" . $maqParce  . "<br>";
echo  "Maq Socio:" . $maqSocio . "<br>";
echo  "% socio:" . $pctSocio . "<br>";
echo  "% especial:" . $pctEsp . "<br>";
echo  "observacao:" . $obsMaq . "<br>";
echo  "gabinete:" . $res_gab['id_tipo_maquina'] . "<br>";
echo  "placa:" . $res_placa['id_placa'] . "<br>";
echo  "bilheteiro:" . $res_bil['id_bilheteiro'] . "<br>";
echo  "pendrive:" . $res_pen['id_pendrive'] . " <br>";
echo  "monitor:" . $res_mon['id_monitor'] . "<br>";
echo  "chapa:" . $perChapas . "<br>";
*/



//consulta dados para historico, antes da troca.
$sql_hist_troca = "SELECT 
					maquinas.entrada_oficial,
					maquinas.saida_oficial,
					interface.numero,
					interface.id_interface
				FROM
					maquinas
				INNER JOIN
					interface
				ON
					maquinas.id_maquina = interface.id_maquina
				WHERE
					maquinas.id_maquina = " . $idMaq;
									
$query_hist_troca=@mysql_query($sql_hist_troca);
$res_hist_troca=@mysql_fetch_assoc($query_hist_troca);					




//atualiza maquina
$sql_up_maq = "UPDATE 
				maquinas
			SET
				data_alteracao = '".date("Y-m-d")."',
				id_local = '".$res_local['id_local']."',
				obs = '".$obsMaq."',
				excluido = '".$excluido."',
				id_tipo_maquina = '".$res_gab['id_tipo_maquina']."',
				porc_maquina = '".$pctEsp."',
				ordem_leitura = '".$ordem."',
				porc_socio = '".$pctSocio."',
				maq_socio = '".$maqSocio."',
				parceiro = '".$maqParce."',
				entrada_oficial = '".$entrada."',
				saida_oficial = '".$saida."'																											
			WHERE
				id_maquina = '".$idMaq."'";

$flagErro = 0;	
	

//
//-----------------------------------------------------
if(@mysql_query($sql_up_maq) )
{
	//verifica se trocou a interface (disp de seg)
	//if($res_hist_troca['numero'] <> $dispSeg)
	//{
		///
		//Historico
		
		//consulta a ultima leitura dessa maquina
		$sql_id_ult_leit = "SELECT
							MAX(id_leitura) as id_ult_leit
						FROM
							leitura_por_maquina
						WHERE
							id_maquina = " . $idMaq;
		$query_id_ult_leit=@mysql_query($sql_id_ult_leit);
		$res_id_ult_leit=@mysql_fetch_assoc($query_id_ult_leit);		
		
		
		//consulta o id do novo disp de seg
		$sql_novo_disp_seg = "SELECT
								id_interface
							FROM
								interface
							WHERE
								numero = " . $dispSeg;
		$query_novo_disp_seg=@mysql_query($sql_novo_disp_seg);
		$res_novo_disp_seg=@mysql_fetch_assoc($query_novo_disp_seg);								
								
								
							
		
		//guarda historico de troca
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
								'".$res_hist_troca['id_interface']."',
								'".$res_novo_disp_seg['id_interface']."',
								'".$res_hist_troca['entrada_oficial']."',
								'".$res_hist_troca['saida_oficial']."',
								'".$entrada."',
								'".$saida."',
								'".$idMaq."',
								'".$_SESSION['id_login']."',
								now(),
								'".$res_id_ult_leit['id_ult_leit']."'
								)";
								
		if (!@mysql_query($sql_add_hist) ) {
			$flagErro = 1;
		}
	
	
		///
		//FIM --- Historico		
	//}
	



	
	
	//atualiza perifericos.
	//limpa a interface que esta com esse maquina
	//limpa dispositivo Seg
	$sql_up_limpaInt = "UPDATE 
							interface
						SET
							id_maquina = 0																											
						WHERE
							id_maquina = '".$idMaq."'";
						
	if(!@mysql_query($sql_up_limpaInt) )
	{
		$flagErro = 1;
	}	
	//atualiza dispositivo Seg
	$sql_up_disp = "UPDATE 
						interface
					SET
						id_maquina = '".$idMaq."'																											
					WHERE
						numero = '".$dispSeg."'";
						
	if(!@mysql_query($sql_up_disp) )
	{
		$flagErro = 1;
	}
		
	
	//placa mae
	//limpa placa mae
	$sql_up_limpaPlaca = "UPDATE 
							placa_mae
						SET
							id_maquina = 0																											
						WHERE
							id_maquina = '".$idMaq."'";
						
	if(!@mysql_query($sql_up_limpaPlaca) )
	{
		$flagErro = 1;
	}		
	$sql_up_placa = "UPDATE 
						placa_mae
					SET
						id_maquina = '".$idMaq."'																											
					WHERE
						id_placa = '".$res_placa['id_placa']."'";
						
	if(!@mysql_query($sql_up_placa) )
	{
		$flagErro = 1;
	}

	
	
	//bilheteiro
	$sql_up_limpaBil = "UPDATE 
							bilheteiros
						SET
							id_maquina = 0																											
						WHERE
							id_maquina = '".$idMaq."'";
						
	if(!@mysql_query($sql_up_limpaBil) )
	{
		$flagErro = 1;
	}		
	$sql_up_bil = "UPDATE 
						bilheteiros
					SET
						id_maquina = '".$idMaq."'																											
					WHERE
						id_bilheteiro = '".$res_bil['id_bilheteiro']."'";
						
	if(!@mysql_query($sql_up_bil) )
	{
		$flagErro = 1;
	}
		
	
	//pendrive
	$sql_up_limpaPen = "UPDATE 
							pendrives
						SET
							id_maquina = 0																											
						WHERE
							id_maquina = '".$idMaq."'";
						
	if(!@mysql_query($sql_up_limpaPen) )
	{
		$flagErro = 1;
	}	
	$sql_up_pen = "UPDATE 
						pendrives
					SET
						id_maquina = '".$idMaq."'																											
					WHERE
						id_pendrive = '".$res_pen['id_pendrive']."'";
						
	if(!@mysql_query($sql_up_pen) )
	{
		$flagErro = 1;
	}

	
	//monitor
	$sql_up_limpaMon = "UPDATE 
							monitores
						SET
							id_maquina = 0																											
						WHERE
							id_maquina = '".$idMaq."'";
						
	if(!@mysql_query($sql_up_limpaMon) )
	{
		$flagErro = 1;
	}	
	$sql_up_mon = "UPDATE 
						monitores
					SET
						id_maquina = '".$idMaq."'																											
					WHERE
						id_monitor = '".$res_mon['id_monitor']."'";
						
	if(!@mysql_query($sql_up_mon) )
	{
		$flagErro = 1;
	}
		
	
	
	//chapas
	$sql_up_chapa = "UPDATE 
						chapas
					SET
						id_maquina = '".$idMaq."'																											
					WHERE
						id_chapa = '".$perChapas."'";
						
	if(!@mysql_query($sql_up_chapa) )
	{
		$flagErro = 1;
	}
	
	
}
else
{
	$flagErro = 1;
	//exit(utf8_encode('ERRO!'));
}


//verifica se teve erro
if($flagErro == 1)
{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}
else
{
	//sleep(1);
	//
	//header('Location: ../maquinas.php');
	exit(utf8_encode(true));
}
?>