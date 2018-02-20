<?php
	session_start();
	include('conn/conn.php');

	//somar todas as entradas - as saidas por leitura
	$sql_fat_bruto = "
			select
				id_leitura,
				SUM(valor_entrada) - SUM(valor_saida) as fat_bruto
			from 
				leitura_por_maquina
			GROUP BY
				leitura_por_maquina.id_leitura
		";
	$query_fat_bruto=@mysql_query($sql_fat_bruto);
	
	
	//inserir faturamento bruto na tabela de leitura
	while($result=@mysql_fetch_assoc($query_fat_bruto)) 
	{
		$sql_add_reg = "UPDATE 
							leitura 
						SET 
							fat_bruto = ".$result['fat_bruto']." 
						WHERE 
							id_leitura = ".$result['id_leitura'];
								
		if(@mysql_query($sql_add_reg) )
		{
			echo(utf8_encode($result['id_leitura'] . ": OK <br>"));
		}else{
			exit(utf8_encode($result['id_leitura'] . ": Erro <br>"));
		}
	}


?>