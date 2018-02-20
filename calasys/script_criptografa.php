<?php
	include('conn/conn.php');

	$sql_senhas = "SELECT id_login, senha FROM logins";	
	$query_senhas=@mysql_query($sql_senhas);
	
	
	while ($res = @mysql_fetch_assoc($query_senhas) ) {
		//$res['id_login'] . " / " . $res['senha'] . "<br>";
		
		$senhaCript = md5($res['senha']);
		
		$sql_add = "UPDATE logins SET nova_senha='".$senhaCript."' WHERE id_login=".$res['id_login'];
		
		echo $sql_add;
	
		
		if(@mysql_query($sql_add) )
		{
			echo "OK <br>";
		}
		else
		{
			echo "Erro id: " . $res['id_login'] ."<br>";	
		}
		
	}
?>