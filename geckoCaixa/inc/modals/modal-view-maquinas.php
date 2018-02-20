<?php $modal_item = "Máquina" // ingresar la palabra clave de cada modal ?>
<div id="view-modal-Maquinas" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Ver ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel, suscipit magni ex, accusantium quam.</p>
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <tbody>
              <tr>
                <th></th>
                <td></td>
                <th><?php echo _('Fecha') ?></th>
                <td><i>21-07-2015</i></td>
              </tr>
              <tr>
                <th><?php echo _('Código') ?></th>
                <td>C - Frut</td>
                <th><?php echo _('Número') ?></th>
                <td>1984</td>
              </tr>
              <tr>
                <th><?php echo _('ID local') ?></th>
                <td>Bilbao</td>
                <th><?php echo _('Juego') ?></th>
                <td>Frutilla</td>
              </tr>
              <tr>
                <th><?php echo _('Interface') ?></th>
                <td>5558</td>
                <th><?php echo _('Por máquina esp') ?></th>
                <td>0</td>
              </tr>
              <tr>
                <th><?php echo _('Máquina de socio') ?></th>
                <td>False</td>
                <th><?php echo _('Porcentaje socio') ?></th>
                <td>Click para editar</td>
              </tr>
              <tr>
                <th><?php echo _('Operador') ?></th>
                <td>Leonardo</td>
                <th><?php echo _('Máquina socio') ?></th>
                <td>False</td>
              </tr>
              <tr>
                <th><?php echo _('Entrada oficial') ?></th>
                <td>$ 496.960</td>
                <th><?php echo _('Salida oficial') ?></th>
                <td>$ 224.350</td>
              </tr>
            </tbody>
          </table>
        </div>
        <div class="row form-group">
          <div class="col-xs-12">
            <button type="button" onclick="javascript:window.print()" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Imprimir') ?></button>
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Editar lectura oficial') ?></button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>