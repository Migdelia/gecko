<?php

include "bd.php";	

$id_loc = $_GET['c'];
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
	echo "Erro conexao <br />";
}
else if (!@mysql_select_db($dbas,$conecta)) 
{
	echo "erro DB <br />";
}


$sql_teste = "select * from StreetDongle WHERE " . $lst_interface;
$query_teste=@mysql_query($sql_teste);

	

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
		
		
		
		$list_int_atu .= $resultado["id"]."/".$entrada."/".$saida.";";
	}
	else
	{
		$list_int_atu .= $resultado["id"]."/".$resultado["mIn"]."/".$resultado["mOut"].";";
	}
	
	$cont++;
}
$contTotal = $contTotal + $cont;


echo "Importado dados de: " . $contTotal . " maquinas com SUCESSO!";


//echo "<br /><br /><br />" . $list_int_atu;
echo "
<form id='exporta_info' name='exporta_info' method='post' action='../leitura_rua.php?id=".$id_loc."' enctype='multipart/form-data' onsubmit='return false;'>
";
?>

<input type="hidden" name="infos" id="infos" value="<?=$list_int_atu;?>">


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