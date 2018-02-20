<?php $modal_item = "Dispositivo";

session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

if($_SESSION['usr_nivel'] <> 8)
{

?>
<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-pencil"></i> 
			<?php echo _('Editar Dongle');?>
        </h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditDisp" method="post">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('ID de la Dongle') ?></label>
              <div class="row form-group">
                <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('ID de la Dongle') ?></label>
                <input type="text" class="form-control" id="input_id_<?php echo $modal_item ?>" placeholder="<?php echo _('ID de la Máquina') ?>" value="0" readonly>
              </div>
              <label for="input_expdate<?php echo $modal_item ?>" class="control-label"><?php echo _('Fecha de Expiración') ?></label>
              <div class="row form-group">
                <label for="input_expdate<?php echo $modal_item ?>" class="control-label"><?php echo _('Fecha de Expiración') ?></label>
                <input type="text" class="form-control" id="input_expdate_<?php echo $modal_item ?>" placeholder="<?php echo _('Fecha de Expiración') ?>" value="" readonly>
              </div>
              <label for="input_periodo<?php echo $modal_item ?>" class="control-label"><?php echo _('Periodo') ?></label>
              <div class="row form-group">
                <label for="input_periodo<?php echo $modal_item ?>" class="control-label"><?php echo _('Periodo') ?></label>
                <input type="text" class="form-control" name="input_periodo_<?php echo $modal_item ?>" id="input_periodo_<?php echo $modal_item ?>" placeholder="<?php echo _('Periodo') ?>" value="0" >
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <label for="input_gameid<?php echo $modal_item ?>" class="control-label"><?php echo _('ID del juego') ?></label>
              <div class="row form-group">
                <label for="input_gameid<?php echo $modal_item ?>" class="control-label"><?php echo _('ID del juego') ?></label>
                <input type="text" class="form-control" id="input_game_<?php echo $modal_item ?>" placeholder="<?php echo _('ID del juego') ?>" value="" readonly>
              </div>
              
              
              <label for="input_ultact<?php echo $modal_item ?>" class="control-label"><?php echo _('Última Actualización') ?></label>
              <div class="row form-group">
                <label for="input_ultact<?php echo $modal_item ?>" class="control-label"><?php echo _('Última Actualización') ?></label>
                <input type="text" class="form-control" id="input_ultact_<?php echo $modal_item ?>" placeholder="<?php echo _('Última Actualización') ?>" value="" readonly>
              </div>
                                         
              
              <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Usuario ') . $modal_item ?></label>
              <div class="row form-group">
                <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Usuario ') . $modal_item ?></label>
                <a href="#" data-target="#" name="" data-toggle="dropdown" aria-expanded="false" id="input_user_<?php echo $modal_item ?>" class="btn dropdown-btn">
                    <div class="ripple-container" id="respUser"></div>
                </a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                	<span class="caret"></span>
                    <div class="ripple-container"></div>
               	</a>
              </div>             
            </div>
          </div>
          <div class="row form-group">
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Guardar ') . $modal_item ?></button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>
<script language="javascript">
	function atribuiUser(obj)
	{
		$('#input_user_Dispositivo').text(obj.text);
	}
	
	
	$( "#formEditDisp" ).submit(function( event ) 
	{
		//pegar os dois valores a serem alterados.
		var usuario = $('#input_user_Dispositivo').text(); 
		var idDisp = $(input_id_Dispositivo).val();
		var periodo = $(input_periodo_Dispositivo).val();


		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraDispositivo.php', // Informo a URL que será pesquisada.
			data: 'id='+idDisp+'&perAtu='+periodo+'&user='+usuario,
			success: function(html)
			{
				if(html == 0)
				{
					alert("Erro");	
				}
				else
				{
					reload;	
				}
			}
		});	
	});	
</script>
<?php
}
else
{
?>

<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5>
			Acesso Negado
        </h5>
      </div>
    </div>
   </div>
  </div>

<?php	
}
?>

