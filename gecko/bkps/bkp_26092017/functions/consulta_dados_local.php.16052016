<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$idLocal = $_POST['id'];	


$return = "";

//busca dados do loc
$sql_local = "
	SELECT
		*				
	FROM
		local
	WHERE
		id_local = " . $idLocal;
$query_local=@mysql_query($sql_local);
$res_local=@mysql_fetch_assoc($query_local);

//echo $sql_disp; [0]
$return .= $res_local['id_local'] . ",";
$return .= $res_local['rut'] . ",";
$return .= $res_local['nome'] . ",";
$return .= $res_local['razao_social'] . ",";
$return .= $res_local['inclusao'] . ",";
$return .= $res_local['ordem'] . ",";

//formata status
if($res_local['excluido'] == 'N')
{
	$status = "Activo";
}
else
{
	$status = "Inactivo";
}

$return .= $status . ",";
$return .= $res_local['endereco'] . ",";
$return .= $res_local['responsavel'] . ",";
$return .= $res_local['contato'] . ",";

//busca dados do ope
$sql_ope = "
	SELECT
		nome				
	FROM
		logins
	WHERE
		id_login = " . $res_local['id_login'];
$query_ope=@mysql_query($sql_ope);
$res_ope=@mysql_fetch_assoc($query_ope);


$return .= $res_ope['nome'] . ",";
$return .= $res_local['percentual'] . ",";

//busca nome da cidade
$sql_cid = "
	SELECT
		nome_cidade				
	FROM
		regiao
	WHERE
		id_cidade = " . $res_local['id_regiao'];
$query_cid=@mysql_query($sql_cid);
$res_cid=@mysql_fetch_assoc($query_cid);

$return .= $res_cid['nome_cidade'] . ",";


//busca nome da cidade
$sql_tpLoc = "
	SELECT
		tp_local			
	FROM
		tipo_local
	WHERE
		id_tp_local = " . $res_local['id_tp_local'];
$query_tpLoc=@mysql_query($sql_tpLoc);
$res_tpLoc=@mysql_fetch_assoc($query_tpLoc);

$return .= $res_tpLoc['tp_local'] . ",";

//consulta nome gerente
$sql_ger = "
	SELECT
		nome				
	FROM
		logins
	WHERE
		id_login = " . $res_local['id_gerente'];
$query_ger=@mysql_query($sql_ger);
$res_ger=@mysql_fetch_assoc($query_ger);

$return .= $res_ger['nome'] . ",";
$return .= $res_local['pct_operador'] . ",";
$return .= $res_local['pct_gerente'];


echo $return;

?>