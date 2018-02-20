<?php
session_start();
include('conn/conn.php');
				
//Lendo a tabela de Maquinas
$sql_leit = "
	SELECT
			*
	FROM
		leitura
	LIMIT
		10
	";
	
	
//abre tabela
$conteudo.="\n\t\t\t\t<table width='100%' border='0' align='center'>";

$query_leit=@mysql_query($sql_leit);
while ($dados_leit=@mysql_fetch_assoc($query_leit)) 
{
	$conteudo.="\n\t\t\t\t<tr>";
		$conteudo.="\n\t\t\t\t<td>";
			$conteudo.= $dados_leit['id_leitura'];			
		$conteudo.="\n\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t<td>";
			$conteudo.= $dados_leit['id_local'];			
		$conteudo.="\n\t\t\t\t</td>";	
		$conteudo.="\n\t\t\t\t<td>";
			$conteudo.= $dados_leit['id_fechamento'];			
		$conteudo.="\n\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t<td>";
			$conteudo.= $dados_leit['data'];			
		$conteudo.="\n\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t<td>";
			$conteudo.= $dados_leit['fechada'];			
		$conteudo.="\n\t\t\t\t</td>";
		$conteudo.="\n\t\t\t\t<td>";
			$conteudo.= $dados_leit['observacao'];			
		$conteudo.="\n\t\t\t\t</td>";										
	$conteudo.="\n\t\t\t\t</tr>";	
}

$conteudo.="\n\t\t\t\t</table>";

?>