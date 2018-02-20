<?php $modal_item = "Local" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>es" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos del nuevo local.</p>
        <form class="form-horizontal" method="post" action="functions/addLocal.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Ciudad') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_cidade_<?php echo $modal_item ?>" name="input_cidade_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Ciudad') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_cidade_<?php echo $modal_item ?>" name="hd_cidade_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                
                <?php
					//consulta cidades
					$sql_cidade = "
						SELECT
							*
						FROM
							regiao
						WHERE
							excluido = 'N'
						ORDER BY
							nome_cidade
						";	
					
					
					$query_cidade=@mysql_query($sql_cidade);
					
					//
					while($res_cidades=@mysql_fetch_assoc($query_cidade)) 
					{
				?>
                          <li>
                            <a href="#" class="mass-act" id="cidade_<?php echo $modal_item ?>" onclick="atribuiValor(this);"><?php echo _($res_cidades['nome_cidade']) ?></a>
                          </li>                
                <?php
					}								
				?>
                

                </ul>
              </div>
			  <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo Local') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_tp_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Tipo Local') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_tp_<?php echo $modal_item ?>" name="hd_tp_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                
                <?php
					//consulta cidades
					$sql_tipo_local = "
						SELECT
							*
						FROM
							tipo_local
						ORDER BY
							tp_local
						";	
					
					
					$query_tipo_local=@mysql_query($sql_tipo_local);
					
					//
					while($res_tipo_local=@mysql_fetch_assoc($query_tipo_local)) 
					{
				?>
                          <li>
                            <a href="#" id="tp_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _($res_tipo_local['tp_local']) ?></a>
                          </li>                
                <?php
					}								
				?>
                

                </ul>
              </div>
              
			  <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión Operador') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_comOpe_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Comisión Operador') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_comOpe_<?php echo $modal_item ?>" name="hd_comOpe_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                          <li>
                            <a href="#" id="comOpe_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('0') ?></a>
                          </li>  
                          <li>
                            <a href="#" id="comOpe_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('5') ?></a>
                          </li>  
                          <li>
                            <a href="#" id="comOpe_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('6') ?></a>
                          </li>  
                          <li>
                            <a href="#" id="comOpe_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('10') ?></a>
                          </li>                


                </ul>
              </div>             
              
			  <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Porcentual Local') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_pct_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Porcentual Local') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_pct_<?php echo $modal_item ?>" name="hd_pct_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                          <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('50') ?></a>
                          </li>  
                          <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('60') ?></a>
                          </li>    
                          <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('70') ?></a>
                          </li>    
                                                    <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('80') ?></a>
                          </li>    
                                                    <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('90') ?></a>
                          </li>                                                                   


                </ul>
              </div>              
                   
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre Local') ?></label>
                <input type="text" class="form-control" id="input_nome_<?php echo $modal_item ?>" name="input_nome_<?php echo $modal_item ?>" placeholder="<?php echo _('Nombre Local') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Rut') ?></label>
                <input type="text" class="form-control" id="input_rut_<?php echo $modal_item ?>" name="input_rut_<?php echo $modal_item ?>" placeholder="<?php echo _('Rut') ?>" value="">
              </div>              
              <div class="row form-group">
                <label for="input_gcomision<?php echo $modal_item ?>" class="control-label"><?php echo _('Contacto') ?></label>
                <input type="text" class="form-control" id="input_contacto_<?php echo $modal_item ?>" name="input_contacto_<?php echo $modal_item ?>" placeholder="<?php echo _('Contacto') ?>" value="">
              </div>                                                      
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre Operador') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_operador_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Nombre Operador') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_operador_<?php echo $modal_item ?>" name="hd_operador_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                <?php
					//consulta cidades
					$sql_ope = "
						SELECT
							*
						FROM
							logins
						WHERE
							excluido = 'N'
						AND
							id_nivel = 8
						ORDER BY
							nome
						";	
					
					
					$query_ope=@mysql_query($sql_ope);
					
					//
					while($res_ope=@mysql_fetch_assoc($query_ope)) 
					{
				?>
                          <li>
                            <a href="#" id="operador_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _($res_ope['nome']) ?></a>
                          </li>                
                <?php
					}								
				?>
                </ul>
              </div>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_gerente_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Gerente') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_gerente_<?php echo $modal_item ?>" name="hd_gerente_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                <?php
					//consulta cidades
					$sql_ger = "
						SELECT
							*
						FROM
							logins
						WHERE
							excluido = 'N'
						AND
							id_nivel = 8
						ORDER BY
							nome
						";	
					
					
					$query_ger=@mysql_query($sql_ger);
					
					//
					while($res_ger=@mysql_fetch_assoc($query_ger)) 
					{
				?>
                          <li>
                            <a href="#" id="gerente_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _($res_ger['nome']) ?></a>
                          </li>                
                <?php
					}								
				?>
                </ul>
              </div> 
			  <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión Gerente') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_comGer_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Comisión Gerente') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_comGer_<?php echo $modal_item ?>" name="hd_comGer_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                          <li>
                            <a href="#" id="comGer_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('0') ?></a>
                          </li>  
                          <li>
                            <a href="#" id="comGer_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('5') ?></a>
                          </li>  
                          <li>
                            <a href="#" id="comGer_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('6') ?></a>
                          </li>  
                          <li>
                            <a href="#" id="comGer_<?php echo $modal_item ?>" onclick="atribuiValor(this);" class="mass-act"><?php echo _('10') ?></a>
                          </li>                                                                                              


                </ul>
              </div>             
              <div class="row form-group">
                <label for="input_pctelocal<?php echo $modal_item ?>" class="control-label"><?php echo _('Razon Social') ?></label>
                <input type="text" class="form-control" id="input_rSocial_<?php echo $modal_item ?>" name="input_rSocial_<?php echo $modal_item ?>" placeholder="<?php echo _('Razon Social') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_ocomision<?php echo $modal_item ?>" class="control-label"><?php echo _('Direccion') ?></label>
                <input type="text" class="form-control" id="input_endereco_<?php echo $modal_item ?>" name="input_endereco_<?php echo $modal_item ?>" placeholder="<?php echo _('Direccion	') ?>" value="">
              </div>
              <div class="row form-group">
                <label for="input_pctual<?php echo $modal_item ?>" class="control-label"><?php echo _('Responsable') ?></label>
                <input type="text" class="form-control" id="input_resp_<?php echo $modal_item ?>" name="input_resp_<?php echo $modal_item ?>" placeholder="<?php echo _('Responsable') ?>" value="">
              </div>  
              
              
           
                           
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Crear Nuevo ') . $modal_item ?></button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
	//
	function atribuiValor(obj)
	{
		$('#input_'+obj.id).text(obj.text);
		$('#hd_'+obj.id).attr("value", obj.text);	
	}
	
</script>