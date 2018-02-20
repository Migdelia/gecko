<div class="container">
  <div class="row log-wrap vhAttr valign-wrapper">
    <div class="valign col-xs-12 col-md-6 col-md-offset-3 col-md-8 col-md-offset-2">
      <div class="well login-component sombra-cuadrada">
        <form id="formLogin" class="form-horizontal" action="home.php" method="post" onkeyup="return enter();">
            <div class="valign-wrapper">
              <div class="logo-login valign">
                <img src="<?php echo $imgurl ?>/logo-login.png" alt="gecko" class="img-responsive">
              </div>
            </div>
            <div id="divUsuario" class="form-group"> <!--- <div class="form-group has-error"> --->
              <label for="inputEmail" class="col-md-2 control-label"><?php echo _('Usuário') ?></label>
              <div class="col-xs-12">
                <input type="text" class="form-control" id="inputEmail" name="inputEmail" value="" placeholder="<?php echo _('Usuário') ?>">
              </div>
            </div>
            <div id="divSenha" class="form-group">
              <label for="inputPassword" class="col-md-2 control-label"><?php echo _('Senha') ?></label>
              <div class="col-xs-12">
                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="<?php echo _('Senha') ?>" value="">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <a href="#" class="forgot" data-toggle="modal" data-target="#forgot-modal"><?php echo _('Esqueceu sua senha?') ?></a>
              </div>
            </div>

            <div class="form-group">
              <div class="col-xs-12">
                <button type="button" id="ingresa" name="ingresa" class="btn btn-default btn-lg btn-block btn-raised"><?php echo _('Entrar') ?></button>
               
              </div>
            </div>
            <input type="hidden" id="senhaQr" name="senhaQr" value="<?php echo $senhaQR; ?>"  />
        </form>
      </div>
    </div>
    <div class="bottomfringe"></div>
  </div>
</div>


<?php include("inc/modals/modal-forgotpass.php"); // modal recuperar contraseña ?>

<script type="text/javascript" charset="utf-8">

	function validaLogin()
	{
		//decalra usuario e senha
		var usuario = $(inputEmail).val();
		var senha = $(inputPassword).val();
		
		//verifica se existe
		$.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/verifica.php', // Informo a URL que será pesquisada.
			data: 'inputEmail='+usuario+'&inputPassword='+senha,
			success: function(html)
			{
				if(html == 0)//usuario com problema
				{
					$(divUsuario).addClass("form-group has-error");	
					$("#inputEmail").focus();
				}
				else if(html == 1)//senha com problema
				{
					$(divSenha).addClass("form-group has-error");
					$("#inputPassword").focus();	
				}
				else if(html == 2)
				{
					//verifica se tem senha QR
					var codQR = $(senhaQr).val();
					if(codQR == '')
					{
						$( "#formLogin" ).submit();	
					}
					else
					{
						location.href = 'validacion.php?s='+codQR;
					}				
				}
				else if(html == 3)//usuario com problema
				{
					$(divUsuario).addClass("form-group has-error");
					$("#inputEmail").focus();				
				}
				else if(html == 4)//os dois com problema
				{
					$(divUsuario).addClass("form-group has-error");
					$(divSenha).addClass("form-group has-error");
					$("#inputEmail").focus();				
				}						
			}
		});			
	}

		
	//aperto o botao ingresar
	$('#ingresa').click( function() {
		validaLogin();	
	});
	
	//submit form com o enter
	function enter()
	{
		var tecla=window.event.keyCode;
		if (tecla==13) 
		{
			validaLogin();
		}
	}	


</script>

