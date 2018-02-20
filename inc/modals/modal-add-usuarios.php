<?php $modal_item = "Usuario" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-plus"></i> <?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Introduzca los datos del nuevo usuario que desea registrar.</p>
        <form id="formAddUsuario" class="form-horizontal" action="functions/addUsuario.php" method="post">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div id="div_name<?php echo $modal_item ?>" class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre de ') . $modal_item ?></label>
                <input type="text" class="form-control" id="input_name<?php echo $modal_item ?>" name="input_name<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre de ') . $modal_item ?>" value="">
              </div>
              <div id="div_senha<?php echo $modal_item ?>" class="row form-group">
                <label for="input_pass<?php echo $modal_item ?>" class="control-label"><?php echo _('Clave de ') . $modal_item ?></label>
                <input type="password" class="form-control" id="input_pass<?php echo $modal_item ?>" name="input_pass<?php echo $modal_item ?>" placeholder="<?php echo _('Clave de ') . $modal_item ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_mail<?php echo $modal_item ?>" class="control-label"><?php echo _('E-mail de ') . $modal_item ?></label>
                <input type="text" class="form-control" id="input_mail<?php echo $modal_item ?>" name="input_mail<?php echo $modal_item ?>" placeholder="<?php echo _('E-mail de ') . $modal_item ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div id="div_log<?php echo $modal_item ?>" class="row form-group">
                <label for="input_log<?php echo $modal_item ?>" class="control-label"><?php echo _('Login de ') . $modal_item ?></label>
                <input type="text" class="form-control" id="input_log<?php echo $modal_item ?>" name="input_log<?php echo $modal_item ?>" placeholder="<?php echo _('Login de ') . $modal_item ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_nivel<?php echo $modal_item ?>" class="control-label"><?php echo _('Nivel de ') . $modal_item ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_nivel<?php echo $modal_item ?>" name="input_nivel<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Nivel de ') . $modal_item ?><div class="ripple-container"></div></a>
                
                <input type="hidden" name="input_vl_nivel<?php echo $modal_item ?>" id="input_vl_nivel<?php echo $modal_item ?>" value="" />
                
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                	
                <?php
					//
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
						echo "<li>";
						echo "<a id='agrega_".$res_nivel['id_nivel']."' href='#' class='mass-act' onclick='atribuiNivelAdd(this);'>".$res_nivel['descricao']."</a>";
						echo "</li>";
						echo "<li class='divider'></li>";
					}											
				?>
                </ul>
              </div>
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Crear Nuevo ') . $modal_item ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script language="javascript">
	//
	function atribuiNivelAdd(obj)
	{
		$('#input_nivelUsuario').text(obj.text);
		$('#input_vl_nivelUsuario').val(obj.text);
	}
	
	//
	$( "#formAddUsuario" ).submit(function( event ) 
	{
		//
		var nomeUsuario = $(input_nameUsuario).val();
		var loginUsuario = $(input_logUsuario).val();
		var senhaUsuario = $(input_passUsuario).val();
		var emailUsuario = $(input_mailUsuario).val();
		var nivelUsuario = $(input_vl_nivelUsuario).text();
		
	
		//valida o nome de usuario
		if(nomeUsuario.length <= 2)
		{
			$(div_nameUsuario).addClass("form-group has-error");
			$(input_nameUsuario).focus();
			$(input_nameUsuario).select();
			return false;
		}
		else if(loginUsuario.length <= 3)
		{
			$(div_logUsuario).addClass("form-group has-error");
			$(input_logUsuario).focus();
			$(input_logUsuario).select();
			return false;		
		}
		else if(senhaUsuario.length <= 3)
		{
			$(div_senhaUsuario).addClass("form-group has-error");
			$(input_passUsuario).focus();
			$(input_passUsuario).select();
			return false;		
		}		
		else
		{
			this.submit();	
		}			
	});
	
	
</script>