<?php $modal_item = "Chapa" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nueva ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos de la nueva chapa.</p>
        <form class="form-horizontal" >
          <div class="row">
            <div class="col-xs-12 col-md-6">
            
              <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo') ?></label>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo') ?></label>
                <input type="text" class="form-control" id="input_insCodigo_<?php echo $modal_item ?>" name="input_insCodigo_<?php echo $modal_item ?>" placeholder="<?php echo _('Codigo') ?>" value="">
              </div>              
            </div>
            <div class="col-xs-12 col-md-6">
              <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripción') ?></label>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripción') ?></label>
                <input type="text" class="form-control" id="input_insDescri_<?php echo $modal_item ?>" name="input_insDescri_<?php echo $modal_item ?>" placeholder="<?php echo _('Descripción') ?>" value="">
              </div>            
            </div>
            <div class="col-xs-12 col-md-6">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
                <a id="btnAddChapa" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                    <?php echo _('Crear Nuevo ') . $modal_item ?>
                </a>  
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>
	//
	function atribuiValor(obj)
	{
		$('#input_'+obj.id).text(obj.text);
		$('#hd_'+obj.id).attr("value", obj.text);	
	}
	
	//
	$('#btnAddChapa').click(function()
	{
		//
		var codChapa = $('#input_insCodigo_Chapa').val();
		var dercriChapa = $('#input_insDescri_Chapa').val();							

		// 
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/addChapa.php', // Informo a URL que será pesquisada.
			data: 'input_insCodigo_Chapa='+codChapa+'&input_insDescri_Chapa='+dercriChapa,
			success: function(html)
			{
				//alert(html);
				if(html == true)
				{
					$('#add-modal-Chapas').fadeOut("slow");
					$('#msgConfirm').text('Registro Inserido con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#add-modal-Chapas').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para inserir el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}				
			}

		});
	});	
</script>