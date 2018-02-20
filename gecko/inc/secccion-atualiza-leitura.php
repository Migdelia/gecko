<?php
session_start();
include('../functions/validaLoginQrLeit.php');

?>

<div class="dashboard">
	<div class="row">
        <!-- Panel dashboard 01 -->
        <div class="col-xs-12">
            <div class="panel validateScreen">
                <div class="panel-heading" align="center">
                   <i class="fa fa-pencil"></i> <?php echo _('Actualizacion de Lectura') ?>
                </div>
                
                
                <?php
					//
					if($retorno == 1)
					{
				?>
                
                        <div class="panel-body">
                            <div class="validate row" align="center">
            
                                <strong>Dispositivo:</strong> <?php echo $id_disp;?>
                                <br />
                                <br />
                                <strong>Entrada:</strong> <?php echo "$ " . number_format($entrada,0,"",".");?>
                                <br />
                                <br />
                                <strong>Saida:</strong> <?php echo "$ " . number_format($saida,0,"",".");?>
                                <br />
                                <br />
                                <img src="img/checked.png" />
                                <br />
                                <br />
                            </div>
                            <div class="row">
                               <div class="col-xs-12 col-md-4 col-md-offset-4">
                                <a id="btn_importaOutra" class="btn btn-raised btn-block"><?php echo _('Importar Otra') ?></a>
                                </div>
                            </div>
                        </div>                

                
                <?php
					}
					else
					{
				?>
                
                
                        <div class="panel-body">
                            <div class="validate row" align="center">
            
                                <strong>Lectura Invalida!</strong>
                                <br />
                                <br />
                                <img src="img/Sem título.png" width="100" />
                                <br />
                                <br />
                            </div>
                            <div class="row">
                               <div class="col-xs-12 col-md-4 col-md-offset-4">
                                <a id="btn_importaOutra" class="btn btn-raised btn-block"><?php echo _('Importar Otra') ?></a>
                                </div>
                            </div>
                        </div>          
          
                
                <?php
					}                
                ?>
                                

            </div>
		</div>
	</div>
</div>
<script type="text/javascript" charset="utf-8">
	jQuery(document).ready( function( $ ) {

		$('#btn_importaOutra').click(function(){

			//
			openedWindow.close();
			
		});
	});

</script>  