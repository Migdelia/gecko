<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/validaLogin.php');


$arrayDesp = $_POST['checkGastos'];
$valoresDesp='';


//Verificando se todos os fechamentos informados ainda estão em aberto
$whr = "WHERE 1=1 AND fechada<>0 ";
$whrs = "";
$fechar = array();
foreach( $_POST as $idx=>$ids )
{
	if ( substr($idx,0,7)=='chk_bx_' ) // aqui atribui cada id a ser fechado
	{
		$whrs.=$ids.",";
		$fechar[$ids] = $ids;
	}
}

if ($whrs!='')
{
	$whr.= " AND id_leitura IN (".substr($whrs,0,-1).") ";
}

$sql_closed = "SELECT id_leitura FROM leitura ".$whr;
$query_closed=@mysql_query($sql_closed);
$registros = @mysql_num_rows($query_closed);



if( $registros>=1 )
{
	$conteudo.="<script language='javascript'>alert('ATENÇAO\\nOcorreu um erro no fechamento. Verifique se as leituras estão corretas.');window.close();</script>";	
}
else
{
	//$tipoLocal = $_POST['tipoLocal'];
	$tipoLocal = 1;
	
	if($tipoLocal == 1) //rua
	{
		
		//contar quantas maquinas ativas esse usuario tem e guardar * continuar aqui **Erico 
		$sql_qtd_maq_ope = "
			SELECT
				COUNT(id_maquina) as qtd_maquinas
			FROM
				maquinas
			INNER JOIN
				`local`
			ON
				maquinas.id_local = `local`.id_local
			WHERE
				maquinas.excluido = 'N'
			AND
				`local`.id_tp_local = 1				
			AND				
				`local`.id_login = '".$_SESSION['id_login']."'";
	
		$query_qtd_maq_ope = @mysql_query($sql_qtd_maq_ope);
		$res_qtd_maq_ope = @mysql_fetch_assoc($query_qtd_maq_ope);
	}
	else // outros / proprio / c socio e etc
	{
		//contar quantas maquinas ativas esse usuario tem e guardar * continuar aqui **Erico 
		$sql_qtd_maq_ope = "
			SELECT
				COUNT(id_maquina) as qtd_maquinas
			FROM
				maquinas
			INNER JOIN
				`local`
			ON
				maquinas.id_local = `local`.id_local
			WHERE
				`local`.id_gerente = '".$_SESSION['id_login']."'";
	
		$query_qtd_maq_ope = @mysql_query($sql_qtd_maq_ope);
		$res_qtd_maq_ope = @mysql_fetch_assoc($query_qtd_maq_ope);			
	}
	
	@mysql_query('BEGIN');
	$sql_fechar_1 = "INSERT INTO fechamento(`data_fechamento`,`id_login`,`qtd_maq_operador`) VALUES ('".date('Y-m-d')."','".$_SESSION['id_login']."','".$res_qtd_maq_ope['qtd_maquinas']."')";
	@mysql_query($sql_fechar_1);	
	//echo $sql_fechar_1 . "<br />";
	$idf = @mysql_insert_id();	
	


	foreach( $fechar as $idc )
	{
		if ( $idf>=1 )
		{
			$sql_fechar_2 = "UPDATE leitura SET id_fechamento=".$idf.", fechada=1 WHERE id_leitura=".$idc;

			if ( @mysql_query($sql_fechar_2) )
			{
				@mysql_query('COMMIT');
				@mysql_query('BEGIN');
			}else
			{
				@mysql_query('ROLLBACK');
				@mysql_query('BEGIN');
			}
	
		}else
		{
			@mysql_query('ROLLBACK');
		}
	}
	
	foreach($arrayDesp as $k => $v)
	{


			$nv = str_replace('true,', '', $v);

			$sql_fechar_desp = "UPDATE desconto_leit_fecha SET id_leitura_fechamento=".$idf." WHERE id_desconto =" . $nv;
			
			//echo $sql_fechar_desp . "<br />";
			
			
			if ( @mysql_query($sql_fechar_desp) )
			{
				@mysql_query('COMMIT');
				@mysql_query('BEGIN');
			}else
			{
				@mysql_query('ROLLBACK');
				@mysql_query('BEGIN');
			}
	}
	
	@mysql_close();
	
	header('Location:ver-informe-cierre.php?id=' . $idf);	
		
}
?>