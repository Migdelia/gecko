<?php
session_start();
include('../conn/conn.php');
include('../functions/functions.php');
include('../functions/lg_validador.php');

//Removendo o valor ID associado das tags html
$id_associado = strip_tags($_POST['row_id']);

//Caso seja para Remover a Pendencia
if ( ($_POST['id']=='pendencia')&&(strtolower($_POST['value'])=='remover') ) {
	$_POST['value']='';
}

$_POST['value'] = utf8_decode($_POST['value']);
$erro="";

//Preparando os campos para a atualizaçao
$all_ok="true";
foreach($_POST as $chave=>$valor) {
	if ( ($chave=='')||($valor=='')&&($chave!='row_oldvalue')&&($_POST['id']!='pendencia')&&($_POST['id']!='comp_res')&&($_POST['id']!='comp_com') ) {
		$all_ok="false";
		$erro.="Erro na atualizaçao\\n";
	}
}

//Validando e tratando os campos necessário
if ($all_ok) {
	switch ($_POST['id']) {
		//Caso seja E-mail Valida e limpa os espaços
		case "email":
			$_POST['value'] = trim(strtolower($_POST['value']));
			if (!valida_email($_POST['value']) ) {
				$erro.="E-Mail Invalido\\n";
			}
		break;
		case "excluir":
			$_POST['id']='excluido';
			if ($_POST['value'] == 'Sim') {
				$_POST['value']='S';
				$ex_as = Excluir_associado( $id_associado );
				$erro.= $ex_as;
			}else{
				$erro.="Erro ao Excluir o Associado.\\n";
			}
		break;
		//Caso seja nome, coloca a 1 letra em maiscula
		case "nome":
			$_POST['value'] = primeira_maiuscula($_POST['value']);
		break;
		//Caso seja CPF, valida para confirmar se o CPF é valido
		case "cpf":
			if ( !CPF_CPNJ($_POST['value'], 'CPF') ) {
				$erro.="CPF Invalido\\n";
			}else{
				//Verifica se o CPF já esta cadastrado no sistema
				$sql_cad = "
					SELECT
						associados.id_associado,
						associados.nome,
						associados.cpf
					FROM
						associados
					WHERE
						associados.cpf='".$_POST['value']."'
						AND associados.excluido='N'
					";
				$query_cad=@mysql_query($sql_cad);
				$resul_cad=@mysql_fetch_assoc($query_cad);
				if ($resul_cad['cpf']==$_POST['value']) {
					$erro.="CPF Já cadastrado\\n";
				}else{
					//Caso tudo esteja correto, atualiza o login para o mesmo numero do CPF (Para resolver problemas de importaçao de INICIO de utilizaçao do sistema.)
					@mysql_query("UPDATE associados SET login='".$_POST['value']."',data_alteracao='".date('Y-m-d')."' WHERE id_associado=".$id_associado);
				}
			}
		break;
		//Caso seja Regional, pesquisa o ID da Regional selecionada e seta o campo a ser atualizado
		case "regional":
			//Pegando o ID da Regional enviada
			if ( is_numeric($_POST['value']) ) {
				$_POST['value'] = @mysql_result(@mysql_query("SELECT regional.id_regional FROM regional WHERE regional.id_regional=".$_POST['value']." AND id_regional IN (".$_SESSION['reg_acesso'].") AND regional.excluido='N'"),0);
			}else{
				$_POST['value'] = @mysql_result(@mysql_query("SELECT regional.id_regional FROM regional WHERE regional.nome='".$_POST['value']."' AND id_regional IN (".$_SESSION['reg_acesso'].") AND regional.excluido='N'"),0);
			}
			if ($_POST['value']=='') {
				$erro.="Erro ao selecionar a Regional.";			
			}
			$_POST['id'] = 'id_regional';
		break;
		//Caso seja data de Nasdimento, formata e valida para gravar no banco
		case "data_nascimento":
			//Converte a data para o Padrao do MySQL
			$data = ConverteData($_POST['value'],'US');
			if ( $data!=false ) {
				$_POST['value']=$data;
			}else{
				$erro.="Data Invalida\\n";
			}
		break;
		//Caso seja o CEP, remove o traco e deixa apenas os numeros. Valida se o tamanho tem 08 digitos
		case "cep_res":
		case "cep_com":
			//Deixa apenas os numeros
			$_POST['value'] = ereg_replace('[^0-9]', '', $_POST['value']);
			$_POST['value'] = substr($_POST['value'],0,5)."-".substr($_POST['value'],5,3);
			if (strlen($_POST['value'])!=9) {
				$erro.="CEP Invalido\\n";
			}
		break;
		case "tel_res":
		case "cel":
		case "tel_com":
		case "fax":
			//Deixa apenas os numeros
			$_POST['value'] = ereg_replace('[^0-9]', '', $_POST['value']);
			$_POST['value'] = "(".substr($_POST['value'],0,2).")".substr($_POST['value'],2,4)."-".substr($_POST['value'],6,4);
			if (strlen($_POST['value'])!=13) {
				$erro.="Telefone Invalido\\nInserir tambem o DDD xx-xxxx-xxxx\\n";
			}
		break;
		case "pendencia":
			//Caso seja Pendencia de Residente, Remove a Pendencia e gera o Financeiro com o Valor Vigente atual.
			if ($_POST['value']=="") {
				//Verifica a Categoria do Associado
				$sql_dad = "SELECT associados.categoria, associados.nome, associados.login, associados.senha, associados.email FROM associados WHERE associados.excluido='N' AND associados.id_associado=".$id_associado;
				$query_dad=@mysql_query($sql_dad);
				$resul_dad=@mysql_fetch_assoc($query_dad);
				$cat_ass = $resul_dad['categoria'];
				if ($cat_ass=='Residente') {
					//Verifica se já tem financeiro Nao pago
					$sql_tfi="SELECT financeiro.id_financeiro FROM financeiro WHERE	financeiro.excluido='N'	AND financeiro.pago='N' AND financeiro.id_associado=".$id_associado." LIMIT 1";
					$id_financeiro = @mysql_result(@mysql_query($sql_tfi),'id_financeiro');
					//Pega o Valor da Anuidade Vigente
					$vlr_anuidade = ValorAnuidade($cat_ass);

					//Configurando o Email com os dados de Login e senha
					$assunto = "Cadastro de Associado - Boleto de Anuidade Disponível";
	
					//Adicionando assinatura a ser exibida apenas no e-mail
					$corpo_pg="
						O seu boleto de Anuidade j&aacute; est&aacute; dispon&iacute;vel para impress&atilde;o.<br /><br />
						Para acessa-lo, utilize os seguintes dados:<br /><br />
						Link: <span class='destaque'><a href='".$_SERVER['HTTP_HOST'].$lnk."/ficha' alt='SOGESP' class='destaque'>".$_SERVER['HTTP_HOST']."/".$lnk."/ficha</a></span><br />
						Login: <span class='destaque'>".$resul_dad['login']."</span><br />
						Senha: <span class='destaque'>".$resul_dad['senha']."</span><br />
						<br /><br />
					";

					$mensagem = "
						<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bolder;'>
							Prezado Associado
						</span>
						<br /><br />".$corpo_pg.
						"Atenciosamente<br /><a href='http:\\www.sogesp.org.br'>SOGESP - Associa&ccedil;&atilde;o de Obstetr&iacute;cia e Ginecologia do Estado de S&atilde;o Paulo</a>";

					$sql_mai="SELECT associados.email FROM associados WHERE	associados.excluido='N'	AND associados.id_associado=".$id_associado;
					$mail_ass = $resul_dad['email'];
		
					//Caso nao tenha Financeiro, gera um novo. Caso tenha, regera o boleto.
					if ( @mysql_num_rows(@mysql_query($sql_tfi))!=1 ) {
						$erro.=gerar_anuidade( $id_associado, date('Y-m-d'), $vlr_anuidade, 0, 'Gerador:ADM:'.$_SESSION['usuario'] );
						if ($erro=='') {
							//Enviando.
							if ( valida_existe_email($mail_ass) ) {
								EnviarMail( $mail_ass, $mail_from, $assunto, $mensagem, $lnk );
							}
						}
					}else{
						$erro.=gerar_nova_anuidade( $id_associado, $cat_ass );
						if ($erro=='') {
							//Enviando.
							if ( valida_existe_email($mail_ass) ) {
								EnviarMail( $mail_ass, $mail_from, $assunto, $mensagem, $lnk );
							}
						}
					}
				}else{
					$erro.="Apenas Residentes podem ter as pendencias excluidas.\\n";
				}
			}else{
				$erro.="Nao é possivel Adicionar pendencias.\\n";
			}
		break;
		default:

		break;
	}
}

//Caso nao ocorram erros, grava a informaçao
if ($erro=='') {
	if (@mysql_query("UPDATE associados SET ".$_POST['id']."='".($_POST['value'])."',data_alteracao='".date('Y-m-d')."' WHERE id_associado=".$id_associado." ") ) {
		//Caso a categoria tenha sido alterada de Residente para outra, remove a pendencia.
		if ( ($_POST['id']=='categoria')&&(strtolower($_POST['value'])!='Residente') ) {
			@mysql_query("UPDATE associados SET residencia_tipo='',pendencia='',data_alteracao='".date('Y-m-d')."' WHERE id_associado=".$id_associado." ");
		}
		//Pegando o Dado depois de atualizado para exibir para o usuario.
		$dado_exibir=@mysql_result(@mysql_query("SELECT associados.".$_POST['id']." FROM associados  WHERE id_associado=".$id_associado." "),0);		
		//Retirada a mensagem “cadastro alterado com sucesso” para cada alteraçao. Solicitado por e-mail em 11/01
		/*echo $dado_exibir."<script language='javascript'>alert('Atualizado com sucesso!.');</script>";*/
		echo $dado_exibir;
	}else{
		echo "<script language='javascript'>alert('".$erro."');</script>";
		$dado_exibir=@mysql_result(@mysql_query("SELECT associados.".$_POST['id']." FROM associados  WHERE id_associado=".$id_associado." "),0);		
		echo $dado_exibir;
	}
}else{
	echo "<script language='javascript'>alert('".$erro."');</script>";
	$dado_exibir=@mysql_result(@mysql_query("SELECT associados.".$_POST['id']." FROM associados  WHERE id_associado=".$id_associado." "),0);		
	echo $dado_exibir;
}
?>