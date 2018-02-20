<?php $modal_item = "Juego" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditJuego" method="post">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <label for="input_id<?php echo $modal_item ?>" class="control-label"><?php echo _('Id del juego') ?></label>
              <div class="row form-group">
                <label for="input_id<?php echo $modal_item ?>" class="control-label"><?php echo _('Id del juego') ?></label>
                <input type="text" class="form-control" id="input_id_<?php echo $modal_item ?>" placeholder="<?php echo _('Id') ?>" value="" readonly="readonly">
              </div>       
              <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre del juego') ?></label>     
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre del juego') ?></label>
                <input type="text" class="form-control" id="input_nombre_<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre') ?>" value="29">
              </div>
              <label for="input_code<?php echo $modal_item ?>" class="control-label"><?php echo _('Código del juego') ?></label>
              <div class="row form-group">
                <label for="input_code<?php echo $modal_item ?>" class="control-label"><?php echo _('Código del juego') ?></label>
                <input type="text" class="form-control" id="input_code_<?php echo $modal_item ?>" placeholder="<?php echo _('Codigo Juego') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
            </div>
          </div>
          <div class="row form-group">
            <a id="btnEditJogo" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                <?php echo _('Guardar ') . $modal_item ?>
            </a>                
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script language="javascript">

	/*
	//
	$( "#formEditJuego" ).submit(function( event ) 
	{
		//pegar os valores a serem alterados.
		var idJogo = $(input_id_Juego).val();
		var nomeJogo = $(input_nombre_Juego).val();
		var codJogo = $(input_code_Juego).val();		

		
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraJogo.php', // Informo a URL que será pesquisada.
			data: 'nome='+nomeJogo+'&codigo='+codJogo+'&id='+idJogo,
			success: function(html)
			{
				if(html == 0)
				{
					alert("Erro");
					return false;
				}
			}
		});	
	});*/
	
	
	//
	$('#btnEditJogo').click(function()
	{
		//
		var idJogo = $(input_id_Juego).val();
		var nomeJogo = $(input_nombre_Juego).val();
		var codJogo = $(input_code_Juego).val();


		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraJogo.php', // Informo a URL que será pesquisada.
			data: 'id='+idJogo+'&nome='+nomeJogo+'&codigo='+codJogo,
			success: function(html)
			{
				if(html == true)
				{
					$('#edit-modal-Juegos').fadeOut("slow");
					$('#msgConfirm').text('Registro alterado con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#edit-modal-Juegos').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para alterar el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}	
			}
		});
	});	

</script>