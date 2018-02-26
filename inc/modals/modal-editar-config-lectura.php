<?php $modal_item = "Lectura" // ingresar la palabra clave de cada modal ?>

<div id="edit-config" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-gears"></i> <?php echo _('ALERTA!!! Edición configuración de  ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">

        <form  class="form-horizontal" method="post" action=" ">
          <div class="row">
          	
          	<div class="col-xs-12 col-md-12">
                <div class="row">
                  <center><b style="color:#1e90ff;">¿Está seguro que desea modificar la configuración la lectura?.</b>
                  </center>    
            </div>
            <div class="col-xs-12">
            	<div class="row form-group">
             		<a id="editar" type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 "><?php echo _('Si') ?></a>
                 <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-sm btn-raised col-xs-12 col-md-5 left"><?php echo _('Cancelar') ?></button>
           		</div>
            </div>                          
        </div>      
      </form>
    </div>
  </div>

</div>
</div>

<script type="text/javascript">
	//

	//
	$("#editar").click( function (){
	
		location="lectura-edit-configuracion.php?id=<?php echo $id_assoc;?>";
	});

	
</script>