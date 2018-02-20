<?php $modal_item = "Lectura" // ingresar la palabra clave de cada modal ?>
<div id="view-modal-<?php echo $modal_item ?>" class="modal fade" tabindex="-1" style="display: none;">
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
                <th><?php echo _('ID') ?></th>
                <td>1545</td>
              </tr>
              <tr>
                <th><?php echo _('Fecha') ?></th>
                <td>21-07-2015</td>
                <th><?php echo _('Nombre') ?></th>
                <td>Lorem Ipsum</td>
              </tr>
              <tr>
                <th><?php echo _('Usuario') ?></th>
                <td>Lorem</td>
                <th><?php echo _('Fecha lectura') ?></th>
                <td>19-12-2014</td>
              </tr>
              <tr>
                <th><?php echo _('Local') ?></th>
                <td>Bilbao</td>
                <th><?php echo _('Semana') ?></th>
                <td>1</td>
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