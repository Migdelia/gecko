<?php $modal_item = "Ciudad" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nueva ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese el nombre de la nueva ciudad.</p>
        <form class="form-horizontal" method="post" action="">
          <div class="row form-group">
            <label for="input<?php echo $modal_item ?>" class="col-md-2 control-label"><?php echo _('Ingresa ') . $modal_item ?></label>
            <div class="col-xs-12 col-lg-8 col-lg-offset-2">
              <input type="text" class="form-control" id="input_add_<?php echo $modal_item ?>" name="input_add_<?php echo $modal_item ?>" placeholder="<?php echo _('Ingresa ') . $modal_item ?>" value="">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12 col-lg-8 col-lg-offset-2">
                <a id="btnAddCidade" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                    <?php echo _('Agregar Nueva ') . $modal_item ?>
                </a>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>


<script>

	$('#btnAddCidade').click(function()
	{
		var nomeCidade = $('#input_add_Ciudad').val();
		 
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/addCiudad.php', // Informo a URL que será pesquisada.
			data: 'input_add_Ciudad='+nomeCidade,
			success: function(html)
			{
				if(html == true)
				{
					$('#add-modal-Ciudades').fadeOut("slow");
					$('#msgConfirm').text('Registro Inserido con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#add-modal-Ciudades').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para inserir el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}				
			}

		});		
	});
	
</script>