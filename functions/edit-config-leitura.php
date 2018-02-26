<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');


$id_fechamento = $_POST['id_fechamento'];
$login = $_POST['id_login'];
$operador = $_POST['id_operador'];
$gerente = $_POST['id_gerente'];
$admin = $_POST['id_admin'];
$fechada = $_POST['fechada'];
$por_gerente = $_POST['por_gerente'];
$por_local = $_POST['por_local'];
$por_operador = $_POST['por_operador'];
$semana = $_POST['semana'];
$id_tipo_local = $_POST['id_tipo_local'];
$dia_fecha = $_POST['dia_fecha'];
$id_leitura = $_POST['id_leitura'];


$semSelecionada = $semana;
if($semSelecionada == "")
{
	$semSelecionada = 0;
}

$dataRef = date("Y-m-d", strtotime($dia_fecha));




$sql_update_conf="UPDATE 
		leitura
	     SET 
		id_fechamento = '".$id_fechamento."',
		id_login = '".$login."',
		id_gerente = '".$gerente."',
		id_operador = '".$operador."',
		id_admin = '".$admin."',
		id_tipo_local = '".$id_tipo_local."',
		semana = '".$semSelecionada."',
		data_fechamento = '".$dataRef."',
		pct_local = '".$por_local."',
		pct_operador = '".$por_operador."',
		pct_gerente = '".$por_gerente."'
	WHERE
		id_leitura = ".$id_leitura;

//echo $sql_update_conf;

if(@mysql_query($sql_update_conf) )
{
	//xit(utf8_encode(1));
}else{
	exit(utf8_encode(0));
}


   $sql_insert_historico= "INSERT INTO 
   					historico_edicion_lectura(
						fecha,
						id_login,
						subtotal_ant,
						subtotal_nuevo,
						tipo_operacion,
						id_leitura_ant,
						id_leitura_nuevo
						) 
				VALUES(
						'".date("Y-m-d")."',
						'".$_SESSION['id_login']."',
						'0',
						'0',
						'Edicion Configuracion Lectura',
						'0',
						".$id_leitura."		
						)";

    if(@mysql_query($sql_insert_historico) )
		{
			exit(utf8_encode(1));
		}
		else
		{
			exit(utf8_encode(0));
		}





?>