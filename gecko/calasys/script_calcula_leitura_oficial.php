<?php
/*script para gerar leitura oficial por leitura de cada maquina*/
session_start();
include('conn/conn.php');
include('functions/lg_validador.php');

$sql_maq = "
	SELECT
		*
	FROM
		maquinas
	";
	
$query_maq=@mysql_query($sql_maq);

$i=0;

while($result_maq=@mysql_fetch_assoc($query_maq)) 
{
	//echo $result_maq['id_leitura'] . "<br>";
	//somar leitura oficial ate o momento da maquina 
	$sql_soma = "
		SELECT
			SUM(leitura_por_maquina.valor_entrada) as entrada_oficial,
			SUM(leitura_por_maquina.valor_saida) as saida_oficial
		FROM
			leitura_por_maquina
		WHERE
			leitura_por_maquina.id_maquina = '".$result_maq['id_maquina']."'
			";
	$query_soma=@mysql_query($sql_soma);
	$result_soma=@mysql_fetch_assoc($query_soma);
	
	$nova_entrada_oficial = $result_soma['entrada_oficial'];
	$nova_saida_oficial = $result_soma['saida_oficial'];
	
	if($nova_entrada_oficial == "")
	{
		$nova_entrada_oficial = 0;
	}
	
	if($nova_saida_oficial == "")
	{
		$nova_saida_oficial = 0;
	}	
	
	//atualiza leitura por maquina
	$sql_up = "UPDATE 
					maquinas 
				SET 
					entrada_oficial = ".$nova_entrada_oficial.",
					saida_oficial = ".$nova_saida_oficial."
				WHERE 
					id_maquina = ".$result_maq['id_maquina'];
				

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
