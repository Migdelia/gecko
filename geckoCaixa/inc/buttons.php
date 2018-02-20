<div class="button-wrap">
	
	<?php  switch ($filenameID) : ?>
<?php case 'Lecturas': ?>
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<a href="#" class="btn"><?php echo _('Repetir Lectura') ?></a>
			<a href="#" class="btn"><?php echo _('Importación Online') ?></a>
			<a href="#" class="btn"><?php echo _('Importación Archivo X') ?></a>
		</div>
	<?php break; ?>
	<?php case 'Ver-informe-cierre': ?>
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<a href="#" class="btn"><?php echo _('Rendição F') ?></a>
			<a href="#" class="btn"><?php echo _('Rendição V') ?></a>
			<a href="#" class="btn" data-toggle="modal" data-target="#download-informe-cierre-modal"><?php echo _('Guardar Informe') ?></a>
		</div>
	<?php break; ?>
	<?php case 'Informe-cierre': ?>
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<a href="#" class="btn"><?php echo _('Crear Informe') ?></a>
			<a href="#" class="btn"><?php echo _('Exportar PDF') ?></a>
		</div>
	<?php break; ?>
	<?php case 'Informe-promedio-maquinas': ?>
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<a href="#" class="btn"><?php echo _('Exportar Excel') ?></a>
			<a href="#" class="btn"><?php echo _('Exportar PDF') ?></a>
		</div>
	<?php break; ?>
	<?php case 'Cajas-controles': ?>
	<?php case 'Cajas-relatorios-caja': ?>
	<?php case 'Cajas-relatorios': ?>
	<?php case 'Home-cajas-detalles': ?>
	<?php case 'Home-cajas': ?>
		<div class="btn-group" role="group" aria-label="Button group with nested dropdown">
			<a href="#" class="btn"><?php echo _('Exportar PDF') ?></a>
		</div>
	<?php break; ?>
	<?php case 'Cajas-manutencion': ?>

	<?php break; ?>
	<?php default: ?>
		<a href="#" class="btn"><?php echo _('Exportar Excel') ?></a>
		<a href="#" class="btn"><?php echo _('Exportar PDF') ?></a>
		<a href="#" class="btn" data-toggle="modal" data-target="#add-modal-<?php echo $filenameID ?>"><i class="fa fa-plus"></i> <?php echo _('Agregar ') . $filenameID ?></a>
	<?php break; ?>
	<?php endswitch; ?>
</div>
