<?php

session_start();

include('conn/conn.php');

include('functions/functions.php');

include('functions/lg_validador.php');

unset($_SESSION['campos']);

$total_colunas=10;

$jsc='';

$id_assoc = $_GET['id'];

$rep = $_GET['rep'];



//recebe lista de plaquinhas atualizada

$lst_plaq_atu = $_POST['infos'];



$det_maq_geral = explode(";", $lst_plaq_atu);



$qtd_inter = count($det_maq_geral);

$qtd_inter = $qtd_inter -1;

//fim de lista de plaquinhas atualizadas







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

	

	

	//campo de que semana pertence a leitura

	$guias_cont.="\n\t\t\t\t<strong>DATA REFERENCIA FECHAMENTO:</strong> ";

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t<input type='text' id='datepicker' size='23' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:1;' readonly='readonly'>";

	

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t&nbsp;";

	



	//campo de que semana pertence a leitura

	$guias_cont.="\n\t\t\t\t<strong>SEMANA:</strong> ";

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t<input type='text' id='semMes' size='2' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:1;' readonly='readonly'>";

	

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t&nbsp;";



	

	/*	

	$guias_cont.="\n\t\t\t\t<label>1- </label><input type='radio' name='radio' id='sem_1' value='1' checked='checked' /> ";

	$guias_cont.="\n\t\t\t\t&nbsp;";	

	$guias_cont.="\n\t\t\t\t<label>2- </label><input type='radio' name='radio' id='sem_2' value='2'  /> ";

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t<label>3- </label><input type='radio' name='radio' id='sem_3' value='3'  /> ";

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t<label>4- </label><input type='radio' name='radio' id='sem_4' value='4'  /> ";

	$guias_cont.="\n\t\t\t\t&nbsp;";

	$guias_cont.="\n\t\t\t\t<label>5- </label><input type='radio' name='radio' id='sem_5' value='5'  /> ";

	*/



	





	

	//Montando a Tabela com os dados que a aba deverá possuir

	$guias_cont.="\n\t\t\t\t<table id='tb_list_maq_leit' width='".($key=='Histórico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";

	$coluna=0;

	//Reponsavel por Montar o Quadro de Historico das leitura

	if ($key=='Leitura') {

	







		/////////////////////////

		/////////////////////////						





		//cria lista de plaquinhas desse local

		$sql_ult_id = "

			SELECT

				max(id_leitura) as id_leitura

			FROM

				leitura

			WHERE

				id_local= ".$id_assoc."

			";

		$query_ult_id=@mysql_query($sql_ult_id);

		$rst_ult_id=@mysql_fetch_assoc($query_ult_id);

		

		

		/*

		//verifica interfaces trocadas

		$sql_troca = "

			SELECT

				historico_troca_inter.id_maq,

				vw_maquinas.codigo,

				vw_maquinas.numero,

				vw_maquinas.id_jogo,

				historico_troca_inter.id_interface_ant AS interface,

				vw_maquinas.porc_maquina,

				historico_troca_inter.entrada_ant AS valor_entrada,

				historico_troca_inter.saida_ant AS valor_saida,

				historico_troca_inter.entrada_nov AS valor_entrada_total,

				historico_troca_inter.saida_nov AS valor_saida_total,

				historico_troca_inter.id_ultima_leitura

			FROM

				historico_troca_inter

			INNER JOIN

				vw_maquinas

			ON

				historico_troca_inter.id_maq = vw_maquinas.id_maquina

			WHERE

				historico_troca_inter.id_ultima_leitura = ".$rst_ult_id['id_leitura']."

			AND

				vw_maquinas.id_local = ".$id_assoc."

			";

		$query_troca=@mysql_query($sql_troca);

		*/

		



		//echo $sql_troca;

		

		

		/////////////////////////

		/////////////////////////

		/////////////////////////

		/////////////////////////

		

		if($rst_ult_id['id_leitura'] =="")

		{

			$sql_maq = "

					SELECT

						vw_maquinas.id_maquina,

						vw_maquinas.codigo,

						vw_maquinas.numero,

						vw_maquinas.id_jogo,

						vw_maquinas.interface,

						vw_maquinas.porc_maquina,

						leitura_por_maquina.valor_entrada,

						leitura_por_maquina.valor_saida,

						'' AS entrada_nova,

						'' AS saida_nova,					

						vw_maquinas.entrada_oficial as valor_entrada_total,

						vw_maquinas.saida_oficial as valor_saida_total,

						leitura_por_maquina.id_leitura,

						vw_maquinas.ordem_leitura,

					 	'normal' AS STATUS

					FROM

						`vw_maquinas`

					INNER JOIN leitura_por_maquina ON vw_maquinas.id_maquina = leitura_por_maquina.id_maquina

					WHERE

						vw_maquinas.id_maquina IS NOT NULL

					AND 

						vw_maquinas.id_local = '".$id_assoc."'

					GROUP BY

						vw_maquinas.id_maquina

	

					ORDER BY

						ordem_leitura					

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

						vw_maquinas.porc_maquina,

						leitura_por_maquina.valor_entrada,

						leitura_por_maquina.valor_saida,

						'' AS entrada_nova,

						'' AS saida_nova,

						vw_maquinas.entrada_oficial AS valor_entrada_total,

						vw_maquinas.saida_oficial AS valor_saida_total,

						leitura_por_maquina.id_leitura,

						vw_maquinas.ordem_leitura,

						'normal' AS STATUS

					FROM

						`vw_maquinas`

					INNER JOIN leitura_por_maquina ON vw_maquinas.id_maquina = leitura_por_maquina.id_maquina

					WHERE

						vw_maquinas.id_maquina IS NOT NULL

					AND 

						vw_maquinas.id_local = '".$id_assoc."'

					GROUP BY

						vw_maquinas.id_maquina

					ORDER BY

						ordem_leitura,

						numero				

				";

				

		/*

			$sql_maq = "

					SELECT

						vw_maquinas.id_maquina,

						vw_maquinas.codigo,

						vw_maquinas.numero,

						vw_maquinas.id_jogo,

						vw_maquinas.interface,

						vw_maquinas.porc_maquina,

						vw_leitura_maquina.valor_entrada,

						vw_leitura_maquina.valor_saida,

						'' AS entrada_nova,

						'' AS saida_nova,					

						vw_maquinas.entrada_oficial as valor_entrada_total,

						vw_maquinas.saida_oficial as valor_saida_total,

						vw_leitura_maquina.id_leitura,

						vw_maquinas.ordem_leitura,

					 'normal' AS STATUS

					FROM

						`vw_maquinas`

					INNER JOIN vw_leitura_maquina ON vw_maquinas.id_maquina = vw_leitura_maquina.id_maquina

					WHERE

						vw_maquinas.id_maquina IS NOT NULL

					AND vw_maquinas.id_local = '".$id_assoc."'

					GROUP BY

						vw_maquinas.id_maquina

					UNION

						SELECT

							historico_troca_inter.id_maq,

							vw_maquinas.codigo,

							vw_maquinas.numero,

							vw_maquinas.id_jogo,

							historico_troca_inter.id_interface_ant AS interface,

							vw_maquinas.porc_maquina,

							historico_troca_inter.entrada_ant AS valor_entrada,

							historico_troca_inter.saida_ant AS valor_saida,

							historico_troca_inter.entrada_nov AS entrada_nova,

							historico_troca_inter.saida_nov AS saida_nova,						

							vw_maquinas.entrada_oficial as valor_entrada_total,

							vw_maquinas.saida_oficial as valor_saida_total,

							historico_troca_inter.id_ultima_leitura,

							vw_maquinas.ordem_leitura - 0.5 AS ordem_leitura,

							'troca' AS STATUS

						FROM

							vw_maquinas

					INNER JOIN vw_leitura_maquina ON vw_maquinas.id_maquina = vw_leitura_maquina.id_maquina	

					INNER JOIN historico_troca_inter ON vw_maquinas.id_maquina = historico_troca_inter.id_maq

						WHERE

							historico_troca_inter.id_ultima_leitura = ".$rst_ult_id['id_leitura']."

						AND

							vw_maquinas.id_local = '".$id_assoc."'

						GROUP BY

							vw_maquinas.id_maquina

						ORDER BY

							ordem_leitura,

							numero				

				";				

				*/

				//echo $sql_maq;

			

			

		}	

		$query_maq=@mysql_query($sql_maq);

				

		



		

		

		//cria lista de plaquinhas desse local

		$sql_int = "

			SELECT

				interface.numero

			FROM

				interface

			INNER JOIN

				maquinas

			ON

				interface.id_maquina = maquinas.id_maquina

			WHERE

				maquinas.id_local = '".$id_assoc."'

			";

			

		$query_int=@mysql_query($sql_int);

		

		//cria a lista de interfaces

		$list_plaq = "";

		$cont_plaq = 0;

		while($result_int=@mysql_fetch_assoc($query_int)) 

		{

			$list_plaq .= "-" . $result_int['numero'] . ";";

			$cont_plaq++;

		}



		

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#E17009;'><!--- LOCAL: ---> <span style='color:#1D5987; font-size:20px;'>" . $result_loc['nome'] . "<div> <font size='2'>" . date('d-m-Y') . "</font></div></span></th></tr>\n";

		

				

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

		

		$tot_ent_imp = 0;

		$tot_sai_imp = 0;

		$TotPctLocal = 0;

		$TotPctPropria = 0;

		

		$arr_plaquinhas = array("plaquinhas" => array());

	

		$cont = 1;

		//$flag_troca = "";



		

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

			//echo $result_maq['STATUS'] . "<br />";

			if($result_maq['STATUS'] == "troca")

			{

				$flag_troca = "true";

				$troca_entrada = $result_maq['entrada_nova'];

				$troca_saida = $result_maq['saida_nova'];

				//($cor_linha=='#F0F0F0'?$cor_linha='#E1E1E1':$cor_linha='#F0F0F0');

				//($cor_linha=='#FF6600');

				$guias_cont.="\n\t\t\t\t<tr bgcolor='#bdadad' height='21px;' align='center'>\n";			

				

				

				//consulta o numero de interface

				$sql_intf = "

					SELECT

						interface.numero

					FROM

						interface

					WHERE

						interface.id_interface = '".$result_maq['interface']."'

					";

				$query_intf=@mysql_query($sql_intf);

				$result_query_intf=@mysql_fetch_assoc($query_intf);

				

	

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">".$result_maq['codigo']. " - " . $result_maq['numero'] . "<br />" . "<font size='2' color='white'>" . $result_query_intf['numero'] . "</font> </strong>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=2;			

							

				//Ultima entrada

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";

				

				$sql_ult_ent = "";

				

				$query_ult_ent=@mysql_query($sql_ult_ent);

				$dados_ult_ent=@mysql_fetch_assoc($query_ult_ent);			

	

	

				//verifica se eh a primeira leitura

				if($result_maq['valor_entrada_total'] == "")

				{

					$result_maq['valor_entrada_total'] = 0;

					$result_maq['valor_saida_total'] = 0;

				}

				

				

				//teste aqui

				$i = 0;

				while($i < $qtd_inter)

				{

				

					$leitura_int = explode("/", $det_maq_geral[$i]);

					$num_inter = $leitura_int[0];

					$entrada = $leitura_int[1] * 10;

					$saida = $leitura_int[2] * 10;

		

					if($result_maq['interface'] == $num_inter)

					{

						break;

					}

					else

					{

						$entrada = 0;

						$saida = 0;

					}				

					$i++;

				}

				

				//verifica se é para repetir a leitura

				if($rep == 1)

				{

					$entrada = $result_maq['valor_entrada_total'];

					$saida = $result_maq['valor_saida_total'];

				}			

				

				

				$guias_cont.="\n\t\t\t\t\t\t <input label='0' type='text' name='" . $result_maq['id_maquina'] . "_ent_troca' size='13 ' id='" . $result_maq['id_maquina'] . "_ent_troca' title='Informe entrada da maquina' style='text-align:center;background-color:transparent; border:none;' value='".number_format($result_maq['valor_entrada'],0,"",".")."' readonly='readonly' >";			

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=3;

				

				//atribui contador de total de entrada

				$tot_ent_ant = $tot_ent_ant + $result_maq['valor_entrada'];

	

				//nova Entrada

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";			

	

	

				//verifica se tem entrada da importacao

				if($entrada == "")

				{

					$bruto = 0;

					$premio = 0;

					$sub_tot_por_maq = 0;

					$PctLocal = 0;

					$PctPropria = 0;

					$tot_ent_imp = $tot_ent_imp + $bruto;

					$tot_sai_imp = $tot_sai_imp + $premio;	

				}

				else

				{

					$bruto = $entrada - $result_maq['valor_entrada_total'];

					$premio = $saida - $result_maq['valor_saida_total'];

					$sub_tot_por_maq = $bruto - $premio;

					$PctLocal = ($sub_tot_por_maq * $result_loc['percentual']) / 100;

					$PctPropria = $sub_tot_por_maq - $PctLocal;

					$tot_ent_imp = $tot_ent_imp + $bruto;

					$tot_sai_imp = $tot_sai_imp + $premio;

					$TotPctLocal = $TotPctLocal + $PctLocal;

					$TotPctPropria = $TotPctPropria + $PctPropria;

				}

				

				$bruto = $result_maq['valor_entrada'] - $result_maq['valor_entrada_total'];

				

				$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_bruto_troca' value='".number_format($bruto,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";			

				

				$guias_cont.="\n\t\t\t\t\t</td>\n";			

				$coluna=4;

				

				//atribui contador de total de entrada

				$tot_sai_ant = $tot_sai_ant + $result_maq['valor_saida'];

	

				//Ultima Saida

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";

	

				if($result_maq['valor_entrada_total'] == "")

				{

					$result_maq['valor_entrada_total'] = 0;

					$result_maq['valor_saida_total'] = 0;

				}

				

				$guias_cont.="\n\t\t\t\t\t\t <input type='text' name='" . $result_maq['id_maquina'] . "_sai_troca' size='13' id='" . $result_maq['id_maquina'] . "_sai_troca' style='text-align:center;background-color:transparent; border:none;' title='".$cont."' value='".number_format($result_maq['valor_saida'],0,"",".")."' readonly='readonly' label='0'>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=5;

				$cont++;

				

				

				//Nova Saida

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				

				$premio = $result_maq['valor_saida'] - $result_maq['valor_saida_total'];

	

				$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_premio_troca' value='".number_format($premio,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";

	

				

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=6;

				

				//aquiiii $sub_tot_por_maq verifica se eh negativo

				if($sub_tot_por_maq < 0)

				{

					$color = "red";	

				}

				else

				{

					$color = "black";	

				}

				

				

				$sub_tot_por_maq = $bruto - $premio;

				

				//Total

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$cont_sub_tot = $linha - 1;

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='SubTotal' type='text' name='" . $cont_sub_tot . "_subtot' size='20' id='" . $result_maq['id_maquina'] . "_subtot_troca' title='Leitura' value='".number_format($sub_tot_por_maq,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; color:".$color."; border:none;' readonly='readonly' >"."</strong>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=7;

	

				$PctLocal = ($sub_tot_por_maq * $result_loc['percentual']) / 100;

				$PctPropria = $sub_tot_por_maq - $PctLocal;

				$tot_ent_imp = $tot_ent_imp + $bruto;

				$tot_sai_imp = $tot_sai_imp + $premio;

				$TotPctLocal = $TotPctLocal + $PctLocal;

				$TotPctPropria = $TotPctPropria + $PctPropria;

				

				

	

				//Porcentagem do local

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='% local' type='text' name='" . $cont_sub_tot . "_porclc' size='20' id='" . $result_maq['id_maquina'] . "_porclc_troca' title='%' value='".number_format($PctLocal,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;color:".$color."; border:none;' readonly='readonly' >"."</strong>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=8;

				

				//numero da maquina

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='Total Maq local' type='text' name='" . $cont_sub_tot . "_totmaq' size='20' id='" . $result_maq['id_maquina'] . "_totmaq_troca' title='Total Maq' value='".number_format($PctPropria,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;color:".$color."; border:none;' readonly='readonly' >"."</strong>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=9;

				

	

				

				//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];

				$guias_cont.="\n\t\t\t\t<tr bgcolor='#bdadad' height='21px;' align='center'>\n";

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

				//$guias_cont.="\n\t\t\t\t\t\t". "entrada ofici";

				$guias_cont.="\n\t\t\t\t\t\t". number_format($result_maq['valor_entrada_total'],0,"",".");

				$guias_cont.="\n\t\t\t\t\t</td>\n";

	

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

				//$guias_cont.="\n\t\t\t\t\t\t". "saida ofici";

				$guias_cont.="\n\t\t\t\t\t\t". number_format($result_maq['valor_saida_total'],0,"",".");						

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$guias_cont.="\t\t\t\t</tr>\n";			

				

				if ($coluna==$total_colunas) {

					$guias_cont.="\t\t\t\t</tr>\n";

					$coluna = 0;

				}

			}

			else

			{

			*/

				($cor_linha=='#F0F0F0'?$cor_linha='#E1E1E1':$cor_linha='#F0F0F0');

				$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";			

				

	

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">".$result_maq['codigo']. " - " . $result_maq['numero'] . "<br />" . "<font size='2' color='gray'>" . $result_maq['interface'] . "</font> </strong>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=2;			

							

				//Ultima entrada

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";

				

				$sql_ult_ent = "";

				

				$query_ult_ent=@mysql_query($sql_ult_ent);

				$dados_ult_ent=@mysql_fetch_assoc($query_ult_ent);			

	

	

				//verifica se eh a primeira leitura

				if($result_maq['valor_entrada_total'] == "")

				{

					$result_maq['valor_entrada_total'] = 0;

					$result_maq['valor_saida_total'] = 0;

				}

				

				

				//teste aqui

				$i = 0;

				while($i < $qtd_inter)

				{

				

					$leitura_int = explode("/", $det_maq_geral[$i]);

					$num_inter = $leitura_int[0];

					$entrada = $leitura_int[1] * 10;

					$saida = $leitura_int[2] * 10;

		

					if($result_maq['interface'] == $num_inter)

					{

						break;

					}

					else

					{

						$entrada = 0;

						$saida = 0;

					}				

					$i++;

				}

				

				//verifica se é para repetir a leitura

				if($rep == 1)

				{

					$entrada = $result_maq['valor_entrada_total'];

					$saida = $result_maq['valor_saida_total'];

				}			

				

				/*

				if($flag_troca == "true")

				{

					$guias_cont.="\n\t\t\t\t\t\t <input label='0' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='13' id='" . $result_maq['id_maquina'] . "_ent' onclick='selCampo(this);' onkeypress='verificaTecla(this);' onblur='calcula(this.id," . $result_maq['id_maquina'] . "," . $troca_entrada . "," . $troca_saida ."," . $result_maq['porc_maquina'] . ");' title='Informe a entrada da maquina' style='text-align:center' value='".number_format($entrada,0,"",".")."' > <input type='button' id='rep_ent_".$result_maq['id_maquina']."' name='rep_ent_".$result_maq['id_maquina']."' title='".$result_maq['valor_entrada_total']."' value=' = ' onclick='rep_valor(this);' />";				

				}

				else

				{

				*/
					if($entrada == 0)
					{
						$guias_cont.="\n\t\t\t\t\t\t <input label='0' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='13' id='" . $result_maq['id_maquina'] . "_ent' onclick='selCampo(this);' onkeypress='verificaTecla(this);' onblur='calcula(this.id," . $result_maq['id_maquina'] . "," . $result_maq['valor_entrada_total'] . "," . $result_maq['valor_saida_total'] ."," . $result_maq['porc_maquina'] . ");' title='Informe entrada da maquina' style='text-align:center' value='".number_format($entrada,0,"",".")."'  > <input type='button' id='rep_ent_".$result_maq['id_maquina']."' name='rep_ent_".$result_maq['id_maquina']."' title='".$result_maq['valor_entrada_total']."' value=' = ' onclick='rep_valor(this);' />";								
					}
					else
					{
						$guias_cont.="\n\t\t\t\t\t\t <input label='0' type='text' name='" . $result_maq['id_maquina'] . "_ent' size='13' id='" . $result_maq['id_maquina'] . "_ent' onclick='selCampo(this);' onkeypress='verificaTecla(this);' onblur='calcula(this.id," . $result_maq['id_maquina'] . "," . $result_maq['valor_entrada_total'] . "," . $result_maq['valor_saida_total'] ."," . $result_maq['porc_maquina'] . ");' title='Informe entrada da maquina' style='text-align:center' value='".number_format($entrada,0,"",".")."' disabled='disabled' > <input type='button' id='rep_ent_".$result_maq['id_maquina']."' name='rep_ent_".$result_maq['id_maquina']."' title='".$result_maq['valor_entrada_total']."' value=' = ' onclick='rep_valor(this);' />";							
					}
	
			

				//}



				

			

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=3;

				

				//atribui contador de total de entrada

				$tot_ent_ant = $tot_ent_ant + $result_maq['valor_entrada'];

	

				//nova Entrada

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";			

	

	

				//verifica se tem entrada da importacao

				if($entrada == "") // nao eh de importacao

				{

					$bruto = 0;

					$premio = 0;

					$sub_tot_por_maq = 0;

					$PctLocal = 0;

					$PctPropria = 0;

					$tot_ent_imp = $tot_ent_imp + $bruto;

					$tot_sai_imp = $tot_sai_imp + $premio;	

				}

				else

				{

					$bruto = $entrada - $result_maq['valor_entrada_total'];

					$premio = $saida - $result_maq['valor_saida_total'];

					$sub_tot_por_maq = $bruto - $premio;
					
					if($result_maq['porc_maquina'] == 0)
					{
						$PctLocal = ($sub_tot_por_maq * $result_loc['percentual']) / 100;					
					}
					else
					{
						$PctLocal = ($sub_tot_por_maq * $result_maq['porc_maquina']) / 100;	
					}


					//$PctLocal = $result_maq['porc_maquina'];

					$PctPropria = $sub_tot_por_maq - $PctLocal;

					$tot_ent_imp = $tot_ent_imp + $bruto;

					$tot_sai_imp = $tot_sai_imp + $premio;

					$TotPctLocal = $TotPctLocal + $PctLocal;

					$TotPctPropria = $TotPctPropria + $PctPropria;

				}

				

				

				

				$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_bruto' value='".number_format($bruto,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;text-align:center;font-weight:bolder;background-color:transparent; border:none;' readonly='readonly'  >";			

				

				//soma contador bruto

				$totBruto = $totBruto + $bruto; 

				

				$guias_cont.="\n\t\t\t\t\t</td>\n";			

				$coluna=4;

				

				//atribui contador de total de entrada

				$tot_sai_ant = $tot_sai_ant + $result_maq['valor_saida'];

	

				//Ultima Saida

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' align='center' >\n";

	

				if($result_maq['valor_entrada_total'] == "")

				{

					$result_maq['valor_entrada_total'] = 0;

					$result_maq['valor_saida_total'] = 0;

				}

				

				/*

				if($flag_troca == "true")

				{

					$guias_cont.="\n\t\t\t\t\t\t <input type='text' name='" . $result_maq['id_maquina'] . "_sai' size='13' id='" . $result_maq['id_maquina'] . "_sai' style='text-align:center' onclick='selCampo(this);' onkeypress='verificaTecla(this);' onBlur='calcula(this.id," . $result_maq['id_maquina'] . "," . $troca_entrada . "," . $troca_saida ."," . $result_maq['porc_maquina'] . ");' title='".$cont."' value='".number_format($saida,0,"",".")."' label='0' > <input type='button' id='rep_sai_".$result_maq['id_maquina']."' name='rep_sai_".$result_maq['id_maquina']."' title='".$result_maq['valor_saida_total']."' value=' = ' onclick='rep_valor(this);' />";

				}

				else

				{

				*/
					if($saida == 0)
					{
						$guias_cont.="\n\t\t\t\t\t\t <input type='text' name='" . $result_maq['id_maquina'] . "_sai' size='13' id='" . $result_maq['id_maquina'] . "_sai' style='text-align:center' onclick='selCampo(this);' onkeypress='verificaTecla(this);' onBlur='calcula(this.id," . $result_maq['id_maquina'] . "," . $result_maq['valor_entrada_total'] . "," . $result_maq['valor_saida_total'] ."," . $result_maq['porc_maquina'] . ");' title='".$cont."' value='".number_format($saida,0,"",".")."' label='0' > <input type='button' id='rep_sai_".$result_maq['id_maquina']."' name='rep_sai_".$result_maq['id_maquina']."' title='".$result_maq['valor_saida_total']."' value=' = ' onclick='rep_valor(this);' />";							
					}
					else
					{
						$guias_cont.="\n\t\t\t\t\t\t <input type='text' name='" . $result_maq['id_maquina'] . "_sai' size='13' id='" . $result_maq['id_maquina'] . "_sai' style='text-align:center' onclick='selCampo(this);' onkeypress='verificaTecla(this);' onBlur='calcula(this.id," . $result_maq['id_maquina'] . "," . $result_maq['valor_entrada_total'] . "," . $result_maq['valor_saida_total'] ."," . $result_maq['porc_maquina'] . ");' title='".$cont."' value='".number_format($saida,0,"",".")."' label='0' disabled='disabled' > <input type='button' id='rep_sai_".$result_maq['id_maquina']."' name='rep_sai_".$result_maq['id_maquina']."' title='".$result_maq['valor_saida_total']."' value=' = ' onclick='rep_valor(this);' />";							
					}
				

			

				//}

				



				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=5;

				$cont++;

				

				

				//Nova Saida

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				

	

				$guias_cont.="\n\t\t\t\t\t\t" . "<input id='" . $result_maq['id_maquina'] . "_premio' value='".number_format($premio,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  >";

				

				//soma contador bruto

				$totPremio = $totPremio + $premio; 				

	

				

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=6;

				

				//aquiiii $sub_tot_por_maq verifica se eh negativo

				if($sub_tot_por_maq < 0)

				{

					$color = "red";	

				}

				else

				{

					$color = "black";	

				}

				

				//Total

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$cont_sub_tot = $linha - 1;

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='SubTotal' type='text' name='" . $cont_sub_tot . "_subtot' size='20' id='" . $result_maq['id_maquina'] . "_subtot' title='Leitura' value='".number_format($sub_tot_por_maq,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; color:".$color."; border:none;' readonly='readonly' >"."</strong>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				

				$coluna=7;

	

	

				//Porcentagem do local

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='% local' type='text' name='" . $cont_sub_tot . "_porclc' size='20' id='" . $result_maq['id_maquina'] . "_porclc' title='%' value='".number_format($PctLocal,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;color:".$color."; border:none;' readonly='readonly' >"."</strong>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=8;

				

				//numero da maquina

				$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' rowspan='2' align='center' >\n";

				$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">"."<input label='Total Maq local' type='text' name='" . $cont_sub_tot . "_totmaq' size='20' id='" . $result_maq['id_maquina'] . "_totmaq' title='Total Maq' value='".number_format($PctPropria,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;color:".$color."; border:none;' readonly='readonly' >"."</strong>";

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna=9;

				

				/*

				if($flag_troca == "true")

				{

					//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];

					$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";

					$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

					//$guias_cont.="\n\t\t\t\t\t\t". "entrada ofici";

					$guias_cont.="\n\t\t\t\t\t\t". number_format($troca_entrada,0,"",".");

					$guias_cont.="\n\t\t\t\t\t</td>\n";

		

					$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

					//$guias_cont.="\n\t\t\t\t\t\t". "saida ofici";

					$guias_cont.="\n\t\t\t\t\t\t". number_format($troca_saida,0,"",".");						

					$guias_cont.="\n\t\t\t\t\t</td>\n";

					$guias_cont.="\t\t\t\t</tr>\n";				

				}

				else

				{

				*/

					//$guias_cont.="\n\t\t\t\t\t\t".$dados_ult_ent['valor_entrada'];

					$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";

					$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

					//$guias_cont.="\n\t\t\t\t\t\t". "entrada ofici";

					$guias_cont.="\n\t\t\t\t\t\t". number_format($result_maq['valor_entrada_total'],0,"",".");

					$guias_cont.="\n\t\t\t\t\t</td>\n";

		

					$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' >\n";

					//$guias_cont.="\n\t\t\t\t\t\t". "saida ofici";

					$guias_cont.="\n\t\t\t\t\t\t". number_format($result_maq['valor_saida_total'],0,"",".");						

					$guias_cont.="\n\t\t\t\t\t</td>\n";

					$guias_cont.="\t\t\t\t</tr>\n";				

				//}



	

				

			

				

				if ($coluna==$total_colunas) {

					$guias_cont.="\t\t\t\t</tr>\n";

					$coluna = 0;

				}

				

				/*

				if($flag_troca == "true")

				{

					$flag_troca = "";

				}

				*/

			//}

			

		}

		$guias_cont.="\n\t\t\t</table>";

		

		$guias_cont.="\n\t\t\t\t<table width='".($key=='Histórico'?'50':'100')."%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='4'>";		

		

		

		//calcula o subtotal da importacao

		$sub_tot_imp = $tot_ent_imp - $tot_sai_imp;

		

		$guias_cont.="\n\t\t\t\t

			<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>

				<th style='color:#1d5987;' width='12.5%'>

					Maquinas Exibidas: <strong>".$NumeroLinhas."</strong>

				</th>				

				<th style='color:#E17009;' width='12.48%'>

					TOTAL FOLHA:

				</th> 

				<th style='color:#E17009;'  width='12.5%'>

					<input label=TotalBruto' type='text' name='total_bruto' size='20' id='total_bruto' title='SubTotalBruto' value='".number_format($totBruto,0,"",".")."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >

				</th> 

				<th style='color:#E17009;'  width='12.5%'>

					&nbsp;

				</th> 

				<th style='color:#E17009;'  width='12.5%'>

					<input label=TotalPremio' type='text' name='total_premio' size='20' id='total_premio' title='SubTotalPremio' value='".number_format($totPremio,0,"",".")."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >

				</th> 												

												

				<th style='color:#E17009;'  width='12.5%'>

					<span style='color:#1D5987;'> <input label=SubTotal' type='text' name='total_subtot' size='20' id='total_subtot' title='SubTotal' value='".number_format($sub_tot_imp,0,"",".")."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" . "</span>

				</th>

				<th style='color:#E17009;'  width='12.5%'>

					<span style='color:#1D5987;'> <input label=TOTAL SAIDA' type='text' name='total_porcentagem' size='20' id='total_porcentagem' title='Total Saida' value='".number_format($TotPctLocal,0,"",".")."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" .  "</span>

				</th>

				<th style='color:#E17009;'  width='12.5%'>

					<span style='color:#1D5987;'> <input label=TOTAL' type='text' name='total_final' size='20' id='total_final' title='Total' value='".number_format($TotPctPropria,0,"",".")."' style='color:#E17009;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >" . "</span>

				</th>																

			</tr>\n";



						

	}



	if ($coluna != 1) {

		$guias_cont.="\t\t\t\t</tr>\n";

	}

	$guias_cont.="\n\t\t\t</table>";









		//

		$guias_cont.="\n\t\t\t\t<table width='100%' border='0' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";

		$guias_cont.="\n\t\t\t\t\t\t<tr align='center'><th>";



		//----------

		//observacao

		//----------

		$guias_cont.="\n\t\t\t\t<table width='100px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";

		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='30px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Observacao: </th>";





		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

		//Abrindo a Linha

		$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

		$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

		$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <textarea name='obs' id='obs' cols=35' rows='6' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder; border:none;'></textarea> ";

		$guias_cont.="\n\t\t\t\t\t\t</td>";

		$guias_cont.="\n\t\t\t\t\t</tr>";

		$guias_cont.="\n\t\t\t\t</table>";			

		

		////////////////////////////////////////////////////////////

		

		

		$guias_cont.="\n\t\t\t\t\t\t</th>";

		

		

		$guias_cont.="\n\t\t\t\t\t\t<th>";

		

		//---------

		//diferenca

		//---------

		$guias_cont.="\n\t\t\t\t<table width='250px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";

		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='29px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Diferencas: </th>";





		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

		//Abrindo a Linha







			//Abrindo a Linha

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Total Dif Positiva:";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center'>";

			

			

$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "<font color='red'></font><input id='tot_dif_pos' name='tot_dif_pos' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none; width:75px;' readonly='readonly'>";			

			

/*

			//Regiao

			$sql_reg = "

				SELECT

					vw_maquinas.id_maquina,

					vw_maquinas.numero,

					vw_maquinas.codigo

				FROM

					vw_maquinas

				WHERE

					vw_maquinas.id_local = ".$id_assoc."

				GROUP BY

					vw_maquinas.id_maquina

				ORDER BY

					vw_maquinas.numero

			";

			$query_reg = @mysql_query($sql_reg);

			//Montando as Combos de regiaoes.

			$reg = '';

			while ( $dados_reg=@mysql_fetch_assoc($query_reg) ) {

				$reg.= "\n\t\t\t\t\t<option value='".$dados_reg['id_maquina']."'>".$dados_reg['codigo']."-".$dados_reg['numero']."</option>";

			}

			$guias_cont.="\n\t\t\t\t<select name='lc_reg' id='lc_reg'  style='width:80px;font-size:10px;' onfocus=\"$('#info_lc_ope').css({'visibility':'visible'});\" onblur=\"$('#info_lc_ope').css({'visibility':'hidden'});\">";

			$guias_cont.=$reg;

			$guias_cont.="\n\t\t\t\t</select>";



			

			

			*/

			

			

			

			

			$guias_cont.="\n\t\t\t\t\t\t</td>";			

			$guias_cont.="\n\t\t\t\t\t</tr>";



			//Abrindo a Linha

			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');			

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='18px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Total Dif Negativa:";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:0px;' align='center'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "<font color='red'></font><input id='tot_dif_neg' name='tot_dif_neg' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none; width:75px;' readonly='readonly'>";

			$guias_cont.="\n\t\t\t\t\t\t</td>";			

			$guias_cont.="\n\t\t\t\t\t</tr>";





			//Abrindo a Linha

			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');						

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='18px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Saldo Dif:";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "<input id='tot_vl_dif' name='tot_vl_dif' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none; width:75px;' readonly='readonly'  >";

			$guias_cont.="\n\t\t\t\t\t\t</td>";			

			$guias_cont.="\n\t\t\t\t\t</tr>";





			//Abrindo a Linha

			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');			

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='18px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";	



			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='center' colspan='2'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "<a name='modal' id='add_dif' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:6%;cursor:pointer;font-size:11px;background-color:#485F65;width:60px;height:15px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;align' align='center' >&nbsp;Editar&nbsp;</a>";

			$guias_cont.="\n\t\t\t\t\t\t</td>";		



			$guias_cont.="\n\t\t\t\t\t</tr>";







		$guias_cont.="\n\t\t\t\t</table>";		

		//----------

		//diferenca

		//----------

		

		$guias_cont.="\n\t\t\t\t\t\t</th>";

		

		

		$guias_cont.="\n\t\t\t\t\t\t<th>";		

		

		

		//observacao

		//DETALHES

		$guias_cont.="\n\t\t\t\t<table width='300px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";

		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='33px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Detalhes de Deve: </th>";





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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Ultimo Pago:";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			

			//consulta o ultimo registro de deve desse local

			$sql_ult_deve = "

				SELECT

					max(deve.id_deve) as id_deve,

					deve.saldo,

					valor_recebido

				FROM

					`deve`

				WHERE

					`id_local` = '".$id_assoc."'

				";

				

			$query_ult_deve=@mysql_query($sql_ult_deve);

			$result_ult_deve=@mysql_fetch_assoc($query_ult_deve);

			

			

			//consulta o ultimo registro de deve desse local

			$sql_dados_deve = "

				SELECT

					*

				FROM

					`deve`

				WHERE

					`id_deve` = '".$result_ult_deve['id_deve']."'

				";

				

			$query_dados_deve=@mysql_query($sql_dados_deve);

			$result_dados_deve=@mysql_fetch_assoc($query_dados_deve);		

			

			$flag_saldo = mysql_num_rows($query_dados_deve);

			

			//

			if($flag_saldo == 0)

			{

				$tem_saldo = 0;

			}

			else

			{

				$tem_saldo = $result_dados_deve['saldo'];

			}





			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='ult_pago' value='". number_format($result_dados_deve['valor_recebido'],0,"",".") ."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Saldo: ";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='saldo' name='saldo' value='". number_format($tem_saldo,0,"",".") ."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'   > ";//.number_format($vtot,'2',',','.');

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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Valor a Abonar:";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t<font color='red'>*</font>&nbsp; <input id='abono' name='abono' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()'   > ";//.number_format($vtot,'2',',','.');

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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Novo Saldo:";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='deve_atual' value='".number_format($result_dados_deve['saldo'],0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			

	

		$guias_cont.="\n\t\t\t\t</table>";

		// fim de mostra total	





		$guias_cont.="\n\t\t\t\t\t\t</th>";



		$guias_cont.="\n\t\t\t\t\t\t<th>";

		

		





		$guias_cont.="\n\t\t\t\t\t\t</th>";

		

		

		$guias_cont.="\n\t\t\t\t\t\t<th>";		

		

		

		

		

		

		

		// mostra total

		//Totalizadores

		$guias_cont.="\n\t\t\t\t<table width='300px' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";

		$guias_cont.="\n\t\t\t\t\t\t<tr bgcolor='#F5F8F9' height='30px;' style='font-weight:bolder' align='center'><th style='color:#E17009;' colspan='2'>Totalizadores Lan&ccedil;amentos: </th>";







			if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}

			

			

			//Abrindo a Linha

			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Efetivo";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp; <input id='efetivo' value='".number_format($TotPctPropria,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t</tr>";

			

			

			if($cor_linha == "#EEF6F9"){$cor_linha = "#FFFFFF";}else{$cor_linha = "#EEF6F9";}

		



			$guias_cont.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' onMouseover='this.style.backgroundColor=\"#9AC0CD\";this.style.color=\"white\";' onMouseout='this.style.backgroundColor=\"".$cor_linha."\";this.style.color=\"black\";'>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='left'>";

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;". "Deve";

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t\t<td style='padding:5px;' align='right'>";

			$guias_cont.="\n\t\t\t\t\t\t\t<font color='red'>*</font>&nbsp; <input id='deve' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' onBlur='total_pagar()'   > ";

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

			$guias_cont.="\n\t\t\t\t\t\t\t<a name='modal' id='list_todas_desp' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:0%;cursor:pointer;font-size:11px;background-color:#485F65;width:55px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;align' align='center' >Editar</a> <input id='despesa' value='0' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' onBlur='total_pagar()'   > ";

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

			$guias_cont.="\n\t\t\t\t\t\t\t&nbsp;<input id='totalapagar' value='".number_format($TotPctPropria,0,"",".")."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly'  > ";//.number_format($vtot,'2',',','.');

			$guias_cont.="\n\t\t\t\t\t\t</td>";

			$guias_cont.="\n\t\t\t\t\t</tr>";

		$guias_cont.="\n\t\t\t\t</table>";

		// fim de mostra total	

	

		$guias_cont.="\n\t\t\t\t\t\t</th>";



		$guias_cont.="\n\t\t\t\t</table>";		

	

	//fecha form

	$guias_cont.="\n\t\t\t</form>";

	

	$guias_cont.="\n\t\t\t</div>";		

	$cont++;

	



$guias.="\n\t\t\t</ul>\n";





	//PAINEL DE CONTROLE

	$guias_cont.="\n\t\t\t\t<div style='position:fixed;bottom:0;background-color:#B2C7CE;width:100%;'>";



	$guias_cont.="\n\t\t\t\t\t<form name='imp_leit' enctype='multipart/form-data' action='http://186.67.7.147/arquivo/uploader.php' method='POST'>";

	$guias_cont.="\n\t\t\t\t\t<input type='hidden' name='MAX_FILE_SIZE' value='100000' />";	



	$guias_cont.="\n\t\t\t\t\t &nbsp; <strong>Importacao:</strong> ";



	$guias_cont.="\n\t\t\t\t\t<input type='file' name='uploadedfile[]'  multiple='' style='margin:5px;margin-left:2%; width:200px;' />";

	

	$guias_cont.="\n\t\t\t\t\t<input type='hidden' name='id_loc_plaq' id='id_loc_plaq' value='".$list_plaq."' />";	

	$guias_cont.="\n\t\t\t\t\t<input type='hidden' name='local_id' id='local_id' value='".$id_assoc."' />";		

	

	$guias_cont.="\n\t\t\t\t<input id='importar' type='button' value='Importar Arquivos' title='Clique aqui importar o arquivo selecionado' style='margin:5px; margin-left:0px; width:150px; cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;'>";

	

	$guias_cont.="\n\t\t\t\t<input id='online' type='button' value='Leitura Online' title='Clique aqui importar leitura Online' style='margin:5px; margin-left:10%; width:150px; cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;'>";

	

	



	$guias_cont.="\n\t\t\t\t<input href='#dialog' id='rep_leit' type='button' value='Repetir Leitura' title='Clique aqui repetir a ultima leitura' style='margin:5px; margin-left:10%; width:150px; cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;'>";		

	

	$guias_cont.="\n\t\t\t\t<a id='arq_leitura' name='modal' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:6%;cursor:pointer;font-size:11px;background-color:#485F65;width:90px;height:21px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;align' align='center' >Criar Leitura</a>";		



}

	//PAINEL DE CONTROLE







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



	$(function() {

		$("#datepicker").datepicker({dateFormat: 'dd-mm-yy, DD'});

	});





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

	

	function rep_valor(obj)

	{

		var vl_cp = obj.title;

		var id_rec = obj.id.split("_");

		var tp_btn = id_rec[1];

		var id_rec = id_rec[2];

		

		if(tp_btn == "ent")

		{

			var id_rec = id_rec + "_ent";

			$("#" + id_rec).attr("value", vl_cp);

			$("#" + id_rec).focus();

			$("#" + id_rec).select();				

		}

		else

		{

			var id_rec = id_rec + "_sai";

			$("#" + id_rec).attr("value", vl_cp);

			$("#" + id_rec).focus();

			$("#" + id_rec).select();	

		}

		

	}



	function verificaTecla(obj)

	{

		if(event.keyCode == 13)

		{	

			var inputs = $('input[type=text]');

			var flag = obj.id.split("_");

			

			if(flag[1] == "ent")

			{	

				var prox_campo = obj.id.replace("ent","sai");

				$("#" + prox_campo).focus();

			}

			else

			{

				var num_pos = obj.title;

				var num_pos = num_pos * 5;

				inputs[num_pos].focus();

			}

		}

	}

	

	function selCampo(obj)

	{

		$("#" + obj.id).select();

	}



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

				

				

				//verifica aqui se o valor novo é menor que o atual

				if(vl_ent < ult_entrada)

				{

					var flagConfirm=confirm('Valor Incorreto, Deseja repetir ENTRADA?');

					if (flagConfirm==true) 

					{

						var vl_cp = ult_entrada;

						var id_rec = id;



						$("#" + id_rec).attr("value", vl_cp);

						$("#" + id_rec).focus();

						$("#" + id_rec).select();				



					}

					else

					{

						$('#'+id).focus();

						$('#'+id).select();

					}

					

				}

				else

				{

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

					

					

					$("#" + bruto_id).attr("value", bruto); //bruto por maquina

					var ultVlBruto = $('#'+id).attr("label");

					

					var vlAtuTotBruto = $('#total_bruto').attr("value");

					bruto = bruto.replace( ".", "");

					bruto = bruto.replace( ".", "");

					bruto = bruto.replace( ".", "");



					

					vlAtuTotBruto = vlAtuTotBruto.replace( ".", "");

					vlAtuTotBruto = vlAtuTotBruto.replace( ".", "");

					vlAtuTotBruto = vlAtuTotBruto.replace( ".", "");					

					

					novoVlBrutoTot = eval(vlAtuTotBruto) - ultVlBruto + eval(bruto);

					

					//formatar com ponto * novoVlBrutoTot

					novoVlBrutoTot = novoVlBrutoTot.formatNumber(2,',','.');

					novoVlBrutoTot = novoVlBrutoTot.split(",");

					novoVlBrutoTot = novoVlBrutoTot[0];

					

					$("#total_bruto").attr("value", novoVlBrutoTot); 

					

					var ultVlBruto = $('#'+id).attr("value");

					$("#"+id).attr("label", eval(bruto)); 

					

					/*

					//calcula o total de entrada

					var tot_ent_atu =$('#total_entrada').attr("value");

					tot_ent_atu = tot_ent_atu.replace( ".", "");

					tot_ent_atu = tot_ent_atu.replace( ".", "");

					tot_ent_atu = tot_ent_atu.replace( ".", "");				

					bruto = bruto.replace( ".", "");

					bruto = bruto.replace( ".", "");

					bruto = bruto.replace( ".", "");	

					tot_ent_atu = eval(tot_ent_atu) + eval(bruto);

					tot_ent_atu = tot_ent_atu.formatNumber(2,',','.');

					tot_ent_atu = tot_ent_atu.split(",");

					tot_ent_atu = tot_ent_atu[0];				

					$("#total_entrada").attr("value",tot_ent_atu);	

					*/			

				

				}

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

				

				

				//verifica aqui se o valor novo é menor que o atual

				if(vl_sai < ultima_saida)

				{

					var confFlag=confirm('Valor Incorreto, Deseja repetir SAIDA?');

					if (confFlag==true) 

					{

						var vl_cp = ultima_saida;

						var id_rec = id;





						$("#" + id_rec).attr("value", vl_cp);

						$("#" + id_rec).focus();

						$("#" + id_rec).select();				



					}

					else

					{

						$('#'+id).focus();

						$('#'+id).select();

					}

				}

				else

				{

					

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

					

					

					$("#" + premio_id).attr("value",premio);	//premio por maquina

					

					

					var ultVlPremio = $('#'+id).attr("label");

					ultVlPremio = eval(ultVlPremio);

					var vlAtuTotPremio = $('#total_premio').attr("value");

					premio = premio.replace( ".", "");

					premio = premio.replace( ".", "");

					premio = premio.replace( ".", "");





					vlAtuTotPremio = vlAtuTotPremio.replace( ".", "");

					vlAtuTotPremio = vlAtuTotPremio.replace( ".", "");

					vlAtuTotPremio = vlAtuTotPremio.replace( ".", "");

					

					novoVlPremioTot = eval(vlAtuTotPremio) - ultVlPremio + eval(premio);

					

					//formatar com ponto * novoVlBrutoTot

					novoVlPremioTot = novoVlPremioTot.formatNumber(2,',','.');

					novoVlPremioTot = novoVlPremioTot.split(",");

					novoVlPremioTot = novoVlPremioTot[0];					

					$("#total_premio").attr("value", novoVlPremioTot); 

					

					var ultVlPremio = $('#'+id).attr("value");

					

					$("#"+id).attr("label", eval(premio)); 				

					

					/*

					//calcula o total de entrada

					var tot_sai_atu =$('#total_saida').attr("value");

					tot_sai_atu = tot_sai_atu.replace( ".", "");

					tot_sai_atu = tot_sai_atu.replace( ".", "");

					tot_sai_atu = tot_sai_atu.replace( ".", "");				

					premio = premio.replace( ".", "");

					premio = premio.replace( ".", "");

					premio = premio.replace( ".", "");	

					tot_sai_atu = eval(tot_sai_atu) + eval(premio);

					tot_sai_atu = tot_sai_atu.formatNumber(2,',','.');

					tot_sai_atu = tot_sai_atu.split(",");

					tot_sai_atu = tot_sai_atu[0];				

					$("#total_saida").attr("value",tot_sai_atu);

					*/										

				}

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



			

			//calcula o subtotal

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

				var porc_loc = "<?=$result_loc['percentual']?>";

			}

			else

			{

				var porc_loc = pct_maq;

			}



			

			subtot = "'" + subtot + "'";

			subtot = subtot.replace( ".", "");

			subtot = subtot.replace( ".", "");

			subtot = subtot.split(",");

			subtot = subtot[0].replace( "'", "");

			subtot = subtot.replace( "'", "");



			porc_loc = "'" + porc_loc + "'";

			porc_loc = porc_loc.replace( ".", "");

			porc_loc = porc_loc.replace( ".", "");

			porc_loc = porc_loc.split(",");

			porc_loc = porc_loc[0].replace( "'", "");

			porc_loc = porc_loc.replace( "'", "");					

			

			var porc = eval(subtot * porc_loc) / 100;



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

			

			//atribui o total dessa maquina

			subtot = "'" + subtot + "'";

			subtot = subtot.replace( ".", "");

			subtot = subtot.replace( ".", "");			

			subtot = subtot.split(",");

			subtot = subtot[0].replace( "'", "");

			subtot = subtot.replace( "'", "");

			

			porc = "'" + porc + "'";

			porc = porc.replace( ".", "");

			porc = porc.replace( ".", "");			

			porc = porc.split(",");

			porc = porc[0].replace( "'", "");

			porc = porc.replace( "'", "");			

			var tot_por_maq = (subtot - porc);

			

			tot_por_maq = tot_por_maq.formatNumber(2,',','.');

			tot_por_maq = tot_por_maq.split(",");

			

			

			tot_por_maq = tot_por_maq[0];

			var verif = tot_por_maq.indexOf("-");

			if(verif == 0)

			{

				

				var qtd_carc = tot_por_maq.length;

				if(qtd_carc == 5)

				{

					tot_por_maq = tot_por_maq.replace( ".", "");

				}

				else if(qtd_carc == 9)

				{

					tot_por_maq = tot_por_maq.replace( ".", "");				

				}

				else if(qtd_carc == 13)

				{

					tot_por_maq = tot_por_maq.replace( ".", "");				

				}

			}

			

							

			$("#" + totmaq_id).attr("value",tot_por_maq); //total final da maquina

			

			//----------------------------------

			//----- calculo totalizadores-------			

			

			//calcula o total dos subtotais

			var cont = 1;

			var tot_subtot = 0;

			while (cont <= "<?=$NumeroLinhas?>")

			{

			

				var obj_nome = "input[name=" + cont +"_subtot]";

				vl_obj = $(obj_nome).attr("value");

				

				vl_obj = "'" + vl_obj + "'";

				vl_obj = vl_obj.replace( ".", "");

				vl_obj = vl_obj.replace( ".", "");

				vl_obj = vl_obj.replace( "'", "");

				vl_obj = vl_obj.replace( "'", "");

				

				tot_subtot = "'" + tot_subtot + "'";

				tot_subtot = tot_subtot.replace( ".", "");

				tot_subtot = tot_subtot.replace( ".", "");

				tot_subtot = tot_subtot.split(",");

				tot_subtot = tot_subtot[0].replace( "'", "");

				tot_subtot = tot_subtot.replace( "'", "");				

				

				var tot_subtot = eval(tot_subtot) + eval(vl_obj);

				cont = cont + 1;

			}

			

			//subtrai o total de diferenca para efetuar calculos

			var totalDiferenca = $('#tot_vl_dif').attr("value");

			totalDiferenca = totalDiferenca.replace( ".", "");

			totalDiferenca = totalDiferenca.replace( ".", "");

			totalDiferenca = totalDiferenca.replace( ".", "");

			tot_subtot = eval(tot_subtot) - eval(totalDiferenca);

			

			tot_subtot = tot_subtot.formatNumber(2,',','.');

			tot_subtot = tot_subtot.split(",");

			

			

			tot_subtot = tot_subtot[0];

			var verif = tot_subtot.indexOf("-");

			if(verif == 0)

			{

				

				var qtd_carc = tot_subtot.length;

				if(qtd_carc == 5)

				{

					tot_subtot = tot_subtot.replace( ".", "");

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



				tot_porc = "'" + tot_porc + "'";

				tot_porc = tot_porc.replace( ".", "");

				tot_porc = tot_porc.replace( ".", "");

				tot_porc = tot_porc.split(",");

				tot_porc = tot_porc[0].replace( "'", "");

				tot_porc = tot_porc.replace( "'", "");				



				

				var tot_porc = eval(tot_porc) + eval(vl_obj);

				cont = cont + 1;

			}

			

			totalDifLoc = (eval(totalDiferenca) * eval("<?=$result_loc['percentual']?>") / 100);

			tot_porc = eval(tot_porc) - eval(totalDifLoc);

			

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

				

				tot_geral = "'" + tot_geral + "'";

				tot_geral = tot_geral.replace( ".", "");

				tot_geral = tot_geral.replace( ".", "");

				tot_geral = tot_geral.split(",");

				tot_geral = tot_geral[0].replace( "'", "");

				tot_geral = tot_geral.replace( "'", "");				

				

				var tot_geral = eval(tot_geral) + eval(vl_obj);

				cont = cont + 1;

			}



			

			totalDifCala = (eval(totalDiferenca) - eval(totalDifLoc)); 

			tot_geral = tot_geral - totalDifCala;			

			

			

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

			$("#efetivo").attr("value",tot_geral);

			total_pagar();



					

		});		

	};

	



	

	function total_pagar()

	{

	

		var efetivo =$('#total_final').attr("value");

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

		

		deve = "'" + deve + "'";

		deve = deve.replace( ".", "");

		deve = deve.replace( ".", "");

		deve = deve.replace( ".", "");

		deve = deve.split(",");

		deve = deve[0].replace( "'", "");

		deve = deve.replace( "'", "");

		

		efetivo = "'" + efetivo + "'";

		efetivo = efetivo.replace( ".", "");

		efetivo = efetivo.replace( ".", "");

		efetivo = efetivo.replace( ".", "");

		efetivo = efetivo.split(",");

		efetivo = efetivo[0].replace( "'", "");

		efetivo = efetivo.replace( "'", "");				

				

				

			

		var tot_pagar = efetivo - deve;

		

	

		tot_pagar = tot_pagar.formatNumber(2,',','.');

		tot_pagar = tot_pagar.split(",");

		

		

		tot_pagar = tot_pagar[0];

		var verif = tot_pagar.indexOf("-");

		if(verif == 0)

		{

			

			var qtd_carc = tot_pagar.length;

			if(qtd_carc == 5)

			{

				tot_pagar = tot_pagar.replace( ".", "");

				tot_pagar = tot_pagar.replace( ".", "");

				tot_pagar = tot_pagar.replace( ".", "");

			}

			else if(qtd_carc == 9)

			{

				tot_pagar = tot_pagar.replace( ".", "");

				tot_pagar = tot_pagar.replace( ".", "");

				tot_pagar = tot_pagar.replace( ".", "");				

			}

			else if(qtd_carc == 13)

			{

				tot_pagar = tot_pagar.replace( ".", "");

				tot_pagar = tot_pagar.replace( ".", "");

				tot_pagar = tot_pagar.replace( ".", "");			

			}

		}				

		$("#totalapagar").attr("value",tot_pagar);





		//modifica valores de DETALHES

		//verifica foi inserido deve

		if(deve != 0)

		{

			var novo_saldo_deve = (eval(<?=$tem_saldo?>) + eval(deve));

			

			//formata valor para mostrar com ponto

			novo_saldo_deve = novo_saldo_deve.formatNumber(2,',','.');

			novo_saldo_deve = novo_saldo_deve.split(",");

					

			$("#deve_atual").attr("value",novo_saldo_deve[0]);

			var saldo_deve = $('#deve_atual').attr("value");

			var abono =$('#abono').attr("value");

			var saldo_deve = saldo_deve.replace(".","");

			var saldo_deve = saldo_deve.replace(".","");

			var saldo_deve_atual = (eval(saldo_deve) - eval(abono));

			

			//formata valor para mostrar com ponto

			saldo_deve_atual = saldo_deve_atual.formatNumber(2,',','.');

			saldo_deve_atual = saldo_deve_atual.split(",");			

			

			

			saldo_deve_atual = saldo_deve_atual[0];

			var verif = saldo_deve_atual.indexOf("-");

			if(verif == 0)

			{

				

				var qtd_carc = saldo_deve_atual.length;

				if(qtd_carc == 5)

				{

					saldo_deve_atual = saldo_deve_atual.replace( ".", "");

				}

				else if(qtd_carc == 9)

				{

					saldo_deve_atual = saldo_deve_atual.replace( ".", "");				

				}

				else if(qtd_carc == 13)

				{

					saldo_deve_atual = saldo_deve_atual.replace( ".", "");				

				}

			}			

			$("#deve_atual").attr("value",saldo_deve_atual);



		}

		else

		{

			var saldo_ant = eval(<?=$result_dados_deve['saldo']?>);

			var abn_deve = $('#abono').attr("value");

			if(abn_deve=='')

			{

				abn_deve = 0;

			}

			

			var saldo_new = saldo_ant - abn_deve;



			

			//formata valor para mostrar com ponto

			saldo_new = saldo_new.formatNumber(2,',','.');

			saldo_new = saldo_new.split(",");	

			

			$("#deve_atual").attr("value",saldo_new[0]);

			$("#saldo_deve").attr("value",eval(<?=$result_deve['saldo']?>));

		

		}

			



	}

	

	//calculos apartir daqui

	$(document).ready(function(){

	

		$("#datepicker").change(function(event)

		{

			var diaSemana = $('#datepicker').attr("value");

			var diaSemana = diaSemana.split(",");

			var diaMes = diaSemana[0].replace(" ","");

			var diaSemana = diaSemana[1].replace(" ","");

			if(diaSemana !== "Friday")

			{

				alert("ERRO! Ese dia no es valido para Fechamento. Elija un VIERNES!");

				$('#datepicker').attr("value", "");

			}

			else

			{

				var diaMes = diaMes.split("-");

				var diaRef = diaMes[0];

				diaRef = diaRef.replace(" ","");

				diaRef = eval(diaRef);

				diaRef = diaRef / 7;



				if((parseFloat(diaRef) == parseInt(diaRef)) && !isNaN(diaRef))

				{

					diaRef = diaRef;

				} 

				else

				{

					var diaRef = diaRef.toString();

					var diaRef = diaRef.split(".");

					diaRef = eval(diaRef[0]) + 1;

				}

				$('#semMes').attr("value", diaRef);

			}

					

		});

		

						   

		$("#arq_leitura").click(function(event)

							{

								//verifica se foi selecionada uma semana 

								var flagSemana = $("#datepicker").attr("value");

								if(flagSemana == "")

								{

									alert("Debes Elegir el dia de la Lectura.");

									$('#boxes').fadeOut("slow");

									$("#datepicker").focus();

									return false;

								}

								

							

								$('#boxes').fadeIn("slow");

								$('#dialog_3').fadeIn("slow");

								$('#arq_leitura').css('visibility','hidden');

								

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

									

									//retira pontos para gravar no banco de dados

									var vl_obj_ent = vl_obj_ent.replace(".","");

									var vl_obj_ent = vl_obj_ent.replace(".","");

									var vl_obj_ent = vl_obj_ent.replace(".","");

									

									var vl_obj_sai = vl_obj_sai.replace(".","");

									var vl_obj_sai = vl_obj_sai.replace(".","");

									var vl_obj_sai = vl_obj_sai.replace(".","");																		

																	

									

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

								var saldo_deve = saldo_deve.replace(".","");

								var saldo_deve = saldo_deve.replace(".","");



								

								var deve = $("#deve").attr("value");

								var obs = $("#obs").attr("value");

								var abn_dev = $("#abono").attr("value");

								var semSel = $("#semMes").attr("value");

								//pegar data de fechamento e passar para guardar

								var diaFecha = $("#datepicker").attr("value");

								diaFecha = diaFecha.split(",");

								diaFecha = diaFecha[0];

								

								//busca faturamento bruto

								var fatBruto = $("#total_subtot").attr("value");

								var fatBruto = fatBruto.replace(".","");

								var fatBruto = fatBruto.replace(".","");

								var fatBruto = fatBruto.replace(".","");								

								

								$('<div id="agd_proc_leitura" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');

								$("#arq_leitura").attr('disabled','disabled');

								$.post('add_leitura.php', {loc:id_loc,ids:ids_maq,vl_maq:param_leitura,qtd:num_lin,dev:deve,sld_dev:saldo_deve,obs:obs,abono:abn_dev,semana:semSel,dia_fecha:diaFecha,fat_bruto:fatBruto},function(json){

									$("#arq_leitura").attr('disabled','');

									$("#agd_proc_leitura").remove();

									if(json=='Leitura cadastrada com sucesso!')

									{

										$("#lc_nome").val("");

										alert(json);

										location="leitura.php";

									}

									else

									{

										alert(json);

										location.reload();

									}

								});

							});						   					   

	});	



	







	 $(document).ready(function() {

	

	 //importacao

	$("#importar").click( function () {

		

		document.forms["imp_leit"].submit();

	});

	



	 //chama add diferenca

	$("#form_add_dif").click( function () {

		$('#dialog_4').fadeOut("slow");

		$('#dialog_5').fadeIn("slow");

	

	});

	

	 //add diferenca

	$("#add_diferenca").click( function () {



		//$('#dialog_4').fadeIn("slow");

		



		var maqDif = $("#lc_reg").attr("value");

		var vlDif = $("#nv_vl_dif").attr("value");

		var tpMot = $("#tpDif").attr("value");

		var motDif = $("#motivo_dif").attr("value");

		//$('input:radio[name="nomequalquer"][value="valor"]').attr("checked",true);

		

		if(tpMot == 1)

		{

			vlDif = vlDif * (-1);

		}

		

		var confDif=confirm('Deseja adicionar diferenca?');

		

		

		

		if (confDif==true) 

		{

			jQuery.ajax(

			{

				type: "POST", // Defino o método de envio POST / GET

				url: 'add_diferenca.php', // Informo a URL que será pesquisada.

				data: 'id_maq='+maqDif+'&valorDif='+vlDif+'&motivo='+motDif,

				//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",

				success: function(html)

				{

					var resul=html.split("/");

					var ult_id_ins = resul[1];

					if(resul[0] == "true")

					{

						

						//$('#lc_reg').attr("value", "");

						$('#nv_vl_dif').attr("value", 0);

						

						//atribui total de diferencas

						var vl_ant_dif = $('#tot_vl_dif').attr("value");

						

						//remove pontos para calculo

						var vl_ant_dif = vl_ant_dif.replace(".","");

						var vl_ant_dif = vl_ant_dif.replace(".","");

						var vl_ant_dif = vl_ant_dif.replace(".","");

						

						if(vlDif < 0)

						{

							vlDif = vlDif  * (-1);

							var cor = "blue";

							

							var totDifPosit = $('#tot_dif_pos').attr("value");

							var totDifPosit = totDifPosit.replace(".","");

							var totDifPosit = totDifPosit.replace(".","");

							var totDifPosit = totDifPosit.replace(".","");							

							totDifPosit = eval(totDifPosit) + eval(vlDif);



							totDifPosit = totDifPosit.formatNumber(2,',','.');

							totDifPosit = totDifPosit.split(",");

							totDifPosit = totDifPosit[0];



							$('#tot_dif_pos').attr("value", totDifPosit);

						}

						else

						{

							//tot_dif_neg

							vlDif = vlDif  * (-1);

							var cor = "red";

							var totDifNegat = $('#tot_dif_neg').attr("value");

							var totDifNegat = totDifNegat.replace(".","");

							var totDifNegat = totDifNegat.replace(".","");

							var totDifNegat = totDifNegat.replace(".","");							

							totDifNegat = eval(totDifNegat) + eval(vlDif);



							totDifNegat = totDifNegat.formatNumber(2,',','.');

							totDifNegat = totDifNegat.split(",");

							totDifNegat = totDifNegat[0];



							$('#tot_dif_neg').attr("value", totDifNegat);					

						}

												

						var vl_nov_dif = eval(vl_ant_dif) + eval(vlDif);

						

						//formata numero para mostrar em tela

						vl_nov_dif = vl_nov_dif.formatNumber(2,',','.');

						vl_nov_dif = vl_nov_dif.split(",");

						vl_nov_dif = vl_nov_dif[0];

						

						

						

						

												

						$('#tot_vl_dif').attr("value", vl_nov_dif);



						

						//formata valor da dif

						vlDif = eval(vlDif);

						vlMostraDif = vlDif.formatNumber(2,',','.');

						vlMostraDif = vlMostraDif.split(",");

						vlMostraDif = vlMostraDif[0];	

							

							



						idLinhaDifLeit = eval(ult_id_ins) + 100;

						

						//adiciona linha para subtrair diferenca

						$("#tb_list_maq_leit tbody").append("<tr id='"+idLinhaDifLeit+"' bgcolor='#FFCC99' height='21px;' style='font-weight:bolder' align='center'><td colspan='2'>Diferenca</td><td colspan='2'>Descricao: </td><td>"+motDif+"</td><td ><font color='"+cor+"'>"+vlMostraDif+"</font></td><td>&nbsp;</td><td>&nbsp;</td></tr>");



						

						$("#tb_list_dif tbody").append("<tr id='"+ult_id_ins+"' bgcolor='#F5F8F9' height='21px;'style='font-weight:bolder' align='center'><td style='padding:5px;' align='center' width='28%'>"+maqDif+"</td><td style='padding:5px;' align='center' width='28%'>"+motDif+"</td><td style='padding:5px;' align='center' width='28%'>$ "+vlDif+"</td><td style='padding:5px;' align='center' width='16%'><a style='cursor:pointer;'><img id='"+ult_id_ins+"' name='exdif' src='img/inativo.png' width='11' title='"+vlDif+"' onclick='excluiItem(this);' /></a></td></tr>"); 						

						

						

						

						

						//subtrair valor de diferenca do subtotal

						var subTotSemDif = $('#total_subtot').attr("value");

						var subTotSemDif = subTotSemDif.replace(".","");

						var subTotSemDif = subTotSemDif.replace(".","");

						var subTotSemDif = subTotSemDif.replace(".","");



						

						nvVlSubTot = eval(subTotSemDif) + eval(vlDif);

						



						var vlPctLocSemDif = (eval(nvVlSubTot) * eval("<?=$result_loc['percentual']?>")) / 100;

						var vlPctCalaSemDif = eval(nvVlSubTot) - eval(vlPctLocSemDif);



						nvVlSubTot = nvVlSubTot.formatNumber(2,',','.');

						nvVlSubTot = nvVlSubTot.split(",");

						nvVlSubTot = nvVlSubTot[0];

						

						vlPctLocSemDif = vlPctLocSemDif.formatNumber(2,',','.');

						vlPctLocSemDif = vlPctLocSemDif.split(",");

						vlPctLocSemDif = vlPctLocSemDif[0];

						

						vlPctCalaSemDif = vlPctCalaSemDif.formatNumber(2,',','.');

						vlPctCalaSemDif = vlPctCalaSemDif.split(",");

						vlPctCalaSemDif = vlPctCalaSemDif[0];												

												

						$('#total_subtot').attr("value", nvVlSubTot);

						$('#total_porcentagem').attr("value", vlPctLocSemDif);

						$('#total_final').attr("value", vlPctCalaSemDif);



						//mudar os valores do totalizador

						$('#efetivo').attr("value", $("#total_final").attr("value"));

						total_pagar();

						$('#dialog_4').fadeOut("slow");

						$('#dialog_5').fadeOut("slow");

						$('#boxes').fadeOut("slow");

						

						

						$("#motivo_dif").attr("value","");

						$("#nv_vl_dif").attr("value","");

						$("#lc_reg").attr("value",0);

						$("#tpDif").attr("value",1);

						

						

						/*

						var maqDif = $("#lc_reg").attr("value");

						var vlDif = $("#nv_vl_dif").attr("value");

						var tpMot = $("#tpDif").attr("value");

						var motDif = $("#motivo_dif").attr("value");

						*/

					}

					else

					{

						alert("Erro! Problema para inserir Diferenca!");

					}

				}

			});

		}

		else

		{

			return false;

		}		

	});

	

	

	 //importacao

	$("#online").click( function () {

		location="arquivo/uploader_leitura_online.php?a=<?= $list_plaq ?>&b=<?= $cont_plaq ?>&c=<?=$id_assoc?>";

	});		

	

	 //importacion

	$("#rep_leit").click( function () {

		location="leitura_rua.php?id="+<?=$id_assoc?>+"&rep=1";

	});

	

	//rendicao

	$("#list_todas_desp").click(function()

	{

		$('#dialog_4').fadeOut("slow");

		$('#dialog_5').fadeOut("slow");

		$('#boxes').fadeIn("slow");

		$('#dialog').fadeIn("slow");

	});

	

	

	$("#add_dif").click(function()

	{

		$('#dialog').fadeOut("slow");

		$('#boxes').fadeIn("slow");

		$('#dialog_4').fadeIn("slow");

	});	

	

	//rendicao

	$("#cancelar").click(function()

	{

		$('#boxes').fadeOut("slow");

		$('#dialog').fadeOut("slow");

		$('#dialog_4').fadeOut("slow");

		$('#dialog_5').fadeOut("slow");

	});	

	

	$("#cancelar_dif").click(function()

	{

		$('#boxes').fadeOut("slow");

		$('#dialog').fadeOut("slow");

		$('#dialog_4').fadeOut("slow");

		$('#dialog_5').fadeOut("slow");

	});		

	

	//rendicao

	$("#add_desp").click(function()

	{

			$('#dialog').fadeOut("slow");

			$('#dialog_2').fadeIn("slow");

	});

			

	

	//rendicao

	$("#voltar").click(function()

	{

		$('#dialog_2').fadeOut("slow");

		$('#dialog').fadeIn("slow");

	});

	

	

	//rendicao

	$("#voltar_dif").click(function()

	{

		$('#dialog_5').fadeOut("slow");

		$('#dialog_4').fadeIn("slow");

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

			type: "POST", // Defino o método de envio POST / GET

			url: 'add_despesa_leitura.php', // Informo a URL que será pesquisada.

			data: 'cent_cust='+cc+'&valor='+vl+'&descricao='+dc+'&tipo_doc='+td+'&numero_doc='+nd+'&oper='+op,

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

					

												

					$("#tb_list_desp tbody").append("<tr id='"+ult_id_ins+"' bgcolor='#F5F8F9' height='21px;'style='font-weight:bolder' align='center'><td style='padding:5px;' align='center' width='28%'>"+nd+"</td><td style='padding:5px;' align='center' width='28%'>"+dc+"</td><td style='padding:5px;' align='center' width='28%'>$ "+vf+"</td><td style='padding:5px;' align='center' width='16%'><a style='cursor:pointer;'><img id='"+ult_id_ins+"' name='exdesc' src='img/inativo.png' width='11' title='"+vl+"' onclick='excluiItem(this);' /></a></td></tr>"); 

					

					//limpa valores

					limpa_val();

					var vl_atu_desp = $('#despesa').attr("value");

					

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

					

					$("#despesa").attr("value",vl_atu_desp);

					$("#totalapagar").attr("value",vl_atu_total);



				}

				else

				{

					alert("Erro! Problema para inserir Despesa!");

				}

			}

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



	//exclui despesa

	function excluiItem(obj)

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

					//alert("Despesa Removida com suceso!");

					$('#' + obj.id).remove();

					var vl_atu_desp = $('#despesa').attr("value");

					

					var vl_atu_desp = vl_atu_desp.replace(".","");

					var vl_atu_desp = vl_atu_desp.replace(".","");

					var vl_atu_desp = vl_atu_desp.replace(".","");

					

					var vl_atu_desp = eval(vl_atu_desp) - eval(obj.title);

					var vl_atu_total = $('#totalapagar').attr("value");

					

					var vl_atu_total = vl_atu_total.replace(".","");

					var vl_atu_total = vl_atu_total.replace(".","");

					var vl_atu_total = vl_atu_total.replace(".","");					

					

					var vl_atu_total = eval(vl_atu_total) + eval(obj.title);					

					

					

				





					

					if(obj.name == "exdif")

					{

						var itemExcluir = eval(obj.id) + 100;

						$('#' + itemExcluir).remove();

						

						

						var efetivo = $('#efetivo').attr("value");

						var efetivo = efetivo.replace(".","");

						var efetivo = efetivo.replace(".","");

						var efetivo = efetivo.replace(".","");

						

						efetivo = efetivo - eval(obj.title);

					

						efetivo = efetivo.formatNumber(2,',','.');

						efetivo = efetivo.split(",");

						efetivo = efetivo[0];						

						

						$("#efetivo").attr("value",efetivo);





						var totalapagar = $('#totalapagar').attr("value");

						var totalapagar = totalapagar.replace(".","");

						var totalapagar = totalapagar.replace(".","");

						var totalapagar = totalapagar.replace(".","");

						

						totalapagar = totalapagar - eval(obj.title);

					

						totalapagar = totalapagar.formatNumber(2,',','.');

						totalapagar = totalapagar.split(",");

						totalapagar = totalapagar[0];						

						

						$("#totalapagar").attr("value",totalapagar);

						

						var valordif = eval(obj.title);

						

						if(valordif > 0)

						{

							var tot_dif_pos = $('#tot_dif_pos').attr("value");

							var tot_dif_pos = tot_dif_pos.replace(".","");

							var tot_dif_pos = tot_dif_pos.replace(".","");

							var tot_dif_pos = tot_dif_pos.replace(".","");

							

							tot_dif_pos = tot_dif_pos - eval(obj.title);

						

							tot_dif_pos = tot_dif_pos.formatNumber(2,',','.');

							tot_dif_pos = tot_dif_pos.split(",");

							tot_dif_pos = tot_dif_pos[0];						

							

							$("#tot_dif_pos").attr("value",tot_dif_pos);						

						}

						else

						{

							var tot_dif_neg = $('#tot_dif_neg').attr("value");

							var tot_dif_neg = tot_dif_neg.replace(".","");

							var tot_dif_neg = tot_dif_neg.replace(".","");

							var tot_dif_neg = tot_dif_neg.replace(".","");

							

							tot_dif_neg = tot_dif_neg - eval(obj.title);

						

							tot_dif_neg = tot_dif_neg.formatNumber(2,',','.');

							tot_dif_neg = tot_dif_neg.split(",");

							tot_dif_neg = tot_dif_neg[0];						

							

							$("#tot_dif_neg").attr("value",tot_dif_neg);							

						}

						

						//



						

						

						//

						var tot_vl_dif = $('#tot_vl_dif').attr("value");

						var tot_vl_dif = tot_vl_dif.replace(".","");

						var tot_vl_dif = tot_vl_dif.replace(".","");

						var tot_vl_dif = tot_vl_dif.replace(".","");

						

						tot_vl_dif = tot_vl_dif - eval(obj.title);

					

						tot_vl_dif = tot_vl_dif.formatNumber(2,',','.');

						tot_vl_dif = tot_vl_dif.split(",");

						tot_vl_dif = tot_vl_dif[0];						

						

						$("#tot_vl_dif").attr("value",tot_vl_dif);												

						



						//

						var total_subtot = $('#total_subtot').attr("value");

						var total_subtot = total_subtot.replace(".","");

						var total_subtot = total_subtot.replace(".","");

						var total_subtot = total_subtot.replace(".","");

						

						total_subtot = total_subtot - eval(obj.title);

					

						total_subtot = total_subtot.formatNumber(2,',','.');

						total_subtot = total_subtot.split(",");

						total_subtot = total_subtot[0];						

						

						$("#total_subtot").attr("value",total_subtot);						

					}

					else

					{



						vl_atu_desp = vl_atu_desp.formatNumber(2,',','.');

						vl_atu_desp = vl_atu_desp.split(",");

						vl_atu_desp = vl_atu_desp[0];

						

						vl_atu_total = vl_atu_total.formatNumber(2,',','.');

						vl_atu_total = vl_atu_total.split(",");

						vl_atu_total = vl_atu_total[0];						

					

						$("#despesa").attr("value",vl_atu_desp);

						$("#totalapagar").attr("value",vl_atu_total);

					}						

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

						desconto_leit_fecha.id_leitura_fechamento = 0

					AND

						desconto_leit_fecha.leitura = 1

					AND

						desconto_leit_fecha.id_maquina = 0

					AND

						desconto_leit_fecha.id_login = " . $_SESSION['id_login'];



					

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

								<img id='".$result_desp_leit['id_desconto']."' name='exdesc' src='img/inativo.png' width='11' title='".$result_desp_leit['valor_desconto']."' onclick='excluiItem(this);' />

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

        

        <!--- form de insercao de despesa --->

        <div id="dialog_2" class="window" style="width:35%;height:70%;background-color:#eeeeee;margin-left:30%; margin-top:10%;">

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

            <a name='modal' id='voltar' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:15%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

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

        <div id="dialog_3" class="window" style="width:210px;height:30px;background-color:#eeeeee;margin-left:40%;margin-top:20%;">

			... Processando ...<br /><img src='img/aguarde.gif' align='aguarde' alt='aguarde'>

        </div>

        

        

        

        <div id="dialog_4" class="window" style="width:40%;height:350px;background-color:#eeeeee;margin-left:30%; margin-top:10%;">

        	<div style="width:105%;height:12%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative; left:-3%;">

				<div style="position:absolute; margin-left:5%; left:0px; margin-top:2%;">

                	Diferencas de Leitura

                </div>

            </div>            

            <div style="overflow:auto;width:100%;height:55%;position:absolute; margin-top:5%; left:0px;" align="center">

            

		<table  id='tb_list_dif' width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:10px;'>

            <tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>

                <th style='color:#E17009;' width="28%">Maquina</th>

                <th style='color:#E17009;' width="28%">Motivo </th>

                <th style='color:#E17009;' width="28%">Valor </th>

                <th style='color:#E17009;' width="16%"><img src="img/lixeira.png" /> </th>

            </tr>

            

            <?php

				//aqui consultar despesas de leitura desse usuario que nao tenham id de leitura

				$sql_dif_leit = "

					SELECT

						desconto_leit_fecha.*,

						vw_maquinas.codigo,

						vw_maquinas.numero

					FROM

						`desconto_leit_fecha`

					INNER JOIN 

						vw_maquinas

					ON

						desconto_leit_fecha.id_maquina = vw_maquinas.id_maquina

					WHERE

						desconto_leit_fecha.id_leitura_fechamento = 0

					AND

						desconto_leit_fecha.leitura = 1

					AND

						desconto_leit_fecha.id_maquina <> 0

					AND

						desconto_leit_fecha.id_login = " . $_SESSION['id_login'];



					

				$query_dif_leit=@mysql_query($sql_dif_leit);

				//$result_desp_leit=@mysql_fetch_assoc($query_desp_leit);				

			

				while($result_dif_leit=@mysql_fetch_assoc($query_dif_leit)) 

				{

				

					// verifica valor para ser mostrado

					$val_dif = $result_dif_leit['valor_desconto'];

					$val_dif = $val_dif * (-1);

				

					echo "<tr id='".$result_dif_leit['id_desconto']."' bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>         

							<td style='padding:5px;' align='center' width='28%'>

								".$result_dif_leit['codigo']." - ".$result_dif_leit['numero']."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								".$result_dif_leit['descricao']."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								$ ".number_format($val_dif,0,"",".")."

							</td>

							<td style='padding:5px;' align='center' width='28%'>

								<a style='cursor:pointer;'>

								<img id='".$result_dif_leit['id_desconto']."' name='exdif' src='img/inativo.png' width='11' title='".$result_dif_leit['valor_desconto']."' onclick='excluiItem(this);' />

								</a>

							</td>							                                

						</tr>"; 

				}			

  

			?>

                                                                                                

		</table>            





            

         

            </div>

            <div  style=" width:90%;height:20%;position:absolute;bottom:0px;">

                <hr />

                <br />

                <a name='modal' id='cancelar_dif' name='cancelar_dif' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:10%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                    &nbsp;&nbsp;

                    <img src='img/inativo.png' width='10' border='0' />

                    <strong> Fechar </strong>

                </a>        

                <a name='modal' id="form_add_dif" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:40%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                    &nbsp;&nbsp;

                    <img src='img/ativo.png' width='10' border='0' />

                    <strong> Adicionar </strong>

                </a>            

            </div>

        </div>

        

        <div id="dialog_5" class="window" style="width:35%;height:60%;background-color:#eeeeee;margin-left:30%; margin-top:10%;">

        	<div style="height:15%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative">

				<div style="position:absolute; margin-left:5%; margin-top:2%;">

                	Adicionar Diferenca na Leitura

                </div>

            </div>

            <div style="width:40%;position:absolute; margin-top:5%;" align="right">

            	<table>

                	<tr height="30px;">

                    	<td align="right"><strong>Maquina: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Tipo Diferenca: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Valor: &nbsp; </strong></td>

                    </tr>

                	<tr height="30px;">

                    	<td align="right"><strong>Motivo: &nbsp; </strong></td>

                    </tr>

                                                                               

                </table>

            </div>

            <div style="width:60%;position:absolute;left:40%;margin-left:10px;margin-top:5%;" align="left">

            	<table>

                	<tr height="30px;">

                    	<td>

                        	<?php

                            //Regiao

                            $sql_reg = "

                                SELECT

                                    vw_maquinas.id_maquina,

                                    vw_maquinas.numero,

                                    vw_maquinas.codigo

                                FROM

                                    vw_maquinas

                                WHERE

                                    vw_maquinas.id_local = ".$id_assoc."

                                GROUP BY

                                    vw_maquinas.id_maquina

                                ORDER BY

                                    vw_maquinas.numero

                            ";

                            $query_reg = @mysql_query($sql_reg);

                            //Montando as Combos de regiaoes.

                            $reg = '';

							$reg.= "\n\t\t\t\t\t<option value='0'>Selecionar</option>";							

							

                            while ( $dados_reg=@mysql_fetch_assoc($query_reg) ) {

                                $reg.= "\n\t\t\t\t\t<option value='".$dados_reg['id_maquina']."'>".$dados_reg['codigo']."-".$dados_reg['numero']."</option>";

                            }

                            echo "\n\t\t\t\t<select name='lc_reg' id='lc_reg'  style='width:80px;font-size:12px;' onfocus=\"$('#info_lc_ope').css({'visibility':'visible'});\" onblur=\"$('#info_lc_ope').css({'visibility':'hidden'});\">";

                            echo $reg;

                            echo "\n\t\t\t\t</select>";

							?>                

                        </td>

                    </tr>

                	<tr height="30px;">

                    	<td>

                            <select name='tpDif' id='tpDif'  style='width:80px;font-size:12px;' >



                              <option value='1'>Positiva</option>

                              <option value='2'>Negativa</option>



                            </select>

                        </td>

                    </tr>

                	<tr height="30px;">

                    	<td>

                            <input type="text" id="nv_vl_dif" name="nv_vl_dif" size="8"  />                    

                        </td>

                    </tr>

                	<tr height="30px;">

                    	<td>

                            <input type="text" id="motivo_dif" name="motivo_dif" size="35"  />

                        </td>

                    </tr>                                                                              

                </table>

            </div>

            <div style=" width:100%;height:20%;position:absolute;bottom:0px;">

            <br />

            <a name='modal' id='voltar_dif' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:15%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                &nbsp;&nbsp;

                <strong> &nbsp;&nbsp;<< Voltar </strong>

            </a>      

            <a name='modal' id="add_diferenca" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:35%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>

                &nbsp;&nbsp;

                <img src='img/ativo.png' width='10' border='0' />

                <strong> &nbsp;Inserir</strong>

	        </a>            

        	</div>

        </div>        

        

        

        

        

        

        

        <div id="mask">

        </div>

</body>

</html>