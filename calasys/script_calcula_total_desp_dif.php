<?php
/*script para gerar leitura oficial por leitura de cada maquina*/
session_start();
include('conn/conn.php');
include('functions/lg_validador.php');

$sql_leit = "
	SELECT
		*
	FROM
		leitura
	";
	
$query_leit=@mysql_query($sql_leit);

$i=0;



while($result_leit=@mysql_fetch_assoc($query_leit)) 
{
	//echo $result_maq['id_leitura'] . "<br>";
	//somar leitura oficial ate o momento da maquina 
	$sql_soma_desp = "
		SELECT
			SUM(desconto_leit_fecha.valor_desconto) as desconto_total
		FROM
			desconto_leit_fecha
		WHERE
			desconto_leit_fecha.id_leitura_fechamento = '".$result_leit['id_leitura']."'
		AND
			desconto_leit_fecha.leitura = 1
		AND
			desconto_leit_fecha.id_maquina = 0
			";
	$query_soma_desp=@mysql_query($sql_soma_desp);
	$result_soma_desp=@mysql_fetch_assoc($query_soma_desp);
	
	$novo_total_despesa = $result_soma_desp['desconto_total'];

	if($novo_total_despesa == "")
	{
		$novo_total_despesa = 0;
	}

	//diferenca
	$sql_soma_dif = "
		SELECT
			SUM(desconto_leit_fecha.valor_desconto) as diferenca_total
		FROM
			desconto_leit_fecha
		WHERE
			desconto_leit_fecha.id_leitura_fechamento = '".$result_leit['id_leitura']."'
		AND
			desconto_leit_fecha.leitura = 1
		AND
			desconto_leit_fecha.id_maquina <> 0
			";
	$query_soma_dif=@mysql_query($sql_soma_dif);
	$result_soma_dif=@mysql_fetch_assoc($query_soma_dif);
	
	$novo_total_dif = $result_soma_dif['diferenca_total'];


	if($novo_total_dif == "")
	{
		$novo_total_dif = 0;
	}
	
	//atualiza leitura por maquina
	$sql_up = "UPDATE 
					leitura 
				SET 
					total_desconto = ".$novo_total_despesa.",
					total_diferenca = ".$novo_total_dif."
				WHERE 
					id_leitura = ".$result_leit['id_leitura'];

	if(@mysql_query($sql_up) )
	{
		echo "OK <br>";
	}else{
		echo "X <br>";
	}
	$i++;
}

echo "<br><br>";
echo $i;

?>
