<div class="button-wrap">
        <!---<a id="expexc" class="btn"><?php //echo _('Exportar Excel') ?></a>
        <a id="exppdf" class="btn"><?php //echo _('Exportar PDF') ?></a>--->




    <?php
		//verifica se é dispositivo
		if($filenameID !== "Dispositivos")
		{
	?>
			<a id="btnAddCierre" href="#" class="btn" data-toggle="modal" data-target="#add-modal-<?php echo $filenameID ?>"><i class="fa fa-plus"></i> <?php echo _('Inserir ') . $filenameID ?></a>
    <?php
		}
	?>    
    
</div>