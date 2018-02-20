<?php
    exec('ping -c 3 sanbernardo.dyndns.org', $saida, $retorno);


	if($retorno == 0)
	{
		echo "ONLINE";
	}
	else
	{
		echo "OFFLINE";
	}
	
	//$saida[1]; // mostra a resposta do ping
	//$retorno // mostra se funcionou o comando ou nao
?>
