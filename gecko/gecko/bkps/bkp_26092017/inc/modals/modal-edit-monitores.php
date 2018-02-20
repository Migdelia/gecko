<?php $modal_item = "Monitor" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditMonitor" method="post" action="functions/alteraMonitor.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <?php
			  	//
				$sql_lista_monitores = "
					SELECT
						*
					FROM
						modelos_monitor
					ORDER BY
						modelos_monitor.descricao
					";	
				
				$query_lista_monitores=@mysql_query($sql_lista_monitores);
			  ?>
              
              <label for="input_modelo<?php echo $modal_item ?>" class="control-label"><?php echo _('Modelo') ?></label>
              <div class="row form-group">
              	<!--- declara id da monitor --->
                <input type="hidden" id="id_monitor" name="id_monitor" value=""  />
              
                <label for="input_modelo<?php echo $modal_item ?>" class="control-label"><?php echo _('Modelo') ?></label>
                <input type="hidden" id="input_modMon_<?php echo $modal_item ?>" name="input_modMon_<?php echo $modal_item ?>" value="<?php echo $res_maq['excluido'] ?>" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_modMon_<?php echo $modal_item ?>" name="select_modMon_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Modelo') ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                
                <?php
					//
					while($res_lista_monitores=@mysql_fetch_assoc($query_lista_monitores)) 
					{
						echo "<li>";
						echo "<a id='modMon_".$res_lista_monitores['id_modelo']."' href='#' class='mass-act' onClick='atribuiValor(this);'>".$res_lista_monitores['descricao']."</a>";
						echo "</li>";
						echo "<li class='divider'></li>";
					}			
				?>
                
                </ul>
              </div>
              
              <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Serie') ?></label>       
              <div class="row form-group">
                <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Serie') ?></label>
                <input type="text" class="form-control" id="edit_serie_<?php echo $modal_item ?>" name="edit_serie_<?php echo $modal_item ?>" placeholder="Serie" value="">
              </div>
                                     
            </div>
            
            <!--- separa coluna --->
            
            <div class="col-xs-12 col-md-6">
              <?php
			  	//
				$sql_lista_maquinas = "
					SELECT
						*
					FROM
						maquinas
					WHERE
						excluido = 'N'
					ORDER BY
						numero
					";	
				
				$query_lista_maquinas=@mysql_query($sql_lista_maquinas);
			  ?>
              
              <label for="input_maquina<?php echo $modal_item ?>" class="control-label"><?php echo _('Maquina') ?></label>
              <div class="row form-group">
                <label for="input_maquina<?php echo $modal_item ?>" class="control-label"><?php echo _('Maquina') ?></label>
                <input type="hidden" id="input_maqMon_<?php echo $modal_item ?>" name="input_maqMon_<?php echo $modal_item ?>" value="<?php echo $res_maq['id_maquina'] ?>" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_maqMon_<?php echo $modal_item ?>" name="select_maqMon_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Maquina') ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                <?php
					//
					while($res_lista_maquinas=@mysql_fetch_assoc($query_lista_maquinas)) 
					{
						echo "<li>";
						echo "<a id='maqMon_".$res_lista_maquinas['id_maquina']."' href='#' class='mass-act' onClick='atribuiValor(this);'>".$res_lista_maquinas['numero']."</a>";
						echo "</li>";
						echo "<li class='divider'></li>";
					}			
				?>
                </ul>
              </div>
                                        
            </div>
          </div>
          <div class="row form-group">
            <a id="btnEditMon" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
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
		$('#select_'+tpCombo+'_Monitor').text(obj.text);
		$('#input_'+tpCombo+'_Monitor').attr("value", idObj);
	}

	//
	$('#btnEditMon').click(function()
	{
		var idMon = $('#id_monitor').val();
		var modMon = $('#input_modMon_Monitor').val();
		var serieMon = $('#edit_serie_Monitor').val();
		var maqMon = $('#input_maqMon_Monitor').val();																			
		

		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraMonitor.php', // Informo a URL que será pesquisada.
			data: 'id_monitor='+idMon+'&input_modMon_Monitor='+modMon+'&edit_serie_Monitor='+serieMon+'&input_maqMon_Monitor='+maqMon,
			success: function(html)
			{
				if(html == true)
				{
					$('#edit-modal-Monitores').fadeOut("slow");
					$('#msgConfirm').text('Registro alterado con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#edit-modal-Monitores').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para alterar el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}	
			}
		});
	});
</script>