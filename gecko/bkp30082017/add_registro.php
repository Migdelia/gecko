<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');


$tabela = base64_decode($_POST['param']);
$tabela = @mysql_real_escape_string($tabela);

//Verifica se o usuario tem acesso para proceder as inclusões de nivel/Usuario
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

	//Caso não tenha acesso
	if ( $tabela=='nivel' || $tabela=='usuario' )
	{
		exit(utf8_encode("Usuario restrito para esta operação."));
	}
}

//Tratando os dados recebidos por POST
foreach($_POST AS $k=>$v)
{
	$var[$k] = @mysql_real_escape_string(strip_tags(RetirarAcentos ($v)));
}

switch ($tabela) {
	case "nivel":
		//Verifica se o campo não está vazio
		if(str_replace(" ","",$var['descricao'])=='' || strlen($var['descricao'])<=3)
		{
			exit(utf8_encode("Digite um nome de nivel com mais de 3 caracteres."));
		}
		//Verifica se o nivel já existe
		$sql_en = "SELECT nivel.* FROM nivel WHERE nivel.descricao='".$var['descricao']."' LIMIT 1";
		$query_en=@mysql_query($sql_en);
		$num_reg = @mysql_num_rows($query_en);
		
		$sql_add = "INSERT INTO nivel (descricao,inclusao,excluido) VALUES('".$var['descricao']."','".date('Y-m-d')."','N')";

		if($num_reg==1)
		{
			$dados_en=@mysql_fetch_assoc($query_en);
			if( $dados_en['excluido']=='S' )
			{
				$sql_add = "UPDATE nivel SET nivel.excluido='N' WHERE nivel.descricao='".$var['descricao']."' AND nivel.excluido<>'N'";
			}else
			{
				exit(utf8_encode("Este nivel foi cadastrado anteriormente."));
			}
		}
	break;

	case "local":
		//Verifica se o campo não está vazio
		if(str_replace(" ","",$var['nome'])=='' || strlen($var['nome'])<=3)
		{
			exit(utf8_encode("Digite um nome de local com mais de 3 caracteres."));
		}
		
		//Verificando se o e-rut é válido
		elseif(!valida_rut($var['rut'],$var['dig']))
		{
			exit(utf8_encode("O RUT não é válido."));
		}
						
		//Verifica se o local já existe
		$sql_en = "SELECT local.* FROM local WHERE local.nome='".$var['nome']."' LIMIT 1";
		$query_en=@mysql_query($sql_en);
		$num_reg = @mysql_num_rows($query_en);
		
		
		//add novos valores trazidos por parametros *erico
		$sql_add = "INSERT INTO 
						local (nome,razao_social,rut,ordem,inclusao,excluido,endereco,responsavel,contato,percentual,id_login,id_regiao,id_tp_local,id_gerente,pct_operador,pct_gerente) 
					VALUES('".$var['nome']."',
						   '".$var['razao_social']."',
						   '".$var['rut'].$var['dig']."',
						   '2',
						   '".date('Y-m-d')."',
						   'N',
						   '".$var['end']."',
						   '".$var['resp_loc']."',
						   '".$var['cont_resp']."',
						   '".$var['pct']."',
						   '".$var['ope']."',
						   '".$var['reg']."',
						   '".$var['tp_loc']."',
						   '".$var['id_ger']."',
						   '".$var['pct_ope']."',
						   '".$var['pct_ger']."'
						   )";
						   
						   
						   //resp_loc
						   //cont_resp

		

		if($num_reg==1)
		{
			$dados_en=@mysql_fetch_assoc($query_en);
			if( $dados_en['excluido']=='S' )
			{
				$sql_add = "UPDATE local SET local.excluido='N' WHERE local.nome='".$var['nome']."' AND local.excluido<>'N'";
			}else
			{
				exit(utf8_encode("Este Local foi cadastrado anteriormente."));
			}
		}
	break;
	
	case "regiao":
	//Verifica se o campo não está vazio
	if(str_replace(" ","",$var['nome'])=='' || strlen($var['nome'])<=3)
	{
		exit(utf8_encode("Digite um nome de cidade com mais de 3 caracteres."));
	}
	//Verifica se o local já existe
	$sql_en = "SELECT local.* FROM regiao WHERE regiao.nome_cidade='".$var['nome']."' LIMIT 1";
	$query_en=@mysql_query($sql_en);
	$num_reg = @mysql_num_rows($query_en);
	
	$sql_add = "INSERT INTO regiao (nome_cidade,excluido) VALUES('".$var['nome']."','N')";

	if($num_reg==1)
	{
		$dados_en=@mysql_fetch_assoc($query_en);
		if( $dados_en['excluido']=='S' )
		{
			$sql_add = "UPDATE regiao SET regiao.excluido='N' WHERE regiao.nome_cidade='".$var['nome']."' AND regiao.excluido<>'N'";
		}else
		{
			exit(utf8_encode("Esta Cidade foi cadastrada anteriormente."));
		}
	}
	break;
	
	
	case "maquina":
		//Verifica se o campo não está vazio
		if(str_replace(" ","",$var['num'])=='' || strlen($var['num'])<=1)
		{
			exit(utf8_encode("Digite um numero de maquina com mais de 1 caracteres."));
		}
						
		//Verifica se o numero de maquina já existe
		$sql_en = "SELECT maquinas.* FROM maquinas WHERE maquinas.numero='".$var['num']."' LIMIT 1";
		$query_en=@mysql_query($sql_en);
		$num_reg = @mysql_num_rows($query_en);
		
		$sql_add = "INSERT INTO 
						maquinas (numero,id_local,data_inclusao,excluido,obs,id_tipo_maquina,porc_maquina,maq_socio,porc_socio) 
					VALUES('".$var['num']."','".$var['loc']."','".date('Y-m-d')."','N','".$var['obs']."','".$var['gab']."','".$var['porc']."','".$var['flag_soc']."','".$var['pct_soc']."')";
		

		if($num_reg==1)
		{
			$dados_en=@mysql_fetch_assoc($query_en);
			if( $dados_en['excluido']=='S' )
			{
				$sql_add = "UPDATE maquinas SET maquinas.excluido='N' WHERE maquinas.numero='".$var['num']."' AND maquinas.excluido<>'N'";
			}else
			{
				exit(utf8_encode("Esta Maquina foi cadastrada anteriormente."));
			}
		}
	break;	

	case "interface":
		//Verifica se o campo não está vazio
		$var['num'] = (int)$var['num'];
		if(str_replace(" ","",$var['num'])=='' || strlen($var['num'])<1)
		{
			exit(utf8_encode("Digite um numero de interface com pelo menos 1 caracteres."));
		}
						
		//Verifica se o numero de interface já existe
		$sql_en = "SELECT interface.* FROM interface WHERE interface.numero='".$var['num']."' LIMIT 1";
		$query_en=@mysql_query($sql_en);
		$num_reg = @mysql_num_rows($query_en);
		
		$sql_add = "INSERT INTO 
						interface (numero,data_inclusao,id_jogo,serie) 
					VALUES('".$var['num']."','".date('Y-m-d')."','".$var['jog']."','".$var['serie']."')";
	
		if($num_reg==1)
		{
			$dados_en=@mysql_fetch_assoc($query_en);
			if( $dados_en['excluido']=='S' )
			{
				$sql_add = "UPDATE interface SET interface.excluido='N' WHERE interface.numero='".$var['num']."' AND interface.excluido<>'N'";
			}else
			{
				exit(utf8_encode("Esta Interface foi cadastrada anteriormente."));
			}
		}
	break;	

	case "desconto":
		//Verifica se o campo não está vazio
		$var['num'] = (int)$var['num'];
		if(str_replace(" ","",$var['num'])=='' || strlen($var['num'])<1)
		{
			exit(utf8_encode("Digite um valor valido de desconto!"));
		}
								
		$sql_add = "INSERT INTO 
						desconto_leit_fecha (
											id_descricao,
											id_leitura_fechamento,
											valor_desconto,
											leitura,
											data_desconto,
											descricao,
											tipo_doc,
											num_doc
											) 
									VALUES(
											'".$var['mot']."',
											'".$var['leit']."',
											'".$var['valor']."',
											'1',
											'".date('Y-m-d')."',
											'".$var['descri']."',
											'".$var['fatu']."',
											'".$var['numdoc']."'					
										   )";	   								
	break;
	
	case "diferenca":
		//Verifica se o campo não está vazio
		$var['num'] = (int)$var['num'];
		if(str_replace(" ","",$var['num'])=='' || strlen($var['num'])<1)
		{
			exit(utf8_encode("Digite um valor valido de desconto!"));
		}
								
		$sql_add = "INSERT INTO 
						desconto_leit_fecha (
											id_leitura_fechamento,
											valor_desconto,
											leitura,
											data_desconto,
											descricao,
											id_maquina
											) 
									VALUES(
											'".$var['leit']."',
											'".$var['valor']."',
											'1',
											'".date('Y-m-d')."',
											'".$var['descri']."',
											'".$var['maq_id']."'	
										   )";	   								
	break;	


	case "desconto_fech":
		
		//Verifica se o campo não está vazio
		$var['num'] = (int)$var['num'];
		if(str_replace(" ","",$var['num'])=='' || strlen($var['num'])<1)
		{
			exit(utf8_encode("Digite um valor valido de desconto!"));
		}
	
								
		$sql_add = "INSERT INTO 
						desconto_leit_fecha (
											id_descricao,
											id_leitura_fechamento,
											valor_desconto,
											fechamento,
											data_desconto,
											descricao,
											tipo_doc,
											num_doc
											) 
									VALUES(
											'".$var['mot']."',
											'".$var['leit']."',
											'".$var['valor']."',
											'1',
											'".date('Y-m-d')."',
											'".$var['descri']."',
											'".$var['fatu']."',
											'".$var['numdoc']."'					
										   )";	     
									
	break;

	
	case "usuario":
		//Verifica se o campo não está vazio
		if(str_replace(" ","",$var['nome'])=='' || strlen($var['nome'])<=3)
		{
			exit(utf8_encode("Digite um nome com mais de 3 caracteres."));
		}
		
		if(str_replace(" ","",$var['login'])=='' || strlen($var['login'])<=3)
		{
			exit(utf8_encode("Digite um login com mais de 3 caracteres."));
		}
		
		if(str_replace(" ","",$var['senha'])=='' || strlen($var['senha'])<=3)
		{
			exit(utf8_encode("Digite uma senha com mais de 3 caracteres."));
		}
		
		if(str_replace(" ","",$var['email'])=='' || strlen($var['email'])<=3)
		{
			exit(utf8_encode("Digite email com mais de 3 caracteres."));
		}else
		{
			//Verificando se o e-mail é válido
			if (!valida_email($var['email'])) {
				exit(utf8_encode("O Email não é válido."));
			}
		}

		//Verifica se o login já existe
		$sql_en = "SELECT logins.* FROM logins WHERE logins.usuario='".$var['login']."' LIMIT 1";
		$query_en=@mysql_query($sql_en);
		$num_reg = @mysql_num_rows($query_en);

		//criptografa senha antes de guardar
		$senhaCrip = md5($var['senha']);

		$sql_add = "INSERT INTO logins (id_nivel,nome,usuario,senha,email,inclusao,excluido) VALUES('".$var['nivel']."','".$var['nome']."','".$var['login']."','".$senhaCrip."','".$var['email']."','".date('Y-m-d')."','N')";

		if($num_reg==1)
		{
			$dados_en=@mysql_fetch_assoc($query_en);
			if( $dados_en['excluido']!='S' )
			{
				exit(utf8_encode("Este login foi cadastrado anteriormente."));
			}
		}
	break;
}

if(@mysql_query($sql_add) )
{
	if( $tabela=='maquina')
	{
		if ( $var['jog']>1 )
		{
			$sql_i = "UPDATE interface SET id_maquina='".@mysql_insert_id()."' WHERE numero=".$var['jog'];
			@mysql_query($sql_i);
		}
		
		//buscar o ultimo id inserido de maquina
		$sql_maq_ins = "SELECT MAX(maquinas.id_maquina) AS id FROM maquinas";
		$query_maq_ins=@mysql_query($sql_maq_ins);
		$result_maq_ins=@mysql_fetch_assoc($query_maq_ins);		
		$ult_id_ins_maq = $result_maq_ins['id'];
		
		$sql_l = "INSERT INTO 
					leitura_por_maquina (id_leitura,id_maquina,valor_entrada,valor_saida,data_cadastro) 
				VALUES('1','".$ult_id_ins_maq."','0','0','".date('Y-m-d')."')";
		@mysql_query($sql_l);
		
	}
	exit(utf8_encode('Registro incluido com sucesso'));
}else{
	exit(utf8_encode("Usuario restrito para esta operação."));
}
exit('Falha ao cadastrar');
?>