<?php
//recebe valores das plaquinhas desse local
$lis_plaq_sist = $_POST['id_loc_plaq'];

//id local
$id_loc = $_POST['local_id'];

//conta quantos arquivos foram enviados
$qtd_arq_imp = count($_FILES['uploadedfile']['name']);

//verifica se foi enviado algum arquivo ou nao
if($qtd_arq_imp == 1)
{
	if($_FILES['uploadedfile']['name'][0] == "")
	{
		//echo "Erro! Nenhum arquivo selecionado<br />";
		echo("<script language = 'javascript'> alert('Erro! Nenhum arquivo selecionado'); location.href = 'http://www.calasys.com.br/calabaza/leitura_rua.php?id=".$id_loc."'; </script>");
	}
	else
	{
		echo $qtd_arq_imp . " Arquivos selecionados<br />";
	}
}
else
{
	echo $qtd_arq_imp . " Arquivos selecionados<br />";
}

$list_int_atu = "";
$cont_erro = 0;
$cont_import = 0;
$i = 0;
while ($i < $qtd_arq_imp) 
{
	//monta o nome da string de verificacao
	$nome_arquivo_ver = $_FILES['uploadedfile']['name'][$i] . ";";
	
	//busca dentro da extring o numero da plaquinha
	$existe = strpos($lis_plaq_sist, $nome_arquivo_ver);
	
	//verifica se existe
	if($existe != "")
	{
		//efetua procedimento de importacao
		include "bd.php";	
	
		$nome_arquivo = $_FILES['uploadedfile']['name'][$i];
		$tmp_arquivo = $_FILES['uploadedfile']['tmp_name'][$i];
		
		$target_path = "uploads/";
		
		$target_path = $target_path . basename( $nome_arquivo);
		
		if(move_uploaded_file($tmp_arquivo, $target_path)) {
		
			//echo "Arquivo ".  basename( $nome_arquivo)." enviado com sucesso!<br>";
			
			$tmpLocal = "uploads/".basename( $nome_arquivo);
			
			$local = fopen($tmpLocal, "r");
			$arquivo = fread($local, 200);
			fclose($local);
			
			$openssl_cmd = "sudo openssl enc -aes256 -d -a -in ".$tmpLocal." -out saida -kfile key.key";
		
			exec($openssl_cmd, $b, $c);
		
			//echo "<br> Criptografado: ".$arquivo."<br>";
					
			$tmpSaida = fopen("./saida", "r");
			$saida = fread($tmpSaida, 2000);
			fclose($tmpSaida);
		
			//echo "<br> Descriptografado: " .$saida."<br>";
		
			$explode = explode(';', $saida);
			$dataHora = $explode[0];
			$idMaquina = $explode[1];
			$moneyIn = $explode[2];
			$moneyOut = $explode[3];
		
			
			$pesquisa = "UPDATE Machine SET mIn=".$moneyIn.", mOut=".$moneyOut.", lastMoneyInOutUpdate=now() WHERE id=".$idMaquina;
			$resultado = mysql_query($pesquisa);
		 
			if ($resultado){
				
				
				$pesquisa = "SELECT * FROM Machine WHERE id = " . $idMaquina;
		
				$resultado = mysql_query($pesquisa);
		
				$array_de_conteudo = mysql_fetch_array($resultado);
		
				$linhas = mysql_num_rows($resultado);
		
				if ($resultado)
				{
			
					//print "Maquina " . $array_de_conteudo["id"] . " atualizada! <br /><br />";
					
					$cont_import++;
					
					//monta lista de plaquinhas atualizadas com suas respectivas entrada e saida
					$list_int_atu .= $array_de_conteudo["id"]."/".$moneyIn."/".$moneyOut.";";
					
					mysql_close($conexao);
		
					mysql_free_result($resultado);
		
				}else{
		
					mysql_close($conexao);
		
				}
			}else{
				die (mysql_error());
			}
		} 
		else{
			echo "Ocorreu um erro, por favor tente novamente!<br />";
		}
	}
	else
	{
		$cont_erro++;
	}
	$i++;
}

//mostra relatorio de importacao
if($cont_import > 0)
{
	echo $cont_import . " Arquivo(s) importado(s) com Sucesso!<br />"; 
}

if($cont_erro > 0)
{
	echo "Erro: " . $cont_erro . " Interfaces nao sao desse local!<br />"; 
}


echo "<form id='exporta_info' name='exporta_info' method='post' action='http://www.calasys.com.br/calabaza/leitura_rua.php?id=".$id_loc."' enctype='multipart/form-data' onsubmit='return false;'>";
?>

<input type="button" id="carr_leit" name="carr_leit" value=" Carregar Leitura " onclick="teste();" />

<input type="hidden" name="infos" id="infos" value="<?=$list_int_atu;?>">

</form>

<script type="text/javascript" charset="utf-8">

	function teste()
	{
		//alert("Direcionar para a leitura com os valores carregados!");
		//location.href="http://localhost/calabaza/leitura_rua_completo.php?id=32";
		document.forms['exporta_info'].submit();
	}
	
	
</script>