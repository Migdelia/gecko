<?php
session_start();
include('../conn/conn.php');
include('validaLogin.php');

$descricao = $_POST['cent_cust'];	
$vl_dec = $_POST['valor'];	
$desc = $_POST['descricao'];
$tp_doc = $_POST['tipo_doc'];
$num_doc = $_POST['numero_doc'];
$ope = $_POST['oper'];

if($ope == "suporte")
{
		$ope = $_SESSION['id_login'];
		$numLf = $_POST['num_lf'];
		$tpLf = $_POST['tp_lf'];
	
		if($tpLf == 1)
		{
			$flag_leit = 1;
			$flag_fecha = 0;
		}
		else
		{
			$flag_leit = 0;
			$flag_fecha = 1;			
		}
		
		$sql_add = "INSERT INTO 
							desconto_leit_fecha 
							(
								id_descricao,
								id_leitura_fechamento,
								valor_desconto,
								leitura,
								fechamento,
								data_desconto,
								descricao,
								tipo_doc,
								num_doc,
								id_maquina,
								id_login
							) 
							VALUES
							(
								'".$descricao."',
								'".$numLf."',
								'".$vl_dec."',
								'".$flag_leit."',
								'".$flag_fecha."',
								'".date('Y-m-d')."',
								'".$desc."',
								'".$tp_doc."',
								'".$num_doc."',
								'0',
								'".$ope."'						
							)";		
	
}
else
{
	$sql_add = "INSERT INTO 
						desconto_leit_fecha 
						(
							id_descricao,
							id_leitura_fechamento,
							valor_desconto,
							leitura,
							fechamento,
							data_desconto,
							descricao,
							tipo_doc,
							num_doc,
							id_maquina,
							id_login
						) 
						VALUES
						(
							'".$descricao."',
							'0',
							'".$vl_dec."',
							'0',
							'1',
							'".date('Y-m-d')."',
							'".$desc."',
							'".$tp_doc."',
							'".$num_doc."',
							'0',
							'".$ope."'						
						)";	
}


						
						
	
	

if(@mysql_query($sql_add))
{
	$retorno="true";
}else{
	$retorno="false";
}

$sql_ult_id ="SELECT max(id_desconto) as ult_id FROM desconto_leit_fecha";
$query_desp_ins = @mysql_query($sql_ult_id);
$resultado=@mysql_fetch_assoc($query_desp_ins);	

if($retorno == "true")
{
	$retorno .= "/".$resultado['ult_id'];
}
//exit(utf8_encode("false"));

echo $retorno;
?>