<div class="button-wrap">

       
        <?php  
         if ($result_id_local['fechada'] == 0 AND $id_assoc == $lectura1 ) 
         {
        echo     "<a href='#'' class='btn' data-toggle='modal' data-target='#select-periodo3' id='eliminar-leitura' title='Eliminar Lectura'> <i class='fa fa-trash'></i> Eliminar Lectura </a>";
        }

         if ($result_id_local['fechada'] == 0 ) 
         {
         echo     "<a href='#'' class='btn' data-toggle='modal' data-target='#select-periodo2' id='edit-lectura' title='Editar Lectura' ><i class='fa fa-pencil'></i> Editar Lectura </a>";
         echo     "<a href='#'' class='btn' data-toggle='modal' data-target='#select-periodo' id='perido-leitura' title='Seleccionar Período'> <i class='fa fa-calendar'></i> Seleccionar Período</a>";
        }
        ?>
              
        
        <!-- <a id="expexc" class="btn"><i class="fa fa-file"></i> <?php echo _('Exportar Excel') ?></a> -->
        <a id="exppdf" class="btn" title="Imprimir/PDF" > <i class="fa fa-print"></i> <?php echo _('Imprimir / PDF') ?></a>
        
        <?php
		/*
        //verifica se nao é administrador
        if($_SESSION['usr_nivel'] <> 9)
        {        
        ?>
			
            <a href="#" class="btn" data-toggle="modal" data-target="#add-modal-Lectura">
                <i class="fa fa-plus"></i>
                <?php echo _('Crear Lectura')?>
            </a>
        
        <?php
		}*/
		?>        
</div>