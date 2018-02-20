<?php $modal_item = " Informaciones Maquinas " // ingresar la palabra clave de cada modal ?>
<div id="maquinasPorLocal-modal" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo $modal_item . '(Isla del Tesoro) ' ?></h5>
      </div>
      
      
      
      
      <div id="painel">
          <div id="combo_telas" class="row form-group" style="display:none;">
          
	  	    <a id="btn_lista_maquinas" class="btn" style="display:none;">Volver</a>
        	
            <form> 
            <!--- declara id da chapa --->
            <input type="hidden" id="id_chapa" name="id_chapa" value=""  />
          
            <label for="input_modelo<?php echo $modal_item ?>" class="control-label"><?php echo _('Modelo') ?></label>
            <input type="hidden" id="input_modChapa_<?php echo $modal_item ?>" name="input_modChapa_<?php echo $modal_item ?>" value="<?php echo $res_maq['excluido'] ?>" >
            <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_modChapa_<?php echo $modal_item ?>" name="select_modChapa_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Modelo') ?><div class="ripple-container"></div></a>
            <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
            <ul class="dropdown-menu">
            
            <?php
			  	//
				$sql_lista_chapas = "
					SELECT
						*
					FROM
						modelos_chapa
					ORDER BY
						modelos_chapa.descricao
					";	
				
				$query_lista_chapas=@mysql_query($sql_lista_chapas);
			
                //
                while($res_lista_chapas=@mysql_fetch_assoc($query_lista_chapas)) 
                {
                    echo "<li>";
                    echo "<a id='modChapa_".$res_lista_chapas['id_modelo']."' href='#' class='mass-act' onClick='atribuiValor(this);'>".$res_lista_chapas['descricao']."</a>";
                    echo "</li>";
                    echo "<li class='divider'></li>";
                }			
            ?>
            
            </ul>
            
            </form> 
          </div>          
      
           
      </div>
      
      
      
      
      <div id="lista_maquinas" class="modal-body">
      	
        <p>Informaciones en tiempo real de las maquinas de: <strong>Isla del Tesoro</strong></p>
      
        
        <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">

            <tbody>
              <tr>
                <th>Maquina</th>
                <th>Entrada</th>
                <th>Salida</th>
                <th>Saldo</th>
              </tr>            
            
            <?php
			
				//consulta as maquinas desse local.
				$sql_maquinas = "SELECT * FROM vw_maquinas WHERE id_local = 101 ORDER BY numero";
				$query_maquinas=@mysql_query($sql_maquinas);
				
				
				//
				while($res_maquinas=@mysql_fetch_assoc($query_maquinas)) 
				{
					//
					if($res_maquinas['interface'] >= 70000)
					{
						//conecta no BD Dongle
						include('conn/connDongle.php');					
						
						//consulta dados da disp
						$sql_info_dong = "SELECT * FROM StreetDongle WHERE MachineId = " . $res_maquinas['interface'];
						$query_info_dong=@mysql_query($sql_info_dong);
						$res_info_dong=@mysql_fetch_assoc($query_info_dong);						
					}
					else
					{
						//conecta no BD Interface
						include('conn/connInt.php');					
						
						//consulta dados da disp
						$sql_info_dong = "SELECT * FROM Machine WHERE id = " . $res_maquinas['interface'];
						$query_info_dong=@mysql_query($sql_info_dong);
						$res_info_dong=@mysql_fetch_assoc($query_info_dong);						
					}
					
					
					$entrada = $res_info_dong['creditIn'] * 10;
					$saida = $res_info_dong['creditOut'] * 10;
					$saldo = $entrada - $saida;

			?>

                    <tr>
                    	<td id="<?php echo $res_maquinas['id_maquina'] ?>" style="cursor:pointer;" onclick="infoMaquina(this);"><?php echo $res_maquinas['codigo'] . " - " . $res_maquinas['numero']  ?> </td>
                    	<td><?php echo "$ " . number_format($entrada,0,"",".") ?></td>
                    	<td><?php echo "$ " . number_format($saida,0,"",".") ?></td>
                    	<td><?php echo "$ " . number_format($saldo,0,"",".") ?></td>
                    </tr>            
            <?php
				}	
			?>
            



            </tbody>
          </table>
        </div>
        <div class="row form-group">
          <div class="col-xs-12">
            <button type="button" onclick="javascript:window.print()" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Imprimir') ?></button>
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Actualizar') ?></button>
          </div>
        </div>
      </div>
      
      
      
    <!--- teste --->
    


      <div id="last_payouts" class="modal-body" style="display:none;">
        <p>&nbsp;</p>
        <p>Last Payout:</p>
        
        
      	<p>Mostrar 50 ultimos pagamentos </p>
        
        <div class="row form-group">
          <div class="col-xs-12">
            <button type="button" onclick="javascript:window.print()" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Imprimir') ?></button>
            <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Actualizar') ?></button>
          </div>
        </div>        
      </div>
      
      
      <div id="info_basica" class="modal-body" style="display:none;">
        <p>&nbsp;</p>
        <p>Informaciones:</p>
        
        
      	<p>Mostrar infos dessa maquina </p>
        <div class="row form-group">
          <div class="col-xs-12">
            <button type="button" onclick="javascript:window.print()" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" style="margin-left:15px;"><?php echo _('Imprimir') ?></button>
          </div>
        </div>        
      </div>      


    
    <!--- teste --->          
      
      
    </div>
  </div>
</div>


<script>
	//
	function infoMaquina(obj)
	{
		//painel
		$('#lista_maquinas').fadeOut("slow");
		$('#btn_lista_maquinas').fadeIn("slow");
		$('#combo_telas').fadeIn("slow");
		
		
		//conteudo
		$('#info_basica').fadeIn("slow");		
	}
	
	$('#btn_lista_maquinas').click(function(){
		//painel
		$('#lista_maquinas').fadeIn("slow");
		$('#btn_lista_maquinas').fadeOut("slow");
		$('#combo_telas').fadeOut("slow");
		
		//conteudo
		$('#info_basica').fadeOut("slow");
	});
</script>