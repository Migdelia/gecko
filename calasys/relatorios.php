<?php

session_start();

include('conn/conn.php');

include('functions/functions.php');

include('functions/lg_validador.php');

//Campos a serem exibidos na personaliza��o de relatorios (vw_relatorios)

$personalizados = array(

	'cpf',

	'nome',

	'email',

	'sexo',

	'data_nascimento',

	'tel_res',

	'cel',

	'fax',

	'cep_res',

	'endereco_res',

	'comp_res',

	'numero_res',

	'bairro_res',

	'cidade_res',

	'uf_res',

	'data_utilizacao',

	'cartao',

	'selo',

	'qtd_selo_cartao',

	'usuario'

);



//Selecionando os relatorios na tabela

$sql_relatorio = "SELECT vw_favoritos.id_relatorio,vw_favoritos.id_login,vw_favoritos.nome,vw_favoritos.tipo,vw_favoritos.area,vw_favoritos.favorito FROM vw_favoritos WHERE (vw_favoritos.favorito='".$_SESSION['usuario']."' OR vw_favoritos.favorito IS NULL) GROUP BY vw_favoritos.id_relatorio ORDER BY vw_favoritos.area,vw_favoritos.favorito DESC,vw_favoritos.ordem,vw_favoritos.nome";

$query_relatorio=@mysql_query($sql_relatorio);



//Montando as abas e conteudos

$anterior = "";

$li= "\n";

$div="\n";



//Para area de Favoritos

$li_fav = "\n\t\t\t\t<li><img src='img/relatorios/estrela_a.png' width='24px' title='Favoritos' align='absmiddle' alt='Favoritos' style='margin:2px;' />".$_SESSION['usuario']."</li>";

$div_fav= "\n\t\t\t\t<div>\n\t\t\t\t\t<h4>Relat&oacute;rios - Favoritos de ".$_SESSION['usuario']."</h4>";

$div_fav.="\n\t\t\t\t\t<div class='rel_container' id='div_favoritos'>";



//Para area de Personalizar

$li_per = "\n\t\t\t\t<li><img src='img/relatorios/estrela_a.png' width='24px' title='Criar' align='absmiddle' alt='Personalizados' style='margin:2px;' />Novos</li>";

$div_per= "\n\t\t\t\t<div>\n\t\t\t\t\t<h4>Relat&oacute;rios - Personaliza&ccedil;&atilde;o de relat&oacute;rios de ".$_SESSION['usuario']."</h4>";

$div_per.="\n\t\t\t\t\t<div class='rel_container' id='div_personalizados'>";




		$div.="\n\t\t\t\t\t\t<select id='semana' name='semana'>

								<option value='0'>Elegir</option>

                				<option value='1'>Semana 1</option>

								<option value='2'>Semana 2</option>

								<option value='3'>Semana 3</option>

								<option value='4'>Semana 4</option>

								<option value='5'>Semana 5</option>

           					 </select>";

		$div.="\n\t\t\t\t\t\t<select id='mes' name='mes'>

								<option value='0'>Elegir</option>

                				<option value='1'>Enero</option>

								<option value='2'>Febrero</option>

								<option value='3'>Marzo</option>

								<option value='4'>Abril</option>

								<option value='5'>Mayo</option>

								<option value='6'>Junio</option>

								<option value='7'>Julio</option>

								<option value='8'>Agosto</option>

								<option value='9'>Septiembre</option>

								<option value='10'>Octubre</option>

								<option value='11'>Noviembre</option>

								<option value='12'>Deciembre</option>

           					 </select>";

							

		$div.="\n\t\t\t\t\t\t<select id='ano' name='ano'>

								<option value='0'>Elegir</option>

                				<option value='2013'>2013</option>

								<option value='2014'>2014</option>

								<option value='2015'>2015</option>
								
								<option value='2016'>2016</option>
								
								<option value='2017'>2017</option>

           					 </select>";	



$i=0;

while ($result_relatorio=@mysql_fetch_assoc($query_relatorio) ) {

	//Verifica se o usuario tem acesso a esta area. Caso tenha, exibe o relatorio

	if (strtoupper(tem_acesso_item($result_relatorio['area']))=='S') {

		if ($i>=1) {

			if ($result_relatorio['area']!=$anterior) {

				//Fechando a DIV do conteudo

				$div.="\n\t\t\t\t\t</div>";

	

				//Area do Preview dos relatorios

				$div.="\n\t\t\t\t\t<div class='rel_container_preview' id='div_".$anterior."_preview'>";

				$div.="\n\t\t\t\t\t\t<p id='preview_".$anterior."'>";

				$div.="\n\t\t\t\t\t\t\t<strong style='font-size:13px'>Relat&oacute;rios - Pr&eacute;-visualiza&ccedil;&atilde;o: </strong><br />";

				$div.="\n\t\t\t\t\t\t</p>";

				$div.="\n\t\t\t\t\t</div>";

				

				$div.="\n\t\t\t\t</div>";

				$i=0;

				$anterior="";

			}

		}

		

		//Montando a area FAVORITOS

		if ($result_relatorio['favorito']==$_SESSION['usuario']) {

			$div_fav.="\n\t\t\t\t\t\t<div class='relatorio_item' id='favorito_".$result_relatorio['id_relatorio']."'>";

			$div_fav.="\n\t\t\t\t\t\t\t\t<img id='fav_".$result_relatorio['id_relatorio']."_".$result_relatorio['id_login']."' src='img/relatorios/".($result_relatorio['favorito']==$_SESSION['usuario']?"estrela_a":"estrela_i").".png' width='24px' title='".($result_relatorio['favorito']==$_SESSION['usuario']?"Remover dos Favoritos":"Adicionar a Favoritos")."' align='absmiddle' alt='Favoritos' style='margin:2px;cursor:pointer;' onclick='alterar_favorito(this.id,0)' />";

			$div_fav.="\n\t\t\t\t\t\t\t\t<span onclick=\"preview_dados('".$result_relatorio['id_relatorio']."','favoritos')\">".$result_relatorio['nome']."</span>";

			$div_fav.="\n\t\t\t\t\t\t</div>";

	

		}

		if ($result_relatorio['area']!=$anterior) {

			//Aba Lateral

			$li.="\n\t\t\t\t<li><img id='imgrel_".$result_relatorio['id_relatorio']."' src='img/relatorios/".strtolower($result_relatorio['area']).".png' width='24px' title='".strtolower($result_relatorio['area'])."' align='absmiddle' alt='".strtolower($result_relatorio['area'])."' style='margin:2px;' />".ucwords(strtolower($result_relatorio['area']))."</li>";

			//Div Conteudo

			$div.="\n\t\t\t\t<div>\n\t\t\t\t\t<h4>Relat&oacute;rios - ".ucwords(strtolower($result_relatorio['area']))."</h4>";

			$div.="\n\t\t\t\t\t<div class='rel_container' id='div_".$result_relatorio['area']."'>";

			$anterior=$result_relatorio['area'];

		}

		//Conteudo (Guia Relatorios exibe apenas os relatorios criados pelo usuario.	

		if ( $result_relatorio['area']!='Relatorios' ) {

			$div.="\n\t\t\t\t\t\t<p class='relatorio_item' id='relatorio_".$result_relatorio['id_relatorio']."'>";




			//fazer condicao para nivel parceiros nao ver o promedio de maquina
			if($_SESSION['usr_nivel'] == 11)
			{
				//verificar que relatorio �
				if($result_relatorio['id_relatorio'] == 2)
				{
					$div.="\n\t\t\t\t\t\t\t\t<img id='imgrel_".$result_relatorio['id_relatorio']."_".$result_relatorio['id_login']."' src='img/relatorios/".($result_relatorio['favorito']==$_SESSION['usuario']?"estrela_a":"estrela_i").".png' width='24px' title='".($result_relatorio['favorito']==$_SESSION['usuario']?"Remover dos Favoritos":"Adicionar a Favoritos")."' align='absmiddle' alt='Favoritos' style='margin:2px;cursor:pointer;' onclick='alterar_favorito(this.id,".$i.")' />";					
					
					$div.="\n\t\t\t\t\t\t\t\t<span onclick=\"preview_dados('".$result_relatorio['id_relatorio']."','".$result_relatorio['area']."')\">".$result_relatorio['nome']."</span>";					
				}
			}
			else
			{
				$div.="\n\t\t\t\t\t\t\t\t<img id='imgrel_".$result_relatorio['id_relatorio']."_".$result_relatorio['id_login']."' src='img/relatorios/".($result_relatorio['favorito']==$_SESSION['usuario']?"estrela_a":"estrela_i").".png' width='24px' title='".($result_relatorio['favorito']==$_SESSION['usuario']?"Remover dos Favoritos":"Adicionar a Favoritos")."' align='absmiddle' alt='Favoritos' style='margin:2px;cursor:pointer;' onclick='alterar_favorito(this.id,".$i.")' />";	
							
				$div.="\n\t\t\t\t\t\t\t\t<span onclick=\"preview_dados('".$result_relatorio['id_relatorio']."','".$result_relatorio['area']."')\">".$result_relatorio['nome']."</span>";				
			}



		}else if ( $result_relatorio['tipo']==$_SESSION['usuario'] ) {

			$div.="\n\t\t\t\t\t\t<p class='relatorio_item' id='relatorio_".$result_relatorio['id_relatorio']."'>";

			$div.="\n\t\t\t\t\t\t\t\t<img id='imgrel_".$result_relatorio['id_relatorio']."_".$result_relatorio['id_login']."' src='img/relatorios/".($result_relatorio['favorito']==$_SESSION['usuario']?"estrela_a":"estrela_i").".png' width='24px' title='".($result_relatorio['favorito']==$_SESSION['usuario']?"Remover dos Favoritos":"Adicionar a Favoritos")."' align='absmiddle' alt='Favoritos' style='margin:2px;cursor:pointer;' onclick='alterar_favorito(this.id,".$i.")' />";

			$div.="\n\t\t\t\t\t\t\t\t<span onclick=\"preview_dados('".$result_relatorio['id_relatorio']."','".$result_relatorio['area']."')\">".$result_relatorio['nome']."</span>";

		}

		//$div.="\n\t\t\t\t\t\t\t\t".$result_relatorio['nome'];

		$div.="\n\t\t\t\t\t\t</p>";

		/*

		$div.="\n\t\t\t\t\t\tSemana 

							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 

							Mes 

							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

							Ano

							<br />";*/

		
													 

		

		/*

		$div.="\n\t\t\t\t\t\t <input type='text' id='datepicker' size='12' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;' readonly='readonly'>";*/



		

		$i++;

		$ultimo=$result_relatorio['area'];

	}

}

$li.= "\n";

$div.="\n\t\t\t\t\t</div>";



//Area do Preview dos relatorios

$div.="\n\t\t\t\t\t<div class='rel_container_preview' id='div_".$ultimo."_preview'>";

$div.="\n\t\t\t\t\t\t<p id='preview_".$ultimo."'>";

$div.="\n\t\t\t\t\t\t\t<strong style='font-size:13px'>Relat&oacute;rios - Pr&eacute;-visualiza&ccedil;&atilde;o: </strong><br />";

$div.="\n\t\t\t\t\t\t</p>";

$div.="\n\t\t\t\t\t</div>";



$div.="\n\t\t\t\t</div>";

$div.="\n";



//Area do Preview dos relatorios Favoritos

$div_fav.="\n\t\t\t\t\t</div>";

$div_fav.="\n\t\t\t\t\t<div class='rel_container_preview' id='div_favoritos_preview'>";

$div_fav.="\n\t\t\t\t\t\t<p id='preview_favoritos'>";

$div_fav.="\n\t\t\t\t\t\t\t<strong style='font-size:13px'>Relat&oacute;rios - Pr&eacute;-visualiza&ccedil;&atilde;o: </strong><br />";

$div_fav.="\n\t\t\t\t\t\t</p>";

$div_fav.="\n\t\t\t\t\t</div>";

$div_fav.= "\n\t\t\t\t</div>";



//Area dos Personalizados

$div_per.="\n\t\t\t\t\t\t<form name='form_criterio' id='form_criterio' method='post' >";

$div_per.="\n\t\t\t\t\t\t<div style='border:".$cor_detalhes." dotted 1px;width:28%;float:left;margin:1px;padding:4px;overflow:auto;height:150px;'>";

$div_per.="\n\t\t\t\t\t\t\t<h4>Campos</h4>";

$div_per.="\n\t\t\t\t\t\t\t<hr style='background-color:".$cor_detalhes.";border:none;height:3px;margin-bottom:4px;' />";

//Campos a serem exibidos nos filtros

$div_per.="\n\t\t\t\t\t\t\t".montar_campos_busca( $personalizados );

$div_per.="\n\t\t\t\t\t\t</div>";

//Parte dos criterios a serem exibidos

$div_per.="\n\t\t\t\t\t\t<div style='border:".$cor_detalhes." dotted 1px;width:65%;float:left;margin:1px;padding:4px;overflow:auto;height:150px;'>";

$div_per.="\n\t\t\t\t\t\t\t<h4>Crit&eacute;rios</h4>";

$div_per.="\n\t\t\t\t\t\t<hr style='background-color:".$cor_detalhes.";border:none;height:3px;margin-bottom:4px;' />";

$div_per.="\n\t\t\t\t\t\t".busca_relatorio($_SESSION['qtd_pesquisa_relatorio']);

$div_per.="\n\t\t\t\t\t\t</div>";

$div_per.="\n\t\t\t\t\t\t<br clear='all' />";

$div_per.="\n\t\t\t\t\t\t<input id='ano_corrente' name='ano_corrente' type='checkbox' class='ui-icon ui-icon-check' style='float:left;'>Apenas Ano ".date('Y')." ";

$div_per.="\n\t\t\t\t\t\t<button id='btn_personalizar_relatorio' type='button' class='bt-enviar'>Visualizar</button>";

$div_per.="\n\t\t\t\t\t\t</form>";

//Pre visualiza��o

$div_per.="\n\t\t\t\t\t</div>";

$div_per.="\n\t\t\t\t\t<div class='rel_container_preview' id='div_personalizados_preview'>";

$div_per.="\n\t\t\t\t\t\t<p id='preview_personalizados'>";

$div_per.="\n\t\t\t\t\t\t\t<strong style='font-size:13px'>Relat&oacute;rios - Pr&eacute;-visualiza&ccedil;&atilde;o: </strong><br />";

$div_per.="\n\t\t\t\t\t\t</p>";

$div_per.="\n\t\t\t\t\t</div>";

$div_per.= "\n\t\t\t\t</div>";



//Apenas quem tem acesso ao financeiro pode criar relatorios

if ( tem_acesso_item('Financeiro')!='S' ) {

	$li_per='';

	$div_per='';

}

?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">

<head>

	<meta name="url" content="http://www.sogesp.com.br/">

	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />

	<meta name="descri��o" content="SOGESP - Associa��o de Obstetr�cia e Ginecologia do Estado de S�o Paulo" />

	<meta name="robots" content="noindex,nofollow">

	<title>..::Administrativo - Associados::..</title>

	<script type="text/javascript" language="javascript" src="js/jquery.js"></script>

	<script type="text/javascript" language="javascript" src="js/functions.js"></script>

	<script type="text/javascript" language="javascript" src="js/jquery.dimensions.js"></script>

	<script type="text/javascript" language="javascript" src="js/jquery.positionBy.js"></script>

	<script type="text/javascript" language="javascript" src="js/jquery.jdMenu.js"></script>

	<script type="text/javascript" language="javascript" src="js/jquery-ui-1.8.3.js"></script>

	<script type="text/javascript" language="javascript" src="js/media/jquery.ui.datepicker-pt-BR.js"></script>

	<script type="text/javascript" language="javascript" src="js/jquery.price_format.1.0.js"></script>

    <script type="text/javascript" src="js/media/jquery.jeditable.datepicker.js"></script>

	<script type="text/javascript" language="javascript" src="js/ajax.js"></script>

    

	<script type="text/javascript" charset="utf-8">



	$(function() {

		$("#datepicker").datepicker({dateFormat: 'dd-mm-yy'});

	});

	

	</script>

    

    

    

	<style type="text/css" title="currentStyle">

		@import "css/media/themes/smoothness/<?=$theme?>";

		<!--

		body {font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:10px;}

		button {font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:8px;}

		.rel_container{width:95%;margin:20px 10px 10px 10px;/*float:left;*/max-height:180px;overflow-x:hidden; border:<?=$cor_detalhes?> dotted 1px;padding:10px;}

		.relatorio_item{line-height:25px;width:190px;float:left;}

		.relatorio_item:hover{font-weight:bolder;cursor:pointer;}

		.rel_container_preview{width:95%;margin:20px 10px 10px 10px;/*float:left*/;max-height:400px;overflow:auto;border:<?=$cor_detalhes?> dotted 1px;padding:10px;}

		table{white-space:nowrap;border:1px solid #95B3D7;border-top:none;border-bottom:none;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif; font-size:10px;}

		th{font-size:8pt;color:white;font-weight:700;font-family:Tahoma;border-width:0.5pt 0.5pt 0.5pt medium; border-style:solid solid solid none;border-color:#95B3D7;background-color:#4F81BD;padding:4px;}

		td{font-size:8pt;color:black;font-weight:400;font-family:Tahoma;border-width:medium 0.5pt 0.5pt medium;border-style: none solid solid none;border-color:#95B3D7;padding:5px;text-align:left;padding:4px;text-decoration:none;}

		#vtab {margin:auto;width:95%;height:100%;}

		#vtab > ul > li {font-size:11px; font-weight:bolder;width:110px;padding:5px 0px 5px 0px;background-color:#FFFFFF !important;list-style-type:none;display:block;text-align:left;margin:auto;border:1px solid #FFFFFF;position:relative;border-right:none;opacity: .3;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=30)";filter: progid:DXImageTransform.Microsoft.Alpha(Opacity=30);}

		#vtab > ul > li.selected {opacity:1;-ms-filter:"progid:DXImageTransform.Microsoft.Alpha(Opacity=100)";filter:progid:DXImageTransform.Microsoft.Alpha(Opacity=100);border:1px solid #dddddd;border-right:none;z-index:10;background-color:#fafafa !important;position:relative;}

		#vtab > ul {float:left;width:110px;text-align:left;display:block;margin:auto 0;padding:0;position:relative;top:30px;}

		#vtab > div {background-color:#fafafa;margin-left:110px;border:1px solid #ddd;min-height:500px;padding:12px;z-index:9;-moz-border-radius:20px;}

		#vtab > div > h4 {color:#414A4F;font-size:1.2em;border-bottom:2px dotted <?=$cor_detalhes?>;padding-top:5px;margin-top:0;}

		#vtab > ul > li.selected{border-right:1px solid #fff !important;}

		#vtab > ul > li {border-right:1px solid #ddd !important;}

		#vtab > div {z-index:-1 !important;left:1px;}

		#ui-datepicker-div {font-size:13px}

		-->

	</style>

	<script type="text/javascript" language="javascript" charset="utf-8">

		$(function(){	

			//Responsavel por salvar a query Personalizada

			$("#btn_salvar_relatorio").live('click',function(event){

				var name = $( "#nome_rel" ).val();

				var save = $( "#salvar_rel" ).val();

				$("#preview_personalizados").html('<img src="img/aguarde_ico.gif" alt="aguarde" title="Aguarde...Processando" /> Aguarde... Processando.');

				event.preventDefault();

				$.post('functions/carregar_preview.php?ida=c2FsdmFy', {

					nome_rel:name,

					salvar_rel:save

				},

				function(json){

					if(json == 'no'){

						alert('ATENCAO. Ocorreu um problema ao gerar a visualiza��o.\nEntre em contat com o administrador do sistema.');

						$("#preview_personalizados").html('');

					}else{

						$("#preview_personalizados").html(json);

					}

				});

			});

			

			$.datepicker.setDefaults($.datepicker.regional['pt-BR']);

			<?

				//Monta a rotina de formata��o dos campos de criterios

				echo montar_js_controle_campos($_SESSION['qtd_pesquisa_relatorio'],$personalizados);

			?>

			var $items = $('#vtab>ul>li');

			$items.mouseover(function() {

				$items.removeClass('selected');

				$(this).addClass('selected');

			

				var index = $items.index($(this));

				$('#vtab>div').hide().eq(index).show();

			}).eq(0).mouseover();

		});

		//Alterar Favoritos

		var alterar_favorito=function(v){

			if (confirm('Aten��o!\n\nDeseja alterar a configura��o de favoritos para este relat�rio?')) {

				var ant=$("#"+v).attr("src");

				$("#"+v).attr("src","img/aguarde_ico.gif");

				new Ajax({

					Url:'functions/alterar_favorito.php?ida='+v,

					funcao:function(a){

						var vc =(a.responseText);

						if(vc == 'no'){

							alert('ATENCAO. Ocorreu um problema ao atualizar o Favorito.');

							$("#"+v).attr("src",ant);

						}else{

							var itens = vc.split(':');

							if (itens[0]=='Excluido') {

								$("#favorito_"+itens[1]).remove();

								$("#imgrel_"+itens[1]+"_"+itens[2]).attr("src","img/relatorios/estrela_i.png");

							}else if (itens[0]=='Adiciona') {

								$("#div_favoritos").append("<div class='relatorio_item' id='favorito_"+itens[1]+"'><img id='fav_"+itens[1]+"_"+itens[2]+"' src='img/relatorios/estrela_a.png' width='24px' title='Remover dos Favoritos' align='absmiddle' alt='Favoritos' style='margin:2px;cursor:pointer;' onclick='alterar_favorito(this.id,0)' /><span  onclick=\"preview_dados('"+itens[1]+"','favoritos')\">"+itens[3]+"</span></div>");

								$("#imgrel_"+itens[1]+"_"+itens[2]).attr("src","img/relatorios/estrela_a.png");

							}

						}

					},

					ajaxErro: function(){

						return false;

					}

				});

			}	

		}

		//Montando o Preview do relatorio

		function preview_dados(id,area) {

			//var semFecha =$('#datepicker').attr("value");

			var semFecha =$('#semana').attr("value");

			var mesFecha =$('#mes').attr("value");

			var anoFecha =$('#ano').attr("value");

			

			//teste erico

			if(semFecha == "0")

			{

				alert("Elegir una semana");

				return false;

			}

			else if(mesFecha == "0")

			{

				alert("Elegir un mes");

				return false;

			}

			else if(anoFecha == "0")

			{

				alert("Elegir un ano");

				return false;

			}					



			

			//teste erico

			

			

			$("#preview_"+area).html("<img src='img/aguarde_ico.gif' alt='processando' align='absmiddle' /> ...Aguarde Processando...");

			new Ajax({

				Url:'functions/carregar_preview.php?ida='+id+'&noa='+area+'&semFecha='+semFecha+'&mesFecha='+mesFecha+'&anoFecha='+anoFecha,

				funcao:function(a){

					var vc =(a.responseText);

					if(vc == 'no'){

						alert('ATENCAO. Ocorreu um problema ao gerar a visualiza��o.\nEntre em contat com o administrador do sistema.');

						$("#preview_"+area).html('');

					}else{

						$("#preview_"+area).html(vc);

					}

				},

				ajaxErro: function(){

					return false;

				}

			});

		}

		

		function itens_builder( campo ) {

			for (i=1;i<=<?=$_SESSION['qtd_pesquisa_relatorio']?>;i++) {

				if (campo.checked) 	{

					$('#pesquisa_'+i).append('<option id="opt_'+i+'_'+campo.id+'" value="'+campo.id+'">'+campo.id+'</option>');

				}else{

					$('#opt_'+i+'_'+campo.id).remove();

				}

			}



		}

	</script>

	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />

	<link rel="shortcut icon" href="img/favicon.ico" type="image/x-icon" />

	<link href="css/estilos.css" rel="stylesheet" type="text/css" />

	<noscript>

		<meta http-equiv="REFRESH" content="0;url=http://www.inscricaofacil.com.br/nojavascript.html" />

	</noscript>

</head>

<body>

	<?php

		echo menu_builder();	

	?>

	<div id='div_conteudo' style=" z-index:1;">

		<?php

		$conteudo="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";

		$conteudo.="\n\t\t\t\t\tRelat&oacute;rios Ger&ecirc;nciais";

		$conteudo.="\n\t\t\t\t</span>";

		$conteudo.="\n\t\t\t\t<hr style='background-color:".$cor_detalhes.";border:none;height:3px;margin-bottom:4px;' /><br />\n";

		?>

		<div id="vtab" class="ui-tabs ui-widget ui-widget-content ui-corner-all" style="z-index:9; padding:10px;">

			<ul>

				<?=$li_fav?>

				<?=$li;?>

				<?=$li_per?>

			</ul>

			<?=$div_fav;?>

			<?=$div;?>

			<?=$div_per;?>			

		</div>

	</div>

</body>

</html>