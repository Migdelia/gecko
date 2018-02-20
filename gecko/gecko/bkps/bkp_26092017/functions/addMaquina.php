<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$numMaq = $_POST['inputAdd_num_Maquina'];
$codMaq = $_POST['inputAdd_cod_Maquina'];
$jogo = $_POST['inputAdd_jogo_Maquina'];
$local = $_POST['inputAdd_local_Maquina'];
$dispSeg = $_POST['inputAdd_disp_Maquina'];
$ordem = $_POST['inputAdd_ordem_Maquina'];
$entrada = $_POST['inputAdd_entrada_Maquina'];
$saida = $_POST['inputAdd_saida_Maquina'];
$maqParce = $_POST['checkAdd_parce'];
$maqSocio = $_POST['checkAdd_maquina_socio'];
$pctSocio = $_POST['inputAdd_pctSocio_Maquina'];
$pctEsp = $_POST['inputAdd_pctEspecial_Maquina'];
$obsMaq = $_POST['inputAdd_obs_Maquina'];
$perTpMaq = $_POST['inputAdd_gab_Maquina']; 
$perPlaca = $_POST['inputAdd_placa_Maquina']; 
$perBilheteiro = $_POST['inputAdd_bil_Maquina']; 
$perPendrive = $_POST['inputAdd_pen_Maquina']; 
$perMonitor = $_POST['inputAdd_mon_Maquina']; 



//
if($ordem == '')
{
	$ordem = 0;
}

//
if($entrada == '')
{
	$entrada = 0;
}

//
if($saida == '')
{
	$saida = 0;
}


//
if($pctEsp == '')
{
	$pctEsp = 0;
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
	$maqSocio = 'true';		
}
else
{
	$maqSocio = 'false';		
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

//verifica se esse numero de maquina ja existe
$sqlMaqExiste = "SELECT * FROM maquinas WHERE numero = '".$numMaq."'";
$queryMaqExiste=@mysql_query($sqlMaqExiste);
$qtdRes = mysql_num_rows($queryMaqExiste);

if($qtdRes > 0)
{
	exit(utf8_encode('ERRO, Maquina ja cadastrada!'));
}
else
{


	//atualiza maquina
	$sql_add_maq = "INSERT INTO 
					maquinas
					(
						data_inclusao,
						numero,
						id_local,
						obs,
						excluido,
						id_tipo_maquina,
						porc_maquina,
						ordem_leitura,
						porc_socio,
						maq_socio,
						parceiro,
						entrada_oficial,
						saida_oficial					
					)
					VALUES
					(
						'".date("Y-m-d")."',
						'".$numMaq."',
						'".$res_local['id_local']."',
						'".$obsMaq."',
						'N',
						'".$res_gab['id_tipo_maquina']."',
						'".$pctEsp."',
						'".$ordem."',
						'".$pctSocio."',
						'".$maqSocio."',
						'".$maqParce."',
						'".$entrada."',
						'".$saida."'
					)";
	
	$flagErro = 0;	
	
	
	
	if(@mysql_query($sql_add_maq) )
	{
	
		//consulta o id da ultima maquina inserido
		$sqlMaxId = "SELECT MAX(id_maquina) as idMaq FROM maquinas";
		$queryMaxId=@mysql_query($sqlMaxId);
		$resMaxId=@mysql_fetch_assoc($queryMaxId);
		$ult_id_ins_maq = $resMaxId['idMaq'];
		
		//
		$sql_l = "INSERT INTO 
					leitura_por_maquina (id_leitura,id_maquina,valor_entrada,valor_saida,data_cadastro) 
				VALUES('1','".$ult_id_ins_maq."','0','0','".date('Y-m-d')."')";
		@mysql_query($sql_l);		
		
	
		//consulta todas as chapas
		$sqlTodasChapas = "SELECT
						*
					FROM
						modelos_chapa";
		$queryTodasChapas=@mysql_query($sqlTodasChapas);				
		
	
		//.
		while($resTodasChapas=@mysql_fetch_assoc($queryTodasChapas))
		{
			$txt = 'checkAdd_chapa_'.$resTodasChapas['codigo'];
			
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
									chapas.id_maquina = ".$resMaxId['idMaq']."
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
												".$resMaxId['idMaq']."
											)";
					
										
					if(!@mysql_query($sqlAddChapa) )
					{
						exit(utf8_encode('ERRO!'));
					}											
				}
			}
		}	
			
		
		
		//atualiza dispositivo Seg
		$sql_up_disp = "UPDATE 
							interface
						SET
							id_maquina = '".$resMaxId['idMaq']."'																											
						WHERE
							numero = '".$dispSeg."'";
							
		if(!@mysql_query($sql_up_disp) )
		{
			$flagErro = 1;
		}
			
		
		//placa mae	
		$sql_up_placa = "UPDATE 
							placa_mae
						SET
							id_maquina = '".$resMaxId['idMaq']."'																											
						WHERE
							id_placa = '".$res_placa['id_placa']."'";
							
		if(!@mysql_query($sql_up_placa) )
		{
			$flagErro = 1;
		}
	
		
		
		//bilheteiro	
		$sql_up_bil = "UPDATE 
							bilheteiros
						SET
							id_maquina = '".$resMaxId['idMaq']."'																											
						WHERE
							id_bilheteiro = '".$res_bil['id_bilheteiro']."'";
							
		if(!@mysql_query($sql_up_bil) )
		{
			$flagErro = 1;
		}
			
		
		//pendrive
		$sql_up_pen = "UPDATE 
							pendrives
						SET
							id_maquina = '".$resMaxId['idMaq']."'																											
						WHERE
							id_pendrive = '".$res_pen['id_pendrive']."'";
							
		if(!@mysql_query($sql_up_pen) )
		{
			$flagErro = 1;
		}
	
		
		//monitor
		$sql_up_mon = "UPDATE 
							monitores
						SET
							id_maquina = '".$resMaxId['idMaq']."'																											
						WHERE
							id_monitor = '".$res_mon['id_monitor']."'";
							
		if(!@mysql_query($sql_up_mon) )
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
		sleep(1);
		//
		//header('Location: ../maquinas.php');
		exit(utf8_encode(true));
	}
	
}


?>
