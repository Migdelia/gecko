<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
$tabela = base64_decode($_POST['param']);
$tabela = @mysql_real_escape_string($tabela);


//Verifica se o usuario tem acesso para proceder as inclus�es de nivel/Usuario
$sql_per = "
	SELECT
		vw_acessos_usuarios.acesso
	FROM
		vw_acessos_usuarios
	WHERE 
		vw_acessos_usuarios.id_menu IN (5,9)
		AND id_nivel= '".$_SESSION['usr_nivel']."'
		AND usuario= '".$_SESSION['usuario']."'
		AND acesso='S'
	";
	
$query_per = mysql_query($sql_per);
if (@mysql_num_rows( $query_per ) != 2) {

	//Caso n�o tenha acesso
	if ( $tabela=='nivel' || $tabela=='usuario' )
	{
		exit(utf8_encode("Usuario restrito para esta opera��o."));
	}
}


//Tratando os dados recebidos por POST
foreach($_POST AS $k=>$v)
{
	$var[$k] = @mysql_real_escape_string(strip_tags(RetirarAcentos ($v)));
}


/*
////consultar o id da leitura anterior a essa inserida desse local
$sql_leit_ant = "
	SELECT
		max(id_leitura) as id_leitura
	FROM
		`leitura`
	";
	
$query_leit_ant=@mysql_query($sql_leit_ant);
$result_leit_ant=@mysql_fetch_assoc($query_leit_ant);

//atibui o id da leitura anterior
$leit_ant = $result_leit_ant['id_leitura'];
*/

$semSelecionada = $var['semana'];
if($semSelecionada == "")
{
	$semSelecionada = 0;
}

$dataRef = date("Y-m-d", strtotime($var['dia_fecha']));


//consulta os dados atuais do local, para historico. * id Local= $var['loc'] *alterado 060417
$sql_dados_loc = "SELECT id_login, id_gerente, percentual, id_tp_local, pct_operador, pct_gerente, id_admin FROM `local` WHERE id_local = " . $var['loc'];
$qry_dados_loc=@mysql_query($sql_dados_loc);
$rst_dados_loc=@mysql_fetch_assoc($qry_dados_loc);



//adiciona registro na tabela leitura  * alterado 06042017
$sql_add = "INSERT INTO 
				leitura (
						id_local,
						id_login,
						data,
						observacao,
						semana,
						data_fechamento,
						fat_bruto,
						id_operador,
						id_gerente,
						pct_local,
						id_tipo_local,
						pct_operador,
						pct_gerente,
						id_admin
						) 
				VALUES(
						'".$var['loc']."',
						'".$_SESSION['id_login']."',
						'".date('Y-m-d')."',
						'".$var['obs']."',
						'".$semSelecionada."',
						'".$dataRef."',
						'".$var['fat_bruto']."',
						'".$rst_dados_loc['id_login']."',
						'".$rst_dados_loc['id_gerente']."',
						'".$rst_dados_loc['percentual']."',
						'".$rst_dados_loc['id_tp_local']."',
						'".$rst_dados_loc['pct_operador']."',
						'".$rst_dados_loc['pct_gerente']."',
						'".$rst_dados_loc['id_admin']."'				
						)";
						

if(@mysql_query($sql_add) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restrito para esta opera��o."));
}

//verifica o ultimo id inserido
$sql_ult_leit = "
	SELECT
		max(id_leitura) as id_leitura
	FROM
		`leitura`
	";
	
$query_ult_leit=@mysql_query($sql_ult_leit);
$result_ult_leit=@mysql_fetch_assoc($query_ult_leit);


//atualiza as despesas com o id da leitura
$sql_desp = "UPDATE desconto_leit_fecha SET id_leitura_fechamento = ".$result_ult_leit['id_leitura']." WHERE id_leitura_fechamento = 0 AND leitura = 1 AND id_maquina = 0 AND id_login = ".$_SESSION['id_login'];
						

if(@mysql_query($sql_desp) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restrito para esta opera��o."));
}

//atualiza as DIFERENCA com o id da leitura
$sql_dife = "UPDATE desconto_leit_fecha SET id_leitura_fechamento = ".$result_ult_leit['id_leitura']." WHERE id_leitura_fechamento = 0 AND leitura = 1 AND id_maquina <> 0 AND id_login = ".$_SESSION['id_login'];
						

if(@mysql_query($sql_dife) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restrito para esta opera��o."));
}

/*

$sql_leit_ins = "SELECT MAX(id_leitura) as id_leitura FROM leitura";
$query_leit_ins=@mysql_query($sql_leit_ins);
$result_leit_ins=@mysql_fetch_assoc($query_leit_ins);

//adiciona UM ao valor encontrado (para que seja a proxima)
$leit_ins_id = $result_leit_ins['id_leitura'];	

*/




//somar total de despesas dessa leitura e total de diferenca 
$sql_tot_desp = "
	SELECT
		sum(desconto_leit_fecha.valor_desconto) as total_desconto
	FROM
		`desconto_leit_fecha`
	WHERE
		desconto_leit_fecha.id_leitura_fechamento = '".$result_ult_leit['id_leitura']."'
	AND
		desconto_leit_fecha.id_maquina = 0
	";
	
$query_tot_desp=@mysql_query($sql_tot_desp);
$result_tot_desp=@mysql_fetch_assoc($query_tot_desp);

//somar total de diferencas dessa leitura e total de diferenca 
$sql_tot_dif = "
	SELECT
		sum(desconto_leit_fecha.valor_desconto) as total_diferenca
	FROM
		`desconto_leit_fecha`
	WHERE
		desconto_leit_fecha.id_leitura_fechamento = '".$result_ult_leit['id_leitura']."'
	AND
		desconto_leit_fecha.id_maquina <> 0
	";
	
$query_tot_dif=@mysql_query($sql_tot_dif);
$result_tot_dif=@mysql_fetch_assoc($query_tot_dif);


//trata valores vazio
$total_desp = $result_tot_desp['total_desconto'];
$total_dif = $result_tot_dif['total_diferenca'];



if($total_desp == "")
{
	$total_desp = 0;
}

if($total_dif == "")
{
	$total_dif = 0;
}


// atualizar nos totais da tabela leitura.
//atualiza as despesas com o id da leitura
$sql_updt_desp = "UPDATE leitura SET total_desconto = ".$total_desp." WHERE leitura.id_leitura = '".$result_ult_leit['id_leitura']."'";
if(@mysql_query($sql_updt_desp) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restrito para esta opera��o."));
}

//atualiza as despesas com o id da leitura
$sql_updt_dif = "UPDATE leitura SET total_diferenca = ".$total_dif." WHERE leitura.id_leitura = '".$result_ult_leit['id_leitura']."'";
if(@mysql_query($sql_updt_dif) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restrito para esta opera��o."));
}


//adiciona deve
//adiciona registro na tabela leitura
$sql_add_dev = "INSERT INTO 
				deve (
						id_local,
						valor,
						saldo,
						id_leitura,
						valor_recebido
						) 
				VALUES(
						'".$var['loc']."',
						'".$var['dev']."',
						'".$var['sld_dev']."',
						'".$result_ult_leit['id_leitura']."',
						'".$var['abono']."'
						)";						

if(@mysql_query($sql_add_dev) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restrito para esta opera��o."));
}



$idLeitura = $result_ult_leit['id_leitura'];



//adiciona valores por maquina

//array de ids
$id_maquinas = explode(",", $var['ids']);

$i = 1;
$flag_troca = "true";
while ($i <= $var['qtd']) {
	/*
	//trata valores
	//busca id da leitura que sera adicionada
	$sql_ult_leit = "SELECT MAX(id_leitura) as id_leitura FROM leitura";
	$query_id_ult_leit=@mysql_query($sql_ult_leit);
	$result_leit=@mysql_fetch_assoc($query_id_ult_leit);
	*/
	//adiciona UM ao valor encontrado (para que seja a proxima)
	$id_leit_ins = $idLeitura;	
	
	//atibui o id atual de qual maquina esta fazendo o looping	
	$id_atual = $id_maquinas[$i - 1];

	//separa os valores dessa mesma maquina
	$valores = explode("/", $var['vl_maq']);
	$ent_sai = explode(",", $valores[$i - 1]);
	$entrada = $ent_sai[0];
	$saida = $ent_sai[1];
	
	$sql_cons_ult_leitura = "SELECT
									leitura_por_maquina.entrada_oficial_atual,
									leitura_por_maquina.saida_oficial_atual				
							FROM
									leitura_por_maquina
							WHERE
									leitura_por_maquina.id_maquina = '".$id_atual."'
							LIMIT 1		
							";
							
	$query_ult_leit=@mysql_query($sql_cons_ult_leitura);
	$result_ult_leit=@mysql_fetch_assoc($query_ult_leit);
		
	$entrada_parcial = $entrada; // - $result_ult_leit['valor_entrada_total'];
	$saida_parcial = $saida; // - $result_ult_leit['valor_saida_total'];
	

	//leitura anterior $leit_ant
	//consulta se essa maquina teve troca de placa
	/*
	$sql_troca = "
		SELECT
			*
		FROM
			historico_troca_inter
		WHERE
			historico_troca_inter.id_maq = '".$id_atual."'
		AND
			historico_troca_inter.id_ultima_leitura = '".$leit_ant."'			
		";
		
	$query_troca=@mysql_query($sql_troca);
	$result_troca=@mysql_fetch_assoc($query_troca);	
	*/
	//caso a maqui teve troca de plaquinha se insere um registro com a leitura oficial NEGATIVA
	/*
	if($result_troca['id_troca'] <> "")
	{
		if($flag_troca == "true")
		{
			$sql_dados_ant = "
				SELECT
					vw_leitura_maquina.valor_entrada_total,
					vw_leitura_maquina.valor_saida_total
				FROM
					vw_leitura_maquina
				WHERE
					vw_leitura_maquina.id_leitura = '".$result_leit_ant['id_leitura']."'
				AND
					vw_leitura_maquina.id_maquina = '".$id_atual."'
				";
				
			$query_dados_ant=@mysql_query($sql_dados_ant);
			$result_dados_ant=@mysql_fetch_assoc($query_dados_ant);		
			
		
			$entrada_parcial = $result_dados_ant['valor_entrada_total'] * (-1);
			$saida_parcial = $result_dados_ant['valor_saida_total'] * (-1);

			
			$sql_add_maq = "INSERT INTO 
							leitura_por_maquina (
									id_leitura,
									id_maquina,
									valor_entrada,
									valor_saida,
									data_cadastro
									) 
							VALUES(
									'1',
									'".$id_atual."',
									'".$entrada_parcial."',						
									'".$saida_parcial."',										
									'".date('Y-m-d')."'
									)";
			$dif_ent = $result_troca['entrada_ant'] - $result_dados_ant['valor_entrada_total'];
			$dif_sai = $result_troca['saida_ant'] - $result_dados_ant['valor_saida_total'];				
			$flag_troca = "false";
		}
		else
		{
			$entrada_parcial = $entrada_parcial + $dif_ent;
			$saida_parcial = $saida_parcial + $dif_sai;		

		
			$sql_add_maq = "INSERT INTO 
							leitura_por_maquina (
									id_leitura,
									id_maquina,
									valor_entrada,
									valor_saida,
									data_cadastro
									) 
							VALUES(
									'".$id_leit_ins."',
									'".$id_atual."',
									'".$entrada_parcial."',						
									'".$saida_parcial."',										
									'".date('Y-m-d')."'
									)";
			
					
			//inserir um valor negativo na leitura 1
			//diferenca entre a soma das entradas paciais e entrada oficial 
			
			//$entrada_parcial - $entrada
			
			$entrada_parcial = (($entrada_parcial - ($result_troca['entrada_nov'] + $entrada)) * (-1));
			$saida_parcial = (($saida_parcial - ($result_troca['saida_nov'] + $saida)) * (-1));
			
			$sql_add_ajus = "INSERT INTO 
							leitura_por_maquina (
									id_leitura,
									id_maquina,
									valor_entrada,
									valor_saida,
									data_cadastro
									) 
							VALUES(
									'1',
									'".$id_atual."',
									'".$entrada_parcial."',						
									'".$saida_parcial."',										
									'".date('Y-m-d')."'
									)";
									
			if(@mysql_query($sql_add_ajus) )
			{
				//echo(utf8_encode($id_atual . ": OK"));
			}else{
				exit(utf8_encode("Usuario restrito para esta opera��o."));
			}											
				
		}
	}
	else
	{
	*/
		//buscar o ultimo valor de entrada e saida oficial dessa maquina
			$sql_lei_ofi = "
				SELECT
					maquinas.entrada_oficial as nova_ent_ofi,
					maquinas.saida_oficial as nova_sai_ofi
				FROM
					maquinas
				WHERE
					maquinas.id_maquina = '".$id_atual."'
				";
			$query_lei_ofi=@mysql_query($sql_lei_ofi);
			$dados_lei_ofi=@mysql_fetch_assoc($query_lei_ofi);
			
			$vl_ent_ofi = $dados_lei_ofi['nova_ent_ofi'] + $entrada_parcial;
			$vl_sai_ofi = $dados_lei_ofi['nova_sai_ofi'] + $saida_parcial;
			
			
		///dar um update no valor oficial da maquina
		$sql_up_ofi = "UPDATE maquinas SET entrada_oficial = ".$vl_ent_ofi.", saida_oficial =  ".$vl_sai_ofi.", id_ultima_leitura = ". $idLeitura ." WHERE id_maquina = '".$id_atual."'";
								
		
		if(@mysql_query($sql_up_ofi) )
		{
			//echo (utf8_encode('Leitura cadastrada com sucesso!'));
		}else{
			exit(utf8_encode("Usuario restrito para esta opera��o."));
		}		
		
		
		
		//consulta dados da maquina / Id Maq = $id_atual * alterado 06042017
		$sql_dados_maq = "SELECT id_tipo_maquina, interface, porc_maquina, ordem_leitura, porc_socio, maq_socio, parceiro, id_jogo FROM vw_maquinas WHERE id_maquina = " . $id_atual;
		$qry_dados_maq=@mysql_query($sql_dados_maq);
		$rst_dados_maq=@mysql_fetch_assoc($qry_dados_maq);	
							
			
	
		//
		$sql_add_maq = "INSERT INTO 
						leitura_por_maquina (
								id_leitura,
								id_maquina,
								valor_entrada,
								entrada_oficial_atual,
								valor_saida,
								saida_oficial_atual,
								data_cadastro,
								id_local,
								id_gabinete,
								num_disp,
								pct_esp_maq,
								ordem_leitura,
								pct_maq_socio,
								maq_socio,
								maq_parceiro,
								id_jogo						
								) 
						VALUES(
								'".$id_leit_ins."',
								'".$id_atual."',
								'".$entrada_parcial."',
								'".$vl_ent_ofi."',					
								'".$saida_parcial."',
								'".$vl_sai_ofi."',										
								'".date('Y-m-d')."',
								'".$var['loc']."',
								'".$rst_dados_maq['id_tipo_maquina']."',
								'".$rst_dados_maq['interface']."',
								'".$rst_dados_maq['porc_maquina']."',					
								'".$rst_dados_maq['ordem_leitura']."',
								'".$rst_dados_maq['porc_socio']."',										
								'".$rst_dados_maq['maq_socio']."',
								'".$rst_dados_maq['parceiro']."',
								'".$rst_dados_maq['id_jogo']."'																
								)";	
	//}
	
		
	if(@mysql_query($sql_add_maq) )
	{
		//echo(utf8_encode($id_atual . ": OK"));
	}else{
		exit(utf8_encode("Usuario restrito para esta opera��o."));
	}
	
    $i++;  
}

exit('Leitura cadastrada com sucesso!');
?>