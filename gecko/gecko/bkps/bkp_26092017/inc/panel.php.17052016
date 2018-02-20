<?php
//consulta as dez maquinas a mais tempo sem leitura.
$sql_maq_sin_leitura = "
SELECT
	vw_maquinas.id_maquina,
	vw_maquinas.numero,
	vw_maquinas.nome,
	vw_maquinas.id_ultima_leitura,
	leitura.`data`
FROM
	vw_maquinas
INNER JOIN
	leitura
ON
	vw_maquinas.id_ultima_leitura = leitura.id_leitura
WHERE
	vw_maquinas.excluido = 'N'
AND
	vw_maquinas.id_ultima_leitura > 1
ORDER BY
	vw_maquinas.id_ultima_leitura
LIMIT
	7
	";	


$query_maq_sin_leitura=@mysql_query($sql_maq_sin_leitura);
$limitRegistros = mysql_num_rows($query_maq_sin_leitura);


?>

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
									<th><a href="#"><?php echo _('Máquina') ?></a></th>
									<th class="center-align"><a href="#"><?php echo _('Nombre del Local') ?></a></th>
									<th class="center-align"><a href="#"><?php echo _('Última Lectura') ?></a></th>
									<th class="center-align"><a href="#"><?php echo _('Acciones') ?></a></th>
								</tr>
							</thead>
							<tbody>
                            
							<?php
								while($res_maq_sin_leitura=@mysql_fetch_assoc($query_maq_sin_leitura)) 
								{
									echo "<tr>";
									echo "<td>".$res_maq_sin_leitura['numero']."</td>";
									echo "<td class='center-align'>".$res_maq_sin_leitura['nome']."</td>";
									echo "<td class='center-align'>".date("d-m-Y", strtotime($res_maq_sin_leitura['data']))."</td>";
									echo "<td class='center-align'>
										<a href='#' class='btn btn-raised btn-sm' data-toggle='modal' data-target='#maqnolectura-modal'> Ver </a>
									</td>";
									echo "</tr>";
								}						
							?>                            

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
									<th colspan="2"><a href="#"><?php echo _('Locales') ?></a></th>
									<th class="right-align"><a href="#"><?php echo _('En línea') ?></a></th>
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