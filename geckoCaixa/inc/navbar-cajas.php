<div class="navbar navbar-info">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-warning-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home-isotope.php">
        <img src="<?php echo $imgurl ?>/logotipo.png" class="visible-xs" alt="gecko">
        <img src="<?php echo $imgurl ?>/logotipo-desktop.png" class="hidden-xs" alt="gecko">
      </a>
    </div>
    <div class="navbar-collapse collapse navbar-warning-collapse">
      <form id="busqueda" class="navbar-form navbar-left hide-on-med-and-down">
        <div class="form-group">
          <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
        </div>
      </form>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown usermenu">
          <a href="#" data-target="#" class="dropdown-toggle left" data-toggle="dropdown">
            <div class="avatar">
              <img class="img-responsive circle" src="http://lorempixel.com/56/56/people/1" alt="avatar">
            </div>
            <div class="user">
              <div class="username" style="font-size : 10px;">Guille González</div>
              <div class="usermail" style="font-size : 10px;">g.gonzalez@gecko.cl</div>
            </div>
          </a>
          <ul class="dropdown-menu">
            <li><a href="perfil.php"><?php echo _('Perfil') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Configuración') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Informes') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Sistema') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Consulta') ?></a></li>
          </ul>
        </li>

        <li class="dropdown usermenu">
          <a href="#" data-target="#" class="dropdown-toggle left" data-toggle="dropdown" style="height:96px;">
            <div class="avatar">
              <i class="fa fa-money"></i>
            </div>
            <div class="user">
              <div class="username" style="font-size : 10px;"><?php echo _('Opciones de Caja: ') ?></div>
              <div class="usermail" style="font-size : 10px;"></div>
            </div>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#" data-target="#modal-cajas-opciones-caja-historico" data-toggle="modal"><?php echo _('Histórico de pagos') ?></a></li>
            <li class="divider"></li>
            <li><a href="#" data-target="#modal-cajas-opciones-caja-orden" data-toggle="modal"><?php echo _('Orden de máquina') ?></a></li>
            <li class="divider"></li>
            <li><a href="home-isotope.php"><?php echo _('Actualizar') ?></a></li>
            <!-- <li><a href="#" data-target="#modal-cajas-opciones-caja-actualizar" data-toggle="modal"><?php echo _('Actualizar') ?></a></li> -->
            <li class="divider"></li>
            <li><a href="#" data-target="#modal-cajas-opciones-caja-entradasalida" data-toggle="modal"><?php echo _('Entrada/Salida') ?></a></li>
            <li class="divider"></li>
          </ul>
        </li>

        <li class="logout">
          <a class="btnoff-caja" href="#index.php" ><i class="fa fa-usd"></i><div class="text" style="font-size : 10px;"><?php echo _('Saldo ').rand(999,9999) ?></div></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<?php include("inc/modals/modal-cajas-lista.php"); ?>
