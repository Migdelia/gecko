<?php $modal_item = "Mapa" // ingresar la palabra clave de cada modal ?>
<div id="maquinasPorLocal-modal" class="modal fade" tabindex="-1" style="display: none;">
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
            <thead>
              <tr>
                <th>Modelo</th>
                <th>Premio</th>
                <th>Saldo</th>
                <th></th>
              </tr>
            </thead>
            <tbody>
              <?php for ($i=0; $i <5 ; $i++): ?>
              <tr>
                <th>Avenida Siempreviva #456</th>
                <th><?php echo rand(0,9999) ?></th>
                <th><?php echo rand(0,9999) ?></th>
<!--
                <th><a href="#" style="width: 125px; border-right-width: 10px;"class="btn btn-default" role="button" style="color: white"> <?php echo _('Ver Máquina') ?></a></th> -->
                <th style="width: 175px;"><a href="maquinas.php"class="btn btn-default center-align"  role="button" style="color: white"> <?php echo _('Ver Máquina') ?></a></th>


              </tr>
            <?php endfor; ?>
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