<?
session_start();
include('../conn/conn.php');
include('lg_validador.php');
include('functions.php');
include('excel.php');

ini_set('max_execution_time', 0);

//Pegando o relatorio solicitado
$sql_rel = "
	SELECT
		relatorios.id_relatorio,
		relatorios.id_login,
		relatorios.nome,
		relatorios.area,
		relatorios.tabela,
		relatorios.campos,
		relatorios.criterios,
		relatorios.ordenacao,
		relatorios.`query`,
		relatorios.ordem,
		relatorios.tipo,
		relatorios.excluido
	FROM
		relatorios
	WHERE
		relatorios.id_relatorio='".base64_decode($_GET['ida'])."'
";

$query_rel = @mysql_query($sql_rel);

//Query da consulta
while ($result_relatorio=@mysql_fetch_assoc($query_rel) ) {
	$nome = strtolower($result_relatorio['nome']);
	$relatorios = $result_relatorio['query'];
}
$relatorios = str_replace("[PERMISSAO]",$_SESSION['reg_acesso'],$relatorios);

//exit($relatorios);
$xls=new IAM_XLS(str_replace(' ','_',$nome)."_".date('Y_m_d'));
$xls->WriteSQLDump(@mysql_query($relatorios));
?>