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

		vw_leitura_maquina.id_local,

		DATE_FORMAT(MAX(vw_leitura_maquina.data),'%d/%m/%Y') AS data

	FROM

		`vw_leitura_maquina`

	WHERE

		vw_leitura_maquina.id_leitura = '".$id_assoc."'

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

	

	//Montando a Tabela com os dados que a aba deverá possuir

	$guias_cont.="\n\t\t\t\t<table width='".($key=='Histórico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";

	$coluna=0;

	//Reponsavel por Montar o Quadro de Historico das leitura

	if ($key=='Leitura') {

	
		//verifica o nivel do usuarios
		if($_SESSION['usr_nivel'] == 11)
		{

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
	
				INNER JOIN
	
					vw_leitura_maquina
	
				ON
	
					vw_maquinas.id_maquina = vw_leitura_maquina.id_maquina
	
				WHERE
	
						vw_maquinas.id_maquina IS NOT NULL
	
					AND 
					
						vw_leitura_maquina.id_leitura = '".$id_assoc."'
						
					AND
					
						vw_maquinas.parceiro = 1						
	
				GROUP BY
	
					vw_maquinas.id_maquina
	
				ORDER BY
	
					vw_maquinas.ordem_leitura
	
				";
				
		}
		else
		{
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
	
				INNER JOIN
	
					vw_leitura_maquina
	
				ON
	
					vw_maquinas.id_maquina = vw_leitura_maquina.id_maquina
	
				WHERE
				
						vw_maquinas.id_maquina IS NOT NULL
						
					AND 
					
						vw_leitura_maquina.id_leitura = '".$id_assoc."'					
	
				GROUP BY
	
					vw_maquinas.id_maquina
	
				ORDER BY
	
					vw_maquinas.ordem_leitura
	
				";			
		}
	
				
	
			$query_maq=@mysql_query($sql_maq);



		/*

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#E17009;'>LOCAL: <span style='color:#1D5987;'>" . $result_loc['nome'] . "<div>" . $result_num_leit['data'] . "</div>" . "</span></th></tr>\n";

		*/

		

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#E17009;'>ID: ". $id_assoc ."<br /><span style='color:#1D5987; font-size:20px;'>" . $result_loc['nome'] . "<div> <font size='2'>" . $result_num_leit['data'] .  "</font></div></span></th></tr>\n";		

		

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

		$tot_frut = 0;

		$tot_lan = 0;

		$com_local = 0;

		

	

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



			

			//atribui valores do resultado

			$entrada_total = $dados_ult_tot['valor_entrada_total'];

			$ent_ant = $dados_ult_ent['valor_entrada'];

			$sai_total = $dados_ult_tot['valor_saida_total'];

			$sai_ant = $dados_ult_ent['valor_saida'];

			

			//subtrai a ultima leitura parcial da total para sacar o valor da leitura anterior

			$dif_leit_ant_ent = $entrada_total - $ent_ant;

			$dif_leit_ant_sai = $sai_total - $sai_ant;



			

			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];

			//$guias_cont.="\n\t\t\t\t\t\t". "entrada ofici";	

			

			//verifica se eh a primeira leitura

			if($dados_ult_ent['valor_entrada'] == "")

			{

				$dados_ult_ent['valor_entrada'] = 0;

				$dados_ult_ent['valor_saida'] = 0;

			}

			

			$guias_cont.="\n\t\t\t\t\t\t <input label=Entrada' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='20' id='" . $result_maq['id_maquina'] . "_ent' title='Informe entrada da maquina' value='". number_format($dados_ult_tot['valor_entrada_total'],0,"",".") ."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >";			

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=3;

			

			//atribui contador de total de entrada

			$tot_ent_ant = $tot_ent_ant + $dados_ult_ent['valor_entrada'];



			//nova Entrada

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";			

			//$guias_cont.="\n\t\t\t\t\t\t <input label=Entrada' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='20' id='" . $result_maq['id_maquina'] . "_ent' onBlur='calcula(this.id);' title='Informe entrada da maquina' value='0' >";

			

			//declara o valor do bruto

			$bruto = $dados_ult_tot['valor_entrada_total'] - $dif_leit_ant_ent;			

			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_bruto' value='" . number_format($bruto,0,"",".") .  "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";

			$guias_cont.="\n\t\t\t\t\t</td>\n";			

			$coluna=4;

			

			//atribui contador de total de entrada

			$tot_sai_ant = $tot_sai_ant + $dados_ult_ent['valor_saida'];



			//Ultima Saida

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";

			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_saida'];

			//$guias_cont.="\n\t\t\t\t\t\t". "saida ofici";

			//verifica se é a primeira entrada

			if($dados_ult_ent['valor_entrada'] == "")

			{

				$dados_ult_ent['valor_entrada'] = 0;

				$dados_ult_ent['valor_saida'] = 0;

			}

			

			$guias_cont.="\n\t\t\t\t\t\t <input label=Saida' type='text' name='" . $result_maq['id_maquina'] . "_sai' size='20' id='" . $result_maq['id_maquina'] . "_sai' title='Informe saida da maquina' value='". number_format($dados_ult_tot['valor_saida_total'],0,"",".") ."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >";

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=5;

			

			//Nova Saida

			$premio = $dados_ult_tot['valor_saida_total'] - $dif_leit_ant_sai;



			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

			$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_premio' value='" . number_format($premio,0,"",".") . "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=6;

			

			

			//criar obs aqui

			if($flag_dif == 'true')

			{

				//sub Total

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$cont_sub_tot = $linha - 1;

				$sub_tot = $bruto - $premio - $result_dif['valor_desconto']; 



				

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='SubTotal' type='text' name='" . $cont_sub_tot . "_subtot' size='20' id='" . $result_maq['id_maquina'] . "_subtot' title='Leitura' value='". number_format($sub_tot,0,"","."). "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >"."</br><a id='mostra_dif' href='#'> obs </a></strong>";

				$tot_sub_tot = $tot_sub_tot + $sub_tot;

				

				$guias_cont.="\n\t\t\t\t\t</td>\n";

			}

			else

			{

				//sub Total

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$cont_sub_tot = $linha - 1;

				$sub_tot = $bruto - $premio;

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='SubTotal' type='text' name='" . $cont_sub_tot . "_subtot' size='20' id='" . $result_maq['id_maquina'] . "_subtot' title='Leitura' value='". number_format($sub_tot,0,"","."). "' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >"."</strong>";

				$tot_sub_tot = $tot_sub_tot + $sub_tot;

				

				$guias_cont.="\n\t\t\t\t\t</td>\n";			

			}

			

			



			

			

			$coluna=7;



			

			//Porcentagem do local (por maquina)

			if($result_maq['porc_maquina'] == 0)

			{

				$vl_pct_maq = ($sub_tot * $result_loc['percentual']) / 100;

			}

			else

			{

			$vl_pct_maq = ($sub_tot * $result_maq['porc_maquina']) / 100;

			}

			

			

			///teste

			

			

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='% local' type='text' name='" . $cont_sub_tot . "_porclc' size='20' id='" . $result_maq['id_maquina'] . "_porclc' title='%' value='". number_format($vl_pct_maq,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >"."</strong>";

			//conta total do porc maquina

			$tot_por_maq = $tot_por_maq + $vl_pct_maq;

			

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=8;

			

			//numero da maquina

			$tot_fat_maq = $sub_tot - $vl_pct_maq;

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='Total Maq local' type='text' name='" . $cont_sub_tot . "_totmaq' size='20' id='" . $result_maq['id_maquina'] . "_totmaq' title='Total Maq' value='". number_format($tot_fat_maq,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >"."</strong>";

			$tot_tot_fat = $tot_tot_fat + $tot_fat_maq;

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=9;

			

			$guias_cont.="\n\t\t\t\t\t</tr>\n";

								

			

			//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];

			$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";			

			$guias_cont.="\n\t\t\t\t\t\t".number_format($dif_leit_ant_ent,0,"",".");

			$guias_cont.="\n\t\t\t\t\t</td>\n";



			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

			//$guias_cont.="\n\t\t\t\t\t\t". "saida ofici";

			$guias_cont.="\n\t\t\t\t\t\t".number_format($dif_leit_ant_sai,0,"",".");						

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

				$guias_cont.="\n\t\t\t\t<div id='res_dif' width='100%' align='center' style='display:none;'>";				

				

				

				$guias_cont.="\n\t\t\t\t<table width='".($key=='Histórico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";				

				

				

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

				

				

				$guias_cont.="\n\t\t\t\t<table width='".($key=='Histórico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";				

			}

			

			

			//somar subtotal das frutilhas  aquiii

			if($result_maq['id_jogo']==20)

			{

				$tot_frut = $tot_frut + $sub_tot;

			}

			else if($result_maq['id_jogo']==22)

			{

				$tot_lan = $tot_lan + $sub_tot;

			}

		}

		

			//porcentagem total por jogo 

			$tot_frut = ($tot_frut *10) / 100;

			$tot_lan = ($tot_lan *10) / 100;		

		

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

								desconto_leit_fecha.id_descricao != ''

							GROUP BY

								desconto_leit_fecha.id_leitura_fechamento

							";

							

			$query_desconto=@mysql_query($sql_desconto);

			$result_desconto=@mysql_fetch_assoc($query_desconto);

			

			

			

			//todos os jogos que tem porcentagem e mostrar em looping

			$sql_jogo = "

				SELECT

					jogo.id_jogo,

					jogo.nome,

					jogo.codigo,

					jogo.porcentagem					

				FROM

					`jogo`

				WHERE

					jogo.porcentagem <> 0

				ORDER BY 

					jogo.nome

				";	

				

			$query_jogo=@mysql_query($sql_jogo);

			$total_jogos = 0;

			while($dados_jogo=@mysql_fetch_assoc($query_jogo) ) 

			{

				if($cor_linha == "#EEF6F9")

				{

					$cor_linha = "#FFFFFF";

				}

				else

				{

					$cor_linha = "#EEF6F9";

				}

				

				

				//verifica que jogo eh

				if($dados_jogo['id_jogo']==20)

				{

					$tot_jogo = $tot_frut;

				}

				else if($dados_jogo['id_jogo']==22)

				{

					$tot_jogo = $tot_lan;

				}



				//comissao local

				if($com_local==0)

				{

					$com_local = $tot_por_maq - $tot_jogo;

				}

				else

				{

					$com_local = $com_local - $tot_jogo;

				}



				$total_jogos = $total_jogos + $tot_jogo;

			}			

			

			

			



			

			$com_local = (($tot_sub_tot - $result_dev_desp['deve'] - $result_desconto['desconto'] - $total_jogos) * 10);

			$com_local = $com_local / 100;

			

				

		

			$vl_tot_tot_fat = (($tot_sub_tot - $result_dev_desp['deve'] - $result_desconto['desconto'] - $total_jogos - $com_local)*50)/100;  ////aquiiiiiiiiiiiiiiiiiii



		

		$guias_cont.="\n\t\t\t\t

			<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>

				<th colspan='5' style='color:#E17009;'>

					TOTAL FOLHA:

				</th>

				<th style='color:#E17009;'>

					<span style='color:#1D5987;'> <input label=TOTAL ENTRADA' type='text' name='total_subtot' size='20' id='total_subtot' title='Total Entrada' value='" . number_format($tot_sub_tot,0,"",".") . "' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" . "</span>

				</th>

				<th style='color:#E17009;'>

					<span style='color:#1D5987;'> <input label=TOTAL SAIDA' type='text' name='total_porcentagem' size='20' id='total_porcentagem' title='Total Saida' value='". number_format($vl_tot_tot_fat,0,"",".") ."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" .  "</span>

				</th>

				

				

				

				<th style='color:#E17009;'>

					<span style='color:#1D5987;'> <input label=TOTAL' type='text' name='total_final' size='20' id='total_final' title='Total' value=' ". number_format($tot_tot_fat,0,"",".") ."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" . "</span>

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



			if($cor_linha == "#EEF6F9")

			{

				$cor_linha = "#FFFFFF";

			}

			else

			{

				$cor_linha = "#EEF6F9";	

			}

			

			$tot_tot_fat = $tot_sub_tot;

			

			//Abrindo a Linha

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Efetivo";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='efetivo' value='".number_format($tot_tot_fat,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Deve";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			

			

			//consulta deve e observacoes

			$sql_dev_desp = "

							SELECT

								leitura.deve,

								leitura.observacao

							FROM

								`leitura`

							WHERE

								leitura.id_leitura = '".$id_assoc."'

							";

							

			$query_dev_desp=@mysql_query($sql_dev_desp);

			$result_dev_desp=@mysql_fetch_assoc($query_dev_desp);

			

			

			 



			

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='deve' value='".number_format($result_dev_desp['deve'],0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'   > ";//.number_format($vtot,'2',',','.');

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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Despesas";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='despesas' value='". number_format($result_desconto['desconto'],0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'   > ";//.number_format($vtot,'2',',','.');

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t</tr>";

			

			





			

			//todos os jogos que tem porcentagem e mostrar em looping

			$sql_jogo = "

				SELECT

					jogo.id_jogo,

					jogo.nome,

					jogo.codigo,

					jogo.porcentagem					

				FROM

					`jogo`

				WHERE

					jogo.porcentagem <> 0

				ORDER BY 

					jogo.nome

				";	

				

			$query_jogo=@mysql_query($sql_jogo);

			$total_jogos = 0;

			while($dados_jogo=@mysql_fetch_assoc($query_jogo) ) 

			{

				if($cor_linha == "#EEF6F9")

				{

					$cor_linha = "#FFFFFF";

				}

				else

				{

					$cor_linha = "#EEF6F9";

				}

				

				

				//verifica que jogo eh

				if($dados_jogo['id_jogo']==20)

				{

					$tot_jogo = $tot_frut;

				}

				else if($dados_jogo['id_jogo']==22)

				{

					$tot_jogo = $tot_lan;

				}



				//comissao local

				if($com_local==0)

				{

					$com_local = $tot_por_maq - $tot_jogo;

				}

				else

				{

					$com_local = $com_local - $tot_jogo;

				}



				

				$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

				$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

				$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". $dados_jogo['nome'];

				$guias_cont.="\n\t\t\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

				$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='". "jg_" .$dados_jogo['id_jogo']."' value='".$tot_jogo."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' onBlur='total_pagar()'   > ";//.number_format($vtot,'2',',','.');

				$guias_cont.="\n\t\t\t\t\t\t</td>";

				$guias_cont.="\n\t\t\t\t\t</tr>";

			

				$total_jogos = $total_jogos + $tot_jogo;

			}

			

			

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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Local";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			

			//calcula o total a pagar

			$total_a_pagar = $tot_tot_fat - $result_dev_desp['deve'] - $result_desconto['desconto'];

			

			$com_local = (($tot_tot_fat - $result_dev_desp['deve'] - $result_desconto['desconto'] - $total_jogos) * 10);

			$com_local = $com_local / 100;



			

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='totalapagar' value='".number_format(($com_local),0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "TOTAL";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			

			//calculo do toal a pagar

			$com_loc_final = $com_local*0.1;

			$total_a_pagar = ($tot_tot_fat - $result_dev_desp['deve'] - $result_desconto['desconto'] - $tot_frut - $tot_lan - $com_loc_final) * 0.5;

			

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='totalapagar' value='".number_format($vl_tot_tot_fat,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

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

		





		$(document).ready(function() {



			//Desconto

			$("#mostra_dif").click(function(event){

	

				$('#res_dif').slideToggle('slow');

			});				



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