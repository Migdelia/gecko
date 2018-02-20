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
        <form class="form-horizontal" method="post" action="functions/addChapa.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
			  <div class="row form-group">
                <label for="input_modelo<?php echo $modal_item ?>" class="control-label"><?php echo _('Modelo') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_modelo_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Modelo') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_modelo_<?php echo $modal_item ?>" name="hd_modelo_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                <?php
					//consulta cidades
					$sql_modelos = "
						SELECT
							*
						FROM
							modelos_chapa
						";	
					
					
					$query_modelos=@mysql_query($sql_modelos);
					
					//
					while($res_modelos=@mysql_fetch_assoc($query_modelos)) 
					{
				?>
                          <li>
                            <a href="#" class="mass-act" id="modelo_<?php echo $modal_item ?>" onclick="atribuiValor(this);"><?php echo _($res_modelos['descricao']) ?></a>
                          </li>                
                <?php
					}								
				?>             


                </ul>
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
			  <div class="row form-group">
                <label for="add_maquina<?php echo $modal_item ?>" class="control-label"><?php echo _('Maquina') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_maquina_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Maquina') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_maquina_<?php echo $modal_item ?>" name="hd_maquina_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                
                <?php
					//consulta cidades
					$sql_maquinas = "
						SELECT
							numero
						FROM
							maquinas
						WHERE
							excluido = 'N'
						ORDER BY
							numero
						";	
					
					
					$query_maquinas=@mysql_query($sql_maquinas);
					
					//
					while($res_maquinas=@mysql_fetch_assoc($query_maquinas)) 
					{
				?>
                      <li>
                        <a href="#" class="mass-act" id="maquina_<?php echo $modal_item ?>" onclick="atribuiValor(this);"><?php echo _($res_maquinas['numero']) ?></a>
                      </li>                
                <?php
					}								
				?>
                

                </ul>
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Crear Nueva ') . $modal_item ?></button>
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
</script>