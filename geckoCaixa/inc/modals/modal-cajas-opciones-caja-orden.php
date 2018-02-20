<?php $modal_item = "Opciones de lista de caja -> Orden Máquina" // ingresar la palabra clave de cada modal ?>
<div id="modal-cajas-opciones-caja-orden" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <h5><?php echo _('Orden Máquina')?></h5>
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