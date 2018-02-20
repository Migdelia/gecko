<?php $modal_item = "Agregar entrada/salida" // ingresar la palabra clave de cada modal ?>
<div id="modal-cajas-opciones-caja-add-entradasalida" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
        <h5><?php echo date('d/m/Y'); ?></h5>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-xs-3"><?php echo _('Valor') ?></div>
          <div class="col-xs-9">
            <select class="form-control input-sm">
              <option value=""><?php echo _('Entrada') ?></option>
              <option value=""><?php echo _('Salida') ?></option>
              <option value=""><?php echo _('Lorem') ?></option>
              <option value=""><?php echo _('Ipsum') ?></option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-3"><?php echo _('Operador') ?></div>
          <div class="col-xs-9">
            <input type="text" class="form-control">
          </div>
        </div>

        <div class="row">
          <div class="col-xs-3"><?php echo _('Descripción') ?></div>
          <div class="col-xs-9">
            <select class="form-control input-sm">
              <option value=""><?php echo _('Fundo Caja') ?></option>
              <option value=""><?php echo _('Dolor') ?></option>
              <option value=""><?php echo _('Lorem') ?></option>
              <option value=""><?php echo _('Ipsum') ?></option>
            </select>
          </div>
        </div>

        <div class="row">
          <div class="col-xs-3"><?php echo _('Caja') ?></div>
          <div class="col-xs-9">
            <select class="form-control input-sm">
              <option value=""><?php echo _('Caja') ?></option>
              <option value=""><?php echo _('Dolor') ?></option>
              <option value=""><?php echo _('Lorem') ?></option>
              <option value=""><?php echo _('Ipsum') ?></option>
            </select>
          </div>
        </div>

        <div class="row">
            <div class="col-xs-12">
              <a href="#" class="btn"><?php echo _('Volver')?></a>
              <a href="#" class="btn"><?php echo _('Insertar')?></a>
            </div>
          </div>

      </div>
    </div>
  </div>
</div>