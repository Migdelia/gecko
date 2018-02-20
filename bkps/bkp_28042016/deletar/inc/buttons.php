<div class="button-wrap">


	<?php if ($filenameID == 'Lecturas') : ?>
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<a href="#" class="btn"><?php echo _('Repetir Lectura') ?></a>
			<a href="#" class="btn"><?php echo _('Importación Online') ?></a>
			<a href="#" class="btn"><?php echo _('Importación Archivo X') ?></a>
		</div>
	<?php else : ?>
		<a href="#" class="btn"><?php echo _('Exportar Excel') ?></a>
		<a href="#" class="btn"><?php echo _('Exportar PDF') ?></a>
		<a href="#" class="btn" data-toggle="modal" data-target="#add-modal-<?php echo $filenameID ?>"><i class="fa fa-plus"></i> <?php echo _('Agregar ') . $filenameID ?></a>
	<?php endif; ?>

</div>