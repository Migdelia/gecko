<?php $modal_item = "Dispositivo" // ingresar la palabra clave de cada modal ?>
<div id="view-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item . _(' de seguridad') ?></h5>
      </div>
      <div class="modal-body">
        <p><strong>Detalles</strong></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel, suscipit magni ex, accusantium quam commodi blanditiis inventore ducimus, in dolorum voluptatibus necessitatibus atque.</p>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <tbody>
              <tr>
                <th><?php echo _('ID de la Máquina') ?></th>
                <td>70050</td>
                <th><?php echo _('Fecha de Expiración') ?></th>
                <td>000-00-00 00:00:00</td>
              </tr>
              <tr>
                <th><?php echo _('ID del juego') ?></th>
                <td>29</td>
                <th><?php echo _('Última Actualización') ?></th>
                <td>000-00-00 00:00:00</td>
              </tr>
              <tr>
                <th><?php echo _('Periodo') ?></th>
                <td>0</td>
                <th></th>
                <td></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>