<?php
$id_loc = $_GET['c'];

if($id_loc == 133 or $id_loc == 55 or $id_loc == 101 or $id_loc == 24 or $id_loc == 223 or $id_loc == 278 or $id_loc == 69 or $id_loc == 289 or $id_loc == 276)
{
	$host = "calasys.cor2yfouvoqs.sa-east-1.rds.amazonaws.com";
	$user = "calasys";
	$pass = "cala*999865";
	$dbas = "integration";
	if (!$conecta = @mysql_connect($host, $user, $pass) ) 
	{
		echo "Erro conexao Dongle <br />";
	}
	else if (!@mysql_select_db($dbas,$conecta)) 
	{
		echo "erro DB <br />";
	}
	
	
	$lis_plaq_sist = $_GET['a'];
	$qtd_inter = $_GET['b'];
	$qtd_inter = $qtd_inter + 1;
	
	$inter = explode("-", $lis_plaq_sist);
	
	$i = 1;
	$lst_interface = "";
	while($i < $qtd_inter)
	{
		$plaq = str_replace(";", "", $inter[$i]);
		if($lst_interface == "")
		{
			$lst_interface .= " id = " . $plaq;
		}
		else
		{
			$lst_interface .= " OR id = " . $plaq;
		}
		
		$i++;
	}
	
	//
	$i = 1;
	$lst_dongle = "";
	while($i < $qtd_inter)
	{
		$plaq = str_replace(";", "", $inter[$i]);
		if($lst_dongle == "")
		{
			$lst_dongle .= " id = " . $plaq;
		}
		else
		{
			$lst_dongle .= " OR id = " . $plaq;
		}
		
		$i++;
	}
	
	
	$pesquisa = "SELECT * FROM Statistic WHERE " . $lst_interface;
	
	
	$query_maquinas=@mysql_query($pesquisa);
	//$resultado=@mysql_fetch_assoc($query_maquinas);
	
	$list_int_atu = "";
	$cont = 0;
	while($resultado=@mysql_fetch_assoc($query_maquinas)) 
	{
		/*
		echo "id: " . $resultado["id"] . "<br />";
		echo "entrada: " . $resultado["mIn"] . "<br />";
		echo "saida: " . $resultado["mOut"] . "<br />";
		echo "entrada Credito: " . $resultado["creditIn"] . "<br />";
		echo "saida Credito: " . $resultado["creditOut"] . "<br />";
		echo "entrada $ Int: " . $resultado["moneyInWhole"] . "<br />";
		echo "entrada $ Cents: " . $resultado["moneyInCents"] . "<br />";					
		echo "saida $ Int: " . $resultado["moneyOutWhole"] . "<br />";
		echo "saida $ Cents: " . $resultado["moneyOutCents"] . "<br />";					
		
		echo "<br /><br />";
		*/
		//verificar se eh o modelo novo de importacao ou o antigo.
		if($resultado["moneyInWhole"] > 0)
		{
			$entrada = $resultado["moneyInWhole"] . $resultado["moneyInCents"];
			$saida = $resultado["moneyOutWhole"] . $resultado["moneyOutCents"];
			
			//verifica quantos casas tem a variavel
			//entrada
			if(strlen($resultado["moneyInCents"]) == 1)
			{
				$entrada = $resultado["moneyInWhole"] . $resultado["moneyInCents"] . "0";
			}
			else if(strlen($resultado["moneyInCents"]) == 2)
			{
				$entrada = $resultado["moneyInWhole"] . "0" . $resultado["moneyInCents"];
			}
			else if(strlen($resultado["moneyInCents"]) == 3)
			{
				$cents = $resultado["moneyInCents"] / 10;
	
				$entrada = $resultado["moneyInWhole"] . $cents;
			}		
	
			//saida
			if(strlen($resultado["moneyOutCents"]) == 2)
			{
				$saida = $resultado["moneyOutWhole"] . "0" . ($resultado["moneyOutCents"] / 10);
			}
			else if(strlen($resultado["moneyOutCents"]) == 1)
			{
				$saida = $resultado["moneyOutWhole"] . $resultado["moneyOutCents"] . "0";
			}
			else if(strlen($resultado["moneyOutCents"]) == 3)
			{
				$saida = $resultado["moneyOutWhole"] . ($resultado["moneyOutCents"] /10);
			}
			
			
			
			$list_int_atu .= $resultado["id"]."/".$entrada."/".$saida.";";
		}
		else
		{
			$list_int_atu .= $resultado["id"]."/".$resultado["moneyIn"]."/".$resultado["moneyOut"].";";
		}
	
	
		$cont++;
	}
	$contTotal = $cont;
	
	/*
	//dongle
		
	$sql_teste = "select * from StreetDongle WHERE " . $lst_dongle;
	$query_teste=@mysql_query($sql_teste);
	
	//echo $sql_teste . "<br />";
	
	$cont = 0;
	while($resultado=@mysql_fetch_assoc($query_teste)) 
	{
		//echo $resultado_teste['id'] . "<br />";
		//alimentar a lista de plaquinhas
	
		//verificar se eh o modelo novo de importacao ou o antigo.
		if($resultado["moneyInWhole"] > 0)
		{
			$entrada = $resultado["moneyInWhole"] . $resultado["moneyInCents"];
			$saida = $resultado["moneyOutWhole"] . $resultado["moneyOutCents"];
			
			//verifica quantos casas tem a variavel
			//entrada
			if(strlen($resultado["moneyInCents"]) == 1)
			{
				$entrada = $resultado["moneyInWhole"] . $resultado["moneyInCents"] . "0";
			}
			else if(strlen($resultado["moneyInCents"]) == 2)
			{
				$entrada = $resultado["moneyInWhole"] . "0" . $resultado["moneyInCents"];
			}
			else if(strlen($resultado["moneyInCents"]) == 3)
			{
				$cents = $resultado["moneyInCents"] / 10;
	
				$entrada = $resultado["moneyInWhole"] . $cents;
			}		
	
			//saida
			if(strlen($resultado["moneyOutCents"]) == 2)
			{
				$saida = $resultado["moneyOutWhole"] . "0" . ($resultado["moneyOutCents"] / 10);
			}
			else if(strlen($resultado["moneyOutCents"]) == 1)
			{
				$saida = $resultado["moneyOutWhole"] . $resultado["moneyOutCents"] . "0";
			}
			else if(strlen($resultado["moneyOutCents"]) == 3)
			{
				$saida = $resultado["moneyOutWhole"] . ($resultado["moneyOutCents"] /10);
			}
			
			
			
			$lst_dongle_atu .= $resultado["MachineId"]."/".$entrada."/".$saida.";";
		}
		else
		{
			$lst_dongle_atu .= $resultado["MachineId"]."/".$resultado["mIn"]."/".$resultado["mOut"].";";
		}
		
		$cont++;
	}
	$contTotal = $contTotal + $cont;
	*/
	
	echo "Importado dados de: " . $contTotal . " maquinas com SUCESSO!";
	
	
	//echo "<br /><br /><br />" . $list_int_atu;
	echo "
	<form id='exporta_info' name='exporta_info' method='post' action='../leitura_rua.php?id=".$id_loc."' enctype='multipart/form-data' onsubmit='return false;'>
	";
	
	
	$lista_final = $list_int_atu . $lst_dongle_atu;
	
	
		
}
else
{
	include "bd.php";	
	
	
	$lis_plaq_sist = $_GET['a'];
	$qtd_inter = $_GET['b'];
	$qtd_inter = $qtd_inter + 1;
	
	$inter = explode("-", $lis_plaq_sist);
	
	$i = 1;
	$lst_interface = "";
	while($i < $qtd_inter)
	{
		$plaq = str_replace(";", "", $inter[$i]);
		if($lst_interface == "")
		{
			$lst_interface .= " id = " . $plaq;
		}
		else
		{
			$lst_interface .= " OR id = " . $plaq;
		}
		
		$i++;
	}
	
	//
	$i = 1;
	$lst_dongle = "";
	while($i < $qtd_inter)
	{
		$plaq = str_replace(";", "", $inter[$i]);
		if($lst_dongle == "")
		{
			$lst_dongle .= " MachineId = " . $plaq;
		}
		else
		{
			$lst_dongle .= " OR MachineId = " . $plaq;
		}
		
		$i++;
	}
	
	
	$pesquisa = "SELECT * FROM Machine WHERE " . $lst_interface;
	
	
	$query_maquinas=@mysql_query($pesquisa);
	//$resultado=@mysql_fetch_assoc($query_maquinas);
	
	$list_int_atu = "";
	$cont = 0;
	while($resultado=@mysql_fetch_assoc($query_maquinas)) 
	{
		/*
		echo "id: " . $resultado["id"] . "<br />";
		echo "entrada: " . $resultado["mIn"] . "<br />";
		echo "saida: " . $resultado["mOut"] . "<br />";
		echo "entrada Credito: " . $resultado["creditIn"] . "<br />";
		echo "saida Credito: " . $resultado["creditOut"] . "<br />";
		echo "entrada $ Int: " . $resultado["moneyInWhole"] . "<br />";
		echo "entrada $ Cents: " . $resultado["moneyInCents"] . "<br />";					
		echo "saida $ Int: " . $resultado["moneyOutWhole"] . "<br />";
		echo "saida $ Cents: " . $resultado["moneyOutCents"] . "<br />";					
		
		echo "<br /><br />";
		*/
		//verificar se eh o modelo novo de importacao ou o antigo.
		if($resultado["moneyInWhole"] > 0)
		{
			$entrada = $resultado["moneyInWhole"] . $resultado["moneyInCents"];
			$saida = $resultado["moneyOutWhole"] . $resultado["moneyOutCents"];
			
			//verifica quantos casas tem a variavel
			//entrada
			if(strlen($resultado["moneyInCents"]) == 1)
			{
				$entrada = $resultado["moneyInWhole"] . $resultado["moneyInCents"] . "0";
			}
			else if(strlen($resultado["moneyInCents"]) == 2)
			{
				$entrada = $resultado["moneyInWhole"] . "0" . $resultado["moneyInCents"];
			}
			else if(strlen($resultado["moneyInCents"]) == 3)
			{
				$cents = $resultado["moneyInCents"] / 10;
	
				$entrada = $resultado["moneyInWhole"] . $cents;
			}		
	
			//saida
			if(strlen($resultado["moneyOutCents"]) == 2)
			{
				$saida = $resultado["moneyOutWhole"] . "0" . ($resultado["moneyOutCents"] / 10);
			}
			else if(strlen($resultado["moneyOutCents"]) == 1)
			{
				$saida = $resultado["moneyOutWhole"] . $resultado["moneyOutCents"] . "0";
			}
			else if(strlen($resultado["moneyOutCents"]) == 3)
			{
				$saida = $resultado["moneyOutWhole"] . ($resultado["moneyOutCents"] /10);
			}
			
			
			
			$list_int_atu .= $resultado["id"]."/".$entrada."/".$saida.";";
		}
		else
		{
			$list_int_atu .= $resultado["id"]."/".$resultado["mIn"]."/".$resultado["mOut"].";";
		}
	
	
		$cont++;
	}
	$contTotal = $cont;
	
	
	//mysql_close();
	//conecta no banco das dongles
	//Conexao com o Banco
	
	$host = "localhost";
	$user = "root";
	$pass = "cala*999865";
	$dbas = "dongle_SysDongleV2";
	if (!$conecta = @mysql_connect($host, $user, $pass) ) 
	{
		echo "Erro conexao Dongle <br />";
	}
	else if (!@mysql_select_db($dbas,$conecta)) 
	{
		echo "erro DB <br />";
	}
	
	
	$sql_teste = "select * from StreetDongle WHERE " . $lst_dongle;
	$query_teste=@mysql_query($sql_teste);
	
	//echo $sql_teste . "<br />";
	
	$cont = 0;
	while($resultado=@mysql_fetch_assoc($query_teste)) 
	{
		//echo $resultado_teste['id'] . "<br />";
		//alimentar a lista de plaquinhas
	
		//verificar se eh o modelo novo de importacao ou o antigo.
		if($resultado["moneyInWhole"] > 0)
		{
			$entrada = $resultado["moneyInWhole"] . $resultado["moneyInCents"];
			$saida = $resultado["moneyOutWhole"] . $resultado["moneyOutCents"];
			
			//verifica quantos casas tem a variavel
			//entrada
			if(strlen($resultado["moneyInCents"]) == 1)
			{
				$entrada = $resultado["moneyInWhole"] . $resultado["moneyInCents"] . "0";
			}
			else if(strlen($resultado["moneyInCents"]) == 2)
			{
				$entrada = $resultado["moneyInWhole"] . "0" . $resultado["moneyInCents"];
			}
			else if(strlen($resultado["moneyInCents"]) == 3)
			{
				$cents = $resultado["moneyInCents"] / 10;
	
				$entrada = $resultado["moneyInWhole"] . $cents;
			}		
	
			//saida
			if(strlen($resultado["moneyOutCents"]) == 2)
			{
				$saida = $resultado["moneyOutWhole"] . "0" . ($resultado["moneyOutCents"] / 10);
			}
			else if(strlen($resultado["moneyOutCents"]) == 1)
			{
				$saida = $resultado["moneyOutWhole"] . $resultado["moneyOutCents"] . "0";
			}
			else if(strlen($resultado["moneyOutCents"]) == 3)
			{
				$saida = $resultado["moneyOutWhole"] . ($resultado["moneyOutCents"] /10);
			}
			
			
			
			$lst_dongle_atu .= $resultado["MachineId"]."/".$entrada."/".$saida.";";
		}
		else
		{
			$lst_dongle_atu .= $resultado["MachineId"]."/".$resultado["creditIn"]."/".$resultado["creditOut"].";";
		}
		
		$cont++;
	}
	$contTotal = $contTotal + $cont;
	
	
	echo "Importado dados de: " . $contTotal . " maquinas com SUCESSO!";
	
	
	//echo "<br /><br /><br />" . $list_int_atu;
	echo "
	<form id='exporta_info' name='exporta_info' method='post' action='../leitura_rua.php?id=".$id_loc."' enctype='multipart/form-data' onsubmit='return false;'>
	";
	
	
	$lista_final = $list_int_atu . $lst_dongle_atu;
	
	
}

?>



<input type="hidden" name="infos" id="infos" value="<?=$lista_final;?>">


</form>

<script type="text/javascript" charset="utf-8">

		setTimeout(function(){document.exporta_info.submit();},3000);
		
		/*
		function enviaForm()
		{
			document.exporta_info.submit();
		}
		*/
</script>
