<style type='text/css'>
	table{font-size: 0.8em;}
	th,td{text-align: center;padding: 2px;}
	th {background-color: gray;color: white;}
</style>
<?php
session_start();
include_once('conn/conn.php');
include_once('functions/functions.php');
include_once('functions/lg_validador.php');
unset($_SESSION['campos']);

//Lendo a tabela Com os Dados dos Usuarios
$sql_ass = "
	SELECT
		vw_maquinas.codigo
		,vw_maquinas.numero
		,vw_maquinas.nome
		,DATE_FORMAT(MAX(leitura_por_maquina.data_cadastro),'%d/%m/%Y') AS data_leitura
	FROM
		vw_maquinas
		LEFT JOIN leitura_por_maquina ON leitura_por_maquina.id_maquina=vw_maquinas.id_maquina
		LEFT JOIN jogo ON jogo.id_jogo=vw_maquinas.id_jogo
	WHERE
			vw_maquinas.id_local IN (".$_SESSION['reg_acesso'].")
       AND leitura_por_maquina.data_cadastro IS NOT NULL
	GROUP BY
		vw_maquinas.id_maquina
	ORDER BY
		4 ASC
	LIMIT 20
";

$query_ass = @mysql_query($sql_ass);
$n_campos= @mysql_num_fields($query_ass);

$est='';

$est.="\n\t\t\t<div style='font-size:11px; font-family:helvetica; margin-bottom:5px;'>";
$est.="\n\t\t\t<table width='95%' border='0' align='left' cellpadding='2' cellspacing='4'>";
$est.="\n\t\t\t\t<tr bgcolor='#C0C0C0' height='14px;' style='font-weight:bolder' align='center'><th colspan='4' style='color:#FFFFFF;'>MAQUINAS SEM LEITURA / DESATUALIZADAS</th></tr>";

$c=0;
//Estatisticas para a exibição.
while ($estatisticas = @mysql_fetch_assoc($query_ass)) {
	if( $i==0 ) {
		$$est.="\n\t\t\t\t<tr height='14px;' bgcolor='#EEF6F9'>";
		for ($i=0;$i<$n_campos;$i++ ) {
			$cmp = @mysql_field_name($query_ass,$i);
			$est.="\n\t\t\t<th>".str_replace(' ','<br />',(strtoupper($cmp)))."</th>";
		}
		$est.="\n\t\t\t\t</tr>";
	}

	$est.="\n\t\t\t\t<tr height='14px;' bgcolor='#EEF6F9'>";
	$est.="\n\t\t\t\t\t<td>";
	$est.="\n\t\t\t\t\t\t&nbsp;".$estatisticas['codigo'];
	$est.="\n\t\t\t\t\t</td>";
	$est.="\n\t\t\t\t\t<td>";
	$est.="\n\t\t\t\t\t\t&nbsp;".$estatisticas['numero'];
	$est.="\n\t\t\t\t\t</td>";
	$est.="\n\t\t\t\t\t<td>";
	$est.="\n\t\t\t\t\t\t&nbsp;".$estatisticas['nome'];
	$est.="\n\t\t\t\t\t</td>";
	$est.="\n\t\t\t\t\t<td>";
	$est.="\n\t\t\t\t\t\t&nbsp;".$estatisticas['data_leitura'];
	$est.="\n\t\t\t\t\t</td>";
	$est.="\n\t\t\t\t</tr>";
	$c++;
}
$est.="\n\t\t\t</table>";
$est.="\n\t\t\t</div>\n";
$est.="\n\t\t\t<br clear='all'>\n";

@mysql_free_result($query_ass);
echo $est;
?>