<?php $modal_item = "Local" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>es" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-plus"></i> <?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos del nuevo local.</p>
        <form class="form-horizontal" method="post" action="">
          <div class="row">
            <div class="col-xs-12 col-md-6">
            
            

              <?php
			  	//monsta lista de cidades
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
			  ?>
              <label for="input_add_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Ciudad') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="hd_cidade_<?php echo $modal_item ?>" name="hd_cidade_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//
					while($res_cidade=@mysql_fetch_assoc($query_cidade)) 
					{
						echo "<option value='".$res_cidade['nome_cidade']."'>".$res_cidade['nome_cidade']."</option>";
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>  
            
            





              <?php
			  	//monsta lista de cidades
				$sql_tipo_local = "
					SELECT
						*
					FROM
						tipo_local
					ORDER BY
						tp_local
					";	
				
				
				$query_tipo_local=@mysql_query($sql_tipo_local);			
			  ?>
              <label for="input_add_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo Local') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="hd_tp_<?php echo $modal_item ?>" name="hd_tp_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//
					while($res_tipo_local=@mysql_fetch_assoc($query_tipo_local)) 
					{
						echo "<option value='".$res_tipo_local['tp_local']."'>".$res_tipo_local['tp_local']."</option>";
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div> 




              
			  <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión Operador') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_comOpe_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Comisión Operador') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_comOpe_<?php echo $modal_item ?>" name="hd_comOpe_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                          <li>
                            <a href="#" id="comOpe_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('0') ?></a>
                          </li> 
                          <li class='divider'></li>
                          <li>
                            <a href="#" id="comOpe_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('5') ?></a>
                          </li>
                          <li class='divider'></li>  
                          <li>
                            <a href="#" id="comOpe_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('6') ?></a>
                          </li>
                          <li class='divider'></li>  
                          <li>
                            <a href="#" id="comOpe_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('10') ?></a>
                          </li>
                          <li class='divider'></li>                
                </ul>
              </div>             
              
			  <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Porcentual Local') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_pct_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Porcentual Local') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_pct_<?php echo $modal_item ?>" name="hd_pct_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                          <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('50') ?></a>
                          </li>
                          <li class='divider'></li>  
                          <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('60') ?></a>
                          </li>
                          <li class='divider'></li>    
                          <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('70') ?></a>
                          </li>
                          <li class='divider'></li>    
                          <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('80') ?></a>
                          </li>    
                          <li class='divider'></li>                          
                          <li>
                            <a href="#" id="pct_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('90') ?></a>
                          </li>
                          <li class='divider'></li>                                                                   


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
            
            
            
              <?php
			  	//monsta lista de ope
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
			  ?>
              <label for="input_add_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="hd_operador_<?php echo $modal_item ?>" name="hd_operador_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//
					while($res_ope=@mysql_fetch_assoc($query_ope)) 
					{
						echo "<option value='".$res_ope['nome']."'>".$res_ope['nome']."</option>";
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>             
            
            
            

              
              
              
              <?php
			  	//monsta lista de ope
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
			  ?>
              <label for="input_add_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="hd_gerente_<?php echo $modal_item ?>" name="hd_gerente_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//em branco
					echo "<option value=''>&nbsp;</option>";
					
					//
					while($res_ger=@mysql_fetch_assoc($query_ger)) 
					{
						echo "<option value='".$res_ger['nome']."'>".$res_ger['nome']."</option>";
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>               
              
              
              
              <?php
			  	//monsta lista de ope
					$sql_ger = "
						SELECT
							*
						FROM
							logins
						WHERE
							excluido = 'N'
						AND
							id_nivel = 9
						ORDER BY
							nome
						";	
					
					
					$query_ger=@mysql_query($sql_ger);		
			  ?>
              <label for="input_add_admin<?php echo $modal_item ?>" class="control-label"><?php echo _('Administrador') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="hd_admin_<?php echo $modal_item ?>" name="hd_admin_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//em branco
					echo "<option value=''>&nbsp;</option>";
				
					//
					while($res_ger=@mysql_fetch_assoc($query_ger)) 
					{
						echo "<option value='".$res_ger['nome']."'>".$res_ger['nome']."</option>";
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>                            
              

              
              
 
			  <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión Gerente') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_comGer_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Comisión Gerente') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_comGer_<?php echo $modal_item ?>" name="hd_comGer_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                          <li>
                            <a href="#" id="comGer_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('0') ?></a>
                          </li>
                          <li class='divider'></li>
                          <li>
                            <a href="#" id="comGer_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('5') ?></a>
                          </li>
                          <li class='divider'></li>  
                          <li>
                            <a href="#" id="comGer_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('6') ?></a>
                          </li>
                          <li class='divider'></li>  
                          <li>
                            <a href="#" id="comGer_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);" class="mass-act"><?php echo _('10') ?></a>
                          </li>
                          <li class='divider'></li>                                                                                              

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
                <a id="btnAddLocal" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                    <?php echo _('Crear Nuevo ') . $modal_item ?>
                </a>              
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
	
	$('select').select2();

	//
	function atribuiValorIns(obj)
	{
		$('#input_'+obj.id).text(obj.text);
		$('#hd_'+obj.id).attr("value", obj.text);	
	}
	
	//
	$('#btnAddLocal').click(function()
	{
		var cidade = $('#hd_cidade_Local').val();
		var operador = $('#hd_operador_Local').val();
		var tipo = $('#hd_tp_Local').val();
		var gerente = $('#hd_gerente_Local').val();
		var admin = $('#hd_admin_Local').val();
		var comOpe = $('#hd_comOpe_Local').val();
		var comGer = $('#hd_comGer_Local').val();
		var pctLocal = $('#hd_pct_Local').val();
		var rSocial = $('#input_rSocial_Local').val();
		var nomeLocal = $('#input_nome_Local').val();
		var endereco = $('#input_endereco_Local').val();
		var rut = $('#input_rut_Local').val();
		var responsavel = $('#input_resp_Local').val();		
		var contato = $('#input_contacto_Local').val();		


		// 
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/addLocal.php', // Informo a URL que será pesquisada.
			data: 'hd_cidade_Local='+cidade+'&hd_operador_Local='+operador+'&hd_tp_Local='+tipo+'&hd_gerente_Local='+gerente+'&hd_admin_Local='+admin+'&hd_comOpe_Local='+comOpe+'&hd_comGer_Local='+comGer+'&hd_pct_Local='+pctLocal+'&input_rSocial_Local='+rSocial+'&input_nome_Local='+nomeLocal+'&input_endereco_Local='+endereco+'&input_rut_Local='+rut+'&input_resp_Local='+responsavel+'&input_contacto_Local='+contato,
			success: function(html)
			{
				if(html == true)
				{
					$('#add-modal-Locales').fadeOut("slow");
					$('#msgConfirm').text('Registro Inserido con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#add-modal-Locales').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para inserir el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}				
			}

		});
	});	
	
</script>