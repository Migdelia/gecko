<?php
include "bd.php";

$idMaquina = $_GET['id'];
if ($idMaquina <= 0) {
	header("index.php");
	exit;
}

$pesquisa = "SELECT * FROM Config WHERE id = " . $idMaquina;
$resultado = mysql_query($pesquisa) or die ("ERRO!");
$linha=mysql_fetch_array($resultado);

$currencyName = $linha["currencyName"];
$denomination = $linha["denomination"];
$percentage = $linha["percentage"];
if ( $percentage > 100 ){
	$percentage = $percentage - 50;
	$percentage = $percentage * 100 ;
	$percentage = $percentage + 5 ;
}
else
	$percentage = $percentage * 100;

$machineType = $linha["machineType"];
$acumuladoMin = $linha["acumuladoMin"];
$acumuladoMax = $linha["acumuladoMax"];
$currentAcu = $linha["currentAcu"];
$acumuladoSMin = $linha["acumuladoSMin"];
$acumuladoSMax = $linha["acumuladoSMax"];
$currentAcuS = $linha["currentAcuS"];
$jackpotValue = $linha["jackpotValue"];
$limDouble = $linha["limDouble"];
$db = $linha["db"];
$fam = $linha["fam"];
$fav = $linha["fav"];
$famS = $linha["famS"];
$favS = $linha["favS"];
$payoutLim = $linha["payoutLim"];
$billValid = $linha["billValid"];
$pk = $linha["pk"];
$percentageBingo = $linha["percentageBingo"];

?>
<!DOCTYPE html>
 
<html>
<head>
        <title>Configuracao</title>
        <meta charset="utf-8">
        <link rel="stylesheet" href="estilo.css">
</head>
     
     
<body>
<h1>Maquina <?php echo $idMaquina; ?></h1>

<form id="formulario" name="formulario" action="config.php" method="post" enctype="multipart/form-data">

<label>Moeda: <?php echo $currencyName; ?> </label><select name="currencyName">
<option value ="<?php echo $idMaquina.'-'.$moeda=1 ; ?>"  >$</option>
<option value ="<?php echo $idMaquina.'-'.$moeda=2 ; ?>"  >EUR</option>
<option value ="<?php echo $idMaquina.'-'.$moeda=3 ; ?>"  >USD</option>
</select>
</br>

<label>Denominacao: <?php echo $denomination;  ?> </label><select name="denomination">
<option value ="1" selected >0.010</option>
<option value ="2"  >0.020</option>
<option value ="5"  >0.050</option>
<option value ="10" >0.100</option>
<option value ="25" >0.250</option>
<option value ="75" >0.750</option>
<option value ="100">1.000</option>
</select>
</br>

<label>Porcentagem: <?php echo $percentage;  ?> </label><select name="percentage">
<option value ="9400" selected >9400</option>
<?php
    $porcent = 84;
    $porcent2 = 84;
    for($i=1; $i < 17; $i++){
	
	if($porcent < 100)
		$porcent = $porcent * 100;
	else
		$porcent = $porcent + 95;

	$porcent2 = $porcent2 = $porcent / 100;
	echo "<option value ='$porcent2' >$porcent</option>";	
        $porcent = $porcent + 5 ;
	$porcent2 = $porcent2 = $porcent + 45;
    	echo "<option value ='$porcent2' >$porcent</option>";
}
?>
<option value ="10000" >10000</option>
</select>
</br>

<label>Tipo: <?php if( $machineType == 1){ echo "Servidor"; }else{ echo "Cliente"; };  ?> </label><select name="machineType">
<option value =0  >Cliente</option>
<option value =1 selected >Servidor</option>
</select>
</br>

<label>Acumulado Big Min: <?php echo $acumuladoMin;  ?> </label><select name="acumuladoMin">
<option value ="370" selected >370</option>
<option value ="380"  >380</option>
<option value ="390"  >390</option>
</select>
</br>

<label>Acumulado Big Max: <?php echo $acumuladoMax;  ?> </label><select name="acumuladoMax">
<option value ="400" selected >400</option>
<option value ="410"  >410</option>
<option value ="420"  >420</option>
<option value ="430"  >430</option>
<option value ="440"  >440</option>
<option value ="450"  >450</option>
</select>
</br>

<label>Acumulado Big Atual: <?php echo $currentAcu;  ?> </label><select name="currentAcu">
<option value ="370" selected >3700</option>
<option value ="390"  >3900</option>
<option value ="400"  >4000</option>
<option value ="410"  >4100</option>
<option value ="420"  >4200</option>
<option value ="430"  >4300</option>
<option value ="440"  >4400</option>
<option value ="450"  >4500</option>
</select>
</br>

<label>Acumulado Single Min: <?php echo $acumuladoSMin;  ?> </label><select name="acumuladoSMin">
<option value ="370" selected >370</option>
<option value ="380"  >380</option>
<option value ="390"  >390</option>
</select>
</br>

<label>Acumulado Single Max: <?php echo $acumuladoSMax;  ?> </label><select name="acumuladoSMax">
<option value ="400" selected >400</option>
<option value ="410"  >410</option>
<option value ="420"  >420</option>
<option value ="430"  >430</option>
<option value ="440"  >440</option>
<option value ="450"  >450</option>
</select>
</br>

<label>Acumulado Single Atual: <?php echo $currentAcuS;  ?> </label><select name="currentAcuS">
<option value ="370" selected >3700</option>
<option value ="390"  >3900</option>
<option value ="400"  >4000</option>
<option value ="410"  >4100</option>
<option value ="420"  >4200</option>
<option value ="430"  >4300</option>
<option value ="440"  >4400</option>
<option value ="450"  >4500</option>
</select>
</br>

<label>Valor Jackpot: <?php echo $jackpotValue;  ?> </label><select name="jackpotValue">
<option value ="200" selected >200</option>
<option value ="250"  >250</option>
<option value ="300"  >300</option>
<option value ="350"  >350</option>
<option value ="400"  >400</option>
<option value ="450"  >450</option>
<option value ="500"  >500</option>
</select>
</br>

<label>Limite Dobrar: <?php echo $limDouble;  ?> </label><select name="limDouble">
<option value ="20000" selected >20000</option>
<option value ="25000"  >25000</option>
<option value ="30000"  >30000</option>
<option value ="35000"  >35000</option>
<option value ="40000"  >40000</option>
<option value ="45000"  >45000</option>
<option value ="50000"  >50000</option>
</select>
</br>

<label>Limite Dobrar: <?php echo $limDouble;  ?> </label><select name="limDouble">
<option value ="20000" selected >20000</option>
<option value ="25000"  >25000</option>
<option value ="30000"  >30000</option>
<option value ="35000"  >35000</option>
<option value ="40000"  >40000</option>
<option value ="45000"  >45000</option>
<option value ="50000"  >50000</option>
</select>
</br>

<label>BD: <?php if( $db == 1){ echo "Sim"; }else{ echo "Nao"; };  ?> </label><select name="db">
<option value =1 selected >Sim</option>
<option value =0  >Nao</option>
</select>
</br>

<label>FAM BIG: <?php if( $fam == 1){ echo "Sim"; }else{ echo "Nao"; };  ?> </label><select name="fam">
<option value =1 selected >Sim</option>
<option value =0  >Nao</option>
</select>
</br>

<label>FAV BIG: <?php echo $fav;  ?> </label><select name="fav">
<option value ="70000"  >A</option>
<option value ="60000"  >B</option>
<option value ="50000" selected >C</option>
<option value ="40000"  >D</option>
</select>
</br>

<label>FAM SINGLE: <?php if( $famS == 1){ echo "Sim"; }else{ echo "Nao"; };  ?> </label><select name="famS">
<option value =1 selected >Sim</option>
<option value =0  >Nao</option>
</select>
</br>

<label>FAV SINGLE: <?php echo $favS;  ?> </label><select name="favS">
<option value ="20000"  >A</option>
<option value ="15000"  >B</option>
<option value ="10000"  >C</option>
<option value ="5000" selected >D</option>
</select>
</br>

<label>Limite autocobrar: <?php echo $payoutLim;  ?> </label><select name="payoutLim">
<option value ="2000" selected >2000</option>
<option value ="2500"  >2500</option>
<option value ="3000"  >3000</option>
<option value ="3500"  >3500</option>
</select>
</br>

<label>PK: <?php if( $pk == 1){ echo "Sim"; }else{ echo "Nao"; };  ?> </label><select name="pk">
<option value =1 selected >Sim</option>
<option value =0  >Nao</option>
</select>
</br>

<?php 

//$a1 = (int)(1.0 / ( 1.0 - 0.99) );
$a2 = 1000; // ~0.999
$a3 = 27; // ~0.9629
$a4 = (int)( 1.0/ ( 1.0 - 0.99 ) );
$a5 = (int)( 1.0/ ( 1.0 - 0.98 ) );
$a6 = (int)( 1.0/ ( 1.0 - 0.97 ) );
$a7 = (int)( 1.0/ ( 1.0 - 0.96 ) );
$a8 = (int)( 1.0/ ( 1.0 - 0.95 ) );
$a9 = (int)( 1.0/ ( 1.0 - 0.94 ) );
$a10 = (int)( 1.0/ ( 1.0 - 0.93 ) );
$a11 = (int)( 1.0/ ( 1.0 - 0.92 ) );
$a12 = (int)( 1.0/ ( 1.0 - 0.91 ) );
$a13 = (int)( 1.0/ ( 1.0 - 0.90 ) );
$a14 = (int)( 1.0/ ( 1.0 - 0.89 ) );
$a15 = (int)( 1.0/ ( 1.0 - 0.88 ) );
$a16 = (int)( 1.0/ ( 1.0 - 0.87 ) );
$a17 = (int)( 1.0/ ( 1.0 - 0.86 ) );
$a18 = (int)( 1.0/ ( 1.0 - 0.85 ) );
$a19 = (int)( 1.0/ ( 1.0 - 0.84 ) );
$a20 = (int)( 1.0/ ( 1.0 - 0.83 ) );
$a21 = (int)( 1.0/ ( 1.0 - 0.82 ) );
$a22 = (int)( 1.0/ ( 1.0 - 0.81 ) );
$a23 = (int)( 1.0/ ( 1.0 - 0.80 ) );

$a24 = (int)( 1.0/ ( 1.0 - 0.995 ) );
$a25 = (int)( 1.0/ ( 1.0 - 0.985 ) );
$a26 = (int)( 1.0/ ( 1.0 - 0.975 ) );
$a28 = (int)( 1.0/ ( 1.0 - 0.965 ) );
$a29 = (int)( 1.0/ ( 1.0 - 0.955 ) );
$a30 = (int)( 1.0/ ( 1.0 - 0.945 ) );
$a31 = (int)( 1.0/ ( 1.0 - 0.935 ) );
$a32 = (int)( 1.0/ ( 1.0 - 0.925 ) );
$a33 = (int)( 1.0/ ( 1.0 - 0.915 ) );
$a34 = (int)( 1.0/ ( 1.0 - 0.905 ) );
$a35 = (int)( 1.0/ ( 1.0 - 0.895 ) );
$a36 = (int)( 1.0/ ( 1.0 - 0.885 ) );
$a37 = (int)( 1.0/ ( 1.0 - 0.875 ) );
$a38 = (int)( 1.0/ ( 1.0 - 0.865 ) );
$a39 = (int)( 1.0/ ( 1.0 - 0.855 ) );
$a40 = (int)( 1.0/ ( 1.0 - 0.845 ) );
$a41 = (int)( 1.0/ ( 1.0 - 0.835 ) );
$a42 = (int)( 1.0/ ( 1.0 - 0.825 ) );
$a43 = (int)( 1.0/ ( 1.0 - 0.815 ) );
$a44 = (int)( 1.0/ ( 1.0 - 0.805 ) );

//echo $a1;

?>

<label>Porcentagem Bingo: <?php echo $percentageBingo;  ?> </label><select name="percentageBingo">
<option value ="13" selected >92.31</option>
<option value ="<?php echo $a2;  ?>"  >99.90</option>
<option value ="<?php echo $a24; ?>"  >99.50</option>
<option value ="<?php echo $a4;  ?>"  >98.99</option>
<option value ="<?php echo $a25; ?>"  >98.48</option>
<option value ="<?php echo $a5;  ?>"  >97.96</option>
<option value ="<?php echo $a26; ?>"  >97.44</option>
<option value ="<?php echo $a6;  ?>"  >96.97</option>
<option value ="<?php echo $a28; ?>"  >96.43</option>
<option value ="<?php echo $a3;  ?>"  >96.30</option>
<option value ="<?php echo $a7;  ?>"  >95.83</option>
<option value ="<?php echo $a29; ?>"  >95.45</option>
<option value ="<?php echo $a8;  ?>"  >94.74</option>
<option value ="<?php echo $a30; ?>"  >94.44</option>
<option value ="<?php echo $a9;  ?>"  >93.75</option>
<option value ="<?php echo $a10; ?>"  >92.86</option>
<option value ="<?php echo $a32; ?>"  >92.31</option>
<option value ="<?php echo $a11; ?>"  >91.67</option>
<option value ="<?php echo $a12; ?>"  >90.91</option>
<option value ="<?php echo $a13; ?>"  >90.00</option>
<option value ="<?php echo $a14; ?>"  >88.89</option>
<option value ="<?php echo $a15; ?>"  >87.50</option>
<option value ="<?php echo $a16; ?>"  >85.71</option>
<option value ="<?php echo $a41; ?>"  >83.33</option>
<option value ="<?php echo $a43; ?>"  >80.00</option>
<!---<option value ="<?php echo $a17;  ?>"  >85.71</option>
<option value ="<?php echo $a18;  ?>"  >83.33</option>
<option value ="<?php echo $a19;  ?>"  >83.33</option>
<option value ="<?php echo $a20;  ?>"  >80.00</option>
<option value ="<?php echo $a21;  ?>"  >80.00</option>
<option value ="<?php echo $a22;  ?>"  >80.00</option>
<option value ="<?php echo $a23;  ?>"  >80.00</option>
<option value ="<?php echo $a31;  ?>"  >94.44</option>
<option value ="<?php echo $a32;  ?>"  >92.31</option>
<option value ="<?php echo $a33;  ?>"  >90.91</option>
<option value ="<?php echo $a34;  ?>"  >90.00</option>
<option value ="<?php echo $a35;  ?>"  >88.89</option>
<option value ="<?php echo $a36;  ?>"  >87.50</option>
<option value ="<?php echo $a37;  ?>"  >87.50</option>
<option value ="<?php echo $a38;  ?>"  >85.71</option>
<option value ="<?php echo $a39;  ?>"  >83.33</option>
<option value ="<?php echo $a40;  ?>"  >83.33</option>
<option value ="<?php echo $a41;  ?>"  >83.33</option>
<option value ="<?php echo $a42;  ?>"  >80.00</option>--->

</select>
</br>



<button type="submit">Configurar</button>

</form>

<a href='index.php'>Voltar</a>


</body>
 
</html>
