<?php
//declara valores QR
$id_disp = $_GET['xx'];
$entrada = $_GET['yy'];
$saida = $_GET['zz'];

session_start();
include('../conn/conn.php');
include('functions.php');

//Gravando dados no log de acessos
$dados = array('login'=>$_SESSION['usuario'],'senha'=>$_SESSION['passw'],'status'=>'logoff','link'=>$_SERVER['REQUEST_URI']);
log_acesso( $dados );
@mysql_close($conecta);

session_destroy();


header('Location:'.$dominio.'/indexQrLeit.php?xx=' . $id_disp . "&yy=" . $entrada . "&zz=" . $saida);
echo "<script>window.location='indexQrLeit.php?xx=" . $id_disp . "&yy=" . $entrada . "&zz=" . $saida ."'</script>";
exit("<a href='indexQrLeit.php?xx=" . $id_disp . "&yy=" . $entrada . "&zz=" . $saida ."' title='Sair do sistema'><strong><img src='img/proximo.png' title='Sair do sistema' align='absmiddle' border=none alt='Sair do sistema' />Sair do Sistema</strong></a>");

?>