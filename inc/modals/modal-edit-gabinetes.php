<?php $modal_item = "Gabinetes" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-pencil"></i> <?php echo _('Editar Gabinete') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditGab" method="post" action="">
          <div class="row">
            <div class="col-xs-12 col-md-6">
            
              <label for="input_id<?php echo $modal_item ?>" class="control-label"><?php echo _('Id Gabinete') ?></label>
              <div class="row form-group">
                <label for="input_id<?php echo $modal_item ?>" class="control-label"><?php echo _('Id Gabinete') ?></label>
                <input type="text" class="form-control" id="input_id_<?php echo $modal_item ?>" name="input_id_<?php echo $modal_item ?>" placeholder="<?php echo _('Id Gabinete') ?>" value="" readonly>
              </div>  
              
              <label for="input_desc<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripción Gabinete') ?></label>   
              <div class="row form-group">
                <label for="input_desc<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripción Gabinete') ?></label>
                <input type="text" class="form-control" id="input_desc_<?php echo $modal_item ?>" name="input_desc_<?php echo $modal_item ?>" placeholder="<?php echo _('Descripción Gabinete') ?>" value="">
              </div>
            </div>
            
            <label for="input_cod<?php echo $modal_item ?>" class="control-label"><?php echo _('Cod Gabinete') ?></label>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_cod<?php echo $modal_item ?>" class="control-label"><?php echo _('Cod Gabinete') ?></label>
                <input type="text" class="form-control" id="input_cod_<?php echo $modal_item ?>" name="input_cod_<?php echo $modal_item ?>" placeholder="<?php echo _('Cod Gabinete') ?>" value="">
              </div>            
            </div>            
          </div>
          <div class="row form-group">
            <a id="btnEditGabinete" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
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
	$('#btnEditGabinete').click(function()
	{
		var idGab = $('#input_id_Gabinetes').val();
		var descGab = $('#input_desc_Gabinetes').val();
		var codGab = $('#input_cod_Gabinetes').val();																			
		

		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraGabinete.php', // Informo a URL que será pesquisada.
			data: 'input_id_Gabinetes='+idGab+'&input_desc_Gabinetes='+descGab+'&input_cod_Gabinetes='+codGab,
			success: function(html)
			{
				if(html == true)
				{
					$('#edit-modal-Gabinetes').fadeOut("slow");
					$('#msgConfirm').text('Registro alterado con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#edit-modal-Gabinetes').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para alterar el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}	
			}
		});
	});	
</script>