<?php $modal_item = "Ciudad" // ingresar la palabra clave de cada modal ?>
<div id="view-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Nombre') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p><strong>Detalles</strong></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel, suscipit magni ex, accusantium quam commodi blanditiis inventore ducimus, in dolorum voluptatibus necessitatibus atque.</p>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <tbody>
              <tr>
                <th><?php echo _('ID') ?></th>
                <td>0004</td>
                <th><?php echo _('Ciudades') ?></th>
                <td>Arica</td>
              </tr>
              <tr>
                <th><?php echo _('Excluido') ?></th>
                <td>Desactivado</td>
                <th><?php echo _('Máquinas de local') ?></th>
                <td>VM-900</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>