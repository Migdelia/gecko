<?php $modal_item = "Histórico de pagos" // ingresar la palabra clave de cada modal ?>
<div id="modal-cajas-opciones-caja-historico" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p><strong>Detalles</strong></p>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel, suscipit magni ex, accusantium quam commodi blanditiis inventore ducimus, in dolorum voluptatibus necessitatibus atque.</p>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th><?php echo _('Hora') ?></th>
                <th><?php echo _('Operador') ?></th>
                <th><?php echo _('Máquina') ?></th>
                <th><?php echo _('Usuario') ?></th>
                <th><?php echo _('Valor') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i <3 ; $i++): ?>
                <tr>
                  <td><?php date('H:i:s');?></td>
                  <td><?php echo 'Ronaldinho'?></td>
                  <td><?php echo 'SKU-'.rand(111,999);?></td>
                  <td><?php echo 'Caja' ?></td>
                  <td><?php echo rand(1111,9999)?></td>
                </tr>
              <?php endfor; ?>
            </tbody>
            <tfoot>
              <tr>
                <td colspan="4">
                  <?php echo date('d-m-Y');?>
                </td>
                <td>
                  <?php echo rand(1111,9999)?>
                </td>
              </tr>
            </tfoot>
          </table>
          <div class="row">
            <div class="col-xs-12">
              <a href="#" class="btn">Nueva</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>