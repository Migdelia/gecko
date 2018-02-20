<?php $modal_item = "Interface" // ingresar la palabra clave de cada modal ?>
<div id="add-modal-<?php echo $modal_item ?>s" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Agregar Nueva ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">
        <p>Ingrese los datos de la nueva Interface.</p>
        <form class="form-horizontal" method="post" action="">
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('Número Interface') ?></label>
              <div class="row form-group">
                <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('Número Interface') ?></label>
                <input type="text" class="form-control" id="input_num_<?php echo $modal_item ?>" name="input_num_<?php echo $modal_item ?>" placeholder="<?php echo _('Número Interface') ?>" value="">
              </div>
              
              
              <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('Serie') ?></label>
              <div class="row form-group">
                <label for="input_idmaq<?php echo $modal_item ?>" class="control-label"><?php echo _('Serie') ?></label>
                <input type="text" class="form-control" id="input_serie_<?php echo $modal_item ?>" name="input_serie_<?php echo $modal_item ?>" placeholder="<?php echo _('Serie') ?>" value="">
              </div>              
              
              
            </div>
            <div class="col-xs-12 col-md-6">



              <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Juego ') ?></label>
              <div class="row form-group">
                <label for="input_user<?php echo $modal_item ?>" class="control-label"><?php echo _(' Juego ') ?></label>
                <input type="hidden" id="input_game_<?php echo $modal_item ?>" name="input_game_<?php echo $modal_item ?>" value="" >
                <a href="#" data-target="#" name="" data-toggle="dropdown" aria-expanded="false" id="select_game_<?php echo $modal_item ?>" name="select_game_<?php echo $modal_item ?>" class="btn dropdown-btn">
                    <div class="ripple-container" id="respUser"></div>
                </a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                	<span class="caret"></span>
                    <div class="ripple-container"></div>
               	</a>
                <ul class="dropdown-menu">
                
                
                <?php 
					//consulta nome dos usuarios
					$sql_jogo = "
						SELECT
							*
						FROM
							jogo
						ORDER BY
							nome
						";
						
					$query_jogo=@mysql_query($sql_jogo);
					
					//mostra todos usuarios
					while($res_jogo=@mysql_fetch_assoc($query_jogo)) 
					{						
				?>
                      <li>
                        <a href="#" class="mass-act" id="game_<?php echo _( $res_jogo['id_jogo'] ) ?>" onclick="atribuiValor(this);"><?php echo _( $res_jogo['nome'] ) ?></a>
                      </li>
                      <li class='divider'></li>
                <?php
					}
				?>
                </ul>
              </div> 




            </div>
          </div>
          <div class="row form-group">
            <div class="col-xs-12">
                <a id="btnAddInt" href="#" class="btn btn-sm btn-raised col-xs-12 col-md-5 right" data-toggle="modal" data-target="#confirm-modal">
                    <?php echo _('Crear Nuevo ') . $modal_item ?>
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
	$('#btnAddInt').click(function()
	{
		//
		var numInterface = $('#input_num_Interface').val();
		var jogoInterface = $('#input_game_Interface').val();	
		var serInterface = $('#input_serie_Interface').val();						

		// 
		jQuery.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/addInterface.php', // Informo a URL que será pesquisada.
			data: 'input_num_Interface='+numInterface+'&input_game_Interface='+jogoInterface+'&input_serie_Interface='+serInterface,
			success: function(html)
			{
				//alert(html);
				if(html == 'existe')
				{
					$('#add-modal-Interfaces').fadeOut("slow");
					$('#msgConfirm').text('Esta Interface foi cadastrada anteriormente!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');	
					
					//nao atualizar a pagina					
				}
				else if(html == true)
				{
					$('#add-modal-Interfaces').fadeOut("slow");
					$('#msgConfirm').text('Registro Inserido con Sucesso!');
					$('#imgConfirm').attr('src', 'img/checked.png');
				}
				else
				{
					$('#add-modal-Interfaces').fadeOut("slow");
					$('#msgConfirm').text('Error! Problema para inserir el Registro!');
					$('#imgConfirm').attr('src', 'img/input-wrong.png');									
				}				
			}

		});
	});
</script>