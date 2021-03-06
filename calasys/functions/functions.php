<?php

setlocale(LC_CTYPE,"pt_BR");

date_default_timezone_set( "America/Sao_Paulo" );

header("Content-Type: text/html; charset=ISO-8859-1", true);

//Montando o Painel de Entrada do Administrativo

//####################################################################

function painel_builder() {

	//ID 7 = SAIR. O Union server para sempre trazer o Botão sair, pois serão selecionado apenas 12 itens no maximo.

	$cmd = "

		SELECT

			menu.*

		FROM

			menu

			INNER JOIN acesso ON acesso.id_menu=menu.id_menu

				AND acesso.id_nivel=".$_SESSION['usr_nivel']."

				AND acesso.acesso='S'

		WHERE

			menu.excluido='N'

			AND menu.id_menu<>7

		LIMIT 30

		

		UNION

		

		SELECT

			menu.*

		FROM

			menu

		WHERE

			menu.id_menu = 7

		ORDER BY

			ordem ASC

	";

	$sql = @mysql_query($cmd);

	//Montando as DIVS dos botoes do Menu

	$mnu="";

	while ( $menu = @mysql_fetch_assoc($sql) ) {

		$mnu.="\n\t\t\t<div id='div_button' onclick='window.location.href=\"".$menu['link']."\"' title='".htmlentities($menu['nome'])."'>";

		$mnu.="\n\t\t\t\t<br />";

		$mnu.="\n\t\t\t\t<img src='img/menu/".$menu['icone']."' alt='".htmlentities($menu['nome'])."' border='none' title='".htmlentities($menu['nome'])."' /><br />".htmlentities($menu['nome']);

		$mnu.="\n\t\t\t</div>\n";

	}

	return $mnu."\n";

}





function caixa_builder() {

	//ID 7 = SAIR. O Union server para sempre trazer o Botão sair, pois serão selecionado apenas 12 itens no maximo.

	$cmd = "

		SELECT

			integracao.*

		FROM

			integracao

		ORDER BY

			integracao.id_integracao

	";

	$sql = @mysql_query($cmd);

	//Montando as DIVS dos botoes do Menu

	$mnu="";

	while ( $menu = @mysql_fetch_assoc($sql) ) {

		

		//pinga cada local para ver se tem conexao

		$ping = "ping -c 1 " . $menu['hostname'];

		exec($ping, $saida, $retorno);

		if($retorno == 0)

		{

			$status =  "<img src='img/online.png' border='none' title='ON' /> ONLINE";

		}

		else

		{

			$status = "<img src='img/offline.png' border='none' title='ON' /> OFFLINE";

		}

	

		//consulta o nome do local

		$sql_loc = "

			SELECT

				nome

			FROM

				local

			WHERE

				local.id_local = '".$menu['id_local']."'

			";

		$query_loc=@mysql_query($sql_loc);

		$resultado_loc=@mysql_fetch_assoc($query_loc);	

	

		$mnu.="\n\t\t\t<a id='div_button_".$menu['id_integracao']."' name='modal' title='".htmlentities($menu['hostname'])."' class='div_button' onclick='concecta_local(this);'>";

		$mnu.="\n\t\t\t\t". $status;

		$mnu.="\n\t\t\t\t<img src='img/casa.png' alt='".htmlentities($menu['id_integracao'])."' border='none' title='".htmlentities($menu['id_integracao'])."' /><br />".htmlentities($resultado_loc['nome']);

		$mnu.="\n\t\t\t</a>\n";

	}

	return $mnu."\n";

}







//######################################################

//Montando o Menu de Entrada do Administrativo

//####################################################################

function menu_builder() {

	//ID 7 = SAIR. O Union server para sempre trazer o Botão sair, pois serão selecionado apenas 12 itens no maximo.

	$cmd = "

		SELECT

			menu.*

		FROM

			menu

			INNER JOIN acesso ON acesso.id_menu=menu.id_menu

				AND acesso.id_nivel=".$_SESSION['usr_nivel']."

				AND acesso.acesso='S'

		WHERE

			menu.excluido='N'

			AND menu.id_menu<>7

		LIMIT 11

		

		UNION

		

		SELECT

			menu.*

		FROM

			menu

		WHERE

			menu.id_menu = 7

		ORDER BY

			ordem ASC

	";



	$sql = @mysql_query($cmd);

	//Montando as LIs com os Menus

	

	$mnu="\n<div id='menu_topo'>";

	$mnu.="\n\t<div class='ui-widget-header ui-corner-all' style='height:22px;margin-top:3px;width:99%'><ul class='jd_menu jd_menu_slate'>";

	$mnu.= "\n\t\t<li onmouseover=\"this.className='ui-state-default'\" onmouseout=\"this.className=''\">";

	$mnu.= "\n\t\t\t<img src='img/menu/home.png' title='Inicio' alt='Inicio' align='absmiddle' height='16px;' onclick='window.location.href=\"main.php\"'> ";

	//$mnu.= "<strong style='font-size:11px;'onclick='window.location.href=\"main.php\"'>Home</strong>";

	$mnu.="\n\t\t</li>";

	$mnu.="\n\t\t<li onmouseover='this.style.padding=\"3px 2px 1px 6px\";this.style.backgroundColor=\"transparent\";this.style.borderColor=\"transparent\";this.style.cursor=\"default\";'>\n\t\t\t|\n\t\t</li>";

	while ( $menu = @mysql_fetch_assoc($sql) ) {

		$item=explode(' ',$menu['nome']);

		$mnu.= "\n\t\t<li onmouseover=\"this.className='ui-state-hover'\" onmouseout=\"this.className=''\">";

		//$mnu.= "<img src='img/menu/".$menu['icone']."' title='".$menu['nome']."' alt='".$menu['nome']."' align='absmiddle' height='16px;'> ";

		$mnu.= "\n\t\t\t<strong style='font-size:11px;' onclick='window.location.href=\"".$menu['link']."\"' title='".htmlentities($menu['nome'])."'>".$item[0]."</strong>";

		//Caso o Menu tenha um submenu, monta o submenu.

		$cmd_sub = "

			SELECT

				menu_itens.*

			FROM

				menu_itens

			WHERE

				menu_itens.id_menu=".$menu['id_menu']."

				AND menu_itens.excluido='N'

			ORDER BY

				menu_itens.ordem

			";

		$itens = 0;

		$sql_sub = @mysql_query($cmd_sub);

		$itens = @mysql_num_rows($sql_sub);

		if ($itens>=1) {

			$mnu.="\n\t\t\t<ul>";

			while ( $menu_itens = @mysql_fetch_assoc($sql_sub) ) {

				$mnu.="\n\t\t\t\t<li class='ui-widget-header ui-corner-all' style='border-color:#FFFFFF;margin-bottom:1px;width:140px;' onmouseover=\"this.className='ui-state-hover'\" onmouseout=\"this.className='ui-widget-header ui-corner-all'\">";

				$mnu.="\n\t\t\t\t<span onclick='window.location.href=\"".$menu_itens['link']."\"' title='".htmlentities($menu_itens['nome'])."'>".$menu_itens['nome']."</span>";

				$mnu.="\n\t\t\t\t</li>";

			}

			$mnu.="\n\t\t\t</ul>";

		}

		$mnu.="\n\t\t</li>";

		$mnu.="\n\t\t<li onmouseover='this.style.padding=\"3px 2px 1px 6px\";this.style.backgroundColor=\"transparent\";this.style.borderColor=\"transparent\";this.style.cursor=\"default\";'>\n\t\t\t|\n\t\t</li>";

	}

	

	//Responsavel pelo Trocar senha do usuario. Aparece para qualquer nivel.

	$mnu.= "\n\t\t<li onmouseover=\"this.className='ui-state-default'\" onmouseout=\"this.className=''\" style=\"float:right;\">";

	$mnu.= "\n\t\t\t<img src='img/menu/senha.png' title='Trocar a senha' alt='Trocar a senha' align='absmiddle' height='16px;' onclick='abre_janela(\"senha.php\",350,215)'> ";

	$mnu.="\n\t\t</li>";



	$mnu.="\n\t\t</ul>";

	$mnu.="\n\t</div>";

	$mnu.="\n</div>";

	return $mnu."\n";

}

//####################################################################

//Removendo Acentos da Frase

//####################################################################

function RetirarAcentos ($frase) {

	$frase = str_replace(

							array("à","á","â","ã","ä","è","é","ê","ë","ì","í","î","ï","ò","ó","ô","õ","ö","ù","ú","û","ü","À","Á","Â","Ã","Ä","È","É","Ê","Ë", "Ì","Í","Î","Ò","Ó","Ô","Õ","Ö","Ù","Ú","Û","Ü","ç","Ç","ñ","Ñ","ª","º","'"),

							array("a","a","a","a","a","e","e","e","e","i","i","i","i","o","o","o","o","o","u","u","u","u","A","A","A","A","A","E","E","E","E","I","I","I","O","O","O","O","O","U","U","U","U","c","C","n","N","a.","o.","`"),

							$frase

						);

	return $frase;                           

}



//################################################

//Validando o CPF/CNPJ

//################################################

function CPF_CPNJ($campo, $tipo='CPF') {

	//Tamanho do Campo

	$dig = (strtoupper($tipo)=='CPF'?11:14);

	$filtro=array();

	$validado=true;



	//Montando o Filtro dos Valores(111...,222..,333..., etc)

	for ($i=0;$i<10;$i++) {

		$filtro[$i]=str_repeat($i,$dig);

	}



	//Filtrando os Valores

	if (strlen($campo)== $dig) {

 		foreach ($filtro as $chave=>$valor) {

			if ($campo==$filtro[$chave]) {

				$validado=false;

			}

		}

	}else{

		$validado=false;

	}



	if ($dig==11) {

		//Validando o CPF

		for ($t=$dig-2; $t<$dig;$t++) {

			for ($d=0, $c=0; $c<$t; $c++) {

				$d += $campo{$c}*(($t+1)- $c);

			}

			$d=((($dig-1) * $d)%11)%10;

	

			if ($campo{$c}!=$d) {

				$validado=false;

				break;

			}

		}

		return $validado;

	}else{

		//Validando o CNPJ

		for ($t=$dig-2; $t<$dig;$t++) {

			$v=1;

			$c1=0;

			for ($d=0, $c=($t==12?6:5); $c<=9; $c++) {

				$d += $campo{$c1}*($c);

				if ($v==1&&$c==9) {

					$c=1;

					$v=2;

				}

				$c1++;

			}

			$d=(($d)%11)%10;

	

			if ($campo{$c1}!=$d) {

				$validado=false;

				break;

			}

		}

		return $validado;

	}

}



//################################################

//Validando o RUT

//################################################

function valida_rut($campo, $dig) 

{

	$rut=$campo;

	$dv=$dig;

	$validado=true;

	

	$rutin=strrev($rut);

	$cant=strlen($rutin);

	$c=0;

	while($c<$cant)

	{

		$r[$c]=substr($rutin,$c,1);

		$c++;

	}

	$ca=count($r);

	$m=2;

	$c2=0;

	$suma=0;

	while($c2<$ca)

	{

		$suma=$suma+($r[$c2]*$m);

		if($m==7)

		{

			$m=2;

		}

		else

		{

			$m++;

		}

		$c2++;

	}

	$resto=$suma%11;

	$digito=11-$resto;

	if($digito==10)

	{

		$digito=K;

	}

	else

	{

		if($digito==11)

		{

			$digito='0';

		}

	}

	if($dv==$digito)

	{

		return $validado;

	}

	else

	{

		$validado=false;

		return $validado;

	}

	

}







//################################################

//Validando o E-Mail

//################################################

function valida_email($campo) {

	$conta = "^[a-zA-Z0-9\._-]+@";

	$domino = "[a-zA-Z0-9\._-]+.";

	$extensao = "([a-zA-Z]{2,4})$";

	$pattern = $conta.$domino.$extensao;



	$campo=strtolower($campo);



	if (!ereg($pattern, $campo)) {

		$validado = false;

	}else{

		$validado = true;

	}

	return ($validado);

}

//################################################

//Validando o E-Mail

//################################################

function valida_existe_email($campo) {

	$campo = trim($campo);

	$conta = "^[a-zA-Z0-9\._-]+@";

	$domino = "[a-zA-Z0-9\._-]+.";

	$extensao = "([a-zA-Z]{2,4})$";

	$pattern = $conta.$domino.$extensao;

	$mail_valido=false;



	$campo=strtolower($campo);

		

	if (ereg($pattern, $campo))	{

		list($usuario, $dominio)=explode("@", $campo);

		$resultado = checkdnsrr($dominio, 'MX');

		return($resultado);

	}else{

		return false;

	}

}



//################################################

//Convertendo texto para a 1 letra maiuscula

//################################################

function primeira_maiuscula($campo) {

	$valor = explode(' ',$campo);

	$novo_valor="";

	foreach($valor as $k => $v) {

		if ( (strlen($v)>2)||(strstr($v,'.')) ) {

			$v=ucwords(strtolower($v))." ";

		}else{

			$v=strtolower($v)." ";

		}

		$novo_valor.=$v;

	}

	$novo_valor=substr($novo_valor,0,-1);

	return $novo_valor;

}

//################################################

//Formatando a data

//################################################

function ConverteData( $data, $formato = "BR" ) {

	if (strlen($data)==10) {

		if( $formato == "BR" ){

			//Do formato US(yyyy-mm-dd) para BR(dd/mm/yyyy)

			$formata_data = explode('-',$data);

			if (@checkdate($formata_data[1],$formata_data[2],$formata_data[0]) ) {

				$nova_data = $formata_data[2]."/".$formata_data[1]."/".$formata_data[0];

			}else{

				$nova_data = false;

			}

		}else{

			//Do formato BR(dd/mm/yyyy) para US(yyyy-mm-dd)

			$formata_data = explode('/',$data);

			if (@checkdate($formata_data[1],$formata_data[0],$formata_data[2]) ) {

				$nova_data = $formata_data[2]."-".$formata_data[1]."-".$formata_data[0];

			}else{

				$nova_data = false;

			}

		}

	}else{

		$nova_data = false;

	}



	return $nova_data;

}



//################################################

//Monta array de anos até o ano Atual

//################################################

function anos( $ano_inicio=2000 ) {

	$ano_atual=date('Y');

	for ($i=$ano_inicio;$i<=$ano_atual;$i++) {

		$lista[$i]=$i;

	}

	return $lista;

}

//################################################

//Função para recebimento de Anuidade (Quita o financeiro e cria a vigencia)

//################################################

function receber_anuidade( $idassoc, $idfinan, $data_pag, $valor, $desconto=0 ) {

	//Verificando se o usuario possui uma vigencia ativa

	$sql_vigente = "

		SELECT

			vigencia.id_vigencia,

			vigencia.termino AS termino

		FROM

			vigencia

		WHERE

			vigencia.id_associado='".$idassoc."'

			AND '".$data_pag."' BETWEEN vigencia.inicio AND vigencia.termino

	";



	$query_vigente= @mysql_query($sql_vigente);



	@mysql_query('BEGIN');

	//Caso exista uma vigencia em vigor, encerra o periodo.

	if ( @mysql_num_rows($query_vigente)>=1 ) {

		while($vigente = @mysql_fetch_assoc($query_vigente) ) {

			//Calculando a Nova Vigencia Caso o Pagamento esteja dentro de uma vigencia.

			$termino = date('Y-m-d',strtotime($data_pag)-3600*24*1); 

			@mysql_query("UPDATE vigencia SET vigencia.termino='".$termino."'WHERE vigencia.id_vigencia='".$vigente['id_vigencia']."'");

		}

	}



	$nv_data = explode('-',$data_pag);

	$novo_termino=date("Y-m-d",mktime (0, 0, 0, $nv_data[1], $nv_data[2]-1, $nv_data[0]+1));

	

	//Gravando a Nova Vigencia

	$sql_nvig = "

		INSERT INTO 

			vigencia(

				vigencia.id_associado,

				vigencia.id_financeiro,

				vigencia.inicio,

				vigencia.termino

			) 

		VALUES 

			(

				'".$idassoc."',

				'".$idfinan."',

				'".$data_pag."',

				'".$novo_termino."'

			)

		";

	//Gravando o Financeiro e as Vigencias.

	if ( !@mysql_query("UPDATE financeiro SET pago='S',valor_pago='".($valor-$desconto)."',valor_desconto='".$desconto."',data_pagamento = '".$data_pag."' WHERE id_financeiro=".$idfinan) ) {

		$erro ="Erro ao Gravar o pagamento.\\nEntre em Contato com o Administrador do Sistema\\n";	

	}else if ( !@mysql_query($sql_nvig) ) {

		$erro ="Erro ao Gravar a vigencia.\\nEntre em Contato com o Administrador do Sistema\\n";

	}else if ( !@mysql_query("UPDATE associados SET data_anuidade='".$novo_termino."',data_alteracao='".date('Y-m-d')."' WHERE id_associado=".$idassoc) ) {

		$erro ="Erro ao Gravar a anuidade do associado.\\nEntre em Contato com o Administrador do Sistema\\n";

	}else{

		$erro = "";

	}

	

	//Comitando os dados caso não hajam erros.

	if ( $erro=="" ) {

		@mysql_query("COMMIT");	

	}else{

		@mysql_query("ROLLBACK");

	}

	return $erro;

}

/*

###################################################################################################################

Função gerava periodo de 1 ano para cada vigencia

Alterada a regra em 24/03/201o por solicitação da SOGESP

- O período da vigência conta a partir da data do último pagamento.

- Por exemplo, como novo sócio efetuei o cadastro e pagamento em Outubro de 2010. 

   Desta forma, minha vigência terminará em Outubro de 2011. Mas, caso eu pago o boleto enviado no início do ano, 

   por exemplo em Janeiro de 2011, a vigência anterior é encerrada e iniciará uma nova em Janeiro de 2011, 

   finalizando em Janeiro de 2012.

###################################################################################################################

function receber_anuidade( $idassoc, $idfinan, $data_pag, $valor, $desconto=0 ) {

	//Pegando a ultima Vigencia Cadastrada para o usuario

	$sql_uvig = "

		SELECT 

			MAX(vigencia.termino) AS termino 

		FROM 

			vigencia 

		WHERE 

			vigencia.id_associado=".$idassoc." 

			AND vigencia.excluido='N'";

	$term_vig = @mysql_result(@mysql_query($sql_uvig),0);



	//Calculando a Nova Vigencia Caso o Pagamento esteja dentro de uma vigencia, renova apenas o ano da nova vigencia.

	if ($term_vig>=$data_pag) {

		$nv_data = explode('-',$term_vig);

		$novo_inicio =date("Y-m-d",mktime (0, 0, 0, $nv_data[1], $nv_data[2], $nv_data[0]));

		$novo_termino=date("Y-m-d",mktime (0, 0, 0, $nv_data[1], $nv_data[2]-1, $nv_data[0]+1));

	//Caso o Pagamento esteja fora de uma vigencia, recalcula a vigencia com base na data de pagamento.

	}else{

		$nv_data = explode('-',$data_pag);

		$novo_inicio =date("Y-m-d",mktime (0, 0, 0, $nv_data[1], $nv_data[2], $nv_data[0]));

		$novo_termino=date("Y-m-d",mktime (0, 0, 0, $nv_data[1], $nv_data[2]-1, $nv_data[0]+1));

	}

	

	@mysql_query('BEGIN');

	//Gravando a Nova Vigencia

	$sql_nvig = "

		INSERT INTO 

			vigencia(

				vigencia.id_associado,

				vigencia.id_financeiro,

				vigencia.inicio,

				vigencia.termino

			) 

		VALUES 

			(

				'".$idassoc."',

				'".$idfinan."',

				'".$novo_inicio."',

				'".$novo_termino."'

			)

		";

	//Gravando o Financeiro e as Vigencias.

	if ( !@mysql_query("UPDATE financeiro SET pago='S',valor_pago='".($valor-$desconto)."',valor_desconto='".$desconto."',data_pagamento = '".$data_pag."' WHERE id_financeiro=".$idfinan) ) {

		$erro ="Erro ao Gravar o pagamento.\\nEntre em Contato com o Administrador do Sistema\\n";	

	}else if ( !@mysql_query($sql_nvig) ) {

		$erro ="Erro ao Gravar a vigencia.\\nEntre em Contato com o Administrador do Sistema\\n";

	}else if ( !@mysql_query("UPDATE associados SET data_anuidade='".$novo_termino."',data_alteracao='".date('Y-m-d')."' WHERE id_associado=".$idassoc) ) {

		$erro ="Erro ao Gravar a anuidade do associado.\\nEntre em Contato com o Administrador do Sistema\\n";

	}else{

		$erro = "";

	}

	

	//Comitando os dados caso não hajam erros.

	if ( $erro=="" ) {

		@mysql_query("COMMIT");	

	}else{

		@mysql_query("ROLLBACK");

	}

	return $erro;

}

*/

//################################################

//Função para Gerar o Financeiro de Anuidade

//################################################

function gerar_anuidade( $idassoc, $data_vcto, $valor, $desconto=0, $origem='Gerador:SITE', $param_bol=array() ) {

	//Pegando a configuração de boletos ativa.

	$sql_cf_bol = "

		SELECT 

			conf_boleto.*

		FROM 

			conf_boleto

		WHERE 

			conf_boleto.ativo='S' 

	";

	$query_cf_bol = @mysql_query($sql_cf_bol);



	//Verifica se existe uma configuração de boleto Valida

	if ( @mysql_num_rows($query_cf_bol)==1 ) {

		$resul_cf_bol = @mysql_fetch_assoc($query_cf_bol);

		

		//Calculando o Vencimento do boleto

		if ($data_vcto<=date('Y-m-d')) {

			$nv_data = explode('-',$data_vcto);

			$novo_vcto=date("Y-m-d",mktime (0, 0, 0, $nv_data[1], $nv_data[2]+$resul_cf_bol['dias_vcto'], $nv_data[0]));

		}else{

			$novo_vcto=$data_vcto;

		}

		

		//Caso sejam fornecidas as informações de boleto, utiliza, senão, pega as padroes do Banco

		if ( (count($param_bol)>=1) ) {

			$instrucao0 = $param_bol[0];

			$instrucao1 = $param_bol[1];

			$instrucao2 = $param_bol[2];

			$instrucao3 = $param_bol[3];

		}else{

			$instrucao0 = $resul_cf_bol['instrucoes'];

			$instrucao1 = $resul_cf_bol['instrucoes1'];

			$instrucao2 = $resul_cf_bol['instrucoes2'];

			$instrucao3 = $resul_cf_bol['instrucoes3'];

		}

		

		//Gravando o Novo Financeiro

		$sql_nfin = "

			INSERT INTO 

				financeiro(

					financeiro.id_associado,

					financeiro.id_config_bol,

					financeiro.data_processamento,

					financeiro.data_vencimento,

					financeiro.nosso_numero,

					financeiro.instrucoes,

					financeiro.instrucoes1,

					financeiro.instrucoes2,

					financeiro.instrucoes3,

					financeiro.valor,

					financeiro.valor_desconto,

					financeiro.pago,

					financeiro.excluido,

					financeiro.data_inclusao,

					financeiro.obs

				) 

			VALUES 

				(

					'".$idassoc."',

					'".$resul_cf_bol['id_config_bol']."',

					'".date('Y-m-d')."',

					'".$novo_vcto."',

					'".($resul_cf_bol['proximo_numero']+1)."',

					'".$instrucao0."',

					'".$instrucao1."',

					'".$instrucao2."',

					'".$instrucao3."',

					'".$valor."',

					'".$desconto."',

					'N',

					'N',

					'".date('Y-m-d')."',

					'".$origem."'

				)

			";

			//Atualizando a Numeração do Boleto

			$sql_atu_bol = "

				UPDATE 

					conf_boleto 

				SET 

					proximo_numero='".($resul_cf_bol['proximo_numero']+1)."'

				WHERE 

					id_config_bol='".$resul_cf_bol['id_config_bol']."'

				";



		//Gravando o Financeiro e os dados do Boleto.

		if ( !@mysql_query($sql_nfin) ) {

			$erro ="Erro ao Gravar o Financeiro.\\nEntre em Contato com o Administrador do Sistema\\n";	

		}else if ( !@mysql_query($sql_atu_bol) ) {

			$erro ="Erro ao Gerar a numeração do boleto.\\nEntre em Contato com o Administrador do Sistema\\n";

		}else{

			$erro = "";

		}

	}else{

		$erro = "Erro ao Gerar o Boleto do Associado.\\nEntre em Contato com o Administrador do Sistema\\n";

	}

	return $erro;

}

//################################################

//Função para Cancelar Anuidade Vencida e gerar novo registro

//################################################

function gerar_nova_anuidade( $idassoc, $cat ) {



	@mysql_query('BEGIN');

	//Pegando a Anuidade que esta Vencida e não paga.

	$sql_anu_ven = "

	SELECT

		financeiro.id_financeiro,

		financeiro.data_vencimento,

		financeiro.nosso_numero,

		financeiro.pago,

		financeiro.excluido

	FROM

		financeiro

	WHERE

		financeiro.id_associado=".$idassoc."

		AND financeiro.excluido='N'

	";



	$query_anu_ven  = @mysql_query($sql_anu_ven);

	//Verifica se existe lançamento vencidos não pagos

	if ( @mysql_num_rows($query_anu_ven)>=1 ) {

		$status = '';

		while($resul_anu_ven = @mysql_fetch_assoc($query_anu_ven)) {

			//Setando o lançamento para "excluido"

			$query_ex = @mysql_query("UPDATE financeiro SET excluido='S' WHERE id_associado=".$idassoc." AND id_financeiro=".$resul_anu_ven['id_financeiro']);

			if (!$query_ex) {

				$status.='Erro ao Atualizar o Lançamento.\\nEntre em Contato com o Administrador do Sistema\\n';

			}

		}

		//Gerando o Novo Financeiro

		$vlr_anuidade = ValorAnuidade($cat);

		$status.= gerar_anuidade( $idassoc, date('Y-m-d'), $vlr_anuidade, 0, 'Regerado' );

		if ( $status=="" ) {

			@mysql_query("COMMIT");	

		}else{

			@mysql_query("ROLLBACK");

		}

	}else{

		$status.= "Erro ao Atualizar o Lançamento.\\nEntre em Contato com o Administrador do Sistema\\n";

	}

	return $status;

}

//################################################

//Função para Montar a listagem com <select>

//################################################

function monta_select_combo( $nome_campo, $valor_selecionado, $valores, $css='', $eventos='' ) {

	//sort($valores);

	$cmp ="\n\t<select name='".$nome_campo."' id='".$nome_campo."' ".$css." ".$eventos.">";

	$cmp.="\n\t\t<option></option>";

	foreach($valores as $c=>$v) {

		//Verifica se é o utem selecionado

		if(( strtoupper($c)==strtoupper($valor_selecionado))&&($valor_selecionado!='') ) {

			$selecionado=" selected='selected' ";

		}else{

			$selecionado=" ";

		}

		$cmp.="\n\t\t<option ".$selecionado." value='".$c."'>".$v."</option>";

	}

	$cmp.="\n\t</select>";

	return $cmp;

}

//################################################

//Função para Gerar Senhas

//################################################

function GeradorSenha($tamanho=8, $tp='') {

	$padrao_letras = "A|B|C|D|E|F|G|H|I|J|K|L|M|N|O|P|Q|R|S|T|U|V|X|W|Y|Z";

	$padrao_numeros = "0|1|2|3|4|5|6|7|8|9";

	$array_letras = explode("|", $padrao_letras);

	$array_numeros = explode("|", $padrao_numeros);



	$pword = "";

	if ($tp=='L') {

		$tipo=array('L');

	}else if ($tp=='N') {

		$tipo=array('N');

	}else{

		$tipo=array('L','N');

	}

	

	for ($i=0; $i<$tamanho; $i++) {

		$char=array_rand($tipo,1);

		if ($tipo[$char] == "L") {

			$pword.= $array_letras[array_rand($array_letras,1)];

		} else if ($tipo[$char] == "N") {

			$pword.= $array_numeros[array_rand($array_numeros,1)];

		}

	}

	return $pword;

}

//################################################

//Função para Pegar os dados do Bleto

//################################################

function DadosBoleto($idconf='') {

	$sql_bol = "

		SELECT 

			conf_boleto.*

		FROM 

			conf_boleto

		WHERE 

	";



	if ($idconf!='') {

		$sql_bol.=" conf_boleto.id_config_bol='".$idconf."'";

	}else{

		$sql_bol.=" conf_boleto.ativo='S'";

	}

	$query_bol = @mysql_query($sql_bol);



	//Verifica se existe uma configuração de boleto Valida

	if ( @mysql_num_rows($query_bol)==1 ) {

		$result = @mysql_fetch_assoc($query_bol);

	}else{

		$result = false;

	}

	return $result;

}

//################################################

//Função para o Endereço de Correspondencia

//################################################

function EnderecoCompleto( $id ) {

	$sql_end = "

		SELECT

			associados.cep_res,

			associados.endereco_res,

			associados.numero_res,

			associados.bairro_res,

			associados.cidade_res,

			associados.uf_res,

			associados.comp_res,

			associados.cep_com,

			associados.endereco_com,

			associados.numero_com,

			associados.bairro_com,

			associados.cidade_com,

			associados.uf_com,

			associados.comp_com,

			associados.correspondencia

		FROM

			associados

		WHERE

			associados.id_associado=".$id

	;

	

	$query_end=@mysql_query($sql_end);

	if (@mysql_num_rows($query_end)==1) {

		$resul_end=@mysql_fetch_assoc($query_end);

		$suf = strtolower(substr($resul_end['correspondencia'],0,3)); 

		$end['cep'] = $resul_end['cep_'.$suf];

		$end['endereco'] = $resul_end['endereco_'.$suf];

		$end['numero']=$resul_end['numero_'.$suf];

		$end['comp']=$resul_end['comp_res'.$suf];

		$end['bairro']=$resul_end['bairro_'.$suf];

		$end['cidade']=$resul_end['cidade_'.$suf];

		$end['uf']=$resul_end['uf_'.$suf];

	}else{

		$end=false;

	}

	return $end;

}

//################################################

//Função para Pegar o Valor da Anuidade.

//################################################

function ValorAnuidade( $cat ) {

	$sql_vanu = "

		SELECT

			anuidades.valor

		FROM

			anuidades

		WHERE

			anuidades.categoria='".$cat."'

	";

	

	$query_vanu=@mysql_query($sql_vanu);

	if (@mysql_num_rows($query_vanu)==1) {

		$resul_vanu=@mysql_fetch_assoc($query_vanu);

		$valor=$resul_vanu['valor'];

	}else{

		$valor=false;

	}

	return $valor;

}

//################################################

//Função para Enviar E-Mail.

//################################################

function EnviarMail( $email, $from, $assunto, $mensagem, $lnk ) {



	//Configurando Quebra de linha, dependendo do Servidor

	if (PHP_OS=="Linux") {

		$quebra_linha = "\n"; //Se for Linux

	}else if(PHP_OS == "WINNT") {

		$quebra_linha = "\r\n";// Se for Windows

	}else{

		$quebra_linha = "\n"; //

		//die("Este script nao esta preparado para funcionar com o sistema operacional de seu servidor");

	}



	$from = strtolower(trim($from));

	$email= strtolower(trim($email));

	//$cc = strtolower(trim($cc));

	//$bcc= strtolower(trim($bcc));

	$cc = '';

	$bcc= '';

	

	$headers = "MIME-Version: 1.1".$quebra_linha;

	$headers .= "Content-type: text/html; charset=iso-8859-1".$quebra_linha;

	$headers .= "From: ".$from.$quebra_linha;

	$headers .= "Cc: ".$cc.$quebra_linha;

	$headers .= "Bcc: ".$bcc.$quebra_linha;

	$headers .= "Reply-To: ".$from.$quebra_linha;

	$headers .= "Return-Path: ".$from.$quebra_linha;

   	$headers .= "X-Priority: 1".$quebra_linha;

	

	$cab_mail = "

		<html>

		<head>

			<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1' />

			<link href='http://".$_SERVER['HTTP_HOST']."/".$lnk."/css/ficha.css' rel='stylesheet' type='text/css' />

		</head>

		<body>

			<div id='f_cad' style='border:none;'>

				<div class='msg' style='width:100%'>

		";

	$rod_mail = "

				</div>

			</div>

		</body>

		</html>

		";

	if ($mensagem!='') {

		$conteudo = $cab_mail.$mensagem.$rod_mail;

		//echo $email."<hr>".$assunto."<hr>".$conteudo."<hr>".$headers;exit();

		$send = @mail($email, $assunto, $conteudo , $headers, "-r".$from); //Se PostFix

		if( !$send ) { // Se for Postfix

			$send = @mail($email, $assunto, $conteudo , $headers);

		}

	}else{

		$send = false;

	}

	return $send;

}

//################################################

//Função para Excluir uma pessoas.

//################################################

function Excluir_associado( $id_pessoa ) {

	$erro = "";

	//Verifica se a pessoa existe

	$sql_exi = "

		SELECT

			associados.id_associado

		FROM

			associados

		WHERE

			associados.id_associado=".$id_pessoa."

			AND associados.excluido='N'

		LIMIT 1

	";



	$id_exi = @mysql_result(@mysql_query($sql_exi),'id_associado');



	//Verifica se o ID pesquisado é igual ao ID passado.

	if ( ($id_exi!=$id_pessoa)||($id_pessoa=='')||(is_null($id_pessoa)) ) {

		$erro.= "Ocorreu um problema na Atualização. Entre em contato com o Administrador do Sistema\\n";

	}

	

	if ($erro=="") {

		mysql_query('BEGIN');

		//Excluido as Vigencias, caso Haja

		$sql_evs = "UPDATE vigencia SET vigencia.excluido='S', vigencia.op_exclusao='".$_SESSION['usuario']."', vigencia.data_exclusao=CONCAT(CURDATE(),' ',CURTIME()) WHERE vigencia.id_associado=".$id_exi;

		//Excluido o Financeiro do Associado, Caso Haja

		$sql_efs = "UPDATE financeiro SET financeiro.excluido='S', financeiro.op_exclusao='".$_SESSION['usuario']."', financeiro.data_exclusao=CONCAT(CURDATE(),' ',CURTIME()) WHERE financeiro.id_associado=".$id_exi;

		//Excluido o Associado

		$sql_eas = "UPDATE associados SET associados.excluido='S', associados.op_exclusao='".$_SESSION['usuario']."', associados.data_exclusao=CONCAT(CURDATE(),' ',CURTIME()),data_alteracao='".date('Y-m-d')."' WHERE associados.id_associado=".$id_exi;

		if ( !@mysql_query($sql_evs) ) {

			$erro.="Erro ao excluir as Vigências\\n";

		}else if ( !@mysql_query($sql_efs) ) {

			$erro.="Erro ao excluir o Financeiro\\n";		

		}else if ( !@mysql_query($sql_eas) ) {

			$erro.="Erro ao excluir o Associado\\n";		

		}



		if ( $erro=="" ) {

			mysql_query("COMMIT");	

		}else{

			mysql_query("ROLLBACK");

		}

	}

	return $erro;

}

//################################################

//Função para Processar a Baixa Automatica

//################################################

function linhaProcessada1($numLn, $vlinha) {

	//Debug

	//echo "<pre>";

	//print_r($vlinha);

	//echo "</pre><hr>";



	//Cabeçalho do Arquivo

	if ( $vlinha['id_registro']==0 ) {	

		//Gravando os dados Necessarios para salvar no Banco

		$_SESSION['linha_c'] = array(

			'lote'			 =>GeradorSenha(10),

			'cod_nome_banco' =>$vlinha["cod_nome_banco"],

			'agencia_cedente'=>$vlinha['agencia_cedente'],

			'conta_cedente'  =>$vlinha['conta_cedente'],

			'nome_cedente'   =>$vlinha['nome_cedente'],

			'cod_nome_banco' =>$vlinha['cod_nome_banco'],

			'data_gravacao'  =>$vlinha['data_gravacao']

		);

	}

	//Linha Detalhe

	if ( ($vlinha['id_registro']!=0)&&($vlinha['id_registro']!=9) ) {

		$linha_d = array(

			'id_registro'   =>$vlinha['id_registro'],

			'nosso_numero'  =>$vlinha['nosso_numero'],

			'uso_banco1'    =>$vlinha['uso_banco1'],

			'data_ent_liq'  =>$vlinha['data_ent_liq'],

			'valor'         =>$vlinha['valor'],

			'valor_tarifa'  =>$vlinha['valor_tarifa'],

			'valor_recebido'=>$vlinha['valor_recebido'],

			'desconto_concedido'=>$vlinha['desconto_concedido']

		);

		//Gravando os dados do arquivo no banco para LOG

		Gravar_Baixa_Automatica( $_SESSION['linha_c'], $linha_d );

	}

}



//################################################

//Função para Gravar no Banco os dados da Baixa Automatica.

//################################################

function Gravar_Baixa_Automatica( $cab, $det ) {

	$sql_lbx = "

		INSERT INTO

			log_baixas(

				lote,

				arquivo,

				instituicao,

				agencia_cedente,

				conta_cedente,

				nome_cedente,

				data_gravacao,

				id_registro,

				nosso_numero,

				uso_banco1,

				data_ent_liq,

				valor,

				valor_tarifa,

				valor_desconto,

				valor_recebido,

				importado,

				data_inclusao,

				hora_inclusao

			)

		VALUES

			(

				'".$cab['lote']."',

				'".$_SESSION['arquivo']."',

				'".$cab['cod_nome_banco']."',

				'".$cab['agencia_cedente']."',

				'".$cab['conta_cedente']."',

				'".$cab['nome_cedente']."',

				'".ConverteData( $cab['data_gravacao'], "US" )."',

				'".$det['id_registro']."',

				".$det['nosso_numero'].",

				'".$det['uso_banco1']."',

				'".ConverteData( $det['data_ent_liq'], "US" )."',

				'".$det['valor']."',

				'".$det['valor_tarifa']."',

				'".$det['desconto_concedido']."',

				'".$det['valor_recebido']."',

				'".$_SESSION['usuario']."',

				'".date('Y-m-d')."',

				'".date('H:i:s')."'

				

			)

	";

	//Gravando os registros do Arquivo no Banco para LOG.

	@mysql_query($sql_lbx);

}

//################################################

//Função para Buscar o CEP (Utilizado na geração do XML.

//################################################

function busca_cep($cep_b){

	$resultado = @file_get_contents('http://republicavirtual.com.br/web_cep.php?cep='.urlencode($cep_b).'&formato=query_string');

	parse_str($resultado, $retorno); 

	return $retorno;

}



//################################################

//Função para Gravar log de acesso.

//################################################

function log_acesso( $dados ){

	$login= $dados['login'];

	$senha= $dados['senha'];

	//$endip= $_SERVER['REMOTE_ADDR'];

	// Pegando o IP do client no lugar do proxy

	$endip= ($_SERVER['HTTP_X_FORWARDED_FOR']!=''?str_replace(',',' ',$_SERVER['HTTP_X_FORWARDED_FOR']):$_SERVER['REMOTE_ADDR']);

	$data = date('Y-m-d');

	$hora = date('H:i:s');

	$status = $dados['status'];

	$link = "http://".$_SERVER['HTTP_HOST'].$dados['link'];

	$sql_lac = "INSERT INTO log_acesso(login,senha,ip,data,hora,status,link) VALUES ('".$login."','".$senha."','".$endip."','".$data."','".$hora."','".$status."','".$link."')";

	@mysql_query($sql_lac);

}

//################################################

//Função verificar se o usuario tem acesso a um 

//determinado item do menu.

//################################################

function tem_acesso_item( $item_menu ){

	$acesso_item = "

		SELECT 

			vw_acessos_usuarios.acesso

		FROM

			vw_acessos_usuarios 

		WHERE 

			vw_acessos_usuarios.Menu='".$item_menu."'

			AND vw_acessos_usuarios.Usuario='".$_SESSION['usuario']."'

		";



	$query_acesso=@mysql_query($acesso_item);

	if (@mysql_num_rows($query_acesso)==1) {

		$resul_acesso=@mysql_fetch_assoc($query_acesso);

		$acesso=$resul_acesso['acesso'];

	}else{

		$acesso=false;

	}

	return $acesso;

}

//################################################

//Função verificar se o usuario tem acesso a um 

//determinado item do menu.

//################################################

function busca_relatorio( $itens=3 ){

	$search = "";

	//Criterios de Pesquisa	

	$criterios=array(

		'Contêm'=>'LIKE',

		'Não Contêm'=>'NOT LIKE',

		'Igual'=>'=',

		'Diferente'=>'<>',

		'Maior'=>'>',

		'Menor'=>'<'

	);



	//Montando as combos

	for ($i=1;$i<=$itens;$i++) {

		//Montando a Combo que comtem a listagem de campos

		$search.= "\n\t\t\t\t\t\t<select id='pesquisa_".$i."' name='pesquisa_".$i."' class='search' style='width:150px;margin:2px;'>";

		$search.= "\n\t\t\t\t\t\t\t<option value=''>...Selecione...</option>";

		$search.= "\n\t\t\t\t\t\t</select>";

		//Montando a listagem de critérios

		$search.= "\n\t\t\t\t\t\t<select id='acao_".$i."' name='acao_".$i."' class='search' style='width:14%;margin:2px;'>";

		foreach ( $criterios as $chave=>$valor ) {

			$search.= "\n\t\t\t\t\t\t\t<option value='".$valor."'>";

			$search.= htmlentities($chave);

			$search.= "</option>";

		}

		$search.= "\t\t\t\t\t\t</select>\n";

		//Montando a Area de digitação do usuario

		$search.= "\t\t\t\t\t\t<input id='item_".$i."' name='item_".$i."' type='text' class='search' style='width:38%;margin:2px' />\n";

		$search.= "\t\t\t\t\t\t<select id='EOU_".$i."' name='EOU_".$i."' class='search' style='width:8%;margin:2px;'>\n";

		$search.= "\t\t\t\t\t\t\t<option value=' AND '>E</option>";

		$search.= "\t\t\t\t\t\t\t<option value=' OR '>OU</option>";

		$search.= "\t\t\t\t\t\t</select>\n";

		$search.= "\t\t\t\t\t\t<br clear='all'>\n";

	}

	return $search;

}

//################################################

//Função para montar os campos da busca

//################################################

function montar_campos_busca( $campos='' ){



	sort($campos);

	$busca='';

	//Pegando os campos solicitados

	if ($campos=='') {

		$sql = "

			SELECT

				vw_relatorios.*

			FROM

				vw_relatorios

			LIMIT 1

		";

	}else{

		$sql = "

			SELECT 

		";

		foreach ($campos as $vlr) {

			$sql.= "vw_relatorios.".$vlr.",";

		}

		$sql = substr($sql,0,-1)." FROM vw_relatorios LIMIT 1";

	}



	$query_busca = @mysql_query($sql);

	$resul_busca = @mysql_fetch_assoc($query_busca);



	//Montando os campos

	$i=0;

	foreach($resul_busca as $ass_chv=>$ass_vlr) {

		$busca.="\n\t\t\t\t\t\t\t<input  id='".$ass_chv."' name='".$ass_chv."' onclick='itens_builder(this);' type='checkbox' class='ui-icon ui-icon-check' style='float:left;'>".ucwords(strtolower(str_replace('_',' ',@mysql_field_name($query_busca,$i))))."<br clear='all' />";

		$i++;

	}

	return $busca;

}

//################################################

//Função para montar as formatações dos campos criterios da busca

//################################################

function montar_js_controle_campos( $itens=3, $campos ){

	$jvscpt='';

	for ($i=1;$i<=$itens;$i++) {

		//Incluir calendario nos campos data

		$jvscpt.= "\n\t\t\t\t$( \"#pesquisa_".$i."\" ).change(function(){";

		$jvscpt.= "\n\t\t\t\t\tif (!$(this).val().indexOf('data')) {";

		$jvscpt.= "\n\t\t\t\t\t\t$( \"#item_".$i."\" ).val('');";

		$jvscpt.= "\n\t\t\t\t\t\t$( \"#item_".$i."\" ).datepicker();";

		$jvscpt.= "\n\t\t\t\t\t\t$( \"#item_".$i."\" ).attr('readonly','readonly');";

		$jvscpt.= "\n\t\t\t\t\t}else{";

		$jvscpt.= "\n\t\t\t\t\t\t$( \"#item_".$i."\" ).val('');";

		$jvscpt.= "\n\t\t\t\t\t\t$( \"#item_".$i."\" ).datepicker(\"destroy\");";

		$jvscpt.= "\n\t\t\t\t\t\t$( \"#item_".$i."\" ).attr('readonly','');";

		$jvscpt.= "\n\t\t\t\t\t}";

		$jvscpt.= "\n\t\t\t\t});";

	}

	//Montando o POST do Formulario de pesquisa para exibir o Preview

	$jvscpt.= "\n\t\t\t\t$(\"#btn_personalizar_relatorio\").click(function(event){";

//	$jvscpt.= "\n\t\t\t\t$(\"#btn_personalizar_relatorio\").live('click',function(event){";

	$jvscpt.= "\n\t\t\t\t\t$(\"#preview_personalizados\").html('<img src=\"img/aguarde_ico.gif\" alt=\"aguarde\" title=\"Aguarde...Processando\" /> Aguarde... Processando.');";

	$jvscpt.= "\n\t\t\t\t\tevent.preventDefault();";

	$jvscpt.= "\n\t\t\t\t\t$.post('functions/carregar_preview.php?ida=".base64_encode('personalizado')."', {";



	for ($i=1;$i<=$itens;$i++) {

		$jvscpt.= "\n\t\t\t\t\t\tpesquisa_".$i.":$( \"#pesquisa_".$i."\" ).val(),";

		$jvscpt.= "\n\t\t\t\t\t\tacao_".$i.":$( \"#acao_".$i."\" ).val(),";

		$jvscpt.= "\n\t\t\t\t\t\titem_".$i.":$( \"#item_".$i."\" ).val(),";

		$jvscpt.= "\n\t\t\t\t\t\tEOU_".$i.":$( \"#EOU_".$i."\" ).val(),";

	}



	foreach($campos as $per_chv=>$per_vlr) {

		$jvscpt.= "\n\t\t\t\t\t\t".$per_vlr.":$( \"#".$per_vlr.":checked\" ).val(),";

	}



	$jvscpt.= "\n\t\t\t\t\t\tano_corrente:$( \"#ano_corrente:checked\" ).val(),";	

	$jvscpt= substr($jvscpt,0,-1)."\n\t\t\t\t\t},";

	$jvscpt.= "\n\t\t\t\t\tfunction(json){";

	//$jvscpt.= "\n\t\t\t\t\t\tlocation.reload();";

	$jvscpt.= "\n\t\t\t\t\t\t

					if(json == 'no'){

						alert('ATENCAO. Ocorreu um problema ao gerar a visualização.\\nEntre em contat com o administrador do sistema.');

						$(\"#preview_personalizados\").html('');

					}else{

						$(\"#preview_personalizados\").html(json);

					}

					

					";

	$jvscpt.= "\n\t\t\t\t\t});\n";

	$jvscpt.= "\n\t\t\t\t});\n";

	return $jvscpt;

}

//################################################

//Função para Validar RUT Chileno

//################################################

function RUT( $rut ){

	$rut = preg_replace('/[^0-9]/i', '', $rut);

	$rut = str_pad($rut,9,0,STR_PAD_LEFT);

	echo $dv = substr($rut,8,1);

	$rut = substr($rut,0,-1);

	

	$rutin=strrev($rut);

	$cant=strlen($rutin);

	$c=0;



	while($c<$cant)

	{

		$r[$c]=substr($rutin,$c,1);

		$c++;

	}



	$ca=count($r);

	$m=2;

	$c2=0;

	$suma=0;



	while($c2<$ca)

	{

		$suma=$suma+($r[$c2]*$m);

		if($m==7)

		{

			$m=2;

		}else{

			$m++;

		}

		$c2++;

	}



	$resto=$suma%11;

	$digito=11-$resto;

	if($digito==10)

	{

		$digito=K;

	}else{

		if($digito==11)

		{

			$digito=”0″;

		}

	}



	if($dv==$digito)

	{

		return true;

	}else

	{

		return false;

	}

	return false;

}

?>