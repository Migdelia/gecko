<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/validaLogin.php');
$tabela = base64_decode($_POST['param']);
$tabela = @mysql_real_escape_string($tabela);


//Verifica se o usuario tem acesso para proceder as inclusões de nivel/Usuario
/*
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
if (@mysql_num_rows( $query_per ) != 2)
{
	//Caso não tenha acesso
	if ( $tabela=='nivel' || $tabela=='usuario' )
	{
		exit(utf8_encode("Usuario restringido para esta operación."));
	}
}
*/
//ate aqui esta OK
//Tratando os dados recebidos por POST
foreach($_POST AS $k=>$v)
{
	//$var[$k] = @mysql_real_escape_string(strip_tags(RetirarAcentos ($v)));
	$var[$k] = @mysql_real_escape_string($v);


}


//consulta os dados atuais do local, para historico. * id Local= $var['loc'] *alterado 060417
$sql_dados_loc = "SELECT id_login, id_gerente, percentual, id_tp_local, pct_operador, pct_gerente, id_admin FROM `local` WHERE id_local = " . $var['id_loc'];
$qry_dados_loc=@mysql_query($sql_dados_loc);
$rst_dados_loc=@mysql_fetch_assoc($qry_dados_loc);


//adiciona registro na tabela leitura  * alterado 06042017

//verifica o ultimo id inserido
$sql_ult_leit = "
	SELECT
		 id_leitura
	FROM
		`leitura` WHERE id_leitura = '".$var['idleitura']."'
	";
$query_ult_leit=@mysql_query($sql_ult_leit);
$result_ult_leit=@mysql_fetch_assoc($query_ult_leit);


//atualiza as despesas com o id da leitura
$sql_desp = "UPDATE desconto_leit_fecha SET id_leitura_fechamento = ".$result_ult_leit['id_leitura']." WHERE id_leitura_fechamento = 0 AND leitura = 1 AND id_maquina = 0 AND id_login = ".$_SESSION['id_login'];
					
/*
if(@mysql_query($sql_desp) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restringido para esta operación."));
}*/

//atualiza as DIFERENCA com o id da leitura
$sql_dife = "UPDATE desconto_leit_fecha SET id_leitura_fechamento = ".$result_ult_leit['id_leitura']." WHERE id_leitura_fechamento = 0 AND leitura = 1 AND id_maquina <> 0 AND id_login = ".$_SESSION['id_login'];
						
/*
if(@mysql_query($sql_dife) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restringido para esta operación."));
}

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
/*
if(@mysql_query($sql_updt_desp) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("Usuario restringido para esta operación."));
}
*/
//atualiza as despesas com o id da leitura
$sql_updt_dif = "UPDATE leitura SET total_diferenca = ".$total_dif." WHERE leitura.id_leitura = '".$result_ult_leit['id_leitura']."'";
if(@mysql_query($sql_updt_dif) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode(0));
}


//adiciona deve
//adiciona registro na tabela leitura
$sql_add_dev = "UPDATE  
				deve SET 
						id_local = '".$var['loc']."',
						valor = '".$var['dev']."',
						saldo = '".$var['sld_dev']."',
						valor_recebido = '".$var['abono']."'
						WHERE id_leitura =  '".$result_ult_leit['id_leitura']."' ";						

if(@mysql_query($sql_add_dev) )
{
	//echo (utf8_encode('Leitura cadastrada com sucesso!'));
}else{
	exit(utf8_encode("0"));
}



$idLeitura = $result_ult_leit['id_leitura'];



//adiciona valores por maquina

//array de ids
$id_maquinas = explode(",", $var['ids']);

$i = 1;
$flag_troca = "true";
while ($i <= $var['qtd']) {
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
		$sql_up_ofi = "UPDATE maquinas SET entrada_oficial = ".$vl_ent_ofi.", saida_oficial =  ".$vl_sai_ofi." WHERE id_maquina = '".$id_atual."'";
								

		if(@mysql_query($sql_up_ofi) )
		{
			//echo (utf8_encode('Leitura cadastrada com sucesso!'));
		}else{
			exit(utf8_encode(0));
		}					
			
			
		//consulta dados da maquina / Id Maq = $id_atual * alterado 06042017
		$sql_dados_maq = "SELECT id_tipo_maquina, interface, porc_maquina, ordem_leitura, porc_socio, maq_socio, parceiro, id_jogo FROM vw_maquinas WHERE id_maquina = " . $id_atual;
		$qry_dados_maq=@mysql_query($sql_dados_maq);
		$rst_dados_maq=@mysql_fetch_assoc($qry_dados_maq);		
			
	
			
		//
		$sql_add_maq = "UPDATE 
		 					leitura_por_maquina 
		                         SET 
		                         valor_entrada = '".$entrada_parcial."',
								entrada_oficial_atual= '".$vl_ent_ofi."',
								valor_saida = '".$saida_parcial."',
								saida_oficial_atual = '".$vl_sai_ofi."' ,
								data_cadastro = '".date('Y-m-d')."',
								id_gabinete = '".$rst_dados_maq['id_tipo_maquina']."',
								num_disp = '".$rst_dados_maq['interface']."',
								pct_esp_maq = '".$rst_dados_maq['porc_maquina']."',
								ordem_leitura = '".$rst_dados_maq['ordem_leitura']."' ,
								pct_maq_socio = '".$rst_dados_maq['porc_socio']."',
								maq_socio = '".$rst_dados_maq['maq_socio']."',
								maq_parceiro = '".$rst_dados_maq['parceiro']."',
								id_jogo	= '".$rst_dados_maq['id_jogo']."'
								WHERE id_leitura =  $idLeitura AND id_maquina= $id_atual
								AND id_local = '".$var['loc']."'
								";	
	//}
	

	if(@mysql_query($sql_add_maq) )
	{

				//echo(utf8_encode($id_atual . ": OK"));
	}else{
		exit(utf8_encode(0));
	}
	
    $i++; 
}

exit($sql_add_maq);
	
?>