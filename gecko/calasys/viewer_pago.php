<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');

$id_fechamento = $_GET['id'];
$id_assoc = 1;

if ($id_assoc == 0) {
	//Caso não tenha acesso carrega guias comuns
	//$acoes = array('Níveis','Usuários','Lotes');
	$acoes = array('Locais');
}else{
	//Se tiver acesso, exibe todas as guias
	$acoes = array('Pago'/*,'Diferenca'*/);
}

//Montando o Nome de Cada Acordion com o Nome do Nivel
$conteudo='';
$conteudo_tab='';
foreach ($acoes as $chave=>$valor) {
	$conteudo_tab.= "\t\t\t\t<li><h5><a href='#tab".$chave."'>".htmlentities($valor)."</a></h5></li>\n";
	
	//Montando o Conteudo de cada Acordion
	switch ($valor) {
	
		case "Pago":
		
		
				$sql_pago = "
					SELECT
						*
					FROM
						pago_fechamento
					WHERE
						id_fechamento = '".$id_fechamento."'
					";
				$query_pago = @mysql_query($sql_pago);
				$dados_pago=@mysql_fetch_assoc($query_pago);
		
				//atribuir cada valor a seu campo ** continuar daqui *Erico
		
		
				$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
				$conteudo.="\n\t\t\t\t<form name='create_pago' id='create_pago' action='add_registro.php' method='POST' target='_blank' enctype='multipart/form-data' onsubmit='return false;'>";
				$conteudo.="\n\t\t\t\t<input label='param_pago' type='hidden' name='param_pago' size='30' id='param_pago' value='".base64_encode('pago')."' />";
				$conteudo.="\n\t\t\t\t<span style='color:#414A4F;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:18px;font-weight:bolder; text-transform:uppercase;'>";
				$conteudo.="\n\t\t\t\t\tPago Fechamento:";
				$conteudo.="\n\t\t\t\t</span>";
				$conteudo.="\n\t\t\t\t<hr style='background-color:#C2006E;border:none;height:3px;margin-bottom:4px;' /><br />";




			
				$conteudo.="\n\t\t\t\t <font style='color:#E17009;font-weight:bolder;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:14px;'>Id Fechamento:</font> <input label=id Fechamento' type='text' name='id_fecha' size='5' id='id_fecha' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:14px;font-weight:bolder;text-align:center;background-color:transparent;border:none;' title='Informe monto' value='".$id_fechamento."' readonly='readonly' >";
				$conteudo.="\n\t\t\t\t <br /><br /> ";
		
						
		
				//Forma de pagamento
				$conteudo.="\n\t\t\t\t<table width='100%' border='1' bordercolor='#000000' align='left' cellpadding='2' cellspacing='3' style=' border-collapse: collapse; font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:10px;padding:10px;'>";
				
				//monta cabecalho da tabela
				$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";		
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center' colspan='6'>";
				$conteudo.="\n\t\t\t\t\t\t\t <font color='#E17009' size='3'>Forma de Pagamento </font>";
				$conteudo.="\n\t\t\t\t\t\t</td>";		
				$conteudo.="\n\t\t\t\t\t</tr>";
				
				//Formas de pagamento
				$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";		
				$conteudo.="\n\t\t\t\t\t\t<td bgcolor='#009933' style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t Dinheiro";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td bgcolor='#008899' style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t Deposito";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td bgcolor='#FF9922' style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t Cheque";
				$conteudo.="\n\t\t\t\t\t\t</td>";						
				$conteudo.="\n\t\t\t\t\t</tr>";		
				
				//dados de forma de pagamentos
				$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";		
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
				$conteudo.="\n\t\t\t\t\t\t\t Obs.";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
				$conteudo.="\n\t\t\t\t\t\t\t Monto";
				$conteudo.="\n\t\t\t\t\t\t</td>";		
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
				$conteudo.="\n\t\t\t\t\t\t\t Num Comp";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
				$conteudo.="\n\t\t\t\t\t\t\t Monto";
				$conteudo.="\n\t\t\t\t\t\t</td>";		
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
				$conteudo.="\n\t\t\t\t\t\t\t Num Cheque";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
				$conteudo.="\n\t\t\t\t\t\t\t Monto";
				$conteudo.="\n\t\t\t\t\t\t</td>";											
				$conteudo.="\n\t\t\t\t\t</tr>";
		
				
				$contador = 6;
				$i = 1;
				
				
				//dados de forma de pagamentos
				$bilhete = 1000; 
				while($contador > $i)
				{
				
					$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";
					$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
					$conteudo.="\n\t\t\t\t\t\t\t <input label=Monto' type='text' name='obs_".$i."' size='20' id='obs_".$i."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;border:none;' title='Informe monto' value='$ ".number_format($bilhete,0,',','.')."' readonly='readonly' >";
					$conteudo.="\n\t\t\t\t\t\t</td>";								
					$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
					$conteudo.="\n\t\t\t\t\t\t\t <input label=Monto' type='text' name='din_".$i."' size='20' id='din_".$i."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;' title='Informe monto' value='".number_format($dados_pago['din_'.$i],0,',','.')."' onBlur='total_dinheiro(this.id,this.value)' readonly='readonly' >";
					$conteudo.="\n\t\t\t\t\t\t</td>";
					$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
					$conteudo.="\n\t\t\t\t\t\t\t <input label=Monto' type='text' name='num_comp_".$i."' size='20' id='num_comp_".$i."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;' title='Informe monto' value='' readonly='readonly' >";
					$conteudo.="\n\t\t\t\t\t\t</td>";
					$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
					$conteudo.="\n\t\t\t\t\t\t\t <input label=Monto' type='text' name='dep_".$i."' size='20' id='dep_".$i."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;' title='Informe monto' value='".$dados_pago['dep_'.$i]."' onBlur='total_deposito(this.id,this.value)' readonly='readonly'>";
					$conteudo.="\n\t\t\t\t\t\t</td>";
					$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
					$conteudo.="\n\t\t\t\t\t\t\t <input label=Monto' type='text' name='num_cheq_".$i."' size='20' id='num_cheq_".$i."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;' title='Informe monto' value='' readonly='readonly'>";
					$conteudo.="\n\t\t\t\t\t\t</td>";
					$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center'>";
					$conteudo.="\n\t\t\t\t\t\t\t <input label=Monto' type='text' name='cheq_".$i."' size='20' id='cheq_".$i."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;' title='Informe monto' value='".number_format($dados_pago['cheq_'.$i],0,',','.')."' onBlur='total_cheque(this.id,this.value)' readonly='readonly'>";
					$conteudo.="\n\t\t\t\t\t\t</td>";												
					$conteudo.="\n\t\t\t\t\t</tr>";
		
					if($bilhete == 1000)
					{
						$bilhete = $bilhete + 1000;
					}
					else if($bilhete == 2000)
					{
						$bilhete = $bilhete + 3000;			
					}
					else if($bilhete == 5000)
					{
						$bilhete = $bilhete + 5000;			
					}			
					else if($bilhete == 10000)
					{
						$bilhete = $bilhete + 10000;			
					}			
		
		
					$i = $i + 1;
				
				}
				
				//dados de forma de pagamentos
				$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";		
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t &nbsp;";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t &nbsp;";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t &nbsp;";
				$conteudo.="\n\t\t\t\t\t\t</td>";									
				$conteudo.="\n\t\t\t\t\t</tr>";
				
				//dados de forma de pagamentos
				$conteudo.="\n\t\t\t\t\t<tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>";		
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t Total $ - <input label=Total Dinheiro' type='text' name='tot_din' size='20' id='tot_din' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;border:none;' title='Informe monto' value='".number_format($dados_pago['valor_din'],0,',','.')."' onBlur='total_dinheiro(this.id,this.value)' readonly='readonly' >";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t Total $ - <input label=Total Deposito' type='text' name='tot_dep' size='20' id='tot_dep' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;border:none;' title='Informe monto' value='".number_format($dados_pago['valor_dep'],0,',','.')."' onBlur='total_dinheiro(this.id,this.value)' readonly='readonly' >";
				$conteudo.="\n\t\t\t\t\t\t</td>";
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center' colspan='2'>";
				$conteudo.="\n\t\t\t\t\t\t\t Total $ - <input label=Total Cheque' type='text' name='tot_cheq' size='20' id='tot_cheq' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent;border:none;' title='Informe monto' value='".number_format($dados_pago['valor_cheq'],0,',','.')."' onBlur='total_dinheiro(this.id,this.value)' readonly='readonly' >";
				$conteudo.="\n\t\t\t\t\t\t</td>";											
				$conteudo.="\n\t\t\t\t\t</tr>";				
				
				//total de pagamento
				//calcula total
				$tot_pago = $dados_pago['valor_din'] + $dados_pago['valor_dep'] + $dados_pago['valor_cheq'];
				
				$conteudo.="\n\t\t\t\t\t\t<td style='padding:5px;".$destaque."' align='center' colspan='6'>";
				$conteudo.="\n\t\t\t\t\t\t\t <font size='3px;'>Total: </font>  <input label=Total Pago' type='text' name='tot_pago' size='20' id='tot_pago' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:14px;font-weight:bolder;text-align:center;background-color:transparent;border:none;' title='Informe monto' value='".number_format($tot_pago,0,',','.')."' readonly='readonly' >";
				$conteudo.="\n\t\t\t\t\t\t</td>";											
				$conteudo.="\n\t\t\t\t\t</tr>";				
						
				
				//fecha tabela de pagamento
				$conteudo.="\n\t\t\t\t</table>";
		
		
						
				
				//Informações do Nível
			
				$conteudo.="\n\t\t\t\t<label class='txt_info' id='info_desc_desconto'>Descricao (livre) do desconto.</label><br>";				
				$conteudo.="\n\t\t\t\t<button id='arq_pago' type='button' class='bt-enviar' style='margin-left:46%; visibility:hidden;'>Enviar</button>";				
				$conteudo.="\n\t\t\t\t</form>";				
				$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";



		break;



		default:
			$conteudo.="\n\t\t\t<div id='tab".$chave."' class='tab_content'>";
			$conteudo.="\n\t\t\t\t<table width='100%' border='0' align='left' cellpadding='2' cellspacing='4'>";
			$conteudo.="\n\t\t\t\t\t<tr bgcolor='#C0C0C0' height='21px;' style='font-weight:bolder' align='center'>";
			$conteudo.="\n\t\t\t\t\t\t<th colspan='2' style='color:#FFFFFF;'>";
			$conteudo.="\n\t\t\t\t\t\t\t".$valor;
			$conteudo.="\n\t\t\t\t\t\t</th>";
			$conteudo.="\n\t\t\t\t\t</tr>";
			$conteudo.="\n\t\t\t\t\t<tr bgcolor='".$cor_linha."' height='21px;'>";
			$conteudo.="\n\t\t\t\t\t\t<td colspan='2' align='center'>";
			$conteudo.="\n\t\t\t\t\t\t\tArea atualmente em Desenvolvimento.<br />Entre em contato com o Administrador do sistema.";
			$conteudo.="\n\t\t\t\t\t\t</td>";
			$conteudo.="\n\t\t\t\t\t</tr>";
			$conteudo.="\n\t\t\t\t</table>";
			$conteudo.="\n\t\t\t\t<br clear='both' />";
			$conteudo.="\n\t\t\t</div>";

		break;

	}
}
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
	<noscript>
		<meta http-equiv="REFRESH" content="0;url=<?php echo $dominio ?>/nojavascript.html" />
	</noscript>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.dimensions.js"></script>
	<script type="text/javascript" src="js/jquery.positionBy.js"></script>
	<script type="text/javascript" src="js/jquery.jdMenu.js"></script>
	<script type="text/javascript" src="js/jquery-ui-1.8.3.js"></script>
	<script type="text/javascript" src="js/functions.js"></script>
	<script type="text/javascript" src="js/jquery.cookie.js"></script>
	<script type="text/javascript" language="javascript" src="js/media/jquery.ui.datepicker-pt-BR.js"></script>
	<script type="text/javascript" src="js/jquery.price_format.1.0.js"></script>
	<script type="text/javascript" language="javascript">
		$(function(){
			// Tabs
			$( "#tabs" ).tabs({
				cookie: {
					// store cookie for a day, without, it would be a session cookie
					expires: 1
				}
			});

			//hover states on the static widgets
			$('#dialog_link, ul#icons li').hover(
				function() { $(this).addClass('ui-state-hover'); }, 
				function() { $(this).removeClass('ui-state-hover'); }

			);
			
			$("#valor_anuidade").priceFormat({
				prefix: '',
				centsSeparator: ',',
				thousandsSeparator: '.'
			});
			$("#valor_desconto").priceFormat({
				prefix: '',
				centsSeparator: ',',
				thousandsSeparator: '.'
			});
			//$.datepicker.setDefaults($.datepicker.local['pt-BR']);
			$( "#data_anuidade" ).datepicker();
			$( "#data_anuidade" ).attr('readonly','readonly');
			$( "#data_vcto" ).datepicker();
			$( "#data_vcto" ).attr('readonly','readonly');
			$( "#data_inicio" ).datepicker();
			$( "#data_inicio" ).attr('readonly','readonly');
			$( "#data_fim" ).datepicker();
			$( "#data_fim" ).attr('readonly','readonly');
		});
		
		
		//calcula total de dinheiro
		function total_dinheiro(id,valor)
		{
			$(document).ready( function() {
				
				valor = eval(valor);
				valor = valor.formatNumber(2,',','.');
				valor = valor.split(",");
				valor = valor[0];				



				$("#"+id).attr("value",valor);
				
				//efetura loop
				soma = 0;
				cont = 6
				i = 1;
				while(cont > i)
				{
					var nome_var = "din_"+i;
					var nome_var = $('#din_'+i).attr("value");
					
					//limpa valores
					nome_var = "'" + nome_var + "'";
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.split(",");
					nome_var = nome_var[0].replace( "'", "");
					nome_var = nome_var.replace( "'", "");					
					//soma novo valor total
					soma = soma + eval(nome_var);

					i=i+1;	
				}
				
				
				soma = soma.formatNumber(2,',','.');
				soma = soma.split(",");
				soma = soma[0];
				//atribui novo valor ao total de dinheiro
				$("#tot_din").attr("value",soma);
			});
			
			//chama verificacao
			verifica_total();			
		};
		
		
		//aplicar pontos para para dep e cheque
		

		//calcula total de dinheiro
		function total_deposito(id,valor)
		{
			$(document).ready( function() {
			
				valor = eval(valor);
				valor = valor.formatNumber(2,',','.');
				valor = valor.split(",");
				valor = valor[0];
				
				$("#"+id).attr("value",valor);		
				
				//efetura loop
				soma = 0;
				cont = 6
				i = 1;
				while(cont > i)
				{
					var nome_var = "dep_"+i;
					var nome_var = $('#dep_'+i).attr("value");
					
					
					//limpa valores
					nome_var = "'" + nome_var + "'";
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.split(",");
					nome_var = nome_var[0].replace( "'", "");
					nome_var = nome_var.replace( "'", "");					
					//soma novo valor total
					soma = soma + eval(nome_var);

					i=i+1;
					
				}
				
				soma = soma.formatNumber(2,',','.');
				soma = soma.split(",");
				soma = soma[0];				
				//atribui novo valor ao total de dinheiro
				$("#tot_dep").attr("value",soma);
			});
			
			//chama verificacao
			verifica_total();			
		};

		//calcula total de dinheiro
		function total_cheque(id,valor)
		{
			$(document).ready( function() {
			
				valor = eval(valor);
				valor = valor.formatNumber(2,',','.');
				valor = valor.split(",");
				valor = valor[0];
				
				$("#"+id).attr("value",valor);				
				
				//efetura loop
				soma = 0;
				cont = 6
				i = 1;
				while(cont > i)
				{
					var nome_var = "cheq_"+i;
					var nome_var = $('#cheq_'+i).attr("value");
					
					//limpa valores
					nome_var = "'" + nome_var + "'";
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.replace( ".", "");
					nome_var = nome_var.split(",");
					nome_var = nome_var[0].replace( "'", "");
					nome_var = nome_var.replace( "'", "");					
					
					//soma novo valor total
					soma = soma + eval(nome_var);

					i=i+1;
					
				}
				
				soma = soma.formatNumber(2,',','.');
				soma = soma.split(",");
				soma = soma[0];				
				//atribui novo valor ao total de dinheiro
				$("#tot_cheq").attr("value",soma);
			
			});
			
			//chama verificacao
			verifica_total();
		};
		

		function verifica_total()
		{
			$(document).ready( function() {
			
				//declara valores
				var tot_sist = $('#total_final').attr("value");
				var tot_dinheiro = $('#tot_din').attr("value");
				var tot_deposito = $('#tot_dep').attr("value");
				var tot_cheque = $('#tot_cheq').attr("value");
				
				//limpa valores
				tot_dinheiro = "'" + tot_dinheiro + "'";
				tot_dinheiro = tot_dinheiro.replace( ".", "");
				tot_dinheiro = tot_dinheiro.replace( ".", "");
				tot_dinheiro = tot_dinheiro.replace( ".", "");
				tot_dinheiro = tot_dinheiro.split(",");
				tot_dinheiro = tot_dinheiro[0].replace( "'", "");
				tot_dinheiro = tot_dinheiro.replace( "'", "");
				//limpa valores
				tot_deposito = "'" + tot_deposito + "'";
				tot_deposito = tot_deposito.replace( ".", "");
				tot_deposito = tot_deposito.replace( ".", "");
				tot_deposito = tot_deposito.replace( ".", "");
				tot_deposito = tot_deposito.split(",");
				tot_deposito = tot_deposito[0].replace( "'", "");
				tot_deposito = tot_deposito.replace( "'", "");
				//limpa valores
				tot_cheque = "'" + tot_cheque + "'";
				tot_cheque = tot_cheque.replace( ".", "");
				tot_cheque = tot_cheque.replace( ".", "");
				tot_cheque = tot_cheque.replace( ".", "");
				tot_cheque = tot_cheque.split(",");
				tot_cheque = tot_cheque[0].replace( "'", "");
				tot_cheque = tot_cheque.replace( "'", "");												
				
				var tot_usuario = eval(tot_dinheiro) + eval(tot_deposito) + eval(tot_cheque);


				//define o total do usuario
				tot_usuario = tot_usuario.formatNumber(2,',','.');
				tot_usuario = tot_usuario.split(",");
				tot_usuario = tot_usuario[0];				
				$("#tot_pago").attr("value",tot_usuario);
				
				
				//remove os pontos
				tot_sist = "'" + tot_sist + "'";
				tot_sist = tot_sist.replace( ".", "");
				tot_sist = tot_sist.replace( ".", "");
				tot_sist = tot_sist.replace( "$", "");
				tot_sist = tot_sist.replace( "-", "");
				tot_sist = tot_sist.split(",");
				tot_sist = tot_sist[0].replace( "'", "");
				tot_sist = tot_sist.replace( "'", "");
				
				//remove os pontos
				tot_usuario = "'" + tot_usuario + "'";
				tot_usuario = tot_usuario.replace( ".", "");
				tot_usuario = tot_usuario.replace( ".", "");
				tot_usuario = tot_usuario.split(",");
				tot_usuario = tot_usuario[0].replace( "'", "");
				tot_usuario = tot_usuario.replace( "'", "");				
				
				tot_sist = eval(tot_sist);
				tot_usuario = eval(tot_usuario);
				
				dif = tot_sist - tot_usuario;
				if(dif == "")
				{
					dif = 0;
				}

				
				if(dif <= 1000 && dif >= -1000)
				{
					if(tot_sist !== "0")
					{
						//alert("igual: mandar Validar fechamento");
						$('#arq_pago').css('visibility','visible');
					}
				}
				else
				{
					//alert("DIFERENTE: NAO validar fechamento");
					$('#arq_pago').css('visibility','hidden');
				}				
			
			});
		}
			

		$(document).ready(function() {


			$("#arq_pago").click(function(event){
				event.preventDefault();
				var vl_par =$("#param_pago").attr("value");
				var id_fecha = <?=$id_fechamento?>;
				var vl_din = $("#tot_din").attr("value");
				var vl_dep = $("#tot_dep").attr("value");
				var vl_cheq = $("#tot_cheq").attr("value");
				
				//detalhe dinheiro
				var um =$("#din_1").attr("value");
				var dois =$("#din_2").attr("value");
				var cinco =$("#din_3").attr("value");
				var dez =$("#din_4").attr("value");
				var vinte =$("#din_5").attr("value");
				
				//limpa valores
				um = "'" + um + "'";
				um = um.replace( ".", "");
				um = um.replace( ".", "");
				um = um.replace( ".", "");
				um = um.split(",");
				um = um[0].replace( "'", "");
				um = um.replace( "'", "");
				
				dois = "'" + dois + "'";
				dois = dois.replace( ".", "");
				dois = dois.replace( ".", "");
				dois = dois.replace( ".", "");
				dois = dois.split(",");
				dois = dois[0].replace( "'", "");
				dois = dois.replace( "'", "");
				
				cinco = "'" + cinco + "'";
				cinco = cinco.replace( ".", "");
				cinco = cinco.replace( ".", "");
				cinco = cinco.replace( ".", "");
				cinco = cinco.split(",");
				cinco = cinco[0].replace( "'", "");
				cinco = cinco.replace( "'", "");
				
				dez = "'" + dez + "'";
				dez = dez.replace( ".", "");
				dez = dez.replace( ".", "");
				dez = dez.replace( ".", "");
				dez = dez.split(",");
				dez = dez[0].replace( "'", "");
				dez = dez.replace( "'", "");
				
				vinte = "'" + vinte + "'";
				vinte = vinte.replace( ".", "");
				vinte = vinte.replace( ".", "");
				vinte = vinte.replace( ".", "");
				vinte = vinte.split(",");
				vinte = vinte[0].replace( "'", "");
				vinte = vinte.replace( "'", "");																			
				
				//detalhe deposito
				var dep_um =$("#dep_1").attr("value");
				var dep_dois =$("#dep_2").attr("value");
				var dep_tres =$("#dep_3").attr("value");
				var dep_quatro =$("#dep_4").attr("value");
				var dep_cinco =$("#dep_5").attr("value");
				
				//limpa valores
				dep_um = "'" + dep_um + "'";
				dep_um = dep_um.replace( ".", "");
				dep_um = dep_um.replace( ".", "");
				dep_um = dep_um.replace( ".", "");
				dep_um = dep_um.split(",");
				dep_um = dep_um[0].replace( "'", "");
				dep_um = dep_um.replace( "'", "");
				
				dep_dois = "'" + dep_dois + "'";
				dep_dois = dep_dois.replace( ".", "");
				dep_dois = dep_dois.replace( ".", "");
				dep_dois = dep_dois.replace( ".", "");
				dep_dois = dep_dois.split(",");
				dep_dois = dep_dois[0].replace( "'", "");
				dep_dois = dep_dois.replace( "'", "");
				
				dep_tres = "'" + dep_tres + "'";
				dep_tres = dep_tres.replace( ".", "");
				dep_tres = dep_tres.replace( ".", "");
				dep_tres = dep_tres.replace( ".", "");
				dep_tres = dep_tres.split(",");
				dep_tres = dep_tres[0].replace( "'", "");
				dep_tres = dep_tres.replace( "'", "");
				
				dep_quatro = "'" + dep_quatro + "'";
				dep_quatro = dep_quatro.replace( ".", "");
				dep_quatro = dep_quatro.replace( ".", "");
				dep_quatro = dep_quatro.replace( ".", "");
				dep_quatro = dep_quatro.split(",");
				dep_quatro = dep_quatro[0].replace( "'", "");
				dep_quatro = dep_quatro.replace( "'", "");
				
				dep_cinco = "'" + dep_cinco + "'";
				dep_cinco = dep_cinco.replace( ".", "");
				dep_cinco = dep_cinco.replace( ".", "");
				dep_cinco = dep_cinco.replace( ".", "");
				dep_cinco = dep_cinco.split(",");
				dep_cinco = dep_cinco[0].replace( "'", "");
				dep_cinco = dep_cinco.replace( "'", "");				
							
				//detalhe cheque
				var cheq_um =$("#cheq_1").attr("value");
				var cheq_dois =$("#cheq_2").attr("value");
				var cheq_tres =$("#cheq_3").attr("value");
				var cheq_quatro =$("#cheq_4").attr("value");
				var cheq_cinco =$("#cheq_5").attr("value");				


				//limpa valores
				cheq_um = "'" + cheq_um + "'";
				cheq_um = cheq_um.replace( ".", "");
				cheq_um = cheq_um.replace( ".", "");
				cheq_um = cheq_um.replace( ".", "");
				cheq_um = cheq_um.split(",");
				cheq_um = cheq_um[0].replace( "'", "");
				cheq_um = cheq_um.replace( "'", "");
				
				cheq_dois = "'" + cheq_dois + "'";
				cheq_dois = cheq_dois.replace( ".", "");
				cheq_dois = cheq_dois.replace( ".", "");
				cheq_dois = cheq_dois.replace( ".", "");
				cheq_dois = cheq_dois.split(",");
				cheq_dois = cheq_dois[0].replace( "'", "");
				cheq_dois = cheq_dois.replace( "'", "");
				
				cheq_tres = "'" + cheq_tres + "'";
				cheq_tres = cheq_tres.replace( ".", "");
				cheq_tres = cheq_tres.replace( ".", "");
				cheq_tres = cheq_tres.replace( ".", "");
				cheq_tres = cheq_tres.split(",");
				cheq_tres = cheq_tres[0].replace( "'", "");
				cheq_tres = cheq_tres.replace( "'", "");
				
				cheq_quatro = "'" + cheq_quatro + "'";
				cheq_quatro = cheq_quatro.replace( ".", "");
				cheq_quatro = cheq_quatro.replace( ".", "");
				cheq_quatro = cheq_quatro.replace( ".", "");
				cheq_quatro = cheq_quatro.split(",");
				cheq_quatro = cheq_quatro[0].replace( "'", "");
				cheq_quatro = cheq_quatro.replace( "'", "");
				
				cheq_cinco = "'" + cheq_cinco + "'";
				cheq_cinco = cheq_cinco.replace( ".", "");
				cheq_cinco = cheq_cinco.replace( ".", "");
				cheq_cinco = cheq_cinco.replace( ".", "");
				cheq_cinco = cheq_cinco.split(",");
				cheq_cinco = cheq_cinco[0].replace( "'", "");
				cheq_cinco = cheq_cinco.replace( "'", "");
				
				
				$('<div id="agd_proc_pago" style="text-decoration:blink;text-align:center; width:520px;">... Processando ...<br /><img src="img/aguarde.gif" align="aguarde" alt="aguarde"></div>').appendTo('#create_pago');
				$("#arq_pago").attr('disabled','disabled');
				$.post('add_forma_pago.php', {param:vl_par,fecha:id_fecha,din:vl_din,dep:vl_dep,cheq:vl_cheq,din_1:um,din_2:dois,din_3:cinco,din_4:dez,din_5:vinte,dep_1:dep_um,dep_2:dep_dois,dep_3:dep_tres,dep_4:dep_quatro,dep_5:dep_cinco,cheq_1:cheq_um,cheq_2:cheq_dois,cheq_3:cheq_tres,cheq_4:cheq_quatro,cheq_5:cheq_cinco},function(json){
					$("#arq_usr").attr('disabled','');
					$("#agd_proc_usr").remove();
					//location.reload();
					alert(json);
					if(json=='Registro incluido com sucesso')
					{
						location="leitura.php";
					}
			 		
				});
			});			
					


		});

	</script>

	<style type="text/css" title="currentStyle">
		@import "css/media/themes/smoothness/<?=$theme?>";
		<!--
		body {font-family:Tahoma, Arial, Helvetica, sans-serif;font-size:11px;}
		td{ padding:2px;}
		td:hover{background-color:#FFD1A4;}
		html {margin: 0;padding: 0;}

		#tabs{ font-size: 12px;margin: 10px;}
		.demoHeaders { margin-top: 2em; }
		#dialog_link {padding: .4em 1em .4em 20px;text-decoration: none;position: relative;}
		#dialog_link span.ui-icon {margin: 0 5px 0 0;position: absolute;left: .2em;top: 50%;margin-top: -8px;}
		ul#icons {margin: 0; padding: 0;}
		ul#icons li {margin: 2px; position: relative; padding: 4px 0; cursor: pointer; float: left;  list-style: none;}
		ul#icons span.ui-icon {float: left; margin: 0 4px;}
		b {color:#FF0000;}
		#ui-datepicker-div {font-size:13px}

		input,select {background-color:#F0F6F9;border:1px solid #A8AFB2; height:20px;margin-bottom:2px;}
		input,select,.lbl,.msg {font-family:Arial, Helvetica, sans-serif;font-size:12px;color:#555C5F;font-weight:bolder;}
		.lbl {height:18px;margin-top:4px;width:120px;float:left;}
		.txt_info {font-family:Arial, Helvetica, sans-serif;font-size:11px;font-weight:bolder;color:#414A4F; margin:3px;visibility:hidden;}
		-->
	</style>
	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>
	<?php
		echo menu_builder();
	?>
	<div id='div_conteudo' style="margin-left:5px;">
		<div id="tabs">
			<ul>
			<?php
				echo "\r".$conteudo_tab."\n";
			?>
			</ul>
			<?php
				echo "\r".$conteudo."\n";
			?>
		</div>
	</div>

</body>
</html>