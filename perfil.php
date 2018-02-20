<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');
?>
<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "perfil" // ingresar la palabra clave de cada modal ?>

    <div class="container-fluid innpage-<?php echo $filenameID; ?>">
      <div class="row">
        <?php include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
      </div>
      <div class="row">
        <?php include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
        <div class="inner-content col-xs-12 col-sm-9">
          <div class="page<?php echo $filenameID; ?>">
            <div class="row">
              <div class="col-xs-12 col-lg-6">
                <h3 class="main-title">
                  <span class="fa-stack fa-md">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-user fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo $filenameID; ?>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-6">
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel">
                  <div class="panel-heading">
                  </div>

                  <div class="panel-body">
                    <div class="row">
                      <div class="list-group">
                        <div class="list-group-item">
                          <div class="row-picture">
                            <a href="#" data-toggle="modal" data-target="#edit-fotoperfil">
                              <img class="circle big-avatar" src="<?php echo $imgurl ?>/default.jpg" alt="icon">
                            </a>
                          </div>
                          <div class="row-content">
                            <h2 class="list-group-item-heading">Perfil</h2>
                            <h2 class="list-group-item-heading"><?php echo $_SESSION['nome'] ?></h2>
                            <p class="list-group-item-text"><?php echo $_SESSION['desc_nivel'] ?></p>
                          </div>
                        </div>
                      </div>
                      
                      <?php 
					  	//consulta dados del usuario logado
						$sql_user = "
							SELECT
								*
							FROM
								logins
							WHERE
								logins.id_login = ".$_SESSION['id_login']."
							";
						$query_user=@mysql_query($sql_user);
						$res_user=@mysql_fetch_assoc($query_user);	
							
					  ?>
                      
                      <div class="input-wrap">
                        <div class="col-xs-12 col-md-6">
                          <!-- input formulario -->
                          <form id="userinfo" class="campos-usuario">
                            <div class="form-group">
                              <div class="input-group">
                                <input type="text" id="nomeUsuario" name="nomeUsuario" class="form-control"  placeholder="<?php echo _('Nome') ?>" value="<?php echo $res_user['nome'] ?>" disabled>
                                <span class="input-group-btn">
                                    <button id="btn_trocaNome" class="btn btn-primary" type="button" data-toggle="modal" data-target="#edit-name"><?php echo _('Insertar Nombre') ?><div class="ripple-container"></div></button>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group">
                                <input type="mail" id="emailUsuario" class="form-control" placeholder="<?php echo _('E-mail') ?>" value="<?php echo $res_user['email'] ?>" disabled>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#edit-mail"><?php echo _('Insertar E-mail') ?><div class="ripple-container"></div></button>
                                </span>
                              </div>
                            </div>
                            <div class="form-group">
                              <div class="input-group">
                                <input type="password" id="addon1" class="form-control"  placeholder="<?php echo _('Senha') ?>" value="<?php echo _('123456') ?>" disabled>
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="button" data-toggle="modal" data-target="#edit-password"><?php echo _('Insertar clave') ?><div class="ripple-container"></div></button>
                                </span>
                              </div>
                            </div>
                          </form>
                        </div>
                        <!---
                        <div class="col-xs-12">
                          <a href="#" class="btn btn-lg right" ><?php echo _('Guardar cambios') ?></a>
                        </div>
                        --->
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Foto perfil -->
    <div id="edit-fotoperfil" class="modal fade" tabindex="-1" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5><?php echo _('Trocar Foto perfil') ?></h5>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <div class="row form-group">
                    <div class="input-group">
                      <input type="text" readonly id="addon1" class="form-control" placeholder="<?php echo _('Selecionar imagen') ?>">
                      <input type="file" multiple id="atachfile">
                    </div>
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Salvar ') ?></button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
    <!-- Nombre -->
    <div id="edit-name" class="modal fade" tabindex="-1" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5><?php echo _('Trocar Nome de Usuario') ?></h5>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <div class="row form-group">
                    <label for="input_name" class="control-label"><?php echo _('Novo Nome') ?></label>
                    <input type="text" class="form-control" id="input_novoNome" placeholder="<?php echo _('Novo Nome') ?>" value="<?php echo $res_user['nome'] ?>">
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <button id="btn_salvaNome" type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Salvar ') ?></button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
    <!-- Correo -->
    <div id="edit-mail" class="modal fade" tabindex="-1" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5><?php echo _('Trocar e-mail do Usuario') ?></h5>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" method="post">
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <div class="row form-group">
                    <label for="input_name" class="control-label"><?php echo _('Novo E-mail') ?></label>
                    <input type="text" class="form-control" id="input_novoEmail" placeholder="<?php echo _('Novo E-mail') ?>" value="<?php echo $res_user['email'] ?>">
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <button id="btn_salvaEmail" type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Salvar ') ?></button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
    <!-- Contraseña -->
    <div id="edit-password" class="modal fade" tabindex="-1" style="display: none;">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            <h5><?php echo _('Trocar Senha') ?></h5>
          </div>
          <div class="modal-body">
            <form class="form-horizontal">
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <div class="row form-group">
                    <label for="input_pass" class="control-label"><?php echo _('Senha atual') ?></label>
                    <input type="password" class="form-control" id="input_pass" placeholder="<?php echo _('Senha atual') ?>" value="">
                  </div>
                  <div id="div_pass2" class="row form-group">
                    <label for="input_pass2" class="control-label"><?php echo _('Nueva Contraseña') ?></label>
                    <input type="password" class="form-control" id="input_pass2" placeholder="<?php echo _('Nova senha') ?>" value="">
                  </div>
                  <div id="div_pass3" class="row form-group">
                    <label for="input_pass3" class="control-label"><?php echo _('Confirmar Nueva Contraseña') ?></label>
                    <input type="password" class="form-control" id="input_pass3" placeholder="<?php echo _('Confirmar nova senha') ?>" value="">
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <button type="submit" id="btn_salvaSenha" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Salvar ') ?></button>
              </div>
            </form>
          </div>

        </div>
      </div>
    </div>
  </body>
</html>

<script language="javascript">
	$('#btn_salvaNome').click( function() 
	{
		var novoNome = $(input_novoNome).val();
		var campo = "nome";
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/atualiza_perfil.php', // Informo a URL que será pesquisada.
			data: 'param='+novoNome+'&flag='+campo+'&id='+<?php echo $_SESSION['id_login'] ?>,
			success: function(html)
			{
				var html = eval(html);
				if(html == 0)
				{
					alert("Erro!");					
				}
			}
		});	
	});
	
	
	$('#btn_salvaEmail').click( function() 
	{
		var novoEmail = $(input_novoEmail).val();
		var campo = "email";
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/atualiza_perfil.php', // Informo a URL que será pesquisada.
			data: 'param='+novoEmail+'&flag='+campo+'&id='+<?php echo $_SESSION['id_login'] ?>,
			success: function(html)
			{
				var html = eval(html);
				if(html == 0)
				{
					alert("Erro!");					
				}
			}
		});	
	});
	
	
	$('#btn_salvaSenha').click( function() 
	{
		var senhaAntiga = $(input_pass).val();
		var senhaNova1 = $(input_pass2).val();
		var senhaNova2 = $(input_pass3).val();
		
		var campo = "senha";

		//valida senha nova
		//verifica se nao tem campo vazio
		if(senhaAntiga == "")
		{
			$(input_pass).focus();
			return false;
		}
		//senha nova1
		if(senhaNova1 == "")
		{
			$(input_pass2).focus();
			return false;
		}
		
		//senha nova2
		if(senhaNova2 == "")
		{
			$(input_pass3).focus();
			return false;
		}
		
		//verifica se as senhas novas sao iguais
		if(senhaNova1 == senhaNova2)
		{

			$.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'functions/atualiza_perfil.php', // Informo a URL que será pesquisada.
				data: 'param='+senhaNova1+'&senhaAnt='+senhaAntiga+'&flag='+campo+'&id='+<?php echo $_SESSION['id_login'] ?>,
				success: function(html)
				{
					var html = eval(html);
					if(html == 0)
					{
						alert("Erro!");					
					}
					else if(html == 2)
					{
						alert("Senha atual invalida!");	
					}
				}
			});			
		}
		else
		{
			$(div_pass3).addClass("row form-group has-error");
			$(input_pass3).focus();
			$(input_pass3).select();
			return false;
		}

	});		
	
</script>