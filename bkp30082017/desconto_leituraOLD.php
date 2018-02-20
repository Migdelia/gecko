<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$id_assoc = $_GET['id_loc'];
$sql_ult_leit = "
	SELECT
		max(leitura.id_leitura) as id_leitura
	FROM
		leitura
	WHERE 
		leitura.id_local = '".$id_assoc."'
	";
$query_ult_leit = @mysql_query($sql_ult_leit);
$dados_ult_leit=@mysql_fetch_assoc($query_ult_leit);


//pegar o id e para cadastrar desconto para esse id de leitura

//Definindo o nome de cada area da tela
//Verificando se o nivel do usuario permite visualizar as abas referente ao financeiro (id_menu=11)
$sql_a = "
	SELECT
		*
	FROM
		acesso
	WHERE 
		id_menu='11'
		AND id_nivel= '".$_SESSION['usr_nivel']."'
		AND acesso='S'
	";
$query_a = @mysql_query($sql_a);
if (@mysql_num_rows( $query_a ) == 0) {
	//Caso não tenha acesso carrega guias comuns
	//$acoes = array('Níveis','Usuários','Lotes');
	$acoes = array('Locais');
}else{
	//Se tiver acesso, exibe todas as guias
	$acoes = array('Descontos');
}

//Montando o Nome de Cada Acordion com o Nome do Nivel
$conteudo='';
$conteudo_tab='';
foreach ($acoes as $chave=>$valor) {
	$conteudo_tab.= "\t\t\t\t<li><h5><a href='#tab".$chave."'>".htmlentities($valor)."</a></h5></li>\n";
	
	//Montando o Conteudo de cada Acordion
	switch ($valor) {
	
		case "Descontos":
				$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_desconto_leitura' id='create_desconto_leitura' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param_desc' type='hidden' name='param_desc' size='30' id='param_desc' value='".base64_encode('desconto')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tDesconto Leitura:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";


				//bOleta ou fatura
				$conteudo.="\n\t\t\t\t<input type='radio' name='radio' id='boleta' value='boleta' checked='checked' />
				<span style='color:#1D5987;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:12px;font-weight:bolder;' id='boleta'> BOLETA &nbsp;</span>
				<input type='radio' name='radio' id='fatura' value='fatura' />
				<span style='color:#1D5987;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:12px;font-weight:bolder;' id='fatura'> FATURA </span><br/>";

				//Informações do Nível
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_desc'>Num. (boleta/fatura):</div>";
				$conteudo.="\n\t\t\t\t<input label='desconto' type='text' name='desconto' size='10' id='desconto' title='Informe o valor do desconto' value='' onfocus=\"$('#info_desc_leituera').css({'visibility':'visible'});\" onblur=\"$('#info_desc_leitura').css({'visibility':'hidden'});\"><br/>";
				
				//Informações do Nível
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_desc'>Valor desconto:</div>";
				$conteudo.="\n\t\t\t\t<input label='desconto' type='text' name='desconto' size='10' id='desconto' title='Informe o valor do desconto' value='' onfocus=\"$('#info_desc_leituera').css({'visibility':'visible'});\" onblur=\"$('#info_desc_leitura').css({'visibility':'hidden'});\"><br/>";				

				//motivo
				$sql_mot = "
					SELECT
						tipo_desconto.id_desconto,
						tipo_desconto.descricao
					FROM
						tipo_desconto
					GROUP BY
						tipo_desconto.id_desconto
					ORDER BY
						tipo_desconto.descricao
				";
				$query_mot = @mysql_query($sql_mot);
				//Montando as Combos de Jogos.
				$mot = '';
				while ( $dados_mot=@mysql_fetch_assoc($query_mot) ) {
					$mot.= "\n\t\t\t\t\t<option value='".$dados_mot['id_desconto']."'>".$dados_mot['descricao']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_mot_desc'>Motivo:</div>";
				$conteudo.="\n\t\t\t\t<select name='mot_desc' id='mot_desc'  style='width:130px;' onfocus=\"$('#info_mot_desc').css({'visibility':'visible'});\" onblur=\"$('#info_mot_desc').css({'visibility':'hidden'});\">";
				$conteudo.=$mot;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_mot_desc'>Motivo do desconto.</label><br>";
				
				//Informações do Nível
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_desc_desconto'>Descricao:</div>";
				$conteudo.="\n\t\t\t\t<input label='descricao' type='text' name='descricao' size='40' id='descricao' title='Informe a descricao do desconto' value='' onfocus=\"$('#info_desc_desconto').css({'visibility':'visible'});\" onblur=\"$('#info_desc_desconto').css({'visibility':'hidden'});\"><br/>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_desc_desconto'>Descricao (livre) do desconto.</label><br>";
				
				
				$conteudo.="\n\t\t\t\t<button id='arq_desconto' type='button' class='bt-enviar' style='margin-left:220px;'>Cadastrar</button>";				
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";
		break;


		//Maquinas
		case "Maquinas":
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_maquina' id='create_maquina' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tCriar Nova Maquina:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";

							
				//Numero de maq
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='param_maq' size='30' id='param_maq' value='".base64_encode('maquina')."' />";
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_maq_num'>Numero da maquina:</div>";
				$conteudo.="\n\t\t\t\t<input label='maq_num' type='text' name='maq_num' size='10' id='maq_num' title='Informe o numero da maquina' value='' onfocus=\"$('#info_maq_num').css({'visibility':'visible'});\" onblur=\"$('#info_maq_num').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_num'>Informe o numero da Maquinao</label><br>";

				
				//Cod Maquina
				$sql_gab = "
					SELECT
						tipo_maquina.id_tipo_maquina,
						tipo_maquina.descricao,
						COUNT(tipo_maquina.id_tipo_maquina) AS qtd
					FROM
						tipo_maquina
					GROUP BY
						tipo_maquina.id_tipo_maquina
					ORDER BY
						tipo_maquina.descricao
				";
								
				$query_gab = @mysql_query($sql_gab);
				
				//Montando as Combos de Gabinetes.
				$gab = '';
				while ( $dados_gab=@mysql_fetch_assoc($query_gab) ) {
					$gab.= "\n\t\t\t\t\t<option value='".$dados_gab['id_tipo_maquina']."'>".$dados_gab['descricao']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_maq_gab'>Modelo Maq:</div>";
				$conteudo.="\n\t\t\t\t<select name='maq_gab' id='maq_gab'  style='width:130px;' onfocus=\"$('#info_maq_gab').css({'visibility':'visible'});\" onblur=\"$('#info_maq_gab').css({'visibility':'hidden'});\">";
				$conteudo.=$gab;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_gab'>Modelo do Gabinete.</label><br>";

				//jogo
				$sql_jog = "
					SELECT
						vw_interface.numero,
						CONCAT(vw_interface.numero,':',vw_interface.id_jogo,'-',vw_interface.nome) AS descricao
					FROM
						vw_interface
					WHERE
						vw_interface.id_maquina=0
					ORDER BY
						vw_interface.nome
						,vw_interface.numero
				";
				$query_jog = @mysql_query($sql_jog);
				//Montando as Combos de Jogos.
				$jog = '';
				$jog.= "\n\t\t\t\t\t<option value='-1' selected='selected'>Selecione</option>";
				while ( $dados_jog=@mysql_fetch_assoc($query_jog) ) {
					$jog.= "\n\t\t\t\t\t<option value='".$dados_jog['numero']."'>".$dados_jog['descricao']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_maq_jogo'>Interface:</div>";
				$conteudo.="\n\t\t\t\t<select name='maq_jog' id='maq_jog'  style='width:130px;' onfocus=\"$('#info_maq_jogo').css({'visibility':'visible'});\" onblur=\"$('#info_maq_jogo').css({'visibility':'hidden'});\">";
				$conteudo.=$jog;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_jogo'>Jogo da maquina.</label><br>";

				
				//local
				$sql_loc = "
					SELECT
						local.id_local,
						local.nome,
						COUNT(local.id_local) AS qtd
					FROM
						local
					GROUP BY
						local.id_local
					ORDER BY
						local.nome
				";

				
				$query_loc = @mysql_query($sql_loc);
				//Montando as Combos de Niveis.
				$loc = '';
				while ( $dados_loc=@mysql_fetch_assoc($query_loc) ) {
					$loc.= "\n\t\t\t\t\t<option value='".$dados_loc['id_local']."'>".$dados_loc['nome']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_maq_loc'>Local:</div>";
				$conteudo.="\n\t\t\t\t<select name='maq_loc' id='maq_loc'  style='width:130px;' onfocus=\"$('#info_maq_loc').css({'visibility':'visible'});\" onblur=\"$('#info_maq_loc').css({'visibility':'hidden'});\">";
				$conteudo.=$loc;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_loc'>Local da Maquina.</label><br>";


				//Numero de maq
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_maq_por'>Maquina %:</div>";
				$conteudo.="\n\t\t\t\t<input label='maq_por' type='text' name='maq_por' size='5' id='maq_por' title='Informe a porcentagem da maquina' value='' onfocus=\"$('#info_maq_por').css({'visibility':'visible'});\" onblur=\"$('#info_maq_por').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_por'>Informe a porcentagem da Maquina</label><br>";


				//obs
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='obs_maq' size='30' id='obs_maq' value='".base64_encode('maquina')."' />";
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_maq_obs'>Obs. da maquina:</div>";
				$conteudo.="\n\t\t\t\t<input label='maq_obs' type='text' name='maq_obs' size='28' id='maq_obs' title='observacao da maquina' value='' onfocus=\"$('#info_maq_obs').css({'visibility':'visible'});\" onblur=\"$('#info_maq_obs').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_obs'>Observacao da Maquina</label><br>";
				
				
				//Envia form
				$conteudo.="\n\t\t\t\t<button id='arq_maq' type='button' class='bt-enviar' style='margin-left:220px;'>Criar Maq</button>";
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";
		break;
		




		case "Importar":
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='arq_baixa' id='arq_baixa' action='processa_cnab.php?u=".base64_encode('carregar')."' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tCarregar Arquivo de Lan&ccedil;amentos";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				//Seleção do Arquivo
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_arq'>Planilha Excel (xls):</div>";
				$conteudo.="\n\t\t\t\t<input label='file' type='file' name='arqui' size='30' id='file' title='Selecione o arquivo xls' value='' onfocus=\"$('#info_arq').css({'visibility':'visible'});\" onblur=\"$('#info_arq').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_arq'>Selecione o arquivo de lan&ccedil;amentos</label><br>";
				$conteudo.="\n\t\t\t\t<button id='arq_processa' type='button' class='bt-enviar' style='margin-left:220px;'>Processar</button>";
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
				//Listagem das baixas a serem feitas (Em aberto)
				$sql_cnb = "
					SELECT
						log_baixas.lote,
						DATE_FORMAT(log_baixas.data_inclusao,'%d/%m/%Y') AS inclusao,
						log_baixas.arquivo,
						count(log_baixas.lote) as Registros,
						log_baixas.instituicao,
						log_baixas.agencia_cedente AS agencia,
						log_baixas.conta_cedente AS Conta,
						log_baixas.nome_cedente AS Cedente,
						log_baixas.importado AS Usuario,
						log_baixas.status AS status
					FROM
						log_baixas
					WHERE
						log_baixas.status=''
					GROUP BY
						log_baixas.lote
					ORDER BY
						log_baixas.data_gravacao ASC
					";
				$query_cnb=@mysql_query($sql_cnb);
				$col_cnab = @mysql_num_fields($query_cnb);
				$conteudo.="\n\t\t\t</div>";
		break;



		case 'Repasse Febrasgo':
			//Para fazer o atualizar, sem sair da Guia
			$cache_repasse = $chave;
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='repasse' id='repasse' action='processa_repasse.php' method='GET' target='_blank' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='g' type='hidden' name='g' size='10' maxlength='10' id='g' value='".base64_encode('carregar')."'\">";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tOp&ccedil;&otilde;es para Gera&ccedil;&atilde;o de Repasses";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				//Busca Por Data
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_cep'>Data de Pagamento:</div>";
				$conteudo.="\n\t\t\t\t<input label='data_inicio' type='text' name='data_inicio' size='10' maxlength='10' id='data_inicio' title='Especifique a data Inicial' value='".date("d/m/Y",time()-3600*24*30)."' onfocus=\"$('#info_data').css({'visibility':'visible'});\" onblur=\"$('#info_data').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\tAt&eacute; <input label='data_fim' type='text' name='data_fim' size='10' maxlength='10' id='data_fim' title='Especifique a data final' value='".date("d/m/Y")."' onfocus=\"$('#info_data').css({'visibility':'visible'});\" onblur=\"$('#info_data').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_data'>Especifique o data Inicial e final.</label><br>";
				//Busca Por local
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_re_local'>Do local:</div>";
				$conteudo.="\n\t\t\t\t<select name='re_local' id='id_re_local'  style='width:130px;' onfocus=\"$('#info_re_local').css({'visibility':'visible'});\" onblur=\"$('#info_re_local').css({'visibility':'hidden'});\">";
				$conteudo.=$local;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_re_local'>Maquina do local Especificada.</label><br>";
				//Busca Por Categoria
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_re_categoria'>Da Categoria:</div>";
				$conteudo.="\n\t\t\t\t<select name='re_categoria' id='re_categoria'  style='width:130px;' onfocus=\"$('#info_re_categoria').css({'visibility':'visible'});\" onblur=\"$('#info_re_categoria').css({'visibility':'hidden'});\">";
				//$conteudo.="\n\t\t\t\t\t<option value='' selected='selected'>Todas</option>";
				foreach ($categorias as $vcat ) {
					if ( (strtolower($vcat)!='falecido') ) {
						$conteudo.="\n\t\t\t\t\t<option value='".$vcat."'>".$vcat."</option>";
					}
				}
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_re_categoria'>Associados da categoria Especificada.</label><br>";
				
				$conteudo.="\n\t\t\t\t<button id='ger_repasse' type='button' class='bt-enviar' style='margin-left:120px;'>Gerar</button>";
				$conteudo.="\n\t\t\t\t</form>";

				//Listagem dos repasses a serem feitos (Em aberto)
				$sql_rep = "
					SELECT
						repasse.arquivo AS arquivos,
						DATE_FORMAT(repasse.data_inclusao,'%d/%m/%Y') AS Inclusao,
						COUNT(repasse.id_financeiro) AS Qtd,
						(SELECT COUNT(repasse.arquivo) FROM repasse WHERE repasse.arquivo=arquivos) AS Lanc,
						SUM(repasse.valor) AS Total,
						repasse.obs AS Detalhes,
						repasse.operador AS Usuario,
						'' AS Finalizado
					FROM
						repasse
					WHERE
						repasse.status=''
					GROUP BY
						repasse.arquivo
					
					UNION
					
					(SELECT
						repasse.arquivo AS arquivos,
						DATE_FORMAT(repasse.data_inclusao,'%d/%m/%Y') AS Inclusao,
						COUNT(repasse.id_associado) AS Qtd,
						(SELECT COUNT(repasse.arquivo) FROM repasse WHERE repasse.arquivo=arquivos) AS Lanc,
						SUM(repasse.valor) AS Total,
						repasse.obs AS Detalhes,
						repasse.operador AS Usuario,
						'Gerar XML' AS Finalizado
					FROM
						repasse
					WHERE
						repasse.status<>''
					GROUP BY
						repasse.arquivo
					ORDER BY
						inclusao ASC
					)
					ORDER BY
						Finalizado DESC,
						DATE_FORMAT(STR_TO_DATE(inclusao,'%d/%m/%Y'), '%Y-%m-%d') DESC
				";
				$query_rep=@mysql_query($sql_rep);
				$col_rep = @mysql_num_fields($query_rep);

				//Tabela das Repasses
				$conteudo.="\n\t\t\t\t<table border='0' align='center' cellpadding='2' cellspacing='4' width='100%'>";
				$conteudo.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$col_rep."' style='color:#E17009;'><span style='color:#1D5987;'>Repasses do Sistema</span></th></tr>\n";

				//Cabeçalho de cada coluna
				$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";
				for ($i=0;$i<$col_rep;$i++) {
					if ( (@mysql_field_name($query_rep,$i)!='qtd')&&(@mysql_field_name($query_rep,$i)!='status') ) {
						$conteudo.="\n\t\t\t\t\t\t<th style='color:#E17009;'>";
						$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ",@mysql_field_name($query_rep,$i))));
						$conteudo.="\n\t\t\t\t\t\t</th>";
					}
				}
				$conteudo.="\n\t\t\t\t\t</tr>";
				while($result_rep=@mysql_fetch_assoc($query_rep)) {
					if ( ($result_rep['Lanc']==$result_rep['Qtd'])||($result_rep['Finalizado']=='') ) {	
						($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
						$conteudo.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;'>\n";
						foreach ($result_rep as $rep_chv=>$rep_vlr) {
							if ( ($rep_chv!='status') ) {
								//Formatnado os campos
								$align = "";
								switch($rep_chv) {
									case 'Total':
										$rep_vlr=number_format($rep_vlr,2,',','.');
										$align = "align='right'";
									break;
									case 'Qtd':
									case 'Lanc':
										$align = "align='right'";
									break;
	
								}
								//Montando as Celulas
								$conteudo.="\t\t\t\t\t<td ".$align." style='padding:2px;";
								if ( $result_rep['Finalizado']=='Gerar XML' ) {
									if (file_exists("repasse_xml/".$result_rep['arquivos'].".xml")) {
										$conteudo.="\n\t\t\t\t\t\t".($rep_chv=='Finalizado'?"text-align:center;'>\n<a href='functions/gera_xml_repasse.php?c=".base64_encode($result_rep['arquivos'])."&d=".md5('save_file')."' title='Download do arquivo' target='_blank' style='font-weight:bolder;color:#2E6E9E;text-decoration:none;'><img src='img/xml.png' border='none' alt='Febrasgo' title='Clique para salvar o arquivo para a Febrasgo'</a>":"'>\n".($rep_vlr));
									}else{
										$conteudo.="\n\t\t\t\t\t\t".($rep_chv=='arquivos'?"'>\n<a href='processa_repasse.php?c=".base64_encode($rep_vlr)."&v=".base64_encode('visualizar')."' title='Visualizar Associados na listagem' target='_blank' style='font-weight:bolder;color:#2E6E9E;text-decoration:none;'>".$rep_vlr."</a>":"'>\n".($rep_vlr));
									}
								}else{
									$conteudo.="\n\t\t\t\t\t\t".($rep_chv=='arquivos'?"'>\n<a href='processa_repasse.php?c=".base64_encode($rep_vlr)."' title='Concluir repasse dos associados' target='_blank' style='font-weight:bolder;color:#2E6E9E;text-decoration:none;'>".$rep_vlr."</a>":"'>\n".($rep_vlr));
								}
								$conteudo.="\n\t\t\t\t\t</td>\n";
							}
						}
						$conteudo.="\n\t\t\t\t</tr>\n";
					}
				}
				$conteudo.="\n\t\t\t\t</table>\n";
			$conteudo.="\n\t\t\t</div>";
		break;

		case "Imprimir Etiquetas":
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='lote_etiqueta' id='lote_etiqueta' action='functions/gera_etiqueta.php' method='GET' target='_blank' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tOp&ccedil;&otilde;es para Gera&ccedil;&atilde;o de Etiquetas";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				//Busca Por CEP
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_cep'>Por CEP:</div>";
				$conteudo.="\n\t\t\t\tDe <input label='cep_inicio' type='text' name='cep_inicio' size='10' maxlength='8' id='cep_inicio' title='Especifique o CEP Inicial' value='00000000' onfocus=\"$('#info_cep').css({'visibility':'visible'});\" onblur=\"$('#info_cep').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\tAt&eacute; <input label='cep_fim' type='text' name='cep_fim' size='10' maxlength='8' id='cep_fim' title='Especifique o CEP final' value='99999999' onfocus=\"$('#info_cep').css({'visibility':'visible'});\" onblur=\"$('#info_cep').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_cep'>Especifique o CEP Inicial e o CEP final.</label><br>";
				//Busca Por local
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_local'>Do local:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_local' id='id_et_local'  style='width:130px;' onfocus=\"$('#info_et_local').css({'visibility':'visible'});\" onblur=\"$('#info_et_local').css({'visibility':'hidden'});\">";
				$conteudo.=$local;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_local'>Maquinas do local Especificado.</label><br>";
				//Busca Por Estado
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_estado'>Do Estado:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_estado' id='id_et_estado'  style='width:130px;' onfocus=\"$('#info_et_estado').css({'visibility':'visible'});\" onblur=\"$('#info_et_estado').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t\t<option value='' selected='selected'>Todos</option>";
				$valores = array("AC"=>"AC","AL"=>"AL","AP"=>"AP","AM"=>"AM","BA"=>"BA","CE"=>"CE","DF"=>"DF","ES"=>"ES","GO"=>"GO","MA"=>"MA","MT"=>"MT","MS"=>"MS","MG"=>"MG","PA"=>"PA","PB"=>"PB","PR"=>"PR","PE"=>"PE","PI"=>"PI","RJ"=>"RJ","RN"=>"RN","RS"=>"RS","RO"=>"RO","RR"=>"RR","SC"=>"SC","SP"=>"SP","SE"=>"SE","TO"=>"TO");
				sort($valores);
				foreach($valores as $v1) {
					$conteudo.="\n\t\t\t\t\t<option value='".$v1."'>".$v1."</option>";
				}
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_estado'>Associados do Estado Especificado.</label><br>";
				//Busca Por Cidades (Apenas as que existem cadastradas)
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_cidade'>Da Cidade:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_cidade' id='id_et_cidade'  style='width:130px;' onfocus=\"$('#info_et_cidade').css({'visibility':'visible'});\" onblur=\"$('#info_et_cidade').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t\t<option value='' selected='selected'>Todas</option>";
				$sql_cid = "SELECT vw_correspondencia.Cidade AS 'Cidades' FROM vw_correspondencia WHERE vw_correspondencia.Cidade<>''  GROUP BY	vw_correspondencia.Cidade COLLATE latin1_german2_ci ORDER BY vw_correspondencia.Cidade";
				$query_cid = @mysql_query($sql_cid);
				while ($cid = @mysql_fetch_assoc($query_cid)) {
					$conteudo.="\n\t\t\t\t\t<option value='".$cid['Cidades']."'>".ucwords(strtolower($cid['Cidades']))."</option>";
				}
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_cidade'>Associados da Cidade Especificada.</label><br>";
				//Busca Por Cidades de Residencia (Apenas as que existem cadastradas)
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_cidade_residencial'>Resida em:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_cidade_residencial' id='id_et_cidade_residencial' style='width:130px;' onfocus=\"$('#info_et_cidade_residencial').css({'visibility':'visible'});\" onblur=\"$('#info_et_cidade_residencial').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t\t<option value='' selected='selected'>Todas</option>";
				$sql_cir = "SELECT vw_correspondencia.Cidade_residencial AS 'Cidade_residencial' FROM vw_correspondencia WHERE vw_correspondencia.Cidade_residencial<>''  GROUP BY	vw_correspondencia.Cidade_residencial COLLATE latin1_german2_ci ORDER BY vw_correspondencia.Cidade_residencial";
				$query_cir = @mysql_query($sql_cir);
				while ($cir = @mysql_fetch_assoc($query_cir)) {
					$conteudo.="\n\t\t\t\t\t<option value='".$cir['Cidade_residencial']."'>".ucwords(strtolower($cir['Cidade_residencial']))."</option>";
				}
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_cidade_residencial'>Cidade de residencia do Associado</label><br>";
				//Busca Por Categoria
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_categoria'>Da Categoria:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_categoria' id='et_categoria'  style='width:130px;' onfocus=\"$('#info_et_categoria').css({'visibility':'visible'});\" onblur=\"$('#info_et_categoria').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t\t<option value='' selected='selected'>Todas</option>";
				foreach ($categorias as $vcat ) {
					if ( (strtolower($vcat)!='falecido') ) {
						$conteudo.="\n\t\t\t\t\t<option value='".$vcat."'>".$vcat."</option>";
					}
				}
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_categoria'>Associados da categoria Especificada.</label><br>";
				//Busca Por Pendencia
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_pendencia'>Tipo Pend&ecirc;ncia:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_pendencia' id='et_pendencia'  style='width:130px;' onfocus=\"$('#info_et_pendencia').css({'visibility':'visible'});\" onblur=\"$('#info_et_pendencia').css({'visibility':'hidden'});\">";
				$conteudo.=$pend;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_pendencia'>Associados com o tipo de Pendencia especificado.</label><br>";
				//Busca Por ATivo/Inativo
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_ativo'>Ativo:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_ativo' id='et_ativo'  style='width:130px;' onfocus=\"$('#info_et_ativo').css({'visibility':'visible'});\" onblur=\"$('#info_et_ativo').css({'visibility':'hidden'});\">";
				$conteudo.=$atv;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_ativo'>Associados Ativos/Inativos ou todos.</label><br>";
				//Ordenação
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_ordem'>Ordena&ccedil;&atilde;o:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_ordem' id='et_ordem'  style='width:130px;' onfocus=\"$('#info_et_ordem').css({'visibility':'visible'});\" onblur=\"$('#info_et_ordem').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t\t<option value='Bairro' >Bairro</option>";
				$conteudo.="\n\t\t\t\t\t<option value='categoria' >Categoria</option>";
				$conteudo.="\n\t\t\t\t\t<option value='CEP' selected='selected'>CEP</option>";
				$conteudo.="\n\t\t\t\t\t<option value='Cidade' >Cidade</option>";
				$conteudo.="\n\t\t\t\t\t<option value='Estado' >Estado</option>";
				$conteudo.="\n\t\t\t\t\t<option value='nome' >Nome</option>";
				$conteudo.="\n\t\t\t\t\t<option value='id_local' >Local</option>";
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_ordem'>Ordena&ccedil;&atilde;o das Etiquetas</label><br>";

				$conteudo.="\n\t\t\t\t<button id='imp_etiqueta' type='button' class='bt-enviar' style='margin-left:220px;'>Gerar</button>";
				$conteudo.="\n\t\t\t\t</form>";


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
			$("#arq_nivel").click(function(event){
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
				});
			});


			//Desconto
			$("#arq_desconto").click(function(event){
				event.preventDefault();
				var vl_par =$("#param_desc").attr("value");
				var id_desc =$("#mot_desc").attr("value");
				var id_leitura = <?= $dados_ult_leit['id_leitura'] ?>;
				var vl_desc =$("#desconto").attr("value");
				
				$('<div id="agd_proc_regiao" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_local").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,mot:id_desc,leit:id_leitura,valor:vl_desc},function(json){
					$("#arq_desconto").attr('disabled','');
					$("#agd_proc_reg").remove();
					if(json=='Registro incluido com sucesso')
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
							location="leitura.php";
						}
					}
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