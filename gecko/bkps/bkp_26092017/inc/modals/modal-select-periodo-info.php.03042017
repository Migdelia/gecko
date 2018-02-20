<?php $modal_item = "Lectura" // ingresar la palabra clave de cada modal ?>
<div id="select-periodo" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Elegir periodo de ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">

        <form id="formInfoLeitura" class="form-horizontal" method="post" action="detalle-local.php">
          <div class="row">
          	<div class="col-xs-12 col-md-6">
                <div class="row">              
                  <label for="tags">Fecha inicio</label>
                  <input type='text' id='dataInicio' name='dataInicio' size='23' placeholder="dd-mm-aaaa" value="<?php echo date("d-m-Y")?>" readonly>
                </div>          
            </div>
          	<div class="col-xs-12 col-md-6">
                <div class="row">
                  <label for="tags">Fecha final</label>
                  <input type='text' id='dataFinal' name='dataFinal' size='23' placeholder="dd-mm-aaaa" value="<?php echo date("d-m-Y")?>" readonly>
                </div>             
            </div>
            <div class="col-xs-12">
            	<div class="row form-group">
             		<a id="btnRecarregar" type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Siguiente') ?></a>
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
	
	$(function() {
		$("#dataInicio").datepicker({dateFormat: 'dd-mm-yy'});
		$("#dataFinal").datepicker({dateFormat: 'dd-mm-yy'});		
	});		
	
	
	
	//
	$("#btnRecarregar").click( function (){
		//pegar data inicio 
		dataInicio = $("#dataInicio").val();
		
		//pegar data final
		dataFinal = $("#dataFinal").val();
		
		//
		location="info-alteraciones.php?dI="+dataInicio+"&dF="+dataFinal;
	});

	
</script>