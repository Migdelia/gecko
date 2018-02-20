<div class="button-wrap">
	<!--- 
        <a id="expexc" class="btn"><?php echo _('Exportar Excel') ?></a>
        <a id="exppdf" class="btn"><?php echo _('Exportar PDF') ?></a>
	--->



    <?php
		//verifica se é dispositivo
		if($filenameID !== "Dispositivos")
		{
			//verifica se nao é administrador
			if($_SESSION['usr_nivel'] <> 9)	
			{				
	?>
			<a href="#" class="btn" data-toggle="modal" data-target="#add-modal-cierre"><i class="fa fa-plus"></i> <?php echo _('Nuevo Cierre ') ?></a>
    <?php
			}
		}
	?>    
    
</div>