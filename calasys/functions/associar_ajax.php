<?php
session_start();
include('../conn/conn.php');
include('../functions/functions.php');
include('../functions/lg_validador.php');
$erro= "";

//Tratando as informações
foreach($_POST as $chave=>$valor){
	$_POST[$key] = mysql_real_escape_string(strip_tags($value));
}

//Verficando se o cartao informado existe e se esta associado a algum cliente
$sql = "SELECT * FROM cartao WHERE cartao=".$_POST['value']." AND inativo<>1 AND id_cliente=0";
$query=@mysql_query($sql);
$regs = @mysql_num_rows($query);

if ( $regs==1){
	//Verificando se o cliente ja possui um cartao ativo
	$sql = "SELECT * FROM cartao WHERE id_cliente=".base64_decode($_POST['idt'])." AND inativo=0";
	$query=@mysql_query($sql);
	$regs_c = @mysql_num_rows($query);
	if ( $regs_c==1){
		$erro = "O Cliente ja possui cartao ativo";
	}
}else{
	$erro = "Este cartao ja foi utilizado";
}

//Caso nao ocorram erros, grava a informaçao
if ($erro=='') {
	if (@mysql_query("UPDATE cartao SET cartao.id_cliente='".base64_decode($_POST['idt'])."' WHERE cartao.cartao=".$_POST['value']." ") ) {
		//Pegando o Dado depois de atualizado para exibir para o usuario.
		$dado_exibir=@mysql_result(@mysql_query("SELECT cartao.cartao FROM cartao  WHERE cartao.cartao=".$_POST['value']." "),0);		
		//Retirada a mensagem “cadastro alterado com sucesso” para cada alteraçao. Solicitado por e-mail em 11/01
		/*echo $dado_exibir."<script language='javascript'>alert('Atualizado com sucesso!.');</script>";*/
		echo $dado_exibir;
	}else{
		echo "<script language='javascript'>alert('".$erro."');</script>";
		$dado_exibir=@mysql_result(@mysql_query("SELECT cartao.cartao FROM cartao  WHERE cartao.cartao=".$_POST['value']." "),0);
		echo $dado_exibir;
	}
}else{
	echo "<script language='javascript'>alert('".$erro."');</script>";
	$dado_exibir=@mysql_result(@mysql_query("SELECT cartao.cartao FROM cartao  WHERE cartao.cartao=".$_POST['value']." "),0);
	echo $dado_exibir;
}
?>