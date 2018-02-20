<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
unset($_SESSION['campos']);
$total_colunas=10;
$jsc='';
$id_assoc = $_GET['id'];


//Definindo em qual aba devera ficar o campo retornado na select
$abas = array(
	'Local'			=>'Leitura',
	'Maquinas'			=>'Leitura'

);


//Montando as Abas
$itens_guia = array_count_values($abas);
$guias="\n\t\t\t<ul>";
$guias_cont="";
$cont=1;
$jquery_jed="";


			
//-----------------------------AQUI------------------------------------------	
	
//pegar o id do local consultar nome do local e todas as maquinas do mesmo	

//-----------------------------AQUI------------------------------------------			
$sql_loc = "SELECT
		local.nome,
		'0' AS percentual
	FROM
		`local`
	WHERE
		local.id_local IS NOT NULL
		AND `id_local` = '".$id_assoc."'
	";
	
$query_loc=@mysql_query($sql_loc);
$result_loc=@mysql_fetch_assoc($query_loc);



foreach($itens_guia as $key=>$val) {
	//Montando as Guias das Abas
	$guias.="\n\t\t\t\t<li><a href='#tabs-".$cont."'>".$key."</a></li>";
	//Montando o Conteudo de Cada Aba
	$guias_cont.="\n\t\t\t<div id='tabs-".$cont."'>";

	//monta o form
	$guias_cont.="\n\t\t\t\t<form name='create_leitura' id='create_leitura' action='add_leitura.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
	
	//Montando a Tabela com os dados que a aba deverá possuir
	$guias_cont.="\n\t\t\t\t<table width='".($key=='Histórico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";
	$coluna=0;
	//Reponsavel por Montar o Quadro de Historico das leitura
	if ($key=='Leitura') {
	
		//Selecionando as maquinas Cadastradas do local
		$sql_maq = "
			SELECT
				vw_maquinas.id_maquina,
				vw_maquinas.codigo,
				vw_maquinas.numero,
				vw_maquinas.id_jogo,
				vw_maquinas.interface,
				vw_maquinas.porc_maquina
			FROM
				`vw_maquinas`
			WHERE
				vw_maquinas.id_maquina IS NOT NULL
				AND `id_local` = '".$id_assoc."'
			ORDER BY
				vw_maquinas.ordem_leitura
			";
			
		$query_maq=@mysql_query($sql_maq);

		
		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#E17009;'><!--- LOCAL: ---> <span style='color:#1D5987; font-size:20px;'>" . $result_loc['nome'] . "<div> <font size='2'>" . date('d-m-Y') . "</font></div></span></th></tr>\n";
		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;'>Codigo</th>
<th style='color:#E17009;'>Rel Entrada</th>
<th style='color:#E17009;'>Bruto</th>
<th style='color:#E17009;'>Rel Saida</th>
<th style='color:#E17009;'>Premio</th>
<th style='color:#E17009;'>Subtotal</th>
<th style='color:#E17009;'>% Local</th>
<th style='color:#E17009;'>% Calabaza</th>
</tr>\n";

		//declara a variavel de ids das maquinas
		$NumeroLinhas = mysql_num_rows($query_maq);
		$guias_cont.="<input type='hidden' id='qtd_maq' value='". $NumeroLinhas ."' />";
		$vl_ids_maq = ""; 
		
		
		//declara contador
		$linha = 1;
		$tot_ent_ant = 0;
		$tot_sai_ant = 0;
	
		while($result_maq=@mysql_fetch_assoc($query_maq)) {
		


			//verifica se a maquina é de socio  // aquiii
			$sql_maq_soc = "
				SELECT
					porc_socio,
					maq_socio					
				FROM
					`maquinas`
				WHERE
					`id_maquina` = '".$result_maq['id_maquina']."'
				";	
				
			$query_maq_soc=@mysql_query($sql_maq_soc);
			$dados_maq_soc=@mysql_fetch_assoc($query_maq_soc);




			if($dados_maq_soc['maq_socio'] == "true")
			{
				$pct_maq_soc = $dados_maq_soc['porc_socio'];
			}
			else
			{
				$pct_maq_soc = 0;
			}

		
		
			
			//declara valor da array com id das maquinas 
			if($linha < $NumeroLinhas)
			{
				$vl_ids_maq = $vl_ids_maq . $result_maq['id_maquina'] . ",";
			}
			else
			{
				$vl_ids_maq = $vl_ids_maq . $result_maq['id_maquina'];
			}
			$linha = $linha+1;
			
			/*	
			if ($coluna==0) {
				($cor_linha=='#F0F0F0'?$cor_linha='#E1E1E1':$cor_linha='#F0F0F0');
				$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";
			}
			*/
			
			($cor_linha=='#F0F0F0'?$cor_linha='#E1E1E1':$cor_linha='#F0F0F0');
			$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";		
			

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";
			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">".$result_maq['codigo']. " - " . $result_maq['numero'] . "<br />" . "<font size='2' color='gray'>" . $result_maq['interface'] . "</font> </strong>";
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=2;
						
			//Ultima entrada
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";
			
			
			//consulta a ultima entrada dessa maquina
			$sql_ult_ent = "
				SELECT
					vw_leitura_maquina.id_leit_maq,
					vw_leitura_maquina.valor_entrada,
					vw_leitura_maquina.valor_saida,
					vw_leitura_maquina.valor_entrada_total,
					vw_leitura_maquina.valor_saida_total					
				FROM
					`vw_leitura_maquina`
				WHERE
					vw_leitura_maquina.id_leit_maq IS NOT NULL
					AND `id_maquina` = '".$result_maq['id_maquina']."'
				ORDER BY 
					vw_leitura_maquina.id_leit_maq
				DESC
				LIMIT 1
				";	
				
			$query_ult_ent=@mysql_query($sql_ult_ent);
			$dados_ult_ent=@mysql_fetch_assoc($query_ult_ent);			



			
			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];
			//$guias_cont.="\n\t\t\t\t\t\t". "entrada ofici";	
			
			//verifica se eh a primeira leitura
			if($dados_ult_ent['valor_entrada_total'] == "")
			{
				$dados_ult_ent['valor_entrada_total'] = 0;
				$dados_ult_ent['valor_saida_total'] = 0;
			}
			
			
			$guias_cont.="\n\t\t\t\t\t\t <input label=Entrada' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='20' id='" . $result_maq['id_maquina'] . "_ent' onBlur='calcula(this.id," . $result_maq['id_maquina'] . "," . $dados_ult_ent['valor_entrada_total'] . "," . $dados_ult_ent['valor_saida_total'] ."," . $pct_maq_soc . ");' title='Informe entrada da maquina' style='text-align:center' value=''  >";			
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=3;
			
			//atribui contador de total de entrada
			$tot_ent_ant = $tot_ent_ant + $dados_ult_ent['valor_entrada'];

			//nova Entrada
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";			
			//$guias_cont.="\n\t\t\t\t\t\t <input label=Entrada' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='20' id='" . $result_maq['id_maquina'] . "_ent' onBlur='calcula(this.id);' title='Informe entrada da maquina' value='0' >";
			/*
			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_bruto' value='" . number_format($dados_ult_ent['valor_entrada_total'],0,"",".") .  "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";
			*/
			
			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_bruto' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";			
			
			$guias_cont.="\n\t\t\t\t\t</td>\n";			
			$coluna=4;
			
			//atribui contador de total de entrada
			$tot_sai_ant = $tot_sai_ant + $dados_ult_ent['valor_saida'];

			//Ultima Saida
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";
			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_saida'];
			//$guias_cont.="\n\t\t\t\t\t\t". "saida ofici";
			//verifica se é a primeira entrada
			if($dados_ult_ent['valor_entrada_total'] == "")
			{
				$dados_ult_ent['valor_entrada_total'] = 0;
				$dados_ult_ent['valor_saida_total'] = 0;
			}
			
			$guias_cont.="\n\t\t\t\t\t\t <input label=Saida' type='text' name='" . $result_maq['id_maquina'] . "_sai' size='20' id='" . $result_maq['id_maquina'] . "_sai' style='text-align:center' onBlur='calcula(this.id," . $result_maq['id_maquina'] . "," . $dados_ult_ent['valor_entrada_total'] . "," . $dados_ult_ent['valor_saida_total'] ."," . $pct_maq_soc . ");' title='Informe saida da maquina' value='' >";
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=5;
			
			//Nova Saida
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";
			/*
			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_premio' value='" . number_format($dados_ult_ent['valor_saida_total'],0,"",".") . "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";*/
			
			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_premio' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";			
			
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=6;
			
			//Total
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";
			$cont_sub_tot = $linha - 1;
			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='SubTotal' type='text' name='" . $cont_sub_tot . "_subtot' size='20' id='" . $result_maq['id_maquina'] . "_subtot' title='Leitura' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >"."</strong>";
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			
			$coluna=7;


			//Porcentagem do local
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";
			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='% local' type='text' name='" . $cont_sub_tot . "_porclc' size='20' id='" . $result_maq['id_maquina'] . "_porclc' title='%' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >"."</strong>";
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=8;
			
			//numero da maquina
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";
			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='Total Maq local' type='text' name='" . $cont_sub_tot . "_totmaq' size='20' id='" . $result_maq['id_maquina'] . "_totmaq' title='Total Maq' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >"."</strong>";
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=9;
			

			//OBS: Fazer calculo da diferenca de entrada ( - ) saida em Javascript															
			
			/*
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' colspan='".($total_colunas/2)."'>\n";
			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">".htmlentities($result_vig['selo'])."<strong>";
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=7;
			*/
			
			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];
			$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";
			//$guias_cont.="\n\t\t\t\t\t\t". "entrada ofici";
			$guias_cont.="\n\t\t\t\t\t\t". number_format($dados_ult_ent['valor_entrada_total'],0,"",".");
			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";
			//$guias_cont.="\n\t\t\t\t\t\t". "saida ofici";
			$guias_cont.="\n\t\t\t\t\t\t". number_format($dados_ult_ent['valor_saida_total'],0,"",".");						
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$guias_cont.="\t\t\t\t</tr>\n";			
			
			if ($coluna==$total_colunas) {
				$guias_cont.="\t\t\t\t</tr>\n";
				$coluna = 0;
			}
			
			
		}
		
		$guias_cont.="\n\t\t\t\t
			<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>
				<th colspan='5' style='color:#E17009;'>
					TOTAL FOLHA:
				</th>
				<th style='color:#E17009;'>
					<span style='color:#1D5987;'> <input label=TOTAL ENTRADA' type='text' name='total_subtot' size='20' id='total_subtot' title='Total Entrada' value='0' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" . "</span>
				</th>
				<th style='color:#E17009;'>
					<span style='color:#1D5987;'> <input label=TOTAL SAIDA' type='text' name='total_porcentagem' size='20' id='total_porcentagem' title='Total Saida' value='0' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" .  "</span>
				</th>
				<th style='color:#E17009;'>
					<span style='color:#1D5987;'> <input label=TOTAL' type='text' name='total_final' size='20' id='total_final' title='Total' value='0' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" . "</span>
				</th>																
			</tr>\n";

		/*			
		$guias_cont.="\n\t\t\t\t
			<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>
				<th colspan='9' style='color:#E17009;'>
					<button id='arq_leitura' type='button' class='bt-enviar' style='margin-left:220px;'>Criar Leitura</button>
				</th>
			</tr>\n";
			
		*/							
	}

	if ($coluna != 1) {
		$guias_cont.="\t\t\t\t</tr>\n";
	}
	$guias_cont.="\n\t\t\t</table>";


		//teste
		$guias_cont.="\n\t\t\t\t<table width='500px' border='0' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";
		$guias_cont.="\n\t\t\t\t\t\t<tr align='center'><th>";
		
		
		// mostra total
		//Totalizadores
		$guias_cont.="\n\t\t\t\t<table width='300px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";
		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Totalizadores<br />Lan&ccedil;amentos: </th>";


			if($cor_linha == "#EEF6F9")
			{
				$cor_linha = "#FFFFFF";
			}
			else
			{
				$cor_linha = "#EEF6F9";
				
			}
			//Abrindo a Linha
			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Total Sala";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='efetivo' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
			
			
			
			//aqui vai a linha do deve
			if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}
		

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Deve";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='deve' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()'    > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";			
			
			
			
			
			if($cor_linha == "#EEF6F9")
			{
				$cor_linha = "#FFFFFF";
			}
			else
			{
				$cor_linha = "#EEF6F9";
				
			}		

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Comissao";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='comissao' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()'  readonly='readonly' > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";

			/*
			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Despesas";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='despesas' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()'   > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
			*/
			

			
			if($cor_linha == "#EEF6F9")
			{
				$cor_linha = "#FFFFFF";
			}
			else
			{
				$cor_linha = "#EEF6F9";
				
			}			
			
			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Total Calabaza";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='totalcalabaza' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
			
			if($cor_linha == "#EEF6F9")
			{
				$cor_linha = "#FFFFFF";
			}
			else
			{
				$cor_linha = "#EEF6F9";
				
			}			
			
			/*
			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Total Socio";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='totalsocio' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";						
			*/
			
			
		$guias_cont.="\n\t\t\t\t</table>";
		// fim de mostra total	
		
		$guias_cont.="\n\t\t\t\t\t\t</th>";		
		$guias_cont.="\n\t\t\t\t\t\t<th>";
		
		//DETALHES
		$guias_cont.="\n\t\t\t\t<table width='300px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";
		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Detalhes: </th>";


			if($cor_linha == "#EEF6F9")
			{
				$cor_linha = "#FFFFFF";
			}
			else
			{
				$cor_linha = "#EEF6F9";
				
			}


			//Abrindo a Linha
			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Saldo Deve:";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			
			//consulta o ultimo registro de deve desse local
			$sql_ult_deve = "
				SELECT
					max(deve.id_deve) as id_deve
				FROM
					`deve`
				WHERE
					`id_local` = '".$id_assoc."'
				";
				
			$query_ult_deve=@mysql_query($sql_ult_deve);
			$result_ult_deve=@mysql_fetch_assoc($query_ult_deve);
			

			//consulta o saldo de deve desse local
			$sql_deve = "
				SELECT
					deve.saldo
				FROM
					`deve`
				WHERE
					`id_deve` = '".$result_ult_deve['id_deve']."'
				";
				
			$query_deve=@mysql_query($sql_deve);
			$result_deve=@mysql_fetch_assoc($query_deve);
			
			$flag_saldo = mysql_num_rows($query_deve);
			
			//
			if($flag_saldo == 0)
			{
				$tem_saldo = 0;
			}
			else
			{
				$tem_saldo = $result_deve['saldo'];
			}


			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='saldo_deve' value='". number_format($result_deve['saldo'],0,"",".") ."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
			
		
			if($cor_linha == "#EEF6F9")
			{
				$cor_linha = "#FFFFFF";
			}
			else
			{
				$cor_linha = "#EEF6F9";
				
			}
		

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Abono Deve";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='abono' name='abono' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()'   > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
			
						if($cor_linha == "#EEF6F9")
			{
				$cor_linha = "#FFFFFF";
			}
			else
			{
				$cor_linha = "#EEF6F9";
				
			}

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Saldo deve atual:";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='deve_atual' value='".number_format($result_deve['saldo'],0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			
		$guias_cont.="\n\t\t\t\t</table>";
		// fim de mostra total	


		$guias_cont.="\n\t\t\t\t\t\t<th>";
		
		
		//observacao
		$guias_cont.="\n\t\t\t\t<table width='300px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";
		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Observacao: </th>";



		if($cor_linha == "#EEF6F9")
		{
			$cor_linha = "#FFFFFF";
		}
		else
		{
			$cor_linha = "#EEF6F9";
			
		}

		//Abrindo a Linha
		$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
		$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
		$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <textarea name='obs' id='obs' cols='50' rows='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder; border:none;'></textarea> ";
		$guias_cont.="\n\t\t\t\t\t\t</td>";
		$guias_cont.="\n\t\t\t\t\t</tr>";
		$guias_cont.="\n\t\t\t\t</table>";		


		$guias_cont.="\n\t\t\t\t</table>";		

		//envia leitura
		$guias_cont.="\n\t\t\t\t <div align='center'>";
		$guias_cont.="\n\t\t\t\t\t\t<font style='font-weight:bolder; color:#E17009;'> OBS.: O desconto sera inserido DEPOIS de cadastrar a leitura</font>";
		$guias_cont.="\n\t\t\t\t<button id='arq_leitura' type='button' class='bt-enviar' style='margin-left:220px;'>Criar Leitura</button>";				
		$guias_cont.="\n\t\t\t\t </div>";

	
	//fecha form
	$guias_cont.="\n\t\t\t</form>";
	
	$guias_cont.="\n\t\t\t</div>";		
	$cont++;
}
$guias.="\n\t\t\t</ul>\n";

@mysql_free_result($query_nivel);
@mysql_free_result($query_usr);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="url" content="http://www.sogesp.com.br/">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="descrição" content="SOGESP - Associação de Obstetrícia e Ginecologia do Estado de São Paulo" />
	<meta name="robots" content="noindex,nofollow">
	<title>..::Administrativo - Usu&aacute;rios e Acessos::..</title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.dimensions.js"></script>
	<script type="text/javascript" src="js/jquery.positionBy.js"></script>
	<script type="text/javascript" src="js/jquery.jdMenu.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.3.js"></script>
	<script type="text/javascript" src="js/media/jquery.jeditable.js"></script>
	<script type="text/javascript" src="js/media/jquery.jeditable.datepicker.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript" language="javascript" src="js/ajax.js"></script>
	<script type="text/javascript" language="javascript" src="js/functions.js"></script>
	<script type="text/javascript" charset="utf-8">

	$(function(){
		// Tabs
		$('#tabs').tabs({
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
	});
	

	function calcula(id,id_num,ult_entrada,ultima_saida,pct_maq)
	{
		$(document).ready(function()
		{
			tp = id.split("_");		
			
			if(tp[1]=="ent" || tp[1]=="_ent")
			{
				var vl_ent =$('#'+id).attr("value");
				var vl_sai =$('#'+sai_id).attr("value");
				
				var sai_id = id.replace("ent","sai");
				var bruto_id = id.replace("ent","bruto");
				var premio_id = id.replace("ent","premio");				
				var sub_id = id.replace("ent","subtot");
				var porc_id = id.replace("ent","porclc");
				var totmaq_id = id.replace("ent","totmaq");
				var bruto = vl_ent - ult_entrada;
				var premio = $('#'+premio_id).attr("value");			
				
				//defini o valor do bruto
				bruto = bruto.formatNumber(2,',','.');
				bruto = bruto.split(",");
				
				bruto = bruto[0];
				var verif = bruto.indexOf("-");
				if(verif == 0)
				{
					
					var qtd_carc = bruto.length;
					if(qtd_carc == 5)
					{
						bruto = bruto.replace( ".", "");
					}
					else if(qtd_carc == 9)
					{
						bruto = bruto.replace( ".", "");				
					}
					else if(qtd_carc == 13)
					{
						bruto = bruto.replace( ".", "");				
					}
				}					
				
				
				//defini o valor do bruto
				$("#" + bruto_id).attr("value", bruto);
			}
			else
			{
				var vl_sai =$('#'+id).attr("value");
				var vl_ent =$('#'+ent_id).attr("value");

				var ent_id = id.replace("sai","ent");
				var premio_id = id.replace("sai","premio");
				var bruto_id = id.replace("sai","bruto");			
				var tot_id = id.replace("sai","total");
				var sub_id = id.replace("sai","subtot");
				var porc_id = id.replace("sai","porclc");
				var totmaq_id = id.replace("sai","totmaq");


				var let_maq = (vl_ent - vl_sai);
				var premio = vl_sai - ultima_saida;
				var bruto = $('#'+bruto_id).attr("value");
				
				
				
				//defini o valor do bruto
				premio = premio.formatNumber(2,',','.');
				premio = premio.split(",");
				
				
				premio = premio[0];
				var verif = premio.indexOf("-");
				if(verif == 0)
				{
					
					var qtd_carc = premio.length;
					if(qtd_carc == 5)
					{
						premio = premio.replace( ".", "");
					}
					else if(qtd_carc == 9)
					{
						premio = premio.replace( ".", "");				
					}
					else if(qtd_carc == 13)
					{
						premio = premio.replace( ".", "");				
					}
				}				
				
								
				//defini o valor do bruto
				$("#" + premio_id).attr("value",premio);								
			}
			
			bruto = "'" + bruto + "'";
			bruto = bruto.replace( ".", "");
			bruto = bruto.replace( ".", "");
			bruto = bruto.split(",");
			bruto = bruto[0].replace( "'", "");
			bruto = bruto.replace( "'", "");

			premio = "'" + premio + "'";
			premio = premio.replace( ".", "");
			premio = premio.replace( ".", "");
			premio = premio.split(",");
			premio = premio[0].replace( "'", "");
			premio = premio.replace( "'", "");			
			
			var subtot = bruto - premio;
			
			
			subtot = subtot.formatNumber(2,',','.');
			subtot = subtot.split(",");
			subtot = subtot[0];
			var verif = subtot.indexOf("-");
			if(verif == 0)
			{
				
				var qtd_carc = subtot.length;
				if(qtd_carc == 5)
				{
					subtot = subtot.replace( ".", "");
				}
				else if(qtd_carc == 9)
				{
					subtot = subtot.replace( ".", "");				
				}
				else if(qtd_carc == 13)
				{
					subtot = subtot.replace( ".", "");				
				}
			}
			
			//verifica se eh negativo
			var verf_neg = subtot;
			verf_neg = "'" + verf_neg + "'";
			verf_neg = verf_neg.replace( ".", "");
			verf_neg = verf_neg.replace( ".", "");
			verf_neg = verf_neg.split(",");
			verf_neg = verf_neg[0].replace( "'", "");
			verf_neg = verf_neg.replace( "'", "");
			
			if(verf_neg < 0)
			{
				document.getElementById(sub_id).style.color = "red";
				document.getElementById(porc_id).style.color = "red";
				document.getElementById(totmaq_id).style.color = "red";
			}
			else
			{
				document.getElementById(sub_id).style.color = "black";
				document.getElementById(porc_id).style.color = "black";
				document.getElementById(totmaq_id).style.color = "black";
			}		
			$("#" + sub_id).attr("value",subtot);
			
						
			//atribui a porcentagem do local
			if(pct_maq == 0)
			{

				$("#" + porc_id).attr("value",0);
				
				subtot = "'" + subtot + "'";
				subtot = subtot.replace( ".", "");
				subtot = subtot.replace( ".", "");
				subtot = subtot.split(",");
				subtot = subtot[0].replace( "'", "");
				subtot = subtot.replace( "'", "");

							
				//atribui o total dessa maquina
				//var porc = eval(subtot * 20) / 100; ALTERADO PARA LOCAL 100 % PROPRIO
				var porc = eval(subtot);
					
				porc = porc.formatNumber(2,',','.');
				porc = porc.split(",");				
				
				porc = porc[0];
				var verif = porc.indexOf("-");
				if(verif == 0)
				{
					
					var qtd_carc = porc.length;
					if(qtd_carc == 5)
					{
						porc = porc.replace( ".", "");
					}
					else if(qtd_carc == 9)
					{
						porc = porc.replace( ".", "");				
					}
					else if(qtd_carc == 13)
					{
						porc = porc.replace( ".", "");				
					}
				}		
				$("#" + totmaq_id).attr("value",porc);		
			}
			else
			{
				
			
				subtot = "'" + subtot + "'";
				subtot = subtot.replace( ".", "");
				subtot = subtot.replace( ".", "");
				subtot = subtot.split(",");
				subtot = subtot[0].replace( "'", "");
				subtot = subtot.replace( "'", "");
				
				pct_maq = "'" + pct_maq + "'";
				pct_maq = pct_maq.replace( ".", "");
				pct_maq = pct_maq.replace( ".", "");
				pct_maq = pct_maq.split(",");
				pct_maq = pct_maq[0].replace( "'", "");
				pct_maq = pct_maq.replace( "'", "");						
			
				var porc = eval(subtot * pct_maq) / 100;
				
				porc = porc.formatNumber(2,',','.');
				porc = porc.split(",");				
				
				porc = porc[0];
				var verif = porc.indexOf("-");
				if(verif == 0)
				{
					
					var qtd_carc = porc.length;
					if(qtd_carc == 5)
					{
						porc = porc.replace( ".", "");
					}
					else if(qtd_carc == 9)
					{
						porc = porc.replace( ".", "");				
					}
					else if(qtd_carc == 13)
					{
						porc = porc.replace( ".", "");				
					}
				}			
				$("#" + porc_id).attr("value",porc);			
				$("#" + totmaq_id).attr("value",0);
			}



			//verificar apartir daqui / Erico  // aquiiiiiiiiiiiiii
			//----------------------------------
			//----- calculo totalizadores-------			
			
			//calcula o total dos subtotais
			var cont = 1;
			var tot_subtot = 0;


			//aqui tem problema /// o valor subtotal nao passa daqui.
			var tot_subtot = 0;
			while (cont <= "<?=$NumeroLinhas?>")
			{
			
				var obj_nome = "input[name=" + cont +"_subtot]";
				vl_obj = $(obj_nome).attr("value");

				vl_obj = "'" + vl_obj + "'";
				vl_obj = vl_obj.replace( ".", "");
				vl_obj = vl_obj.replace( ".", "");
				vl_obj = vl_obj.split(",");
				vl_obj = vl_obj[0].replace( "'", "");
				vl_obj = vl_obj.replace( "'", "");

				var tot_subtot = eval(tot_subtot) + eval(vl_obj);

				cont = cont + 1;
			}
			//aqui tem problema /// o valor subtotal nao passa daqui.
			
			tot_subtot = tot_subtot.formatNumber(2,',','.');
			tot_subtot = tot_subtot.split(",");
			tot_subtot = tot_subtot[0];
			var verif = tot_subtot.indexOf("-");
			if(verif == 0)
			{
				
				var qtd_carc = tot_subtot.length;
				if(qtd_carc == 5)
				{
					tot_subtot = subtot.replace( ".", "");
				}
				else if(qtd_carc == 9)
				{
					tot_subtot = tot_subtot.replace( ".", "");				
				}
				else if(qtd_carc == 13)
				{
					tot_subtot = tot_subtot.replace( ".", "");				
				}
			}			
			
			
			$("#total_subtot").attr("value",tot_subtot);
			
			//calcula o total das porc
			var cont = 1;
			var tot_porc = 0;
			while (cont <= "<?=$NumeroLinhas?>")
			{
			
				var obj_nome = "input[name=" + cont +"_porclc]";
				vl_obj = $(obj_nome).attr("value");
				
				vl_obj = "'" + vl_obj + "'";
				vl_obj = vl_obj.replace( ".", "");
				vl_obj = vl_obj.replace( ".", "");
				vl_obj = vl_obj.split(",");
				vl_obj = vl_obj[0].replace( "'", "");
				vl_obj = vl_obj.replace( "'", "");
				
				var tot_porc = eval(tot_porc) + eval(vl_obj);
				cont = cont + 1;
			}
			
			
			
			tot_porc = tot_porc.formatNumber(2,',','.');
			tot_porc = tot_porc.split(",");
			tot_porc = tot_porc[0];
			var verif = tot_porc.indexOf("-");
			if(verif == 0)
			{
				
				var qtd_carc = tot_porc.length;
				if(qtd_carc == 5)
				{
					tot_porc = tot_porc.replace( ".", "");
				}
				else if(qtd_carc == 9)
				{
					tot_porc = tot_porc.replace( ".", "");				
				}
				else if(qtd_carc == 13)
				{
					tot_porc = tot_porc.replace( ".", "");				
				}
			}
			

			
			$("#total_porcentagem").attr("value",tot_porc);
			

			//calcula o total dos totais
			var cont = 1;
			var tot_geral = 0;
			while (cont <= "<?=$NumeroLinhas?>")
			{
				
				var obj_nome = "input[name=" + cont +"_totmaq]";
				vl_obj = $(obj_nome).attr("value");
				
				vl_obj = "'" + vl_obj + "'";
				vl_obj = vl_obj.replace( ".", "");
				vl_obj = vl_obj.replace( ".", "");
				vl_obj = vl_obj.split(",");
				vl_obj = vl_obj[0].replace( "'", "");
				vl_obj = vl_obj.replace( "'", "");				
				
				var tot_geral = eval(tot_geral) + eval(vl_obj);
				cont = cont + 1;
			}
			
			tot_geral = tot_geral.formatNumber(2,',','.');
			tot_geral = tot_geral.split(",");
			tot_geral = tot_geral[0];
			var verif = tot_geral.indexOf("-");
			if(verif == 0)
			{
				
				var qtd_carc = tot_geral.length;
				if(qtd_carc == 5)
				{
					tot_geral = tot_geral.replace( ".", "");
				}
				else if(qtd_carc == 9)
				{
					tot_geral = tot_geral.replace( ".", "");				
				}
				else if(qtd_carc == 13)
				{
					tot_geral = tot_geral.replace( ".", "");				
				}
			}

						
			$("#total_final").attr("value",tot_geral);	

			tot_subtot = "'" + tot_subtot + "'";
			tot_subtot = tot_subtot.replace( ".", "");
			tot_subtot = tot_subtot.replace( ".", "");
			tot_subtot = tot_subtot.split(",");
			tot_subtot = tot_subtot[0].replace( "'", "");
			tot_subtot = tot_subtot.replace( "'", "");			


			//var tot_sala = tot_subtot * 0.8; COMENTADO *LOCAL PROPRRIO COM SOCIO ANTIGO
			var tot_sala = tot_subtot * 1;
			
			
			tot_sala = tot_sala.formatNumber(2,',','.');
			tot_sala = tot_sala.split(",");
			tot_sala = tot_sala[0];
			var verif = tot_sala.indexOf("-");
			if(verif == 0)
			{
				
				var qtd_carc = tot_sala.length;
				if(qtd_carc == 5)
				{
					tot_sala = tot_sala.replace( ".", "");
				}
				else if(qtd_carc == 9)
				{
					tot_sala = tot_sala.replace( ".", "");				
				}
				else if(qtd_carc == 13)
				{
					tot_sala = tot_sala.replace( ".", "");				
				}
			}			
			$("#efetivo").attr("value",tot_sala);
			
			// atribui a comissao
			var comissao = (tot_subtot * 5) / 100;
			
			
			comissao = comissao.formatNumber(2,',','.');
			comissao = comissao.split(",");
			comissao = comissao[0];
			var verif = comissao.indexOf("-");
			if(verif == 0)
			{
				
				var qtd_carc = comissao.length;
				if(qtd_carc == 5)
				{
					comissao = comissao.replace( ".", "");
				}
				else if(qtd_carc == 9)
				{
					comissao = comissao.replace( ".", "");				
				}
				else if(qtd_carc == 13)
				{
					comissao = comissao.replace( ".", "");				
				}
			}
						
			$("#comissao").attr("value",comissao);			
			
			
			
			// atribui total da calabaza
			var deve =$('#deve').attr("value");
			if(deve == ''){deve=0;}
		
			tot_sala = "'" + tot_sala + "'";
			tot_sala = tot_sala.replace( ".", "");
			tot_sala = tot_sala.replace( ".", "");
			tot_sala = tot_sala.split(",");
			tot_sala = tot_sala[0].replace( "'", "");
			tot_sala = tot_sala.replace( "'", "");
			
			comissao = "'" + comissao + "'";
			comissao = comissao.replace( ".", "");
			comissao = comissao.replace( ".", "");
			comissao = comissao.split(",");
			comissao = comissao[0].replace( "'", "");
			comissao = comissao.replace( "'", "");
			
			deve = "'" + deve + "'";
			deve = deve.replace( ".", "");
			deve = deve.replace( ".", "");
			deve = deve.replace( ".", "");
			deve = deve.split(",");
			deve = deve[0].replace( "'", "");
			deve = deve.replace( "'", "");
			
			tot_geral = "'" + tot_geral + "'";
			tot_geral = tot_geral.replace( ".", "");
			tot_geral = tot_geral.replace( ".", "");
			tot_geral = tot_geral.replace( ".", "");
			tot_geral = tot_geral.split(",");
			tot_geral = tot_geral[0].replace( "'", "");
			tot_geral = tot_geral.replace( "'", "");						
						
			
			
			var desc = eval(tot_sala) - eval(comissao) - eval(deve);

			
			/*
			var desc = (desc * 50) / 100; 
			var tot_cala = desc + eval(tot_geral);
			*/ 
			var tot_cala = desc;			
			
			
			tot_cala = tot_cala.formatNumber(2,',','.');
			tot_cala = tot_cala.split(",");
			tot_cala = tot_cala[0];			
			
			
			
			$("#totalcalabaza").attr("value",tot_cala);				
			
			/*
			// atribui total da calabaza
			var tot_socio = (((tot_sala - comissao - deve) * 50)/100)+ eval(tot_porc);
			
			
			tot_socio = tot_socio.formatNumber(2,',','.');
			tot_socio = tot_socio.split(",");
			tot_socio = tot_socio[0];				
			
			$("#totalsocio").attr("value",tot_socio);					
			*/
			
			total_pagar();
					
		});		
	};
	

	
	function total_pagar()
	{
	
		var efetivo =$('#efetivo').attr("value");
		if(efetivo == '')
		{
			efetivo = 0;
		}
		var deve =$('#deve').attr("value");
		if(deve == '')
		{
			deve = 0;
		}
		var abono_deve =$('#abono').attr("value");
		if(abono_deve == '')
		{
			abono_deve = 0;
		}
		/*var despesas =$('#despesas').attr("value");
		if(despesas == '')
		{
			despesas = 0;
		}
		*/
						
		var tot_pagar = efetivo - deve;
		$("#totalapagar").attr("value",tot_pagar);


		//modifica valores de DETALHES
		//verifica foi inserido deve
		if(deve != 0)
		{
			var novo_saldo_deve = (eval(<?=$result_deve['saldo']?>) + eval(deve));
			
			//FORMATAR COM PONTO O NOVO SALDO DO DEVE
			novo_saldo_deve = novo_saldo_deve.formatNumber(2,',','.');
			novo_saldo_deve = novo_saldo_deve.split(",");
			novo_saldo_deve = novo_saldo_deve[0];			
			
			$("#saldo_deve").attr("value",novo_saldo_deve);
			var saldo_deve = $('#saldo_deve').attr("value");
			var abono =$('#abono').attr("value");
			var saldo_deve = saldo_deve.replace(".","");
			var saldo_deve_atual = (eval(saldo_deve) - eval(abono));
			
			saldo_deve_atual = saldo_deve_atual.formatNumber(2,',','.');
			saldo_deve_atual = saldo_deve_atual.split(",");
			saldo_deve_atual = saldo_deve_atual[0];				
			$("#deve_atual").attr("value",saldo_deve_atual);
			
			//recalcula totalizadores
			var total_subtot = $('#total_subtot').attr("value");
			var comissao = $('#comissao').attr("value");
			var tot_geral = $('#total_final').attr("value");
			var tot_porc = $('#total_porcentagem').attr("value");
			var tot_sala = total_subtot * 0.8;
			var tot_subtot = $('#total_final').attr("value");

			
			// PROBLEMA var tot_sala = tot_subtot * 0.8; // aqui tem PROBLEMA

			//recalcula aqui o total a pagar
			// atribui total da calabaza
			
			var deve =$('#deve').attr("value");
			if(deve == ''){deve=0;}
			
			var tot_sala = $('#efetivo').attr("value");
			
			tot_sala = "'" + tot_sala + "'";
			tot_sala = tot_sala.replace( ".", "");
			tot_sala = tot_sala.replace( ".", "");
			tot_sala = tot_sala.split(",");
			tot_sala = tot_sala[0].replace( "'", "");
			tot_sala = tot_sala.replace( "'", "");
			
			comissao = "'" + comissao + "'";
			comissao = comissao.replace( ".", "");
			comissao = comissao.replace( ".", "");
			comissao = comissao.split(",");
			comissao = comissao[0].replace( "'", "");
			comissao = comissao.replace( "'", "");
			
			deve = "'" + deve + "'";
			deve = deve.replace( ".", "");
			deve = deve.replace( ".", "");
			deve = deve.split(",");
			deve = deve[0].replace( "'", "");
			deve = deve.replace( "'", "");
			
			tot_geral = "'" + tot_geral + "'";
			tot_geral = tot_geral.replace( ".", "");
			tot_geral = tot_geral.replace( ".", "");
			tot_geral = tot_geral.split(",");
			tot_geral = tot_geral[0].replace( "'", "");
			tot_geral = tot_geral.replace( "'", "");						
						

			
			var desc = eval(tot_sala) - eval(comissao) - eval(deve);
			
			/*
			var desc = (desc * 50) / 100; 
			var tot_cala = desc + eval(tot_geral);		
			*/

			var tot_cala = desc;			
			
			
			tot_cala = tot_cala.formatNumber(2,',','.');
			tot_cala = tot_cala.split(",");
			tot_cala = tot_cala[0];				
			
			$("#totalcalabaza").attr("value",tot_cala);				
			
			/*
			// atribui total da calabaza
			var tot_socio = (((tot_sala - comissao - deve) * 50)/100)+ eval(tot_porc);
			
			tot_socio = tot_socio.formatNumber(2,',','.');
			tot_socio = tot_socio.split(",");
			tot_socio = tot_socio[0];				
			
			$("#totalsocio").attr("value",tot_socio);
			*/			
		}
		else
		{

			var saldo_deve = $('#saldo_deve').attr("value");
			var abn_deve = $('#abono').attr("value");
			if(abn_deve=='')
			{
				abn_deve = 0;
			}			
			var saldo_deve = saldo_deve.replace(".","")			
			var deve_atual = saldo_deve - abn_deve;

			
			$("#deve_atual").attr("value",eval(deve_atual));
			
			
			//recalcula totalizadores
			var total_subtot = $('#total_subtot').attr("value");
			var comissao = $('#comissao').attr("value");
			var tot_geral = $('#total_final').attr("value"); total_porcentagem
			var tot_porc = $('#total_porcentagem').attr("value"); 
			var tot_sala = total_subtot * 0.8;
			var tot_subtot = $('#total_final').attr("value"); 
			var tot_sala = $('#efetivo').attr("value"); ////aquiiiiiiiiiiiiiiiiiiiiii
			
				
			//recalcula aqui o total a pagar
			// atribui total da calabaza
			var deve =$('#deve').attr("value");
			if(deve == ''){deve=0;}				
			
			
			//atribui saldo deve
			saldo_deve = eval(deve) + eval(<?=$result_deve['saldo']?>);
			$("#saldo_deve").attr("value",saldo_deve);
			
			deve_atual = saldo_deve - abn_deve;
			$("#deve_atual").attr("value",deve_atual);
			
			
			tot_sala = "'" + tot_sala + "'";
			tot_sala = tot_sala.replace( ".", "");
			tot_sala = tot_sala.replace( ".", "");
			tot_sala = tot_sala.split(",");
			tot_sala = tot_sala[0].replace( "'", "");
			tot_sala = tot_sala.replace( "'", "");
			
			comissao = "'" + comissao + "'";
			comissao = comissao.replace( ".", "");
			comissao = comissao.replace( ".", "");
			comissao = comissao.split(",");
			comissao = comissao[0].replace( "'", "");
			comissao = comissao.replace( "'", "");
			
			deve = "'" + deve + "'";
			deve = deve.replace( ".", "");
			deve = deve.replace( ".", "");
			deve = deve.split(",");
			deve = deve[0].replace( "'", "");
			deve = deve.replace( "'", "");
			
			tot_geral = "'" + tot_geral + "'";
			tot_geral = tot_geral.replace( ".", "");
			tot_geral = tot_geral.replace( ".", "");
			tot_geral = tot_geral.split(",");
			tot_geral = tot_geral[0].replace( "'", "");
			tot_geral = tot_geral.replace( "'", "");
			
			
			var desc = eval(tot_sala) - eval(comissao) - eval(deve);
			/*
			var desc = (desc * 50) / 100; 
			var tot_cala = desc + eval(tot_geral);
			*/
			var tot_cala = desc;
			
			tot_cala = tot_cala.formatNumber(2,',','.');
			tot_cala = tot_cala.split(",");
			tot_cala = tot_cala[0];				
			
			$("#totalcalabaza").attr("value",tot_cala);					
			
			/*
			// atribui total da calabaza
			var tot_socio = (((tot_sala - comissao - deve) * 50)/100)+ eval(tot_porc);
			
			tot_socio = tot_socio.formatNumber(2,',','.');
			tot_socio = tot_socio.split(",");
			tot_socio = tot_socio[0];				
			
			$("#totalsocio").attr("value",tot_socio);
			*/			
		}
		

	}
	
	//calculos apartir daqui
	$(document).ready(function(){
						   
		$("#arq_leitura").click(function(event)
							{
								event.preventDefault();
								
								var id_loc = "<?=$id_assoc?>";
								var ids_maq = "<?=$vl_ids_maq?>";
								
								var cont = 0;
								var param_leitura = "";
								while (cont< "<?=$NumeroLinhas?>"){
									//declara o obj
									var quebra=ids_maq.split(",");
									var id_obj = quebra[cont];
									//pega o valor de entrada
									var obj_ent = id_obj + "_bruto";
									var vl_obj_ent = $("#" + obj_ent + "").attr("value");
									//pega o valor de saida
									var obj_sai = id_obj + "_premio";
									var vl_obj_sai = $("#" + obj_sai + "").attr("value");
									
									//remove os pontos
									vl_obj_ent = "'" + vl_obj_ent + "'";
									vl_obj_ent = vl_obj_ent.replace( ".", "");
									vl_obj_ent = vl_obj_ent.replace( ".", "");
									vl_obj_ent = vl_obj_ent.replace( ".", "");
									vl_obj_ent = vl_obj_ent.split(",");
									vl_obj_ent = vl_obj_ent[0].replace( "'", "");
									vl_obj_ent = vl_obj_ent.replace( "'", "");	
									
									vl_obj_sai = "'" + vl_obj_sai + "'";
									vl_obj_sai = vl_obj_sai.replace( ".", "");
									vl_obj_sai = vl_obj_sai.replace( ".", "");
									vl_obj_sai = vl_obj_sai.replace( ".", "");
									vl_obj_sai = vl_obj_sai.split(",");
									vl_obj_sai = vl_obj_sai[0].replace( "'", "");
									vl_obj_sai = vl_obj_sai.replace( "'", "");																		
									

									
									//concatena valores para passar									
									var param_leitura = param_leitura + vl_obj_ent;																		
									var param_leitura = param_leitura + ",";																		
									var param_leitura = param_leitura + vl_obj_sai;																																				
									var param_leitura = param_leitura + "/";									
									cont++;
								}

								var num_lin = "<?=$NumeroLinhas?>";
								//var desconto = $("#despesas").attr("value");
								var saldo_deve = $("#deve_atual").attr("value");
								var deve = $("#deve").attr("value");
								var obs = $("#obs").attr("value");
								var abn_dev = $("#abono").attr("value");
								
								
								
								
								
								$('<div id="agd_proc_leitura" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
								$("#arq_leitura").attr('disabled','disabled');
								$.post('add_leitura.php', {loc:id_loc,ids:ids_maq,vl_maq:param_leitura,qtd:num_lin,dev:deve,sld_dev:saldo_deve,obs:obs,abono:abn_dev},function(json){
									$("#arq_leitura").attr('disabled','');
									$("#agd_proc_leitura").remove();
									if(json=='Leitura cadastrada com sucesso!')
									{
										$("#lc_nome").val("");
										if(confirm("deseja cadastrar desconto para essa leitura?"))
										{
											alert(json);
											location="desconto_leitura.php?id_loc=<?= $id_assoc ?>";
										}
										else
										{
											alert(json);
											//location.reload();
											location="leitura.php";
										}
									}
									else
									{
											alert(json);
											//location.reload();
											location="leitura.php";
									}
								});
							});						   					   
	});	

	



	 $(document).ready(function() {
	<?php
		echo $jquery_jed;
	?>
		//Responsavel por imprimir a etiqueta quando clicada a opção de etiqueta.
		$("#imp_etiqueta").click( function (ev) {
			if (confirm('Atenção!\n\nDeseja realmente gerar o arquivo de Etiqueta para este Associado ?')) {
				//window.open('functions/gera_etiqueta.php?id=<?=$id_assoc?>','','width=50,height=25');
				//ev.preventDefault();
				//return false;
				return true;
			}else{
				return false;
			};
		});
	});

	</script>
	<style type="text/css">
		/*demo page css*/
		@import "css/media/themes/smoothness/<?=$theme?>";
		#tabs{ font-size: 12px;margin: 10px;}
		.demoHeaders { margin-top: 2em; }
		#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
		#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
		ul#icons {margin: 0; padding: 0;}
		ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
		ul#icons span.ui-icon {float: left; margin: 0 4px;}
		b {color:#FF0000;}
		#ui-datepicker-div {font-size:13px}
	</style>	

	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=http://www.inscricaofacil.com.br/nojavascript.html" />
	</noscript>
</head>
<body>
	<?php
		echo menu_builder();	
	?>
	<div id='div_conteudo'>
		<!-- Tabs -->
		<div id="tabs">
			<?=$guias;?>
			<?=$guias_cont;?>
		</div>
	</div>
</body>
</html>