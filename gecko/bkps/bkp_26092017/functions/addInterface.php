<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$numero = $_POST['input_num_Interface'];
$jogo = $_POST['input_game_Interface'];
$serie = $_POST['input_serie_Interface'];


//consulta o id do jogo
$sql_jogo = "SELECT id_jogo FROM jogo WHERE nome = '". $jogo ."'";
$query_jogo=@mysql_query($sql_jogo);
$res_jogo=@mysql_fetch_assoc($query_jogo);

$jogo = $res_jogo['id_jogo'];



//Verifica se o numero de interface já existe
$sql_en = "SELECT interface.* FROM interface WHERE interface.numero='".$numero."' LIMIT 1";
$query_en=@mysql_query($sql_en);
$num_reg = @mysql_num_rows($query_en);

$sql_add = "INSERT INTO 
				interface (numero,data_inclusao,id_jogo,excluido,serie) 
			VALUES('".$numero."','".date('Y-m-d')."','".$jogo."','N','".$serie."')";

//verifica se ja foi cadastrada
if($num_reg == 0)
{
	//
	if(@mysql_query($sql_add) )
	{
		//sleep(1);
		//header('Location: ../interfaces.php');
		exit(utf8_encode(true));
	}else{
		//exit(utf8_encode('ERRO!'));
		exit(utf8_encode(false));
	}			
}
else
{
	exit(utf8_encode("existe"));
}





?>