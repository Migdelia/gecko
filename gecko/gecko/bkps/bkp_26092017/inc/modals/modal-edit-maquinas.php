<?php 

// ingresar la palabra clave de cada modal
$modal_item = "Maquina";
 
?>
<div id="edit-modal-Maquinas" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
      </div>
      <div class="modal-body">
      <p><strong>Detalles</strong></p>

        
        <form class="form-horizontal" method="post" action="" target="_parent">
          <input type="hidden" id="id_maquina" name="id_maquina" value="0" >
          <div class="row">
            <div class="col-xs-6 col-md-6">
              <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Número de máquina') ?></label>
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Número de máquina') ?></label>
                <input type="text" class="form-control" id="input_num_<?php echo $modal_item ?>" name="input_num_<?php echo $modal_item ?>" placeholder="<?php echo _('Número de máquina') ?>" value="<?php echo $res_maq['numero'] ?>" readonly>
              </div>
              
              <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo Maquina') ?></label>
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo Maquina') ?></label>
                <input type="text" class="form-control" id="input_cod_<?php echo $modal_item ?>" name="input_cod_<?php echo $modal_item ?>" placeholder="<?php echo _('Codigo Maquina') ?>" value="<?php echo $res_maq['codigo'] ?>" readonly>
              </div>
              
              <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Jogo') ?></label>
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Jogo') ?></label>
                <input type="text" class="form-control" id="input_jogo_<?php echo $modal_item ?>" name="input_jogo_<?php echo $modal_item ?>" placeholder="<?php echo _('Jogo') ?>" value="<?php echo $res_maq['jogo'] ?>" readonly>
              </div>  
              
              
              <?php
			  	//monsta lista de locais
				$sql_loc = "
					SELECT
						id_local,
						nome
					FROM
						`local`
					WHERE
						excluido = 'N'
					ORDER BY
						nome";	
				
				
				$query_loc=@mysql_query($sql_loc);			
			  ?>
              <label for="input_mod<?php echo $modal_item ?>" class="control-label"><?php echo _('Local') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="input_local_<?php echo $modal_item ?>" name="input_local_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//
					while($res_loc=@mysql_fetch_assoc($query_loc)) 
					{
						echo "<option value='".$res_loc['nome']."'>".$res_loc['nome']."</option>";
					}
				?>                 

                </select>
                <input type="hidden" id="hd_input_local_<?php echo $modal_item ?>" name="hd_input_local_<?php echo $modal_item ?>" value="" />
                <span class="material-input"></span>
              </div>              
              
                
              
              <?php
			  	//
				if($res_maq['excluido'] == 'N')
				{
					$status = "Activo";
				}
				else
				{
					$status = "Inactivo";
				}
			  ?> 
              <br />             
              <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo _('Status') ?></label>
              <div class="row form-group">
                <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo _('Status') ?></label>
                <input type="hidden" id="input_status_<?php echo $modal_item ?>" name="input_status_<?php echo $modal_item ?>" value="" >
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
              
              
              <label for="input_obsm<?php echo $modal_item ?>" class="control-label"><?php echo _('Ordem Leitura') ?></label>
              <div class="row form-group">
                <label for="input_obsm<?php echo $modal_item ?>" class="control-label"><?php echo _('Ordem Leitura') ?></label>
                <input type="text" class="form-control" id="input_ordem_<?php echo $modal_item ?>" name="input_ordem_<?php echo $modal_item ?>" placeholder="<?php echo _('Ordem Leitura') ?>" value="<?php echo $res_maq['ordem_leitura'] ?>">
              </div>               
              
              
              
              <?php
			  	//monsta lista de dispositivos de seguranca
				$sql_disp = "
					SELECT
						id_interface,
						numero,
						id_maquina
					FROM
						interface
					WHERE
						excluido = 'N'
					ORDER BY
						numero";	
				
				
				$query_disp=@mysql_query($sql_disp);				
			  ?>              
              
              
              <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo _('Disp de Seguridad') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="input_disp_<?php echo $modal_item ?>" name="input_disp_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <option value=''>&nbsp;</option>
                <?php
					//
					while($res_disp=@mysql_fetch_assoc($query_disp)) 
					{
						if($res_disp['id_maquina'] == 0)
						{
							echo "<option value='".$res_disp['numero']."'>".$res_disp['numero']."</option>";						
						}
						else
						{
							//consulta numero da maquina
							$sql_num_maq = "SELECT numero FROM maquinas WHERE id_maquina = " . $res_disp['id_maquina'];
							$query_num_maq=@mysql_query($sql_num_maq);
							$res_num_maq=@mysql_fetch_assoc($query_num_maq);
							
							
							echo "<option value='".$res_disp['numero']."' disabled>".$res_disp['numero']." - (Ocupada: Maq-".$res_num_maq['numero'].")</option>";													
						}
					}
				?>                 

                </select>
                <input type="hidden" id="hd_input_disp_<?php echo $modal_item ?>" name="hd_input_disp_<?php echo $modal_item ?>" value="" />
                <span class="material-input"></span>
              </div>                 

              
              <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Entrada Oficial') ?></label>             
              <div class="row form-group">
                <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Entrada Oficial') ?></label>
                <input type="text" class="form-control" id="input_entrada_<?php echo $modal_item ?>" name="input_entrada_<?php echo $modal_item ?>" placeholder="<?php echo _('Entrada Oficial') ?>" value="0">
              </div>
              
              <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Saida Oficial') ?></label>
              <div class="row form-group">
                <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Saida Oficial') ?></label>
                <input type="text" class="form-control" id="input_saida_<?php echo $modal_item ?>" name="input_saida_<?php echo $modal_item ?>" placeholder="<?php echo _('Saida Oficial') ?>" value="0">
              </div>                                                                          
            </div>
            <div class="col-xs-6 col-md-6">
              <div class="row form-group">
                <h6><?php echo _('Registros especiales') ?></h6>
              </div>
              
                          
              
              <div class="row form-group">
                <div class="checkbox">
                  <?php echo _('Maquina Parceiro');
				  	//
					if($res_maq['parceiro'] == 1)
					{
				  		echo "<label><input id='check_parce' name='check_parce' type='checkbox' checked><span class='checkbox-material'></span></label>";
					}
					else
					{
						echo "<label><input id='check_parce' name='check_parce' type='checkbox'><span class='checkbox-material'></span></label>";	
					}
				  ?>
                </div>
              </div>               
              
              <div class="row form-group">
                <div class="checkbox">
                  <?php echo _('Maquina Socio &nbsp; &nbsp;&nbsp;');
				  	//
					if($res_maq['maq_socio'] == "true")
					{
				  		echo "<label><input id='check_maquina_socio' name='check_maquina_socio' type='checkbox' checked><span class='checkbox-material'></span></label>";
					}
					else
					{
						echo "<label><input id='check_maquina_socio' name='check_maquina_socio' type='checkbox'><span class='checkbox-material'></span></label>";	
					}				  
				  ?>
                </div>
              </div>              
              
              <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Socio') ?></label>              
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Socio') ?></label>
                <input type="text" class="form-control" id="input_pctSocio_<?php echo $modal_item ?>" name="input_pctSocio_<?php echo $modal_item ?>" placeholder="<?php echo _('% Socio') ?>" value="<?php echo $res_maq['porc_socio'] ?>" >
              </div>
              
              <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Especial') ?></label>
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Especial') ?></label>
                <input type="text" class="form-control" id="input_pctEspecial_<?php echo $modal_item ?>" name="input_pctEspecial_<?php echo $modal_item ?>" placeholder="<?php echo _('% Especial') ?>" value="<?php echo $res_maq['porc_maquina'] ?>">
              </div>              
              
              <div class="row form-group">
                <h6><?php echo _('Perifericos') ?></h6>
              </div>


              <?php
			  	//monsta lista de gabinetes 
				$sql_lista_gab = "
					SELECT
						descricao
					FROM
						tipo_maquina
					";
				$query_lista_gab=@mysql_query($sql_lista_gab);			
			  ?>              
              <label for="input_gabinete<?php echo $modal_item ?>" class="control-label"><?php echo _('Gabinete') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="input_gab_<?php echo $modal_item ?>" name="input_gab_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//
					while($res_lista_gab=@mysql_fetch_assoc($query_lista_gab))  
					{
						echo "<option value='".$res_lista_gab['descricao']."'>".$res_lista_gab['descricao']."</option>";
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>    

              
              <?php
			  	//monsta lista de placas 
				$sql_lista_placa = "
					SELECT
						serie,
						id_maquina
					FROM
						placa_mae
						
					";
				$query_lista_placa=@mysql_query($sql_lista_placa);		
			  ?>              
              <label for="input_placa<?php echo $modal_item ?>" class="control-label"><?php echo _('Placa Madre') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="input_placa_<?php echo $modal_item ?>" name="input_placa_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <option value='Ninguno' selected>Ninguno</option>
                <?php
					//
					while($res_lista_placa=@mysql_fetch_assoc($query_lista_placa)) 
					{
						if($res_lista_placa['id_maquina'] == 0)
						{						
							echo "<option value='".$res_lista_placa['serie']."'>".$res_lista_placa['serie']."</option>";
						}
						else
						{
							echo "<option value='".$res_lista_placa['serie']."' disabled>".$res_lista_placa['serie']."</option>";
						}
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>               
              
              
              <?php
			  	//monsta lista de billeteros 
				$sql_lista_bil = "
					SELECT
						serie,
						id_maquina
					FROM
						bilheteiros
					";
				$query_lista_bil=@mysql_query($sql_lista_bil);	
			  ?>              
              <label for="input_bil<?php echo $modal_item ?>" class="control-label"><?php echo _('Billeteros') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="input_bil_<?php echo $modal_item ?>" name="input_bil_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <option value='Ninguno' selected>Ninguno</option>
                <?php
					//
					while($res_lista_bil=@mysql_fetch_assoc($query_lista_bil)) 
					{
						if($res_lista_bil['id_maquina'] == 0)
						{							
							echo "<option value='".$res_lista_bil['serie']."'>".$res_lista_bil['serie']."</option>";
						}
						else
						{
							echo "<option value='".$res_lista_bil['serie']."' disabled=>".$res_lista_bil['serie']."</option>";
						}
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>   
              
              
              <?php
			  	//monsta lista de pendrives 
				$sql_lista_pen = "
					SELECT
						serie,
						id_maquina
					FROM
						pendrives
					";
				$query_lista_pen=@mysql_query($sql_lista_pen);
			  ?>              
              <label for="input_pen<?php echo $modal_item ?>" class="control-label"><?php echo _('Pendrives') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="input_pen_<?php echo $modal_item ?>" name="input_pen_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <option value='Ninguno' selected>Ninguno</option>
                <?php
					//
					while($res_lista_pen=@mysql_fetch_assoc($query_lista_pen)) 
					{
						if($res_lista_pen['id_maquina'] == 0)
						{						
							echo "<option value='".$res_lista_pen['serie']."'>".$res_lista_pen['serie']."</option>";
						}
						else
						{
							echo "<option value='".$res_lista_pen['serie']."' disabled=>".$res_lista_pen['serie']."</option>";
						}
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>                          
             
              
              <?php
			  	//monsta lista de monitores 
				$sql_lista_mon = "
					SELECT
						serie,
						id_maquina
					FROM
						monitores
					";
				$query_lista_mon=@mysql_query($sql_lista_mon);
			  ?>              
              <label for="input_mon<?php echo $modal_item ?>" class="control-label"><?php echo _('Monitores') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="input_mon_<?php echo $modal_item ?>" name="input_mon_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <option value='Ninguno' selected>Ninguno</option>
                <?php
					//
					while($res_lista_mon=@mysql_fetch_assoc($query_lista_mon)) 
					{
						if($res_lista_mon['id_maquina'] == 0)
						{						
							echo "<option value='".$res_lista_mon['serie']."'>".$res_lista_mon['serie']."</option>";
						}
						else
						{
							echo "<option value='".$res_lista_mon['serie']."' disabled>".$res_lista_mon['serie']."</option>";
						}
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>

                               

              <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo "Chapas" ?></label>
              <div class="row form-group">
                <div class="checkbox">
                
                	<?php
						//consulta modelos de chapas
						$sqlChapas = "SELECT * FROM modelos_chapa";
						$queryChapa=@mysql_query($sqlChapas);
						
						//
						while($resChapa=@mysql_fetch_assoc($queryChapa))
						{
							echo "<label>";
							echo "<input id='check_chapa_".$resChapa['codigo']."' name='check_chapa_".$resChapa['codigo']."' type='checkbox'>";
							echo "<span class='checkbox-material'>".$resChapa['codigo']."</span>";
							echo "</label>";
						}
					?>                                      
                </div>
                
                <!---
                <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo "Chapas" ?></label>
                <input type="hidden" id="input_chapa_<?php echo $modal_item ?>" name="input_chapa_<?php echo $modal_item ?>" value="0" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_chapa_<?php echo $modal_item ?>" name="select_chapa_<?php echo $modal_item ?>" class="btn dropdown-btn">0<div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                
                <?php
                        $sql_lista_chapa = "
                            SELECT
                                id_chapa as serie
                            FROM
                                chapas
                            ";
                        $query_lista_chapa=@mysql_query($sql_lista_chapa);
                        
                        //
                        while($res_lista_chapa=@mysql_fetch_assoc($query_lista_chapa)) 
                        {
                            echo "<li>";
                            echo "<a id='chapa_".$res_lista_chapa['id_chapa']." href='#' class='mass-act' onclick='atribuiValor(this);'>".$res_lista_chapa['serie']."</a>";
                            echo "</li>";
                            echo "<li class='divider'></li>";			
                        }		
                        
                ?>      
                </ul>--->
              </div>                                                                       
            </div>
          </div>
          <div class="row form-group">
          	<div class="col-xs-10">
            	<label for="input_resp<?php echo $modal_item ?>" class="control-label"><?php echo _('Observacion maquina') ?></label>
            	<input type="text" class="form-control" id="input_obs_<?php echo $modal_item ?>" name="input_obs_<?php echo $modal_item ?>" placeholder="<?php echo _('Observacion maquina') ?>" value="<?php echo $res_maq['obs'] ?>">
            </div>
          </div>          
          
          <div class="row form-group">
            <div class="col-xs-6">
                <a id="btnEditMaquina" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                    <?php echo _('Guardar ') . $modal_item ?>
                </a>                 
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
		//
		var tpCombo = obj.id.split("_");
		tpCombo = tpCombo[0];
		
		$('#select_'+tpCombo+'_Maquina').text(obj.text);
		$('#input_'+tpCombo+'_Maquina').attr("value", obj.text);	
	}
	
	
	//
	$('select').select2();	
	
	//verificar se esta sendo enviado form
	$("form").submit(function(){
		//
		var dispSelecionado = $('#select2-input_disp_Maquina-container').text();
		$("#input_disp_Maquina option[value=" + dispSelecionado + "]").removeAttr('disabled');
		
		//
		var placaSelecionada = $('#select2-input_placa_Maquina-container').text();
		$("#input_placa_Maquina option[value=" + placaSelecionada + "]").removeAttr('disabled');
		
		//
		var bilSelecionado = $('#select2-input_bil_Maquina-container').text();
		$("#input_bil_Maquina option[value=" + bilSelecionado + "]").removeAttr('disabled');
		
		//
		var penSelecionado = $('#select2-input_pen_Maquina-container').text();
		$("#input_pen_Maquina option[value=" + penSelecionado + "]").removeAttr('disabled');
		
		//
		var monSelecionado = $('#select2-input_mon_Maquina-container').text();
		$("#input_mon_Maquina option[value=" + monSelecionado + "]").removeAttr('disabled');							
		
		
	});
	
	///
	$('#btnEditMaquina').click(function()
	{
		var idMaquina = $('#id_maquina').val();
		var numMaquina = $('#input_num_Maquina').val();
		var codMaquina = $('#input_cod_Maquina').val();
		var jogo = $('#input_jogo_Maquina').val();
		
		//var local = $('#input_local_Maquina option:selected').val();
		var local = $('#hd_input_local_Maquina').val();
		
		
		var statusMaq = $('#input_status_Maquina').val();
		
		
		
		//var dispSeg = $("#input_disp_Maquina option:selected").val();
		var dispSeg = $("#hd_input_disp_Maquina").val();
		
		
		var ordemLeit = $('#input_ordem_Maquina').val();
		var entrada = $('#input_entrada_Maquina').val();
		var saida = $('#input_saida_Maquina').val();
		var maqParce = $('#check_parce').prop("checked");
		var maqSocio = $('#check_maquina_socio').prop("checked");
		var pctSocio = $('#input_pctSocio_Maquina').val();
		var pctEspecial = $('#input_pctEspecial_Maquina').val();
		var obs = $('#input_obs_Maquina').val();
		var gabinete = $('#input_gab_Maquina option:selected').val();
		var placaM = $('#input_placa_Maquina option:selected').val();	
		var bil = $('#input_bil_Maquina option:selected').val();
		var pen = $('#input_pen_Maquina option:selected').val();
		var mon = $('#input_mon_Maquina option:selected').val();												
		
		

		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/alteraMaquina.php', // Informo a URL que será pesquisada.
			data: 'id_maquina='+idMaquina+'&input_num_Maquina='+numMaquina+'&input_cod_Maquina='+codMaquina+'&input_jogo_Maquina='+jogo+'&input_local_Maquina='+local+'&input_status_Maquina='+statusMaq+'&input_disp_Maquina='+dispSeg+'&input_ordem_Maquina='+ordemLeit+'&input_entrada_Maquina='+entrada+'&input_saida_Maquina='+saida+'&check_parce='+maqParce+'&check_maquina_socio='+maqSocio+'&input_pctSocio_Maquina='+pctSocio+'&input_pctEspecial_Maquina='+pctEspecial+'&input_obs_Maquina='+obs+'&input_gab_Maquina='+gabinete+'&input_placa_Maquina='+placaM+'&input_bil_Maquina='+bil+'&input_pen_Maquina='+pen+'&input_mon_Maquina='+mon,
			success: function(html)
			{
				if(html == true)
				{
					$('#edit-modal-Maquinas').fadeOut("slow");
					$('#msgConfirm').text('Registro alterado con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#edit-modal-Maquinas').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para alterar el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}	
			}
		});
	});	
	
	
	
	//
	$('#input_local_Maquina').change(function(){
		
		//
		$("#hd_input_local_Maquina").attr("value", this.value);
	});
	
	//
	$('#input_disp_Maquina').change(function(){
		
		//
		$("#hd_input_disp_Maquina").attr("value", this.value);
	});	
	
	
</script>