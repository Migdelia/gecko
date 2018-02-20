<?php $modal_item = "Lista de cajas abiertas" // ingresar la palabra clave de cada modal ?>
<div id="modal-cajas-lista" class="modal fade" tabindex="-1" style="display: none;">
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
                  <?php echo _('Maquina') ?>
                </th>
                <th>
                  <?php echo _('Orden') ?>
                </th>
                <th>
                  <?php echo _('Editar') ?>
                </th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i < 3 ; $i++):?>
                <tr>
                  <td><?php echo('vmtd -'.rand(100,2000)); ?></td>
                  <td><?php echo rand(1,9)?></td>
                  <td>
                    <div class="input-group">
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-minus"></span>
                        </button>
                      </span>
                      <!-- <input type="text" name="quant[2]" class="form-control input-number" value="10" min="1" max="100"> -->
                      <span class="input-group-btn">
                        <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="quant[2]">
                          <span class="glyphicon glyphicon-plus"></span>
                        </button>
                      </span>
                    </div>
                  </td>
                </tr>
              <?php endfor; ?>
            </tbody>
          </table>
          <a href="#" class="btn"><?php echo _('Reordenar') ?></a>
        </div>
      </div>
    </div>
  </div>
</div>