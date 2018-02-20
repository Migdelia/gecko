<?php $modal_item = "Entrada / Salida de Caja" // ingresar la palabra clave de cada modal ?>
<div id="modal-cajas-opciones-caja-entradasalida" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
        <h5><?php echo date('d/m/Y'); ?></h5>
      </div>
      <div class="modal-body">

        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th><?php echo _('Tipo') ?></th>
                <th><?php echo _('Hora') ?></th>
                <th><?php echo _('Detalle') ?></th>
                <th><?php echo _('Valor') ?></th>
                <th><?php echo _('Autorizao') ?></th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i <3 ; $i++): ?>
                <tr>
                  <td><?php echo _('Entrada');?></td>
                  <td><?php echo date('H:i:s');?></td>
                  <td><?php echo _('Fundo de caja');?></td>
                  <td><?php echo rand(1111,9999);?></td>
                  <td><?php echo _('Autorizado');?></td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
          <div class="row">
            <div class="col-xs-12">
              <a class="btn" data-target="#modal-cajas-opciones-caja-add-entradasalida" data-toggle="modal">Nueva</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include("inc/modals/modal-cajas-opciones-caja-add-entradasalida.php"); ?>