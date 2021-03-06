<?php $modal_item = "Maquina" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item ?></h5>
      </div>
      <div class="modal-body">
      	<p><strong>Ingrese los datos de la nueva maquina.</strong></p>      
        <form class="form-horizontal" method="post" action="" target="_parent">
          <div class="row">
            <div class="col-xs-6 col-md-6">
              <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Número de máquina') ?></label>
              <div id="div_num_maq" class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Número de máquina') ?></label>
                <input type="number" class="form-control" id="inputAdd_num_<?php echo $modal_item ?>" name="inputAdd_num_<?php echo $modal_item ?>" placeholder="<?php echo _('Número de máquina') ?>" value="">
              </div>
              
              
              <?php
			  	//monsta lista de cidades
				$sql_cidade = "
					SELECT
						id_cidade,
						nome_cidade
					FROM
						regiao
					WHERE
						excluido = 'N'
					ORDER BY
						nome_cidade";	
				
				
				$query_cidade=@mysql_query($sql_cidade);			
			  ?>
              <label for="input_add_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Ciudad') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="inputAdd_cidade_<?php echo $modal_item ?>" name="inputAdd_cidade_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
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
              <label for="inputAdd_local<?php echo $modal_item ?>" class="control-label"><?php echo _('Local') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="inputAdd_local_<?php echo $modal_item ?>" name="inputAdd_local_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                <?php
					//
					while($res_loc=@mysql_fetch_assoc($query_loc)) 
					{
						echo "<option value='".$res_loc['nome']."'>".$res_loc['nome']."</option>";
					}
				?>                 

                </select>
                <span class="material-input"></span>
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
              
              
              <label for="inputAdd_disp<?php echo $modal_item ?>" class="control-label"><?php echo _('Disp de Seguridad') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="inputAdd_disp_<?php echo $modal_item ?>" name="inputAdd_disp_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
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
							
							
							echo "<option value='".$res_disp['numero']."' onmouseup='' disabled>".$res_disp['numero']." - (Ocupada: Maq-".$res_num_maq['numero'].")</option>";													
						}
					}
				?>                 

                </select>
                <span class="material-input"></span>
              </div>
              
              
              
 

              <label for="input_obsm<?php echo $modal_item ?>" class="control-label"><?php echo _('Ordem Leitura') ?></label>
              <div class="row form-group">
                <label for="input_obsm<?php echo $modal_item ?>" class="control-label"><?php echo _('Ordem Leitura') ?></label>
                <input type="number" class="form-control" id="inputAdd_ordem_<?php echo $modal_item ?>" name="inputAdd_ordem_<?php echo $modal_item ?>" placeholder="<?php echo _('Ordem Leitura') ?>" value="0">
              </div>               
           
                            
              
              <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Entrada Oficial') ?></label>             
              <div class="row form-group">
                <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Entrada Oficial') ?></label>
                <input type="text" class="form-control" id="inputAdd_entrada_<?php echo $modal_item ?>" name="inputAdd_entrada_<?php echo $modal_item ?>" placeholder="<?php echo _('Entrada Oficial') ?>" value="0">
              </div>
              
              <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Saida Oficial') ?></label>
              <div class="row form-group">
                <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Saida Oficial') ?></label>
                <input type="text" class="form-control" id="inputAdd_saida_<?php echo $modal_item ?>" name="inputAdd_saida_<?php echo $modal_item ?>" placeholder="<?php echo _('Saida Oficial') ?>" value="0">
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
					if($res_maq['parceiro'] == "true")
					{
				  		echo "<label><input id='checkAdd_parce' name='checkAdd_parce' type='checkbox' checked><span class='checkbox-material'></span></label>";
					}
					else
					{
						echo "<label><input id='checkAdd_parce' name='checkAdd_parce' type='checkbox'><span class='checkbox-material'></span></label>";	
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
				  		echo "<label><input id='checkAdd_maquina_socio' name='checkAdd_maquina_socio' type='checkbox' checked><span class='checkbox-material'></span></label>";
					}
					else
					{
						echo "<label><input id='checkAdd_maquina_socio' name='checkAdd_maquina_socio' type='checkbox'><span class='checkbox-material'></span></label>";	
					}				  
				  ?>
                </div>
              </div>              
              
              <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Socio') ?></label>              
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Socio') ?></label>
                <input type="text" class="form-control" id="inputAdd_pctSocio_<?php echo $modal_item ?>" name="inputAdd_pctSocio_<?php echo $modal_item ?>" placeholder="<?php echo _('% Socio') ?>" value="<?php echo $res_maq['porc_socio'] ?>" >
              </div>
              
              <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Especial') ?></label>
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Especial') ?></label>
                <input type="text" class="form-control" id="inputAdd_pctEspecial_<?php echo $modal_item ?>" name="inputAdd_pctEspecial_<?php echo $modal_item ?>" placeholder="<?php echo _('% Especial') ?>" value="<?php echo $res_maq['porc_maquina'] ?>">
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
              <label for="inputAdd_gab<?php echo $modal_item ?>" class="control-label"><?php echo _('Gabinete') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="inputAdd_gab_<?php echo $modal_item ?>" name="inputAdd_gab_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
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
              <label for="inputAdd_placa<?php echo $modal_item ?>" class="control-label"><?php echo _('Placa Madre') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="inputAdd_placa_<?php echo $modal_item ?>" name="inputAdd_placa_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
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
              <label for="inputAdd_bil<?php echo $modal_item ?>" class="control-label"><?php echo _('Billeteros') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="inputAdd_bil_<?php echo $modal_item ?>" name="inputAdd_bil_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
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
              <label for="inputAdd_pen<?php echo $modal_item ?>" class="control-label"><?php echo _('Pendrives') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="inputAdd_pen_<?php echo $modal_item ?>" name="inputAdd_pen_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
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
              <label for="inputAdd_mon<?php echo $modal_item ?>" class="control-label"><?php echo _('Monitores') ?></label>    
              <div class="form-group is-empty ui-widget">
                <label for="tags"></label>
                <select id="inputAdd_mon_<?php echo $modal_item ?>" name="inputAdd_mon_<?php echo $modal_item ?>" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
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
							echo "<input id='checkAdd_chapa_".$resChapa['codigo']."' name='checkAdd_chapa_".$resChapa['codigo']."' type='checkbox'>";
							echo "<span class='checkbox-material'>".$resChapa['codigo']."</span>";
							echo "</label>";
						}
					?>                                      
                </div>
                </ul>
              </div>                                                                       
            </div>
          </div>
          <div class="row form-group">
          	<div class="col-xs-10">
            	<label for="input_resp<?php echo $modal_item ?>" class="control-label"><?php echo _('Observacion maquina') ?></label>
            	<input type="text" class="form-control" id="inputAdd_obs_<?php echo $modal_item ?>" name="inputAdd_obs_<?php echo $modal_item ?>" placeholder="<?php echo _('Observacion maquina') ?>" value="<?php echo $res_maq['obs'] ?>">
            </div>
          </div>   
          <div class="row form-group">
            <div class="col-xs-12">
                <a id="btnAddMaquina" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                    <?php echo _('Crear Nueva ') . $modal_item ?>
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
	/*
	function atribuiValorAdd(obj)
	{
		//
		var tpCombo = obj.id.split("_");
		tpCombo = tpCombo[0];
		
		$('#selectAdd_'+tpCombo+'_Maquina').text(obj.text);
		$('#inputAdd_'+tpCombo+'_Maquina').attr("value", obj.text);	
	}
	
	
	$('#myInputSearchField').keyup(function(){
		oTable.search($(this).val()).draw() ;
	});
	*/
    $(document).ready(function() {
        $('select').select2();
    });	
	
	$("form").submit(function()
	{
		//
		if($('#inputAdd_num_Maquina').val() == '' || $('#inputAdd_num_Maquina').val() <= 0)
		{
			//verifica se o numero de maqui esta vazio
			$(div_num_maq).addClass("form-group has-error");
			$('#inputAdd_num_Maquina').focus();
			return false;			
		}
		else
		{
			return true;	
		}

	});
	
	
	//
	$('#btnAddMaquina').click(function()
	{
		var numMaquina = $('#inputAdd_num_Maquina').val();
		var codMaquina = $('#inputAdd_cod_Maquina').val();
		var jogo = $('#inputAdd_jogo_Maquina').val();
		var local = $('#inputAdd_local_Maquina').val();
		var dispSeg = $('#inputAdd_disp_Maquina').val();
		var ordem = $('#inputAdd_ordem_Maquina').val();
		var entrada = $('#inputAdd_entrada_Maquina').val();
		var saida = $('#inputAdd_saida_Maquina').val();
		var maqParceiro = $('#checkAdd_parce').is(':checked');
		var maqSocio = $('#checkAdd_maquina_socio').is(':checked');;
		var pctSocio = $('#inputAdd_pctSocio_Maquina').val();
		var pctEsp = $('#inputAdd_pctEspecial_Maquina').val();		
		var maqObs = $('#inputAdd_obs_Maquina').val();		
		var gabMaq = $('#inputAdd_gab_Maquina').val();
		var placa = $('#inputAdd_placa_Maquina').val();
		var bilheteiro = $('#inputAdd_bil_Maquina').val();
		var pendrive = $('#inputAdd_pen_Maquina').val();		
		var monitor = $('#inputAdd_mon_Maquina').val();				



		// 
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/addMaquina.php', // Informo a URL que será pesquisada.
			data: 'inputAdd_num_Maquina='+numMaquina+'&inputAdd_cod_Maquina='+codMaquina+'&inputAdd_jogo_Maquina='+jogo+'&inputAdd_local_Maquina='+local+'&inputAdd_disp_Maquina='+dispSeg+'&inputAdd_ordem_Maquina='+ordem+'&inputAdd_entrada_Maquina='+entrada+'&inputAdd_saida_Maquina='+saida+'&checkAdd_parce='+maqParceiro+'&checkAdd_maquina_socio='+maqSocio+'&inputAdd_pctSocio_Maquina='+pctSocio+'&inputAdd_pctEspecial_Maquina='+pctEsp+'&inputAdd_obs_Maquina='+maqObs+'&inputAdd_gab_Maquina='+gabMaq+'&inputAdd_placa_Maquina='+placa+'&inputAdd_bil_Maquina='+bilheteiro+'&inputAdd_pen_Maquina='+pendrive+'&inputAdd_mon_Maquina='+monitor,
			success: function(html)
			{
				if(html == true)
				{
					$('#add-modal-Maquinas').fadeOut("slow");
					$('#msgConfirm').text('Registro Inserido con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#add-modal-Maquinas').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para inserir el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}				
			}

		});
	});		
</script>