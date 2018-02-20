<?php $modal_item = "diferenca" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Editar ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" id="formEditPlaca" method="post" action="functions/alteraPlaca.php">
          <div class="row">
            <div class="radio">
            	<label>
                <input id='rd_dif_neg' name='tipo_operacao_dif' type='radio' checked="checked" value="0" onclick="operacaoDif(this);">&nbsp; Negativa 
                </label>
                
            	<label>
                <input id='rd_dif_pos' name='tipo_operacao_dif' type='radio' value="1" onclick="operacaoDif(this);">&nbsp; Positiva
                </label>                
                <br /> 
                <br />                                
            </div>          
            <div class="col-xs-12 col-md-6">                     
              <div id="vlDifNeg" class="row">
              	<label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Diferencia Negativa') ?></label>  
                <input type="text" class="form-control" id="edit_neg_<?php echo $modal_item ?>" name="edit_novo_<?php echo $modal_item ?>" placeholder="$" value="" onkeyup="formataValor(this);">
              </div>     
              <div id="vlDifPos" class="row" style="display:none;">
                <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Diferencia Positiva') ?></label>
                <input type="text" class="form-control" id="edit_pos_<?php echo $modal_item ?>" name="edit_pos_<?php echo $modal_item ?>" placeholder="$" value="" onkeyup="formataValor(this);">
              </div>                                                
            </div>
            
            
            <div class="col-xs-12 col-md-6">                     
              <div id="vlDifNeg" class="row">
                  <label for="tags">Maquina</label>
                  <select id="maq_dif" name="maq_dif" type="text" class="form-control col-xs-6" placeholder="Ciudades">
                        
                      <option value="0"></option>
                      
                      <?php
                        //busca locais ativos
                        $sql_maquinas = "SELECT id_maquina, numero FROM vw_maquinas WHERE id_local = " . $id_assoc;
                        $query_maquinas=@mysql_query($sql_maquinas);
                        
                        while($res_maquinas=@mysql_fetch_assoc($query_maquinas)) 
                        {
                            echo "<option value=".$res_maquinas['id_maquina'].">".$res_maquinas['numero']."</option>";
                        }						
                      ?>
                  
                  </select>
              </div>                                                  
            </div>
            <div class="col-xs-12 col-md-612">                     
              <div class="row">
              	<label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Motivo') ?></label>  
                <input type="text" class="form-control" id="edit_mot_<?php echo $modal_item ?>" name="edit_mot_<?php echo $modal_item ?>" placeholder="motivo" value="" >
              </div>                                                    
            </div>            
          </div>
          <div class="row form-group">
            <button id="btnGuardar" name="btnGuardar" type="button" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-dismiss="modal"><?php echo _('Guardar ') ?></button>
            <!--- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--->
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script language="javascript">


$('#btnGuardar').click( function (){
	
	//
	var vlDifPos = $('#edit_pos_diferenca').val();
	var vlDifNeg = $('#edit_neg_diferenca').val();
	var motDif = $('#edit_mot_diferenca').val();
	var maqDif =  $('#maq_dif').val();	
	var tipoSelect = jQuery("input[name=tipo_operacao_dif]:checked").val();
	
	
	//
	if(tipoSelect == 0)
	{
		//pega a dif negativa antes de trocar
		var difNegAtu = $('#tot_dif_neg').text();
		
		//
		$('#tot_dif_neg').text(vlDifNeg);		
		
		//calcula o novo saldo
		var novoSaldoDif = $('#tot_vl_dif').text();
		
		//limpa valores para calculo novo saldo
		vlDifNeg = vlDifNeg.replace('.', '');
		vlDifNeg = vlDifNeg.replace('.', '');
		
		novoSaldoDif = novoSaldoDif.replace('.', '');
		novoSaldoDif = novoSaldoDif.replace('.', '');
		
		difNegAtu = difNegAtu.replace('.', '');
		difNegAtu = difNegAtu.replace('.', '');		
		
		//
		novoSaldoAtual = (eval(novoSaldoDif) - eval(difNegAtu)) + eval(vlDifNeg);
		

		//
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'add_diferenca.php', // Informo a URL que será pesquisada.
			data: 'id_maq='+maqDif+'&valorDif='+vlDifNeg+'&motivo='+motDif,
			//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
			success: function(html)
			{
				var resul=html.split("/");
				var ult_id_ins = resul[1];
				if(resul[0] == "true")
				{
					alert("funfo");
				}
	
				else
				{
					alert("Error!");
				}
			}
		});			
		
		//atualiza o saldo
		novoSaldoAtual = eval(novoSaldoAtual).formatNumber(2,',','.');
		novoSaldoAtual = novoSaldoAtual.replace(',00', '');		
		
		$('#tot_vl_dif').text(novoSaldoAtual);
		
		//
		vlDif = $('#tot_dif_neg').text();
	}
	else
	{
		//
		$('#tot_dif_pos').text(vlDifPos);	
		
		//
		vlDif = $('#tot_dif_pos').text();
	}
	
	//adicionar linha
	$("<tr id='ln_dif_"+maqDif+"'><td><strong>Diferencia maq:</strong></td><td>Descripcion:</td><td colspan='3'>"+motDif+"</td><td colspan='2'><strong>$ "+vlDif+"</strong></td><td><a class='btn btn-raised btn-sm' title='"+maqDif+"' data-target='#edit-modal-diferenca' onclick='excluiDif(this);'>Excluir</a></td></tr>").insertAfter($('#ln_'+maqDif).closest('tr'));
	
	//recalcular valores dessa maquina	

});


//
function operacaoDif(obj)
{
	if(obj.id == 'rd_dif_neg')
	{
		$('#vlDifNeg').slideDown("slow");
		$('#vlDifPos').slideUp("slow");				
	}
	else
	{
		$('#vlDifNeg').slideUp("slow");		
		$('#vlDifPos').slideDown("slow");
	}
}

//
$(document).ready(function() {
   $('select').select2();
});


</script>
