
<?php
session_start();
include('../conn/connIntegration.php');
include('functions.php');
//include('validaLogin.php');

$idMaq = $_POST['id'];
$return = "";



//consulta dados
$sql_info = "SELECT * FROM Config WHERE id = " . $idMaq;
$query_info=@mysql_query($sql_info);


//conecta no calaSys
//include('../conn/conn.php');

//
while($res_info=@mysql_fetch_assoc($query_info)) 
{
	$return .= $res_info['currencyName'] . ",";
	$return .= ($res_info['denomination'] / 1000) . ",";
	$return .= $res_info['percentage'] . ",";
	
	//trata o tipo de maquina
	if($res_info['machineType'] == 1)
	{
		$tpMaq = 'Server';	
	}
	else
	{
		$tpMaq = 'Cliente';
	}
	
	$return .= $tpMaq . ",";
	$return .= $res_info['acumuladoMin'] . ",";
	$return .= $res_info['acumuladoMax'] . ",";	
	$return .= round(($res_info['currentAcu'] / 1000000)) . ",";
	$return .= $res_info['acumuladoSMin'] . ",";	
	$return .= $res_info['acumuladoSMax'] . ",";
	$return .= round(($res_info['currentAcuS'] / 1000000)) . ",";
	$return .= $res_info['jackpotValue'] . ",";
	$return .= $res_info['limDouble']  . ",";	
	
	//
	//trata o db
	if($res_info['db'] == 1)
	{
		$db = 'SI';	
	}
	else
	{
		$db = 'NO';
	}
		
	$return .= $db  . ",";
	
	//
	//trata o fam
	if($res_info['fam'] == 1)
	{
		$fam = 'SI';	
	}
	else
	{
		$fam = 'NO';
	}	
	$return .= $fam  . ",";
	
	//
	//trata o fav
	if($res_info['fav'] == 70000)
	{
		$fav = 'A';	
	}
	else if($res_info['fav'] == 60000)
	{
		$fav = 'B';
	}	
	else if($res_info['fav'] == 50000)
	{
		$fav = 'C';
	}	
	else if($res_info['fav'] == 40000)
	{
		$fav = 'D';
	}
	else if($res_info['fav'] == 80000)
	{
		$fav = 'D';
	}			
	$return .= $fav  . ",";
	
	//
	//trata o fam
	if($res_info['famS'] == 1)
	{
		$famS = 'SI';	
	}
	else
	{
		$famS = 'NO';
	}	
	$return .= $famS  . ",";
	
	//
	//trata o fav
	if($res_info['favS'] == 20000)
	{
		$favS = 'A';	
	}
	else if($res_info['favS'] == 15000)
	{
		$favS = 'B';
	}	
	else if($res_info['favS'] == 10000)
	{
		$favS = 'C';
	}	
	else if($res_info['favS'] == 5000)
	{
		$favS = 'D';
	}		
	$return .= $favS  . ",";
	$return .= number_format(($res_info['payoutLim'] * 1000),0,"",".")  . ",";
	
	//
	//trata o pk
	if($res_info['pk'] == 1)
	{
		$pk = 'SI';	
	}
	else
	{
		$pk = 'NO';
	}	
	
	$return .= $pk  . ",";
}


//$return = $sql_info;
echo $return;

?>