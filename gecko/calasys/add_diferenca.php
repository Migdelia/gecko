<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$idMaqDif = $_POST['id_maq'];	
$vlDifMaq = $_POST['valorDif'];
$descrDif = $_POST['motivo'];


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
							'5',
							'0',
							'".$vlDifMaq."',
							'1',
							'0',
							'".date('Y-m-d')."',
							'".$descrDif."',
							'',
							'',
							'".$idMaqDif."',
							'".$_SESSION['id_login']."'						
						)";
						
				
	

if(@mysql_query($sql_add) )
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


echo $retorno;
?>
