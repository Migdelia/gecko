<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$id_assoc = $_GET['id'];
$sql_loc = "
	SELECT
		local.id_local,
		local.id_tp_local
	FROM
		`local`
	WHERE
		local.id_local IS NOT NULL
		AND `id_local` = '".$id_assoc."'
	";
	
$query_loc=@mysql_query($sql_loc);
$result_loc=@mysql_fetch_assoc($query_loc);



if($result_loc['id_tp_local']==1)
{
	header('Location: leitura_rua.php?id=' . $id_assoc);
}
elseif($result_loc['id_tp_local']==2)
{
	header('Location: leitura_proprio_socio.php?id=' . $id_assoc);
}
elseif($result_loc['id_tp_local']==3)
{
	header('Location: leitura_lan.php?id=' . $id_assoc);
}
elseif($result_loc['id_tp_local']==4)
{
	header('Location: leitura_proprio.php?id=' . $id_assoc);
}

?>