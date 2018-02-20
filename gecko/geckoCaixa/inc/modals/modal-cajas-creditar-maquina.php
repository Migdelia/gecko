<?php $modal_item = "Creditar-Maquina" // ingresar la palabra clave de cada modal ?>
<div id="modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo str_replace('-',' ',$modal_item) ?> 70049</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi temporibus distinctio id nemo omnis expedita, esse provident odio labore deleniti totam</p>
        <br>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-xs-3"><?php echo _('Valor Actual') ?></div>
          <div class="col-xs-3">
            <strong>20000</strong>
          </div>
          <div class="col-xs-6"></div>
        </div>
        <div class="row">
          <div class="col-xs-3"><?php echo _('Valor') ?></div>
          <div class="col-xs-3">
            <select class="form-control input-sm">
              <option value=""><?php echo _('Elegir') ?></option>
              <option value=""><?php echo _('$ 1000') ?></option>
              <option value=""><?php echo _('$ 2000') ?></option>
              <option value=""><?php echo _('Ipsum') ?></option>
            </select>
          </div>
          <div class="col-xs-6"></div>
        </div>

        <div class="row">
          <div class="col-xs-3"><?php echo _('Promo') ?></div>
          <div class="col-xs-3">
            <select class="form-control input-sm">
              <option value=""><?php echo _('Elegir') ?></option>
              <option value=""><?php echo _('$ 1000') ?></option>
              <option value=""><?php echo _('$ 2000') ?></option>
              <option value=""><?php echo _('Ipsum') ?></option>
            </select>
          </div>
          <div class="col-xs-6 center-align"><button class="btn-danger">Borrar</button></div>
        </div>

        <div class="row">
            <div class="col-xs-12">
              <a href="#" class="btn"><?php echo _('Insertar')?></a>
              <a href="#" class="btn" data-target="#modal-cobrar-maquina" data-toggle="modal"><?php echo _('Cobrar')?></a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>


<?php $modal_item = "Maquina" // ingresar la palabra clave de cada modal ?>
<div id="modal-cobrar-maquina" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo str_replace('-',' ',$modal_item) ?> 800</h5>
        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Eligendi temporibus distinctio id nemo omnis expedita, esse provident odio labore deleniti totam</p>
        <br>
      </div>
      <div class="modal-body">

        <div class="row">
          <div class="col-xs-3"><?php echo _('Valor') ?></div>
          <div class="col-xs-3">
            <input type="text" class="form-control" required="required">
          </div>
          <div class="col-xs-6"></div>
        </div>
        <div class="row">
          <div class="col-xs-3"><?php echo _('Operador') ?></div>
          <div class="col-xs-3">
            <select class="form-control input-sm">
              <option value=""><?php echo _('Pedrinho') ?></option>
              <option value=""><?php echo _('Operador 02') ?></option>
              <option value=""><?php echo _('Operador 03') ?></option>
              <option value=""><?php echo _('Ipsum') ?></option>
            </select>
          </div>
          <div class="col-xs-6"></div>
        </div>

        <div class="row">
            <div class="col-xs-12">
              <a href="#" class="btn"><?php echo _('Cancelar')?></a>
              <a href="#" class="btn"><?php echo _('Pagar')?></a>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>