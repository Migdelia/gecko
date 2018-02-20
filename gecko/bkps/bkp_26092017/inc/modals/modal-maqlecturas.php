<div id="maqnolectura-modal" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><strong>Máquina nº <span id="numMaq"></span></strong></h5>
      </div>
      <div class="modal-body">
        <p><strong>Número Dispositivo:</strong> <span id="numDisp"></span></p>
        <p><strong>Tipo Dispositivo:</strong> <span id="tpDisp"></span></p>
        <p><strong>Período de validacion:</strong> <span id="periodoVal"></span></p>
        <p><strong>Data de expiracion:</strong> <span id="dtExpDisp"></span></p>
        <p><strong>Operador:</strong> <span id="opeDisp"></span></p>
        <p><strong>Juego:</strong> <span id="jogoDisp"></span></p>
        
        
        <div class="row form-group">
          <div class="col-xs-12">
            <button type="button" onclick="javascript:window.print()" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Imprimir') ?></button>
          </div>
        </div>        
        
      </div>
    </div>
  </div>
</div>