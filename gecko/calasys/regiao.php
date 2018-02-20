<?php
//Fechamento de sessao ao fechar o navegador
session_start();

include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
unset($_SESSION['campos']);

//Lendo a tabela de Locais
$sql_log = "
	SELECT
		vw_regiao.id_cidade,
		vw_regiao.nome_cidade,
		vw_regiao.excluido
	FROM
		vw_regiao
	";

$query_log=@mysql_query($sql_log);

//Montando a Combo de Locais
$ev_pesquisa="[";
while ( $acesso = @mysql_fetch_assoc($query_log) ) {
	$ev_pesquisa.= "'".($acesso['cidades'])."',";
}
$ev_pesquisa = substr($ev_pesquisa,0,-1)."]";

//Pegando o titulo de cada coluna de cabeçalho
$cab ="\n\t<thead>";
$cab.="\n\t\t<tr>";
$n_campos= @mysql_num_fields($query_log);
$filtro=array('STR_','_');
for ($i=0;$i<$n_campos;$i++ ) {
	$cmp = @mysql_field_name($query_log,$i);
	$_SESSION['campos'].=$cmp."||";
	$cab.="\n\t\t\t<th>".str_replace($filtro,' ',$cmp)."</th>";
}
$_SESSION['campos']=base64_encode(substr($_SESSION['campos'],0,-2));
$cab.="\n\t\t</tr>";
$cab.="\n\t</thead>";


//Pegando o titulo de cada coluna de rodape
$rod ="\n\t<tfoot>";
$rod.="\n\t\t<tr>";
for ($i=0;$i<$n_campos;$i++ ) {
	$cmp = @mysql_field_name($query_log,$i);
	//$rod.="\n\t\t\t<th><input type='text' style='width:150px;' value='Localizar ".ucwords(strtolower(str_replace($filtro,' ',$cmp)))."' class='search_init'></th>";
	$rod.="\n\t\t\t<th>".($cmp=='Nivel'?"<input type='hidden' style='width:150px;' value='Localizar ".ucwords(strtolower(str_replace($filtro,' ',$cmp)))."' class='search_init'><span></span>":"<input type='text' style='width:150px;' value='Localizar ".ucwords(strtolower(str_replace($filtro,' ',$cmp)))."' class='search_init'>")."</th>";
	//$rod.="\n\t\t\t<th>".str_replace($filtro,' ',$cmp)."</th>";
	$ocultar.=str_repeat('&nbsp;',2)."<span onclick='fnShowHide(".$i.")'>".($i+1)."</span>";
}
$rod.="\n\t\t</tr>";
$rod.="\n\t</tfoot>";

//Montando a tabela com os dados
$tabela = "\n<table cellpadding='0' cellspacing='0' border='0' class='display' id='example'>";
$tabela.= $cab;
$tabela.= "\n\t<tbody>";
$tabela.= "\n\t\t<tr>";
$tabela.= "\n\t\t\t<td colspan='".$n_campos."' class='dataTables_empty'>Aguarde... Carregando a informação</td>";
$tabela.= "\n\t\t</tr>";
$tabela.="\n\t</tbody>";
$tabela.=$rod;
$tabela.="\n<table>\n"/*.$ocultar*/;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="url" content="<?php echo $dominio ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="<?php echo $description?>" />
	<meta name="robots" content="noindex,nofollow">
	<title>..::Administrativo - <?php echo $description?> ::..</title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.dimensions.js"></script>
	<script type="text/javascript" src="js/jquery.positionBy.js"></script>
	<script type="text/javascript" src="js/jquery.jdMenu.js"></script>
	<script type="text/javascript" language="javascript" src="js/functions.js"></script>
	<script type="text/javascript" language="javascript" src="js/media/js/jquery.dataTables.js"></script>
	<script type="text/javascript" language="javascript" src="js/media/jquery.jeditable.js"></script>
    
	<style type="text/css" title="currentStyle">
		@import "css/media/css/demo_page.css";
		@import "css/media/css/demo_table.css";
		@import "css/media/css/demo_table_jui.css";
		@import "css/media/themes/smoothness/<?=$theme?>";
		<!--
		body {font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:11px;}
		b {color:#FF0000;}
		-->
	</style>

	<script type="text/javascript" charset="utf-8">
		var altura=(screen.height)-400;
		/* Define two custom functions (asc and desc) for string sorting */
		jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
			return ((x < y) ? -1 : ((x > y) ?  1 : 0));
		};
		
		jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
			return ((x < y) ?  1 : ((x > y) ? -1 : 0));
		};
		
		(function($) {
		/*
		 * Function: fnGetColumnData
		 * Purpose:  Return an array of table values from a particular column.
		 * Returns:  array string: 1d data array 
		 * Inputs:   object:oSettings - dataTable settings object. This is always the last argument past to the function
		 *           int:iColumn - the id of the column to extract the data from
		 *           bool:bUnique - optional - if set to false duplicated values are not filtered out
		 *           bool:bFiltered - optional - if set to false all the table data is used (not only the filtered)
		 *           bool:bIgnoreEmpty - optional - if set to false empty values are not filtered from the result array
		 * Author:   Benedikt Forchhammer <b.forchhammer /AT\ mind2.de>
		 */
		$.fn.dataTableExt.oApi.fnGetColumnData = function ( oSettings, iColumn, bUnique, bFiltered, bIgnoreEmpty ) {
			
			// check that we have a column id
			if ( typeof iColumn == "undefined" ) return new Array();			
			
			// by default we only wany unique data
			if ( typeof bUnique == "undefined" ) bUnique = true;
			
			// by default we do want to only look at filtered data
			if ( typeof bFiltered == "undefined" ) bFiltered = true;
			
			// by default we do not wany to include empty values
			if ( typeof bIgnoreEmpty == "undefined" ) bIgnoreEmpty = true;
			
			// list of rows which we're going to loop through
			var aiRows;
			
			// use only filtered rows
			if (bFiltered == true) aiRows = oSettings.aiDisplay; 
			// use all rows
			else aiRows = oSettings.aiDisplayMaster; // all row numbers
		
			// set up data array	
			var asResultData = new Array();
			
			for (var i=0,c=aiRows.length; i<c; i++) {
				iRow = aiRows[i];
				var aData = this.fnGetData(iRow);
				var sValue = aData[iColumn];
				
				// ignore empty values?
				if (bIgnoreEmpty == true && sValue.length == 0) continue;
		
				// ignore unique values?
				else if (bUnique == true && jQuery.inArray(sValue, asResultData) > -1) continue;
				
				// else push the value onto the result data array
				else asResultData.push(sValue);
			}
			return asResultData;
		}}(jQuery));
		

		function fnCreateSelect( aData )
		{
			aData=<?=$ev_pesquisa?>;
			var r='<select style="color:#999999; width:160px;"><option value="">Todos</option>', i, iLen=aData.length;
			for ( i=0 ; i<iLen ; i++ ) {
				alert(iLen);
				r += '<option value="'+aData[i]+'">'+aData[i]+'</option>';
			}
			return r+'</select>';
		}

		$(document).ready(function() {
			var oTable = $('#example').dataTable( {
				"bSortClasses": false,
				"oLanguage": {
					"sProcessing": "... Consultando ...<br /><img src='img/aguarde.gif' align='aguarde' alt='aguarde'>",
					"sLengthMenu": "Mostrar _MENU_ itens por página.",
					"sZeroRecords": "Ninguno iten encontrado.",
					"sInfo": "Mostrando de _START_ hasta _END_ de _TOTAL_ itens.",
					"sInfoEmpty": "Mostrando de 0 hasta 0 de 0 itens.",
					"sInfoFiltered": "(Filtrados de _MAX_ itens.)",
					"sSearch": "Buscar Todos los itens:",
					"oPaginate": {
						"sFirst":    "Primera",
						"sPrevious": "Anterior",
						"sNext":     "Seguinte",
						"sLast":     "Ultima"
					}
				},
				"aaSorting": [[ 1, "asc" ]],
				/*"aoColumns": [ {"bSearchable":true,"bVisible":true},null,null,null,null],*/
				"bStateSave": false,
				"sScrollY": altura,
				"bJQueryUI": true,
				"sPaginationType": "full_numbers",
				"aoColumns": [ {"bSearchable":true,"bVisible":true},null,null],
				"aLengthMenu": [[10, 20 ], [10, 20 ]],
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": "functions/server_processing1.php?idc=<?=$_SESSION['campos']?>&idi=<?=base64_encode('id_cidade')?>&idt=<?=base64_encode('vw_regiao')?>",
				"fnRowCallback": 
					function( nRow, aData, iDisplayIndex ) {
						var id = aData[0];
						var id_td = ['ID_CAMPO','<?=str_replace("||","','",base64_decode($_SESSION['campos']))?>'];
						var iLen1 = id_td.length;
						$(nRow).attr("id",id);
						for ( i=0 ; i<iLen1 ; i++ ) {
							$('td:nth-child('+(i)+')', oTable.fnGetNodes()).attr("id",id_td[i]);
						}
						return nRow;
					},
				"fnDrawCallback": fnOpenClose
			} );

			$('td', oTable.fnGetNodes()).hover( function() {
				var iCol = $('td').index(this) % <?=$n_campos?>;
				var nTrs = oTable.fnGetNodes();
				$('td:nth-child('+(iCol+1)+')', nTrs).addClass( 'highlighted' );
			}, function() {
				$('td.highlighted', oTable.fnGetNodes()).removeClass('highlighted');
			} );

			/* Add a select menu for each TH element in the table footer */
			$("tfoot th span").each( function ( i ) {
				//Coluna a ser filtrada
				i=3;
				this.innerHTML = fnCreateSelect( oTable.fnGetColumnData(i) );
				$('select', this).change( function () {
					oTable.fnFilter( $(this).val(), i );
				} );
			} );
			
			//Pesquisa das colunas
			var asInitVals = new Array();
			$("tfoot input").keyup( function () {
				/* Filter on the column (the index) of this element */
				oTable.fnFilter( this.value, $("tfoot input").index(this) );
			} );

			/*
			 * Support functions to provide a little bit of 'user friendlyness' to the textboxes in 
			 * the footer
			 */
			$("tfoot input").each( function (i) {
				asInitVals[i] = this.value;
			} );
			
			$("tfoot input").focus( function () {
				if ( this.className == "search_init" )
				{
					this.className = "";
					this.value = "";
				}
			} );
			
			$("tfoot input").blur( function (i) {
				if ( this.value == "" )
				{
					this.className = "search_init";
					this.value = asInitVals[$("tfoot input").index(this)];
				}
			} );
		} );

		function fnOpenClose ( oSettings ) {
			var oTable = $('#example').dataTable();
			/* Apply the jEditable handlers to the table */
			$('#example tbody tr td:nth-child(2)').editable( 'functions/editable_ajax.php', {
				"callback": function( sValue, y ) {
					var aPos = oTable.fnGetPosition( this );
					oTable.fnUpdate( sValue, aPos[0], aPos[1] );
				},
				"submitdata": function ( value, settings ) {
					return {
						"table":'regiao',
						"mkey":"id_cidade",
						"row_id": this.parentNode.getAttribute('id'),
						"column": oTable.fnGetPosition( this )[2]
					};
				},
				"height": "14px",
				"placeholder":"<b>Clique para Editar</b>"
			} );
			
			<?php
			if ( strstr($_SESSION['reg_acesso'],"'10'") ) {
			?>
				$('#example tbody tr td:nth-child(3)').editable( 'functions/editable_ajax.php', {
					data	: "{'':'','Sim':'Excluir'}",
					type	: 'select',
					submit	: 'OK',
					cancel	: 'Cancel',
					width	: '80%',
					tooltip:	'Clique para excluir esta cidade.',
					"callback": function( sValue, y ) {
						//var aPos = oTable_assoc.fnGetPosition( this );
						//oTable_assoc.fnUpdate( sValue, aPos[0], aPos[1] );
						return sValue;
					},
					"submitdata": function ( value, settings ) {
						return {
						"table":'regiao',
						"mkey":"id_cidade",
						"row_id": this.parentNode.getAttribute('id'),
						"column": oTable.fnGetPosition( this )[2]
						};
					},
					"height":"14px",
					"placeholder":"<b><img src='img/lixeira.png' alt='Excluir' title='Excluir esta cidade' /></b>"
				} );
			<?php			
			}
			?>
		}
		
		function fnShowHide( iCol ) {
			/* Get the DataTables object again - this is not a recreation, just a get of the object */
			var oTable = $('#example').dataTable();
			var bVis = oTable.fnSettings().aoColumns[iCol].bVisible;
			oTable.fnSetColumnVis( iCol, bVis ? false : true );
		}
		
		function redireciona()
		{
			location="parametros.php?flag=cidade";
		}
		
	</script>
	<link rel="icon" href="img/favicon.gif" type="image/gif" />
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=<?php echo $dominio ?>/nojavascript.html" />
	</noscript>
	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php
		echo menu_builder();	
	?>
	<br clear="all" />
	<div id='div_conteudo'>
		<?php
			echo $tabela;
		?>
	</div>
	<div id='addregistro'>
    	<a onclick="redireciona();" target="_blank" style="text-decoration:none;">
        	<img src="img/plus.png" border="0" />
            <strong>Agregar Ciudad</strong>
        </a>
	</div>    
</body>
</html>