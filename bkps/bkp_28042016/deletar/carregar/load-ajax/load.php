<?php
	mysql_connect("localhost", "root", "");
	mysql_select_db("video_aulas");
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET charecter_set_client=utf8');
	mysql_query('SET charecter_set_results=utf8');

	$init 	= $_POST['init'];
	$max 	= $_POST['max'];

	$result = array(
		'totalResults' => 0,
		'dados' => null
	);

	$queryTotal = mysql_query("SELECT * FROM clientes");
	$result["totalResults"] = mysql_num_rows($queryTotal);

	$queryDados = mysql_query("SELECT nome FROM clientes LIMIT $init, $max");

	if($result["totalResults"] > 0){

		while($res = mysql_fetch_assoc($queryDados)){ $arr[] = $res; }

		$result["dados"] = $arr;

	}

	echo json_encode($result);