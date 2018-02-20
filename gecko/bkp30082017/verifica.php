<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');

if( ($_POST['login']!='')&&($_POST['senha']!='') ){
	
	//criptografa senha para comparar 
	$senhaCrip = md5($_POST['senha']);


	$sql = @mysql_query("SELECT logins.id_login,logins.id_nivel, logins.usuario, logins.nome, logins.senha FROM logins WHERE md5(logins.usuario)='".md5($_POST['login'])."' AND md5(logins.senha)='".md5($senhaCrip)."' AND logins.excluido='N'");
	$existe = @mysql_fetch_assoc($sql);
	if( ($_POST['login']==$existe['usuario'])&&(md5($senhaCrip)==md5($existe['senha'])) ){
		$_SESSION['usuario'] = $_POST['login'];
		$_SESSION['id_login'] = $existe['id_login'];
		$_SESSION['passw'] = $senhaCrip;
		$_SESSION['nome'] = $existe['nome'];
		$_SESSION['usr_nivel'] = $existe['id_nivel'];

		//Montando a Variavel de Acesso aos locais que o usuario Possui
		$sql_reg="SELECT acesso_local.id_local FROM acesso_local LEFT JOIN local ON local.id_local=acesso_local.id_local WHERE	acesso_local.id_nivel=".$existe['id_nivel']." AND local.excluido='N'";
		$query_reg = @mysql_query($sql_reg);
		$_SESSION['reg_acesso']="";
		while ($regionais = @mysql_fetch_assoc($query_reg) ) {
			$_SESSION['reg_acesso'].= "'".$regionais['id_local']."',";
		}
		$_SESSION['reg_acesso']=substr($_SESSION['reg_acesso'],0,-1);
		
		//Gravando dados no log de acessos
		$dados = array('login'=>$_POST['login'],'senha'=>$senhaCrip,'status'=>'sucesso','link'=>$_SERVER['REQUEST_URI']);
		log_acesso( $dados );
		
		$jsc ="<script language='javascript' type='text/javascript'>";
		$jsc.="\n\twindow.location='main.php';";
		$jsc.="\n</script>";
		$des ="<a href='main.php' title='Acessar o sistema' style='text-decoration:none'><strong><img src='img/alerta.png' title='Acessar o sistema' align='absmiddle' border=none alt='Acessar o sistema' /> Acessar o sistema</strong></a>";
	}else{
		//Gravando dados no log de acessos
		$dados = array('login'=>$_POST['login'],'senha'=>$senhaCrip,'status'=>'falha','link'=>$_SERVER['REQUEST_URI']);
		log_acesso( $dados );

		session_destroy();
		$jsc ="<script language='javascript' type='text/javascript'>";
		$jsc.="\n\talert('Dados Incorretos.');";
		$jsc.="\n\twindow.location='sair.php';";
		$jsc.="\n</script>";
		$des ="<a href='index.php' title='Sair do sistema' style='text-decoration:none'><strong><img src='img/alerta.png' title='Sair do sistema' align='absmiddle' border=none alt='Sair do sistema' /> Sair do Sistema</strong></a>";
	}
}else{
	//Gravando dados no log de acessos
	$dados = array('login'=>$_POST['login'],'senha'=>$senhaCrip,'status'=>'falha','link'=>$_SERVER['REQUEST_URI']);
	log_acesso( $dados );

	session_destroy();
	$jsc ="<script language='javascript' type='text/javascript'>";
	$jsc.="\n\talert('Dados Incorretos.');";
	$jsc.="\n\twindow.location='sair.php';";
	$jsc.="\n</script>";
	$des ="<a href='index.php' title='Sair do sistema' style='text-decoration:none'><strong><img src='img/alerta.png' title='Sair do sistema' align='absmiddle' border=none alt='Sair do sistema' /> Sair do Sistema</strong></a>";
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="url" content="<?php echo $dominio ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="<?php echo $description?>" />
	<meta name="robots" content="noindex,nofollow">
	<title>..::Administrativo - <?php echo $description?> ::..</title>
	<!--<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />-->
	<link rel="icon" href="img/favicon.gif" type="image/gif" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
	<?php
		echo $jsc;
	?>
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=<?php echo $dominio ?>/nojavascript.html" />
	</noscript>
</head>
<body>
	<div style="width:200px;left:50%;margin-left:-100px;position:absolute;margin-top:120px;">
		<?php
		exit($des);
		?>
	</div>
</body>
</html>