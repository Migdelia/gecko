<div id="massaction-modal" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Estas seguro que quiere ejecutar esta acción?') ?></h5>
      </div>
      <div class="modal-body">
        <p>
        	<strong><span id="tpAcao">- Crear Lectura</span></strong>
            <br />


          <div id="div_combo_nivel" class="row form-group" style="display:none;">
            <label for="input_nivel<?php echo $modal_item ?>" class="control-label"><?php echo _('Nivel de ') . $modal_item ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_nivel_massivo_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Nivel de ') . $modal_item ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                    <span class="caret"></span>
                    <div class="ripple-container"></div>
                 </a>
            <ul class="dropdown-menu">
            <?php 
                //consulta nome dos usuarios
                if($_SESSION['usr_nivel'] == 1)
                {
                    //consulta niveis do usuario
                    $sql_nivel = "
                        SELECT
                            descricao,
                            id_nivel
                        FROM
                            nivel
                        WHERE
                            excluido = 'N'
                        ORDER BY
                            descricao
                        ";						
                }
                else 
                {
                    $sql_nivel = "
                        SELECT
                            descricao,
                            id_nivel
                        FROM
                            nivel
                        WHERE
                            excluido = 'N'
                        AND
                            id_nivel = 8
                        ORDER BY
                            descricao
                        ";							
                }
                    
                $query_nivel=@mysql_query($sql_nivel);
                
                //mostra todos usuarios
                while($res_nivel=@mysql_fetch_assoc($query_nivel)) 
                {						
            ?>
                  <li>
                    <a href="#" class="mass-act" id="nivel_<?php echo _( $res_nivel['id_nivel'] ) ?>" onclick="atribuiNivelMassivo(this);"><?php echo _( $res_nivel['descricao'] ) ?></a>
                  </li>
            <?php
                }
            ?>
            </ul>
          </div>            
            

            
            
            <p>
            	<span id="cont_acao"></span>
            </p>
        </p>
        <div class="row form-group">
          <div class="col-xs-12">
            <button id="confAcao" type="submit" class="btn send btn-sm btn-raised col-xs-12 col-md-4 right"><?php echo _('Confirmar') ?></button>
            <button type="button" data-dismiss="modal" aria-hidden="true" class="btn btn-sm btn-raised col-xs-12 col-md-4 right"><?php echo _('Cancelar') ?></button>  
            
          </div>
          
        </div>
      </div>
    </div>
  </div>
</div>
