<?php $modal_item = "Lista de cajas abiertas" // ingresar la palabra clave de cada modal ?>
<div id="modal-cajas-lista-2" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
        <h5><?php echo date('d/m/Y');?></h5>
      </div>
      <div class="modal-body">
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <thead>
              <tr>
                <th>
                  <?php echo _('Id') ?>
                </th>
                <th>
                  <?php echo _('Usuario') ?>
                </th>
                <th>
                  <?php echo _('Saldos') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php 
              $d_usuarios = array("Gerente", "Caja", "Admin", "Otro");
              for ($i=0; $i < 3 ; $i++): 
                $d_usuarios_key = array_rand($d_usuarios, 3);
                ?>
                <tr>
                  <td><?php echo rand(1,99);?></td>
                  <td><?php echo $d_usuarios[$d_usuarios_key[$i]]?></td>
                  <td><?php echo '$ '.rand(1111,99999)?></td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>