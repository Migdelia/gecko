<?php

session_start();

include('../conn/conn.php');

include('../functions/lg_validador.php');

include('../functions/functions.php');



//Verifica se deve salvar o relatorio personalizado

if ( $_GET['ida']==base64_encode('salvar') ) {

	//Gravando o relatorio

	$pers = "INSERT INTO relatorios (id_login, nome, area, query, ordem, tipo, excluido) VALUES ('".$_SESSION['id_login']."','".($_POST['nome_rel']==''?date('Y_m_d')."_".date('H_m_s'):$_POST['nome_rel'])."','Relatorios',\"".base64_decode($_POST['salvar_rel'])."\",'9999','".$_SESSION['usuario']."','N')";

	@mysql_query($pers);

	$_GET['ida'] = @mysql_insert_id();

}



//Pegando o relatorio solicitado

if ( $_GET['ida']==base64_encode('personalizado') ) {

	$select='SELECT ';

	

	//Verificando se utiliza apenas registros do Ano corrente

	$curyear = '';

	if ($_POST['ano_corrente']=='on') {

		$curyear = " 

			(YEAR(vw_relatorios.data_pagamento)='".date('Y')."' OR YEAR(vw_relatorios.data_vencimento)='".date('Y')."' )";

	}

	unset($_POST['ano_corrente']);	

	

	//Selecionando os campos da Tabela

	$cmps = '';

	foreach ($_POST as $chv=>$vlr) {

		if ($vlr=='on') {

			if (strstr($chv,'data')) {

				$cmps.= " DATE_FORMAT(vw_relatorios.".$chv.",'%d/%m/%Y') AS ".$chv.",";

			}else{

				$cmps.= " vw_relatorios.".$chv.",";

			}

		}

	}

	$select.= substr(($cmps==''?' vw_relatorios.* ':$cmps),0,-1);

	

	//Criterio da restri�ao de acesso

	$criterio=" FROM vw_relatorios WHERE vw_relatorios.id_regional IN ([PERMISSAO]) ".($curyear!=''?"AND ":"").$curyear." AND(";

	

	//Montando os criterios da Pesquisa

	for ($i=1;$i<=$_SESSION['qtd_pesquisa_relatorio'];$i++) {

		if ( (trim($_POST['item_'.$i])!='')&&(trim($_POST['pesquisa_'.$i])!='') ) {

			//Caso seja data. formata para o padrao Americano

			if (strstr($_POST['pesquisa_'.$i],'data')) {

				$_POST['item_'.$i] = ConverteData( $_POST['item_'.$i], "US" );

			}

			

			//Caso seja LIKE / NOT LIKE

			if ( strstr($_POST['acao_'.$i],'LIKE') ) {

				$_POST['item_'.$i]="%".$_POST['item_'.$i]."%";

			}

			

			$criterio.= " ".$_POST['pesquisa_'.$i]." ".$_POST['acao_'.$i]." '".RetirarAcentos ($_POST['item_'.$i])."'  ".$_POST['EOU_'.$i];

		}

	}

	

	//Terminando a Query

	$select.= substr($criterio,0,-7).")";

	$relatorios = str_replace("[PERMISSAO]",$_SESSION['reg_acesso'],$select);

	//echo $relatorios;

}else{

	$sql_rel = "

		SELECT

			relatorios.id_relatorio,

			relatorios.id_login,

			relatorios.nome,

			relatorios.area,

			relatorios.tabela,

			relatorios.campos,

			relatorios.criterios,

			relatorios.ordenacao,

			relatorios.`query`,

			relatorios.ordem,

			relatorios.tipo,

			relatorios.excluido

		FROM

			relatorios

		WHERE

			relatorios.id_relatorio='".$_GET['ida']."'

	";

	

	$query_rel = @mysql_query($sql_rel);



	//Query da consulta

	while ($result_relatorio=@mysql_fetch_assoc($query_rel) ) {

		$report = $result_relatorio['nome'];

		$relatorios = $result_relatorio['query'];

		
		$idRel = $result_relatorio['id_relatorio'];
		//adiciona a condicao da data

		if($result_relatorio['id_relatorio'] == 2 )
		{

			$mesInicio = $_GET['mesFecha'] - 1;

			$mesFinal = $_GET['mesFecha'] + 1;

			$dataInicio = $_GET['anoFecha'] . "-" . $mesInicio . "-" . "31";

			$dataFinal = $_GET['anoFecha'] . "-" . $mesFinal . "-" . "01";

			$where = " AND

						leitura.semana = ". $_GET['semFecha'] ."

					AND

						(leitura.data_fechamento > '".$dataInicio."'

					AND

						leitura.data_fechamento < '".$dataFinal."')

					GROUP BY

						leitura.id_local

					ORDER BY

						`local`.nome";

			$relatorios = $relatorios . $where;

				

		}
		else if($result_relatorio['id_relatorio'] == 3)
		{
			$mesInicio = $_GET['mesFecha'] - 1;

			$mesFinal = $_GET['mesFecha'] + 1;

			$dataInicio = $_GET['anoFecha'] . "-" . $mesInicio . "-" . "31";

			$dataFinal = $_GET['anoFecha'] . "-" . $mesFinal . "-" . "01";

			$where = " AND

						leitura.semana = ". $_GET['semFecha'] ."

					AND

						(leitura.data_fechamento > '".$dataInicio."'

					AND

						leitura.data_fechamento < '".$dataFinal."')
					GROUP BY
					
						leitura.id_login
						
					ORDER BY
						promedio_total DESC,
						promedio_com_leitura DESC";

			$relatorios = $relatorios . $where;			
		}


		//echo $relatorios . "<br />";

		//Verifica se tem criterios com WHERE para setar na listagem apenas as regionais as quais a pessoa tem acesso

		$relatorios = str_replace("[PERMISSAO]",$_SESSION['reg_acesso'],$relatorios);

	}

	

}

//echo $relatorios . "<br />";


//exit($relatorios." LIMIT 5");

//if( !$query = @mysql_query($relatorios." LIMIT 15") ) {

if( !$query = @mysql_query($relatorios) ) {

	exit("<strong>Ocorreu um erro ao processar este relatorio.<br>Entre em contato com o Administrador do sistema e informe <span style='text-decoration:blink;color:#990000'>ERRO:".$_GET['ida']."</span> de relatorio</strong>");

}

$registros = number_format(@mysql_num_rows( @mysql_query($relatorios) ),0,',','.');

//$tabela="<button type='button' class='bt-enviar' onclick=\"window.location='gera_xml_repasse.php?c=".base64_encode($lote_re)."&d=".md5('save_file')."';\">Download</button>";



//Comentado Temporariamente * Erico 

/* 

$tabela="\n\t\t\t\t\t\t\t<strong style='font-size:12px'>Relat&oacute;rios - Pr&eacute;-visualiza&ccedil;&atilde;o: Visualize as colunas que o relat&oacute;rio possui.&nbsp;&nbsp;&nbsp;";

*/



//Caso nao seja personalizado, exibe a op�ao de download

if ( $_GET['ida']!=base64_encode('personalizado') ) {

	

	//comentado o download do relatorio temporariamente * Erico 

	/*$tabela.="\n\t\t\t\t\t\t\t<a id='gerar_xls' href='functions/gera_xls.php?ida=".base64_encode($_GET['ida'])."' onclick=\"alert('ATEN�AO!!!\\n\\nA gera�ao do download pode demorar varios minutos.\\nClique e agurade o t�rmino do processamento.\\n');\">Download - / ".$report."</a><br />";*/

}else{

	$tabela.="\n\t\t\t\t\t\t\t<br />Salvar o Relatorio: <input type='text' name='nome_rel' id='nome_rel' size='25' maxlength='25' value=''> ";

	$tabela.="\n\t\t\t\t\t\t<button id='btn_salvar_relatorio' type='button' class='bt-enviar'>Salvar</button>&nbsp;&nbsp;&nbsp;&nbsp;";

	$tabela.="\n\t\t\t\t\t\t\t<input type='hidden' id='salvar_rel' name='salvar_rel' value='".base64_encode($select)."'> ";

}



//tabela do conteudo * Erico 







//$tabela.= "(".$registros."Registro".($registros>1?"s":"").")</strong>";



//mostra semana do relatorio



$tabela.= "Semana: " . $_GET['semFecha'];

$tabela.= " del: " . $_GET['mesFecha'];

$tabela.= "-" . $_GET['anoFecha'];



$tabela.="\n\t<table cellspacing='0px' cellpadding='0px' style='margin-top:10px;' width='95%' >";

$val=true;

$somaPct = 0;
$totFatBruto = 0;
while ( $Dados=mysql_fetch_assoc($query) ) {

	//Montando o Cabe�alho

	$cor=($cor=='#DBE5F1'?"#FFFFFF":"#DBE5F1");

	if ($cont==0) {

		//Pegando o titulo de cada coluna de cabe�alho

		$tabela.="\n\t\t<tr>";

		$n_campos= @mysql_num_fields($query);

		$filtro=array('STR_','_');

		for ($i=0;$i<$n_campos;$i++ ) {

			$cmp = @mysql_field_name($query,$i);

			if($cmp !== "id_local" and $cmp !== "id_leitura_parceiro")

			{

				$tabela.="\n\t\t\t<th>".str_replace(' ','<br />',(strtoupper(str_replace($filtro,' ',$cmp))))."</th>";

			}

		}

		$tabela.="\n\t\t</tr>";

	}

	//Pegando o conteudo das Colunas

	$tabela.="\n\t\t<tr style='background-color:".$cor.";' >";



	//verifica se � faturamento * Erico 

	foreach($Dados as $chv=>$vlr) {

		

		if ( trim($vlr=='') ){

			$vlr="&nbsp;";

		}

		$chv=strtoupper($chv);




		if($chv == "FATURAMENTO_BRUTO")

		{

			$tabela.="\n\t\t\t<td>".number_format($vlr,0,"",".")."</td>";	

		}

		else if($chv == "ID_LOCAL")

		{

			//consulta/soma se as maquinas do parceiro nesse local tem diferenca .

			$sql_dif = "

				SELECT 

					SUM(desconto_leit_fecha.valor_desconto) as diferenca

				FROM 

					desconto_leit_fecha

				INNER JOIN

					leitura

				ON

					desconto_leit_fecha.id_leitura_fechamento = leitura.id_leitura

				INNER JOIN

					maquinas

				ON

					desconto_leit_fecha.id_maquina = maquinas.id_maquina

				WHERE

					leitura.semana = ". $_GET['semFecha'] ."

				AND

					(leitura.data_fechamento > '".$dataInicio."'

				AND

					leitura.data_fechamento < '".$dataFinal."')

				AND

					leitura.id_local = ". $vlr ."

				AND

					desconto_leit_fecha.leitura = 1

				AND

					maquinas.parceiro = 1

					";

			

			$query_dif= @mysql_query($sql_dif);

			$resul_dif= @mysql_fetch_assoc($query_dif);			

			

			

			//echo $resul_dif['diferenca'] . "<br />";

			

			//buscar diferenca desse local em maquina do parceiro

			if($resul_dif['diferenca'] == "")

			{

				$tot_diferenca = 0; // proporcional ao porcentagem da calabaza

			}

			else

			{

				//consulta a porcentagem desse local para calcular a porcentagem proporcional de diferenca
				$sql_pct_loc = "

					SELECT 

						local.percentual

					FROM 

						local

					WHERE

						local.id_local =" . $vlr;

				

				$query_pct_loc= @mysql_query($sql_pct_loc);

				$resul_pct_loc= @mysql_fetch_assoc($query_pct_loc);					

				

				//calcula a diferenca proporcional

				$pctPropria = 100 - $resul_pct_loc['percentual'];

				$tot_diferenca = (($resul_dif['diferenca'] * $pctPropria) / 100);

			}

		}		

		else if($chv == "MEDIA_POR_MAQ")
		{

			$tabela.="\n\t\t\t<td> $ ".number_format($vlr,0,"",".")."</td>";	

		}

		else if($chv == "TOTAL")

		{

			$totalConDesconto = $vlr - $tot_diferenca;	

			$tabela.="\n\t\t\t<td> $ ".number_format($totalConDesconto,0,"",".")."</td>"; 

			$subTotal = $subTotal + $totalConDesconto;

		}
		else if($chv == "QTD_MAQUINAS_LEITURA")
		{

			$tabela.="\n\t\t\t<td>" . RetirarAcentos ($vlr)."</td>";	

			$qtdMaq = $qtdMaq + $vlr;

		}
		else if($chv == "TOTAL_MAQUINAS_OPERADOR")
		{

			$tabela.="\n\t\t\t<td>" . RetirarAcentos ($vlr)."</td>";	

			$qtdMaqTot = $qtdMaqTot + $vlr;

		}
		
		else if($chv == "QTD_MAQ")
		{

			$tabela.="\n\t\t\t<td>" . RetirarAcentos ($vlr)." </td>";	

			$qtdMaqTerc = $qtdMaqTerc + $vlr;

		}		
								
		else if($chv == "FATURAMENTO")
		{

			$tabela.="\n\t\t\t<td> $ ".number_format($vlr,0,"",".")."</td>";
			$totFatBruto = $totFatBruto + $vlr;

		}
		else if($chv == "PROMEDIO_COM_LEITURA")
		{

			$tabela.="\n\t\t\t<td> $ ".number_format($vlr,0,"",".")."</td>";	

		}
		else if($chv == "PROMEDIO_TOTAL")
		{

			$tabela.="\n\t\t\t<td> $ ".number_format($vlr,0,"",".")."</td>";	

		}
		else if($chv == "NOME_LOCAL")
		{

			$tabela.="\n\t\t\t<td><a href='detalhes_leitura_rua.php?id=".$Dados['id_leitura_parceiro']."'> " . RetirarAcentos ($vlr)."</a></td>";	

		}
		else if($chv == "ID_LEITURA_PARCEIRO")
		{
			//NAO MOSTRA NADA
		}							
		else
		{

			if($chv == "PORCENTAGEM")

			{

				$tabela.="\n\t\t\t<td>$ " . number_format(RetirarAcentos ($vlr),0,"",".")."</td>";

				$somaPct = $somaPct + $vlr;

			}

			else

			{

				$tabela.="\n\t\t\t<td>" . RetirarAcentos ($vlr)."</td>";	

			}

			

		}

	}

	$tabela.="\n\t\t</tr>";

	$cont++;

}





if($chv == "PORCENTAGEM")

{



	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<th>TOTAL DE LEITURA LOCAIS</th>";

	$tabela.="\n\t\t\t<th align='left'>$ " . number_format($somaPct,0,"",".") . "</th>";

	$tabela.="\n\t\t</tr>";





	$sql_fat_rua = "

		SELECT

			logins.nome,

			ROUND(SUM(vw_leitura.faturamento_bruto - ((vw_leitura.faturamento_bruto * vw_leitura.percentual) / 100))) - ROUND(SUM(vw_leitura.diferenca - ((vw_leitura.diferenca * vw_leitura.percentual) / 100))) as porcentagem

		FROM

			vw_leitura

		INNER JOIN

			logins

		ON

			vw_leitura.id_login = logins.id_login		

		WHERE

			vw_leitura.semana = 2

		AND

			vw_leitura.data_fechamento > '2014-02-31'

		AND

			vw_leitura.data_fechamento < '2014-04-01'

		AND

				(

					vw_leitura.id_tp_local = 1

				)

		AND

			vw_leitura.fechada = 1

		GROUP BY 

			vw_leitura.id_login

		ORDER BY

			vw_leitura.id_login

	";

	

	$query_fat_rua = @mysql_query($sql_fat_rua);

	$query_fat_pct_rua = @mysql_query($sql_fat_rua);

	



	//Query da consulta

	$somaPctRua = 0;

	while ($result_fat=@mysql_fetch_assoc($query_fat_rua) ) {

		$cor=($cor=='#DBE5F1'?"#FFFFFF":"#DBE5F1");

		$tabela.="\n\t\t<tr style='background-color:".$cor.";'>";

		$tabela.="\n\t\t\t<td>". $result_fat['nome'] ."</td>";	 

		$tabela.="\n\t\t\t<td>$ ". number_format($result_fat['porcentagem'],0,"",".") ."</td>";	

		$tabela.="\n\t\t</tr>";

		$somaPctRua = $somaPctRua + $result_fat['porcentagem'];



	}	

	

	

	

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<th>TOTAL DE LEITURA RUA</th>";

	$tabela.="\n\t\t\t<th align='left'>$ " . number_format($somaPctRua,0,"",".") . "</th>";

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<th>TOTAL GERAL LEITURA</th>";

	$tabela.="\n\t\t\t<th align='left'>$ " . number_format($somaPctRua + $somaPct,0,"",".") . "</th>";

	$tabela.="\n\t\t</tr>";	

	

	

	while ($result_goiaba=@mysql_fetch_assoc($query_fat_pct_rua) ) {

		$cor=($cor=='#DBE5F1'?"#FFFFFF":"#DBE5F1");

		$tabela.="\n\t\t<tr style='background-color:".$cor.";'>";

		$tabela.="\n\t\t\t<td>Comissao ". $result_goiaba['nome'] ."</td>";	 

		$tabela.="\n\t\t\t<td>$ ". number_format($result_goiaba['porcentagem'],0,"",".") ."</td>";	

		$tabela.="\n\t\t</tr>";

	}	

	

	



	$tabela.="\n\t\t\t<th>SUBTOTAL</th>";

	$tabela.="\n\t\t\t<th>$ 999.000</th>";	

	$tabela.="\n\t\t</tr>";

	

	

	

	//TABELA DE SOCIOS DA EMPRESA

	$tabela.="\n\t<table cellspacing='0px' cellpadding='0px' style='margin-top:10px;' width='50%' >";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<th>NOME</th>";

	$tabela.="\n\t\t\t<th>VALOR</th>";

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<td>ALBERTO</td>";	

	$tabela.="\n\t\t\t<td>$ 150.000</td>";	

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<td>JENKO</td>";	

	$tabela.="\n\t\t\t<td>$ 150.000</td>";	

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<td>DANIEL</td>";	

	$tabela.="\n\t\t\t<td>$ 150.000</td>";	

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<td>ALESSANDRO</td>";	

	$tabela.="\n\t\t\t<td>$ 150.000</td>";	

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<th colspan='2'>TOTAL: $ 30.000.000</th>";

	$tabela.="\n\t\t</tr>";	

	$tabela.="\n\t\t<tr>";	

	$tabela.="\n\t<table>\n<br clear='all'>";		

	

	

	//TABELA DE PARCEIROS DA EMPRESA

	$tabela.="\n\t<table cellspacing='0px' cellpadding='0px' style='margin-top:10px;' width='50%' >";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<th colspan='2'>MARTINHO</th>";

	$tabela.="\n\t\t</tr>";	

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<td>Casa Blanca</td>";	

	$tabela.="\n\t\t\t<td>$ 150.000</td>";	

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<td>ISLA DEL TESORO</td>";	

	$tabela.="\n\t\t\t<td>$ 150.000</td>";	

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<td>SUR</td>";	

	$tabela.="\n\t\t\t<td>$ 150.000</td>";	

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<td>PACHINKO</td>";	

	$tabela.="\n\t\t\t<td>$ 150.000</td>";	

	$tabela.="\n\t\t</tr>";

	$tabela.="\n\t\t<tr>";

	$tabela.="\n\t\t\t<th colspan='2'>TOTAL: $ 1.500.000</th>";

	$tabela.="\n\t\t</tr>";	

	$tabela.="\n\t\t<tr>";				

	$tabela.="\n\t<table>\n<br clear='all'>";		

	

}


//echo $idRel;

if($idRel == 2 )
{	
	//adiciona linha de totalizadores.
	
	$tabela.="\n\t\t<tr>";
	
	$tabela.="\n\t\t\t<th align='left'> Maquinas con leitura: </th>";
	
	$tabela.="\n\t\t\t<th align='left'> " . number_format($qtdMaqTerc,0,"",".") . " </th>";
	
	$tabela.="\n\t\t\t<th align='left'>SubTotal: </th>";
	
	$tabela.="\n\t\t\t<th align='left'> $ " . number_format($subTotal,0,"",".") . "</t	h>";
	
	$tabela.="\n\t\t</tr>";




	//manutencao rua.
	
	
	
	//consultar quantas maquinas tem o parceiro.
	
	$sql_qtd_maq_parc = "SELECT
							COUNT(DISTINCT id_maquina) as total_maquina
						FROM
							leitura_por_maquina
						INNER JOIN
							leitura
						ON
							leitura_por_maquina.id_leitura = leitura.id_leitura
						WHERE
							maq_parceiro = 1
						AND
							leitura.semana = ". $_GET['semFecha'] ."
						AND (
							leitura.data_fechamento > '".$dataInicio."'
							AND leitura.data_fechamento < '".$dataFinal."'
						)";
	
	$query_qtd_maq_parc = @mysql_query($sql_qtd_maq_parc);
	
	$resul_qtd_maq_parc = @mysql_fetch_assoc($query_qtd_maq_parc);
	
	
	
	//echo $resul_qtd_maq_parc['total_maquina'];


	//pct parceiro
	
	$pct_parceiro = (($subTotal * 45) / 100);
	
	$tabela.="\n\t\t<tr>";
	
	$tabela.="\n\t\t\t<th align='left'> Total de Maquinas: </th>";
	
	//busca quantidade de maquinas assoiadas ao parceiro no momento.
	
	
	//$tabela.="\n\t\t\t<th align='left'> " . number_format($resul_qtd_maq_parc['total_maquina'],0,"",".") . " </th>";
	$tabela.="\n\t\t\t<th align='left'> 8 </th>";
	
	$tabela.="\n\t\t\t<th align='left'> 45 % </td>";
	
	$tabela.="\n\t\t\t<th align='left'> $ ".number_format($pct_parceiro,0,"",".")."</th>";
	
	$tabela.="\n\t\t</tr>";
	


	//comissao rua.
	
	$comRua = (($pct_parceiro * 6) / 100);
	
	$tabela.="\n\t\t<tr>";
	
	$tabela.="\n\t\t\t<td colspan='3' align='right'>6 % </td>";
	
	$tabela.="\n\t\t\t<td> $ " . number_format($comRua,0,"",".") . "</td>";
	
	$tabela.="\n\t\t</tr>";



	
	
	
	//$manuRua = ($resul_qtd_maq_parc['total_maquina'] * 2000); // automatizar
	$manuRua = (8 * 2000); // automatizar
	
	$tabela.="\n\t\t<tr style='aligbackground-color:".$cor.";'>";
	
	$tabela.="\n\t\t\t<td colspan='3' align='right'> $ 2.000 </td>";
	
	$tabela.="\n\t\t\t<td> $ " . number_format($manuRua,0,"",".") . "</td>";
	
	$tabela.="\n\t\t</tr>";





	//Total Final.
	
	$totalFinal = $pct_parceiro - $comRua - $manuRua;
	
	$tabela.="\n\t\t<tr>";
	
	$tabela.="\n\t\t\t<th colspan='3' align='right'>Total Final: </th>";
	
	$tabela.="\n\t\t\t<th> $ " . number_format($totalFinal,0,"",".") . "</th>";
	
	$tabela.="\n\t\t</tr>";


}
else if($idRel == 3)
{
	$tabela.="\n\t\t<tr>";
	
	$tabela.="\n\t\t\t<th align='left'> Total promedio: </th>";

	$tabela.="\n\t\t\t<th align='left'> " . number_format($qtdMaqTot,0,"",".") . " </th>";
	
	$tabela.="\n\t\t\t<th align='left'> " . number_format($qtdMaq,0,"",".") . "</th>";
	
	$tabela.="\n\t\t\t<th align='left'> $ " . number_format($totFatBruto,0,"",".") . "</th>";
	
	//calcula promedio final
	$promedioFinalLeitura = $totFatBruto / $qtdMaq;
	$promedioFinalTotal = $totFatBruto / $qtdMaqTot;
	
	$tabela.="\n\t\t\t<th align='left'> $ " . number_format($promedioFinalLeitura,0,"",".") . "</th>";
	
	$tabela.="\n\t\t\t<th align='left'> $ " . number_format($promedioFinalTotal,0,"",".") . " </th>";
	
	$tabela.="\n\t\t</tr>";
}






$tabela.="\n\t<table>\n<br clear='all'>";



exit($tabela);



$ids = explode('_',($_GET['ida']) );

//Verifica se o relatorio ja esta nos favoritos. Caso esteja, remove senao adiciona

$sql_fav = "

	SELECT 

		vw_favoritos.* 

	FROM 

		vw_favoritos 

	WHERE 

		vw_favoritos.id_relatorio=".$ids[1]."

		AND vw_favoritos.id_login=".$ids[2]."

		AND vw_favoritos.favorito='".$_SESSION['usuario']."'";



$query_fav= @mysql_query($sql_fav);

$qtde_fav = @mysql_num_rows($query_fav);

$resul_fav= @mysql_fetch_assoc($query_fav);



//Verifica se o acesso a ser alterado � o de uma regional.

if ( $qtde_fav>=1 ) {

	

	//Removendo o relatorio dos Favoritos

	$sql_del_fav = "

		DELETE

		FROM

			favoritos

		WHERE

			favoritos.id_relatorio=".$ids[1]."

			AND favoritos.id_login=".$ids[2]."

		LIMIT 1

	";



	//Para remover o favorito, basta excluir o registro.

	if ( $query_ace_reg=@mysql_query($sql_del_fav) ) {

		//Verifica se o relatorio � padrao do sistema (tipo<>nome_usuario)

		//Se tipo=nome_usuario � um relatorio personalizado e pode ser excluido tamb�m junto com o favorito.

		if ( $resul_fav['favorito']==$_SESSION['usuario']) {

			$sql_del_relat = "UPDATE relatorio SET excluido='S' WHERE relatorio.id_relatorio=".$ids[1]." LIMIT 1";

			@mysql_query($sql_del_relat);

		}

		echo "Excluido:".$ids[1].":".$ids[2];

	}else{

		echo "no";

	}

}else{

	//Caso nao haja o Favorito, ele adiciona

	//Pega o nome do relatorio para exibir nos Favoriots

	$sql_nome = "

		SELECT 

			vw_favoritos.* 

		FROM 

			vw_favoritos 

		WHERE 

			vw_favoritos.id_relatorio=".$ids[1];

	

	$query_nome= @mysql_query($sql_nome);

	$qtde_nome = @mysql_num_rows($query_nome);

	$resul_nome= @mysql_fetch_assoc($query_nome);

	$relatorio = $resul_nome['nome'];

	

	$sql_aterar="INSERT INTO favoritos (id_relatorio,id_login) VALUES (".$ids[1].",".$ids[2].")";	

	if ( @mysql_query($sql_aterar) ) {

		echo "Adiciona:".$ids[1].":".$ids[2].":".$relatorio;

	}else{

		echo "no";

	}

}

?>