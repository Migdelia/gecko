<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$id_assoc = $_GET['id'];
$sql_loc = "
	SELECT
		leitura.id_local
	FROM
		leitura
	WHERE
		leitura.id_fechamento = '".$id_assoc."'
	";
	
$query_loc=@mysql_query($sql_loc);
$result_loc=@mysql_fetch_assoc($query_loc);

$sql_tp_loc = "
	SELECT
		local.id_tp_local
	FROM
		local
	WHERE
		local.id_local = '".$result_loc['id_local']."'
	";
	
$query_tp_loc=@mysql_query($sql_tp_loc);
$result_tp_loc=@mysql_fetch_assoc($query_tp_loc);



if($result_tp_loc['id_tp_local']==1)
{
	header('Location: viewer_fechamento_rua.php?id=' . $id_assoc);
}
elseif($result_tp_loc['id_tp_local']==2)
{
	header('Location: viewer_fechamento_local.php?id=' . $id_assoc);
}
elseif($result_tp_loc['id_tp_local']==3)
{
	header('Location: viewer_fechamento_rua.php?id=' . $id_assoc);
}
elseif($result_tp_loc['id_tp_local']==4)
{
	header('Location: viewer_fechamento_proprio.php?id=' . $id_assoc);
}
else if($result_tp_loc['id_tp_local']==6)
{
	header('Location: viewer_fechamento_rua.php?id=' . $id_assoc);
}

?>