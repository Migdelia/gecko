<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
$conteudo = "";

//Caso seja para fechar os lotes passados.
$gerar_re = $_GET['c'];
$id_ope = $_GET['ope'];

if($id_ope == "")
{
	$id_ope = $_SESSION['id_login'];
}



//verifica se é usuario
if (($_SESSION['usr_nivel']==8))
{
   $sWhere = " AND local.id_login = ".$id_ope." ";
}
//se nao é usuario
else
{
	//verifica se NAO foi selecionado um operador
	if($id_ope == "")
	{
		$sWhere = " AND local.id_login = ".$_SESSION['id_login']." ";
	}
	else
	{
		$sWhere = " AND local.id_login = ".$id_ope." ";
	}
}

//echo $sWhere;

if ($gerar_re!='carregar') {
		$sql_existe = "
			SELECT
				'' AS status,
				leitura.id_leitura,
				leitura.`data`,
				`local`.nome,
				leitura.id_local,
				leitura.fat_bruto AS faturamento,
				`local`.percentual,
				`local`.id_tp_local,
				(
					SELECT
						(
							sum(`lpm`.`valor_entrada`)- sum(`lpm`.`valor_saida`)
						)
					FROM
						(
							`leitura_por_maquina` `lpm`
							JOIN `maquinas` ON(
								(
									`lpm`.`id_maquina` = `maquinas`.`id_maquina`
								)
							)
						)
					WHERE
						(
							(
								`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`
							)
							AND(
								`maquinas`.`porc_maquina` <> 0
							)
						)
					GROUP BY
						`lpm`.`id_leitura`
				)AS `faturamento_especial`,
				(
					SELECT
						(
							sum(`lpm`.`valor_entrada`)- sum(`lpm`.`valor_saida`)
						)
					FROM
						(
							`leitura_por_maquina` `lpm`
							JOIN `maquinas` ON(
								(
									`lpm`.`id_maquina` = `maquinas`.`id_maquina`
								)
							)
						)
					WHERE
						(
							(
								`lpm`.`id_leitura` = `leitura_por_maquina`.`id_leitura`
							)
							AND(`maquinas`.`porc_socio` <> 0)
						)
					GROUP BY
						`lpm`.`id_leitura`
				)AS `faturamento_socio`,
				deve.valor_recebido,
				deve.valor as deve,				
				`leitura`.`total_desconto` AS `desconto`,
				`leitura`.`total_diferenca` AS `diferenca`
			FROM
				leitura
			INNER JOIN
				`local`
			ON
				leitura.id_local = `local`.id_local
			INNER JOIN
				deve
			ON
				leitura.id_leitura = deve.id_leitura
			INNER JOIN
				leitura_por_maquina
			ON
				leitura.id_leitura = leitura_por_maquina.id_leitura
			WHERE
				leitura.fechada <> 1".$sWhere."
			GROUP BY
				leitura.id_leitura			
				";

	
		$query_existe = @mysql_query($sql_existe);
		$reg_existe = @mysql_num_rows($query_existe);

		//echo $sql_existe;

	if ( $reg_existe <= 0 ) {	
		$conteudo.="<script language='javascript'>alert('ATENÇAO\\nNao foram encontrados Registros para Fechamento.\\n');window.opener.location.reload();window.close();</script>";
	}
	
		//Montando a Listagem de conferencia
		$conteudo.="\n\t\t\t<form name='confirma_fechamento' id='confirma_fechamento' action='fechamento.php?c=carregar' method='POST'> ";
		$conteudo.="\n\t\t\t\t<div style='position:fixed;bottom:0;background-color:#B2C7CE;width:100%;'>";
		
		//consulta todos os operadores
		$sql_operadores = "
			SELECT
				*
			FROM
				logins
			WHERE
				excluido = 'N'
			AND
				id_nivel = 8
			OR
				id_nivel = 10
					";

	
		$query_operadores = @mysql_query($sql_operadores);		
		
		
		//mostra como de operadores
		$conteudo.="\n\t\t\t\t &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<strong>Operador: &nbsp;</strong> ";
		$conteudo.="\n\t\t\t\t<select id='operador' name='operador'>";
		
		while ($repasse=@mysql_fetch_assoc($query_operadores))
		{
			if(($_SESSION['usr_nivel']==8))
			{
				if($repasse['id_login'] == $id_ope)
				{
					$conteudo.="\n\t\t\t\t <option value='".$repasse['id_login']."' selected>".$repasse['nome']."</option>";	
				}
			}
			else
			{
				if($repasse['id_login'] == $id_ope)
				{
					$conteudo.="\n\t\t\t\t <option value='".$repasse['id_login']."' selected>".$repasse['nome']."</option>";	
				}
				else
				{
					$conteudo.="\n\t\t\t\t <option value='".$repasse['id_login']."'>".$repasse['nome']."</option>";				
				}
			}
			
				
		}
		if (($_SESSION['usr_nivel']==1))
		{
			$conteudo.="\n\t\t\t\t <option value='1' selected>Administrador</option>";
		}

		
		
		$conteudo.="\n\t\t\t\t</select>";		

				
		
		if(($_SESSION['usr_nivel']!=9))
		{
			$conteudo.="\n\t\t\t\t<a id='add_desp' name='modal' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:10%;cursor:pointer;font-size:11px;background-color:#485F65;width:85px;height:36px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
		<br />&nbsp;
        <img src='img/plus.png' width='10' border='0' />
        <strong> &nbsp;Despesa </strong></a>";			
		
	
		}		
		
		$conteudo.="\n\t\t\t\t<a id='rend_parc' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:10%;cursor:pointer;font-size:11px;background-color:#485F65;width:120px;height:36px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
		<br />&nbsp;
		<strong> &nbsp;Rendicao Leitura </strong></a>";			
			

		$conteudo.="\n\t\t\t\t<a id='confirmar_lancamentos' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:10%;cursor:pointer;font-size:11px;background-color:#485F65;width:85px;height:36px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block; visibility:hidden;'>
		<br />&nbsp;
		<strong> &nbsp;Confirmar </strong><img src='img/ativo.png' width='10' border='0' /></a>";	

		
		$conteudo.="\n\t\t\t\t</div>";		

		$conteudo.="\n\t\t\t\t<table width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='left' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";


		//daqui pra baixo nao mecher
		$colunas = @mysql_num_fields($query_existe);
		
		$conteudo.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='40px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='10'>Fechamento de Leituras<br />Lan&ccedil;amentos: ".$reg_existe."</th>";		
		
		//Cabeçalho de cada coluna
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";
		//cabecalho da tabela
		for ($i=0;$i<$colunas;$i++) {
			if ( @mysql_field_name($query_existe,$i)!='id_leitura' and @mysql_field_name($query_existe,$i)!='id_local' and @mysql_field_name($query_existe,$i)!='percentual' and @mysql_field_name($query_existe,$i)!='id_tp_local' and @mysql_field_name($query_existe,$i)!='faturamento_especial'  and @mysql_field_name($query_existe,$i)!='faturamento_socio' ) {
				$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
				$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ",@mysql_field_name($query_existe,$i))));
				$conteudo.="\n\t\t\t\t\t\t</th>";
			}
		}	
	
		//valor a pagar leitura
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","% Local")));
		$conteudo.="\n\t\t\t\t\t\t</th>";			


		//valor a pagar leitura
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Valor a Pagar")));
		$conteudo.="\n\t\t\t\t\t\t</th>";		
		
		
		
		
		$conteudo.="\n\t\t\t\t\t</tr>";

		//Montando a Linha detalhe das baixas
		while ( $repasse=@mysql_fetch_assoc($query_existe) ) {

			//Definindo a Cor da Linha
			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		
			//Abrindo a Linha
			$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			//Montando as Colunas
			$i=1;

			foreach ($repasse as $chv=>$vlr) {
				//Totalizador de Valores
				if (strstr(strtoupper($chv),'VALOR')) {
					$totais[$chv]=$totais[$chv]+$vlr;
				}

				if ( $chv!='id_leitura' and  $chv!='id_local') {

					
					/*
					$sql_local = "
						SELECT
							percentual,
							id_tp_local
						FROM
							local
						WHERE
							local.id_local = '".$repasse['id_local']."'
					";
				
					$query_local = @mysql_query($sql_local);
					$res_local=@mysql_fetch_assoc($query_local);					
					*/
					
					
					
					//aquiiii
					if($i == 1)
					{
						//verifica se é local proprio COM SOCIO
						if($repasse['id_tp_local'] == 2)
						{
							$despesas = ($repasse['desconto'] * 50) / 100;
							$descontos_local = ($repasse['faturamento'] * 80) /100;
														
							//verifica se o local é com porcentagem especial ** Faraon
							if($repasse['id_local'] == 55 or $repasse['id_local'] == 49)
							{
								
								$comissao =  ($repasse['faturamento'] * 6) /100;	
							}
							else
							{
								$comissao =  ($repasse['faturamento'] * 5) /100;
							}

							$descontos_local = $descontos_local - $comissao;	
							$descontos_local = ($descontos_local * 50) / 100;
							
							$pct_maq_soc = ($repasse['faturamento_socio'] * 20) / 100;
							
							$descontos_local = $descontos_local + $pct_maq_soc;

							
							//declara desconto de local prorio
							$descontos_local = $descontos_local + $comissao;
							
							$fat_sem_dif = $repasse['faturamento'];
							
							//zera desconto do local para calculo de 76% de gastos
							//$descontos_local = 0;
							

						}
						else if($repasse['id_tp_local'] == 1) // rua
						{
							$despesas = $repasse['desconto'];
							
							//calcula maquinas com porcentagem especial
							$descontos_local = $repasse['faturamento'] - $repasse['faturamento_especial'];
							
							$descontos_local = ($descontos_local * $repasse['percentual']) / 100;
							
							$desconto_local_esp = ($repasse['faturamento_especial'] * 60) / 100;
							
							
							$descontos_local = $descontos_local + $desconto_local_esp;
							
							$poc_prop_dif_loc = ($repasse['diferenca'] * $repasse['percentual']) / 100;

							$descontos_local = $descontos_local - $poc_prop_dif_loc;
							
							$fat_sem_dif = $repasse['faturamento'];

						}
						else if($repasse['id_tp_local'] == 4)
						{
							$despesas = $repasse['desconto'];
							
							$descontos_local = 0;
						
							//verifica se o local é com porcentagem especial ** Faraon
							if($repasse['id_local'] == 101 or $repasse['id_local'] == 102)
							{
								$comissao =  ($repasse['faturamento'] * 6) /100;	
							}
							else
							{
								$comissao =  ($repasse['faturamento'] * 5) /100;
							}				
							
							//declara desconto de local prorio
							$descontos_local = $comissao;
							
							$fat_sem_dif = $repasse['faturamento'];

						}						
						else
						{
							$despesas = $repasse['desconto'];
							
							//calcula maquinas com porcentagem especial
							$descontos_local = $repasse['faturamento'];
							$fat_sem_dif = $descontos_local;
							$descontos_local = $descontos_local - $repasse['diferenca'];
							
						
							// consultar o valor de faturamento de jogos com porcentagem
							$sql_fat_jog_esp = "
									SELECT
										SUM(vw_leitura_maquina.valor_entrada) - SUM(vw_leitura_maquina.valor_saida) as faturamento
									FROM
										vw_leitura_maquina
									INNER JOIN
										jogo
									ON
										vw_leitura_maquina.jogo = jogo.nome
									WHERE
										vw_leitura_maquina.id_leitura = '".$repasse['id_leitura']."'
									AND
										jogo.porcentagem != 0 
							";
						
							$query_fat_jog_esp = @mysql_query($sql_fat_jog_esp);
							$res_fat_jog_esp=@mysql_fetch_assoc($query_fat_jog_esp);							
					
							$pct_jogos = $res_fat_jog_esp['faturamento'] - $repasse['diferenca']; 

							//atribui valor de jogos com porcentagem
							$pct_jogos = ($pct_jogos * 10) / 100; // mudar esse valor para valor informado pelo banco de dados		
							$pct_loc = (($descontos_local - $pct_jogos - $despesas) * 10) / 100;
							
							
							
							$vl_tot_desc = (($descontos_local * 50) /100);
							$vl_tot_desc = $vl_tot_desc + (($pct_loc * 50) /100);
							$vl_tot_desc = $vl_tot_desc + (($pct_jogos * 50) /100);
							$vl_tot_desc = $vl_tot_desc + $repasse['diferenca'];

							$despesas = ($repasse['desconto'] * 50) / 100;
							$descontos_local = $vl_tot_desc;
						}				
					}
					
					
					
					$descontos_local = round($descontos_local);

					$descontos_local = $descontos_local + $repasse['diferenca'];
					
					
					if($repasse['id_tp_local'] == 2)
					{
						$descontos_local = 0;	
					}

					//Icone de Baixa
					$baixa_ico = "\n\t\t\t\t\t\t\t<input type='checkbox' name='chk_bx_".$repasse['id_leitura']."' id='chk_bx_".$repasse['id_leitura']."' title='".$fat_sem_dif."/".$repasse['deve']."/".$despesas."/".$repasse['valor_recebido']."/".$descontos_local. "' value='".$repasse['id_leitura']."' onclick='totalizador(this);'>";
					
					//Formatando os campos
					$align='';
					switch ($chv) {
						//Tratando valores
						case 'valor':
						case 'valor_entrada_total':
						case 'valor_saida_total':
						case 'valor_faturamento_total':
							$align=" align='right'";
							$vlr=number_format($vlr,2,',','.');
						break;
						case 'status':
							$align=" align='center'";
							$vlr=$baixa_ico;
						break;
						case 'data':
						case 'data_inclusao':
						case 'data_pagamento':
							$align=" align='center'";
							$vlr=ConverteData( $vlr, "BR");
						break;
						default:
							$align=" align='left'";
						break;
					}
					
					//
					if($pct_local_esp == "")
					{
						$pct_local_esp = 0;
					}
					
					$vlr_fatu_liq = $vlr - $pct_dif;
					//$vlr_fatu_liq = $vlr - $pct_dif;
					
					//Montando a Linha
					if ($repasse['id_fin_fi']!='') {
						$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
						$conteudo.="\n\t\t\t\t\t\t\t&nbsp;".$vlr;
						$conteudo.="\n\t\t\t\t\t\t</td>";
					}else if ($i<=$colunas ) { ///aqui eh o q mostra * Erico
					
						//esconde valores desnecessarios
						if($chv <> "percentual" and $chv <> "id_tp_local" and $chv <> "faturamento_especial" and $chv <> "faturamento_socio")
						{
						
							//Colunas da baixas - exibir valores
							$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
							
							if($chv <> "status" and $chv <> "data" and $chv <> "nome")
							{
								$conteudo.="\n\t\t\t\t\t\t\t&nbsp;". number_format($vlr_fatu_liq,0,"",".");
							}
							else
							{
								$conteudo.="\n\t\t\t\t\t\t\t&nbsp;". $vlr;						
							}
							$conteudo.="\n\t\t\t\t\t\t</td>";
							$i++;

						}
					}else if ($i==$colunas) {
						//Apenas para as colunas do financeiro - exibir "boleto não localizado"
						$conteudo.="\n\t\t\t\t\t\t<td colspan='".$colunas."' style='padding:5px;".$destaque."' align='center'>";
						$conteudo.="\n\t\t\t\t\t\t\t&nbsp;O boleto n&atilde;o foi localizado !!! ";						
						$conteudo.="\n\t\t\t\t\t\t</td>";
						$i++;
					}	
				}
				
			}
	
						
						//verifica que tipo de local é
						if($repasse['id_tp_local'] == 2) // proprio com socio
						{
							$descontos_local = ($repasse['faturamento'] * 80) /100;
							
							//verifica se o local é com porcentagem especial ** Faraon
							if($repasse['id_local'] == 55 or $repasse['id_local'] == 49)
							{
								
								$comissao =  ($repasse['faturamento'] * 6) /100;	
							}
							else
							{
								$comissao =  ($repasse['faturamento'] * 5) /100;
							}
														
							$descontos_local = $descontos_local - $comissao;
							$descontos_local = ($descontos_local * 50) / 100;
							
							/*
							//busca maquinas dessa leitura de socio
							$sql_maq_soc = "
								SELECT
									sum(valor_entrada) - sum(valor_saida) as vl_maq_soc
								FROM
									vw_leitura_maquina
								INNER JOIN
									maquinas
								ON
									vw_leitura_maquina.id_maquina = maquinas.id_maquina
								WHERE
									vw_leitura_maquina.id_leitura = '".$repasse['id_leitura']."'
								AND
									maquinas.maq_socio = 'true'
							";
						
							$query_maq_soc = @mysql_query($sql_maq_soc);
							$res_maq_soc=@mysql_fetch_assoc($query_maq_soc);
							*/
							$pct_maq_soc = ($repasse['faturamento_socio'] * 20) / 100;
							
							$descontos_local = $descontos_local + $pct_maq_soc;
							
							//teste
							$descontos_local = $descontos_local + $comissao;
							
							
							//zera desconto do local para calculo de 76 % de gastos 
							//$descontos_local = 0;
							
						}
						else if($repasse['id_tp_local'] == 1)
						{	
							//calcula desconto do local com porcentagem de maquina especial
							$descontos_local = $repasse['faturamento'] - $repasse['faturamento_especial'];
							
							$descontos_local = ($descontos_local * $repasse['percentual']) / 100;
							
							$desconto_local_esp = ($repasse['faturamento_especial'] * 60) / 100;
							
							$descontos_local = $descontos_local + $desconto_local_esp;
							
							$poc_prop_dif_loc = ($repasse['diferenca'] * $repasse['percentual']) / 100;

							$descontos_local = $descontos_local - $poc_prop_dif_loc;

						}
						else if($repasse['id_tp_local'] == 4)
						{
							$despesas = ($repasse['desconto'] * 50) / 100;
							
							$descontos_local = 0;
							//verifica se o local é com porcentagem especial ** Faraon
							if($repasse['id_local'] == 101 or $repasse['id_local'] == 102)
							{
								$comissao =  ($repasse['faturamento'] * 6) /100;	
							}
							else
							{
								$comissao =  ($repasse['faturamento'] * 5) /100;
							}
							
							//declara desconto de local prorio
							$descontos_local = $comissao;
						}						
						
						

						//mostra descontos
						$total_desc_leit = '';
						if($repasse['desconto'] == "")
						{
							$total_desc_leit = 0;
						}
						else
						{
							if($repasse['id_tp_local'] == 2)
							{
								$total_desc_leit = ($repasse['desconto'] * 50) / 100;
							}
							else if($repasse['id_tp_local'] == 3)
							{
								$total_desc_leit = ($repasse['desconto'] * 50) / 100;
							}
							else
							{
								$total_desc_leit = $repasse['desconto'];
							}
						}

						//mostra descontos
						$valor_a_pagar = $repasse['faturamento'] - $repasse['deve'] - $total_desc_leit - $descontos_local;

						
						$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
						$conteudo.="\n\t\t\t\t\t\t\t&nbsp;".number_format($descontos_local,0,"",".");
						$conteudo.="\n\t\t\t\t\t\t</td>";
						
						//soma valor de deve recebido  // subtrair diferenca
						$valor_a_pagar = $valor_a_pagar + $repasse['valor_recebido'] - $repasse['diferenca'];					
						
						$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
						$conteudo.="\n\t\t\t\t\t\t\t&nbsp;".number_format($valor_a_pagar,0,"",".");
						$conteudo.="\n\t\t\t\t\t\t</td>";																			
						
						
						
			
			$conteudo.="\n\t\t\t\t\t</tr>";
		}
		//Inserindo o Botão submit no final da listagem
		$conteudo.="\n\t\t\t\t</table>";
		$conteudo.="\n\t\t\t\t<br clear='both' />";
		$conteudo.="\n\t\t\t\t<br clear='both' />";
		$conteudo.="\n\t\t\t\t<br clear='both' />";
		

		
		//verifica se NAO foi selecionado um operador
		if($id_ope == "")
		{
			$id_ope = $_SESSION['id_login'];
		}
		
		
		//consulta todas as despesas em aberto
		$sql_desp = "
				SELECT
					desconto_leit_fecha.id_desconto,
					desconto_leit_fecha.id_descricao,
					desconto_leit_fecha.valor_desconto,
					desconto_leit_fecha.descricao,
					DATE_FORMAT(desconto_leit_fecha.data_desconto,'%d/%m/%Y') AS data_desconto,
					desconto_leit_fecha.tipo_doc,
					desconto_leit_fecha.num_doc,
					tipo_desconto.descricao as centro_custo
				FROM
					desconto_leit_fecha
				INNER JOIN
					tipo_desconto
				ON
					desconto_leit_fecha.id_descricao = tipo_desconto.id_desconto
				WHERE
					desconto_leit_fecha.id_login = ".$id_ope."
				AND
					desconto_leit_fecha.fechamento = 1
				AND
					id_leitura_fechamento = 0
				ORDER BY
					desconto_leit_fecha.id_desconto";

	
		$query_desp = @mysql_query($sql_desp);
		$reg_desp = @mysql_num_rows($query_desp);				

		
		
		$conteudo.="\n\t\t\t\t<table id='tb_list_desp' name='tb_list_desp' width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='left' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";


		//daqui pra baixo nao mecher
		$colunas = @mysql_num_fields($query_existe);
		
		$conteudo.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='40px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='9'>Despesas de Fechamento<br />Lan&ccedil;amentos: ".$reg_desp."</th>";		
		
		//Cabeçalho de cada coluna
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";
		//status
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Incluir")));
		$conteudo.="\n\t\t\t\t\t\t</th>";

		//deve
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Data")));
		$conteudo.="\n\t\t\t\t\t\t</th>";
		
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Documento")));
		$conteudo.="\n\t\t\t\t\t\t</th>";	

		//desconto
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Numero")));
		$conteudo.="\n\t\t\t\t\t\t</th>";
		
		//desconto
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Centro de Custo")));
		$conteudo.="\n\t\t\t\t\t\t</th>";
		
		//desconto
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Descricao")));
		$conteudo.="\n\t\t\t\t\t\t</th>";		
		
		//desconto
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Valor Despesa")));
		$conteudo.="\n\t\t\t\t\t\t</th>";
		
		//desconto
		$conteudo.="\n\t\t\t\t\t\t<th style='color:#1D5987;'>";
		$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ","Excluir")));
		$conteudo.="\n\t\t\t\t\t\t</th>";						
		
	
		$conteudo.="\n\t\t\t\t\t</tr>";
		
				
		$align = "align='center'";
		//aqui listar despesas de fechamento nao associadas. 
		while ($repasse=@mysql_fetch_assoc($query_desp))
		{
			//Exibindo os totalizadores
			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
			//Abrindo a Linha
			$conteudo.="\n\t\t\t\t\t<tr id='".$repasse['id_desconto']."' bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";


				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
				$conteudo.="\n\t\t\t\t\t\t\t <input type='checkbox' name='chk_desp[]' id='chk_desp_".$repasse['id_desconto']."' title='".$repasse['valor_desconto']."' value='".$repasse['id_desconto']."' onclick='totalizador(this);'>";
				$conteudo.="\n\t\t\t\t\t\t<input type='hidden' id='dataAtu' name='dataAtu' value='".date("d/m/Y")."' />";
				$conteudo.="\n\t\t\t\t\t\t</td>";	
				
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
				$conteudo.="\n\t\t\t\t\t\t\t&nbsp;".$repasse['data_desconto'];
				$conteudo.="\n\t\t\t\t\t\t</td>";
				
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
				$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . $repasse['tipo_doc'];
				$conteudo.="\n\t\t\t\t\t\t</td>";
				
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
				$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . $repasse['num_doc'];
				$conteudo.="\n\t\t\t\t\t\t</td>";
				
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
				$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . $repasse['centro_custo'];
				$conteudo.="\n\t\t\t\t\t\t</td>";
				
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' ".$align.">";
				$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . $repasse['descricao'];
				$conteudo.="\n\t\t\t\t\t\t</td>";				
				
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='left'>";
				$conteudo.="\n\t\t\t\t\t\t\t&nbsp; " . number_format($repasse['valor_desconto'],0,',','.');
				$conteudo.="\n\t\t\t\t\t\t</td>";

				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
				$conteudo.="\n\t\t\t\t\t\t\t <input type='button' id='".$repasse['id_desconto']."' name='".$repasse['id_desconto']."' value=' excluir ' title='".$repasse['valor_desconto']."' onclick='goiaba(this);'  />";
				$conteudo.="\n\t\t\t\t\t\t</td>";																
			
			$conteudo.="\n\t\t\t\t\t</tr>";
			$total_parc_desp = $total_parc_desp + $repasse['valor_desconto'];
		}		


		
		
		//Inserindo o Botão submit no final da listagem
		$conteudo.="\n\t\t\t\t</table>";
		$conteudo.="\n\t\t\t\t<br clear='both' />";
		$conteudo.="\n\t\t\t\t<br clear='both' />";
		$conteudo.="\n\t\t\t\t<br clear='both' />";
		

				
		$conteudo.="\n\t\t\t</form>";



		//formata tela para totalizadores
		$conteudo.="\n\t\t\t\t<table width='100%' border='0' bordercolor='#000000' align='center' cellpadding='2' cellspacing='3' style='border-collapse: collapse'; font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";


		$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";		
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";

		
		
		//total de cargos
		//Totalizadores
		$conteudo.="\n\t\t\t\t<table width='100%' border='1' bordercolor='#000000' align='center' cellpadding='2' cellspacing='3' style='border-collapse: collapse'; font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:0px;'>";
		$conteudo.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Totalizadores Entradas: </th>";

		
		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . "Total Faturamento:";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <input id='total_fat' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t</tr>";		

		
		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . "Deve pago:";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <input id='total_dev_pago' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' > ";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t</tr>";		
		
		
		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . "Total a Somar:";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$<input id='total_somar' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t</tr>";		
		
				

		$conteudo.="\n\t\t\t\t</table>";


	
		$conteudo.="\n\t\t\t\t\t\t</td>";
		
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
		
		//Totalizadores
		$conteudo.="\n\t\t\t\t<table width='100%' border='1' bordercolor='#000000' align='center' cellpadding='2' cellspacing='3' style='border-collapse: collapse'; font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:0px;'>";
		$conteudo.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Totalizadores Saidas: </th>";

		
		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . "Total Deves:";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <input id='total_deve' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t</tr>";		

		
		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . "Total Desc + Dif:";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
		/*
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <input id='total_descontos' value='".number_format($total_parc_desp,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";
		*/
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <input id='total_descontos' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";		
		
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t</tr>";		
		
		
		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;" . "Total a subtrair:";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
		/*
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <input id='total_sub' value='".number_format($total_parc_desp,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";
		*/
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <input id='total_sub' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";

		
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t</tr>";		
		
		$conteudo.="\n\t\t\t\t</table>";

	
		$conteudo.="\n\t\t\t\t\t\t</td>";
		
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
		//total a pagar
		//Totalizadores
		$conteudo.="\n\t\t\t\t<table width='100%' border='1' bordercolor='#000000' align='center' cellpadding='2' cellspacing='3' style='border-collapse: collapse'; font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:0px;'>";
		$conteudo.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'><font size='4'>Total a pagar: </font></th>";

		
		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";		
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;SubTotal:";
		$conteudo.="\n\t\t\t\t\t\t</td>";

		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <font size='3'> <input id='total_final' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  ></font>";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t</tr>";	
			
		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";		
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;Comissao: ";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <font size='3'> <input id='total_final' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  ></font>";
		$conteudo.="\n\t\t\t\t\t\t</td>";		
		$conteudo.="\n\t\t\t\t\t</tr>";	

		//Exibindo os totalizadores
		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
		//Abrindo a Linha
		$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";		
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;Total: ";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center'>";
		$conteudo.="\n\t\t\t\t\t\t\t&nbsp;$ <font size='3'> <input id='total_final' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  ></font>";
		$conteudo.="\n\t\t\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t\t</tr>";	


		$conteudo.="\n\t\t\t\t</table>";	
		$conteudo.="\n\t\t\t\t\t\t</td>";													
		$conteudo.="\n\t\t\t\t\t</tr>";
		
		$conteudo.="\n\t\t\t\t\t<tr>";
		$conteudo.="\n\t\t\t\t\t\t<td height='70px;'>";
		$conteudo.="\n\t\t\t\t\t\t&nbsp;";															
		$conteudo.="\n\t\t\t\t\t\t</td>";															
		$conteudo.="\n\t\t\t\t\t</tr>";		
		
		
		$conteudo.="\n\t\t\t\t</table>";		


		

}else if($gerar_re=='carregar') {
	
	//
	$arrayDesp = $_POST['chk_desp'];
	$valoresDesp='';

	
	//Verificando se todos os fechamentos informados ainda estão em aberto
	$whr = "WHERE 1=1 AND fechada<>0 ";
	$whrs = "";
	$fechar = array();
	foreach( $_POST as $idx=>$ids )
	{
		if ( substr($idx,0,7)=='chk_bx_' ) // aqui atribui cada id a ser fechado
		{
			$whrs.=$ids.",";
			$fechar[$ids] = $ids;
		}
	}
	
	
	
	if ($whrs!='')
	{
		$whr.= " AND id_leitura IN (".substr($whrs,0,-1).") ";
	}
	
	$sql_closed = "SELECT id_leitura FROM leitura ".$whr;
	$query_closed=@mysql_query($sql_closed);
	$registros = @mysql_num_rows($query_closed);
	
	if( $registros>=1 )
	{
		$conteudo.="<script language='javascript'>alert('ATENÇAO\\nOcorreu um erro no fechamento. Verifique se as leituras estão corretas.');window.close();</script>";	
	}
	else
	{
		@mysql_query('BEGIN');
		$sql_fechar_1 = "INSERT INTO fechamento(`data_fechamento`,`id_login`) VALUES ('".date('Y-m-d')."','".$_SESSION['id_login']."')";
		@mysql_query($sql_fechar_1);	
		$idf = @mysql_insert_id();
		


		foreach( $fechar as $idc )
		{
			if ( $idf>=1 )
			{
				$sql_fechar_2 = "UPDATE leitura SET id_fechamento=".$idf.", fechada=1 WHERE id_leitura=".$idc;
				/*
				$sql_fechar_desp = "UPDATE desconto_leit_fecha SET id_leitura_fechamento=".$idf." WHERE id_login=".$_POST['operador']." AND id_leitura_fechamento = 0";
				*/
				if ( @mysql_query($sql_fechar_2) )
				{
					@mysql_query('COMMIT');
					@mysql_query('BEGIN');
				}else
				{
					@mysql_query('ROLLBACK');
					@mysql_query('BEGIN');
				}
				/*
				if ( @mysql_query($sql_fechar_desp) )
				{
					@mysql_query('COMMIT');
					@mysql_query('BEGIN');
				}else
				{
					@mysql_query('ROLLBACK');
					@mysql_query('BEGIN');
				}*/			
			}else
			{
				@mysql_query('ROLLBACK');
			}
		}
		
		foreach($arrayDesp as $k => $v)
		{

				$sql_fechar_desp = "UPDATE desconto_leit_fecha SET id_leitura_fechamento=".$idf." WHERE id_desconto =" . $v;
				if ( @mysql_query($sql_fechar_desp) )
				{
					@mysql_query('COMMIT');
					@mysql_query('BEGIN');
				}else
				{
					@mysql_query('ROLLBACK');
					@mysql_query('BEGIN');
				}
		}		

		
		//foreach despesas * atualiza despesas selecionadas com id do fechamento
		
				
		
		
		@mysql_close();
	}
	
	
	header('Location:verifica_tp_fechamento.php?id=' . $idf);
	/*
	
	//verifica se tem que adicionar descontos ao fechamento
	$flag_desc = $_POST['radio'];

	if($flag_desc=='sim')
	{
		header('Location:desconto_fechamento.php?id_ope=' . $_SESSION['id_login']);
	}
	else
	{
		//header('Location:pago_fechamento.php?id_ope=1');
		header('Location:verifica_tp_fechamento.php?id=' . $idf);
	}
	*/

	
}else{
	header('Location:leitura.php');
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
	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" language="javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/jquery.price_format.1.0.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script>   
	<script type="text/javascript" src="script.js"></script>    
	<script language="javascript" type="text/javascript">

		$(document).ready( function() {
			total=0;
			$('#select_all').click( function() {
				if (this.checked) {
					$('#selecionar').html('Desmaracar Todos');
					$('input:checkbox').each( function() {
						this.checked=true;
					});
				}else{
					$('#selecionar').html('Selecionar Todos');
					$('input:checkbox').each( function() {
						this.checked=false;
					});
				}
			});
			$('input:checkbox').click( function(){ 
				sumChecked();
			});
			
			
			$('#rend_parc').click( function() {
				window.open('rendicao.php', '_blank');
			});
			
			$('#add_desp').click( function() {
				$('#boxes').fadeIn("slow");
				$('#dialog').fadeIn("slow");
				
			});	
			
								
			
			$('#operador').change( function() {
				var id_ope =$('#operador').attr("value");
				location = "fechamento.php?ope="+id_ope;
			});
			
			$('#confirmar_lancamentos').click( function() {
				document.forms["confirma_fechamento"].submit();
			});
			
			$('#cancelar').click( function() {
				$('#boxes').fadeOut("slow");
				limpa_val();
			});
			
			$('#lp_val').click( function() {
				limpa_val();
			});			
				
			
			function limpa_val()
			{
				$("#centro_cust").attr("value", "1");
				$('#valor_dec').attr("value", "");
				$('#desc_desc').attr("value", "");
				$('#tp_documento').attr("value", "1");
				$('#num_doc').attr("value", "");
			}
		
					
			
			$('#ins_desp').click( function() {
				
				var cc = $('#centro_cust').attr("value");
				var vl = $('#valor_dec').attr("value");
				var dc = $('#desc_desc').attr("value");
				var td = $('#tp_documento').attr("value");
				var nd = $('#num_doc').attr("value");
				var op = $('#operador').attr("value");
				
				var vf = "";
				var qtd_carac = vl.length;

				if(qtd_carac == 4)
				{
					var y = 0;
					for (var i=0;i<qtd_carac;i++)
					{ 
						carac = vl.charAt(i);
						if(y == 1)
						{
							vf = vf + "." + carac;
						}
						else
						{
							vf = vf + carac;
						}
						y++;
					}					
				}
				else if(qtd_carac == 5)
				{
					var y = 0;
					for (var i=0;i<qtd_carac;i++)
					{ 
						carac = vl.charAt(i);
						if(y == 2)
						{
							vf = vf + "." + carac;
						}
						else
						{
							vf = vf + carac;
						}
						y++;
					}					
				}
				else if(qtd_carac == 6)
				{
					var y = 0;
					for (var i=0;i<qtd_carac;i++)
					{ 
						carac = vl.charAt(i);
						if(y == 3)
						{
							y = 0;
							vf = vf + "." + carac;
						}
						else
						{
							vf = vf + carac;
						}
						y++;
					}					
				}
				else if(qtd_carac == 7)
				{
					var y = 2;
					for (var i=0;i<qtd_carac;i++)
					{ 
						carac = vl.charAt(i);
						if(y == 3)
						{
							y = 0;
							vf = vf + "." + carac;
						}
						else
						{
							vf = vf + carac;
						}
						y++;
					}					
				}
				else if(qtd_carac == 8)
				{
					var y = 1;
					for (var i=0;i<qtd_carac;i++)
					{ 
						carac = vl.charAt(i);
						if(y == 3)
						{
							y = 0;
							vf = vf + "." + carac;
						}
						else
						{
							vf = vf + carac;
						}
						y++;
					}					
				}
				else if(qtd_carac == 9)
				{
					var y = 0;
					for (var i=0;i<qtd_carac;i++)
					{ 
						carac = vl.charAt(i);
						if(y == 3)
						{
							y = 0;
							vf = vf + "." + carac;
						}
						else
						{
							vf = vf + carac;
						}
						y++;
					}					
				}																												
				else
				{
					var vf = vl;
				}

			
				//atribui o nome do centro de custo
				if(cc == 1)
				{
					cent_cust = "ADM";	
				}
				else if(cc == 2)
				{
					cent_cust = "MKT";	
				}
				else if(cc == 3)
				{
					cent_cust = "PERSONAL";	
				}
				else if(cc == 4)
				{
					cent_cust = "MANUTENCION";	
				}
				else
				{
					cent_cust = "EXTRAS";	
				}												
				
				//verifica o tipo de documento e trata para guardar texto no BD
				if(td == 1)
				{
					td = "fatura";
				}
				else if(td == 2)
				{
					td = "boleta";
				}
				else
				{
					td = "vale";
				}

				jQuery.ajax(
				{
					type: "POST", // Defino o método de envio POST / GET
					url: 'add_despesa.php', // Informo a URL que será pesquisada.
					data: 'cent_cust='+cc+'&valor='+vl+'&descricao='+dc+'&tipo_doc='+td+'&numero_doc='+nd+'&oper='+op,
					//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
					success: function(html)
					{
						var resul=html.split("/");
						var ult_id_ins = resul[1];
						if(resul[0] == "true")
						{
							$('#boxes').fadeOut("slow");
							limpa_val();
							
							var vlDescLimp = 0;
							vlDescLimp = vf.replace( ".", "");
							vlDescLimp = vlDescLimp.replace( ".", "");
							vlDescLimp = vlDescLimp.replace( ".", "");								


							var dataAtual = $("#dataAtu").attr("value");
							

														
							$("#tb_list_desp tbody").append("<tr id='"+ult_id_ins+"' align='center' bgcolor='#EEF6F9' height='21px;'><td><input type='checkbox' name='chk_desp[]' id='chk_desp_"+ult_id_ins+"' title='"+vlDescLimp+"' value='"+ult_id_ins+"' onclick='totalizador(this);'></td><td>"+dataAtual+"</td><td>"+td+"</td><td>"+nd+"</td><td>"+cent_cust+"</td><td>"+dc+"</td><td align='left' style='padding:5px;'>&nbsp;&nbsp;"+vf+"</td><td style='padding:5px;' align='center'><input type='button' id='"+ult_id_ins+"' name='"+ult_id_ins+"' value=' excluir ' title='"+vl+"' onclick='goiaba(this);'  /></td></tr>"); //<a href='#' id='exclui_item'><img src='img/inativo.png' width='10' border='0' /></a>
							
							var desc_atual = $("#total_descontos").attr("value");
							desc_atual = desc_atual.replace( ".", "");
							desc_atual = desc_atual.replace( ".", "");
							desc_atual = desc_atual.replace( ".", "");	
							var novo_dec = eval(desc_atual) + eval(vl);
							
							novo_dec = novo_dec.formatNumber(2,',','.');
							novo_dec = novo_dec.split(",");
							novo_dec = novo_dec[0];							
							
							//$('#total_descontos').attr("value", novo_dec);
							//$('#total_sub').attr("value", novo_dec);
						}
						else
						{
							alert("Erro! Problema para inserir Despesa!");
						}
					}
				});			
			});
						
		});
		
		function goiaba(obj)
		{
			jQuery.ajax(
			{
				type: "POST", // Defino o método de envio POST / GET
				url: 'remove_despesa.php', // Informo a URL que será pesquisada.
				data: 'id_desp='+obj.id,
				//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
				success: function(html)
				{
					if(html == "true")
					{
						alert("Despesa Removida com suceso!");
						$('#' + obj.id).remove();
						
						var desc_atual = $("#total_descontos").attr("value");
						desc_atual = desc_atual.replace( ".", "");
						desc_atual = desc_atual.replace( ".", "");
						desc_atual = desc_atual.replace( ".", "");	
						var novo_dec = eval(desc_atual) - eval(obj.title);
						
						novo_dec = novo_dec.formatNumber(2,',','.');
						novo_dec = novo_dec.split(",");
						novo_dec = novo_dec[0];							
						
						$('#total_descontos').attr("value", novo_dec);
						$('#total_sub').attr("value", novo_dec);								
					}
					else
					{
						alert("Erro! Problema para inserir Despesa!");
					}
				}
			});
		}	


		function totalizador(obj) // aquiii
		{
			
			tpCheck = obj.id;
			tpCheck = tpCheck.split("_");

			
			if(tpCheck[1] == "desp")
			{
				//verificar se esta sendo marcado ou desmarcado.
				if(obj.checked == true)
				{
					//alert("verificar se o total de despesas nao ultrapassa o 74 % do faturamento");
					var preTotSub = $('#total_sub').attr("value");
					var totalFatu = $('#total_somar').attr("value");
					
					
					preTotSub = preTotSub.replace( ".", "");
					preTotSub = preTotSub.replace( ".", "");
					preTotSub = preTotSub.replace( ".", "");	
					novoTotDesc = eval(preTotSub) + eval(obj.title);
					
					totalFatu = totalFatu.replace( ".", "");
					totalFatu = totalFatu.replace( ".", "");
					totalFatu = totalFatu.replace( ".", "");				
					
					//total atualizado desconto
					//alert(novoTotDesc);
					
					//verificar se o novo total de desc vai ser maior que os 74 % do total faturado.
					limDesp = ((eval(totalFatu) * 74) / 100);
					
					//alert("total de Desp: " + novoTotDesc);
					//alert("limite de desp: " + limDesp);
					
					if(novoTotDesc > limDesp)
					{
						alert("Despesa supera o limite (de acordo com o faturamento)!");
						
						$('#' + obj.id).attr("checked", false);
						
					}
					else
					{
						
						var preTotSubi = $('#total_sub').attr("value");
						var deveParc = $('#total_deve').attr("value");
						
						novoTotSubi = eval(deveParc) + eval(novoTotDesc);
										
						var vlSubTotalSemDesc = $('#total_final').attr("value");
						
						
						vlSubTotalSemDesc = vlSubTotalSemDesc.replace( ".", "");
						vlSubTotalSemDesc = vlSubTotalSemDesc.replace( ".", "");
						vlSubTotalSemDesc = vlSubTotalSemDesc.replace( ".", "");		
						vlSubTotalSemDesc = eval(vlSubTotalSemDesc);				
						
						
						vlSubTotalSemDesc = vlSubTotalSemDesc - eval(obj.title);
						
					
						//formata valor
						novoTotDesc = novoTotDesc.formatNumber(2,',','.');
						novoTotDesc = novoTotDesc.split(",");
						novoTotDesc = novoTotDesc[0];						
	
						novoTotSubi = novoTotSubi.formatNumber(2,',','.');
						novoTotSubi = novoTotSubi.split(",");
						novoTotSubi = novoTotSubi[0];
	
						vlSubTotalSemDesc = vlSubTotalSemDesc.formatNumber(2,',','.');
						vlSubTotalSemDesc = vlSubTotalSemDesc.split(",");
						vlSubTotalSemDesc = vlSubTotalSemDesc[0];
	
	
						//pegar o valor atual das despesas
						
						$("#total_descontos").attr("value", novoTotDesc);
						$("#total_sub").attr("value", novoTotSubi);
						$("#total_final").attr("value", vlSubTotalSemDesc);
						
						
						
					}
					
					return false;
				}
				else
				{
					//pegar o valor da despesa desmarcada.
					vlDespSubi = obj.title;
					
					var novoTotDesc = $('#total_descontos').attr("value");
					var novoTotSubi = $('#total_sub').attr("value");
					
					//pegar o total de despesas e limpar o valor
					novoTotDesc = novoTotDesc.replace( ".", "");
					novoTotDesc = novoTotDesc.replace( ".", "");
					novoTotDesc = novoTotDesc.replace( ".", "");
					//alert(novoTotDesc);
					
					//pegar o total a subtrair e limpar o valor
					novoTotSubi = novoTotSubi.replace( ".", "");
					novoTotSubi = novoTotSubi.replace( ".", "");
					novoTotSubi = novoTotSubi.replace( ".", "");
					//alert(novoTotSubi);
					
					
					var vlSubTotalSemDesc = $('#total_final').attr("value");
					
					
					vlSubTotalSemDesc = vlSubTotalSemDesc.replace( ".", "");
					vlSubTotalSemDesc = vlSubTotalSemDesc.replace( ".", "");
					vlSubTotalSemDesc = vlSubTotalSemDesc.replace( ".", "");		
					vlSubTotalSemDesc = eval(vlSubTotalSemDesc);				
					
					
					vlSubTotalSemDesc = vlSubTotalSemDesc + eval(obj.title);					
					
					
					
					novoTotDesc = eval(novoTotDesc) - eval(vlDespSubi);	
					novoTotSubi = eval(novoTotSubi) - eval(vlDespSubi);	
									
				
					novoTotDesc = novoTotDesc.formatNumber(2,',','.');
					novoTotDesc = novoTotDesc.split(",");
					novoTotDesc = novoTotDesc[0];						

					novoTotSubi = novoTotSubi.formatNumber(2,',','.');
					novoTotSubi = novoTotSubi.split(",");
					novoTotSubi = novoTotSubi[0];	
					
					vlSubTotalSemDesc = vlSubTotalSemDesc.formatNumber(2,',','.');
					vlSubTotalSemDesc = vlSubTotalSemDesc.split(",");
					vlSubTotalSemDesc = vlSubTotalSemDesc[0];									
					
					//substituir valores totais
					$("#total_descontos").attr("value", novoTotDesc);
					$("#total_sub").attr("value", novoTotSubi);
					$("#total_final").attr("value", vlSubTotalSemDesc);
				
					
					return false;
				}
			}
			else
			{
				if(obj.checked == false)
				{
					//alert("Desmarcou leitura");
					var novoTotSomar = $('#total_somar').attr("value");
					var novoTotSubi = $('#total_sub').attr("value");
					
					var array_valores = obj.title.split("/");
		
					var fat = array_valores[0];
					var deve = array_valores[1];
					var desconto = array_valores[2];
					var deve_rec = array_valores[3];
					var desc_loc = array_valores[4];		
					
					//fatItem = eval(fat) - eval(deve) - eval(desconto) - eval(desc_loc) + eval(deve_rec);
					fatItem = eval(fat);
					descItem = eval(desconto) + eval(desc_loc);
					
					novoTotSubi = novoTotSubi.replace( ".", "");
					novoTotSubi = novoTotSubi.replace( ".", "");
					novoTotSubi = novoTotSubi.replace( ".", "");
					
					novoTotSomar = novoTotSomar.replace( ".", "");
					novoTotSomar = novoTotSomar.replace( ".", "");
					novoTotSomar = novoTotSomar.replace( ".", "");										
					
					
					
					novoTotSubi = eval(novoTotSubi) - eval(descItem);	
					novoTotSomar = eval(novoTotSomar) - eval(fatItem);
					
					
					
					
					verPorcLimt = ((novoTotSomar * 74) / 100);
					
					//alert(verPorcLimt);
					
					
					if(novoTotSubi > verPorcLimt)
					{
						alert("nao pode desmarcar leitura");
						$('#' + obj.id).attr("checked", true);
						return false;
					}
					
					/*
					if(novoTotSubi > verPorcLimt)
					(
						alert("tem que desmarcar despesas para poder desmarcar essa leitura");
						return false;
					)
					*/
					
				
				}
			}

			var array_valores = obj.title.split("/");

			var fat = array_valores[0];
			var deve = array_valores[1];
			var desconto = array_valores[2];
			var deve_rec = array_valores[3];
			var desc_loc = array_valores[4];
								
			
			//alert(desc_loc); // errado (trazer soh a metade)
			
			
			if(desconto == "")
			{
				desconto = 0;
			}
			if(deve == "")
			{
				deve = 0;
			}			
			if(fat == "")
			{
				fat = 0;
			}
			if(deve_rec == "")
			{
				deve_rec = 0;
			}
			if(desc_loc == "")
			{
				desc_loc = 0;
			}							

			
			//verifica se eh para somar ou subtrair
			if(obj.checked)
			{
				//calculos
				
				//deve
				var vl_atu_deve =$('#total_deve').attr("value");
				//retira os pontos para as contas
				vl_atu_deve = "'" + vl_atu_deve + "'";
				vl_atu_deve = vl_atu_deve.replace( ".", "");
				vl_atu_deve = vl_atu_deve.replace( ".", "");
				vl_atu_deve = vl_atu_deve.split(",");
				vl_atu_deve = vl_atu_deve[0].replace( "'", "");
				vl_atu_deve = vl_atu_deve.replace( "'", "");
				//retira os pontos para as contas
				deve = "'" + deve + "'";
				deve = deve.replace( ".", "");
				deve = deve.replace( ".", "");
				deve = deve.split(",");
				deve = deve[0].replace( "'", "");
				deve = deve.replace( "'", "");									
				var novo_vl_dev = eval(vl_atu_deve) + eval(deve);
				
				//despesas
				var vl_atu_desc =$('#total_descontos').attr("value");
				//retira os pontos para as contas
				vl_atu_desc = "'" + vl_atu_desc + "'";
				vl_atu_desc = vl_atu_desc.replace( ".", "");
				vl_atu_desc = vl_atu_desc.replace( ".", "");
				vl_atu_desc = vl_atu_desc.split(",");
				vl_atu_desc = vl_atu_desc[0].replace( "'", "");
				vl_atu_desc = vl_atu_desc.replace( "'", "");
				
				//retira os pontos para as contas
				
				//arredonda o desconto. (tratando erro)
				desconto = Math.round(desconto);				
				
				desconto = "'" + desconto + "'";
				desconto = desconto.replace( ".", "");
				desconto = desconto.replace( ".", "");
				desconto = desconto.split(",");
				desconto = desconto[0].replace( "'", "");
				desconto = desconto.replace( "'", "");
				//retira os pontos para as contas
				
				//arredonda o desconto do local. (tratando erro)
				desc_loc = Math.round(desc_loc);
				
				desc_loc = "'" + desc_loc + "'";
				desc_loc = desc_loc.replace( ".", "");
				desc_loc = desc_loc.replace( ".", "");
				desc_loc = desc_loc.split(",");
				desc_loc = desc_loc[0].replace( "'", "");
				desc_loc = desc_loc.replace( "'", "");
				

															
				var novo_vl_desc = eval(vl_atu_desc) + eval(desconto) + eval(desc_loc);
				var vl_tot_sub = eval(novo_vl_dev) + eval(novo_vl_desc);
				
				//faturamento
				var vl_atu_fat =$('#total_fat').attr("value");
				//retira os pontos para as contas
				fat = "'" + fat + "'";
				fat = fat.replace( ".", "");
				fat = fat.replace( ".", "");
				fat = fat.split(",");
				fat = fat[0].replace( "'", "");
				fat = fat.replace( "'", "");
				//retira os pontos para as contas
				vl_atu_fat = "'" + vl_atu_fat + "'";
				vl_atu_fat = vl_atu_fat.replace( ".", "");
				vl_atu_fat = vl_atu_fat.replace( ".", "");
				vl_atu_fat = vl_atu_fat.split(",");
				vl_atu_fat = vl_atu_fat[0].replace( "'", "");
				vl_atu_fat = vl_atu_fat.replace( "'", "");				
				var novo_vl_fat = eval(vl_atu_fat) + eval(fat);
				
				//deve recebido
				var vl_atu_deve_pago =$('#total_dev_pago').attr("value");
				//retira os pontos para as contas
				deve_rec = "'" + deve_rec + "'";
				deve_rec = deve_rec.replace( ".", "");
				deve_rec = deve_rec.replace( ".", "");
				deve_rec = deve_rec.split(",");
				deve_rec = deve_rec[0].replace( "'", "");
				deve_rec = deve_rec.replace( "'", "");
				//retira os pontos para as contas
				vl_atu_deve_pago = "'" + vl_atu_deve_pago + "'";
				vl_atu_deve_pago = vl_atu_deve_pago.replace( ".", "");
				vl_atu_deve_pago = vl_atu_deve_pago.replace( ".", "");
				vl_atu_deve_pago = vl_atu_deve_pago.split(",");
				vl_atu_deve_pago = vl_atu_deve_pago[0].replace( "'", "");
				vl_atu_deve_pago = vl_atu_deve_pago.replace( "'", "");				
				var vl_atu_deve_pago = eval(vl_atu_deve_pago) + eval(deve_rec);
				

				
				//valor final
				var vl_tot_somar = eval(novo_vl_fat) + eval(vl_atu_deve_pago);			
				
			}
			else
			{
				//calculos
				
				//deve
				var vl_atu_deve =$('#total_deve').attr("value");
				//retira os pontos para as contas
				vl_atu_deve = "'" + vl_atu_deve + "'";
				vl_atu_deve = vl_atu_deve.replace( ".", "");
				vl_atu_deve = vl_atu_deve.replace( ".", "");
				vl_atu_deve = vl_atu_deve.split(",");
				vl_atu_deve = vl_atu_deve[0].replace( "'", "");
				vl_atu_deve = vl_atu_deve.replace( "'", "");
				//retira os pontos para as contas
				deve = "'" + deve + "'";
				deve = deve.replace( ".", "");
				deve = deve.replace( ".", "");
				deve = deve.split(",");
				deve = deve[0].replace( "'", "");
				deve = deve.replace( "'", "");									
				var novo_vl_dev = eval(vl_atu_deve) - eval(deve);
				
				//despesas
				var vl_atu_desc =$('#total_descontos').attr("value");
				//retira os pontos para as contas
				vl_atu_desc = "'" + vl_atu_desc + "'";
				vl_atu_desc = vl_atu_desc.replace( ".", "");
				vl_atu_desc = vl_atu_desc.replace( ".", "");
				vl_atu_desc = vl_atu_desc.split(",");
				vl_atu_desc = vl_atu_desc[0].replace( "'", "");
				vl_atu_desc = vl_atu_desc.replace( "'", "");
				//retira os pontos para as contas
				desconto = "'" + desconto + "'";
				desconto = desconto.replace( ".", "");
				desconto = desconto.replace( ".", "");
				desconto = desconto.split(",");
				desconto = desconto[0].replace( "'", "");
				desconto = desconto.replace( "'", "");
				//retira os pontos para as contas
				desc_loc = "'" + desc_loc + "'";
				desc_loc = desc_loc.replace( ".", "");
				desc_loc = desc_loc.replace( ".", "");
				desc_loc = desc_loc.split(",");
				desc_loc = desc_loc[0].replace( "'", "");
				desc_loc = desc_loc.replace( "'", "");												

				
				var novo_vl_desc = eval(vl_atu_desc) - eval(desconto) - eval(desc_loc);
				
				
				
				var vl_tot_sub = eval(novo_vl_dev) + eval(novo_vl_desc);
				
				//faturamento
				var vl_atu_fat =$('#total_fat').attr("value");
				//retira os pontos para as contas
				fat = "'" + fat + "'";
				fat = fat.replace( ".", "");
				fat = fat.replace( ".", "");
				fat = fat.split(",");
				fat = fat[0].replace( "'", "");
				fat = fat.replace( "'", "");
				//retira os pontos para as contas
				vl_atu_fat = "'" + vl_atu_fat + "'";
				vl_atu_fat = vl_atu_fat.replace( ".", "");
				vl_atu_fat = vl_atu_fat.replace( ".", "");
				vl_atu_fat = vl_atu_fat.split(",");
				vl_atu_fat = vl_atu_fat[0].replace( "'", "");
				vl_atu_fat = vl_atu_fat.replace( "'", "");				
				var novo_vl_fat = eval(vl_atu_fat) - eval(fat);
				
				//deve recebido
				var vl_atu_deve_pago =$('#total_dev_pago').attr("value");
				//retira os pontos para as contas
				deve_rec = "'" + deve_rec + "'";
				deve_rec = deve_rec.replace( ".", "");
				deve_rec = deve_rec.replace( ".", "");
				deve_rec = deve_rec.split(",");
				deve_rec = deve_rec[0].replace( "'", "");
				deve_rec = deve_rec.replace( "'", "");
				//retira os pontos para as contas
				vl_atu_deve_pago = "'" + vl_atu_deve_pago + "'";
				vl_atu_deve_pago = vl_atu_deve_pago.replace( ".", "");
				vl_atu_deve_pago = vl_atu_deve_pago.replace( ".", "");
				vl_atu_deve_pago = vl_atu_deve_pago.split(",");
				vl_atu_deve_pago = vl_atu_deve_pago[0].replace( "'", "");
				vl_atu_deve_pago = vl_atu_deve_pago.replace( "'", "");				
				var vl_atu_deve_pago = eval(vl_atu_deve_pago) - eval(deve_rec);
				

				
				//valor final
				var vl_tot_somar = eval(novo_vl_fat) + eval(vl_atu_deve_pago);
			}
			

			//calcula valor final
			var nv_vl_final = eval(vl_tot_somar) - eval(vl_tot_sub);
	
			
			novo_vl_dev = novo_vl_dev.formatNumber(2,',','.');
			novo_vl_dev = novo_vl_dev.split(",");
			novo_vl_dev = novo_vl_dev[0];
					
			
			novo_vl_desc = novo_vl_desc.formatNumber(2,',','.');
			novo_vl_desc = novo_vl_desc.split(",");
			novo_vl_desc = novo_vl_desc[0];
			
			vl_tot_sub = vl_tot_sub.formatNumber(2,',','.');
			vl_tot_sub = vl_tot_sub.split(",");
			vl_tot_sub = vl_tot_sub[0];		

			
			novo_vl_fat = novo_vl_fat.formatNumber(2,',','.');
			novo_vl_fat = novo_vl_fat.split(",");
			novo_vl_fat = novo_vl_fat[0];
			
			vl_atu_deve_pago = vl_atu_deve_pago.formatNumber(2,',','.');
			vl_atu_deve_pago = vl_atu_deve_pago.split(",");
			vl_atu_deve_pago = vl_atu_deve_pago[0];
			
			vl_tot_somar = vl_tot_somar.formatNumber(2,',','.');
			vl_tot_somar = vl_tot_somar.split(",");
			vl_tot_somar = vl_tot_somar[0];
			
			nv_vl_final = nv_vl_final.formatNumber(2,',','.');
			nv_vl_final = nv_vl_final.split(",");
			nv_vl_final = nv_vl_final[0];																					

	
			
	
			//atribui os valores
			$("#total_deve").attr("value", novo_vl_dev);
			$("#total_descontos").attr("value", novo_vl_desc);
			$("#total_sub").attr("value", vl_tot_sub);
			$("#total_fat").attr("value", novo_vl_fat);
			$("#total_dev_pago").attr("value", vl_atu_deve_pago);
			$("#total_somar").attr("value", vl_tot_somar);
			$("#total_final").attr("value", nv_vl_final);						
								
		}


		//Função totalizadora
		function sumChecked() {
			var result = $("input:checked");
			var i=0;
			var total = 0;
			for (i=0;i<result.length;i++) {
				total = total+parseInt($(result[i]).attr('vcalc'));
			}
			if ( $('#select_all').attr('checked') ) {
				var lanc = --i;
			}else{
				var lanc = i;
			}

			var total_atual = $('#total_final').attr("value");
			
			//retira os pontos para as contas
			total_atual = "'" + total_atual + "'";
			total_atual = total_atual.replace( ".", "");
			total_atual = total_atual.replace( ".", "");
			total_atual = total_atual.split(",");
			total_atual = total_atual[0].replace( "'", "");
			total_atual = total_atual.replace( "'", "");

			/*
			if ( total_atual>=1)
			{
				$('#confirmar_lancamentos').css('visibility','visible');
			}else
			{
				$('#confirmar_lancamentos').css('visibility','hidden');
			}
			*/
			$('#confirmar_lancamentos').css('visibility','visible');
			
			$('#total_lanca').html(+" "+lanc+" Lançamentos");

			$("#total_atual").priceFormat({
				prefix: '',
				centsSeparator: ',',
				thousandsSeparator: '.'
			});
		}
			
		
		
		
	</script>
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=http://www.inscricaofacil.com.br/nojavascript.html" />
	</noscript>
	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />
	<style type="text/css" title="currentStyle">
		@import "css/media/css/demo_page.css";
		@import "css/media/css/demo_table.css";
		@import "css/media/css/demo_table_jui.css";
		@import "css/media/themes/smoothness/<?=$theme?>";
		<!--
		body {font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:11px;}
		b {color:#FF0000;}
		-->
	</style>
</head>
<body onblur="window.opener.location.reload();">
	<?php
		echo menu_builder();	
	?>
	<br clear="all" />
	<div id='div_conteudo'>
	<?
	echo $conteudo;
	?>
	</div>
    <div id="boxes"> 
        <div id="dialog" class="window" style="width:40%;height:50%;background-color:#eeeeee;margin-left:30%; margin-top:10%;">
        	<div style="height:12%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative">
				<div style="position:absolute; margin-left:5%; margin-top:2%;">
                	Adicionar Despesas no Fechamento (150)
                </div>
            </div>
            <div style="width:40%;position:absolute; margin-top:5%;" align="right">
            	<table>
                	<tr height="30px;">
                    	<td align="right"><strong>Documento:</strong></td>
                    </tr>
                	<tr height="30px;">
                    	<td align="right"><strong>Numero Documento:</strong></td>
                    </tr>
                	<tr height="30px;">
                    	<td align="right"><strong>Centro de Custo:</strong></td>
                    </tr>
                	<tr height="30px;">
                    	<td align="right"><strong>Valor:</strong></td>
                    </tr>
                	<tr height="30px;">
                    	<td align="right"><strong>Descricao:</strong></td>
                    </tr>                                                                                
                </table>
            </div>
            <div style="width:60%;position:absolute;left:40%;margin-left:10px;margin-top:5%;" align="left">
            	<table>
                	<tr height="30px;">
                    	<td>
                            <select id="tp_documento" name="tp_documento">
                                <option value="1">Fatura</option>
                                <option value="2">Boleta</option>
                                <option value="3">Vale</option>
                            </select>                        
                        </td>
                    </tr>
                	<tr height="30px;">
                    	<td>
                            <input type="text" id="num_doc" name="num_doc" size="30"  />
                        </td>
                    </tr>
                	<tr height="30px;">
                    	<td>
                            <select id="centro_cust" name="centro_cust">
                                <option value="1">ADM</option>
                                <option value="2">MKT</option>
                                <option value="3">PERSONAL</option>
                                <option value="4">MANUTENCION</option>
                                <option value="5">EXTRA</option>                   
                            </select>                      
                        </td>
                    </tr>
                	<tr height="30px;">
                    	<td>
                            <input type="text" id="valor_dec" name="valor_dec" size="30"  />
                        </td>
                    </tr>
                	<tr height="30px;">
                    	<td>
                            <input type="text" id="desc_desc" name="desc_desc" size="30"  /> 
                        </td>
                    </tr>                                                                                
                </table>
            </div>
            <div style=" width:100%;height:20%;position:absolute;bottom:0px;">
            <hr />
            <br />
            <br />
            <a name='modal' id="cancelar" name="cancelar" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:10%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
                &nbsp;&nbsp;
                <img src='img/inativo.png' width='10' border='0' />
                <strong> Cancelar </strong>
            </a>
            <a id="lp_val" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:15%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
                &nbsp;&nbsp;
                <img src='img/lixeira.png' width='10' border='0' />
                <strong> Limpar </strong>
	        </a>        
            <a name='modal' id="ins_desp" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:15%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
                &nbsp;&nbsp;
                <img src='img/ativo.png' width='10' border='0' />
                <strong> Inserir </strong>
	        </a>            </div>
        </div> 
        <div id="mask">
        </div> 
    </div>         
</body>
</html>