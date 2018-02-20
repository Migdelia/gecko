<?php
//declara senha QR
$senhaQR = $_GET['s'];	
$codVer = $_GET['v'];	

session_start();
include('../conn/conn.php');
include('functions.php');

//Gravando dados no log de acessos
$dados = array('login'=>$_SESSION['usuario'],'senha'=>$_SESSION['passw'],'status'=>'logoff','link'=>$_SERVER['REQUEST_URI']);
log_acesso( $dados );
@mysql_close($conecta);

session_destroy();

if($senhaQR == NULL)
{
	header('Location:'.$dominio);
	echo "<script>window.location='index.php'</script>";
	exit("<a href='index.php' title='Sair do sistema'><strong><img src='img/proximo.png' title='Sair do sistema' align='absmiddle' border=none alt='Sair do sistema' />Sair do Sistema</strong></a>");	
}
else
{
	header('Location:'.$dominio.'/index.php?s=' . $senhaQR . "&v=" . $codVer);
	echo "<script>window.location='index.php?s=" . $senhaQR . "&v=" . $codVer ."'</script>";
	exit("<a href='index.php?s=" . $senhaQR . "&v=" . $codVer ."' title='Sair do sistema'><strong><img src='img/proximo.png' title='Sair do sistema' align='absmiddle' border=none alt='Sair do sistema' />Sair do Sistema</strong></a>");
}

?>