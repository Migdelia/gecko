<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="url" content="<?php echo $dominio ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="<?php echo $description?>" />
	<meta name="robots" content="noindex,nofollow">
	<title>..::Administrativo - <?php echo $description?> ::..</title>
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=<?php echo $dominio ?>/nojavascript.html" />
	</noscript>
	<link rel="icon" href="img/favicon.gif" type="image/gif" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
	<link href="css/ficha.css" rel="stylesheet" type="text/css" />
	<style type="text/css">
	<!--
		body{font-family:Tahoma,Verdana,Arial,Helvetica,sans-serif;font-size:13px;}
	-->
	</style>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.3.js"></script>
	<script type="text/javascript" charset="iso-8859-1">
		jQuery(function() {
			$("#alt_senha").click( function () {
				if ( ($("#senha_a").val()!='')&&($("#senha_n").val()!='')&&($("#senha_r").val()!='') ) {
					$("#msg_senha").html('<img src=\"img/aguarde_ico.gif\" border=\"none\" />Aguarde...');
					if ($("#senha_n").val()!=$("#senha_r").val()) {
						alert('ATENÇAO!\n\nAs senhas não conferem.\nElas devem ser identicas.');
						$("#senha_r").val('');
						$("#senha_r").focus();
						$("#msg_senha").html('Confirme a nova senha');
					}else if ($("#senha_a").val()==$("#senha_n").val() ) {
						alert('ATENÇAO!\n\nA  Nova senha deve ser diferente da senha atual.');
						$("#msg_senha").html('A  Nova senha deve ser diferente da senha atual.');
					}else{
						new Ajax({
							Url:'alt_senha.php?a='+$("#senha_a").val()+'&n='+$("#senha_n").val()+'&r='+$("#senha_r").val(),
							funcao:function(r){
								var res =(r.responseText);
								
								if(res==''){
									$("#msg_senha").html('Senha Alterada com sucesso.');
									alert('ATENÇAO!\n\nA nova senha foi enviada para o e-mail cadastrado.\nVoce deverá sair do sistema e acessa-lo utilizando a nova senha.');
									window.opener.location.reload()
									self.close();
								}else{
									$("#msg_senha").html('Redigite os dados');
									alert('ATENÇAO!'+res);
								}
							},
							ajaxErro: function(){
								return false;
							}
						});
					}
				}else{
					alert('ATENÇAO!\n\nO Preencha os dados solicitados.');
					$("#senha_a").focus();
				}
			});
		});
	</script>	
</head>
<body>
	<fieldset style="padding:5px;margin:5px;">
	<legend>Calabaza - Alterar Senha</legend>
		<div style="float:left;width:105px;">
			<label for="senha_a">Senha Atual:</label>
		</div>
		<div style="float:left;">
			<input id="senha_a" name="senha_a" type="password" class="fonte" size="15" maxlength="11" title="Digite a sua senha Atual" /> 
		</div>
		<br clear="all" />
		
		<div style="float:left;width:105px;">
			<label for="senha_n">Nova Senha:</label>
		</div>
		<div style="float:left;">
			<input id="senha_n" name="senha_n" type="password" class="fonte" size="15" maxlength="11" title="Digite a nova Senha"/>
		</div>
		<br clear="all" />

		<div style="float:left;width:105px;">
			<label for="senha_n">Redigite a Senha:</label>
		</div>
		<div style="float:left;">
			<input id="senha_r" name="senha_r" type="password" class="fonte" size="15" maxlength="11" title="Redigite a nova Senha"/>
		</div>
		<br clear="all" />
		<p id='msg_senha' title="Aten&ccedil;&atilde;o">&nbsp;
			
		</p>
		<button id='alt_senha' type='submit' class='bt-enviar' style='margin-left:120px;'>Alterar</button>
	</fieldset>
</body>
</html>
