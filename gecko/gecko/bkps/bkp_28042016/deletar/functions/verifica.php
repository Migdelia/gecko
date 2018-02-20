<?php
session_start();
include('../conn/conn.php');
include('functions.php');


//if( ($_POST['inputEmail']!='')&&($_POST['inputPassword']!='') )
//verifica se ingresso nome de usuario
if( ($_POST['inputEmail']!=''))
{
	
	//criptografa senha para comparar 
	$senhaCrip = md5($_POST['inputPassword']);

	//consulta usuario
	$sql_usuario = @mysql_query("SELECT logins.id_login,logins.id_nivel, logins.usuario, logins.nome FROM logins WHERE md5(logins.usuario)='".md5($_POST['inputEmail'])."' AND logins.excluido='N'");	
	$existe_usuario = @mysql_fetch_assoc($sql_usuario);
	
	//verifica usuario
	if( ($_POST['inputEmail']==$existe_usuario['usuario']))
	{
		$flag = 1;
		
		//consulta senha
		$sql = @mysql_query("SELECT logins.id_login,logins.id_nivel, logins.usuario, logins.nome, logins.senha, logins.email FROM logins WHERE md5(logins.usuario)='".md5($_POST['inputEmail'])."' AND md5(logins.senha)='".md5($senhaCrip)."' AND logins.excluido='N'");	
		$existe = @mysql_fetch_assoc($sql);		
		
		//verifica usuario e senha
		if( ($_POST['inputEmail']==$existe['usuario'])&&(md5($senhaCrip)==md5($existe['senha'])) )
		{
			$_SESSION['usuario'] = $_POST['inputEmail'];
			$_SESSION['id_login'] = $existe['id_login'];
			$_SESSION['passw'] = $senhaCrip;
			$_SESSION['nome'] = $existe['nome'];
			$_SESSION['usr_nivel'] = $existe['id_nivel'];
			$_SESSION['email'] = $existe['email'];
	
			//Montando a Variavel de Acesso aos locais que o usuario Possui
			$sql_reg="SELECT acesso_local.id_local FROM acesso_local LEFT JOIN local ON local.id_local=acesso_local.id_local WHERE	acesso_local.id_nivel=".$existe['id_nivel']." AND local.excluido='N'";
			$query_reg = @mysql_query($sql_reg);
			$_SESSION['reg_acesso']="";
			while ($regionais = @mysql_fetch_assoc($query_reg) ) {
				$_SESSION['reg_acesso'].= "'".$regionais['id_local']."',";
			}
			$_SESSION['reg_acesso']=substr($_SESSION['reg_acesso'],0,-1);
			
			//Gravando dados no log de acessos
			$dados = array('login'=>$_POST['inputEmail'],'senha'=>$senhaCrip,'status'=>'sucesso','link'=>$_SERVER['REQUEST_URI']);
			log_acesso( $dados );
			$flag = 2;		
		}
	}
	else
	{
		//Gravando dados no log de acessos
		$dados = array('login'=>$_POST['inputEmail'],'senha'=>$senhaCrip,'status'=>'falha','link'=>$_SERVER['REQUEST_URI']);
		log_acesso( $dados );
		session_destroy();
		$flag = 0;
	}
}
else
{
	//Gravando dados no log de acessos
	$dados = array('login'=>$_POST['inputEmail'],'senha'=>$senhaCrip,'status'=>'falha','link'=>$_SERVER['REQUEST_URI']);
	log_acesso( $dados );
	session_destroy();

	
	//verifica se a senha esta vazia
	if($_POST['inputPassword']!='') //os dois
	{
		$flag = 3; 	
	}
	else //so a senha
	{
		$flag = 4; 	
	}

}
echo $flag;
?>
