<div class="navbar navbar-info">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-warning-collapse">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="home.php">
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
      <div class="timer hide-on-med-and-down">
        <div class="text"><?php echo _('Tiempo de expiración: ') ?></div>
        <div class="digit">10:00</div>
      </div>
      <ul class="nav navbar-nav navbar-right">
        <li class="dropdown language">
          <a href="#" data-target="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa fa-flag"></i> <div class="text"><?php echo _('Idioma') ?></div> <b class="caret"></b></a>
          <ul class="dropdown-menu">
            <li><a href="#"><?php echo _('Español') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Inglés') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Portugués') ?></a></li>
          </ul>
        </li>
        <li class="dropdown usermenu">
          <a href="#" data-target="#" class="dropdown-toggle left" data-toggle="dropdown">
            <div class="avatar">
              <img class="img-responsive circle" src="http://lorempixel.com/56/56/people/1" alt="avatar">
            </div>
            <div class="user">
              <div class="username">Guille González</div>
              <div class="usermail">g.gonzalez@gecko.cl</div>
            </div>
          </a>
          <ul class="dropdown-menu">
            <li><a href="perfil.php"><?php echo _('Perfil') ?></a></li>
        <!--<li class="divider"></li>
            <li><a href="#"><?php echo _('Configuración') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Informes') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Sistema') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Consulta') ?></a></li> -->
          </ul>
        </li>
        <li class="logout">
          <a class="btnoff" href="index.php"><i class="fa fa-power-off"></i> <div class="text"><?php echo _('Cerrar Sesión') ?></div></a>
        </li>
      </ul>
    </div>
  </div>
</div>
