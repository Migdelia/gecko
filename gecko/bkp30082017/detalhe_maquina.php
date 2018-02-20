<?php

session_start();

include('conn/conn.php');

include('functions/functions.php');

include('functions/lg_validador.php');

unset($_SESSION['campos']);

$total_colunas=4;

$jsc='';

$id_assoc = $_GET['id'];





//consulta que local pertence essa maquina

$sql_loc = "

	SELECT

		id_local

	FROM

		maquinas

	WHERE

		maquinas.id_maquina = '".$id_assoc."'

	";

$query_loc=@mysql_query($sql_loc);

$resultado_loc=@mysql_fetch_assoc($query_loc);











//verifica a ultima leitura desse local

$sql_ult_leit = "

	SELECT

		MAX(

			leitura.id_leitura

		)AS id_leitura

	FROM

		leitura

	WHERE

		leitura.id_local = '".$resultado_loc['id_local']."'

	";

$query_ult_leit=@mysql_query($sql_ult_leit);

$resultado_ult_leit=@mysql_fetch_assoc($query_ult_leit);

 





//Verificando se foi passado um Associado e se ele existe.

$sql_assoc = "

SELECT

	vw_maquinas.codigo,

	vw_maquinas.numero,

	vw_maquinas.nome,

	vw_maquinas.id_jogo,

	vw_maquinas.interface,

	vw_maquinas.porc_maquina,

	vw_maquinas.maq_socio,

	vw_maquinas.porc_socio,

	vw_maquinas.operador,

	vw_maquinas.parceiro,

	vw_maquinas.entrada_oficial,

	vw_maquinas.saida_oficial

FROM

	vw_maquinas

INNER JOIN

	leitura_por_maquina

ON

	vw_maquinas.id_maquina = leitura_por_maquina.id_maquina

WHERE

	vw_maquinas.id_maquina = ".$id_assoc."

GROUP BY

	vw_maquinas.id_maquina

	";



//Definindo em qual aba devera ficar o campo retornado na select

$abas = array(

	'codigo'			=>'Informacoes',

	'numero'			=>'Informacoes',

	'nome'			=>'Informacoes',	

	'id_jogo'			=>'Informacoes',

	'interface'			=>'Informacoes',	

	'porc_maquina'			=>'Informacoes',		

	'maq_socio'			=>'Informacoes',

	'porc_socio'			=>'Informacoes',

	'operador'			=>'Informacoes',

	'parceiro'			=>'Informacoes',

	'entrada_oficial'			=>'Informacoes',

	'saida_oficial'			=>'Informacoes'

		



);





$result = mysql_query($sql_assoc);



while ($linha = mysql_fetch_array($result)) 

{

	$n_edit=array('codigo','numero','entrada','saida','jogo','operador','interface','entrada_oficial', 'saida_oficial' );

	

	$moneyIn = $linha['entrada_oficial'];	

	$moneyOut = $linha['saida_oficial'];		

}





//Caso o Cliente não exista, exibe o erro e volta para tela anterior

if ($query_assoc=@mysql_query($sql_assoc)) {

	if (@mysql_num_rows($query_assoc)!=1) {

		$jsc ="<script language='javascript' type='text/javascript'>";

		$jsc.="\n\talert('Dados Incorretos.');";

		$jsc.="\n\twindow.location='clientes.php';";

		$jsc.="\n</script>";

	}else{

		$result_assoc=@mysql_fetch_assoc($query_assoc);

	}

}else{

	$jsc ="<script language='javascript' type='text/javascript'>";

	$jsc.="\n\talert('Dados Incorretos.');";

	$jsc.="\n\twindow.location='clientes.php';";

	$jsc.="\n</script>";

}

//Montando as Abas

$itens_guia = array_count_values($abas);

$guias="\n\t\t\t<ul>";

$guias_cont="";

$cont=1;

$jquery_jed="";



foreach($itens_guia as $key=>$val) {

	//Montando as Guias das Abas

	$guias.="\n\t\t\t\t<li><a href='#tabs-".$cont."'>".$key."</a></li>";

	//Montando o Conteudo de Cada Aba

	$guias_cont.="\n\t\t\t<div id='tabs-".$cont."'>";

	//Montando a Tabela com os dados que a aba deverá possuir

	$guias_cont.="\n\t\t\t\t<table width='".($key=='Histórico'?'50':'100')."%' border='0' align='center' cellpadding='2' cellspacing='4'>";

	$coluna=0;

	//Reponsavel por Montar o Quadro de Historico das Vigencias

	if ($key=='Histórico') {

		//Selecionando as Vigencias Cadastradas do usuario

		$sql_vig = "

			SELECT

				vw_selo.cartao

				,GROUP_CONCAT(vw_selo.selo SEPARATOR ' - \n') AS selo

				,vw_selo.qtd_selo_cartao

				,vw_selo.`local`

				,vw_selo.data_utilizacao_br

			FROM

				`vw_selo`

			WHERE

				vw_selo.idcard IS NOT NULL

				AND `id_cliente` = '".$id_assoc."'

			ORDER BY

				vw_selo.data_utilizacao_br DESC

			";

		$query_vig=@mysql_query($sql_vig);

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#E17009;'>MAQUINA: ".$id_assoc." - <span style='color:#1D5987;'>Cartões</span></th></tr>\n";

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".($total_colunas/2)."' style='color:#E17009;'>Cartão - Total Selos</th><th colspan='".($total_colunas/2)."' style='color:#E17009;'>Selos</th></tr>\n";

		while($result_vig=@mysql_fetch_assoc($query_vig)) {

			if ($coluna==0) {

				($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

				$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";

			}



			$ano_corrente=date('Y');

			//Verifica se é a anuidade vigente. Caso esteja, destaca a informação.

			if ( (date('Y-m-d')>=ConverteData($result_vig['inicio'],"US"))&&(date('Y-m-d')<=ConverteData($result_vig['termino'],'US')) ) {

				//$destaque="style='color:#4169E1;cursor:pointer;text-decoration:blink;' title='Ativo nesta Vig&ecirc;ncia'";

			}else{

				//$destaque="style='color:#8B8989'";

			}



			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' colspan=' ".($total_colunas/2)."'>\n";

			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">".htmlentities(strtoupper(str_replace('_',' ',$result_vig['cartao'])))." - ".str_replace('_',' ',$result_vig['qtd_selo_cartao'])." Selo".($result_vig['qtd_selo_cartao']>1?'s':'')."</strong>";

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=2;

			$guias_cont.="\t\t\t\t\t<td width='".(100/($total_colunas))."%' colspan='".($total_colunas/2)."'>\n";

			$guias_cont.="\n\t\t\t\t\t\t<strong ".$destaque.">".htmlentities($result_vig['selo'])."<strong>";

			$guias_cont.="\n\t\t\t\t\t</td>\n";

			$coluna=4;

			if ($coluna==$total_colunas) {

				$guias_cont.="\t\t\t\t</tr>\n";

				$coluna = 0;

			}

		}

	}else{

	

		//consulta dados da maquina

		$sql_maq = "

			SELECT

				*

			FROM

				`vw_maquinas`

			WHERE

				vw_maquinas.id = '".$id_assoc."'

			";

		$query_maq=@mysql_query($sql_maq);

		$resultado_maq=@mysql_fetch_assoc($query_maq);			

	

		$guias_cont.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#E17009;'>DATA: <span style='color:#1D5987;'>".date('d-m-Y')."</span></th></tr>\n";



		$vlr = "";	



					

		foreach ($result_assoc as $chv=>$vlr) {

			if ($abas[$chv] == $key) {

				//Montando os campos dentro das abas (Conteudos)

				if ($coluna==0) {

					($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

					$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;'>\n";

				}

				

				$guias_cont.="\t\t\t\t\t<td width='".(48/$total_colunas)."%'>\n";



				//trata a mudanca de cpf para rut(documento chileno

				if($chv == "cpf")

				{

					$chv = "RUT";

				}

				

				

				if($chv ==  "nome")

				{$chv = "id_local";}

				if($chv ==  "id_jogo")

				{$chv = "jogo";}

				





				if($chv ==  "porc_maquina")

				{				

					$guias_cont.="\n\t\t\t\t\t\t<strong>".htmlentities(strtoupper(str_replace('_',' ',str_replace('_br','',$chv))))." ESPECIAL</strong>";

				}

				else if($chv ==  "maq_socio")

				{

					$guias_cont.="\n\t\t\t\t\t\t<strong>".htmlentities(strtoupper(str_replace('_',' ',str_replace('_br','',"MAQUINA DE SOCIO"))))."</strong>";				

				}				

				else if($chv ==  "parceiro")

				{

					$guias_cont.="\n\t\t\t\t\t\t<strong>".htmlentities(strtoupper(str_replace('_',' ',str_replace('_br','',"MAQUINA DE PARCEIRO"))))."</strong>";				

				}				

				else

				{

					$guias_cont.="\n\t\t\t\t\t\t<strong>".htmlentities(strtoupper(str_replace('_',' ',str_replace('_br','',$chv))))."</strong>";				

				}

				

												

				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna++;

				

				$editar = '';

				$editar = trim(array_search($chv, $n_edit));

			

				//Verificando se o Campo pode ser editado

				if ($editar == "") {

				

					//Campo a ser exibido quando o item for o estado

					if (strstr($chv,'local')) {

					

						//consulta aqui todos os locais

						//com a condicao de que se for operador nao mostrar locais que nao pertence ao mesmo.

						$sql_local = "

							SELECT

								*

							FROM

								`local`

							";

						$query_local=@mysql_query($sql_local);

						

						$list_loc = "";

						while ($linha = mysql_fetch_array($query_local)) 

						{

							$list_loc .=  "'" . $linha['id_local'] . "':'" . $linha['nome'] . "',";

						}



						$complemento = "\t\t\t\t\t\tdata   : \"{".$list_loc."}\",\n";

						$complemento.= "\t\t\t\t\t\ttype   : 'select',\n";

					}else if (strstr($chv,'jogo')) {

						//consulta aqui todos os jogos

						$sql_jg = "

							SELECT

								*

							FROM

								`jogo`

							";

						$query_jg=@mysql_query($sql_jg);

						

						$list_jog = "";

						while ($linha_jg = mysql_fetch_array($query_jg)) 

						{

							$list_jog .=  "'" . $linha_jg['id_jogo'] . "':'" . $linha_jg['nome'] . "',";

						}



						$complemento = "\t\t\t\t\t\tdata   : \"{".$list_jog."}\",\n";

						$complemento.= "\t\t\t\t\t\ttype   : 'select',\n";

					}else if (strstr($chv,'interface')) {

						//consulta aqui todos os jogos

						$sql_inter = "

							SELECT

								*

							FROM

								`interface`

							WHERE

								interface.id_maquina = 0

							";

						$query_inter=@mysql_query($sql_inter);

						

						$list_inter = "";

						while ($linha_inter = mysql_fetch_array($query_inter)) 

						{

							$list_inter .=  "'" . $linha_inter['id_interface'] . "':'" . $linha_inter['numero'] . "',";

						}



						$complemento = "\t\t\t\t\t\tdata   : \"{".$list_inter."}\",\n";

						$complemento.= "\t\t\t\t\t\ttype   : 'select',\n";

					}else if (strstr($chv,'parceiro')) {

						//Montando a TAG select com as opções de sexo

						$complemento = "\n\t\t\t\t\t\tdata   : \"{'1':'TRUE','0':'FALSE'}\",";

						$complemento.= "\n\t\t\t\t\t\ttype   : 'select',";

					}else if (strstr($chv,'data')) {

						//Montando o campo com o calendario

						$complemento = "\n\t\t\t\t\t\ttype	:	'datepicker',";

					}else if (strstr($chv,'maq_socio')) {

						//Montando a TAG select com as opções de sexo

						$complemento = "\n\t\t\t\t\t\tdata   : \"{'true':'TRUE','false':'FALSE'}\",";

						$complemento.= "\n\t\t\t\t\t\ttype   : 'select',";

					}else if (strstr($chv,'operador')) {

						//consulta aqui todos os jogos

						$sql_ope = "

							SELECT

								*

							FROM

								`logins`

							WHERE

								logins.id_nivel = 8

							";

						$query_ope=@mysql_query($sql_ope);

						

						$list_ope = "";

						while ($linha_ope = mysql_fetch_array($query_ope)) 

						{

							$list_ope .=  "'" . $linha_ope['id_login'] . "':'" . $linha_ope['nome'] . "',";

						}



						$complemento = "\t\t\t\t\t\tdata   : \"{".$list_ope."}\",\n";

						$complemento.= "\t\t\t\t\t\ttype   : 'select',\n";

					}

					else{

						$complemento= "";

					}



					

					$table = "maquinas";

					$mkey = "id_maquina";

					

					

					



					$jquery_jed.= "

						 $('#".$chv."').editable('functions/editable_det_ajax.php', {

							".$complemento."

							tooltip		:	'Clique para Editar...',

							height		:	'14px',

							width		:	'150px',

							placeholder	:	'<b>Clique para Editar</b>',

							cancel		:	'Cancel',

							submit		:	'OK',

							submitdata	:	function ( value, settings ) {

								return {

									\"row_id\": '".$id_assoc."',

									\"table\": '".$table."',

									\"mkey\": '".$mkey."',

									\"row_oldvalue\": '".$vlr."'

								};

							},

							indicator : '<img src=\"img/aguarde_ico.gif\">'

						});\n

					";					

				}



				

				$guias_cont.="\t\t\t\t\t<td width='".(152/$total_colunas)."%'>\n";

				

				//aqui mostra os valores

				/*				

				$guias_cont.="\n\t\t\t\t\t\t<label id='".$chv."//'>".htmlentities(number_format($vlr,0,"",".")). "</label>";

				*/

				

				if($chv == "jogo")

				{			

					//consulta dados da maquina

					$sql_jogo = "

						SELECT

							nome

						FROM

							`jogo`

						WHERE

							jogo.id_jogo = '".$vlr."'

						";

					$query_jogo=@mysql_query($sql_jogo);

					$resultado_jogo=@mysql_fetch_assoc($query_jogo);

					

					$vlr = $resultado_jogo['nome'];

				}



				

				//

				if($chv == "entrada_oficial" or $chv == "saida_oficial")

				{

					$guias_cont.="\n\t\t\t\t\t\t<label id='".$chv."' title='".$vlr."'>$ ".htmlentities(number_format($vlr,0,"",".")). "</label>";

				}

				else if($chv == "parceiro")

				{

					if($vlr == 0)

					{

						$guias_cont.="\n\t\t\t\t\t\t<label id='".$chv."'>false</label>";				

					}

					else

					{

						$guias_cont.="\n\t\t\t\t\t\t<label id='".$chv."'>true</label>";

					}		

				}

				else

				{

					$guias_cont.="\n\t\t\t\t\t\t<label id='".$chv."'>".$vlr. "</label>";				

				}

	

				



				$guias_cont.="\n\t\t\t\t\t</td>\n";

				$coluna++;

	

				if ($coluna==$total_colunas) {

					$guias_cont.="\t\t\t\t</tr>\n";

					$coluna = 0;

				}

			}

	//		$guias_cont.=$key." : ".$chv."-".$vlr."<br />";

		}

	}

	if ($coluna != 1) {

		$guias_cont.="\t\t\t\t</tr>\n";

	}

	



	$guias_cont.="\n\t\t\t</table><br clear='both' />&nbsp;\n";

	



	if($key == "Lectura")

	{

		$guias_cont.="\n\t\t\t\t<table width='".($key=='Histórico'?'50':'100')."%' border='0' align='center' cellpadding='2' cellspacing='4'>";	

	

		($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');

		$guias_cont.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;'>\n";

		$guias_cont.="\t\t\t\t\t<td width='".(152/$total_colunas)."%' align='right'>\n";

		$guias_cont.="\n\t\t\t\t\t\t<label id='".$chv."//'><strong>TOTAL: &nbsp;</strong> </label>";

		$guias_cont.="\n\t\t\t\t\t</td>\n";	

		$guias_cont.="\t\t\t\t\t<td width='".(152/$total_colunas)."%'>\n";

		$vlr = ($result_assoc['moneyIn'] - $result_assoc['moneyOut']) * 10;

		$guias_cont.="\n\t\t\t\t\t\t<label id='".$chv."//'>".htmlentities(number_format($vlr,0,"",".")). " $ </label>";

		$guias_cont.="\n\t\t\t\t\t</td>\n";														

		$guias_cont.="\t\t\t\t</tr>\n";

		

		$guias_cont.="\n\t\t\t</table><br clear='both' />&nbsp;\n";		

	}



	

	if ($key=='Dados Pessoais') {

		//Verificando se existe boleto não pago para exibir o icone do boleto.

		$sql_tfin = "

			SELECT

				vw_financeiro.id_financeiro

			FROM

				vw_financeiro

			WHERE

				vw_financeiro.id_associado=".$id_assoc."

				AND vw_financeiro.pago='N'

				AND vw_financeiro.data_vencimento>=curdate()

		";

		$query = @mysql_query($sql_tfin);

		$qtd_fin = @mysql_num_rows($query);

		if ($qtd_fin==1) {

			$idfin = @mysql_result($query,0);

			$guias_cont.="\n\t\t\t<a id='imp_boleto' style='margin-left:5px;' name='imp_boleto' href='ficha/lnk_boleto.php?i=".base64_encode($idfin)."' target='_blank'><img src='img/boleto_itau.png' border='none' align='absmiddle' title='Clique aqui para gerar o boleto do Associado' style='cursor:pointer;' /></a>\n";

		}

	}	

	$guias_cont.="\n\t\t\t</div>";	

	$cont++;

}

$guias.="\n\t\t\t</ul>\n";





//verificar nivel
if($_SESSION['usr_nivel'] == 1 or $_SESSION['usr_nivel'] == 10)
{
	$guias_cont.="\n\t\t\t\t <div align='center'>";
	
	$guias_cont.="\n\t\t\t\t<button id='editar_leitura' type='button' style='margin-left:4%;margin-top:30px;cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;width:160px;'>EDITAR LEITURA OFICIAL</button>";	
	
	$guias_cont.="\n\t\t\t\t </div>";	
}




//

$guias_cont.="\n\t\t\t\t <div align='center'>";

$guias_cont.="\n\t\t\t\t<button id='imprimir' type='button' class='bt-enviar' style='margin-left:4%;margin-top:30px;'>Imprimir</button>";				

$guias_cont.="\n\t\t\t\t </div>";





///busca motivos da troca

$sql_motivo = "

	SELECT

		*

	FROM

		`motivo_troca`

	";

$query_motivo=@mysql_query($sql_motivo);





$guias_cont.="\n\t\t\t\t <div id='div_edita_valores' align='center' class='window' style='display:none;position:absolute;width:350px;height:220px;left:50%;z-index:9999;margin-left:-175px;top:50px;background-color:#FFFFF8;'>";

$guias_cont.="\n\t\t\t\t <center>";	

$guias_cont.="\n\t\t\t\t <ul style='list-style-type:none;'>

            <li style='background-color:#FF9933; color:#FFFFFF;'>

            <br />

            <strong>LEITURA OFICIAL</strong>

            </li>

        </ul>

		

        <form id='form_nova_leitura' name='form_nova_leitura' method='post'>

            <br />

			<br />

            <label>&nbsp;<strong> ENTRADA:</strong></label>

			<input type='text' name='ent_ofi' size='13' id='ent_ofi' style='text-align:center' title='Entrada oficial' label='0' value='".htmlentities(number_format($moneyIn,0,"",".")). "' onclick='selVal(this);'>

            <label>&nbsp;&nbsp;&nbsp;<strong> SAIDA:</strong></label>

			<input type='text' name='sai_ofi' size='13' id='sai_ofi' style='text-align:center' title='Saida Oficial' label='0' value='".htmlentities(number_format($moneyOut,0,"",".")). "' onclick='selVal(this);'>

			<br />

			<br />

			<br />			

            <label>&nbsp;<strong> MOTIVO: </strong>&nbsp;</label>

			<select id='motivo_troca' name='motivo_troca'>";





			

			while($dados_mot=@mysql_fetch_assoc($query_motivo)) 

			{



				$guias_cont.="\n\t\t\t\t<option value='".$dados_mot['id_motivo']."'>".$dados_mot['motivo']."</option>";

			}

				

$guias_cont.="\n\t\t\t\t 							

            </select>

            <br />

            <br />

            &nbsp;&nbsp;

            

            <input type='button' id='atualiza_leit' name='seguinte' value='&nbsp;Atualizar&nbsp;' onclick='dirLeitura();' />				

           

            

        </form>

        </center>		

		

		";				

$guias_cont.="\n\t\t\t\t </div>";



/*

$guias_cont.="\n\t\t\t\t <div id='div_edita_valores' align='center' style='display:none;'>";

$guias_cont.="\n\t\t\t\t AQUI VAI O FORM QUE MUDA A LEITURA OFICIAL!";				

$guias_cont.="\n\t\t\t\t </div>";

*/





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

		//seleciona o texto completo do campo

		function selVal(obj)

		{

			obj.select();

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

		});



		 $(document).ready(function() {

		<?php

			echo $jquery_jed;

		?>

		

			//atualiza dados da leitura oficial ** atualiza_leit * Erico Porchat

			$("#atualiza_leit").click(function() {

				var entradaOfi = $('#ent_ofi').attr("value");

				var saidaOfi = $('#sai_ofi').attr("value");

				var motivoTroca = $('#motivo_troca').attr("value");





				var entradaOfiVelha = $('#entrada_oficial').attr("title"); 

				var saidaOfiVelha = $('#saida_oficial').attr("title"); 





				jQuery.ajax(

				{								

					type: "POST", // Defino o método de envio POST / GET

					url: 'atualizaHistTroca.php', // Informo a URL que será pesquisada.

					data: 'ent='+entradaOfi+'&sai='+saidaOfi+'&entAnt='+entradaOfiVelha+'&saiAnt='+saidaOfiVelha+'&mot='+motivoTroca+'&id=<?php echo $id_assoc ?>',

					success: function(html)

					{

						var html = eval(html);

						if(html == true)

						{

							alert("Atualizado! OK!");

							location.reload();							

						}

						else

						{

							alert("Erro!");

						}

					}

				});	





			});		

		

		

		

			//controle de volume

			//baixar volume

			$("#menosVol").click(function() {

					jQuery.ajax(

					{

						type: "POST", // Defino o método de envio POST / GET

						url: 'menosVol.php', // Informo a URL que será pesquisada.

						data: 'id=<?php echo $id_assoc ?>',

						success: function(html)

						{

							var html = eval(html);

							if(html == true)

							{							

								return true;

							}

							else

							{

								alert("Erro!");

							}

						}

					});

			});	

			//subir volume

			$("#maisVol").click(function() {

					jQuery.ajax(

					{

						type: "POST", // Defino o método de envio POST / GET

						url: 'maisVol.php', // Informo a URL que será pesquisada.

						data: 'id=<?php echo $id_assoc ?>',

						success: function(html)

						{

							var html = eval(html);

							if(html == true)

							{					

								return true;

							}

							else

							{

								alert("Erro!");

							}

						}

					});

			});

			//deixar mudo

			$("#mute").click(function() {

					jQuery.ajax(

					{

						type: "POST", // Defino o método de envio POST / GET

						url: 'muteVol.php', // Informo a URL que será pesquisada.

						data: 'id=<?php echo $id_assoc ?>',

						success: function(html)

						{

							var html = eval(html);

							if(html == true)

							{					

								return true;

							}

							else

							{

								alert("Erro!");

							}

						}

					});

			});	

			

			//deixar mudo

			$("#mute_off").click(function() {

					jQuery.ajax(

					{

						type: "POST", // Defino o método de envio POST / GET

						url: 'muteOffVol.php', // Informo a URL que será pesquisada.

						data: 'id=<?php echo $id_assoc ?>',

						success: function(html)

						{

							var html = eval(html);

							if(html == true)

							{					

								return true;

							}

							else

							{

								alert("Erro!");

							}

						}

					});

			});				

			

		

				

		

			//Responsavel por imprimir a tela.

			$("#imprimir").click(function() {

				self.print();

			});

			

			//some com a mascara

			$("#mascara").click(function() {

				$('#div_edita_valores').fadeOut("slow");

				$('#mascara').fadeOut("slow");

			});			

			

			

			//mostra div de edicao de leitura.

			$("#editar_leitura").click(function() {

				$('#mascara').fadeIn("slow");

				$('#div_edita_valores').fadeIn("slow");

			});

			

			

			

			//reinicia a maquina selecionada atual

			$("#reboot").click(function() {

				if (confirm('Atencion!\n\nEsta maquina sera reiniciada, estas seguro?')) {

					jQuery.ajax(

					{

						type: "POST", // Defino o método de envio POST / GET

						url: 'reboot.php', // Informo a URL que será pesquisada.

						data: 'id=<?php echo $id_assoc ?>',

						success: function(html)

						{

							var html = eval(html);

							if(html == true)

							{

								$('#processando').fadeIn("slow");

								setInterval(function() 

								{

									$('#processando').fadeOut("slow");

									alert("Maquina Reiniciada con exito!");

									location = "manutencao.php";

								},18000);								

								return true;

							}

							else

							{

								alert("Erro! Nao é possivel Cobrar essa maquina!");

							}

						}

					});

				}

				else

				{

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

		#ui-datepicker-div {font-size:13px;}

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

        <div id="processando" style="position:absolute; left:45%; top:50%; display:none; background-color:#999999; opacity:0.7;" align="center">

             <strong>........... Procesando ...........</strong>

             <br />

            <img src="../calabaza/img/aguarde.gif" />

        </div>

	</div>

    <div id='mascara' align='center' style='position:absolute;left:0;top:0;z-index:9000;background-color:#000;width:100%;height:100%;display:none;opacity:0.8;' >				

	</div>

</body>

</html>