<div class="sidebar col-xs-12 col-sm-3">
	<h2 class="titlemenu"><?php echo _('Menú') ?> <div class="arrow right"></div></h2>
	<div class="main-menu btn-group-vertical">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

			<!-- Menú Inicio -->
			<div class="panel">
				<div class="panel-heading menu-item" role="tab" id="menuHome">
					<a href="home.php" class="btn btn-raised"><i class="fa fa-home"></i> <?php echo _('Inicio') ?></a>
				</div>
			</div>
			<!-- menú Estructura -->
			<div class="panel">
				<div class="panel-heading menu-item" role="tab" id="menuStruct">
					<a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseStruct" aria-expanded="false" aria-controls="collapseStruct"><i class="material-icons">web</i> <?php echo _('Estructura') ?></a>
				</div>
				<div id="collapseStruct" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menuStruct">
					<div class="list-group">
						<a href="ciudades.php" class="list-group-item"><span><?php echo _('Ciudades') ?></span></a>
						<a href="locales.php" class="list-group-item"><span><?php echo _('Locales') ?></span></a>


							<div class="panel-heading menu-item" role="tab" id="menuMaquina">
								<a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#menuMaquina" href="#collapseMaquina" aria-expanded="false" aria-controls="collapseMaquina"><i class="fa fa-diamond"></i> <?php echo _('Máquinas') ?></a>
							</div>
							<div id="collapseMaquina" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menuMaquina">
								<div class="list-group">
									<a href="maquinas.php" class="list-group-item"><span><?php echo _('Detalle') ?></span></a>
									<a href="#" class="list-group-item"><span><?php echo _('Ipsum') ?></span></a>
									<a href="#" class="list-group-item"><span><?php echo _('Dolor') ?></span></a>
									<a href="#" class="list-group-item"><span><?php echo _('Sit') ?></span></a>
								</div>
							</div>


							<a href="dispositivos.php" class="list-group-item"><span><?php echo _('Dispositivos de seguridad') ?></span></a>
							<a href="juegos.php" class="list-group-item"><span><?php echo _('Juegos') ?></span></a>
						</div>
					</div>
				</div>
				<!-- menú Operaciones -->
				<div class="panel">
					<div class="panel-heading menu-item" role="tab" id="menuOperat">
						<a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOperat" aria-expanded="false" aria-controls="collapseOperat"><i class="fa fa-gear"></i> <?php echo _('Operaciones') ?></a>
					</div>
					<div id="collapseOperat" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menuOperat">
						<div class="list-group">
							<a href="lectura.php" class="list-group-item"><span><?php echo _('Lectura') ?></span></a>
							<a href="cierre.php" class="list-group-item"><span><?php echo _('Cierre') ?></span></a>
						</div>
					</div>
				</div>
				<!-- menú Informes -->
				<div class="panel">
					<div class="panel-heading menu-item" role="tab" id="menuInform">
						<a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseInform" aria-expanded="false" aria-controls="collapseInform"><i class="fa fa-info-circle"></i> <?php echo _('Informes') ?></a>
					</div>
					<div id="collapseInform" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menuInform">
						<div class="list-group">
							<a href="lecturas.php" class="list-group-item"><span><?php echo _('Lecturas') ?></span></a>
							<a href="informe-cierre.php" class="list-group-item"><span><?php echo _('Cierres') ?></span></a>
							<a href="informe-promedio-maquinas.php" class="list-group-item"><span><?php echo _('Promedio Máquinas') ?></span></a>
							<a href="#" class="list-group-item"><span><?php echo _('Operadores') ?></span></a>
						</div>
					</div>
				</div>
				<!-- menú Sistema -->
				<div class="panel">
					<div class="panel-heading menu-item" role="tab" id="menuSist">
						<a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseSist" aria-expanded="false" aria-controls="collapseSist"><i class="material-icons">perm_data_setting</i> <?php echo _('Sistema') ?></a>
					</div>
					<div id="collapseSist" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menuSist">
						<div class="list-group">
							<a href="usuarios.php" class="list-group-item"><span><?php echo _('Usuarios') ?></span></a>
							<a href="niveles.php" class="list-group-item"><span><?php echo _('Niveles') ?></span></a>
							<a href="financieros.php" class="list-group-item"><span><?php echo _('Financiero') ?></span></a>
						</div>
					</div>
				</div>
				<!-- menú Consultas -->
				<div class="panel">
					<div class="panel-heading menu-item" role="tab" id="menuConsul">
						<a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseConsul" aria-expanded="false" aria-controls="collapseConsul"><i class="material-icons cons">search</i> <?php echo _('Consultas') ?></a>
					</div>
					<div id="collapseConsul" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menuConsul">
						<div class="list-group">
							<a href="#" class="list-group-item"><span><?php echo _('Locales') ?></span></a>
							<a href="#" class="list-group-item"><span><?php echo _('Máquinas') ?></span></a>
							<a href="lectura.php" class="list-group-item"><span><?php echo _('Lectura') ?></span></a>
							<a href="#" class="list-group-item"><span><?php echo _('Cierre') ?></span></a>
							<a href="#" class="list-group-item"><span><?php echo _('Dispositivo de seguridad') ?></span></a>
							<a href="usuarios-consulta.php" class="list-group-item"><span><?php echo _('Usuarios') ?></span></a>
						</div>
					</div>
				</div>
				<!-- menú Soporte -->
				<!-- <div class="panel">
					<div class="panel-heading menu-item" role="tab" id="menuHome">
						<a href="#" class="btn btn-raised"><i class="fa fa-desktop"></i> <?php echo _('Soporte') ?></a>
					</div>
				</div> -->
				<!-- menú Locales integrados -->
				<div class="panel">
					<div class="panel-heading menu-item" role="tab" id="menuIntegrados">
						<a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseIntegrados" aria-expanded="false" aria-controls="collapseIntegrados"><i class="material-icons cons">store</i> <?php echo _('Locales integrados') ?></a>
					</div>
					<div id="collapseIntegrados" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menuIntegrados">
						<div class="list-group">
							<a href="mapa-local.php" class="list-group-item"><span><?php echo _('Mapa') ?></span></a>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
