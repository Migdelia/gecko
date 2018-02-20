<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="url" content="http://www.sogesp.com.br/">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="descrição" content="SOGESP - Associação de Obstetrícia e Ginecologia do Estado de São Paulo" />
	<meta name="robots" content="noindex,nofollow">
	<title>..::Administrativo - Painel Principal::..</title>
	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=http://www.inscricaofacil.com.br/nojavascript.html" />
	</noscript>
</head>
<body style='background-color:#FFA766'>
	<div id='painel'>
		<p class="usr"><?php echo substr($_SESSION['nome'],0,15)?></p>
		<div id='icones'>
			<?php
				echo painel_builder();
			?>
		</div>
		<!---
		<div id="estatistica">
			<?php
				include('estatistica.php');
			?>
		</div>
        --->
	</div>
</body>
</html>
