<?php $modal_item = "Gabinete" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-plus"></i> <?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos del nuevo gabinete.</p>
        <form class="form-horizontal" method="post" action="">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripción') ?></label>
                <input type="text" class="form-control" id="input_descricao_<?php echo $modal_item ?>" name="input_descricao_<?php echo $modal_item ?>" placeholder="<?php echo _('Descripción') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_name<?php echo $modal_item ?>" class="control-label"><?php echo _('Código') ?></label>
                <input type="text" class="form-control" id="input_cod_<?php echo $modal_item ?>" name="input_cod_<?php echo $modal_item ?>" placeholder="<?php echo _('Código') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
                <a id="btnAddGabinete" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
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
	$('#btnAddGabinete').click(function()
	{
		//
		var descGab = $('#input_descricao_Gabinete').val();
		var codGab = $('#input_cod_Gabinete').val();				

		// 
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/addGabinete.php', // Informo a URL que será pesquisada.
			data: 'input_descricao_Gabinete='+descGab+'&input_cod_Gabinete='+codGab,
			success: function(html)
			{
				if(html == true)
				{
					$('#add-modal-Gabinetes').fadeOut("slow");
					$('#msgConfirm').text('Registro Inserido con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#add-modal-Gabinetes').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para inserir el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}				
			}

		});
	});
</script>