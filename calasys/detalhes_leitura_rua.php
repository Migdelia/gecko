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

$sql_num_leit = "

	SELECT

		leitura.id_local,

		DATE_FORMAT(

			MAX(leitura.`data`),

			'%d/%m/%Y'

		)AS DATA,

		leitura.semana,

		leitura.fechada,
		
		leitura.pct_local

	FROM

		`leitura`

	WHERE

		leitura.id_leitura = '".$id_assoc."'

	";

$query_num_leit=@mysql_query($sql_num_leit);

$result_num_leit=@mysql_fetch_assoc($query_num_leit);



		

$sql_loc = "

	SELECT

		local.nome,

		local.percentual

	FROM

		`local`

	WHERE

		local.id_local IS NOT NULL

		AND `id_local` = '".$result_num_leit['id_local']."'

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

	

	//Montando a Tabela com os dados que a aba dever� possuir

	$guias_cont.="\n\t\t\t\t<table width='".($key=='Hist�rico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";

	$coluna=0;

	//Reponsavel por Montar o Quadro de Historico das leitura

	if ($key=='Leitura') {

	

		//verifica o nivel do usuarios
		if($_SESSION['usr_nivel'] == 11)
		{
			//Selecionando as maquinas Cadastradas do local
	
			$sql_maq = "
	
				SELECT
	
					maquinas.id_maquina,

					concat(
	
						`tipo_maquina`.`codigo`,
	
							ifnull(`jogo`.`codigo`, '-')
	
					)AS `codigo`,
	
					maquinas.numero,
	
					leitura_por_maquina.valor_entrada,
	
					leitura_por_maquina.entrada_oficial_atual,
	
					leitura_por_maquina.valor_saida,
	
					leitura_por_maquina.saida_oficial_atual,
	
					leitura_por_maquina.num_disp as interface,
	
					leitura_por_maquina.pct_esp_maq as porc_maquina,
	
					leitura_por_maquina.ordem_leitura
	
				FROM
	
					`maquinas`
	
				
	
				INNER JOIN 
	
					leitura_por_maquina
	
				ON
	
					maquinas.id_maquina = leitura_por_maquina.id_maquina
	
				INNER JOIN
	
					tipo_maquina
	
				ON
	
					maquinas.id_tipo_maquina = tipo_maquina.id_tipo_maquina
	
				
	
				INNER JOIN
	
					interface
	
				ON
	
					maquinas.id_maquina = interface.id_maquina
	
				INNER JOIN
	
					jogo
	
				ON
	
					interface.id_jogo = jogo.id_jogo
	
				WHERE
	
					leitura_por_maquina.id_leitura = '".$id_assoc."'
				AND
					leitura_por_maquina.maq_parceiro = 1
	
				GROUP BY
	
					leitura_por_maquina.id_maquina
	
				ORDER BY
	
					leitura_por_maquina.ordem_leitura,
	
					leitura_por_maquina.id_maquina
	
				";
				
				
		}
		else
		{
			//Selecionando as maquinas Cadastradas do local
	
			$sql_maq = "
	
				SELECT
	
					maquinas.id_maquina,

					concat(
	
						`tipo_maquina`.`codigo`,
	
							ifnull(`jogo`.`codigo`, '-')
	
					)AS `codigo`,
	
					maquinas.numero,
	
					leitura_por_maquina.valor_entrada,
	
					leitura_por_maquina.entrada_oficial_atual,
	
					leitura_por_maquina.valor_saida,
	
					leitura_por_maquina.saida_oficial_atual,
	
					leitura_por_maquina.num_disp as interface,
	
					leitura_por_maquina.pct_esp_maq as porc_maquina,
	
					leitura_por_maquina.ordem_leitura
	
				FROM
	
					`maquinas`
	
				
	
				INNER JOIN 
	
					leitura_por_maquina
	
				ON
	
					maquinas.id_maquina = leitura_por_maquina.id_maquina
	
				INNER JOIN
	
					tipo_maquina
	
				ON
	
					maquinas.id_tipo_maquina = tipo_maquina.id_tipo_maquina
	
				
	
				INNER JOIN
	
					interface
	
				ON
	
					maquinas.id_maquina = interface.id_maquina
	
				INNER JOIN
	
					jogo
	
				ON
	
					interface.id_jogo = jogo.id_jogo
	
				WHERE
	
					leitura_por_maquina.id_leitura = '".$id_assoc."'
	
				GROUP BY
	
					leitura_por_maquina.id_maquina
	
				ORDER BY
	
					leitura_por_maquina.ordem_leitura,
	
					leitura_por_maquina.id_maquina
	
				";		
			
		}



		// ate aqui Ok Erico *-*-*-*-*-*-*- 21-04


		$query_maq=@mysql_query($sql_maq);




		

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#E17009;'>ID Leitura: ". $id_assoc ."<br /><span style='color:#1D5987; font-size:20px;'>" . $result_loc['nome'] . "<div> <font size='2'>" . $result_num_leit['data'] . " - Semana: " . $result_num_leit['semana'] . "</font></div></span></th></tr>\n";		

		

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

		$tot_sub_tot = 0;

		$tot_por_maq = 0;

		$tot_tot_fat = 0;

			

		

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

			

			/*	

			if ($coluna==0) {

				($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

				$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";

			}

			*/



			

			//verifica se a maquina tem diferenca

			//aquiii

			//consulta diferenca da maquina

			$sql_dif = "

				SELECT

					*

				FROM

					`desconto_leit_fecha`

				WHERE

					desconto_leit_fecha.id_maquina != 0

				AND

					desconto_leit_fecha.id_leitura_fechamento = '".$id_assoc."'

				AND

					desconto_leit_fecha.id_maquina = '".$result_maq['id_maquina']."'			

				";

				

			$query_dif=@mysql_query($sql_dif);

			$result_dif=@mysql_fetch_assoc($query_dif);			

			$qtd_dif = mysql_num_rows($query_dif);



		

			

			//verifica se houve diferenca

			if($qtd_dif > 0)

			{

				$flag_dif = 'true';

			}

			else

			{

				$flag_dif = 'false';

			}

			

			





			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

			$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";			



			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">".$result_maq['codigo']. " - " . $result_maq['numero'] . "<br />" . "<font size='2' color='gray'>" . $result_maq['interface'] . "</font> </strong>";

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=2;

			

			

			//Ultima entrada

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";

			

			/*

			//consulta a ultima entrada dessa maquina

			$sql_ult_ent = "

				SELECT

					vw_leitura_maquina.id_leit_maq,

					vw_leitura_maquina.valor_entrada,

					vw_leitura_maquina.valor_saida					

				FROM

					`vw_leitura_maquina`

				WHERE

					vw_leitura_maquina.id_leit_maq IS NOT NULL

				AND 

					`id_maquina` = '".$result_maq['id_maquina']."'

				AND

					id_leitura = '".$id_assoc."'

				";



				

			$query_ult_ent=@mysql_query($sql_ult_ent);

			$dados_ult_ent=@mysql_fetch_assoc($query_ult_ent);

			

			$sql_ult_tot = "

				SELECT

					SUM(valor_entrada) AS valor_entrada_total,

					SUM(valor_saida) AS valor_saida_total,

					valor_entrada

				FROM

					leitura_por_maquina

				WHERE

					id_maquina = '".$result_maq['id_maquina']."'

				AND

					id_leitura <= '".$id_assoc."'

				";	

				

			$query_ult_tot=@mysql_query($sql_ult_tot);

			$dados_ult_tot=@mysql_fetch_assoc($query_ult_tot);				

			*/

			

			//atribui valores do resultado

			$entrada_total = $result_maq['entrada_oficial_atual'];

			$ent_ant = $result_maq['valor_entrada'];

			$sai_total = $result_maq['saida_oficial_atual'];

			$sai_ant = $result_maq['valor_saida'];

			

			//subtrai a ultima leitura parcial da total para sacar o valor da leitura anterior

			$dif_leit_ant_ent = $entrada_total - $ent_ant;

			$dif_leit_ant_sai = $sai_total - $sai_ant;



			

			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];

			//$guias_cont.="\n\t\t\t\t\t\t". "entrada ofici";	

			

			//verifica se eh a primeira leitura

			if($result_maq['valor_entrada'] == "")

			{

				$result_maq['valor_entrada'] = 0;

				$result_maq['valor_saida'] = 0;

			}

			

			$guias_cont.="\n\t\t\t\t\t\t <input label=Entrada' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='20' id='" . $result_maq['id_maquina'] . "_ent' title='Informe entrada da maquina' value='". number_format($result_maq['entrada_oficial_atual'],0,"",".") ."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >";			

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=3;

			

			//atribui contador de total de entrada

			$tot_ent_ant = $tot_ent_ant + $result_maq['valor_entrada'];



			//nova Entrada

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";			

			//$guias_cont.="\n\t\t\t\t\t\t <input label=Entrada' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='20' id='" . $result_maq['id_maquina'] . "_ent' onBlur='calcula(this.id);' title='Informe entrada da maquina' value='0' >";

			

			//declara o valor do bruto

			$bruto = $result_maq['entrada_oficial_atual'] - $dif_leit_ant_ent;			

			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_bruto' value='" . number_format($bruto,0,"",".") .  "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";

			$guias_cont.="\n\t\t\t\t\t</td>\n";			

			$coluna=4;

			

			//soma o total de entrada

			$totBruto = $totBruto + $bruto;

			

			//atribui contador de total de entrada

			$tot_sai_ant = $tot_sai_ant + $result_maq['valor_saida'];



			//Ultima Saida

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";

			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_saida'];

			//$guias_cont.="\n\t\t\t\t\t\t". "saida ofici";

			//verifica se � a primeira entrada

			if($result_maq['valor_entrada'] == "")

			{

				$result_maq['valor_entrada'] = 0;

				$result_maq['valor_saida'] = 0;

			}

			

			$guias_cont.="\n\t\t\t\t\t\t <input label=Saida' type='text' name='" . $result_maq['id_maquina'] . "_sai' size='20' id='" . $result_maq['id_maquina'] . "_sai' title='Informe saida da maquina' value='". number_format($result_maq['saida_oficial_atual'],0,"",".") ."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >";

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=5;

			

			//Nova Saida

			$premio = $result_maq['saida_oficial_atual'] - $dif_leit_ant_sai;



			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_premio' value='" . number_format($premio,0,"",".") . "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=6;

			

			$totPremio = $totPremio + $premio;

			

			//criar obs aqui

			if($flag_dif == 'true')

			{

				//sub Total

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$cont_sub_tot = $linha - 1;

				$sub_tot = $bruto - $premio - $result_dif['valor_desconto']; 





				//verifica se eh negativo

				if($sub_tot < 0)

				{

					$color = "red";

				}

				else

				{

					$color = "black";

				}

				

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='SubTotal' type='text' name='" . $cont_sub_tot . "_subtot' size='20' id='" . $result_maq['id_maquina'] . "_subtot' title='Leitura' value='". number_format($sub_tot,0,"","."). "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;color:".$color."; border:none;' readonly='readonly' >"."</br><a id='mostra_dif".$result_maq['id_maquina']."' title='".$result_maq['id_maquina']."' style='cursor: pointer;' onclick='abreObs(this);'> obs </a></strong>";

				$tot_sub_tot = $tot_sub_tot + $sub_tot;

				

				$guias_cont.="\n\t\t\t\t\t</td>\n";

			}

			else

			{

				//sub Total

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$cont_sub_tot = $linha - 1;

				$sub_tot = $bruto - $premio;

				

				//verifica se eh negativo

				if($sub_tot < 0)

				{

					$color = "red";

				}

				else

				{

					$color = "black";

				}				

				

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='SubTotal' type='text' name='" . $cont_sub_tot . "_subtot' size='20' id='" . $result_maq['id_maquina'] . "_subtot' title='Leitura' value='". number_format($sub_tot,0,"","."). "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;color:".$color."; border:none;' readonly='readonly' >"."</strong>";

				$tot_sub_tot = $tot_sub_tot + $sub_tot;

				

				$guias_cont.="\n\t\t\t\t\t</td>\n";			

			}

			

			



			

			

			$coluna=7;





			

			//Porcentagem do local (por maquina)
			if($result_maq['porc_maquina'] == 0)
			{
				$vl_pct_maq = ($sub_tot * $result_num_leit['pct_local']) / 100;
			}
			else
			{
				$vl_pct_maq = ($sub_tot * $result_maq['porc_maquina']) / 100;
			}

			

			

			///teste

			

			

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='% local' type='text' name='" . $cont_sub_tot . "_porclc' size='20' id='" . $result_maq['id_maquina'] . "_porclc' title='%' value='". number_format($vl_pct_maq,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;color:".$color."; border:none;' readonly='readonly' >"."</strong>";

			//conta total do porc maquina

			$tot_por_maq = $tot_por_maq + $vl_pct_maq;

			

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=8;

			

			//numero da maquina

			$tot_fat_maq = $sub_tot - $vl_pct_maq;

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='Total Maq local' type='text' name='" . $cont_sub_tot . "_totmaq' size='20' id='" . $result_maq['id_maquina'] . "_totmaq' title='Total Maq' value='". number_format($tot_fat_maq,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;color:".$color."; border:none;' readonly='readonly' >"."</strong>";

			$tot_tot_fat = $tot_tot_fat + $tot_fat_maq;

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=9;

			

			$guias_cont.="\n\t\t\t\t\t</tr>\n";

								

			

			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];

			$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

			

			if($dif_leit_ant_ent < 0)

			{

				$guias_cont.="\n\t\t\t\t\t\t <strong ".$destaque.">CAMBIO </strong>";

			}

			else

			{

				$guias_cont.="\n\t\t\t\t\t\t".number_format($dif_leit_ant_ent,0,"",".");			

			}



			$guias_cont.="\n\t\t\t\t\t</td>\n";



			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

			

			

			if($dif_leit_ant_ent < 0)

			{

				$guias_cont.="\n\t\t\t\t\t\t <strong ".$destaque.">CAMBIO </strong>";

			}

			else

			{

				$guias_cont.="\n\t\t\t\t\t\t".number_format($dif_leit_ant_sai,0,"",".");			

			}			

			

									

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$guias_cont.="\t\t\t\t</tr>\n";			

			

			if ($coluna==$total_colunas) {

				$guias_cont.="\t\t\t\t</tr>\n";

				$coluna = 0;

			}

			

			

			



			if($flag_dif == 'true')

			{

			

				//fecha tabela para mostar div

				$guias_cont.="\n\t\t\t</table>\n";				

			

				//INICIO da obs de diferenca

				$guias_cont.="\n\t\t\t\t<div id='res_dif_".$result_maq['id_maquina']."' width='100%' align='center' style='display:none;'>";				

				

				

				$guias_cont.="\n\t\t\t\t<table width='".($key=='Hist�rico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";				

				

				

				//monta nova linha de dif

				//($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

				$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";				

				$guias_cont.="\t\t\t\t\t<td colspan='3' width='".(100/($total_colunas))."%' align='right' >\n";

				$guias_cont.="\n\t\t\t\t\t <span style='color:#FF0000; font-size:12px;'><strong>Descricao: &nbsp;</strong></span>\n";				

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=4;

				

	

				//Ultima Saida

				$guias_cont.="\t\t\t\t\t<td colspan='2' width='".(100/($total_colunas))."%' align='center' >\n";

				$guias_cont.="\n\t\t\t\t\t <span style='color:#FF0000; font-size:12px;'>

											<strong>"

											 . $result_dif['descricao'] . 

											 " &nbsp;</strong>

											</span>\n";	

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=6;

				

				

				//sub Total

				$guias_cont.="\t\t\t\t\t<td colspan='3' width='".(100/($total_colunas))."%' align='left' >\n";

				$guias_cont.="\n\t\t\t\t\t <span style='color:#FF0000; font-size:12px;'>

											<strong>&nbsp; Valor Diferenca $- :&nbsp;  ".number_format($result_dif['valor_desconto'],0,"",".")." &nbsp;</strong>

											</span>\n";					

				$guias_cont.="\n\t\t\t\t\t</td>\n";			

				$coluna=9;

				

				$guias_cont.="\n\t\t\t\t\t</tr>\n";

									

				

				

				if ($coluna==$total_colunas) {

					$guias_cont.="\t\t\t\t</tr>\n";

					$coluna = 0;

				}

				

				//fecha tabela para mostar div

				$guias_cont.="\n\t\t\t</table>\n";					

				

				$guias_cont.="\n\t\t\t\t</div>";				

				//fim da obs de diferenca

				

				

				$guias_cont.="\n\t\t\t\t<table width='".($key=='Hist�rico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";				

			}

		}

		

		$guias_cont.="\n\t\t\t\t

			<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>

				<th style='color:#1d5987;' width='12.5%'>

					Maquinas Exibidas: <strong>".$NumeroLinhas."</strong>

				</th>

				<th style='color:#E17009;' width='12.48%'>

					TOTAL FOLHA:

				</th>

				<th style='color:#E17009;' width='12.5%'>

					".number_format($totBruto,0,"",".")."

				</th>

				<th style='color:#E17009;' width='12.5%'>

					&nbsp;

				</th>

				<th style='color:#E17009;' width='12.5%'>

					".number_format($totPremio,0,"",".")."

				</th>												

				<th style='color:#E17009;' width='12.5%'>

					<span style='color:#1D5987;'> <input label=TOTAL ENTRADA' type='text' name='total_subtot' size='20' id='total_subtot' title='Total Entrada' value='" . number_format($tot_sub_tot,0,"",".") . "' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" . "</span>

				</th>

				<th style='color:#E17009;' width='12.5%'>

					<span style='color:#1D5987;'> <input label=TOTAL SAIDA' type='text' name='total_porcentagem' size='20' id='total_porcentagem' title='Total Saida' value='". number_format($tot_por_maq,0,"",".") ."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" .  "</span>

				</th>

				<th style='color:#E17009;' width='12.5%'>

					<span style='color:#1D5987;'> <input label=TOTAL' type='text' name='total_final' size='20' id='total_final' title='Total' value='". number_format($tot_tot_fat,0,"",".") ."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" . "</span>

				</th>																

			</tr>\n";

	}



	if ($coluna != 1) {

		$guias_cont.="\t\t\t\t</tr>\n";

	}



	$guias_cont.="\n\t\t\t</table><br clear='both' />&nbsp;\n";





			//teste

		$guias_cont.="\n\t\t\t\t<table width='500px' border='0' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";

		$guias_cont.="\n\t\t\t\t\t\t<tr align='center'><th>";

		

		// mostra total

		

		//Totalizadores

		$guias_cont.="\n\t\t\t\t<table width='300px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";

		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Totalizadores<br />Lan&ccedil;amentos: </th>";



			if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}

			//Abrindo a Linha

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Efetivo";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='efetivo' value='".number_format($tot_tot_fat,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t</tr>";

			

			if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}



			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Deve";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			

			

			//verifica se a leitura ja foi fechada.

			if($result_num_leit['fechada'] == "")

			{

				$guias_cont.="\n\t\t\t\t\t\t\t<a name='modal' id='list_todos_deves' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:1%;cursor:pointer;font-size:11px;background-color:#485F65;width:55px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;align' align='center' >Editar</a> ";				

			}			

			

			//consulta deve e observacoes

			$sql_dev = "

							SELECT

								deve.valor

							FROM

								`deve`

							WHERE

								deve.id_leitura = '".$id_assoc."'

							";

							

			$query_dev=@mysql_query($sql_dev);

			$result_dev=@mysql_fetch_assoc($query_dev);



			

			//consulta desconto

			$sql_desconto = "

							SELECT

								SUM(desconto_leit_fecha.valor_desconto) as desconto

							FROM

								`desconto_leit_fecha`

							WHERE

								desconto_leit_fecha.id_leitura_fechamento = '".$id_assoc."'

							AND

								desconto_leit_fecha.leitura = 1

							AND

								desconto_leit_fecha.id_maquina = 0

							GROUP BY

								desconto_leit_fecha.id_leitura_fechamento

							";

							

			$query_desconto=@mysql_query($sql_desconto);

			$result_desconto=@mysql_fetch_assoc($query_desconto);			

				

			

			

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='deve' value='".number_format($result_dev['valor'],0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'   > ";//.number_format($vtot,'2',',','.');

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t</tr>";



			if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}



			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Despesas";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";





			//verifica se a leitura ja foi fechada.

			if($result_num_leit['fechada'] == "")

			{

				$guias_cont.="\n\t\t\t\t\t\t\t<a name='modal' id='list_todas_desp' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:0%;cursor:pointer;font-size:11px;background-color:#485F65;width:55px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;align' align='center' >Editar</a> ";				

			}

			

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='despesas' value='". number_format($result_desconto['desconto'],0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'   > ";//.number_format($vtot,'2',',','.');

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t</tr>";

			

			if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}

			

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "TOTAL";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			

			//calcula o total a pagar

			$total_a_pagar = $tot_tot_fat - $result_dev['valor'] - $result_desconto['desconto'];

			

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='totalapagar' value='".number_format($total_a_pagar,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t</tr>";

		$guias_cont.="\n\t\t\t\t</table>";

		// fim de mostra total				







		$guias_cont.="\n\t\t\t\t\t\t</th>";		

		$guias_cont.="\n\t\t\t\t\t\t<th>";

			

			



			//observacao

			$guias_cont.="\n\t\t\t\t<table width='300px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";

			$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Observacao: </th>";







			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

			//Abrindo a Linha

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <textarea name='obs' id='obs' cols='50' rows='5' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder; border:none;' readonly='readonly' disabled='disabled'>" . $result_dev_desp['observacao'] . "</textarea> ";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t</tr>";

			$guias_cont.="\n\t\t\t\t</table>";



		$guias_cont.="\n\t\t\t\t</table>";



		//envia leitura

		$guias_cont.="\n\t\t\t\t <div align='center'>";

		$guias_cont.="\n\t\t\t\t<button id='imprimir' type='button' class='bt-enviar' style='margin-left:220px;'>Imprimir</button>";				

		$guias_cont.="\n\t\t\t\t </div>";



	

	//fecha form

	$guias_cont.="\n\t\t\t</form>";

	

	$guias_cont.="\n\t\t\t</div>";		

	$cont++;

}

$guias.="\n\t\t\t</ul>\n";





//recalcular leitura aqui

$sql_tot_fat_leit = "

	SELECT

		SUM(leitura_por_maquina.valor_entrada) - SUM(leitura_por_maquina.valor_saida) as faturamento

	FROM

		`leitura_por_maquina`

	WHERE

		leitura_por_maquina.id_leitura = '".$id_assoc."'

	";

$query_tot_fat_leit=@mysql_query($sql_tot_fat_leit);

$result_tot_fat_leit=@mysql_fetch_assoc($query_tot_fat_leit);



//consulta se a leitura tem diferencas

$sql_tot_dif_leit = "

	SELECT 

		SUM(desconto_leit_fecha.valor_desconto) as diferenca

	FROM 

		`desconto_leit_fecha` 

	WHERE 

		desconto_leit_fecha.id_leitura_fechamento = '".$id_assoc."'

	AND

		desconto_leit_fecha.id_maquina <> 0 

		";

$query_tot_dif_leit=@mysql_query($sql_tot_dif_leit);

$result_tot_dif_leit=@mysql_fetch_assoc($query_tot_dif_leit);



//$fat_atu = $result_tot_fat_leit['faturamento'] - $result_tot_dif_leit['diferenca'];

$fat_atu = $result_tot_fat_leit['faturamento'];







$sql_up = "UPDATE 

					leitura

					SET

						fat_bruto = ".$fat_atu."

					WHERE

						leitura.id_leitura = '".$id_assoc."'";

						

						

			

					if(@mysql_query($sql_up) )

					{

						//echo "ok";

					}

					else

					{

						//echo "erro";

					}





@mysql_free_result($query_nivel);

@mysql_free_result($query_usr);

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta name="url" content="http://www.sogesp.com.br/">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<meta name="descri��o" content="SOGESP - Associa��o de Obstetr�cia e Ginecologia do Estado de S�o Paulo" />

	<meta name="robots" content="noindex,nofollow">

	<title>..::Administrativo - Usu&aacute;rios e Acessos::..</title>

    

    <script type="text/javascript" src="js/jquery.min.js"></script>   

	<script type="text/javascript" src="script.js"></script>       

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

	
	function abreObs(obj)
	{
		//alert("entrou na funcao!");
		var idMaq = obj.title;
		//alert(idMaq);
		
		$(document).ready(function() {

			$('#res_dif_'+idMaq).slideToggle('slow');
		});

	}
	

	



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



		


		




		$(document).ready(function() {




			$("#imprimir").click(function(event){

				window.print();

			});			



		});

	});





	$(document).ready(function() {

	

		//rendicao

		$("#list_todas_desp").click(function()

		{

			$('#boxes').fadeIn("slow");

			$('#dialog').fadeIn("slow");

		});

		

		//deves

		$("#list_todos_deves").click(function()

		{

			$('#boxes').fadeIn("slow");

			$('#dialog_deves').fadeIn("slow");

		});		

		

		//rendicao

		$("#cancelar").click(function()

		{

			$('#boxes').fadeOut("slow");

			$('#dialog').fadeOut("slow");

		});

		

		$("#fecha_deve").click(function()

		{

			$('#boxes').fadeOut("slow");

			$('#dialog_deves').fadeOut("slow");

		});		

		

		//rendicao

		$("#add_desp").click(function()

		{

				$('#dialog').fadeOut("slow");

				$('#dialog_2').fadeIn("slow");

		});	

		

		//

		$("#atu_deve_leit").click(function()

		{

			var idDeve = $('#edit_id_dev').attr("value");

			var vlNovoDeve = $('#edit_vl_dev').attr("value");

			var vlNovoPago = $('#edit_vl_dev_pag').attr("value");



			var vlNovoDeve = vlNovoDeve.replace(".","");

			var vlNovoDeve = vlNovoDeve.replace(".","");

			var vlNovoDeve = vlNovoDeve.replace(".","");



			var vlNovoPago = vlNovoPago.replace(".","");

			var vlNovoPago = vlNovoPago.replace(".","");

			var vlNovoPago = vlNovoPago.replace(".","");



			jQuery.ajax(

			{

				type: "POST", // Defino o m�todo de envio POST / GET

				url: 'script_atu_deve.php', // Informo a URL que ser� pesquisada.

				data: 'id_deve='+idDeve+'&vl_deve='+vlNovoDeve+'&deve_pago='+vlNovoPago,

				//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",

				success: function(html)

				{

					if(html == "true")

					{

						alert("Deve atualizado com sucesso!");

						$('#dialog_edit_dev').fadeOut("slow");	

						$('#boxes').fadeOut("slow");

						

						//recalcular valores necessarios.

						var efetivo = $('#efetivo').attr("value");

						var efetivo = efetivo.replace(".","");

						var efetivo = efetivo.replace(".","");

						var efetivo = efetivo.replace(".","");						

						

						

						var vlNovoDesp = $('#despesas').attr("value");

						var vlNovoDesp = vlNovoDesp.replace(".","");

						var vlNovoDesp = vlNovoDesp.replace(".","");

						var vlNovoDesp = vlNovoDesp.replace(".","");							

						

						

						novoValPagar = eval(efetivo) - eval(vlNovoDeve) - eval(vlNovoDesp);

						

						

						//formata numeros

						vlNovoDeve = eval(vlNovoDeve);

						vlNovoDeve = vlNovoDeve.formatNumber(2,',','.');

						vlNovoDeve = vlNovoDeve.split(",");

						vlNovoDeve = vlNovoDeve[0];	



						novoValPagar = eval(novoValPagar);

						novoValPagar = novoValPagar.formatNumber(2,',','.');

						novoValPagar = novoValPagar.split(",");

						novoValPagar = novoValPagar[0];												

						

						

						$("#deve").attr("value",vlNovoDeve);

						$("#totalapagar").attr("value",novoValPagar);										

					}

					else

					{

						alert("Erro! Problema para atualizar Deve!");

					}

				}

			});	

		});			

			

		

		//

		$("#updt_deve").click(function()

		{

				$('#dialog_deves').fadeOut("slow");

				$('#dialog_edit_dev').fadeIn("slow");

		});			

				

		

		//rendicao

		$("#voltar").click(function()

		{

			$('#dialog_2').fadeOut("slow");

			$('#dialog').fadeIn("slow");

		});

		

		//deve

		$("#voltar_deve").click(function()

		{

			$('#dialog_edit_dev').fadeOut("slow");

			$('#dialog_deves').fadeIn("slow");

		});		

		

		

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

			type: "POST", // Defino o m�todo de envio POST / GET

			url: 'add_despesa_leitura_criada.php', // Informo a URL que ser� pesquisada.

			data: 'cent_cust='+cc+'&valor='+vl+'&descricao='+dc+'&tipo_doc='+td+'&numero_doc='+nd+'&oper='+op+'&id_leit='+"<?=$id_assoc?>+",

			//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",

			success: function(html)

			{

				var resul=html.split("/");

				var ult_id_ins = resul[1];

				if(resul[0] == "true")

				{

					$('#boxes').fadeOut("slow");

					$('#dialog').fadeOut("slow");

					$('#dialog_2').fadeOut("slow");

					

												

					$("#tb_list_desp tbody").append("<tr id='"+ult_id_ins+"' bgcolor='#F5F8F9' height='21px;'style='font-weight:bolder' align='center'><td style='padding:5px;' align='center' width='28%'>"+nd+"</td><td style='padding:5px;' align='center' width='28%'>"+dc+"</td><td style='padding:5px;' align='center' width='28%'>$ "+vf+"</td><td style='padding:5px;' align='center' width='16%'><a style='cursor:pointer;'><img id='"+ult_id_ins+"' src='img/inativo.png' width='11' title='"+vl+"' onclick='excluiItem(this);' /></a></td></tr>"); 

					

					//limpa valores

					limpa_val();

					var vl_atu_desp = $('#despesas').attr("value");

					

					//alert(vl_atu_desp);

					

					//limpa pontos

					var vl_atu_desp = vl_atu_desp.replace(".","");

					var vl_atu_desp = vl_atu_desp.replace(".","");

					var vl_atu_desp = vl_atu_desp.replace(".","");

					

					var vl_atu_desp = eval(vl_atu_desp) + eval(vl);

					var vl_atu_total = $('#totalapagar').attr("value");

					

					var vl_atu_total = vl_atu_total.replace(".","");

					var vl_atu_total = vl_atu_total.replace(".","");

					var vl_atu_total = vl_atu_total.replace(".","");					

					

					var vl_atu_total = eval(vl_atu_total) - eval(vl);					

					

					vl_atu_desp = vl_atu_desp.formatNumber(2,',','.');

					vl_atu_desp = vl_atu_desp.split(",");

					vl_atu_desp = vl_atu_desp[0];

					

					vl_atu_total = vl_atu_total.formatNumber(2,',','.');

					vl_atu_total = vl_atu_total.split(",");

					vl_atu_total = vl_atu_total[0];					

					

					$("#despesas").attr("value",vl_atu_desp);

					$("#totalapagar").attr("value",vl_atu_total);



				}

				else

				{

					alert("Erro! Problema para inserir Despesa!");

				}

			}

		});			

	});

		

		

		

		

		

	});







	function limpa_val()

	{

		$("#centro_cust").attr("value", "1");

		$('#valor_dec').attr("value", "");

		$('#desc_desc').attr("value", "");

		$('#tp_documento').attr("value", "1");

		$('#num_doc').attr("value", "");

	}



	//exclui despesa

	function excluiItem(obj)

	{	

		jQuery.ajax(

		{

			type: "POST", // Defino o m�todo de envio POST / GET

			url: 'remove_despesa.php', // Informo a URL que ser� pesquisada.

			data: 'id_desp='+obj.id,

			//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",

			success: function(html)

			{

				if(html == "true")

				{

					//alert("Despesa Removida com suceso!");

					$('#' + obj.id).remove();

					var vl_atu_desp = $('#despesas').attr("value");

					

					var vl_atu_desp = vl_atu_desp.replace(".","");

					var vl_atu_desp = vl_atu_desp.replace(".","");

					var vl_atu_desp = vl_atu_desp.replace(".","");

					

					var vl_atu_desp = eval(vl_atu_desp) - eval(obj.title);

					var vl_atu_total = $('#totalapagar').attr("value");

					

					var vl_atu_total = vl_atu_total.replace(".","");

					var vl_atu_total = vl_atu_total.replace(".","");

					var vl_atu_total = vl_atu_total.replace(".","");					

					

					var vl_atu_total = eval(vl_atu_total) + eval(obj.title);					

					

					

					vl_atu_desp = vl_atu_desp.formatNumber(2,',','.');

					vl_atu_desp = vl_atu_desp.split(",");

					vl_atu_desp = vl_atu_desp[0];

					

					vl_atu_total = vl_atu_total.formatNumber(2,',','.');

					vl_atu_total = vl_atu_total.split(",");

					vl_atu_total = vl_atu_total[0];					



					$("#despesas").attr("value",vl_atu_desp);

					$("#totalapagar").attr("value",vl_atu_total);

					

																

				}

				else

				{

					alert("Erro! Problema para excluir Despesa!");

				}

			}

		});

	}	







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

    <div id="boxes"> 

        <div id="dialog" class="window" style="width:40%;height:450px;background-color:#eeeeee;margin-left:30%; margin-top:10%;">

        	<div style="height:12%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative">

				<div style="position:absolute; margin-left:5%; margin-top:2%;">

                	Despesas de Leitura

                </div>

            </div>            

            <div style="overflow:auto;width:100%;height:55%;position:absolute; margin-top:5%;" align="center" style="margin-left:5%;">

            

         

		<table  id='tb_list_desp' width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:10px;'>

            <tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>

                <th style='color:#E17009;' width="28%">Num doc</th>

                <th style='color:#E17009;' width="28%">Descricao </th>

                <th style='color:#E17009;' width="28%">Valor </th>

                <th style='color:#E17009;' width="16%"><img src="img/lixeira.png" /> </th>

            </tr>

            

            <?php

				//aqui consultar despesas de leitura desse usuario que nao tenham id de leitura

				$sql_desp_leit = "

					SELECT

						*

					FROM

						`desconto_leit_fecha`

					WHERE

						desconto_leit_fecha.id_leitura_fechamento = ".$id_assoc."

					AND

						desconto_leit_fecha.leitura = 1

					";

					

				$query_desp_leit=@mysql_query($sql_desp_leit);

				//$result_desp_leit=@mysql_fetch_assoc($query_desp_leit);			

			

				while($result_desp_leit=@mysql_fetch_assoc($query_desp_leit)) 

				{

					echo "<tr id='".$result_desp_leit['id_desconto']."' bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>         

							<td style='padding:5px;' align='center' width='28%'>

								".$result_desp_leit['num_doc']."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								".$result_desp_leit['descricao']."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								$ ".number_format($result_desp_leit['valor_desconto'],0,"",".")."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								<a style='cursor:pointer;'>

								<img id='".$result_desp_leit['id_desconto']."' src='img/inativo.png' width='11' title='".$result_desp_leit['valor_desconto']."' onclick='excluiItem(this);' />

								</a>

							</td>							                                

						</tr>"; 

				}			

  

			?>

                                                                                                

		</table>            



            



            </div>

            <div  style=" width:100%;height:20%;position:absolute;bottom:0px;">

                <hr />

                <br />

                <a name='modal' id='cancelar' name='cancelar' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:10%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                    &nbsp;&nbsp;

                    <img src='img/inativo.png' width='10' border='0' />

                    <strong> Fechar </strong>

                </a>        

                <a name='modal' id="add_desp" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:40%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                    &nbsp;&nbsp;

                    <img src='img/ativo.png' width='10' border='0' />

                    <strong> Adicionar </strong>

                </a>            

            </div>

        </div>

        

        

        <div id="dialog_deves" class="window" style="width:40%;height:300px;background-color:#eeeeee;margin-left:30%; margin-top:10%;">

        	<div style="height:12%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative">

				<div style="position:absolute; margin-left:5%; margin-top:2%;">

                	Deves

                </div>

            </div>            

            <div style="overflow:auto;width:90%;height:55%;position:absolute; margin-top:5%;" align="center" style="margin-left:5%;">

            

         

		<table  id='tb_list_desp' width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:10px;'>

            <tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>

                <th style='color:#E17009;' width="28%">ID</th>

                <th style='color:#E17009;' width="28%">Valor</th>

                <th style='color:#E17009;' width="28%">Valor Recebido</th>

                <th style='color:#E17009;' width="16%">Saldo </th>

            </tr>

            

            <?php

				//aqui consultar despesas de leitura desse usuario que nao tenham id de leitura

				$sql_deve_leit = "

					SELECT

						*

					FROM

						`deve`

					WHERE

						deve.id_leitura = ".$id_assoc."

					";

					

				$query_deve_leit=@mysql_query($sql_deve_leit);

				//$result_desp_leit=@mysql_fetch_assoc($query_desp_leit);				

			

				while($result_deve_leit=@mysql_fetch_assoc($query_deve_leit)) 

				{

					echo "<tr id='".$result_deve_leit['id_deve']."' bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>         

							<td style='padding:5px;' align='center' width='28%'>

								".$result_deve_leit['id_deve']."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								$ ".number_format($result_deve_leit['valor'],0,"",".")."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								$ ".number_format($result_deve_leit['valor_recebido'],0,"",".")."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								$ ".number_format($result_deve_leit['saldo'],0,"",".")."

							</td>							                                

						</tr>"; 

						

					$idDeve = $result_deve_leit['id_deve'];

					$vlDeveAtu = $result_deve_leit['valor'];

					$vlDevePago = $result_deve_leit['valor_recebido'];

					$saldoDeve = $result_deve_leit['saldo'];

				}			

  

			?>

                                                                                                

		</table>            



            



            </div>

            <div  style=" width:100%;height:20%;position:absolute;bottom:0px;">

                <hr width="90%" />

                <br />

                <a name='modal' id='fecha_deve' name='cancelar' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:10%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                    &nbsp;&nbsp;

                    <img src='img/inativo.png' width='10' border='0' />

                    <strong> Fechar </strong>

                </a>        

                <a name='modal' id="updt_deve" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:40%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                    &nbsp;&nbsp;

                    <img src='img/ativo.png' width='10' border='0' />

                    <strong> Editar </strong>

                </a>            

            </div>

        </div>        

        

        

        

        <!--- form de insercao de despesa --->

        <div id="dialog_2" class="window" style="width:40%;height:50%;background-color:#eeeeee;margin-left:30%; margin-top:10%;">

        	<div style="height:12%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative">

				<div style="position:absolute; margin-left:5%; margin-top:2%;">

                	Adicionar Despesa na Leitura

                </div>

            </div>

            <div style="width:40%;position:absolute; margin-top:5%;" align="right">

            	<table>

                	<tr height="30px;">

                    	<td align="right"><strong>Documento: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Numero Documento: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Centro de Custo: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Valor: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Descricao: &nbsp; </strong></td>

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

            <br />

            <a name='modal' id='voltar' name='cancelar' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:15%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                &nbsp;&nbsp;

                <strong> &nbsp;&nbsp;<< Voltar </strong>

            </a>      

            <a name='modal' id="ins_desp" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:35%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                &nbsp;&nbsp;

                <img src='img/ativo.png' width='10' border='0' />

                <strong> &nbsp;Inserir </strong>

	        </a>            

        	</div>

        </div> 

        

        

        

        

        

        <div id="dialog_edit_dev" class="window" style="width:40%;height:40%;background-color:#eeeeee;margin-left:30%; margin-top:10%;">

        	<div style="height:18%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative">

				<div style="position:absolute; margin-left:5%; margin-top:2%;">

                	Editar Deve Leitura

                </div>

            </div>

            <div style="width:40%;position:absolute; margin-top:5%;" align="right">

            	<table>

                	<tr height="30px;">

                    	<td align="right"><strong>ID Deve: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Valor Deve: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Valor Pago Deve: &nbsp; </strong></td>

                    </tr>                                                                             

                </table>

            </div>

            <div style="width:60%;position:absolute;left:40%;margin-left:10px;margin-top:5%;" align="left">

            	<table>

                	<tr height="30px;">

                    	<td>

                            <?php echo $idDeve;?> 

                            <input type="hidden" name="edit_id_dev" id="edit_id_dev" value="<?php echo $idDeve;?>" title="<?php echo $saldoDeve;?>"  />                      

                        </td>

                    </tr>

                	<tr height="30px;">

                    	<td>

                            <input type="text" id="edit_vl_dev" name="edit_vl_dev" size="8" value="<?php echo number_format($vlDeveAtu,0,"",".");?>" />

                        </td>

                    </tr>

                	<tr height="30px;">

                    	<td>

                            <input type="text" id="edit_vl_dev_pag" name="edit_vl_dev_pag" size="8" value="<?php echo number_format($vlDevePago,0,"",".");?>"  />                  

                        </td>

                    </tr>                                                                           

                </table>

            </div>

            <div style=" width:100%;height:20%;position:absolute;bottom:0px;">

            <br />

            <a name='modal' id='voltar_deve' name='cancelar' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:15%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                &nbsp;&nbsp;

                <strong> &nbsp;&nbsp;<< Voltar </strong>

            </a>      

            <a name='modal' id="atu_deve_leit" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:35%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                &nbsp;&nbsp;

                <img src='img/ativo.png' width='10' border='0' />

                <strong> &nbsp;Atualizar </strong>

	        </a>            

        	</div>

        </div> 

        <div id="dialog_3" class="window" style="width:210px;height:30px;background-color:#eeeeee;margin-left:40%;margin-top:20%;">

			... Processando ...<br /><img src='img/aguarde.gif' align='aguarde' alt='aguarde'>

        </div> 

        <div id="mask">

        </div>     

</body>

</html>