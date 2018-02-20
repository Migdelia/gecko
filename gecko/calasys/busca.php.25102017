<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
unset($_SESSION['campos']);


//
if($_SESSION['id_login'] == 60)
{
	header('Location: main.php');
}



//Definindo o nome de cada area da tela
//Verificando se o nivel do usuario permite visualizar as abas referente ao financeiro (id_menu=11)
$sql_a = "
	SELECT
		*
	FROM
		acesso
	WHERE 
		(id_menu='15'
	OR
		id_menu='11')
	AND 
		id_nivel= '".$_SESSION['usr_nivel']."'
	AND 
		acesso='S'
	ORDER BY
		acesso.id_menu
	";
$query_a = @mysql_query($sql_a);


//
if (@mysql_num_rows( $query_a ) == 0) {
	//Caso não tenha acesso carrega guias comuns
	//$acoes = array('Níveis','Usuários','Lotes');
	$acoes = array('Locais');
	
	
	//se for parceiro carraga do mesmo jeito leitura 
	if($_SESSION['usr_nivel'] == 11)
	{
		$acoes = array('Leitura','Fechamento');
	}
}else{

	$flag = 0;
	while ($dados_perm=@mysql_fetch_assoc($query_a)) 
	{
		if($dados_perm['id_menu']==11)
		{
			$flag = 1;
		}
		else if($dados_perm['id_menu']==15)
		{
			if($flag==1)
			{
				$flag = 3;
			}
			else
			{
				$flag = 2;
			}
		}
	}

	if($flag==1)
	{
		$acoes = array('Fechamento');
	}
	else if($flag==2)
	{
		$acoes = array('Leitura');
	}
	else if($flag==3)
	{
		//Se tiver acesso, exibe todas as guias
		$acoes = array('Leitura','Fechamento');		
	}
}

//Pegando os locais para utilizar na pagina
$sql_reg = "
	SELECT
		`local`.id_local,
		`local`.nome
	FROM
		local
	WHERE
		`local`.id_local IN (".$_SESSION['reg_acesso'].")
		AND `local`.excluido='N'
	ORDER BY
		`local`.nome
	";

$query_reg=@mysql_query($sql_reg);



//Pegando os clientes para utilizar na pagina
$sql_cli = "
	SELECT
		cliente.id_cliente,
		cliente.nome
	FROM
		cliente
	WHERE
		cliente.id_cliente IN (".$_SESSION['reg_acesso'].")
		AND cliente.excluido='N'
	ORDER BY
		cliente.nome
	";

$query_cli=@mysql_query($sql_cli);


//Montando as Combos de Seleção de local.
$local="";
while ( $dados_reg=@mysql_fetch_assoc($query_reg) ) {
	$local.= "\n\t\t\t\t\t<option value='".$dados_reg['id_local']."'>".$dados_reg['nome']."</option>";
}

//Montando as Combos de Seleção de clientes.
$cliente="";
while ( $dados_cli=@mysql_fetch_assoc($query_cli) ) {
	$cliente.= "\n\t\t\t\t\t<option value='".$dados_cli['id_cliente']."'>".$dados_cli['nome']."</option>";
}

//Montando as Combos de Seleção de Lotes.
$atv="";
$stat = array('Cartao','Selo');
foreach ($stat as $v_atv ) {
	$atv.= "\n\t\t\t\t\t<option value='".$v_atv."'>".$v_atv."</option>";
}

//Montando o Nome de Cada Acordion com o Nome do Nivel
$conteudo='';
$conteudo_tab='';
foreach ($acoes as $chave=>$valor) {
	$conteudo_tab.= "\t\t\t\t<li><h5><a href='#tab".$chave."'>".htmlentities($valor)."</a></h5></li>\n";

	
	//Montando o Conteudo de cada Acordion
	switch ($valor) {
		case "Leitura":
		
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_local' id='create_local' action='busca.php' method='POST' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='param_lc' size='30' id='param_lc' value='".base64_encode('local')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tBusca de Leitura:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				
				
				//declara flag para saber se foi busca ou acesso
				$conteudo.="\n\t\t\t\t<input type='hidden' name='flag_busca' id='flag_busca' value='1'>";

				if(($_SESSION['usr_nivel']!=9) && ($_SESSION['usr_nivel']!=11))
				{
				//Informações do Local
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Numero:</div>";
				$conteudo.="\n\t\t\t\t<input label='Leitura' type='text' name='leit_num' size='7' id='leit_num' title='Informe o numero da Leitura' value='' onfocus=\"$('#info_leit_num').css({'visibility':'visible'});\" onblur=\"$('#info_leit_num').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_leit_num'>Numero da leitua</label><br>";
				}
				
				//verifica se eh operador
				if( ($_SESSION['usr_nivel']==8))
				{
					$whr = " WHERE id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];						
					$whrL = " WHERE id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
					$whrO = " WHERE id_login = ".$_SESSION['id_login'];
				}
								
				
				//SE FOR SOCIO
				if( ($_SESSION['usr_nivel']==9))
				{
					$sql_ope = "
						SELECT
							`local`.id_login,
							logins.nome
						FROM
							acesso_local
						INNER JOIN
							`local`
						ON
							acesso_local.id_local = `local`.id_local
						INNER JOIN
							logins
						ON
							`local`.id_login = logins.id_login
						WHERE
							acesso_local.id_nivel = 9
						GROUP BY
							logins.id_login
						ORDER BY
							logins.nome";
			
				}
				else if($_SESSION['usr_nivel'] == 11) //parceiro
				{
					$sql_ope = "
						SELECT
							logins.id_login,
							logins.nome
						FROM
							logins
						INNER JOIN
							vw_maquinas
						ON
							logins.id_login = vw_maquinas.id_login
						WHERE
							vw_maquinas.parceiro = 1
						GROUP BY
							logins.id_login
						ORDER BY
							logins.nome";				
				}
				else
				{				
					//operadores  /// quando nao é master nao mostrar os outros
					$sql_ope = "
						SELECT
							logins.id_login,
							logins.nome
						FROM
							logins
					" .$whrO . "
						GROUP BY
							logins.id_login
						ORDER BY
							logins.nome";



				}

				
					
				$query_ope = @mysql_query($sql_ope);	
				//Montando as Combos de regiaoes.
				$ope = '';
				$ope.= "\n\t\t\t\t\t<option value='0'>Todos</option>";
				while ( $dados_ope=@mysql_fetch_assoc($query_ope) ) {
					$ope.= "\n\t\t\t\t\t<option value='".$dados_ope['id_login']."'>".$dados_ope['nome']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_lc_reg'>Operador:</div>";
				$conteudo.="\n\t\t\t\t<select name='nome_ope' id='nome_ope'  style='width:130px;' onfocus=\"$('#info_lc_ope').css({'visibility':'visible'});\" onblur=\"$('#info_lc_ope').css({'visibility':'hidden'});\">";
				$conteudo.=$ope;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_ope_leit'>Operador Leitura.</label><br>";					


				//SE FOR SOCIO
				if( ($_SESSION['usr_nivel']==9))
				{
					//local
					$sql_loc = "
						SELECT
							`local`.id_local,
							`local`.nome
						FROM
							acesso_local
						INNER JOIN
							`local`
						ON
							acesso_local.id_local = `local`.id_local
						INNER JOIN
							logins
						ON
							`local`.id_login = logins.id_login
						WHERE
							acesso_local.id_nivel = 9
						GROUP BY
							`local`.id_local
						ORDER BY
							`local`.nome";			
				}
				else if($_SESSION['usr_nivel'] == 11) // parceiro
				{
					//local
					$sql_loc = "
						SELECT
							`local`.id_local,
							`local`.nome
						FROM
							local
						INNER JOIN
							vw_maquinas
						ON
							`local`.id_local = vw_maquinas.id_local
						WHERE
							vw_maquinas.parceiro = 1
						GROUP BY
							`local`.id_local
						ORDER BY
							`local`.nome
					";					
				}
				else
				{
					//local
					$sql_loc = "
						SELECT
							`local`.id_local,
							`local`.nome
						FROM
							local
						" .$whrL . "	
						GROUP BY
							`local`.id_local
						ORDER BY
							`local`.nome
					";							
				}


				
				
				$query_loc = @mysql_query($sql_loc);
				//Montando as Combos de regiaoes.
				$loc = '';
				$loc.= "\n\t\t\t\t\t<option value='0'>Todos</option>";				
				while ( $dados_loc=@mysql_fetch_assoc($query_loc) ) {
					$loc.= "\n\t\t\t\t\t<option value='".$dados_loc['id_local']."'>".$dados_loc['nome']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_loc'>Local:</div>";
				$conteudo.="\n\t\t\t\t<select name='loc' id='loc'  style='width:130px;' onfocus=\"$('#info_loc').css({'visibility':'visible'});\" onblur=\"$('#info_loc').css({'visibility':'hidden'});\">";
				$conteudo.=$loc;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc'>Local.</label><br>";					
				
				/*
				//data
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local_rut'>Buscar por Data:</div>";
				$conteudo.="\n\t\t\t\t<input type='checkbox' id='por_data' name='por_data' />";
				*/
			
				$conteudo.="\n\t\t\t\t<br><br><button id='btn_busca' type='button' class='bt-enviar' style='margin-left:50px;'>Buscar</button>";				
				

				
				
				
				
				
				//teste de div que mostra resultado da busca
				//titulo da div de busca
				$flag_busca = $_POST['flag_busca'];
				$id_leit = $_POST['leit_num'];
				$id_ope = $_POST['nome_ope'];
				$id_loc = $_POST['loc'];

				
				//monta o where 
				$wh = "WHERE 1 = 1";
				
				
				//
				/*
				if( ($_SESSION['usr_nivel']==9))
				{
					$wh .= " AND (leitura.id_login = 23 
					OR
						  leitura.id_login = 24
					OR
						  leitura.id_login = 25
					OR
						  leitura.id_login = 26
					OR
						  leitura.id_login = 21)";
				}
				*/
				
				if($id_leit != '')
				{
					$wh .= " AND leitura.id_leitura = " . $id_leit;
					
					//verifica se eh operador
					if( ($_SESSION['usr_nivel']==8))
					{
						$wh .= " AND leitura.id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
					}					
					
				}
				else if($id_ope != 0)
				{
					$wh .= " AND leitura.id_login = " . $id_ope . " OR `local`.id_gerente = " . $id_ope;
					//verifica se eh master
					if( ($_SESSION['usr_nivel']==8))
					{
						$wh .= " AND leitura.id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
					}						
				}
				else if($id_loc != 0)
				{
					$wh .= " AND leitura.id_local = " . $id_loc;
					//verifica se eh master
					if( ($_SESSION['usr_nivel']==8))
					{
						$wh .= " AND leitura.id_login = ".$_SESSION['id_login']. " OR `local`.id_gerente = " . $_SESSION['id_login'];
					}						
				}
				else
				{
					//verifica se eh master
					if( ($_SESSION['usr_nivel']==8))
					{
						$wh .= " AND leitura.id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
					}				
				}							

				
				//atribui a ordem que mostra as leituras
				$wh .= " ORDER BY data DESC, leitura.id_leitura DESC LIMIT 100";
								
				$conteudo.="\n\t\t\t\t<div id='tit' width='100%' align='center' style='margin-top:50px; background-color:#FFFFFF;color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder;'>";
				
				//efetua a query de busca
				$sql_leit = "
					SELECT
							leitura.id_leitura,
							`local`.nome,
							leitura.`data`,
							leitura.fechada,
							logins.nome as operador,
							leitura.semana,
							leitura.data_fechamento,
							leitura.id_tipo_local
					FROM
							leitura
					INNER JOIN
							`local`
					ON
							leitura.id_local = `local`.id_local
					INNER JOIN
							logins
					ON
							leitura.id_login = logins.id_login										
					".$wh;
					
				

				$query_leit=@mysql_query($sql_leit);						
				$qtd_reg = mysql_num_rows($query_leit);				
				
				//verifica a quantidade de registros
				if($flag_busca !== "1")
				{
					$conteudo.="\n\t\t\t\t Resultados: <font size='2' color='#485F65'> 0 Registros</font>";
				}
				else
				{
					$conteudo.="\n\t\t\t\t Resultados: <font size='2' color='#485F65'>" . $qtd_reg . " Registros</font>";
					
					//ver resultados
					$conteudo.="\n\t\t\t\t<button id='busca_local' type='button' class='acao' style='cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;width:80px; margin-left:15px;'>Ver</button>";					
				}

				$conteudo.="\n\t\t\t\t</div>";

				//div que mostra o resultado da busca
				$conteudo.="\n\t\t\t\t<div id='res_let' width='100%' align='center' style='display:none;margin-top:20px; background-color:#FFFFFF;color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px;font-weight:bolder;'>";			

				//verifica se ja foi solicitada a busca
				if($flag_busca == "1")
				{	
					
						
					//echo $sql_leit;
						
		
					//abre tabela
					$conteudo.="\n\t\t\t\t<table width='100%' border='0' align='center'>";
					
					
					
						if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#e6e5e5";}
						$conteudo.="\n\t\t\t\t<tr bgcolor='".$cor_linha."'>";
							$conteudo.="\n\t\t\t\t<td>";
							$conteudo.="\n\t\t\t\t ID";		
							$conteudo.="\n\t\t\t\t</td>";
							$conteudo.="\n\t\t\t\t<td>";
							$conteudo.="\n\t\t\t\t DATA REALIZADA";			
							$conteudo.="\n\t\t\t\t</td>";
							$conteudo.="\n\t\t\t\t<td>";
							$conteudo.="\n\t\t\t\t SEMANA REFERENCIA";				
							$conteudo.="\n\t\t\t\t</td>";	
							$conteudo.="\n\t\t\t\t<td>";
							$conteudo.="\n\t\t\t\t LOCAL";				
							$conteudo.="\n\t\t\t\t</td>";
							$conteudo.="\n\t\t\t\t<td>";
							$conteudo.="\n\t\t\t\t FEITA POR";				
							$conteudo.="\n\t\t\t\t</td>";							
							$conteudo.="\n\t\t\t\t<td>";
							$conteudo.= "STATUS";			
							$conteudo.="\n\t\t\t\t</td>";							


										
						$conteudo.="\n\t\t\t\t</tr>";					


					
					while ($dados_leit=@mysql_fetch_assoc($query_leit)) 
					{
						if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}
						$conteudo.="\n\t\t\t\t<tr bgcolor='".$cor_linha."'>";
							$conteudo.="\n\t\t\t\t<td>";
							$conteudo.="\n\t\t\t\t <a href='detalhes_leitura.php?id=".$dados_leit['id_leitura']."' target='_blank' style='text-decoration:none;'>";
								$conteudo.= $dados_leit['id_leitura'];
							$conteudo.="\n\t\t\t\t</a>";		
							$conteudo.="\n\t\t\t\t</td>";
							$conteudo.="\n\t\t\t\t<td>";
								$newDate = date("d-m-Y", strtotime($dados_leit['data']));
								$conteudo.= $newDate;			
							$conteudo.="\n\t\t\t\t</td>";
							$conteudo.="\n\t\t\t\t<td>";
								if($dados_leit['data_fechamento'] !== "0000-00-00")
								{
									$conteudo.= "Sem: " . $dados_leit['semana'] . " / " . date("M-Y", strtotime($dados_leit['data_fechamento']));
								}
								else
								{
									$conteudo.= "Sem: " . $dados_leit['semana'];								
								}		
							$conteudo.="\n\t\t\t\t</td>";	
							$conteudo.="\n\t\t\t\t<td>";
								$conteudo.= $dados_leit['nome'];			
							$conteudo.="\n\t\t\t\t</td>";
							$conteudo.="\n\t\t\t\t<td>";
								$conteudo.= $dados_leit['operador'];			
							$conteudo.="\n\t\t\t\t</td>";
							
							if($dados_leit['fechada'] == 1)
							{
								$conteudo.="\n\t\t\t\t<td>";
									$conteudo.= "Fechada";			
								$conteudo.="\n\t\t\t\t</td>";							
							}
							else
							{
								$conteudo.="\n\t\t\t\t<td>";
									$conteudo.= "Aberta";			
								$conteudo.="\n\t\t\t\t</td>";							
							}							
							

										
						$conteudo.="\n\t\t\t\t</tr>";	
					}
					
					$conteudo.="\n\t\t\t\t</table>";					
				}

							
				$conteudo.="\n\t\t\t\t</div>";
				
				//fim teste de div que lista resultado
				
				
				
				
				
				
				
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";
		break;	
		
		
		
		case "Fechamento":

			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='busca_fecha' id='busca_fecha' action='busca.php' method='POST' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='param_fecha' size='30' id='param_fecha' value='".base64_encode('local')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tBusca de Fechamento:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				
				
				//declara flag para saber se foi busca ou acesso
				$conteudo.="\n\t\t\t\t<input type='hidden' name='flag_busca_fecha' id='flag_busca_fecha' value='1'>";

				if(($_SESSION['usr_nivel']!=9) && ($_SESSION['usr_nivel']!=11))
				{
				//Informações do Local
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Numero:</div>";
				$conteudo.="\n\t\t\t\t<input label='Fechamento' type='text' name='fecha_num' size='7' id='fecha_num' title='Informe o numero do fechamento' value='' onfocus=\"$('#info_fecha_num').css({'visibility':'visible'});\" onblur=\"$('#info_fecha_num').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_fecha_num'>Numero do fechamento</label><br>";
				}
				
				//verifica se eh master
				if( ($_SESSION['usr_nivel']==8))
				{
					$whr = " WHERE id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
				}
								
				
				
				//SE FOR SOCIO
				if( ($_SESSION['usr_nivel']==9))
				{
					$sql_ope = "
						SELECT
							`local`.id_login,
							logins.nome
						FROM
							acesso_local
						INNER JOIN
							`local`
						ON
							acesso_local.id_local = `local`.id_local
						INNER JOIN
							logins
						ON
							`local`.id_login = logins.id_login
						WHERE
							acesso_local.id_nivel = 9
						GROUP BY
							logins.id_login
						ORDER BY
							logins.nome";
			
				}
				else if($_SESSION['usr_nivel'] == 11) //parceiro
				{
					$sql_ope = "
						SELECT
							logins.id_login,
							logins.nome
						FROM
							logins
						INNER JOIN
							vw_maquinas
						ON
							logins.id_login = vw_maquinas.id_login
						WHERE
							vw_maquinas.parceiro = 1
						AND
							logins.id_login = 32							
						GROUP BY
							logins.id_login
						ORDER BY
							logins.nome";				
				}				
				else
				{
					//operadores
					$sql_ope = "
						SELECT
							logins.id_login,
							logins.nome
						FROM
							logins
						" .$whrO . "
						GROUP BY
							logins.id_login
						ORDER BY
							logins.nome
					";
				}				
				
				
				
				$query_ope = @mysql_query($sql_ope);
				//Montando as Combos de regiaoes.
				$ope = '';
				$ope.= "\n\t\t\t\t\t<option value='0'>Todos</option>";
				while ( $dados_ope=@mysql_fetch_assoc($query_ope) ) {
					$ope.= "\n\t\t\t\t\t<option value='".$dados_ope['id_login']."'>".$dados_ope['nome']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_fecha_reg'>Responsavel:</div>";
				$conteudo.="\n\t\t\t\t<select name='nome_ope_fecha' id='nome_ope_fecha'  style='width:130px;' onfocus=\"$('#info_fecha_ope').css({'visibility':'visible'});\" onblur=\"$('#info_fecha_ope').css({'visibility':'hidden'});\">";
				$conteudo.=$ope;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_ope_fecha'>Operador Fechamento.</label><br>";					



				//SE FOR SOCIO
				if( ($_SESSION['usr_nivel']==9))
				{
					//local
					$sql_loc = "
						SELECT
							`local`.id_local,
							`local`.nome
						FROM
							acesso_local
						INNER JOIN
							`local`
						ON
							acesso_local.id_local = `local`.id_local
						INNER JOIN
							logins
						ON
							`local`.id_login = logins.id_login
						WHERE
							acesso_local.id_nivel = 9
						GROUP BY
							`local`.id_local
						ORDER BY
							`local`.nome";			
				}
				else if($_SESSION['usr_nivel'] == 11) // parceiro
				{
					//local
					$sql_loc = "
						SELECT
							`local`.id_local,
							`local`.nome
						FROM
							local
						INNER JOIN
							vw_maquinas
						ON
							`local`.id_local = vw_maquinas.id_local
						WHERE
							vw_maquinas.parceiro = 1
						AND
							`local`.id_local = 101
						GROUP BY
							`local`.id_local
						ORDER BY
							`local`.nome
					";					
				}				
				else
				{
					//local
					$sql_loc = "
						SELECT
							`local`.id_local,
							`local`.nome
						FROM
							local
						" .$whrL . "
						GROUP BY
							`local`.id_local
						ORDER BY
							`local`.nome
					";
				}
					
				$query_loc = @mysql_query($sql_loc);
				//Montando as Combos de regiaoes.
				$loc = '';
				$loc.= "\n\t\t\t\t\t<option value='0'>Todos</option>";				
				while ( $dados_loc=@mysql_fetch_assoc($query_loc) ) {
					$loc.= "\n\t\t\t\t\t<option value='".$dados_loc['id_local']."'>".$dados_loc['nome']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_loc'>Local:</div>";
				$conteudo.="\n\t\t\t\t<select name='loc_fecha' id='loc_fecha'  style='width:130px;' onfocus=\"$('#info_loc_fecha').css({'visibility':'visible'});\" onblur=\"$('#info_loc_fecha').css({'visibility':'hidden'});\">";
				$conteudo.=$loc;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_fecha'>Local.</label><br>";					
				
				/*
				//data
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local_rut'>Buscar por Data:</div>";
				$conteudo.="\n\t\t\t\t<input type='checkbox' id='por_data' name='por_data' />";
				*/
				$conteudo.="\n\t\t\t\t<br><br><button id='btn_busca_fecha' type='button' class='bt-enviar' style='margin-left:50px;'>Buscar</button>";				
				

				
				
				
				
				
				//teste de div que mostra resultado da busca
				//titulo da div de busca
				$flag_busca_fecha = $_POST['flag_busca_fecha'];
				$id_fecha = $_POST['fecha_num'];
				$id_ope = $_POST['nome_ope_fecha'];
				$id_loc = $_POST['loc_fecha'];

				
				//monta o where
				$wh = "WHERE 1 = 1";
				
				//echo $_SESSION['usr_nivel'] . "<br />";
				//echo $id_ope;
				if($id_fecha != '')
				{
					$wh .= " AND fechamento.id_fechamento = " . $id_fecha;
					//verifica se eh master
					if( ($_SESSION['usr_nivel']==8))
					{
						$wh .= " AND fechamento.id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
					}						
				}
				else if($id_ope != 0) ///aqui
				{
					$wh .= " AND `local`.id_login = " . $id_ope . " OR `local`.id_gerente = " . $id_ope;
					//verifica se eh master
					if( ($_SESSION['usr_nivel']==8))
					{
						$wh .= " AND fechamento.id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
					}					
				}
				else if($id_loc != 0)
				{
					$wh .= " AND `local`.id_local = " . $id_loc;
					//verifica se eh master
					if( ($_SESSION['usr_nivel']==8))
					{
						$wh .= " AND fechamento.id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
					}						
				}
				else
				{
					//verifica se eh master
					if( ($_SESSION['usr_nivel']==8))
					{
						$wh .= " AND fechamento.id_login = ".$_SESSION['id_login']." OR `local`.id_gerente = " . $_SESSION['id_login'];
					}					
				}

				
				//atribui a ordem que mostra as leituras
				$wh .= " GROUP BY
							fechamento.id_fechamento
						ORDER BY
							fechamento.data_fechamento DESC,
							fechamento.id_fechamento DESC
						LIMIT 100";
								
				$conteudo.="\n\t\t\t\t<div id='tit_fecha' width='100%' align='center' style='margin-top:50px; background-color:#FFFFFF;color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder;'>";
				
				//efetua a query de busca
				$sql_fecha = "
					SELECT
						fechamento.id_fechamento,
						`local`.nome,
						fechamento.`data_fechamento`,
						logins.nome AS operador,
						`local`.id_login AS id_responsavel
					FROM
						fechamento
					INNER JOIN `leitura` ON fechamento.id_fechamento = `leitura`.id_fechamento
					INNER JOIN `local`	ON	leitura.id_local = `local`.id_local
					INNER JOIN logins ON fechamento.id_login = logins.id_login										
					".$wh;	

				$query_fecha=@mysql_query($sql_fecha);						
				$qtd_reg_fecha = mysql_num_rows($query_fecha);

				//echo $sql_fecha;
				
				
				//verifica a quantidade de registros
				if($flag_busca_fecha !== "1")
				{
					$conteudo.="\n\t\t\t\t Resultados: <font size='2' color='#485F65'> 0 Registros</font>";
				}
				else
				{
					$conteudo.="\n\t\t\t\t Resultados: <font size='2' color='#485F65'>" . $qtd_reg_fecha . " Registros</font>";
					
					//ver resultados
					$conteudo.="\n\t\t\t\t<button id='busca_fecha' type='button' class='acao_fecha' style='cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;width:80px; margin-left:15px;'>Ver</button>";					
				}

				$conteudo.="\n\t\t\t\t</div>";

				//div que mostra o resultado da busca
				$conteudo.="\n\t\t\t\t<div id='res_fecha' width='100%' align='center' style='display:none;margin-top:20px; background-color:#FFFFFF;color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px;font-weight:bolder;'>";			

				//verifica se ja foi solicitada a busca
				if($flag_busca_fecha == "1")
				{	
					
						
					//echo $sql_leit;
						
		
					//abre tabela
					$conteudo.="\n\t\t\t\t<table width='100%' border='0' align='center'>";
					



					if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#e6e5e5";}
					$conteudo.="\n\t\t\t\t<tr bgcolor='".$cor_linha."'>";
						$conteudo.="\n\t\t\t\t<td>";
						$conteudo.="\n\t\t\t\t ID";		
						$conteudo.="\n\t\t\t\t</td>";
						$conteudo.="\n\t\t\t\t<td>";
						$conteudo.="\n\t\t\t\t DATA REALIZADO";			
						$conteudo.="\n\t\t\t\t</td>";
						$conteudo.="\n\t\t\t\t<td>";
						$conteudo.="\n\t\t\t\t SEMANA REFERENCIA";				
						$conteudo.="\n\t\t\t\t</td>";	
						$conteudo.="\n\t\t\t\t<td>";
						$conteudo.="\n\t\t\t\t OPERADOR";				
						$conteudo.="\n\t\t\t\t</td>";
						$conteudo.="\n\t\t\t\t<td>";
						$conteudo.="\n\t\t\t\t RESPONSAVEL";				
						$conteudo.="\n\t\t\t\t</td>";							

									
					$conteudo.="\n\t\t\t\t</tr>";	




					
					while ($dados_fecha=@mysql_fetch_assoc($query_fecha)) 
					{
						if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}
						$conteudo.="\n\t\t\t\t<tr bgcolor='".$cor_linha."'>";
							$conteudo.="\n\t\t\t\t<td>";
							
							//efetua a query de busca
							$sql_tp_fecha = "
								SELECT
									max(leitura.id_local)AS id_local,
									id_tipo_local
								FROM
									leitura
								WHERE
									leitura.id_fechamento =  '".$dados_fecha['id_fechamento']."'
								";	
			
							$query_tp_fecha=@mysql_query($sql_tp_fecha);						
							$res_tp_fecha=@mysql_fetch_assoc($query_tp_fecha);
							
							
							
							
							/*
							$sql_tp_loc = "
								SELECT
									`local`.id_tp_local
								FROM
									`local`
								WHERE
									`local`.id_local =  '".$res_tp_fecha['id_local']."'
								";	
			
							$query_tp_loc=@mysql_query($sql_tp_loc);						
							$res_tp_loc=@mysql_fetch_assoc($query_tp_loc);			*/				
							
							
							
							
							
							
							
							//verifica se o fechamento eh de rua ou de local.
							if($res_tp_fecha['id_tipo_local'] == 1)
							{
								$conteudo.="\n\t\t\t\t<a <a href='viewer_fechamento_rua.php?id=".$dados_fecha['id_fechamento']."' target='_blank' style='text-decoration:none;'>";
									$conteudo.= $dados_fecha['id_fechamento'];
								$conteudo.="\n\t\t\t\t</a>";
							}							
							else if($res_tp_fecha['id_tipo_local'] == 2)
							{
								$conteudo.="\n\t\t\t\t<a <a href='viewer_fechamento_local.php?id=".$dados_fecha['id_fechamento']."' target='_blank' style='text-decoration:none;'>";
									$conteudo.= $dados_fecha['id_fechamento'];
								$conteudo.="\n\t\t\t\t</a>";
							}
							else if($res_tp_fecha['id_tipo_local'] == 3)
							{
								$conteudo.="\n\t\t\t\t<a <a href='viewer_fechamento_lan.php?id=".$dados_fecha['id_fechamento']."' target='_blank' style='text-decoration:none;'>";
									$conteudo.= $dados_fecha['id_fechamento'];
								$conteudo.="\n\t\t\t\t</a>";
							}							
							else if($res_tp_fecha['id_tipo_local'] == 4)
							{
								$conteudo.="\n\t\t\t\t<a <a href='viewer_fechamento_proprio.php?id=".$dados_fecha['id_fechamento']."' target='_blank' style='text-decoration:none;'>";
									$conteudo.= $dados_fecha['id_fechamento'];
								$conteudo.="\n\t\t\t\t</a>";							
							}							
							
							
		
							$conteudo.="\n\t\t\t\t</td>";
							$conteudo.="\n\t\t\t\t<td>";
								$newDate = date("d-m-Y", strtotime($dados_fecha['data_fechamento']));
								$conteudo.= $newDate;			
							$conteudo.="\n\t\t\t\t</td>";
							
							
							//CONSULTA A SEMANA DO FECHAMENTO.
							$sql_sem_fecha = "
								SELECT
										semana,
										data_fechamento
								FROM
										leitura
								WHERE
										leitura.id_fechamento = ". $dados_fecha['id_fechamento'];
			
							$query_sem_fecha=@mysql_query($sql_sem_fecha);
							$result_sem_fecha=@mysql_fetch_assoc($query_sem_fecha);							
							
							
							$conteudo.="\n\t\t\t\t<td>";
								$newDate = "Sem: " . $result_sem_fecha['semana'] . " / " . date("M-Y", strtotime($result_sem_fecha['data_fechamento']));
								$conteudo.= $newDate;			
							$conteudo.="\n\t\t\t\t</td>";							
							$conteudo.="\n\t\t\t\t<td>";
								$conteudo.= $dados_fecha['operador'];		
							$conteudo.="\n\t\t\t\t</td>";
							
							//CONSULTA O NOME DO RESPONSAVEL POR ESSE LOCAL.
							$sql_responsa = "
								SELECT
										nome
								FROM
										logins
								WHERE
										logins.id_login = ". $dados_fecha['id_responsavel'];
			
							$query_responsa=@mysql_query($sql_responsa);
							$result_responsa=@mysql_fetch_assoc($query_responsa);

							
							$conteudo.="\n\t\t\t\t<td>";
								$conteudo.= $result_responsa['nome'];			
							$conteudo.="\n\t\t\t\t</td>";
							
					
							

										
						$conteudo.="\n\t\t\t\t</tr>";	
					}
					
					$conteudo.="\n\t\t\t\t</table>";					
				}

							
				$conteudo.="\n\t\t\t\t</div>";
				
				//fim teste de div que lista resultado
				
				
				
				
				
				
				
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";

		break;			



	

		default:
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
			$conteudo.="\n\t\t\t\t<table width='100%' border='0' align='left' cellpadding='2' cellspacing='4'>";
			$conteudo.="\n\t\t\t\t\t<tr bgcolor='#C0C0C0' height='21px;' style='font-weight:bolder' align='center'>";
			$conteudo.="\n\t\t\t\t\t\t<th colspan='2' style='color:#FFFFFF;'>";
			$conteudo.="\n\t\t\t\t\t\t\t".$valor;
			$conteudo.="\n\t\t\t\t\t\t</th>";
			$conteudo.="\n\t\t\t\t\t</tr>";
			$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;'>";
			$conteudo.="\n\t\t\t\t\t\t<td colspan='2' align='center'>";
			$conteudo.="\n\t\t\t\t\t\t\tArea atualmente em Desenvolvimento.<br />Entre em contato com o Administrador do sistema.";
			$conteudo.="\n\t\t\t\t\t\t</td>";
			$conteudo.="\n\t\t\t\t\t</tr>";
			$conteudo.="\n\t\t\t\t</table>";
			$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";

		break;

	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="url" content="<?php echo $dominio ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="<?php echo $description?>" />
	<meta name="robots" content="noindex,nofollow">
	<title>..::Administrativo - <?php echo $description?> ::..</title>
	<!--<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />-->
	<link rel="icon" href="img/favicon.gif" type="image/gif" />
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=<?php echo $dominio ?>/nojavascript.html" />
	</noscript>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.dimensions.js"></script>
	<script type="text/javascript" src="js/jquery.positionBy.js"></script>
	<script type="text/javascript" src="js/jquery.jdMenu.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.3.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript" language="javascript" src="js/media/jquery.ui.datepicker-pt-BR.js"></script>
	<script type="text/javascript" src="js/jquery.price_format.1.0.js"></script>
	<script type="text/javascript" language="javascript">
		$(function(){
			// Tabs
			$( "#tabs" ).tabs({
				cookie: {
					// store cookie for a day, without, it would be a session cookie
					expires: 1
				}
			});

			//hover states on the static widgets
			$('#dialog_link, ul#icons li').hover(
				function() { $(this).addClass('ui-state-hover'); }, 
				function() { $(this).removeClass('ui-state-hover'); }

			);
			
			$("#valor_anuidade").priceFormat({
				prefix: '',
				centsSeparator: ',',
				thousandsSeparator: '.'
			});
			$("#valor_desconto").priceFormat({
				prefix: '',
				centsSeparator: ',',
				thousandsSeparator: '.'
			});
			//$.datepicker.setDefaults($.datepicker.local['pt-BR']);
			$( "#data_anuidade" ).datepicker();
			$( "#data_anuidade" ).attr('readonly','readonly');
			$( "#data_vcto" ).datepicker();
			$( "#data_vcto" ).attr('readonly','readonly');
			$( "#data_inicio" ).datepicker();
			$( "#data_inicio" ).attr('readonly','readonly');
			$( "#data_fim" ).datepicker();
			$( "#data_fim" ).attr('readonly','readonly');
		});

		$(document).ready(function() {
			
			//di
			$('.acao').click(function()
			{ /* Quando usuario clica no botão ele executa está ação*/
				$('#res_let').slideToggle('slow');
				//isso mmuda o que tem na div
				//$("#res_let").html("Este é o novo texto heehe!");
			});
			
			//
			$('.acao_fecha').click(function()
			{ /* Quando usuario clica no botão ele executa está ação*/
				$('#res_fecha').slideToggle('slow');
				//isso mmuda o que tem na div
				//$("#res_let").html("Este é o novo texto heehe!");
			});			
		
		
			$("#btn_busca").click(function(event){
			
			
				if ($("#nome_ope").attr("value") == 0)
				{
					if($("#loc").attr("value") == 0)
					{
						alert("Elija un local o operador!");
						return false;
					}
				}
				
				if ($("#loc").attr("value") == 0)
				{
					if($("#nome_ope").attr("value") == 0)
					{
						alert("Elija un Local o operador!");
						return false;
					}
				}			
			
				document.create_local.submit();
			
				/*
				event.preventDefault();
				var vl_des =$("#descricao").attr("value");
				var vl_par =$("#param_nv").attr("value");
				$('<div id="agd_proc_nivel" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_nivel").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,descricao:vl_des},function(json){
					$("#arq_nivel").attr('disabled','');
					$("#agd_proc_nivel").remove();
					//location.reload();
					if(json=='Registro incluido com sucesso')
					{
						$("#descricao").val("");
					}
					alert(json);
				});*/
			});
			
			$("#btn_busca_fecha").click(function(event){
			
				if ($("#nome_ope_fecha").attr("value") == 0)
				{
					if($("#loc_fecha").attr("value") == 0)
					{
						alert("Elija un local o operador!");
						return false;
					}
				}
				
				if ($("#loc_fecha").attr("value") == 0)
				{
					if($("#nome_ope_fecha").attr("value") == 0)
					{
						alert("Elija un Local o operador!");
						return false;
					}
				}				
					
				document.busca_fecha.submit();
			
				/*
				event.preventDefault();
				var vl_des =$("#descricao").attr("value");
				var vl_par =$("#param_nv").attr("value");
				$('<div id="agd_proc_nivel" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_nivel").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,descricao:vl_des},function(json){
					$("#arq_nivel").attr('disabled','');
					$("#agd_proc_nivel").remove();
					//location.reload();
					if(json=='Registro incluido com sucesso')
					{
						$("#descricao").val("");
					}
					alert(json);
				});*/
			});			

			$("#arq_local").click(function(event){
				event.preventDefault();
				var vl_nom =$("#lc_nome").attr("value");
				var vl_rut =$("#lc_rut").attr("value");
				var vl_dig =$("#local_rut_dig").attr("value");
				var vl_end =$("#lc_end").attr("value");
				var vl_ope =$("#lc_ope").attr("value");
				var vl_par =$("#param_lc").attr("value");
				var vl_pct =$("#lc_pct").attr("value");
				var vl_reg =$("#lc_reg").attr("value");
				var vl_tp_loc =$("#tp_loc").attr("value");
				
				
				$('<div id="agd_proc_local" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_local").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,nome:vl_nom,rut:vl_rut,dig:vl_dig,end:vl_end,ope:vl_ope,pct:vl_pct,reg:vl_reg,tp_loc:vl_tp_loc},function(json){
					$("#arq_local").attr('disabled','');
					$("#agd_proc_local").remove();
					if(json=='Registro incluido com sucesso')
					{
						$("#lc_nome").val("");
					}
					alert(json);
					location.reload();
				});
			});


			//maquinas
			$("#arq_maq").click(function(event){
				event.preventDefault();
				
				var vl_num =$("#maq_num").attr("value");
				var vl_mod =$("#maq_gab").attr("value");
				var vl_jog =$("#maq_jog").attr("value");
				var vl_loc =$("#maq_loc").attr("value");
				var vl_obs =$("#maq_obs").attr("value");
				var vl_par =$("#param_maq").attr("value");
				var vl_porc =$("#maq_por").attr("value");
				
				
				$('<div id="agd_proc_local" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_maq").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,num:vl_num,gab:vl_mod,jog:vl_jog,loc:vl_loc,obs:vl_obs,porc:vl_porc},function(json){
					$("#arq_maq").attr('disabled','');
					$("#agd_proc_maq").remove();
					//location.reload();
					if(json=='Registro incluido com sucesso')
					{
						$("#lc_nome").val("");
					}
					alert(json);
					location.reload();
				});
			});
			
			
			//Regiao
			$("#arq_reg").click(function(event){
				event.preventDefault();
				var vl_nom =$("#reg_nome").attr("value");
				var vl_par =$("#param_reg").attr("value");
				$('<div id="agd_proc_regiao" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_local").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,nome:vl_nom},function(json){
					$("#arq_reg").attr('disabled','');
					$("#agd_proc_reg").remove();
					if(json=='Registro incluido com sucesso')
					{
						$("#lc_nome").val("");
					}
					alert(json);
					location.reload();
				});
			});

			//Interface
			$("#arq_int").click(function(event){
				event.preventDefault();
				var vl_num =$("#numero").attr("value");
				var vl_jog =$("#int_jog").attr("value");
				var vl_par =$("#param_int").attr("value");

				$('<div id="agd_proc_interface" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_interface');
				$("#arq_interface").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,num:vl_num,jog:vl_jog},function(json){
					$("#arq_int").attr('disabled','');
					$("#agd_proc_int").remove();
					if(json=='Registro incluido com sucesso')
					{
						$("#numero").val("");
					}
					alert(json);
					location.reload();
				});
			});
			
			$("#arq_cliente").click(function(event){
				event.preventDefault();

				var vl_nom =$("#cliente_nome").attr("value");
				var vl_rut =$("#cliente_rut").attr("value");
				var vl_dig =$("#cliente_rut_dig").attr("value");
				var vl_email =$("#cliente_email").attr("value");
				var vl_sexo =$("#cliente_sexo").attr("value");
				var vl_par =$("#param_cli").attr("value");
				
				$('<div id="agd_proc_cli" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_cliente").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,nome:vl_nom,rut:vl_rut,digito:vl_dig,email:vl_email,sexo:vl_sexo},function(json){
					$("#arq_cliente").attr('disabled','');
					$("#agd_proc_cli").remove();
					//location.reload();
					if(json=='Registro incluido com sucesso')
					{
						$("#lc_nome").val("");
					}
					alert(json);
				});
			});

			$("#arq_usr").click(function(event){
				event.preventDefault();
				var vl_par =$("#param_usr").attr("value");
				var vl_nom =$("#usr_nome").attr("value");
				var vl_usr =$("#usr_usuario").attr("value");
				var vl_ema =$("#usr_email").attr("value");
				var vl_niv =$("#usr_nv").attr("value");
				var vl_sen =$("#usr_senha").attr("value");
				$('<div id="agd_proc_usr" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_usr").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,nome:vl_nom,login:vl_usr,senha:vl_sen,nivel:vl_niv,email:vl_ema},function(json){
					$("#arq_usr").attr('disabled','');
					$("#agd_proc_usr").remove();
					//location.reload();
					alert(json);
					if(json=='Registro incluido com sucesso')
					{
						$("#usr_nome").val("");
						$("#usr_usuario").val("");
						$("#usr_email").val("");
						$("#usr_nv").val("");
						$("#usr_senha").val("");
					}
			 		
				});
			});
			
			
			
			
			
			

			//Responsavel por Gerar a etiqueta. Pega os campos do form e passa para o popup via GET			
			$("#ger_cartao").click( function () {
				if (confirm('Atenção!\n\nDeseja realmente gerar o Lote especificado.\nEsta operação poderá levar varios minutos.\nNão feche a janela que se abrirá.\nEla será fechada automaticamente ao término da operação')) {
					$("#lote_cartao").submit();
				}else{
					return false;
				};
			});

			//Responsavel por validar o envio do arquivo de retorno
			$("#arq_processa").click( function () {
				if ( $("#file").val()=='' ) {
					alert('Voce deve selecionar o arquivo antes de processá-lo');
					return false;
				}else if (confirm('Atenção!\n\nDeseja realmente Processar o arquivo do banco.\nEsta operação poderá levar varios minutos.\nNão feche a janela que se abrirá.')) {
					$("#arq_baixa").submit();
				}else{
					return false;
				};
			});
			
			//Responsavel por Gerar os repasses. Pega os campos do form e passa para o popup via GET			
			$("#ger_repasse").click( function () {
				if (confirm('Atenção!\n\nDeseja realmente gerar o arquivo de Repasses.\nEsta operação poderá levar vários minutos.\nNão feche a janela que se abrirá.\nEla será fechada automaticamente ao término da operação')) {
					$("#repasse").submit();
				}else{
					return false;
				};
			});
		});
	</script>

	<style type="text/css" title="currentStyle">
		@import "css/media/themes/smoothness/<?=$theme?>";
		<!--
		body {font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:11px;}
		td{ padding:2px;}
		td:hover{background-color:#FFD1A4;}
		html {margin: 0;padding: 0;}

		#tabs{ font-size: 12px;margin: 10px;}
		.demoHeaders { margin-top: 2em; }
		#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
		#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
		ul#icons {margin: 0; padding: 0;}
		ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
		ul#icons span.ui-icon {float: left; margin: 0 4px;}
		b {color:#FF0000;}
		#ui-datepicker-div {font-size:13px}

		input,select {background-color:#F0F6F9;border:1px solid #A8AFB2; height:20px;margin-bottom:2px;}
		input,select,.lbl,.msg {font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#555C5F;font-weight:bolder;}
		.lbl {height:18px;margin-top:4px;width:120px;float:left;}
		.txt_info {font-family:Arial, Helvetica, sans-serif;font-size:11px;font-weight:bolder;color:#414A4F; margin:3px;visibility:hidden;}
		-->
	</style>
	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php
		echo menu_builder();
	?>
	<div id='div_conteudo' style="margin-left:5px;">
		<div id="tabs">
			<ul>
			<?php
				echo "\r".$conteudo_tab."\n";
			?>
			</ul>
			<?php
				echo "\r".$conteudo."\n";
			?>
		</div>
	</div>

</body>
</html>