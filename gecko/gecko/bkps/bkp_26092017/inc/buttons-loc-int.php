<div class="button-wrap">
     	 <span class="main-title">desde:</span>
         <input type='text' id='dataInicio' name='dataInicio' size='23' value="<?php echo date('d-m-Y'); ?>" style="width:90px; margin-left:30px; margin-right:30px;" readonly>
		 <span class="main-title">hasta:</span>
         <input type='text' id='dataFim' name='dataFim' size='23' value="<?php echo date('d-m-Y'); ?>" style="width:90px; margin-left:30px; margin-right:30px;" readonly>         
        <!---
        <a id="expexc" class="btn"><?php echo _(date('d-m-Y')) ?></a>
        Hasta:
        <a id="exppdf" class="btn"><?php echo _('Exportar PDF') ?></a>--->




    <?php
		/*
		//verifica se é dispositivo
		if($filenameID !== "Dispositivos")
		{
	?>
			<a href="#" class="btn" data-toggle="modal" data-target="#add-modal-<?php echo $filenameID ?>"><i class="fa fa-plus"></i> <?php echo _('Inserir ') . $filenameID ?></a>
    <?php
		}*/
	?>    
    
</div>

<script>
	$(function() {
		$("#dataInicio").datepicker({dateFormat: 'dd-mm-yy'});
	});
	
	$(function() {
		$("#dataFim").datepicker({dateFormat: 'dd-mm-yy'});
	});	

</script>