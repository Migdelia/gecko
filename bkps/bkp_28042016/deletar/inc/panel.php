<div class="dashboard">
	<div class="row">
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-6">
			<div class="panel first">
				<div class="panel-heading">
					<i class="fa fa-tachometer"></i> <?php echo _('Máquinas sin lectura') ?>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th><?php echo _('Nº de la máquina') ?></th>
									<th class="center-align"><?php echo _('Nombre del Local') ?></th>
									<th class="center-align"><?php echo _('Última Lectura') ?></th>
									<th class="center-align"><?php echo _('Acciones') ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>VM-100</td>
									<td class="center-align">Blue Space</td>
									<td class="center-align">02 - 03 - 2015</td>
									<td class="center-align">
									<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
										<a href="#" class="btn btn-raised btn-sm" data-toggle="modal" data-target="#maqnolectura-modal"><?php echo _('Ver') ?></a>
									</div>
									</td>
								</tr>
								<tr>
									<td>VM-200</td>
									<td class="center-align">Blue Space</td>
									<td class="center-align">02 - 03 - 2015</td>
									<td class="center-align">
									<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
										<a href="#" class="btn btn-raised btn-sm" data-toggle="modal" data-target="#maqnolectura-modal"><?php echo _('Ver') ?></a>
									</div>
									</td>
								</tr>
								<tr>
									<td>VM-300</td>
									<td class="center-align">Blue Space</td>
									<td class="center-align">02 - 03 - 2015</td>
									<td class="center-align">
									<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
										<a href="#" class="btn btn-raised btn-sm" data-toggle="modal" data-target="#maqnolectura-modal"><?php echo _('Ver') ?></a>
									</div>
									</td>
								</tr>
								<tr>
									<td>VM-400</td>
									<td class="center-align">Blue Space</td>
									<td class="center-align">02 - 03 - 2015</td>
									<td class="center-align">
									<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
										<a href="#" class="btn btn-raised btn-sm" data-toggle="modal" data-target="#maqnolectura-modal"><?php echo _('Ver') ?></a>
									</div>
									</td>
								</tr>
								<tr>
									<td>VM-500</td>
									<td class="center-align">Blue Space</td>
									<td class="center-align">02 - 03 - 2015</td>
									<td class="center-align">
									<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
										<a href="#" class="btn btn-raised btn-sm" data-toggle="modal" data-target="#maqnolectura-modal"><?php echo _('Ver') ?></a>
									</div>
									</td>
								</tr>
								<tr>
									<td>VM-600</td>
									<td class="center-align">Blue Space</td>
									<td class="center-align">02 - 03 - 2015</td>
									<td class="center-align">
									<div class="btn-group btn-group-justified" role="group" aria-label="Justified button group">
										<a href="#" class="btn btn-raised btn-sm" data-toggle="modal" data-target="#maqnolectura-modal"><?php echo _('Ver') ?></a>
									</div>
									</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-6">
			<div class="panel second">
				<div class="panel-heading">
					<i class="fa fa-line-chart"></i> <?php echo _('Ingreso por local de la última semana') ?>
				</div>
				<div class="panel-body">
					<div id="graph-incomes" class="graphitem"></div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-6">
			<div class="panel third">
				<div class="panel-heading">
					<i class="material-icons">store</i> <?php echo _('Locales integrados') ?>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th colspan="2"><?php echo _('Locales') ?></th>
									<th class="right-align"><?php echo _('En línea') ?></th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Local #01</td>
									<td></td>
									<td class="right-align">Online</td>
								</tr>
								<tr>
									<td>Local #02</td>
									<td></td>
									<td class="right-align">Online</td>
								</tr>
								<tr>
									<td>Local #03</td>
									<td></td>
									<td class="right-align">Online</td>
								</tr>
								<tr>
									<td>Local #04</td>
									<td></td>
									<td class="right-align">Online</td>
								</tr>
								<tr>
									<td>Local #05</td>
									<td></td>
									<td class="right-align">Online</td>
								</tr>
								<tr>
									<td>Local #06</td>
									<td></td>
									<td class="right-align">Online</td>
								</tr>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-6">
			<div class="panel fourth">
				<div class="panel-heading">
					<i class="fa fa-bar-chart"></i> <?php echo _('Promedio de máquinas última semana') ?>
				</div>
				<div class="panel-body">
					<div id="graph-averages" class="graphitem"></div>
				</div>
			</div>
		</div>
	</div>
</div>