<!-- modal-actions.php -->
<a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" class="btn"><?php echo _('Ação Massiva') ?><div class="ripple-container"></div></a>
<a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
<ul class="dropdown-menu">
	<li id="<?php echo _('Desativar') ?>" onclick="acaoMassiva(this);">
		<a href="#" class="mass-act" data-toggle="modal" data-target="#massaction-modal"><?php echo _('Desativar') ?></a>
	</li>
	<li class="divider"></li>
	<li id="<?php echo _('Trocar Nivel') ?>" onclick="acaoMassiva(this);">
		<a href="#" class="mass-act" data-toggle="modal" data-target="#massaction-modal"><?php echo _('Trocar Nivel') ?></a>
	</li>
</ul>

<?php include("inc/modals/modal-actions.php"); // modal alerta acciones másivas ?>