<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>

<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
unset($_SESSION['campos']);


	$id_maq = array(717 , 718);

	$tam_array = count($id_maq);
	$tam_array = $tam_array -1;

	$i = 0;
	while($i <= $tam_array) 
	{

		$sql_num_maq = "select numero from maquinas WHERE id_maquina = " . $id_maq[$i];
		$query_num_maq=@mysql_query($sql_num_maq);
		$resultado_num_maq=@mysql_fetch_assoc($query_num_maq);

		
		$num_maq = $resultado_num_maq['numero'];



		$sql_id_leit = "select MAX(id_leitura) as leitura from leitura_por_maquina WHERE id_maquina = " . $id_maq[$i];
		$query_id_leit=@mysql_query($sql_id_leit);
		$resultado_id=@mysql_fetch_assoc($query_id_leit);
		
		$id_leitura = $resultado_id['leitura'];
		
		$sql_ult_leit = "select (valor_entrada - valor_saida) as faturamento from leitura_por_maquina WHERE id_leitura = ".$resultado_id['leitura']." and id_maquina =" . $id_maq[$i];
		$query_ult_leit=@mysql_query($sql_ult_leit);
		$resultado=@mysql_fetch_assoc($query_ult_leit);
	
		
		$fat_maq = $resultado['faturamento'];
		
		
		$sql_pct_loc = "SELECT
							`local`.id_local,
							`local`.percentual
						FROM
							`local`
						INNER JOIN
							maquinas
						ON
							`local`.id_local = maquinas.id_local
						WHERE
							maquinas.id_maquina = " . $id_maq[$i];
		$query_pct_loc=@mysql_query($sql_pct_loc);
		$resultado_pct_loc=@mysql_fetch_assoc($query_pct_loc);
		
		$pct_local = $resultado_pct_loc['percentual'];
		
		$vl_cala = ($fat_maq - ($fat_maq * $pct_local / 100));
		
		$vl_parc = ($vl_cala * 45) / 100;

		
		$vl_parc = $vl_parc - (($vl_parc * 6) / 100);

		
		$vl_parc = $vl_parc - 2000;
		
		

		echo "Maq: " . $num_maq;
		echo "<br />Val Cala: " . $vl_cala;
		echo "<br />Val Martinho: " . $vl_parc;

		echo "<br />";
		echo "<br />";		
	
		$i++;
	}


	
	
?>

</body>
</html>
