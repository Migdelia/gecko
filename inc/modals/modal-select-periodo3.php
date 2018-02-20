<?php $modal_item = "Lectura" // ingresar la palabra clave de cada modal ?>

<div id="select-periodo3" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-trash"></i> <?php echo _('ALERTA!!!!!  Eliminación ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">

        <form id="formInfoLeitura" class="form-horizontal" method="post" action="eliminar_leitura.php">
          <div class="row">
          	<div class="col-xs-12 col-md-12">
                <div class="row">              
             
                  <center><b style="color:red;" >¿Está seguro que desea Eliminar la lectura? <br><br>Esto modificará todas las lecturas oficiales registradas en el sistema.</b></center> 
                </div>          
            </div>
          	
            <div class="col-xs-12">
            	<div class="row form-group">
             		<a id="btneliminar" type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5"><?php echo _('Si') ?></a>
                 <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-sm btn-raised col-xs-12 col-md-5 left "><?php echo _('Cancelar') ?></button>
           		</div>
            </div>                          
        </div>      
      </form>
    </div>
  </div>
</div>
</div>


