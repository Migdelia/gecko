<!-- modal-actions.php -->
<a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" class="btn"><?php echo _('Acción masiva') ?><div class="ripple-container"></div></a>
<a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
<ul class="dropdown-menu">
	<li>
		<a href="#" class="mass-act" data-toggle="modal" data-target="#massaction-modal-leituraOnline"><?php echo _('Lectura Online') ?></a>
	</li>
	<li class="divider"></li>
	<li>
		<a href="#" class="mass-act" data-toggle="modal" data-target="#massaction-modal-repLeitura"><?php echo _('Repetir Lectura') ?></a>
	</li>
    <!---
	<li class="divider"></li>
	<li>
		<a href="#" class="mass-act" data-toggle="modal" data-target="#massaction-modal"><?php echo _('Action 3') ?></a>
	</li>
    -->
</ul>

<?php include("inc/modals/modal-actions-repLectura.php"); // modal alerta acciones másivas ?>
<?php include("inc/modals/modal-actions-leituraOnline.php"); // modal alerta acciones másivas ?>