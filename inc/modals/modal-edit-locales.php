<?php $modal_item = "Local" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>es" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-pencil"></i> <?php echo _('Editar Local ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" method="post" action="">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('ID Local') ?></label>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('ID Local') ?></label>
                <input type="text" class="form-control" id="id_<?php echo $modal_item ?>" name="id_<?php echo $modal_item ?>" placeholder="ID Local" value="" disabled="disabled">
                <input type="hidden" id="edit_id_<?php echo $modal_item ?>" name="edit_id_<?php echo $modal_item ?>" value="" />
              </div>
              
              
              
              
              
              

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
              <label for="input_edit_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Ciudad') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="edit_cidade_<?php echo $modal_item ?>" name="edit_cidade_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//
					while($res_cidade=@mysql_fetch_assoc($query_cidade)) 
					{
						echo "<option value='".$res_cidade['nome_cidade']."'>".$res_cidade['nome_cidade']."</option>";
					}
				?>                 

                </select>
                <input type="hidden" id="hd_edit_cidade_<?php echo $modal_item ?>" name="hd_edit_cidade_<?php echo $modal_item ?>" value="" />
                <span class="material-input"></span>
              </div>               
              
              
              
              
              
              
              <!---
              <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Ciudad') ?></label>        
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Ciudad') ?></label>
                <input type="text" class="form-control" id="edit_cidade_<?php echo $modal_item ?>" name="edit_cidade_<?php echo $modal_item ?>" placeholder="Ciudad" value="">
              </div>-->
              
  
              
              
              
              
              
              
              <?php
			  	//monsta lista de operadores
				$sql_tpLoc = "
					SELECT
						id_tp_local,
						tp_local
					FROM
						tipo_local
					ORDER BY
						tp_local";	
				
				
				$query_tpLoc=@mysql_query($sql_tpLoc);				
			  ?>              
                    
                        
            
            
              <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo Local') ?></label>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo Local') ?></label>
                <input type="hidden" id="edit_tipo_<?php echo $modal_item ?>" name="edit_tipo_<?php echo $modal_item ?>" value="" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_tipo_<?php echo $modal_item ?>" name="select_tipo_<?php echo $modal_item ?>" class="btn dropdown-btn"><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
					<?php
                        //
                        while($res_tpLoc=@mysql_fetch_assoc($query_tpLoc)) 
                        {
                            echo "<li>";
                            echo "<a href='#' id='tipo_".$res_tpLoc['id_tp_local']."' class='mass-act' onClick='atribuiValor(this);'>". $res_tpLoc['tp_local'] ."</a>";
                            echo "</li>";
							echo "<li class='divider'></li>";
                        }
                    ?>
                </ul>
              </div>               
              
              
              
              
              
              
              <!---
              <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo Local') ?></label>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Tipo Local') ?></label>
                <input type="text" class="form-control" id="edit_tipo_<?php echo $modal_item ?>" name="edit_tipo_<?php echo $modal_item ?>" placeholder="Tipo Local" value="">
              </div>-->
              
              
              
              
              
              
              <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Razón Social') ?></label>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Razón Social') ?></label>
                <input type="text" class="form-control" id="edit_rs_<?php echo $modal_item ?>" name="edit_rs_<?php echo $modal_item ?>" placeholder="Razón Social" value="">
              </div>
              <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Porcentaje Local') ?></label>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Porcentaje Local') ?></label>
                <input type="text" class="form-control" id="edit_pct_<?php echo $modal_item ?>" name="edit_pct_<?php echo $modal_item ?>" placeholder="Porcentaje Local" value="">
              </div>
              <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre Local') ?></label>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Nombre Local') ?></label>
                <input type="text" class="form-control" id="edit_nome_<?php echo $modal_item ?>" name="edit_nome_<?php echo $modal_item ?>" placeholder="Nombre Local" value="">
              </div>
              <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Rut') ?></label>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Rut') ?></label>
                <input type="text" class="form-control" id="edit_rut_<?php echo $modal_item ?>" name="edit_rut_<?php echo $modal_item ?>" placeholder="Rut" value="">
              </div>
              <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Inclusion') ?></label>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Inclusion') ?></label>
                <input type="text" class="form-control" id="edit_incluido_<?php echo $modal_item ?>" name="edit_incluido_<?php echo $modal_item ?>" placeholder="Inclusion" value="">
              </div>
              <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Orden') ?></label>
              <div class="row form-group">
                <label for="input_nombre<?php echo $modal_item ?>" class="control-label"><?php echo _('Orden') ?></label>
                <input type="text" class="form-control" id="edit_orden_<?php echo $modal_item ?>" name="edit_orden_<?php echo $modal_item ?>" placeholder="Orden" value="">
              </div>                            
                                     
            </div>
            
            <!--- separa coluna -->
            
            <div class="col-xs-12 col-md-6">
            
            
            
            
            
            
              <?php
			  	//monsta lista de operadores
				$sql_ope = "
					SELECT
						id_login,
						nome
					FROM
						logins
					WHERE
						excluido = 'N'
					AND
						id_nivel = 8
					ORDER BY
						nome";	
				
				
				$query_ope=@mysql_query($sql_ope);				
			  ?>              
            
            
            
              <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>
                <input type="hidden" id="edit_ope_<?php echo $modal_item ?>" name="edit_ope_<?php echo $modal_item ?>" value="" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_ope_<?php echo $modal_item ?>" name="select_ope_<?php echo $modal_item ?>" class="btn dropdown-btn"><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
					<?php
                        //
                        while($res_ope=@mysql_fetch_assoc($query_ope)) 
                        {
                            echo "<li>";
                            echo "<a href='#' id='ope_".$res_ope['id_login']."' class='mass-act' onClick='atribuiValor(this);'>". $res_ope['nome'] ."</a>";
                            echo "</li>";
							echo "<li class='divider'></li>";
                        }
                    ?>
                </ul>
              </div>            
            
            
            
            
            
            
            
            
             <!--    
              <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>
                <input type="text" class="form-control" id="edit_ope_<?php echo $modal_item ?>" name="edit_ope_<?php echo $modal_item ?>" placeholder="Operador" value="">
              </div>-->
              
              
              
              
            
                
              <?php
			  	//monsta lista de operadores
				$sql_ger = "
					SELECT
						id_login,
						nome
					FROM
						logins
					WHERE
						excluido = 'N'
					AND
						id_nivel = 8
					ORDER BY
						nome";	
				
				
				$query_ger=@mysql_query($sql_ger);				
			  ?>              
                        
            
            
              <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>
                <input type="hidden" id="edit_ger_<?php echo $modal_item ?>" name="edit_ger_<?php echo $modal_item ?>" value="" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_ger_<?php echo $modal_item ?>" name="select_ger_<?php echo $modal_item ?>" class="btn dropdown-btn"><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
					<?php
						echo "<li>";
						echo "<a href='#' id='ger_0' class='mass-act' onClick='atribuiValor(this);'>Ninguno</a>";
						echo "</li>";
						echo "<li class='divider'></li>";					
                        //
                        while($res_ger=@mysql_fetch_assoc($query_ger)) 
                        {
                            echo "<li>";
                            echo "<a href='#' id='ger_".$res_ger['id_login']."' class='mass-act' onClick='atribuiValor(this);'>". $res_ger['nome'] ."</a>";
                            echo "</li>";
							echo "<li class='divider'></li>";
                        }
                    ?>
                </ul>
              </div>                
            
            
                
              <?php
			  	//monsta lista de operadores
				$sql_admin = "
					SELECT
						id_login,
						nome
					FROM
						logins
					WHERE
						excluido = 'N'
					AND
						id_nivel = 9
					ORDER BY
						nome";	
				
				
				$query_admin=@mysql_query($sql_admin);				
			  ?>              
                        
            
            
              <label for="input_admin<?php echo $modal_item ?>" class="control-label"><?php echo _('Administrador') ?></label>
              <div class="row form-group">
                <label for="input_admin<?php echo $modal_item ?>" class="control-label"><?php echo _('Administrador') ?></label>
                <input type="hidden" id="edit_admin_<?php echo $modal_item ?>" name="edit_admin_<?php echo $modal_item ?>" value="" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_admin_<?php echo $modal_item ?>" name="select_admin_<?php echo $modal_item ?>" class="btn dropdown-btn"><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
					<?php
					
						echo "<li>";
						echo "<a href='#' id='admin_0' class='mass-act' onClick='atribuiValor(this);'>Ninguno</a>";
						echo "</li>";
						echo "<li class='divider'></li>";					
					
                        //
                        while($res_admin=@mysql_fetch_assoc($query_admin)) 
                        {
                            echo "<li>";
                            echo "<a href='#' id='admin_".$res_admin['id_login']."' class='mass-act' onClick='atribuiValor(this);'>". $res_admin['nome'] ."</a>";
                            echo "</li>";
							echo "<li class='divider'></li>";
                        }
                    ?>
                </ul>
              </div>            
              
              
                
              <!--  
              
              <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Gerente') ?></label>
                <input type="text" class="form-control" id="edit_ger_<?php echo $modal_item ?>" name="edit_ger_<?php echo $modal_item ?>" placeholder="Gerente" value="">
              </div>-->
              
              
              
              
              <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión Gerente') ?></label>
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión Gerente') ?></label>
                <input type="text" class="form-control" id="edit_comGer_<?php echo $modal_item ?>" name="edit_comGer_<?php echo $modal_item ?>" placeholder="Comision Gerente" value="">
              </div>
              <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión Operador') ?></label>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Comisión Operador') ?></label>
                <input type="text" class="form-control" id="edit_comOpe_<?php echo $modal_item ?>" name="edit_comOpe_<?php echo $modal_item ?>" placeholder="Comision Operador" value="">
              </div> 
              <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Dirección') ?></label>            
              <div class="row form-group">
                <label for="input_operador<?php echo $modal_item ?>" class="control-label"><?php echo _('Dirección') ?></label>
                <input type="text" class="form-control" id="edit_end_<?php echo $modal_item ?>" name="edit_end_<?php echo $modal_item ?>" placeholder="Direccion" value="">
              </div>
              <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Responsable') ?></label>
              <div class="row form-group">
                <label for="input_gerente<?php echo $modal_item ?>" class="control-label"><?php echo _('Responsable') ?></label>
                <input type="text" class="form-control" id="edit_resp_<?php echo $modal_item ?>" name="edit_resp_<?php echo $modal_item ?>" placeholder="Responsable" value="">
              </div>
              <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Contacto') ?></label>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Contacto') ?></label>
                <input type="text" class="form-control" id="edit_cont_<?php echo $modal_item ?>" name="edit_cont_<?php echo $modal_item ?>" placeholder="Contacto" value="">
              </div> 
              
              
              
              
              
              <label for="input_status<?php echo $modal_item ?>" class="control-label"><?php echo _('Estatus') ?></label>
              <div class="row form-group">
                <label for="input_status<?php echo $modal_item ?>" class="control-label"><?php echo _('Estatus') ?></label>
                <input type="hidden" id="edit_status_<?php echo $modal_item ?>" name="edit_status_<?php echo $modal_item ?>" value="" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_status_<?php echo $modal_item ?>" name="select_status_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo $status ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                  <li>
                    <a id="status_s" href="#" class="mass-act" onClick='atribuiValor(this);'><?php echo _('Activo') ?></a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a id="status_n" href="#" class="mass-act" onClick='atribuiValor(this);'><?php echo _('Inactivo') ?></a>
                  </li>
                  <li class="divider"></li>
                </ul>
              </div>              
              
              
              
              
              <!---
              <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Status') ?></label>
              <div class="row form-group">
                <label for="input_tipo<?php echo $modal_item ?>" class="control-label"><?php echo _('Status') ?></label>
                <input type="text" class="form-control" id="edit_status_<?php echo $modal_item ?>" name="edit_status_<?php echo $modal_item ?>" placeholder="Status" value="">
              </div> 
              -->                               
                                        
            </div>
          </div>
          <div class="row form-group">
            <a id="btnEditLocal" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                <?php echo _('Guardar ') . $modal_item ?>
            </a>             
            
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script>
	$('select').select2();

	//
	function atribuiValor(obj)
	{
		//
		var tpCombo = obj.id.split("_");
		tpCombo = tpCombo[0];

		
		$('#select_'+tpCombo+'_Local').text(obj.text);
		$('#edit_'+tpCombo+'_Local').attr("value", obj.text);	
	}
	
	$('#btnEditLocal').click(function()
	{
		var idLocal = $('#edit_id_Local').val();
		var cidade = $('#edit_cidade_Local').val();
		var tpLocal = $('#edit_tipo_Local').val();
		var razaoSocial = $('#edit_rs_Local').val();
		var pctLocal = $('#edit_pct_Local').val();
		var nomeLocal = $('#edit_nome_Local').val();
		var rut = $('#edit_rut_Local').val();
		var inclusao = $('#edit_incluido_Local').val();
		var ordem = $('#edit_orden_Local').val();
		var operador = $('#edit_ope_Local').val();
		var gerente = $('#edit_ger_Local').val();
		var comGer = $('#edit_comGer_Local').val();
		var comope = $('#edit_comOpe_Local').val();
		var endereco = $('#edit_end_Local').val();
		var responsavel = $('#edit_resp_Local').val();
		var contato = $('#edit_cont_Local').val();
		var status = $('#edit_status_Local').val();	
		var admin = $('#edit_admin_Local').val();									
		
		/*
		alert(idLocal);
		alert(cidade);
		alert(tpLocal);
		alert(razaoSocial);
		alert(pctLocal);
		alert(nomeLocal);
		alert(rut);
		alert(inclusao);
		alert(ordem);
		alert(operador);
		alert(gerente);
		alert(comGer);
		alert(comope);
		alert(endereco);
		alert(responsavel);
		alert(contato);
		alert(status);		*/	


		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraLocal.php', // Informo a URL que será pesquisada.
			data: 'edit_id_Local='+idLocal+'&edit_cidade_Local='+cidade+'&edit_tipo_Local='+tpLocal+'&edit_rs_Local='+razaoSocial+'&edit_pct_Local='+pctLocal+'&edit_nome_Local='+nomeLocal+'&edit_rut_Local='+rut+'&edit_incluido_Local='+inclusao+'&edit_orden_Local='+ordem+'&edit_ope_Local='+operador+'&edit_ger_Local='+gerente+'&edit_admin_Local='+admin+'&edit_comGer_Local='+comGer+'&edit_comOpe_Local='+comope+'&edit_end_Local='+endereco+'&edit_resp_Local='+responsavel+'&edit_cont_Local='+contato+'&edit_status_Local='+status,
			success: function(html)
			{
				if(html == true)
				{
					$('#edit-modal-Locales').fadeOut("slow");
					$('#msgConfirm').text('Registro alterado con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#edit-modal-Locales').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para alterar el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}	
			}

		});
	});	
</script>