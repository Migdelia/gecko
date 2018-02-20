<?php $modal_item = "Local" // ingresar la palabra clave de cada modal ?>
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
                <th><?php echo _('Tipo de local') ?></th>
                <td>Tipo</td>
                <th><?php echo _('Nombre Operador') ?></th>
                <td>Nombre Operador</td>
              </tr>
              <tr>
                <th><?php echo _('Gerente') ?></th>
                <td>Gerente</td>
                <th><?php echo _('Porcentual local') ?></th>
                <td>22%</td>
              </tr>
              <tr>
                <th><?php echo _('Operador') ?></th>
                <td>Operador</td>
                <th><?php echo _('Comisión Operador') ?></th>
                <td>50%</td>
              </tr>
              <tr>
                <th><?php echo _('Porcentual local') ?></th>
                <td>22%</td>
                <th><?php echo _('Comisión Gerente') ?></th>
                <td>50%</td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>