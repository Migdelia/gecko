<?php $modal_item = "Billetero" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditPlaca" method="post" action="functions/alteraBil.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <?php
			  	//
				$sql_lista_bilheteiros = "
					SELECT
						*
					FROM
						modelos_bilheteiro
					ORDER BY
						modelos_bilheteiro.descricao
					";	
				
				$query_lista_bilheteiros=@mysql_query($sql_lista_bilheteiros);
			  ?>
              
              <div class="row form-group">
              	<!--- declara id da placa --->
                <input type="hidden" id="id_bilheteiro" name="id_bilheteiro" value=""  />
              
                <label for="input_modelo<?php echo $modal_item ?>" class="control-label"><?php echo _('Modelo') ?></label>
                <input type="hidden" id="input_modBil_<?php echo $modal_item ?>" name="input_modBil_<?php echo $modal_item ?>" value="<?php echo $res_maq['excluido'] ?>" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_modBil_<?php echo $modal_item ?>" name="select_modBil_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Modelo') ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                
                <?php
					//
					while($res_lista_bilheteiros=@mysql_fetch_assoc($query_lista_bilheteiros)) 
					{
						echo "<li>";
						echo "<a id='modBil_".$res_lista_bilheteiros['id_modelo']."' href='#' class='mass-act' onClick='atribuiValor(this);'>".$res_lista_bilheteiros['descricao']."</a>";
						echo "</li>";
						echo "<li class='divider'></li>";
					}			
				?>
                
                </ul>
              </div>           
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
              
              <div class="row form-group">
                <label for="input_maquina<?php echo $modal_item ?>" class="control-label"><?php echo _('Maquina') ?></label>
                <input type="hidden" id="input_maqBil_<?php echo $modal_item ?>" name="input_maqBil_<?php echo $modal_item ?>" value="<?php echo $res_maq['id_maquina'] ?>" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_maqBil_<?php echo $modal_item ?>" name="select_maqBil_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Maquina') ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                <?php
					//
					while($res_lista_maquinas=@mysql_fetch_assoc($query_lista_maquinas)) 
					{
						echo "<li>";
						echo "<a id='maqBil_".$res_lista_maquinas['id_maquina']."' href='#' class='mass-act' onClick='atribuiValor(this);'>".$res_lista_maquinas['numero']."</a>";
						echo "</li>";
						echo "<li class='divider'></li>";
					}			
				?>
                </ul>
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

//
function atribuiValor(obj)
{
	//
	var tpCombo = obj.id.split("_");
	tpCombo = tpCombo[0];
	
	var idObj = obj.id.split("_");
	idObj = idObj[1];

	//
	$('#select_'+tpCombo+'_Billetero').text(obj.text);
	$('#input_'+tpCombo+'_Billetero').attr("value", idObj);
}
</script>