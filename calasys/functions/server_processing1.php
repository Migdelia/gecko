<?php

	session_start();



	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

	 * Easy set variables

	 */

	

	/* Array of database columns which should be read and sent back to DataTables. Use a space where

	 * you want to insert a non-database field (for example a counter or static image)

	 */



	//$aColumns = array( 'engine', 'browser', 'platform', 'version', 'grade' );

	$aColumns = explode('||',base64_decode($_GET['idc']));

	

	/* Indexed column (used for fast and accurate table cardinality) */

	$sIndexColumn = base64_decode($_GET['idi']);

	

	/* DB table to use */

	$sTable = base64_decode($_GET['idt']);



	/* Database connection information */

	//$gaSql['user']       = "";

	//$gaSql['password']   = "";

	//$gaSql['db']         = "";

	//$gaSql['server']     = "localhost";

	

	/* REMOVE THIS LINE (it just includes my SQL connection user/pass) */

	//include( $_SERVER['DOCUMENT_ROOT']."/datatables/mysql.php" );

	include( "../conn/conn.php" );

	

	

	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

	 * If you just want to use the basic configuration for DataTables with PHP server-side, there is

	 * no need to edit below this line

	 */

	

	/* 

	 * MySQL connection

	 */

	//$gaSql['link'] =  @mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or

	//	die( 'Could not open connection to server' );

	

	//@mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 

	//	die( 'Could not select database '. $gaSql['db'] );

	

	

	/* 

	 * Paging

	 */

	$sLimit = "";

	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )

	{

		$sLimit = "LIMIT ".@mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".

			@mysql_real_escape_string( $_GET['iDisplayLength'] );

	}

	

	

	/*

	 * Ordering

	 */

	if ( isset( $_GET['iSortCol_0'] ) )

	{

		$sOrder = "ORDER BY  ";

		for ( $i=0 ; $i<intval( $_GET['iSortingCols'] ) ; $i++ )

		{

			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )

			{

				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."

				 	".@mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";

			}

		}

		

		$sOrder = substr_replace( $sOrder, "", -2 );

		if ( $sOrder == "ORDER BY" )

		{

			$sOrder = "";

		}

	}

	

	

	/* 

	 * Filtering

	 * NOTE this does not match the built-in DataTables filtering which does it

	 * word by word on any field. It's possible to do here, but concerned about efficiency

	 * on very large tables, and MySQL's regex functionality is very limited

	 */

	$sWhere = "";

	if ( $_GET['sSearch'] != "" )

	{

		$sWhere = "WHERE (";

		for ( $i=0 ; $i<count($aColumns) ; $i++ )

		{

			$sWhere .= $aColumns[$i]." LIKE '%".@mysql_real_escape_string( $_GET['sSearch'] )."%' OR ";

			

		}

		$sWhere = substr_replace( $sWhere, "", -3 );

		$sWhere .= ')';

		

		// verifica se � operador para nao trazer resultados de outros operadores

		if($_SESSION['usr_nivel']==8)

		{

			$sWhere .= " AND id_login = ".$_SESSION['id_login']." ";

		}		

	}



	/* Individual column filtering */

	for ( $i=0 ; $i<count($aColumns) ; $i++ )

	{

		if ( $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )

		{

			if ( $sWhere == "" )

			{

				$sWhere = "WHERE ";

			}

			else

			{

				$sWhere .= " AND ";

			}

			//Caso seja data, formata para pesquisar

			if ($aColumns[$i]=='`Data`') {

				$sWhere .= "date_format(`Data`,'%d/%m/%Y') LIKE '%".@mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";			

			}else{

				$sWhere .= $aColumns[$i]." LIKE '%".@mysql_real_escape_string($_GET['sSearch_'.$i])."%' ";

				

				// verifica se � operador para nao trazer resultados de outros operadores

				if($_SESSION['usr_nivel']==8)

				{

					$sWhere .= " AND id_login = ".$_SESSION['id_login']." ";

				}

			}

		}

	}



	

	/*

	 * SQL queries

	 * Get data to display

	 */



	 if (trim($sWhere)=='' && ($sTable=='vw_local' || $sTable=='vw_maquinas' || $sTable=='vw_leitura_info') && ($_SESSION['usr_nivel']==8))

	 {

		//se for operador

		$sWhere = " WHERE id_login = ".$_SESSION['id_login']." ";

	 }

	 elseif($_SESSION['usr_nivel']==11)

	 {

	 	$sWhere = " WHERE parceiro = 1 ";

	 }



	 if (trim($sWhere)=='' && ($sTable=='vw_leitura_info') && ($_SESSION['usr_nivel']==9))

	 {

		$sWhere = " WHERE (id_local = 54 

					OR

						  id_local = 50

					OR

						  id_local = 133

					OR

						  id_local = 55

					OR

						  id_local = 52)

				AND 

					vw_leitura_info.fechada<>1				  				

					";

	 }







	 if (trim($sWhere)=='' && $sTable=='vw_leitura_info')

	 {

		$sWhere= "WHERE 

						vw_leitura_info.fechada<>1 ";

	 }

	 if ($sTable=='vw_leitura_info')

	 {

		$sWhere.= " AND vw_leitura_info.fechada<>1 ";

	 }





	$sQuery = "

		SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."

		FROM   $sTable

		$sWhere

		$sOrder

		$sLimit

	";

	



	

	//echo $sQuery;exit();

	$rResult = @mysql_query( $sQuery/*, $gaSql['link']*/ ) or die(@mysql_error());

	

	/* Data set length after filtering */

	$sQuery = "

		SELECT FOUND_ROWS()

	";

	$rResultFilterTotal = @mysql_query( $sQuery/*, $gaSql['link']*/ ) or die(@mysql_error());

	$aResultFilterTotal = @mysql_fetch_array($rResultFilterTotal);

	$iFilteredTotal = $aResultFilterTotal[0];

	

	/* Total data set length */

	$sQuery = "

		SELECT COUNT(".$sIndexColumn.")

		FROM   $sTable

	";

	$rResultTotal = @mysql_query( $sQuery/*, $gaSql['link']*/ ) or die(@mysql_error());

	$aResultTotal = @mysql_fetch_array($rResultTotal);

	$iTotal = $aResultTotal[0];

	

	

	/*

	 * Output

	 */

	$sOutput = '{';

	$sOutput .= '"sEcho": '.intval($_GET['sEcho']).', ';

	$sOutput .= '"iTotalRecords": '.$iTotal.', ';

	$sOutput .= '"iTotalDisplayRecords": '.$iFilteredTotal.', ';

	$sOutput .= '"aaData": [ ';

	while ( $aRow = @mysql_fetch_array( $rResult ) )

	{

		$sOutput .= "[";

		for ( $i=0 ; $i<count($aColumns) ; $i++ )

		{

			$aColumns[$i]=str_replace('`','',$aColumns[$i]);

			if ( $aColumns[$i] == "Data" ) {

				/* Special output formatting for 'Data' */

				$sOutput .= ($aRow[ $aColumns[$i] ]=="")?

					'"-",' :

					'"'.date('d/m/Y',strtotime($aRow[ $aColumns[$i] ])).'",';

			}else if ( $aColumns[$i] == "id_login" ) {

				/* Special output formatting for 'Data' */

				$sOutput .= ($aRow[ $aColumns[$i] ]=="")?

					'"-",' :

					'"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';

			}else if ( $aColumns[$i] == "id_leitura" ) {

				$sOutput .= ($aRow[ $aColumns[$i] ]=="")?

						'"-",' :

						'"<a id=\"id_leitura\" href=\"detalhes_leitura.php?id='.$aRow[ $aColumns[$i] ].'\" style=\"font-weight:bolder;\" title=\"Clique para visualizar os detalhes da Leitura\">'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'</a>",';

			}else if ( $aColumns[$i] == "numero" ) {

				$sOutput .= ($aRow[ $aColumns[$i] ]=="")?

						'"-",' :

						'"<a id=\"id_maquina\" href=\"detalhe_maquina.php?id='.$aRow[ $aColumns[0] ].'\" style=\"font-weight:bolder;\" title=\"Clique para visualizar os detalhes da Maquina\">'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'</a>",';

			}else if ( $aColumns[$i] == "id_gerente" ) {

				

				//consulta o nome do gerente

				$sql_ger = "

					SELECT

						logins.nome

					FROM

						`logins`

					WHERE

						logins.id_login = '".$aRow[ $aColumns[$i] ]."'

					";

					

				$query_ger=@mysql_query($sql_ger);

				$result_ger=@mysql_fetch_assoc($query_ger);				

			

				$sOutput .= ($aRow[ $aColumns[$i] ]=="")?

						'"-",' :

						'"'.str_replace('"', '\"', $result_ger['nome']).'",';

			}			

			else if ( $aColumns[$i] == "excluido" ) {


				$sOutput .= ($aRow[ $aColumns[$i] ]=="S")?
	
					'"Excluido",' :
	
					'"",';
	

				/*
				//Verifica se o Local � Calabaza (10) para liberar o excluir
				if ( strstr($_SESSION['reg_acesso'],"'10'") ) {


					$sOutput .= ($aRow[ $aColumns[$i] ]=="S")?

						'"Excluido",' :

						'"",';

				}else{

					$sOutput .= '"Desativado",';

				}*/

			} else if ( $aColumns[$i] != ' ' ) {

				/* General output */

				$sOutput .= '"'.str_replace('"', '\"', $aRow[ $aColumns[$i] ]).'",';

			}

		}

		

		/*

		 * Optional Configuration:

		 * If you need to add any extra columns (add/edit/delete etc) to the table, that aren't in the

		 * database - you can do it here

		 */

		

		

		

		$sOutput = substr_replace( $sOutput, "", -1 );

		$sOutput .= "],";

	}

	$sOutput = substr_replace( $sOutput, "", -1 );

	$sOutput .= '] }';

	

	echo $sOutput;

?>