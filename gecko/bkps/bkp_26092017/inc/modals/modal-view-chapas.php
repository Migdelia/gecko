<?php $modal_item = "Chapa" // ingresar la palabra clave de cada modal ?>
<div id="view-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Ver ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p><strong>Detalles</strong></p>
        


		<iframe id="view_chapa" src="frames/view-chapas.php" width="100%"  frameborder="0" scrolling="no" marginheight="0" marginwidth="0" align="middle" height="78px;"></iframe> 

        <br />
        <br />

        <div class="row form-group">
          <div class="col-xs-12">
            <button type="button" onclick="javascript:window.print()" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Imprimir') ?></button>
          </div>
        </div>

      </div>
    </div>
  </div>
</div>