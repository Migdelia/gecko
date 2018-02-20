<?php
//Fechamento de sessao ao fechar o navegador
session_start();
session_destroy();
include('conn/conn.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php
		include('functions/includes/header.php');
	?>
	<link href="css/login.css" rel="stylesheet" type="text/css" />
	<script type="text/javascript" charset="<?php echo $charset;?>">
		validador('form1');
		jQuery(function() {
			$("#esq_senha").click( function () {
				if ( $("#login").val()!='' ) {
					$("#esq_senha").html('<img src=\"img/aguarde_ico.gif\" border=\"none\" />Aguarde...');
					new Ajax({
						Url:'esq_senha.php?id='+$("#login").val(),
						funcao:function(r){
							var res =(r.responseText);
							if(res==''){
								$("#esq_senha").html('Esqueci minha senha');
								alert('ATENÇAO!\n\nA senha foi enviada para o e-mail cadastrado.');
							}else{
								$("#esq_senha").html('Esqueci minha senha');
								alert(res);
							}
						},
						ajaxErro: function(){
							return false;
						}
					});
				}else{
					alert('ATENÇAO!\n\nO Preencha o seu login.');
					$("#login").focus();
				}
			});
		});
	</script>	
</head>
<body>
	<div id="div_login">
	<form id="form1" name="form1" method="post" action="verifica.php">
		<fieldset>
		<legend><?php echo $description?>-LOGIN</legend>
			<div align="center">
            	<strong> CENTRAL - CALABAZA </strong>
                <br />
				<img src="img/calabaza_logo.png" width="400" />
                <br />
                <br />
                <br />
			</div>
			<div>
				<label for="login">LOGIN:</label>
				<input id="login" name="login" label="Login" req='true' type="text" class="fonte" size="36" maxlength="100" title="Digite o seu Login" /> 
			</div>
			<div>
				<label for="senha">PASSWORD:</label>
				<input id="senha" name="senha" label='Senha' req='true' type="password" class="fonte" maxlength="11" title="Digite a sua Senha"/>
			</div><br />

			<input type="submit" style="margin: -20px 0 0 125px;" class="button" name="Entrar" value="Entrar" title="Digite o Login e a senha e clique aqui para acessar o sistema" />
			<div id='divError' style="display:none; text-align:center; text-decoration:blink; font-weight:bolder;">&nbsp;</div>
		</fieldset>
	</form>
    </div>
</body>
</html>
<script language="javascript">
	var teste = document.getElementById("login");
	teste.focus();
</script>