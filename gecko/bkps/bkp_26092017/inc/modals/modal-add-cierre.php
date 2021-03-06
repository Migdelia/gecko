<?php $modal_item = "cierre" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nueva ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>&nbsp;</p>
        <br />
        <form id="formInfoLeitura" class="form-horizontal" method="post" action="cierre.php">
          <div class="row">
          	<div class="col-xs-12 col-md-12">
                <div class="row">
                  <label for="tags">Tipo Local</label>
                  <select id="myInputSearchField" name="myInputSearchField" type="text" class="form-control col-xs-6" placeholder="Ciudades">
                  		
                      <option value="0"></option>
                      
                      <?php
					  	//busca locais ativos
						$sql_locais = "SELECT id_tp_local, tp_local FROM tipo_local";
						$query_locais=@mysql_query($sql_locais);
						
						while($res_locais=@mysql_fetch_assoc($query_locais)) 
						{
							echo "<option value=".$res_locais['id_tp_local'].">".$res_locais['tp_local']."</option>";
						}						
					  ?>
                  
                  </select>
                </div>             
            </div>
            <div class="col-xs-12">
            	<div class="row form-group">
             		<a id="btnSeguinte" type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Siguiente') ?></a>
           		</div>
            </div>                          
        </div>      
      </form>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
       $('select').select2();
    });
	
	$(function() {
		$("#datepicker").datepicker({dateFormat: 'dd-mm-yy, DD'});
	});	
	
	
	$("#btnSeguinte").click( function (){
		$( "#formInfoLeitura" ).submit();
	});


	//
	function verificaDia(obj)
	{

		var diaSemana = obj.value;
		var diaSemana = diaSemana.split(",");
		var diaMes = diaSemana[0].replace(" ","");
		var diaSemana = diaSemana[1].replace(" ","");

		//
		if(diaSemana !== "Friday")
		{
			alert("ERRO! Ese dia no es valido para Fechamento. Elija un VIERNES!");
			document.getElementById("datepicker").value = '';
		}
		else
		{
			var diaMes = diaMes.split("-");
			var diaRef = diaMes[0];
			diaRef = diaRef.replace(" ","");
			diaRef = eval(diaRef);
			diaRef = diaRef / 7;
			
			//
			if((parseFloat(diaRef) == parseInt(diaRef)) && !isNaN(diaRef))
			{
				diaRef = diaRef;
			} 
			else
			{
				var diaRef = diaRef.toString();
				var diaRef = diaRef.split(".");
				diaRef = eval(diaRef[0]) + 1;
			}

			$('#semMes').attr("value", diaRef);
		}
	}	
	
</script>