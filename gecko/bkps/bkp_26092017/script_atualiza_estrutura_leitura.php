<?php

session_start();
include('conn/conn.php');
include('functions/validaLogin.php');


//gerar lista de leitura por maquina, para futura consulta de dados faltantes.
$sql_lista_leitura_maquina = "SELECT * FROM leitura_por_maquina WHERE id_leit_maq > 382000";
$query_lista_leitura_maquina=@mysql_query($sql_lista_leitura_maquina);


while($res_lst_maq=@mysql_fetch_assoc($query_lista_leitura_maquina)) 
{
	//
	if($res_lst_maq['id_leit_maq'] == '')
	{
		echo "ERRO - Maq ingressada na LeituraPorMaquina <br />";	
	}
	else
	{
		//consulta os dados da tabela de maquina 
		$sql_dados_atuais_maq = "SELECT * FROM vw_maquinas WHERE id_maquina = " . $res_lst_maq['id_maquina'];
		$query_dados_atuais_maq=@mysql_query($sql_dados_atuais_maq);
		$res_dados_atuais_maq=@mysql_fetch_assoc($query_dados_atuais_maq);	
		
		$disp = $res_dados_atuais_maq['interface'];
		
		//
		if($res_dados_atuais_maq['id_maquina'] == '')
		{
			//consulta os dados da tabela de maquina 
			$sql_dados_atuais_maq = "SELECT * FROM maquinas WHERE id_maquina = " . $res_lst_maq['id_maquina'];
			$query_dados_atuais_maq=@mysql_query($sql_dados_atuais_maq);
			$res_dados_atuais_maq=@mysql_fetch_assoc($query_dados_atuais_maq);	
			
			$disp = 0;			
		}		
	
	
		//atualiza dados nos novos campos
		$sql_add_lpm = "UPDATE 
							leitura_por_maquina 
						SET
							id_gabinete = '".$res_dados_atuais_maq['id_tipo_maquina']."',
							num_disp = '".$disp."',
							pct_esp_maq = '".$res_dados_atuais_maq['porc_maquina']."',
							ordem_leitura = '".$res_dados_atuais_maq['ordem_leitura']."',
							pct_maq_socio = '".$res_dados_atuais_maq['porc_socio']."',
							maq_socio = '".$res_dados_atuais_maq['maq_socio']."',
							maq_parceiro = '".$res_dados_atuais_maq['parceiro']."',
							id_jogo = '".$res_dados_atuais_maq['id_jogo']."'
						WHERE
							id_leit_maq = '".$res_lst_maq['id_leit_maq']."'";						
	
	
		//
		if(@mysql_query($sql_add_lpm))
		{
			//echo $res_lst_maq['id_maquina'] . " = OK <br />";
		}else{
			echo $res_lst_maq['id_maquina'] . " = ERRO AO INSERIR REGISTRO <br />";
		}		
	}
}




//gerar lista de LEITURAS a serem atualizadas, para futura consulta de dados faltantes.
$sql_lista_leitura = "SELECT * FROM leitura";
$query_lista_leitura=@mysql_query($sql_lista_leitura);


//
while($res_lst_leitura=@mysql_fetch_assoc($query_lista_leitura)) 
{
	
	//consulta os dados da tabela de locais 
	$sql_dados_atuais_local = "SELECT * FROM local WHERE id_local = " . $res_lst_leitura['id_local'];
	$query_dados_atuais_local=@mysql_query($sql_dados_atuais_local);
	$res_dados_atuais_local=@mysql_fetch_assoc($query_dados_atuais_local);	
	


	//atualiza dados nos novos campos
	$sql_add_ll = "UPDATE 
						leitura 
					SET
						id_operador = '".$res_dados_atuais_local['id_login']."',
						id_gerente = '".$res_dados_atuais_local['id_gerente']."',
						pct_local = '".$res_dados_atuais_local['percentual']."',
						id_tipo_local = '".$res_dados_atuais_local['id_tp_local']."',
						pct_operador = '".$res_dados_atuais_local['pct_operador']."',
						pct_gerente = '".$res_dados_atuais_local['pct_gerente']."',
						id_admin = '".$res_dados_atuais_local['id_admin']."'
							
					WHERE
						id_leitura = '".$res_lst_leitura['id_leitura']."'";						


	//
	if(@mysql_query($sql_add_ll))
	{
		echo $res_lst_leitura['id_leitura'] . " = OK <br />";
	}else{
		echo $res_lst_leitura['id_leitura'] . " = ERRO AO INSERIR REGISTRO <br />";
	}	
}

//echo "Terminou";
?>