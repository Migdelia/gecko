<?php $modal_item = "Interface";

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
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5>
			<?php echo _('Editar ') . $modal_item;?>
        </h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditDisp" method="post" action="">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('Num Interface') ?></label>
              <div class="row form-group">
                <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('Num Interface') ?></label>
                <input type="text" class="form-control" id="input_EditNum_<?php echo $modal_item ?>" name="input_EditNum_<?php echo $modal_item ?>" placeholder="<?php echo _('Número Interface') ?>" value="0" readonly>
              </div>
              <label for="input_expdate<?php echo $modal_item ?>" class="control-label"><?php echo _('Serie') ?></label>
              <div class="row form-group">
                <label for="input_expdate<?php echo $modal_item ?>" class="control-label"><?php echo _('Serie') ?></label>
                <input type="text" class="form-control" id="inputEdit_serie_<?php echo $modal_item ?>" name="inputEdit_serie_<?php echo $modal_item ?>" placeholder="<?php echo _('Serie') ?>" value="" >
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
            
            	<!---
              <label for="input_gameid<?php echo $modal_item ?>" class="control-label"><?php echo _('Juego') ?></label>
              <div class="row form-group">
                <label for="input_gameid<?php echo $modal_item ?>" class="control-label"><?php echo _('Juego') ?></label>
                <input type="text" class="form-control" id="input_game_<?php echo $modal_item ?>" name="input_game_<?php echo $modal_item ?>" placeholder="<?php echo _('Juego') ?>" value="" readonly>
              </div>--->

              <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Juego ') ?></label>
              <div class="row form-group">
                <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Juego ') ?></label>
                <input type="hidden" id="input_jogo_<?php echo $modal_item ?>" name="input_jogo_<?php echo $modal_item ?>" value="" >
                <a href="#" data-target="#" name="" data-toggle="dropdown" aria-expanded="false" id="select_jogo_<?php echo $modal_item ?>" name="select_jogo_<?php echo $modal_item ?>" class="btn dropdown-btn">
                    <div class="ripple-container" id="respUser"></div>
                </a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                	<span class="caret"></span>
                    <div class="ripple-container"></div>
               	</a>
                <ul class="dropdown-menu">
                
                
                <?php 
					//consulta nome dos usuarios
					$sql_jogo = "
						SELECT
							*
						FROM
							jogo
						ORDER BY
							nome
						";
						
					$query_jogo=@mysql_query($sql_jogo);
					
					//mostra todos usuarios
					while($res_jogo=@mysql_fetch_assoc($query_jogo)) 
					{						
				?>
                      <li>
                        <a href="#" class="mass-act" id="jogo_<?php echo _( $res_jogo['id_jogo'] ) ?>" onclick="atribuiValor(this);"><?php echo _( $res_jogo['nome'] ) ?></a>
                      </li>
                <?php
					}
				?>
                </ul>
              </div>   
              
              
              <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Máquina ') ?></label>
              <div class="row form-group">
                <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Máquina ') ?></label>
                <input type="hidden" id="input_maquina_<?php echo $modal_item ?>" name="input_maquina_<?php echo $modal_item ?>" value="" >
                <a href="#" data-target="#" name="" data-toggle="dropdown" aria-expanded="false" id="select_maquina_<?php echo $modal_item ?>" name="select_maquina_<?php echo $modal_item ?>" class="btn dropdown-btn">
                    <div class="ripple-container" id="respUser"></div>
                </a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                	<span class="caret"></span>
                    <div class="ripple-container"></div>
               	</a>
                <ul class="dropdown-menu">
                
                
                <?php 
					//consulta nome dos usuarios
					$sql_maquinas = "
						SELECT
							*
						FROM
							maquinas
						WHERE
							excluido = 'N'
						ORDER BY
							numero
						";
						
					$query_maquinas=@mysql_query($sql_maquinas);
					
					//mostra todos usuarios
					while($res_maquinas=@mysql_fetch_assoc($query_maquinas)) 
					{						
				?>
                      <li>
                        <a href="#" class="mass-act" id="maquina_<?php echo _( $res_maquinas['id_maquina'] ) ?>" onclick="atribuiValor(this);"><?php echo _( $res_maquinas['numero'] ) ?></a>
                      </li>
                      <div class="ripple-container"></div>
                <?php
					}
				?>
                </ul>
              </div>                 
                        
            </div>
          </div>
          <div class="row form-group">
            <a id="btnEditInterface" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
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
		
		$('#select_'+tpCombo+'_Interface').text(obj.text);
		$('#input_'+tpCombo+'_Interface').attr("value", obj.text);	
	}
	
	//
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
	
	//
	$('#btnEditInterface').click(function()
	{
		var numInterface = $('#input_EditNum_Interface').val();
		var serInterface = $('#inputEdit_serie_Interface').val();
		var jogoInterface = $('#input_jogo_Interface').val();	
		var maqInterface = $('#input_maquina_Interface').val();	


		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraInterface.php', // Informo a URL que será pesquisada.
			data: 'input_EditNum_Interface='+numInterface+'&inputEdit_serie_Interface='+serInterface+'&input_jogo_Interface='+jogoInterface+'&input_maquina_Interface='+maqInterface,
			success: function(html)
			{
				if(html == true)
				{
					$('#edit-modal-Interfaces').fadeOut("slow");
					$('#msgConfirm').text('Registro alterado con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#edit-modal-Interfaces').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para alterar el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
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

