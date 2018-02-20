<div id="massaction-modal-repLeitura" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <br />
        <p>
	        <h5><?php echo _('Estas seguro que quiere repetir la ultima lectura?') ?></h5>        
        </p>

      </div>
      <div class="modal-body">
        <p>&nbsp;
        	
        </p>
        <div class="row form-group">
          <div class="col-xs-12">
            <button id="confRep" name="confRep" type="submit" class="btn send btn-sm btn-raised col-xs-12 col-md-4 right"><?php echo _('Confirmar') ?></button>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-sm btn-raised col-xs-12 col-md-4 right"><?php echo _('Cancelar') ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<script language="javascript">
$('#confRep').click(function() 
{
	location="detalle-local.php?id=<?php echo $id_assoc;?>&rep=1&datepicker=<?php echo $dataRef;?>";
});
</script>