<?php $modal_item = "Usuario" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditUsuario" method="post">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_id<?php echo $modal_item ?>" class="control-label"><?php echo _('ID de usuario') ?></label>
                <input type="text" class="form-control" id="input_id_<?php echo $modal_item ?>" placeholder="<?php echo _('ID de usuario') ?>" value="" readonly="readonly">
              </div>
              <div class="row form-group">
                <label for="input_mail<?php echo $modal_item ?>" class="control-label"><?php echo _('Correo Electrónico') ?></label>
                <input type="text" class="form-control" id="input_mail_<?php echo $modal_item ?>" placeholder="<?php echo _('Correo Electrónico') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_pass<?php echo $modal_item ?>" class="control-label"><?php echo _('Nueva contraseña') ?></label>
                <input type="password" class="form-control" id="input_pass_<?php echo $modal_item ?>" placeholder="<?php echo _('Nueva contraseña') ?>" value="" readonly="readonly">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre de usuario') ?></label>
                <input type="text" class="form-control" id="input_name_<?php echo $modal_item ?>" placeholder="Nombre de usuario" value="">
              </div>
              <div class="row form-group">
                <label for="input_exclu<?php echo $modal_item ?>" class="control-label"><?php echo _('Exclusión') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_exclu_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Exclusión') ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                  <li>
                    <a href="#" class="mass-act" onclick="atribuiStatus(this);"><?php echo _('Ativo') ?></a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a href="#" class="mass-act" onclick="atribuiStatus(this);"><?php echo _('Inativo') ?></a>
                  </li>
                </ul>
              </div>
              <div class="row form-group">
                <label for="input_nivel<?php echo $modal_item ?>" class="control-label"><?php echo _('Nivel de ') . $modal_item ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_nivel_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Nivel de ') . $modal_item ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                <?php 
					//consulta nome dos usuarios
					if($_SESSION['usr_nivel'] == 1)
					{
						//consulta niveis do usuario
						$sql_nivel = "
							SELECT
								descricao,
								id_nivel
							FROM
								nivel
							WHERE
								excluido = 'N'
							ORDER BY
								descricao
							";						
					}
					else 
					{
						$sql_nivel = "
							SELECT
								descricao,
								id_nivel
							FROM
								nivel
							WHERE
								excluido = 'N'
							AND
								id_nivel = 8
							ORDER BY
								descricao
							";							
					}
						
					$query_nivel=@mysql_query($sql_nivel);
					
					//mostra todos usuarios
					while($res_nivel=@mysql_fetch_assoc($query_nivel)) 
					{						
				?>
                      <li>
                        <a href="#" class="mass-act" id="nivel_<?php echo _( $res_nivel['id_nivel'] ) ?>" onclick="atribuiNivel(this);"><?php echo _( $res_nivel['descricao'] ) ?></a>
                      </li>
                <?php
					}
				?>
                </ul>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Guardar ') . $modal_item ?></button>
            
            
            <?php
				//permissao para estrutura
				if($_SESSION['usr_nivel'] == 1)
				{
			?>             
            	<button type="button" id="restSenha" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Resetear Contraseña') ?></button>
			<?php	
                }
            ?>             
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script language="javascript">
	//
	function atribuiStatus(obj)
	{
		$('#input_exclu_Usuario').text(obj.text);
	}
	
	//
	function atribuiNivel(obj)
	{
		$('#input_nivel_Usuario').text(obj.text);
	}
	
	//
	$( "#formEditUsuario" ).submit(function( event ) 
	{
		//pegar os dois valores a serem alterados.
		var nomeUsuario = $(input_name_Usuario).val();
		var email = $(input_mail_Usuario).val();
		var status = $(input_exclu_Usuario).text();
		var nivel = $(input_nivel_Usuario).text();
		var usuarioId = $(input_id_Usuario).val();
		var senha = $(input_pass_Usuario).val();

		
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraUsuario.php', // Informo a URL que será pesquisada.
			data: 'nome='+nomeUsuario+'&email='+email+'&status='+status+'&nivel='+nivel+'&id='+usuarioId+'&senhaUsu='+senha,
			success: function(html)
			{
				if(html == 0)
				{
					alert("Erro");
					return false;
				}
			}
		});	
	});
	
	//
	$( "#restSenha" ).click(function() 
	{
		$(input_pass_Usuario).removeAttr("readonly");
		$(input_pass_Usuario).focus();
		$(input_pass_Usuario).select();
	});
	
</script>