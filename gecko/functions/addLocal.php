<?php
session_start();
include('../conn/conn.php');
include('functions.php');
include('validaLogin.php');

$cidadeLocal = $_POST['hd_cidade_Local'];
$nomeOperador = $_POST['hd_operador_Local'];
$tipoLocal = $_POST['hd_tp_Local'];
$gerenteLocal = $_POST['hd_gerente_Local'];
$adminLocal = $_POST['hd_admin_Local'];
$comOperador = $_POST['hd_comOpe_Local'];
$comGerente = $_POST['hd_comGer_Local'];
$pctLocal = $_POST['hd_pct_Local'];
$razaoSocial = $_POST['input_rSocial_Local'];
$NomeLocal = $_POST['input_nome_Local'];
$enderecoLocal = $_POST['input_endereco_Local'];
$rut = $_POST['input_rut_Local'];
$responsavel = $_POST['input_resp_Local'];
$contato = $_POST['input_contacto_Local'];


//consulta o id do usuario
$sql_ope = "
	SELECT
		id_login
	FROM
		logins
	WHERE
		nome = '".$nomeOperador."'
	";
	
$query_ope=@mysql_query($sql_ope);
$result_ope=@mysql_fetch_assoc($query_ope);


//consulta o id do usuario
$sql_ger = "
	SELECT
		id_login
	FROM
		logins
	WHERE
		nome = '".$gerenteLocal."'
	";
	
$query_ger=@mysql_query($sql_ger);
$result_ger=@mysql_fetch_assoc($query_ger);

//consulta o id do usuario
$sql_adm = "
	SELECT
		id_login
	FROM
		logins
	WHERE
		nome = '".$adminLocal."'
	";
	
$query_adm=@mysql_query($sql_adm);
$result_adm=@mysql_fetch_assoc($query_adm);

//consulta o id cidade
$sql_cidade = "
	SELECT
		id_cidade
	FROM
		regiao
	WHERE
		nome_cidade = '".$cidadeLocal."'
	";
	
$query_cidade=@mysql_query($sql_cidade);
$result_cidade=@mysql_fetch_assoc($query_cidade);


//consulta o id tipo local
$sql_tpLocal = "
	SELECT
		id_tp_local
	FROM
		tipo_local
	WHERE
		tp_local = '".$tipoLocal."'
	";
	
$query_tpLocal=@mysql_query($sql_tpLocal);
$result_tpLocal=@mysql_fetch_assoc($query_tpLocal);



//
$sql_add = "INSERT INTO 
					local 
					(
						rut,
						nome,
						razao_social,
						inclusao,
						ordem,
						excluido,
						endereco,
						responsavel,
						contato,
						id_login,
						percentual,
						id_regiao,
						id_tp_local,
						id_gerente,
						id_admin,
						pct_operador,
						pct_gerente
					) 
					VALUES
					(
						'".$rut."',
						'".$NomeLocal."',
						'".$razaoSocial."',
						'".date('Y-m-d')."',
						'1',
						'N',
						'".$enderecoLocal."',	
						'".$responsavel."',
						'".$contato."',
						'".$result_ope['id_login']."',
						'".$pctLocal."',
						'".$result_cidade['id_cidade']."',
						'".$result_tpLocal['id_tp_local']."',
						'".$result_ger['id_login']."',
						'".$result_adm['id_login']."',
						'".$comOperador."',
						'".$comGerente."'													
					)";
					
//				
if(@mysql_query($sql_add) )
{
	
	//header('Location: ../locales.php');
	exit(utf8_encode(true));
}else{
	//exit(utf8_encode('ERRO!'));
	exit(utf8_encode(false));
}
?>