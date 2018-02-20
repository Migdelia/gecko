<div class="row">
              <div class="col-xs-12 col-lg-6">
                <h3 class="main-title">
                  <span class="fa-stack fa-md">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-money fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Caja') ?>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-6">
                <?php include("inc/buttons.php"); // btns paneles ?>
              </div>
            </div>
	<div class="row">
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-12">
			<div class="panel first">
				<div class="panel-heading">
					Fecha: <?php echo date('d-m-Y') ?>
				</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-hover">
							<thead>
								<tr>
									<th><?php echo _('Id Caixa') ?></th>
									<th class="left-align"><?php echo _('Nome') ?></th>
									<th class="left-align"><?php echo _('Data Abertura') ?></th>
									<th class="left-align"><?php echo _('Data Fechamento') ?></th>
									<th class="left-align"><?php echo _('Entrada') ?></th>
									<th class="left-align"><?php echo _('Saida') ?></th>
									<th class="left-align"><?php echo _('Pagos') ?></th>
									<th class="left-align"><?php echo _('Cierres') ?></th>
								</tr>
							</thead>
							<tbody>
								<?php for ($i=0; $i < 15; $i++): ?>
									<tr class="row_caja_id" id="<?php echo $i; ?>" onDblClick="window.location='home-cajas-detalles.php'">
										<td><?php echo 'SKU- '. rand(0,999);?></td>
										<td class="left-align">Caja</td>
										<td class="left-align"><?php echo date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))); ?></td>
										<td class="left-align"><?php echo date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))); ?></td>
										<!-- <td class="left-align">John Doe</td> -->
										<td class="left-align"><?php echo  '$ '.number_format(rand(0,9999), 2, ',', '.');?></td>
										<td class="left-align"><?php echo '$'.rand(0,9999);?></td>
										<td class="left-align"><?php echo '$'.rand(0,9999);?></td>
										<td class="left-align"><?php echo '$'.rand(0,9999);?></td>
									</tr>
								<?php endfor; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>