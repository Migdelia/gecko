<div class="dashboard">
	<div class="row">
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12 col-md-12">
			<div class="panel first">
				<div class="panel-heading">
					<strong><?php echo _('Caja') ?>: <?php echo 'SKU- '. rand(0,999);?></strong>
				</div>
				<div class="panel-body">
					<div class="table-responsive">.
                    
                       
                       </div>
					<!-- 
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
									<tr class="row_caja_id" id="<?php echo $i; ?>">
										<td><?php echo 'SKU- '. rand(0,999);?></td>
										<td class="left-align">Caja</td>
										<td class="left-align"><?php echo date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))); ?></td>
										<td class="left-align"><?php echo date('d-m-Y H:i:s', rand(strtotime(date('d-m-Y H:i:s')), strtotime('d-m-Y H:i:s'))); ?></td>
										<td class="left-align"><?php echo  '$ '.number_format(rand(0,9999), 2, ',', '.');?></td>
										<td class="left-align"><?php echo '$'.rand(0,9999);?></td>
										<td class="left-align"><?php echo '$'.rand(0,9999);?></td>
										<td class="left-align"><?php echo '$'.rand(0,9999);?></td>
									</tr>
								<?php endfor; ?>
							</tbody>
						</table>
					</div>
 -->
				</div>
			</div>
		</div>
	</div>
</div>