<?php $modal_item = "Chapa" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-pencil"></i> <?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditChapa">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('ID') ?></label>         
              <div class="row form-group">
                <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('ID') ?></label>
                <input type="text" class="form-control" id="edit_idMod_<?php echo $modal_item ?>" name="edit_idMod_<?php echo $modal_item ?>" placeholder="ID" value="" readonly="readonly">
              </div>              
              <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripción') ?></label>         
              <div class="row form-group">
                <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripción') ?></label>
                <input type="text" class="form-control" id="edit_descri_<?php echo $modal_item ?>" name="edit_descri_<?php echo $modal_item ?>" placeholder="Descripción" value="" >
              </div>
                                     
            </div>
            
            <!--- separa coluna -->
            
            <div class="col-xs-12 col-md-6">
              <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo') ?></label>         
              <div class="row form-group">
                <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo') ?></label>
                <input type="text" class="form-control" id="edit_cod_<?php echo $modal_item ?>" name="edit_cod_<?php echo $modal_item ?>" placeholder="Codigo" value="">
              </div>                                        
            </div>
          </div>
          <div class="row form-group">
            <a id="btnEditChapa" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                <?php echo _('Guardar ') . $modal_item ?>
            </a>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script language="javascript">

	//
	function atribuiValor(obj)
	{
		//
		var tpCombo = obj.id.split("_");
		tpCombo = tpCombo[0];
		
		var idObj = obj.id.split("_");
		idObj = idObj[1];
	
		
		//
		$('#select_'+tpCombo+'_Chapa').text(obj.text);
		$('#input_'+tpCombo+'_Chapa').attr("value", idObj);
	}

	//
	$('#btnEditChapa').click(function()
	{
		var modChapa = $('#edit_idMod_Chapa').val();
		var descriChapa = $('#edit_descri_Chapa').val();
		var codChapa = $('#edit_cod_Chapa').val();																			
		

		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraChapa.php', // Informo a URL que será pesquisada.
			data: 'edit_idMod_Chapa='+modChapa+'&edit_descri_Chapa='+descriChapa+'&edit_cod_Chapa='+codChapa,
			success: function(html)
			{
				if(html == true)
				{
					$('#edit-modal-Chapas').fadeOut("slow");
					$('#msgConfirm').text('Registro alterado con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#edit-modal-Chapas').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para alterar el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}	
			}
		});
	});
</script>