<?php $modal_item = " Informaciones Maquinas " // ingresar la palabra clave de cada modal ?>
<div id="maquinasPorLocal-modal" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item . '(Gran Faraon) ' ?></h5>
      </div>
      <div class="modal-body">
        <p>Informaciones en tiempo real de las maquinas de: <strong>Gran Faraon</strong></p>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>Maquina</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Saldo</th>
              </tr>
            </thead>
            <tbody>
            
            <?php
			
				//consulta as maquinas desse local.
				$sql_maquinas = "SELECT * FROM maquinas WHERE id_local = 55 ORDER BY numero";
				$query_maquinas=@mysql_query($sql_maquinas);
				
				//
				while($res_maquinas=@mysql_fetch_assoc($query_maquinas)) 
				{
			?>
                    
                    <tr>
                    	<th><?php echo $res_maquinas['numero'] ?></th>
                    	<th><?php echo 'SKU-'.rand(0,9999) ?></th>
                    	<th><?php echo rand(0,9999) ?></th>
                    	<th><?php echo rand(0,9999) ?></th>
                    </tr>            
            <?php
				}	
			?>
            



            </tbody>
          </table>
        </div>
        <div class="row form-group">
          <div class="col-xs-12">
            <button type="button" onclick="javascript:window.print()" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Imprimir') ?></button>
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Editar lectura oficial') ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>