<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
//include('functions/lg_validador.php');

$flag = $_GET['flag'];


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
	//Caso n�o tenha acesso carrega guias comuns
	//$acoes = array('N�veis','Usu�rios','Lotes');
	$acoes = array('Locais');
}else{
	//Se tiver acesso, exibe todas as guias
	$acoes = array('Niveis','Usuarios','Cidade','Locais','Interface','Maquinas');
	
	if($flag=="cidade")
	{
		$acoes = array('Cidade');
	}
	else if($flag=="local")
	{
		$acoes = array('Locais');
	}
	else if($flag=="maquina")
	{
		$acoes = array('Maquinas');
	}
	else if($flag=="usuario")
	{
		$acoes = array('Usuarios');
	}	
	
}

//Pegando os locais para utilizar na pagina
$sql_reg = "
	SELECT
		local.id_local,
		local.nome
	FROM
		local
	WHERE
		local.id_local IN (".$_SESSION['reg_acesso'].")
		AND local.excluido='N'
	ORDER BY
		local.nome
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


//Montando as Combos de Sele��o de local.
$local="";
while ( $dados_reg=@mysql_fetch_assoc($query_reg) ) {
	$local.= "\n\t\t\t\t\t<option value='".$dados_reg['id_local']."'>".$dados_reg['nome']."</option>";
}

//Montando as Combos de Sele��o de clientes.
$cliente="";
while ( $dados_cli=@mysql_fetch_assoc($query_cli) ) {
	$cliente.= "\n\t\t\t\t\t<option value='".$dados_cli['id_cliente']."'>".$dados_cli['nome']."</option>";
}

//Montando as Combos de Sele��o de Lotes.
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
		case "Niveis":
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_nivel' id='create_nivel' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='param_nv' size='30' id='param_nv' value='".base64_encode('nivel')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tCriar Novo N�vel:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				//Informa��es do N�vel
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_nivel'>Descri&ccedil;&atilde;o do N&iacute;vel:</div>";
				$conteudo.="\n\t\t\t\t<input label='Nivel' type='text' name='descricao' size='30' id='descricao' title='Informe o nome do N�vel a ser criado' value='' onfocus=\"$('#info_add_nivel').css({'visibility':'visible'});\" onblur=\"$('#info_add_nivel').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_add_nivel'>Descri&ccedil;&atilde;o do N&iacute;vel</label><br>";
				$conteudo.="\n\t\t\t\t<button id='arq_nivel' type='button' class='bt-enviar' style='margin-left:220px;'>Criar N&iacute;vel</button>";
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";
		break;
	
		case "Usuarios":
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_usuario' id='create_usuario' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tCriar Novo Usu�rio:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				//Informa��es do usu�rio
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='param_usr' size='30' id='param_usr' value='".base64_encode('usuario')."' />";
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_usr_nome'>Nome do Usu�rio:</div>";
				$conteudo.="\n\t\t\t\t<input label='usr_nome' type='text' name='usr_nome' size='40' id='usr_nome' title='Informe o nome do usu�rio' value='' onfocus=\"$('#info_usr_nome').css({'visibility':'visible'});\" onblur=\"$('#info_usr_nome').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_usr_nome'>Informe o nome do Usu�rio</label><br>";

				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_usr_login'>Login do Usu�rio:</div>";
				$conteudo.="\n\t\t\t\t<input label='usr_usuario' type='text' name='usr_usuario' autocomplete='off' size='25' id='usr_usuario' title='Informe o login do usu�rio' value='' onfocus=\"$('#info_usr_login').css({'visibility':'visible'});\" onblur=\"$('#info_usr_login').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_login'>Informe o login do Usu�rio</label><br>";

				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_usr_senha'>Senha do Usu�rio:</div>";
				$conteudo.="\n\t\t\t\t<input label='usr_senha' type='password' name='usr_senha' autocomplete='off' size='25' id='usr_senha' title='Informe a senha do usu�rio' value='' onfocus=\"$('#info_usr_senha').css({'visibility':'visible'});\" onblur=\"$('#info_usr_senha').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_usr_senha'>Informe a senha do Usu�rio</label><br>";

				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_usr_email'>Email do Usu�rio:</div>";
				$conteudo.="\n\t\t\t\t<input label='usr_email' type='text' name='usr_email' autocomplete='off' size='40' id='usr_email' title='Informe o email do usu�rio' value='' onfocus=\"$('#info_usr_email').css({'visibility':'visible'});\" onblur=\"$('#info_usr_email').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_usr_email'>Informe o email do Usu�rio</label><br>";

				//Niveis Dispon�veis
				$sql_nv = "
					SELECT
						nivel.id_nivel,
						nivel.Descricao,
						COUNT(logins.id_login) AS qtd
					FROM
						nivel
						LEFT JOIN logins ON logins.id_nivel=nivel.id_nivel
							AND logins.excluido='N'
					WHERE
						nivel.excluido='N'
					GROUP BY
						nivel.id_nivel
					ORDER BY
						nivel.Descricao
				";
				$query_nv = @mysql_query($sql_nv);
				//Montando as Combos de Niveis.
				$nv = '';
				while ( $dados_nv=@mysql_fetch_assoc($query_nv) ) {
					$nv.= "\n\t\t\t\t\t<option value='".$dados_nv['id_nivel']."'>".$dados_nv['Descricao']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_usr_nivel'>N&iacute;vel do Usu&aacute;rio:</div>";
				$conteudo.="\n\t\t\t\t<select name='usr_nv' id='usr_nv'  style='width:130px;' onfocus=\"$('#info_usr_nivel').css({'visibility':'visible'});\" onblur=\"$('#info_usr_nivel').css({'visibility':'hidden'});\">";
				$conteudo.=$nv;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_usr_nivel'>N&iacutevel do usu&aacute;rio.</label><br>";

				$conteudo.="\n\t\t\t\t<button id='arq_usr' type='button' class='bt-enviar' style='margin-left:220px;'>Criar Usu&aacute;rio</button>";
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";
		break;
		
		case "Lotes":
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='lote_cartao' id='lote_cartao' action='functions/gera_lote.php' method='GET' target='_blank' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tOp&ccedil;&otilde;es para Gera&ccedil;&atilde;o de Lotes";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";

				//Sequencia
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_seq'>Numera��o de:</div>";
				$conteudo.="\n\t\t\t\tDe <input label='seq_inicio' type='text' name='seq_inicio' size='10' maxlength='8' id='seq_inicio' title='Especifique o numero Inicial' value='00000000' onfocus=\"$('#info_seq').css({'visibility':'visible'});\" onblur=\"$('#info_seq').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\tAt&eacute; <input label='seq_fim' type='text' name='seq_fim' size='10' maxlength='8' id='seq_fim' title='Especifique o numero final' value='99999999' onfocus=\"$('#info_seq').css({'visibility':'visible'});\" onblur=\"$('#info_seq').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_seq'>Especifique o numero Inicial e final.</label><br>";

				//Tipo
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_tipo'>Gerar lote de:</div>";
				$conteudo.="\n\t\t\t\t<select name='tipo' id='tipo'  style='width:130px;' onfocus=\"$('#info_tipo').css({'visibility':'visible'});\" onblur=\"$('#info_tipo').css({'visibility':'hidden'});\">";
				$conteudo.=$atv;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_tipo'>Tipo de lote a ser gerado.</label><br>";

				//Local dos cart�es
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_et_local'>Local do lote:</div>";
				$conteudo.="\n\t\t\t\t<select name='et_local' id='id_et_local'  style='width:130px;' onfocus=\"$('#info_et_local').css({'visibility':'visible'});\" onblur=\"$('#info_et_local').css({'visibility':'hidden'});\">";
				$conteudo.=$local;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_et_local'>Local que receber� o cart�o.</label><br>";

				$conteudo.="\n\t\t\t\t<br />";
				$conteudo.="\n\t\t\t\t<button id='ger_cartao' type='button' class='bt-enviar' style='margin-left:220px;'>Gerar</button>";
				$conteudo.="\n\t\t\t\t</form>";


			$conteudo.="\n\t\t\t</div>";
		break;

		/*
		case "Locais":
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_local' id='create_local' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='param_lc' size='30' id='param_lc' value='".base64_encode('local')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tCadastrar Novo Local:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				
				//Informa��es do Local
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Descri&ccedil;&atilde;o do Local:</div>";
				$conteudo.="\n\t\t\t\t<input label='Local' type='text' name='lc_nome' size='30' id='lc_nome' title='Informe o nome do Local a ser criado' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_local'>Nome do local</label><br>";
				
				//Rut
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local_rut'>RUT do Local:</div>";
				$conteudo.="\n\t\t\t\t<input label='Rut' type='text' name='lc_rut' autocomplete='off' size='24' id='lc_rut' title='Informe o RUT do Local' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.=" - ";
				$conteudo.="<input label='Digito' type='text' name='local_rut_dig' autocomplete='off' size='2' id='local_rut_dig' title='Informe o Digito do Rut' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="&nbsp; ex: 12345678 - 0";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_dig'>Informe o Digito do Rut</label>
				<br>";

				
				//Endereco
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Endereco:</div>";
				$conteudo.="\n\t\t\t\t<input label='Endereco' type='text' name='lc_end' size='30' id='lc_end' title='Informe o endereco do local a ser cadastrado' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_end'>Endereco do local</label><br>";							
				
				
				//Envia form
				$conteudo.="\n\t\t\t\t<button id='arq_local' type='button' class='bt-enviar' style='margin-left:220px;'>Criar Local</button>";
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";
		break;*/
		
		case "Locais":
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_local' id='create_local' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='param_lc' size='30' id='param_lc' value='".base64_encode('local')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tCadastrar Novo Local:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				
				
				
				//Regiao
				$sql_reg = "
					SELECT
						regiao.id_cidade,
						regiao.nome_cidade
					FROM
						regiao
					GROUP BY
						regiao.id_cidade
					ORDER BY
						regiao.nome_cidade
				";
				$query_reg = @mysql_query($sql_reg);
				//Montando as Combos de regiaoes.
				$reg = '';
				while ( $dados_reg=@mysql_fetch_assoc($query_reg) ) {
					$reg.= "\n\t\t\t\t\t<option value='".$dados_reg['id_cidade']."'>".$dados_reg['nome_cidade']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_lc_reg'>Cidade:</div>";
				$conteudo.="\n\t\t\t\t<select name='lc_reg' id='lc_reg'  style='width:130px;' onfocus=\"$('#info_lc_ope').css({'visibility':'visible'});\" onblur=\"$('#info_lc_ope').css({'visibility':'hidden'});\">";
				$conteudo.=$reg;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_jogo'>Cidade do Local.</label><br>";					

				//Tipo de local
				$sql_tp_loc = "
					SELECT
						tipo_local.id_tp_local,
						tipo_local.tp_local
					FROM
						tipo_local
					GROUP BY
						tipo_local.id_tp_local
					ORDER BY
						tipo_local.tp_local
				";
				$query_tp_loc = @mysql_query($sql_tp_loc);
				//Montando as Combos de regiaoes.
				$tp_loc = '';
				while ( $dados_tp_loc=@mysql_fetch_assoc($query_tp_loc) ) {
					$tp_loc.= "\n\t\t\t\t\t<option value='".$dados_tp_loc['id_tp_local']."'>".$dados_tp_loc['tp_local']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_tp_loc'>Tipo Local:</div>";
				$conteudo.="\n\t\t\t\t<select name='tp_loc' id='tp_loc'  style='width:130px;' onfocus=\"$('#info_tp_loc').css({'visibility':'visible'});\" onblur=\"$('#info_tp_loc').css({'visibility':'hidden'});\">";
				$conteudo.=$tp_loc;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_tp_loc'>Tipo do Local.</label><br>";					

				
				
				//Informa��es do Local
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Descri&ccedil;&atilde;o do Local:</div>";
				$conteudo.="\n\t\t\t\t<input label='Local' type='text' name='lc_nome' size='30' id='lc_nome' title='Informe o nome do Local a ser criado' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_local'>Nome do local</label><br>";
				
				
				//Informa��es do Local
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Razao Social:</div>";
				$conteudo.="\n\t\t\t\t<input label='Local' type='text' name='lc_razao' size='30' id='lc_razao' title='Informe a razao social do cliente' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_local'>Nome do local</label><br>";				
				
				//Rut
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local_rut'>RUT do Local:</div>";
				$conteudo.="\n\t\t\t\t<input label='Rut' type='text' name='lc_rut' autocomplete='off' size='24' id='lc_rut' title='Informe o RUT do Local' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.=" - ";
				$conteudo.="<input label='Digito' type='text' name='local_rut_dig' autocomplete='off' size='2' id='local_rut_dig' title='Informe o Digito do Rut' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="&nbsp; ex: 12345678 - 0";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_dig'>Informe o Digito do Rut</label>
				<br>";

				
				//Endereco
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Endereco:</div>";
				$conteudo.="\n\t\t\t\t<input label='Endereco' type='text' name='lc_end' size='30' id='lc_end' title='Informe o endereco do local a ser cadastrado' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_end'>Endereco do local</label><br><br />
";	
				
				//Responsavel
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Responsavel:</div>";
				$conteudo.="\n\t\t\t\t<input label='Endereco' type='text' name='lc_resp' size='30' id='lc_resp' title='Informe o endereco do local a ser cadastrado' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_end'>Endereco do local</label><br>";
				
				//Responsavel
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>Contato:</div>";
				$conteudo.="\n\t\t\t\t<input label='Endereco' type='text' name='lc_cont' size='30' id='lc_cont' title='Informe o endereco do local a ser cadastrado' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_end'>Endereco do local</label><br><br />";															

				//operador
				$sql_ope = "
					SELECT
						logins.id_login,
						logins.nome,
						COUNT(logins.id_login) AS qtd
					FROM
						logins
					GROUP BY
						logins.id_login
					ORDER BY
						logins.nome
				";
				$query_ope = @mysql_query($sql_ope);
				//Montando as Combos de Operadores.
				$ope = '';
				while ( $dados_ope=@mysql_fetch_assoc($query_ope) ) {
					$ope.= "\n\t\t\t\t\t<option value='".$dados_ope['id_login']."'>".$dados_ope['nome']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_lc_ope'>Operador:</div>";
				$conteudo.="\n\t\t\t\t<select name='lc_ope' id='lc_ope'  style='width:130px;' onfocus=\"$('#info_lc_ope').css({'visibility':'visible'});\" onblur=\"$('#info_lc_ope').css({'visibility':'hidden'});\">";
				$conteudo.=$ope;
				$conteudo.="\n\t\t\t\t</select>";				
				$conteudo.="\n\t\t\t\t<input label='Porcentagem' type='text' name='lc_pct_ope' size='5' id='lc_pct_ope' title='Informe o % do operador do local' value='' onfocus=\"$('#info_pct_ope').css({'visibility':'visible'});\" onblur=\"$('#info_pct_ope').css({'visibility':'hidden'});\"> &nbsp;%";				
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_jogo'>Operador do Local.</label><br>";
				
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_lc_ger'>Gerente:</div>";
				$conteudo.="\n\t\t\t\t<select name='lc_ger' id='lc_ger'  style='width:130px;' onfocus=\"$('#info_lc_ger').css({'visibility':'visible'});\" onblur=\"$('#info_lc_ger').css({'visibility':'hidden'});\">";
				$conteudo.=$ope;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<input label='Porcentagem' type='text' name='lc_pct_ger' size='5' id='lc_pct_ger' title='Informe o % do gerente do local' value='' onfocus=\"$('#info_pct_ger').css({'visibility':'visible'});\" onblur=\"$('#info_pct_ger').css({'visibility':'hidden'});\"> &nbsp;%";			
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_jogo'>Gerente do Local.</label><br>";				
				


				//Percentual
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_local'>% Local:</div>";
				$conteudo.="\n\t\t\t\t<input label='Porcentagem' type='text' name='lc_pct' size='5' id='lc_pct' title='Informe o % do local a ser cadastrado' value='' onfocus=\"$('#info_pct_local').css({'visibility':'visible'});\" onblur=\"$('#info_pct_local').css({'visibility':'hidden'});\"> &nbsp;%";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_pct'>% do local</label><br>";														
			
				
				//Envia form
				$conteudo.="\n\t\t\t\t<button id='arq_local' type='button' class='bt-enviar' style='margin-left:220px;'>Criar Local</button>";
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
				//Sele��o do Arquivo
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

				//Tabela das baixas
				/*
				$conteudo.="\n\t\t\t\t<table border='0' align='center' cellpadding='2' cellspacing='4' width='100%'>";
				$conteudo.="\n\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$col_cnab."' style='color:#E17009;'><span style='color:#1D5987;'>Baixas em aberto no Sistema</span></th></tr>\n";

				//Cabe�alho de cada coluna
				$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";
				for ($i=0;$i<$col_cnab;$i++) {
					if ( (@mysql_field_name($query_cnb,$i)!='qtd')&&(@mysql_field_name($query_cnb,$i)!='status') ) {
						$conteudo.="\n\t\t\t\t\t\t<th style='color:#E17009;'>";
						$conteudo.="\n\t\t\t\t\t\t\t".ucwords(strtolower(str_replace("_"," ",@mysql_field_name($query_cnb,$i))));
						$conteudo.="\n\t\t\t\t\t\t</th>";
					}
				}
				$conteudo.="\n\t\t\t\t\t</tr>";
			
				while($result_cnb=@mysql_fetch_assoc($query_cnb)) {
					($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
					$conteudo.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;' align='center'>\n";
					foreach ($result_cnb as $cnb_chv=>$cnb_vlr) {
						if ( ($cnb_chv!='qtd')&&($cnb_chv!='status') ) {
							$conteudo.="\t\t\t\t\t<td>\n";
							$conteudo.="\n\t\t\t\t\t\t".($cnb_chv=='lote'?"<a href='processa_cnab.php?c=".base64_encode($cnb_vlr)."' title='Efetuar baixa dos titulos' target='_blank' style='font-weight:bolder;color:#2E6E9E;text-decoration:none;'>".$cnb_vlr."</a>":htmlentities($cnb_vlr));
							$conteudo.="\n\t\t\t\t\t</td>\n";
						}
					}
					$conteudo.="\n\t\t\t\t</tr>\n";
				}
				$conteudo.="\n\t\t\t\t</table>\n";
				*/
				$conteudo.="\n\t\t\t</div>";
		break;

		case "Cidade":
				$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_regiao' id='create_regiao' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param' type='hidden' name='param_reg' size='30' id='param_reg' value='".base64_encode('regiao')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tCadastrar Nova Cidade:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				//Informa��es do N�vel
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_regiao'>Descri&ccedil;&atilde;o da Cidade:</div>";
				$conteudo.="\n\t\t\t\t<input label='Cidade' type='text' name='reg_nome' size='30' id='reg_nome' title='Informe o nome da Cidade a ser criado' value='' onfocus=\"$('#info_loc_local').css({'visibility':'visible'});\" onblur=\"$('#info_loc_local').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_loc_regiao'>Nome da Cidade</label><br>";
				$conteudo.="\n\t\t\t\t<button id='arq_reg' type='button' class='bt-enviar' style='margin-left:220px;'>Criar Cidade</button>";
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";
		break;
	
		case "Interface":
				$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_interface' id='create_interface' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param_int' type='hidden' name='param_int' size='30' id='param_int' value='".base64_encode('interface')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tCadastrar Interface:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";
				//Informa��es do N�vel
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_regiao'>Numero de Interface:</div>";
				$conteudo.="\n\t\t\t\t<input label='numero' type='text' name='numero' size='30' id='numero' title='Informe onumero da Interface' value='' onfocus=\"$('#info_num_interface').css({'visibility':'visible'});\" onblur=\"$('#info_num_interface').css({'visibility':'hidden'});\"><br/>";

				//jogo
				$sql_jog = "
					SELECT
						jogo.id_jogo,
						jogo.nome,
						COUNT(jogo.id_jogo) AS qtd
					FROM
						jogo
					GROUP BY
						jogo.id_jogo
					ORDER BY
						jogo.nome
				";
				$query_jog = @mysql_query($sql_jog);
				//Montando as Combos de Jogos.
				$jog = '';
				while ( $dados_jog=@mysql_fetch_assoc($query_jog) ) {
					$jog.= "\n\t\t\t\t\t<option value='".$dados_jog['id_jogo']."'>".$dados_jog['nome']."</option>";
				}
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_int_jogo'>Jogo:</div>";
				$conteudo.="\n\t\t\t\t<select name='int_jog' id='int_jog'  style='width:130px;' onfocus=\"$('#info_int_jogo').css({'visibility':'visible'});\" onblur=\"$('#info_int_jogo').css({'visibility':'hidden'});\">";
				$conteudo.=$jog;
				$conteudo.="\n\t\t\t\t</select>";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_int_jogo'>Jogo da interface.</label><br>";
				$conteudo.="\n\t\t\t\t<button id='arq_int' type='button' class='bt-enviar' style='margin-left:220px;'>Cadastrar</button>";				
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
				$conteudo.="\n\t\t\t\t<br /><input label='param' type='hidden' name='param_maq' size='30' id='param_maq' value='".base64_encode('maquina')."' />";
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
					WHERE
						local.excluido = 'N'						
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
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_loc'>Local da Maquina.</label><br><br />
<br />";


				//divide tela de cadastro por Particularidades da maquina
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\t Cadastros especiais:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' />";


				//Numero de maq
				$conteudo.="\n\t\t\t\t<br /><div class='lbl' id='lbl_maq_por'>Maq % especial:</div>";
				$conteudo.="\n\t\t\t\t<input label='maq_por' type='text' name='maq_por' size='5' id='maq_por' title='Informe a porcentagem da maquina (ex: Pachinko 60%)' value='' onfocus=\"$('#info_maq_por').css({'visibility':'visible'});\" onblur=\"$('#info_maq_por').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_por'>Informe a porcentagem da maquina (ex: Pachinko 60%)</label><br>";


				//Maquina de socio
				$conteudo.="\n\t\t\t\t<div class='lbl' id='lbl_maq_soc'>Maquina de socio:</div>";
				$conteudo.="\n\t\t\t\t<input label='maq_soc' type='checkbox' name='maq_soc' id='maq_soc' class='acao' title='Maquina de socio?'\"><br>";
				
				//Numero de maq
				$conteudo.="\n\t\t\t\t<div class='lbl' id='maq_por_soc' style='display:none;'>% do Socio:</div>";
				$conteudo.="\n\t\t\t\t<input label='lbl_maq_por_soc' type='text' name='lbl_maq_por_soc' size='5' id='lbl_maq_por_soc' title='Informe a porcentagem do socio refetente a essa maquina (ex: Policia y ladron 20%)' value='' style='display:none;' onfocus=\"$('#info_maq_por_soc').css({'visibility':'visible'});\" onblur=\"$('#info_maq_por_soc').css({'visibility':'hidden'});\">";
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_maq_por_soc'>Informe a porcentagem do socio refetente a essa maquina (ex: Policia y ladron 20%)</label><br>";				

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
				//Sele��o do Arquivo
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

				//Cabe�alho de cada coluna
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
				//Ordena��o
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
		
			$('.acao').click(function()
			{ /* Quando usuario clica no bot�o ele executa est� a��o*/
				$('#maq_por_soc').slideToggle('slow');
				$('#lbl_maq_por_soc').slideToggle('slow');

			});		
		
		
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
				var vl_rz_soc =$("#lc_razao").attr("value");
				var vl_resp =$("#lc_resp").attr("value");
				var vl_cont_resp =$("#lc_cont").attr("value");
				
				//continuar *Erico		
				var vl_ger =$("#lc_ger").attr("value");
				var vl_pct_ger =$("#lc_pct_ger").attr("value");
				var vl_pct_ope =$("#lc_pct_ope").attr("value");
				
				
				$('<div id="agd_proc_local" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_local").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,nome:vl_nom,rut:vl_rut,dig:vl_dig,end:vl_end,ope:vl_ope,pct:vl_pct,reg:vl_reg,tp_loc:vl_tp_loc,razao_social:vl_rz_soc,resp_loc:vl_resp,cont_resp:vl_cont_resp,id_ger:vl_ger,pct_ger:vl_pct_ger,pct_ope:vl_pct_ope},function(json){
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
				var maq_soc =$("#maq_soc").attr("checked");
				var porc_soc =$("#lbl_maq_por_soc").attr("value");
				
				
				
				
				$('<div id="agd_proc_local" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_nivel');
				$("#arq_maq").attr('disabled','disabled');
				$.post('add_registro.php', {param:vl_par,num:vl_num,gab:vl_mod,jog:vl_jog,loc:vl_loc,obs:vl_obs,porc:vl_porc,flag_soc:maq_soc,pct_soc:porc_soc},function(json){
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
				if (confirm('Aten��o!\n\nDeseja realmente gerar o Lote especificado.\nEsta opera��o poder� levar varios minutos.\nN�o feche a janela que se abrir�.\nEla ser� fechada automaticamente ao t�rmino da opera��o')) {
					$("#lote_cartao").submit();
				}else{
					return false;
				};
			});

			//Responsavel por validar o envio do arquivo de retorno
			$("#arq_processa").click( function () {
				if ( $("#file").val()=='' ) {
					alert('Voce deve selecionar o arquivo antes de process�-lo');
					return false;
				}else if (confirm('Aten��o!\n\nDeseja realmente Processar o arquivo do banco.\nEsta opera��o poder� levar varios minutos.\nN�o feche a janela que se abrir�.')) {
					$("#arq_baixa").submit();
				}else{
					return false;
				};
			});
			
			//Responsavel por Gerar os repasses. Pega os campos do form e passa para o popup via GET			
			$("#ger_repasse").click( function () {
				if (confirm('Aten��o!\n\nDeseja realmente gerar o arquivo de Repasses.\nEsta opera��o poder� levar v�rios minutos.\nN�o feche a janela que se abrir�.\nEla ser� fechada automaticamente ao t�rmino da opera��o')) {
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