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
$sql_loc = "
	SELECT
		local.nome,
		local.percentual
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
	$guias_cont.="\n\t\t\t\t<table width='".($key=='Histórico'?'50':'100')."%' border='0' align='center' cellpadding='2' cellspacing='4'>";
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
				vw_maquinas.numero DESC
			";
			
		$query_maq=@mysql_query($sql_maq);

		
		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#E17009;'>LOCAL: <span style='color:#1D5987;'>" . $result_loc['nome'] . "<div>" . date('d-m-Y') . "</div></span></th></tr>\n";
		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;'>Codigo</th>
<th style='color:#E17009;'>Rel Entrada</th>
<th style='color:#E17009;'>Bruto</th>
<th style='color:#E17009;'>Rel Saida</th>
<th style='color:#E17009;'>Premio</th>
<th style='color:#E17009;'>Subtotal</th>
<th style='color:#E17009;'>% Local</th>
<th style='color:#E17009;'>Total</th>
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
			
				
			if ($coluna==0) {
				($cor_linha=='#F0F0F0'?$cor_linha='#E1E1E1':$cor_linha='#F0F0F0');
				$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";
			}
			
			

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
			
			
			$guias_cont.="\n\t\t\t\t\t\t <input label=Entrada' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='20' id='" . $result_maq['id_maquina'] . "_ent' onBlur='calcula(this.id," . $result_maq['id_maquina'] . "," . $dados_ult_ent['valor_entrada_total'] . "," . $dados_ult_ent['valor_saida_total'] ."," . $result_maq['porc_maquina'] . ");' title='Informe entrada da maquina' style='text-align:center' value='0'  >";			
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=3;
			
			//atribui contador de total de entrada
			$tot_ent_ant = $tot_ent_ant + $dados_ult_ent['valor_entrada'];

			//nova Entrada
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";			
			//$guias_cont.="\n\t\t\t\t\t\t <input label=Entrada' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='20' id='" . $result_maq['id_maquina'] . "_ent' onBlur='calcula(this.id);' title='Informe entrada da maquina' value='0' >";
			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_bruto' value='" . number_format($dados_ult_ent['valor_entrada_total'],0,"",".") .  "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";
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
			
			$guias_cont.="\n\t\t\t\t\t\t <input label=Saida' type='text' name='" . $result_maq['id_maquina'] . "_sai' size='20' id='" . $result_maq['id_maquina'] . "_sai' style='text-align:center' onBlur='calcula(this.id," . $result_maq['id_maquina'] . "," . $dados_ult_ent['valor_entrada_total'] . "," . $dados_ult_ent['valor_saida_total'] ."," . $result_maq['porc_maquina'] . ");' title='Informe saida da maquina' value='0' >";
			$guias_cont.="\n\t\t\t\t\t</td>\n";
			$coluna=5;
			
			//Nova Saida
			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";
			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_premio' value='" . number_format($dados_ult_ent['valor_saida_total'],0,"",".") . "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";
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
		$guias_cont.="\n\t\t\t\t<table width='200px' border='0' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";
		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Totalizadores<br />Lan&ccedil;amentos: </th>";



			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
			//Abrindo a Linha
			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Efetivo";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='efetivo' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
			
		

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Deve";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='deve' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()'   > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Despesas";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='despesas' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()'   > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
			
			
			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "TOTAL";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='totalapagar' value='' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
		$guias_cont.="\n\t\t\t\t</table>";
		// fim de mostra total	
		
		$guias_cont.="\n\t\t\t\t\t\t</th>";		
		$guias_cont.="\n\t\t\t\t\t\t<th>";
		
		
		//observacao
		$guias_cont.="\n\t\t\t\t<table width='300px' border='0' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";
		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Observacao: </th>";



			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
			//Abrindo a Linha
			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";
			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";
			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <textarea name='obs' id='obs' cols='50' rows='10' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder; border:none;'></textarea> ";
			$guias_cont.="\n\t\t\t\t\t\t</td>";
			$guias_cont.="\n\t\t\t\t\t</tr>";
			$guias_cont.="\n\t\t\t\t</table>";		

		$guias_cont.="\n\t\t\t\t</table>";		

		//envia leitura
		$guias_cont.="\n\t\t\t\t <div align='center'>";
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
				$("#" + premio_id).attr("value",premio);								
			}
			var subtot = bruto - premio;
			$("#" + sub_id).attr("value",subtot);
						
			//atribui a porcentagem do local
			
			if(pct_maq == 0)
			{
				var porc_loc = "<?=$result_loc['percentual']?>";
			}
			else
			{
				var porc_loc = pct_maq;
			}

			
			var porc = eval(subtot * porc_loc) / 100;
			$("#" + porc_id).attr("value",porc);
			
			//atribui o total dessa maquina
			var tot_por_maq = (subtot - porc);
			$("#" + totmaq_id).attr("value",tot_por_maq);
			
			//----------------------------------
			//----- calculo totalizadores-------			
			
			//calcula o total dos subtotais
			var cont = 1;
			var tot_subtot = 0;
			while (cont <= "<?=$NumeroLinhas?>")
			{
			
				var obj_nome = "input[name=" + cont +"_subtot]";
				vl_obj = $(obj_nome).attr("value");			
				var tot_subtot = eval(tot_subtot) + eval(vl_obj);
				cont = cont + 1;
			}
			$("#total_subtot").attr("value",tot_subtot);
			
			//calcula o total das porc
			var cont = 1;
			var tot_porc = 0;
			while (cont <= "<?=$NumeroLinhas?>")
			{
			
				var obj_nome = "input[name=" + cont +"_porclc]";
				vl_obj = $(obj_nome).attr("value");
				var tot_porc = eval(tot_porc) + eval(vl_obj);
				cont = cont + 1;
			}
			$("#total_porcentagem").attr("value",tot_porc);
			

			//calcula o total dos totais
			var cont = 1;
			var tot_geral = 0;
			while (cont <= "<?=$NumeroLinhas?>")
			{
			
				var obj_nome = "input[name=" + cont +"_totmaq]";
				vl_obj = $(obj_nome).attr("value");
				var tot_geral = eval(tot_geral) + eval(vl_obj);
				cont = cont + 1;
			}
			$("#total_final").attr("value",tot_geral);	
			$("#efetivo").attr("value",tot_geral);
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
		var despesas =$('#despesas').attr("value");
		if(despesas == '')
		{
			despesas = 0;
		}
		
		var tot_pagar = efetivo - deve - despesas;
		$("#totalapagar").attr("value",tot_pagar);

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
									//concatena valores para passar									
									var param_leitura = param_leitura + vl_obj_ent;																		
									var param_leitura = param_leitura + ",";																		
									var param_leitura = param_leitura + vl_obj_sai;																																				
									var param_leitura = param_leitura + "/";									
									cont++;
								}

								var num_lin = "<?=$NumeroLinhas?>";
								var desconto = $("#despesas").attr("value");
								var deve = $("#deve").attr("value");
								var obs = $("#obs").attr("value");
								
								$('<div id="agd_proc_leitura" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
								$("#arq_leitura").attr('disabled','disabled');
								$.post('add_leitura.php', {loc:id_loc,ids:ids_maq,vl_maq:param_leitura,qtd:num_lin,desc:desconto,dev:deve,obs:obs},function(json){
									$("#arq_leitura").attr('disabled','');
									$("#agd_proc_leitura").remove();
									if(json=='Registro incluido com sucesso')
									{
										$("#lc_nome").val("");
									}
									alert(json);
									location.reload();
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