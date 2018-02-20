<?php $modal_item = "Lectura" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-plus"></i> <?php echo _('Agregar Nueva ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos de la nueva lectura.</p>
        <br />
        <form id="formInfoLeitura" class="form-horizontal" method="post" action="detalle-local.php">
          <div class="row">
          	<div class="col-xs-12 col-md-6">
                <div class="row">
                  <label for="tags">Local</label>
                  <select id="local_leitura" name="local_leitura" type="text" class="form-control col-xs-6" placeholder="Ciudades">
                  		
                      <option value="0"></option>
                      
                      <?php
						//limita acesso usuario <> master
						if($_SESSION['usr_nivel'] == 1)
						{
							$whr = " AND 1 = 1";
						}
						else
						{
							$whr = " AND (`local`.id_login = " . $_SESSION['id_login'] . " OR `local`.id_gerente = " . $_SESSION['id_login'] . ")";
						}			
								  	
					  
					  	//busca locais ativos
						$sql_locais = "SELECT id_local, nome FROM local WHERE excluido = 'N' " . $whr . " ORDER BY nome";
						
						
						$query_locais=@mysql_query($sql_locais);
						
						
						while($res_locais=@mysql_fetch_assoc($query_locais)) 
						{
							echo "<option value=".$res_locais['id_local'].">".$res_locais['nome']."</option>";
						}						
					  ?>
                  
                  </select>
                  
                  <?php //echo $sql_locais . " /////////////////////////////////////" ; ?>
                </div>             
            </div>
          	<div class="col-xs-12 col-md-6">
                <div class="row">
                  <label for="tags">Fecha de Cierre </label>
                  <input type='text' id='datepicker' name='datepicker' size='23' placeholder="dd-mm-aaaa" onchange="verificaDia(this);" readonly>
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
		location="detalle-local.php?id="+$('#local_leitura').val()+"&rep=0"+"&datepicker="+$('#datepicker').val();
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
			alert("ERROR! Ese dia no es valido para la Fecha. Elija un VIERNES!");
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