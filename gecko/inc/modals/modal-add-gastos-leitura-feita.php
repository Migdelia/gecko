<?php $modal_item = "gasto" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>&nbsp;</p>
        <form class="form-horizontal" method="post" action="functions/addJogo.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row">
                  <label for="tags">Tipo de Gasto</label>
                  <select id="tipoGasto" name="tipoGasto" type="text" class="form-control col-xs-6" placeholder="Ciudades">
                        
                      <option value="0"></option>
                      
                      <?php
                        //busca locais ativos
                        $sql_tp_gastos = "SELECT * FROM tipo_desconto ORDER BY id_desconto";
                        $query_tp_gastos=@mysql_query($sql_tp_gastos);
                        
                        while($res_tp_gastos=@mysql_fetch_assoc($query_tp_gastos)) 
                        {
                            echo "<option value=".$res_tp_gastos['id_desconto'].">".$res_tp_gastos['descricao']."</option>";
                        }						
                      ?>
                  
                  </select>
              </div>
              <div class="row form">
                <label for="input_codigo<?php echo $modal_item ?>" class="control-label"><?php echo _('Numero del documento') ?></label>
                <input type="text" class="form-control" id="input_numDoc_<?php echo $modal_item ?>" name="input_numDoc_<?php echo $modal_item ?>" placeholder="<?php echo _('Numero del documento') ?>" value="">
              </div>
              <div class="row form">
                <label for="input_codigo<?php echo $modal_item ?>" class="control-label"><?php echo _('Descripcion') ?></label>
                <input type="text" class="form-control" id="input_descri_<?php echo $modal_item ?>" name="input_descri_<?php echo $modal_item ?>" placeholder="<?php echo _('Descripcion') ?>" value="">
              </div>              
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="row">
                  <label for="tags">Tipo de Documento</label>
                  <select id="tpDoc" name="tpDoc" type="text" class="form-control col-xs-6" placeholder="tipo documento">
                        
                      <option value="0"></option>
					  <option value="Factura">Factura</option>
                      <option value="Boleta">Boleta</option>
                      <option value="Vale">Vale</option>                  
                  </select>
              </div>
              <div class="row form">
                <label for="input_codigo<?php echo $modal_item ?>" class="control-label"><?php echo _('Valor del gasto') ?></label>
                <input type="text" class="form-control" id="input_valor_<?php echo $modal_item ?>" name="input_valor_<?php echo $modal_item ?>" placeholder="<?php echo _('Valor del gasto') ?>" value="">
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
				<button id="btnGasto" name="btnGasto" type="button" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-dismiss="modal"><?php echo _('Agregar Nuevo Gasto ') ?></button>              
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
    //
	$(document).ready(function() {
       $('select').select2();
    });
	
	//adiciona despesa
	$('#btnGasto').click( function (){
		
		//pegar valores desse gasto
		var tpGasto = $('#tipoGasto').val(); //cc
		var tpDoc = $('#tpDoc').val(); //td
		var descricao = $('#input_descri_gasto').val(); //dc
		var vlGasto = $('#input_valor_gasto').val(); //vl
		var numDoc = $('#input_numDoc_gasto').val(); //vl
		var op = <?php echo $_SESSION['id_login']; ?>;

		
		//inseri no banco de dados
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'add_despesa_leitura_feita.php', // Informo a URL que será pesquisada.
			data: 'cent_cust='+tpGasto+'&valor='+vlGasto+'&descricao='+descricao+'&tipo_doc='+tpDoc+'&numero_doc='+numDoc+'&oper='+op+'&idLeit='+<?php echo $id_assoc; ?>,
			//data: "cent_cust=cc&valor=vl&descricao=dc&tipo_doc=td&numero_doc=nd",
			success: function(html)
			{
				window.location.reload(true);
				
				/*
				//alert(html);
				
				idGasto = html.split("/");
				idGasto = idGasto[1];

				//somar no total de gastos
				var totalGastoAtual = $('#total_gastos').text();
				totalGastoAtual = totalGastoAtual.replace('.', '');
				totalGastoAtual = totalGastoAtual.replace('.', '');						
				
				
				//
				novoTotalGasto = eval(totalGastoAtual) + eval(vlGasto);

				//
				novoTotalGasto = eval(novoTotalGasto).formatNumber(2,',','.');
				novoTotalGasto = novoTotalGasto.replace(',00', '');				
				$('#total_gastos').text(novoTotalGasto);
		
				//
				vlGasto = eval(vlGasto).formatNumber(2,',','.');
				vlGasto = vlGasto.replace(',00', '');
				
				//
				$("#tableGastos tbody").prepend("<tr id='ln_gasto_"+idGasto+"'><td class='left-align'>"+descricao+"</td><td class='left-align'>"+tpDoc+"</td><td class='left-align'>$ "+vlGasto+"</td><td class='left-align'><a id='gasto_"+idGasto+"' class='btn btn-sm' target='new' onClick='excluiGasto(this);'> Excluir </a></td></tr>");
				
				*/
			}
		});		

	               
	});
</script>