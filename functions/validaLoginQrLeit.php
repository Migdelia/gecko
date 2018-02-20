<?php

//
$id_disp = $_GET['xx'];
$entrada = $_GET['yy'];
$saida = $_GET['zz'];

$cmd = "
	SELECT 
		logins.id_nivel, 
		logins.usuario, 
		logins.nome, 
		logins.senha 
	FROM 
		logins 
	WHERE 
		md5(logins.usuario)='".md5($_SESSION['usuario'])."' 
		AND md5(logins.senha)='".md5($_SESSION['passw'])."' 
		AND logins.excluido='N'
	";

$sql = @mysql_query($cmd);
$existe = @mysql_fetch_assoc($sql);



if( ($_SESSION['usuario']==$existe['usuario'])&&(md5($_SESSION['passw'])==md5($existe['senha']))&&($_SESSION['usuario']!='')&&($_SESSION['passw']!='') ){
	$_SESSION['usr_nivel'] = $existe['id_nivel'];

	//Montando a Variavel de Acesso as Regionais que o usuario Possui
	$sql_reg="SELECT acesso_local.id_local FROM acesso_local LEFT JOIN local ON local.id_local=acesso_local.id_local WHERE	acesso_local.id_nivel=".$existe['id_nivel']." AND local.excluido='N'";
	$query_reg = @mysql_query($sql_reg);
	$_SESSION['reg_acesso']="";
	while ($regionais = @mysql_fetch_assoc($query_reg) ) {
		$_SESSION['reg_acesso'].= "'".$regionais['id_local']."',";
	}
	$_SESSION['reg_acesso']=substr($_SESSION['reg_acesso'],0,-1);

	//Verifica se pagina tem controle de acesso.
	$script = $_SERVER['SCRIPT_NAME'];
	$file = explode('/',$script);
	$arquivo = $file[count($file)-1];
	
	$query_pg = @mysql_query("SELECT * FROM menu WHERE link='".$arquivo."'");
	$result_pg= @mysql_fetch_assoc($query_pg);
	
	if(@mysql_num_rows( $query_pg ) >= 1) {
		//Verificando se o nivel do usuario permite visualizar a pagina
		$sql_a = "
			SELECT
				*
			FROM
				acesso
			WHERE 
				id_menu='".$result_pg['id_menu']."'
				AND id_nivel= '".$_SESSION['usr_nivel']."'
				AND acesso='S'
			";
		$query_a = @mysql_query($sql_a);
		if ( (@mysql_num_rows($query_a)== 0)||(strtoupper($result_pg['excluido'])=='S') ) {
			header("Location:functions/sairQrLeit.php?xx=" .$id_disp ."&yy=".$entrada . "&zz=".$saida."");
		}
	}
}else{
	session_destroy();
	$jsc ="<script language='javascript' type='text/javascript'>";
	

	$jsc.="\n\twindow.location.href='functions/sairQrLeit.php?xx=" .$id_disp ."&yy=".$entrada . "&zz=".$saida."'";
	$jsc.="\n</script>";
	$des ="<a href='index.php' title='Sair do sistema' style='text-decoration:none'><strong><img src='img/alerta.png' title='Sair do sistema' align='absmiddle' border=none alt='Sair do sistema' /> Sair do Sistema</strong></a>";
	exit($jsc);
}
?>