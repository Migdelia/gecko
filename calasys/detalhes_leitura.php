<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$id_assoc = $_GET['id'];
$sql_loc = "
	SELECT
		leitura.id_leitura,
		leitura.id_local,
		leitura.id_tipo_local
	FROM
		`leitura`
	WHERE
		leitura.id_leitura IS NOT NULL
		AND `id_leitura` = '".$id_assoc."'
	";
	
$query_loc=@mysql_query($sql_loc);
$result_loc=@mysql_fetch_assoc($query_loc);

if($result_loc['id_tipo_local']==1)
{
	header('Location: detalhes_leitura_rua.php?id=' . $id_assoc);
}
elseif($result_loc['id_tipo_local']==2)
{
	header('Location: detalhes_leitura_proprio_socio.php?id=' . $id_assoc);
}
elseif($result_loc['id_tipo_local']==3)
{
	header('Location: detalhes_leitura_lan.php?id=' . $id_assoc);
}
elseif($result_loc['id_tipo_local']==4)
{
	header('Location: detalhes_leitura_proprio.php?id=' . $id_assoc);
}
elseif($result_loc['id_tipo_local']==6)
{
	header('Location: detalhes_leitura_rua.php?id=' . $id_assoc);
}
?>