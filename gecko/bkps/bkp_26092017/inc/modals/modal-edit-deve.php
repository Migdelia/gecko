<?php $modal_item = "deve" // ingresar la palabra clave de cada modal ?>
<div id="edit-modal-<?php echo $modal_item ?>" class="modal fade" tabindex="-1" style="display: none;">
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
                <input id='rd_novo_deve' name='tipo_operacao_deve' type='radio' checked="checked" value="0" onclick="operacao(this);">&nbsp; Nuevo Deve 
                </label>
                
            	<label>
                <input id='rd_abono_deve' name='tipo_operacao_deve' type='radio' value="1" onclick="operacao(this);">&nbsp; Abono Deve
                </label>                
                <br /> 
                <br />                                
            </div>          
          
          
          
          
            <div class="col-xs-12 col-md-6">
                     
              <div id="vlNovoDeve" class="row">
              	<label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Valor Nuevo Deve') ?></label>  
                <input type="text" class="form-control" id="edit_novo_<?php echo $modal_item ?>" name="edit_novo_<?php echo $modal_item ?>" placeholder="$" value="" onkeyup="formataValor(this);">
              </div>     
              <div id="vlAbodoDeve" class="row" style="display:none;">
                <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Valor Abono Deve') ?></label>
                <input type="text" class="form-control" id="edit_abono_<?php echo $modal_item ?>" name="edit_abono_<?php echo $modal_item ?>" placeholder="$" value="" onkeyup="formataValor(this);">
              </div>                                                
            </div>
          </div>
          <div class="row form-group">
            <button id="btnAbono" name="btnAbono" type="button" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-dismiss="modal"><?php echo _('Guardar ') ?></button>
            <!--- <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>--->
          </div>
        </form>
      </div>

    </div>
  </div>
</div>

<script language="javascript">

//
function atribuiValor(obj)
{
	//
	var tpCombo = obj.id.split("_");
	tpCombo = tpCombo[0];
	
	var idObj = obj.id.split("_");
	idObj = idObj[1];

	
	//
	$('#select_'+tpCombo+'_Placa').text(obj.text);
	$('#input_'+tpCombo+'_Placa').attr("value", idObj);
}


$('#btnAbono').click( function (){
	
	//
	var vlAbonoDeve = $('#edit_abono_deve').val();
	var vlNovoDeve = $('#edit_novo_deve').val();
	var tipoSelect = jQuery("input[name=tipo_operacao_deve]:checked").val();
	
	//
	if(tipoSelect == 0)
	{
		//pegar o deve antes de atualizar
		var deveIngressado = $('#deve').text();

		//
		$('#deve').text(vlNovoDeve);
		
		//calcula o novo saldo
		var novoSaldo = $('#deve_atual').text();
		
		//limpa valores para calculo novo saldo
		vlNovoDeve = vlNovoDeve.replace('.', '');
		vlNovoDeve = vlNovoDeve.replace('.', '');
		
		novoSaldo = novoSaldo.replace('.', '');
		novoSaldo = novoSaldo.replace('.', '');
		
		deveIngressado = deveIngressado.replace('.', '');
		deveIngressado = deveIngressado.replace('.', '');		
		
		//
		novoSaldoAtual = (eval(novoSaldo) - eval(deveIngressado)) + eval(vlNovoDeve);
		
		//atualiza o saldo
		novoSaldoAtual = eval(novoSaldoAtual).formatNumber(2,',','.');
		novoSaldoAtual = novoSaldoAtual.replace(',00', '');		
		
		$('#deve_atual').text(novoSaldoAtual);	
	}
	else
	{
		//pegar o deve antes de atualizar
		var deveAbonado = $('#abono').text();
				
		//
		$('#abono').text(vlAbonoDeve);	
		
		//calcula o novo saldo
		var novoSaldo = $('#deve_atual').text();
		
		//limpa valores para calculo novo saldo
		vlAbonoDeve = vlAbonoDeve.replace('.', '');
		vlAbonoDeve = vlAbonoDeve.replace('.', '');
		
		novoSaldo = novoSaldo.replace('.', '');
		novoSaldo = novoSaldo.replace('.', '');
		
		deveAbonado = deveAbonado.replace('.', '');
		deveAbonado = deveAbonado.replace('.', '');		
		
		//
		novoSaldoAtual = (eval(novoSaldo) + eval(deveAbonado)) - eval(vlAbonoDeve);
		
		//atualiza o saldo
		novoSaldoAtual = eval(novoSaldoAtual).formatNumber(2,',','.');
		novoSaldoAtual = novoSaldoAtual.replace(',00', '');		
		
		$('#deve_atual').text(novoSaldoAtual);			
		
	}	


});

function operacao(obj)
{
	if(obj.id == 'rd_novo_deve')
	{
		$('#vlNovoDeve').slideDown("slow");
		$('#vlAbodoDeve').slideUp("slow");				
	}
	else
	{
		$('#vlNovoDeve').slideUp("slow");		
		$('#vlAbodoDeve').slideDown("slow");
	}
}


function formataValor(obj)
{
	var vlNovo = obj.value;
	
	//limpa valor
	vlNovo = vlNovo.replace('.', '');
	vlNovo = vlNovo.replace('.', '');		
	
	//formata nova entrada
	if(vlNovo == '')
	{
		vlNovo = 0;
	}		
	vlNovo = eval(vlNovo).formatNumber(2,',','.');
	vlNovo = vlNovo.replace(',00', '');
	
	//atribui os valores novos
	$('#'+obj.id).val(vlNovo);
}

</script>