<?php
session_start();
include('../conn/conn.php');
include('functions.php');
//include('validaLogin.php');

$return = "";


//consulta dados
$sql_idLocais = "SELECT
	id_local
FROM
	locais_integrados
";
$query_idLocais=@mysql_query($sql_idLocais);

//
while($res_idLocais=@mysql_fetch_assoc($query_idLocais))
{
	//
	$return .= $res_idLocais['id_local'] . ","; 
	
	//consulta lista de dongles desse local.
	$sql_listDongle = "SELECT
							interface
						FROM
							vw_maquinas
						WHERE
							(interface > 69999
						AND
							interface < 89999
						)
						AND
							id_local = " . $res_idLocais['id_local'];
							
	$query_listDongle=@mysql_query($sql_listDongle);


	//gera lista dongle array
	$listDongle ='';
	while($res_listDongle=@mysql_fetch_assoc($query_listDongle))
	{
		$listDongle .= $res_listDongle['interface'] . ",";
	}
	

	//efetuar looping na lista de dongle 
	$id_dongles = explode(",", $listDongle);
	
	
	//
	$qtdDongles = count($id_dongles);
	$qtdDongles = $qtdDongles - 2;
	
	
	//conecta no integration 
	session_start();
	include('../conn/connIntegration.php');	
	
	
	//
	$totLocal =0;
	$subMaq = 0;
	for ($i = 0; $i <= $qtdDongles; $i++) {
		
		//
		$sql_leitDongle = "SELECT
							creditIn,
							creditOut
						FROM
							Statistic
						WHERE
							id = " . $id_dongles[$i];
							
							
		//echo $res_idLocais['id_local'] . ": " . $sql_leitDongle . "<br /><br />"; 
							
		$query_leitDongle=@mysql_query($sql_leitDongle);
		$res_leitDongle=@mysql_fetch_assoc($query_leitDongle);
		
		//
		$subMaq = $res_leitDongle['creditIn'] - $res_leitDongle['creditOut'];
		
		$totLocal = $totLocal + $subMaq;							
	}
	
	//
	$return .= $totLocal . ";"; 
			

	session_start();
	include('../conn/conn.php');
	
}


//$return = $sql_idLocais;
echo $return;

?>