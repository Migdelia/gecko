<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$nomeCidade = $_POST['input_edit_Ciudad'];
$status = $_POST['status_Ciudad'];
$id_cidade = $_POST['id_cidade_atual'];


//muda a nomenclatura
if($status == 'Activo')
{
	$return .= "N";	
	$statusBD = "N";	
}
else
{
	$return .= "S";	
	$statusBD = "S";
}



//atualiza cidade
$sql_up = "UPDATE 
				regiao
			SET
				nome_cidade = '".$nomeCidade."',
				excluido = '".$statusBD."'
			WHERE
				id_cidade = '".$id_cidade."'";
				
		
				
if(@mysql_query($sql_up) )
{
	//
	//header('Location: ../ciudades.php');
	exit(utf8_encode(true));
}else{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}

?>