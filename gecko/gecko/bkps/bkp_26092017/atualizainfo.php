<?php
//
session_start();
//include('conn/connDongle.php');
include('conn/conn.php');
include('functions/validaLoginQrLeit.php');

//
include('conn/connDongle.php');

//
$id_disp = $_GET['xx'];
$entrada = $_GET['yy'];
$saida = $_GET['zz'];

//buscar se o valor de entrada e saida dessa dongle é menor que o atual
$sql_leitura = "SELECT creditIn, creditOut FROM StreetDongle WHERE MachineId = " . $id_disp;
$query_leitura=@mysql_query($sql_leitura);
$res_leitura=@mysql_fetch_assoc($query_leitura);


//verifica se a entrada nova é maior
if($entrada >= $res_leitura['creditIn'] and $saida >= $res_leitura['creditOut'])
{
	//atualiza entrada e saida
	$sql_up = "UPDATE 
					StreetDongle
				SET
					creditIn = '".$entrada."',
					creditOut = '".$saida."'
				WHERE
					MachineId = '".$id_disp."'";
	
	//		
	if(@mysql_query($sql_up) )
	{
		$retorno=1;
	}
	else
	{
		$retorno= 0;
	}						
}
else
{
	//
	$retorno = 0;	
}
?>


<!DOCTYPE html>
<html>
<head>
	<title>Gecko</title>
	<?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
	<?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
	<div class="container-fluid innpage-<?php echo $filenameID; ?>">
		<div class="row">
			<?php //include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
		</div>
		<div class="row">
			<?php //include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
			<div class="inner-content col-xs-12 col-sm-9">
			<?php include("inc/secccion-atualiza-leitura.php"); //el contenido de esta vista de panel de escritorio del usaurio ?>
			</div>
		</div>
	</div>
</body>
</html>