<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


//
$numero = $_POST['input_EditNum_Interface'];
$serie = $_POST['inputEdit_serie_Interface'];
$jogo = $_POST['input_jogo_Interface'];
$maquina = $_POST['input_maquina_Interface'];

//
$sql_jogo = "SELECT id_jogo FROM jogo WHERE nome = '" . $jogo . "'";
$query_jogo=@mysql_query($sql_jogo);
$res_jogo=@mysql_fetch_assoc($query_jogo);


//
$sql_maquina = "SELECT id_maquina FROM maquinas WHERE numero = ". $maquina;
$query_maquina=@mysql_query($sql_maquina);
$res_maquina=@mysql_fetch_assoc($query_maquina);


//atualiza interface
$sql_up = "UPDATE 
				interface
			SET
				id_maquina = '".$res_maquina['id_maquina']."',
				id_jogo = '".$res_jogo['id_jogo']."',
				serie = '".$serie."'
			WHERE
				numero = '".$numero."'";
				
		
				
if(@mysql_query($sql_up) )
{
	//sleep(1);
	//
	//header('Location: ../interfaces.php');
	exit(utf8_encode(true));
}else{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}

?>