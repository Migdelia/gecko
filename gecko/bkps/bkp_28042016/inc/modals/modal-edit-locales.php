<?php $modal_item = "Local" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" action="functions/alteraLocal.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('ID Local') ?></label>
                <input type="text" class="form-control" id="id_<?php echo $modal_item ?>" name="id_<?php echo $modal_item ?>" placeholder="ID Local" value="" disabled="disabled">
                <input type="hidden" id="edit_id_<?php echo $modal_item ?>" name="edit_id_<?php echo $modal_item ?>" value="" />
              </div>            
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Ciudad') ?></label>
                <input type="text" class="form-control" id="edit_cidade_<?php echo $modal_item ?>" name="edit_cidade_<?php echo $modal_item ?>" placeholder="Ciudad" value="">
              </div>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo Local') ?></label>
                <input type="text" class="form-control" id="edit_tipo_<?php echo $modal_item ?>" name="edit_tipo_<?php echo $modal_item ?>" placeholder="Tipo Local" value="">
              </div>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Razao Social') ?></label>
                <input type="text" class="form-control" id="edit_rs_<?php echo $modal_item ?>" name="edit_rs_<?php echo $modal_item ?>" placeholder="Razao Social" value="">
              </div>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Porcentual Local') ?></label>
                <input type="text" class="form-control" id="edit_pct_<?php echo $modal_item ?>" name="edit_pct_<?php echo $modal_item ?>" placeholder="Porcentual Local" value="">
              </div>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre Local') ?></label>
                <input type="text" class="form-control" id="edit_nome_<?php echo $modal_item ?>" name="edit_nome_<?php echo $modal_item ?>" placeholder="Nombre Local" value="">
              </div>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Rut') ?></label>
                <input type="text" class="form-control" id="edit_rut_<?php echo $modal_item ?>" name="edit_rut_<?php echo $modal_item ?>" placeholder="Rut" value="">
              </div>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Inclusion') ?></label>
                <input type="text" class="form-control" id="edit_incluido_<?php echo $modal_item ?>" name="edit_incluido_<?php echo $modal_item ?>" placeholder="Inclusion" value="">
              </div> 
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Orden') ?></label>
                <input type="text" class="form-control" id="edit_orden_<?php echo $modal_item ?>" name="edit_orden_<?php echo $modal_item ?>" placeholder="Orden" value="">
              </div>                            
                                     
            </div>
            
            <!--- separa coluna --->
            
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>
                <input type="text" class="form-control" id="edit_ope_<?php echo $modal_item ?>" name="edit_ope_<?php echo $modal_item ?>" placeholder="Operador" value="">
              </div>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>
                <input type="text" class="form-control" id="edit_ger_<?php echo $modal_item ?>" name="edit_ger_<?php echo $modal_item ?>" placeholder="Gerente" value="">
              </div>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Comision Gerente') ?></label>
                <input type="text" class="form-control" id="edit_comGer_<?php echo $modal_item ?>" name="edit_comGer_<?php echo $modal_item ?>" placeholder="Comision Gerente" value="">
              </div>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Comision Operador') ?></label>
                <input type="text" class="form-control" id="edit_comOpe_<?php echo $modal_item ?>" name="edit_comOpe_<?php echo $modal_item ?>" placeholder="Comision Operador" value="">
              </div>              
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Direccion') ?></label>
                <input type="text" class="form-control" id="edit_end_<?php echo $modal_item ?>" name="edit_end_<?php echo $modal_item ?>" placeholder="Direccion" value="">
              </div>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Responsable') ?></label>
                <input type="text" class="form-control" id="edit_resp_<?php echo $modal_item ?>" name="edit_resp_<?php echo $modal_item ?>" placeholder="Responsable" value="">
              </div>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Contacto') ?></label>
                <input type="text" class="form-control" id="edit_cont_<?php echo $modal_item ?>" name="edit_cont_<?php echo $modal_item ?>" placeholder="Contacto" value="">
              </div>  
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Status') ?></label>
                <input type="text" class="form-control" id="edit_status_<?php echo $modal_item ?>" name="edit_status_<?php echo $modal_item ?>" placeholder="Status" value="">
              </div>                                 
                                        
            </div>
          </div>
          <div class="row form-group">
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Guardar ') . $modal_item ?></button>
          </div>
        </form>
      </div>

    </div>
  </div>
</div>