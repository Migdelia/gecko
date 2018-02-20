<div id="massaction-modal-leituraOnline" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <br />
        <p>
	        <h5><?php echo _('Estas seguro que quiere importar lectura?') ?></h5>        
        </p>

      </div>
      <div class="modal-body">
        <p>&nbsp;
        	
        </p>
        <div class="row form-group">
          <div class="col-xs-12">
            <button id="confImpo" name="confImpo" type="submit" class="btn send btn-sm btn-raised col-xs-12 col-md-4 right"><?php echo _('Confirmar') ?></button>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-sm btn-raised col-xs-12 col-md-4 right"><?php echo _('Cancelar') ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script language="javascript">
$('#confImpo').click(function() 
{
	/*
	//alert("importar leitura do integration");
	//return false;
	//fazer procedimento de trazer valores das maquina do street dongle. Aquiii Erico
	//location.reload();
	var url = window.location.href;
	
	alert(url);
	url = url + "&On=1";
	
	location = url;*/
	
	
	location="detalle-local.php?id=<?php echo $id_assoc;?>&rep=0&datepicker=<?php echo $dataRef;?>"+ "&On=1";
	
});
</script>