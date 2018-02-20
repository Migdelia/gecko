<div class="container-fluid">
	<div class="row">
		<div class="col-xs-12 col-md-12 col-lg-12 ">
			<div class="row">
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="grid-1">
						<div class="thumbnail grid-item maquina1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/1.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 1</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina2 red lighten-1">
							<a href="#" data-target="#modal-Creditar-Maquinas" data-toggle="modal">
								<img src="img/2.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 2</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina3 blue lighten-1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/3.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 3</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina4 yellow lighten-1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/4.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 4</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina5 green lighten-1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/5.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 5</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina1">
							<a href="#" data-target="#modal-cajas-lista-2" data-toggle="modal">
								<img src="img/1.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 1</p>
							</a>
						</div>
					</div>
				</div>
				<div class="col-xs-12 col-md-6 col-lg-6">
					<div class="grid-1">
						<div class="thumbnail grid-item maquina1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/1.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 1</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina2 red lighten-1">
							<a href="#" data-target="#modal-Creditar-Maquinas" data-toggle="modal">
								<img src="img/2.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 2</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina3 blue lighten-1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/3.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 3</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina4 yellow lighten-1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/4.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 4</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina5 green lighten-1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/5.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 5</p>
							</a>
						</div>
						<div class="thumbnail grid-item maquina1">
							<a href="#" data-target="#modal-cajas-maquina-estado<?php echo $status=rand(1,6);?>" data-toggle="modal">
								<img src="img/1.png" class="<?php echo $status;?>">
								<p class="black-text">Máquina 1</p>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-xs-10">
		<div class="button-group filter-button-group">
			<button data-filter="*" class="btn">Mostrar todos</button>
			<button data-filter=".maquina1" class="btn">Máquina 1</button>
			<button data-filter=".maquina2" class="btn">Máquina 2</button>
			<button data-filter=".maquina3" class="btn">Máquina 3</button>
			<button data-filter=".maquina4, .maquina5" class="btn">Máquina 4 y 5</button>
		</div>
	</div>
	<div class="col-xs-2">
		<a href="#" class="btn" data-target="#modal-cajas-lista" data-toggle="modal">Caja abierta</a>
	</div>
</div>
