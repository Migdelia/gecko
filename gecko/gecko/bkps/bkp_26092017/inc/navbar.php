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
          <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Busca') ?>">
        </div>
      </form>
      <div class="timer hide-on-med-and-down">
        <div class="text"><?php echo _('Tiempo de Expiración: ') ?></div>
        <div class="digit"><span id="ms_timer"></span></div>
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
              <img class="img-responsive circle" src="img/perfil/1.jpg" alt="avatar">
            </div>
            <div class="user">
              <div class="username"><?php echo _('Usuário: ') . $_SESSION['nome']?></div>
              <div class="usermail"><?php echo $_SESSION['email'] ?></div>
            </div>
          </a>
          <ul class="dropdown-menu">
            <li><a href="perfil.php"><?php echo _('Perfil') ?></a></li>
        <!--<li class="divider"></li>
            <li><a href="#"><?php echo _('Configuração') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Relatorios') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Sistema') ?></a></li>
            <li class="divider"></li>
            <li><a href="#"><?php echo _('Consulta') ?></a></li> -->
          </ul>
        </li>
        <li class="logout">
          <a class="btnoff" href="functions/sair.php"><i class="fa fa-power-off"></i> <div class="text"><?php echo _('Fechar sessão') ?></div></a>
        </li>
      </ul>
    </div>
  </div>
</div>

<script>
	$(function(){
		$('#ms_timer').countdowntimer({
			minutes :40,
			seconds : 0,
			size : "lg"
		});
	});
	
	setTimeout(function()
	{
		//mata sessao
		$.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/fechaSessao.php', // Informo a URL que será pesquisada.
			data: '',
			success: function(html)
			{ 
				//mudar o contador (#ms_timer) por um aviso 
				$('#ms_timer').text("Sesión Expirada");			
			}
		});
	},2402000);	//20 min e 2 segundos
	
</script>
