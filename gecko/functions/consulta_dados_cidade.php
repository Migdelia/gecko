<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idCidade = $_POST['id'];	


$return = "";

//busca dados do disp
$sql_cidade = "
	SELECT
		*				
	FROM
		regiao
	WHERE
		id_cidade = " . $idCidade;
$query_cidade=@mysql_query($sql_cidade);
$res_cidade=@mysql_fetch_assoc($query_cidade);

//echo $sql_disp; [0]
$return .= $res_cidade['nome_cidade'] . ",";


//muda a nomenclatura
if($res_cidade['excluido'] == 'N')
{
	$return .= "Activo,"; //[1]	
}
else
{
	$return .= "Inactivo,";//[1]	
}

$return .= $res_cidade['id_cidade'] . ",";//[2]	




//consultar quantidade de locais dessa cidade
$sql_qtd_locais = "
	SELECT 
		id_local,
		nome
	FROM
		`local`
	WHERE
		id_regiao = ".$res_cidade['id_cidade']."
	AND
		excluido = 'N'";
$query_qtd_locais=@mysql_query($sql_qtd_locais);
//$res_qtd_locais=@mysql_fetch_assoc($query_qtd_locais);


//
$i = 0;
while($res_qtd_locais=@mysql_fetch_assoc($query_qtd_locais)) 
{
	//
	$return .= $res_qtd_locais['nome'] . "|";//[3]
	$i++;
}
$return .= "," . $i;//[4]



//$return .= $res_qtd_locais['qtd_locais'];//[3]	



echo $return;

?>