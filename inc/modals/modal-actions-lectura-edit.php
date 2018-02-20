<div id="massaction-modal" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Estas seguro que quiere Editar esta lectura?') ?></h5>
      </div>
      <div class="modal-body">
        <p>
        	<strong><span id="tpAcao">Local:</strong> <?php echo $result_loc['nome'];?></span>
            <br />
        	
        </p>
	
            <br />

            
            <p>
            	<span id="cont_acao"></span>
            </p>
        </p>
        <div class="row form-group">
          <div class="col-xs-12">
            <button id="confirmar" type="submit" class="btn send btn-sm btn-raised col-xs-12 col-md-4 right"><?php echo _('Confirmar') ?></button>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-sm btn-raised col-xs-12 col-md-4 right"><?php echo _('Cancelar') ?></button>  
            
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>


