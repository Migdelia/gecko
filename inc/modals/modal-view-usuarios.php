<?php $modal_item = "Usuario" // ingresar la palabra clave de cada modal ?>
<div id="view-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-eye"></i> <?php echo _('Ver ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
      	<!---
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos fugit tempora perferendis officia nihil aspernatur vel, suscipit magni ex, accusantium quam commodi blanditiis inventore ducimus, in dolorum voluptatibus necessitatibus atque.</p>--->
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <tbody>
              <tr>
                <th><?php echo _('ID Login') ?></th>
                <td><span id="idLogin"></span></td>
                <th><?php echo _('E-mail') ?></th>
                <td><span id="usuEmail"></span></td>
              </tr>
              <tr>
                <th><?php echo _('Nome de usuario') ?></th>
                <td><span id="usuNome"></span></td>
                <th><?php echo _('Excluido') ?></th>
                <td><span id="usuStatus"></span></td>
              </tr>
              <tr>
                <th><?php echo _('Usuario') ?></th>
                <td><span id="usuario"></span></td>
                <th><?php echo _('Nivel de usuario') ?></th>
                <td><span id="usuNivel"></span></td>
              </tr>
              <tr>
                <th><?php echo _('Senha') ?></th>
                <td><span id="usuSenha">******</span></td>
                <th><?php echo _('Data de inclusao') ?></th>
                <td><span id="usuInclusao"></span></td>
              </tr>              
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>