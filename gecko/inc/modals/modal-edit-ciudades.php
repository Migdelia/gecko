<?php $modal_item = "Ciudad" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-pencil"></i> <?php echo _('Editar  ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" action="">
          <div class="row">
            <div class="col-xs-12 col-md-6">
            <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre Ciudad') ?></label>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre Ciudad') ?></label>
                <input type="text" class="form-control" id="input_edit_<?php echo $modal_item ?>" name="input_edit_<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre Ciudad') ?>" value="">
                <input type="hidden" id="id_cidade_atual" name="id_cidade_atual" value="" />
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Status ') . $modal_item ?></label>
              <div class="row form-group">
                <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Status ') . $modal_item ?></label>
                <a href="#" data-target="#" name="input_status_<?php echo $modal_item ?>" data-toggle="dropdown" aria-expanded="false" id="input_status_<?php echo $modal_item ?>" class="btn dropdown-btn">
                    <div class="ripple-container" id="respUser"></div>
                </a>
                <input type="hidden" name="status_Ciudad" id="status_Ciudad" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                	<span class="caret"></span>
                    <div class="ripple-container"></div>
               	</a>
                <ul class="dropdown-menu">
                      <li>
                        <a href="#" class="mass-act" id="user_<?php echo _( $res_users['id_login'] ) ?>" onclick="atribuiStatus(this);"><?php echo _( 'Activo' ) ?></a>
                      </li>                      
                      <li>
                        <a href="#" class="mass-act" id="user_<?php echo _( $res_users['id_login'] ) ?>" onclick="atribuiStatus(this);"><?php echo _( 'Inactivo' ) ?></a>
                      </li>                      
                </ul>
              </div>             
            </div>  
          </div>
          <div class="row form-group">
            <a id="btnEditCidade" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                <?php echo _('Guardar ') . $modal_item ?>
            </a>            
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
	//
	function atribuiStatus(obj)
	{
		$('#input_status_Ciudad').text(obj.text);
		$("#status_Ciudad").attr("value", obj.text);	
	}
	
	//
	$('#btnEditCidade').click(function()
	{
		var nomeCidade = $('#input_edit_Ciudad').val();
		var statusCidade = $('#status_Ciudad').val();
		var idCidade = $('#id_cidade_atual').val();
		

		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraCidade.php', // Informo a URL que será pesquisada.
			data: 'input_edit_Ciudad='+nomeCidade+'&status_Ciudad='+statusCidade+'&id_cidade_atual='+idCidade,
			success: function(html)
			{
				if(html == true)
				{
					$('#edit-modal-Ciudades').fadeOut("slow");
					$('#msgConfirm').text('Registro alterado con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#edit-modal-Ciudades').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para alterar el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}				
			}

		});	
	});	
</script>