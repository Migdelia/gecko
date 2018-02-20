<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

$sql_maquinas = "
	SELECT
		id_maquina
	FROM
		maquinas
	";
$query_maquinas=@mysql_query($sql_maquinas);


while($res_maquinas=@mysql_fetch_assoc($query_maquinas)) 
{
		// consulta a ultima leitura dessa maquina
		$sql_ultima_leitura = "
		SELECT
			max(id_leitura) as id_leitura
		FROM
			leitura_por_maquina
		WHERE
			id_maquina = " . $res_maquinas['id_maquina'];
			
		$query_ultima_leitura=@mysql_query($sql_ultima_leitura);
		$res_ultima_leitura=@mysql_fetch_assoc($query_ultima_leitura);	


		
		
		
		//atualiza cidade
		$sql_up = "UPDATE 
						maquinas
					SET
						id_ultima_leitura = ".$res_ultima_leitura['id_leitura']."
					WHERE
						id_maquina = ".$res_maquinas['id_maquina'];

						
		if(@mysql_query($sql_up) )
		{
			echo "maq: " . $res_maquinas['id_maquina'] . " OK <br />";	
		}else{
			echo "maq: " . $res_maquinas['id_maquina'] . " ERROOOOOOOOO <br /> ";	
		}		
		
}

?>