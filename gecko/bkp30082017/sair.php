<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');

//Gravando dados no log de acessos
$dados = array('login'=>$_SESSION['usuario'],'senha'=>$_SESSION['passw'],'status'=>'logoff','link'=>$_SERVER['REQUEST_URI']);
log_acesso( $dados );
@mysql_close($conecta);

session_destroy();
header('Location:'.$dominio);
echo "<script>window.location='index.php'</script>";
exit("<a href='index.php' title='Sair do sistema'><strong><img src='img/proximo.png' title='Sair do sistema' align='absmiddle' border=none alt='Sair do sistema' />Sair do Sistema</strong></a>");
?>