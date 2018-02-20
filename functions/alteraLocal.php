<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

//
$idLocal = $_POST['edit_id_Local'];
$cidade = $_POST['edit_cidade_Local'];
$tpLocal = $_POST['edit_tipo_Local'];
$razaoSocial = $_POST['edit_rs_Local'];
$pctLocal = $_POST['edit_pct_Local'];
$nome = $_POST['edit_nome_Local'];
$rut = $_POST['edit_rut_Local'];
$inclusao = $_POST['edit_incluido_Local'];
$ordem = $_POST['edit_orden_Local'];
$operador = $_POST['edit_ope_Local'];
$gerente = $_POST['edit_ger_Local'];
$comGerente = $_POST['edit_comGer_Local'];
$comOperador = $_POST['edit_comOpe_Local'];
$endereco = $_POST['edit_end_Local'];
$responsavel = $_POST['edit_resp_Local'];
$contato = $_POST['edit_cont_Local'];
$statusLoc = $_POST['edit_status_Local'];
$admin = $_POST['edit_admin_Local'];

//trata valores
if($statusLoc == "Activo")
{
	$status = "N";
}
else
{
	$status = "S";
}


//consulta id do operador
$sql_usuario = "
	SELECT
		id_login
	FROM
		logins
	WHERE
		nome = '".$operador."'
	";
$query_usuario=@mysql_query($sql_usuario);
$result_usuario=@mysql_fetch_assoc($query_usuario);

$operador = $result_usuario['id_login'];


//consulta id da cidade
$sql_cidade = "
	SELECT
		id_cidade
	FROM
		regiao
	WHERE
		nome_cidade = '".$cidade."'
	";
$query_cidade=@mysql_query($sql_cidade);
$result_cidade=@mysql_fetch_assoc($query_cidade);

$cidade = $result_cidade['id_cidade'];




//consulta id do operador
$sql_tipo = "
	SELECT
		id_tp_local
	FROM
		tipo_local
	WHERE
		tp_local = '".$tpLocal."'
	";
$query_tipo=@mysql_query($sql_tipo);
$result_tipo=@mysql_fetch_assoc($query_tipo);

$tpLocal = $result_tipo['id_tp_local'];



//consulta id do gerente
$sql_usuario = "
	SELECT
		id_login
	FROM
		logins
	WHERE
		nome = '".$gerente."'
	";
$query_usuario=@mysql_query($sql_usuario);
$result_usuario=@mysql_fetch_assoc($query_usuario);

$gerente = $result_usuario['id_login'];


//consulta id do administrador
$sql_adm = "
	SELECT
		id_login
	FROM
		logins
	WHERE
		nome = '".$admin."'
	";
$query_adm=@mysql_query($sql_adm);
$result_adm=@mysql_fetch_assoc($query_adm);

$admin = $result_adm['id_login'];


/*
echo "ID local: " . $idLocal . "<br>";
echo "cidade: " . $cidade . "<br>";
echo "Tipo local: " . $tpLocal . "<br>";
echo "Razao social: " . $razaoSocial . "<br>";
echo "% Local: " . $pctLocal . "<br>";
echo "Nome Local: " . $nome . "<br>";
echo "RUT: " . $rut . "<br>";
echo "inclusao: " . $inclusao . "<br>";
echo "ordem: " . $ordem . "<br>";
echo "Operador: " . $operador . "<br>";
echo "Gerente: " . $gerente . "<br>";
echo "Com Gerente: " . $comGerente . "<br>";
echo "Com Operador: " . $comOperador . "<br>";
echo "endereco: " . $endereco . "<br>";
echo "responsavel: " . $responsavel . "<br>";
echo "Contato: " . $contato . "<br>";
echo "Status: " . $status . "<br>";
*/


//atualiza local
$sql_up = "UPDATE 
				local
			SET
				rut = '".$rut."',
				nome = '".$nome."',
				razao_social = '".$razaoSocial."',
				inclusao = '".$inclusao."',
				ordem = '".$ordem."',
				excluido = '".$status."',
				endereco = '".$endereco."',
				responsavel = '".$responsavel."',
				contato = '".$contato."',
				id_login = '".$operador."',
				percentual = '".$pctLocal."',
				id_regiao = '".$cidade."',
				id_tp_local = '".$tpLocal."',
				id_gerente = '".$gerente."',
				pct_operador = '".$comOperador."',
				pct_gerente = '".$comGerente."',
				id_admin = '".$admin."'																											
			WHERE
				id_local = '".$idLocal."'";

if(@mysql_query($sql_up) )
{
	//
	//header('Location: ../locales.php');
	exit(utf8_encode(true));
}else{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}

echo $sql_up;

?>