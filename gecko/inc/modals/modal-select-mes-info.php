<?php $modal_item = "Lectura" // ingresar la palabra clave de cada modal ?>
<div id="select-periodo" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-calendar"></i> <?php echo _('Elegir mes de consulta') ?></h5>
      </div>
      <div class="modal-body">

        <form id="formInfoEstRes" class="form-horizontal" method="post" action="info-estado-resultado.php">
          <div class="row">
          	<div class="col-xs-12 col-md-6">
            	<div class="row form-group">
                	<strong>
                    	<input type="button" id="menosMes" name="menosMes" style="width:50px;" onclick="restaMes(this)" value=" << " />
                        &nbsp;&nbsp;&nbsp;
                    	<input type="text" id="txtAno" name="txtAno" value="2017" style="width:70px;" align="right" />&nbsp;
                        <input type="button" id="maisMes" name="maisMes" style="width:50px;" onclick="somaMes(this)" value=" >> " />
                    </strong>
                    <br /><br />
             		<input type="button" id="jan" name="01" style="width:50px;" onclick="atribuiData(this)" value="Ene" />
                    &nbsp;
                    <input type="button" id="fev" name="02" style="width:50px;" onclick="atribuiData(this)" value="Feb" />
             		&nbsp;
                    <input type="button" id="mar" name="03" style="width:50px;" onclick="atribuiData(this)" value="Mar" />
                    &nbsp;
                    <input type="button" id="abr" name="04" style="width:50px;" onclick="atribuiData(this)" value="Abr" />
                    <br /><br />
             		<input type="button" id="jan" name="05" style="width:50px;" onclick="atribuiData(this)" value="May" />
                    &nbsp;
                    <input type="button" id="fev" name="06" style="width:50px;" onclick="atribuiData(this)" value="Jun" />
             		&nbsp;
                    <input type="button" id="mar" name="07" style="width:50px;" onclick="atribuiData(this)" value="Jul" />
                    &nbsp;
                    <input type="button" id="abr" name="08" style="width:50px;" onclick="atribuiData(this)" value="Ago" />
             		<br /><br />
                    <input type="button" id="jan" name="09" style="width:50px;" onclick="atribuiData(this)" value="Sep" />
                    &nbsp;
                    <input type="button" id="fev" name="10" style="width:50px;" onclick="atribuiData(this)" value="Oct" />
             		&nbsp;
                    <input type="button" id="mar" name="11" style="width:50px;" onclick="atribuiData(this)" value="Nov" />
                    &nbsp;
                    <input type="button" id="abr" name="12" style="width:50px;" onclick="atribuiData(this)" value="Dec" />                                                            
           		</div>                
                  
                 
                  
                                                                         
            </div>
          	<div class="col-xs-12 col-md-6">
                <div class="row">
                  <label for="tags">Fecha</label>
                  <input type='text' id='dataFinal' name='dataFinal' size='23' placeholder="dd-mm-aaaa" value="<?php echo date("m-Y"); ?>" readonly>
                </div>             
            </div>             
            <div class="col-xs-12">
            	<div class="row form-group">
             		<a id="btnRecarregar" type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Siguiente') ?></a>
           		</div>
            </div>                          
        </div>      
      </form>
    </div>
  </div>
</div>
</div>


<script>
	//
	function atribuiData(obj)
	{
		//
		mes = obj.name;
		ano = $("#txtAno").val();
		
		dataSelecionada = mes + "-" + ano;
		//alert(dataSelecionada);	
		
		$("#dataFinal").val(dataSelecionada);
		
	}
	
	
	//
	function somaMes()
	{
		//
		anoAtual = $("#txtAno").val();
		anoNovo = eval(anoAtual) + 1;
		
		$("#txtAno").val(anoNovo);
	}
	
	
	//
	function restaMes()
	{
		//
		anoAtual = $("#txtAno").val();
		anoNovo = eval(anoAtual) - 1;
		
		$("#txtAno").val(anoNovo);
	}	
	
	//
	$("#btnRecarregar").click( function ()
	{
		//envia formulario
		$("#formInfoEstRes" ).submit();
	});		
	
</script>

