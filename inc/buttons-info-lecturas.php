<div class="button-wrap">
    
       
        <?php  
         if ($result_id_local['fechada'] == 0 AND $id_assoc == $lectura1 ) 
         {
        echo     "<a href='#' class='btn' data-toggle='modal' data-target='#select-periodo3' id='eliminar-leitura' title='Eliminar Lectura'> <i class='fa fa-trash' style='font-size:20px;'></i></a>";
        }

         if ($result_id_local['fechada'] == 0 ) 
         {
                echo     "<a href='lectura-detalle.edit.php?id=$id_assoc' class='btn'  id='edit-lectura' title='Editar Lectura' ><i class='fa fa-pencil' style='font-size:20px;'></i></a>";
                echo     "<a href='#' class='btn' data-toggle='modal' data-target='#select-periodo' id='perido-leitura' title='Seleccionar Período'> <i class='fa fa-calendar' style='font-size:20px;'></i></a>";
        }
        ?>
              
        
       <a href="lectura-edit-configuracion.php?id=<?=$id_assoc?>"; class='btn'  id='btn-lectura' title='Editar configuración Lectura' ><i class='fa fa-gears' style="font-size:20px;"></i></a>
       <a id="exppdf" class="btn" title="Imprimir/PDF" > <i class="fa fa-print" style="font-size:20px;"></i> <?php echo _('Imprimir / PDF') ?></a>
        
         
</div>