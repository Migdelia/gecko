<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/validaLogin.php');

$id_leitura = $_POST['id'];
$subtotal_anterior = $_POST['subtotal'];

$sql_per = "
	SELECT
		vw_acessos_usuarios.acesso
	FROM
		vw_acessos_usuarios
	WHERE 
		vw_acessos_usuarios.id_menu IN (5,9)
		AND id_nivel= '".$_SESSION['usr_nivel']."'
		AND usuario= '".$_SESSION['usuario']."'
		AND acesso='S'
	";
	
$query_per = mysql_query($sql_per);

if (@mysql_num_rows( $query_per ) != 2)
{
	
	if ( $tabela=='nivel' || $tabela=='usuario' )
	{
		exit(utf8_encode("Usuario no tiene permiso para esta operación."));
	}
}

$sql_consulta_local = " SELECT * FROM
               leitura_por_maquina 
                 WHERE
              id_leitura= '".$id_leitura."'";

$query_local = @mysql_query($sql_consulta_local);
$result_local=@mysql_fetch_assoc($query_local);

$local= $result_local['id_local'];

$sql_consulta = " SELECT * FROM
               leitura_por_maquina 
                 WHERE
              id_leitura= '".$id_leitura."'";

$query_lec = @mysql_query($sql_consulta);
while($result_lec=@mysql_fetch_assoc($query_lec)) 
{
	$entrada= $result_lec['entrada_oficial_atual'];
	$salida= $result_lec['saida_oficial_atual'];
	$maquina= $result_lec['id_maquina'];
    
	$sql_update_maquina = "UPDATE 
					maquinas 
					 SET 
					entrada_oficial= '".$entrada."',
					saida_oficial= '".$salida."'
					WHERE 
					id_maquina =  '".$maquina."' ";

  if(@mysql_query($sql_update_maquina) )
	{
	
	}
		else{
		exit(utf8_encode(0));
	}

  }

$sql_up1 = "DELETE FROM  
				desconto_leit_fecha 
			
			WHERE
				id_leitura_fechamento = '".$id_leitura."' AND leitura = 1  ";


if(@mysql_query($sql_up1) )
	{
	
	}
		else{
		exit(utf8_encode(0));
	}

$sql_up = "DELETE FROM  
				leitura 
			
			WHERE
				id_leitura = '".$id_leitura."'";


if(@mysql_query($sql_up) )
	{
		
	}
		else{
		exit(utf8_encode(0));
	}

$sql_maq = "DELETE FROM  
				leitura_por_maquina 
			
			WHERE
				id_leitura = '".$id_leitura."'";

if(@mysql_query($sql_maq) )
	{
		
	}
		else{
		exit(utf8_encode(0));
	}



$sql_consulta3 = " SELECT * FROM
               maquinas 
                 WHERE
              id_local= ".$local."";


$query_lec2 = @mysql_query($sql_consulta3);
while ($result_lec2=@mysql_fetch_assoc($query_lec2)) 
{
	$maquina= $result_lec2['id_maquina'];

     $sql_leitura = "SELECT 
     max(id_leitura) as id_leitura
     FROM
	leitura_por_maquina 
	where 
	id_maquina='".$maquina."'  ";

	$query_lec1 = @mysql_query($sql_leitura);
    $result_lec1=@mysql_fetch_assoc($query_lec1);

	$sql_ultima_leitura = "
	UPDATE 
	maquinas 
	 SET 
	id_ultima_leitura = '".$result_lec1['id_leitura']."'
	WHERE 
	id_local =  '".$local."' AND id_maquina = '".$maquina."' ";

    @mysql_query($sql_ultima_leitura);
    
}
	
	  $sql_insert_historico= "INSERT INTO 
   					historico_edicion_lectura(
						fecha,
						id_login,
						subtotal_ant,
						subtotal_nuevo,
						tipo_operacion,
						id_leitura_ant,
						id_leitura_nuevo
						) 
				VALUES(
						'".date("Y-m-d")."',
						'".$_SESSION['id_login']."',
						'".$subtotal_anterior."',
						'0',
						'Eliminacion',
						'".$id_leitura."',
						'0'
						)";


      if(@mysql_query($sql_insert_historico) )
		{
	
			exit(utf8_encode(1));
		}
		else
		{
			exit(utf8_encode(0));
		}

?>