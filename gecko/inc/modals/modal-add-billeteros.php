<?php $modal_item = "Billetero" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class=" fa fa-times"></i></button>
        <h5><i class="fa fa-plus"></i> <?php echo _('Agregar Nuevo ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos del nuevo Billetero.</p>
        <form class="form-horizontal" method="post" action="functions/addBilheteiro.php">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="row form-group">
                <label for="input_serie<?php echo $modal_item ?>" class="control-label"><?php echo _('Serie') ?></label>
                <input type="text" class="form-control" id="add_serie_<?php echo $modal_item ?>" name="add_serie_<?php echo $modal_item ?>" placeholder="<?php echo _('Serie') ?>" value="">
              </div>
			  <div class="row form-group">
                <label for="add_maquina<?php echo $modal_item ?>" class="control-label"><?php echo _('Maquina') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_maquina_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Maquina') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_maquina_<?php echo $modal_item ?>" name="hd_maquina_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                
                <?php
					//consulta cidades
					$sql_maquinas = "
						SELECT
							numero
						FROM
							maquinas
						WHERE
							excluido = 'N'
						ORDER BY
							numero
						";	
					
					
					$query_maquinas=@mysql_query($sql_maquinas);
					
					//
					while($res_maquinas=@mysql_fetch_assoc($query_maquinas)) 
					{
				?>
                      <li>
                        <a href="#" class="mass-act" id="maquina_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);"><?php echo _($res_maquinas['numero']) ?></a>
                      </li>                
                <?php
					}								
				?>
                

                </ul>
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
			  <div class="row form-group">
                <label for="input_modelo<?php echo $modal_item ?>" class="control-label"><?php echo _('Modelo') ?></label>
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_modelo_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo _('Modelo') ?><div class="ripple-container"></div></a>
                <input type="hidden" id="hd_modelo_<?php echo $modal_item ?>" name="hd_modelo_<?php echo $modal_item ?>" value="" />
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">

                <?php
					//consulta cidades
					$sql_modelos = "
						SELECT
							*
						FROM
							modelos_bilheteiro
						";	
					
					
					$query_modelos=@mysql_query($sql_modelos);
					
					//
					while($res_modelos=@mysql_fetch_assoc($query_modelos)) 
					{
				?>
                          <li>
                            <a href="#" class="mass-act" id="modelo_<?php echo $modal_item ?>" onclick="atribuiValorIns(this);"><?php echo _($res_modelos['descricao']) ?></a>
                          </li>                
                <?php
					}								
				?>             


                </ul>
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
                <a id="btnAddBill" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
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
	function atribuiValorIns(obj)
	{
		$('#input_'+obj.id).text(obj.text);
		$('#hd_'+obj.id).attr("value", obj.text);	
	}
	
	//
	$('#btnAddBill').click(function()
	{
		//
		var serieBill = $('#add_serie_Billetero').val();
		var maqBill = $('#hd_maquina_Billetero').val();	
		var modBill = $('#hd_modelo_Billetero').val();								

		// 
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/addBilheteiro.php', // Informo a URL que será pesquisada.
			data: 'add_serie_Billetero='+serieBill+'&hd_maquina_Billetero='+maqBill+'&hd_modelo_Billetero='+modBill,
			success: function(html)
			{
				//alert(html);
				if(html == true)
				{
					$('#add-modal-Billeteros').fadeOut("slow");
					$('#msgConfirm').text('Registro Inserido con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#add-modal-Billeteros').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para inserir el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}				
			}

		});
	});		
</script>