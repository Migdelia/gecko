<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
$total_colunas=6;

//Lendo os Niveis
$sql_nivel = "
	SELECT
		nivel.id_nivel,
		nivel.Descricao
	FROM
		nivel
	WHERE
		nivel.excluido='N'
	ORDER BY
		nivel.Descricao
	";

$query_nivel=@mysql_query($sql_nivel);

//Quantidade de Usuarios por nivel
$sql_qtd = "
	SELECT
		logins.id_nivel,
		COUNT(logins.id_login) AS qtd
	FROM
		logins
	WHERE
		logins.excluido='N'
	GROUP BY
		logins.id_nivel
	";

$query_qtd=@mysql_query($sql_qtd);
while ( $qtd_login = @mysql_fetch_assoc($query_qtd) ) {
	$qtd[$qtd_login['id_nivel']] = $qtd_login['qtd'];
}

//Montando o Nome de Cada Acordion com o Nome do Nivel
$nivel=array();
while( $nvl=@mysql_fetch_assoc($query_nivel) ) {
	$nivel[$nvl['id_nivel']]= "<h3><a href='#'>".$nvl['Descricao']." - ".($qtd[$nvl['id_nivel']]>=1?$qtd[$nvl['id_nivel']]." Usu&aacute;rio(s)":/*"<img src='img/inativo.png' alt='excluir' title='Excluir o Nivel' border='none' aling='absmiddle' onclick='alert(\"Deseja excluir este nivel ?\")'>"*/"")."</a></h3>";
}

//Montando os Acessos de Cada Nivel
$conteudo_nivel="";
foreach ($nivel as $chave=>$valor) {
	//Selecionando os Acessos para montar a Lista de Acessos para o Nivel
	$sql_ace = "
		SELECT
			menu.nome,
			menu.link,
			menu.icone,
			menu.id_menu,
			acesso.acesso
		FROM
			menu
			LEFT JOIN acesso ON acesso.id_menu=menu.id_menu	
				AND acesso.id_nivel=".$chave."
		WHERE
			menu.id_menu<>7
			AND menu.excluido='N'
		ORDER BY
			menu.nome ASC
		";
	$query_ace = @mysql_query($sql_ace);
	
	//Montando o Conteudo do Acordion
	$conteudo_nivel.=$valor;
	$conteudo_nivel.="\n\t\t\t<div>";
	$conteudo_nivel.="\n\t\t\t\t<table width='100%' border='0' align='left' cellpadding='2' cellspacing='4'>";
	$conteudo_nivel.="\n\t\t\t\t<tr bgcolor='#C0C0C0' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas."' style='color:#FFFFFF;'>Acesso ao Menus</th></tr>\n";
	$coluna=1;
	while ( $acessos = @mysql_fetch_assoc($query_ace) ) {
		//Formatando os Campos
		if ($coluna==1) {
			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
			$conteudo_nivel.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;'>\n";
		}

		$conteudo_nivel.="\t\t\t\t\t<td width='".(100/$total_colunas)."%'>\n";
		$conteudo_nivel.="\n\t\t\t\t\t\t<div style='float:left;'>";
		$conteudo_nivel.="\n\t\t\t\t\t\t\t<img src='img/menu/".$acessos['icone']."' title='".$acessos['nome']."' alt='".$acessos['nome']."' align='absmiddle' height='16px;'> ";
		$conteudo_nivel.=ucwords(strtolower($acessos['nome']));
		$conteudo_nivel.="\n\t\t\t\t\t\t</div>";
		$conteudo_nivel.="\n\t\t\t\t\t\t<img id='".($chave."_".$acessos['id_menu'])."'src='img/".($acessos['acesso']=='S'?'ativo.png':'inativo.png')."' title='".($acessos['acesso']=='S'?'REMOVER o acesso':'CONCEDER o acesso')."' alt='Acesso ao item:".$acessos['nome']."' align='absmiddle' height='16px;' style='float:right;margin-right:15px;cursor:pointer;' onclick='alterar_nivel(this.id);'> ";
		$conteudo_nivel.="\n\t\t\t\t\t</td>\n";

		if ($coluna==$total_colunas) {
			$conteudo_nivel.="\t\t\t\t</tr>\n";
			$coluna = 1;
		}else{
			$coluna++;
		}
	}
	if ($coluna != 1) {
		$conteudo_nivel.="\t\t\t\t</tr>\n";
	}

	$conteudo_nivel.="\n\t\t\t</table>\n";
	$conteudo_nivel.="\n\t\t\t<br clear='both' />\n";
		
	//Montando os Locais
	//Selecionando os Acessos para montar a Lista de Acessos para o Nivel
	$sql_reg = "
		SELECT
			local.nome,
			local.id_local,
			acesso_local.acesso
		FROM
			local
			LEFT JOIN acesso_local ON acesso_local.id_local=local.id_local
				AND acesso_local.id_nivel=".$chave."
		WHERE
			local.excluido='N'
		ORDER BY
			local.nome ASC
		";
	$query_reg = @mysql_query($sql_reg);
	
	//Montando o Conteudo do Acordion
	$total_colunas_r=3;
	$conteudo_nivel.="\n\t\t\t<table width='100%' border='0' align='left' cellpadding='2' cellspacing='4'>";
	$conteudo_nivel.="\n\t\t\t\t<tr bgcolor='#C0C0C0' height='21px;' style='font-weight:bolder' align='center'><th colspan='".$total_colunas_r."' style='color:#FFFFFF;'>Acesso aos Locais</th></tr>\n";

	$coluna_r=1;
	while ( $acessos_local = @mysql_fetch_assoc($query_reg) ) {
		//Formatando os Campos
		if ($coluna_r==1) {
			($cor_linha=='#F0F0F0'?$cor_linha='#EEF6F9':$cor_linha='#F0F0F0');
			$conteudo_nivel.="\n\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;'>\n";
		}

		$conteudo_nivel.="\t\t\t\t\t<td width='".number_format((100/$total_colunas_r),0)."%'>\n";
		$conteudo_nivel.="\t\t\t\t\t\t<div style='float:left;'>";
		$conteudo_nivel.="\n\t\t\t\t\t\t\t<img src='img/menu/home.png' title='".$acessos_local['nome']."' alt='".$acessos_local['nome']."' align='absmiddle' height='16px;'> ";
		$conteudo_nivel.=ucwords(strtolower($acessos_local['nome']));
		$conteudo_nivel.="\n\t\t\t\t\t\t</div>";
		$conteudo_nivel.="\n\t\t\t\t\t\t<img id='reg_".($chave."_".$acessos_local['id_local'])."'src='img/".($acessos_local['acesso']=='S'?'ativo.png':'inativo.png')."' title='".($acessos_local['acesso']=='S'?'REMOVER o acesso':'CONCEDER o acesso')."' alt='Acesso ao item:".$acessos_local['nome']."' align='absmiddle' height='16px;' style='float:right;margin-right:15px;cursor:pointer;' onclick='alterar_nivel(this.id);'> ";
		$conteudo_nivel.="\n\t\t\t\t\t</td>\n";

		if ($coluna_r==$total_colunas_r) {
			$conteudo_nivel.="\t\t\t\t</tr>\n";
			$coluna_r = 1;
		}else{
			$coluna_r++;
		}
	}
	if ($coluna_r != 1) {
		$conteudo_nivel.="\t\t\t\t</tr>\n";
	}
	$conteudo_nivel.="\n\t\t\t</table>\n";
	$conteudo_nivel.="\n\t\t&nbsp;</div>\n\t\t";
}
				
@mysql_free_result($query_nivel);
@mysql_free_result($query_qtd);
@mysql_free_result($query_ace);
@mysql_free_result($query_reg);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="url" content="<?php echo $dominio ?>">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<meta name="description" content="<?php echo $description?>" />
	<meta name="robots" content="noindex,nofollow">
	<title>..::Administrativo - <?php echo $description?> ::..</title>
	<!--<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />-->
	<link rel="icon" href="img/favicon.gif" type="image/gif" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=<?php echo $dominio ?>/nojavascript.html" />
	</noscript>

	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.dimensions.js"></script>
	<script type="text/javascript" src="js/jquery.positionBy.js"></script>
	<script type="text/javascript" src="js/jquery.jdMenu.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.3.js"></script>
	<script type="text/javascript" src="js/ajax.js"></script>
	<script type="text/javascript" language="javascript" src="js/functions.js"></script>
	<script>
		$(function() {
			$( "#accordion" ).accordion();
		});
/*		jQuery(document).ready(function(){
			$('.accordion .head').click(function() {
				$(this).next().toggle('slow');
				return false;
			}).next().hide();
		});
*/		var alterar_nivel=function(v){
			var ant=$("#"+v).attr("src");
			$("#"+v).attr("src","img/aguarde_ico.gif");
			new Ajax({
				Url:'functions/alterar_acesso.php?ida='+v,
				funcao:function(a){
					var vc =(a.responseText);
					if(vc == 'no'){
						alert('ATENCAO. Ocorreu um problema ao atualizar o Acesso.');
						$("#"+v).attr("src",ant);
					}else{
						$("#"+v).attr("src","img/"+vc);
					}
				},
				ajaxErro: function(){
					return false;
				}
			});
		}
	</script>

	<style type="text/css" title="currentStyle">
		@import "css/media/themes/smoothness/<?=$theme?>";
		<!--
		body {font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:11px;}
		td:hover{background-color:#FFD1A4;}
		-->
	</style>
	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php
		echo menu_builder();
	?>
	<div id='div_conteudo'>
		<div id="accordion">
			<?php
				echo $conteudo_nivel;
			?>
		</div>
	</div>
</body>
</html>