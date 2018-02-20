<div class="button-wrap">
        <a id="expexc" class="btn"><i class="fa fa-download"></i> <?php echo _('Exportar Excel') ?></a>
        <a id="exppdf" class="btn"> <i class="fa fa-file"></i> <?php echo _('Exportar PDF') ?></a>




    <?php
		//verifica se é dispositivo
		if($filenameID !== "Dispositivos")
		{
			//verifica se nao é administrador
			if($_SESSION['usr_nivel'] <> 9 or $_SESSION['usr_nivel'] <> 8)
			{
					
	?>
			<a href="#" class="btn" data-toggle="modal" data-target="#add-modal-<?php echo $filenameID ?>"><i class="fa fa-plus"></i> <?php echo _('Insertar ') . $filenameID ?></a>
    <?php
			}
		}
	?>    
    
</div>