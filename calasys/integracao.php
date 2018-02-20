<?php
//Fechamento de sessao ao fechar o navegador
session_start();

include('conn/conn.php');
include('functions/functions.php');
include('functions/lg_validador.php');
unset($_SESSION['campos']);


$sql_placas = "
	SELECT
		id_integracao				
	FROM
		integracao
	";
	
	
$query_placas=@mysql_query($sql_placas);
$lista_placas = "";
$cont_plaq = 0;
while($dados_placas=@mysql_fetch_assoc($query_placas) ) 
{
	$lista_placas .= $dados_placas['id'] . "/";
	$cont_plaq ++;
}

$size = strlen($lista_placas);
$lista_placas = substr($lista_placas,0, $size-1);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta name="url" content="<?php echo $dominio ?>">
	<meta http-equiv="refresh" content="20" >
	<meta name="description" content="<?php echo $description?>" />
	<meta name="robots" content="noindex,nofollow">
	<title>..::Administrativo - <?php echo $description?> ::..</title>
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.dimensions.js"></script>
	<script type="text/javascript" src="js/jquery.positionBy.js"></script>
	<script type="text/javascript" src="js/jquery.jdMenu.js"></script>
    <script type="text/javascript" src="js/jquery.min.js"></script> 
	<script src="js/jquery.js" type="text/javascript"></script>
    <script src="js/jquery.printElement.js" type="text/javascript"></script>      
	<script type="text/javascript" src="script.js"></script>    
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


		function concecta_local(obj)
		{
			document.forms["valida_user"].submit();
		}

		function printPago(obj)
		{
			arrayImp = obj.title.split("|");
			descr = arrayImp[0];
			data = arrayImp[1];
			
			descr = descr * 10;
			
			window.open("imprimir.php?id="+obj.name+"&descr="+descr+"&dt="+data,'','height=150, width=750, top=200, left=200');
		}
		
		function upPos(obj)
		{
			var id = obj.name;
			var id = id.split("_");
			var id = id[1];
			jQuery.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'changePos.php', // Informo a URL que será pesquisada.
				data: 'id='+id+'&flag=1&pos='+obj.title,
				success: function(html)
				{
					var html = eval(html);
					if(html == true)
					{
						//pega posicao atual do objeto
						var titAtu =$('#maisPos_'+id).attr("title");
						//atribui um a mais
						var newVal = eval(obj.title) + 1;
						//busca o botao campo text e soma mais um
						$("#"+id+"_"+titAtu).attr("value", newVal);
						$("#"+id+"_"+titAtu).attr("id", id+"_"+newVal);
						$("#maisPos_"+id).attr("title", newVal);
						$("#menosPos_"+id).attr("title", newVal);								
					}
					else
					{
						alert("Erro!");
					}
				}
			});	
		}

		function downPos(obj)
		{
			var id = obj.name;
			var id = id.split("_");
			var id = id[1];
			jQuery.ajax(
			{								
				type: "POST", // Defino o método de envio POST / GET
				url: 'changePos.php', // Informo a URL que será pesquisada.
				data: 'id='+id+'&flag=0&pos='+obj.title,
				success: function(html)
				{
					var html = eval(html);
					if(html == true)
					{
						//pega posicao atual do objeto
						var titAtu =$('#menosPos_'+id).attr("title");
						//atribui um a mais
						var newVal = eval(obj.title) - 1;
						//busca o botao campo text e soma mais um
						$("#"+id+"_"+titAtu).attr("value", newVal);
						$("#"+id+"_"+titAtu).attr("id", id+"_"+newVal);
						$("#menosPos_"+id).attr("title", newVal);
						$("#maisPos_"+id).attr("title", newVal);										
					}
					else
					{
						alert("Erro!");
					}
				}
			});	
		}


		$(document).ready( function() {
			total=0;
			$('#select_all').click( function() {
				if (this.checked) {
					$('#selecionar').html('Desmaracar Todos');
					$('input:checkbox').each( function() {
						this.checked=true;
					});
				}else{
					$('#selecionar').html('Selecionar Todos');
					$('input:checkbox').each( function() {
						this.checked=false;
					});
				}
			});

			$('#historico').click( function() {
				$('#boxes').fadeIn("slow");
				$('#dialog_historico').fadeIn("slow");
			});
			
			$('#ordem').click( function() {
				$('#boxes').fadeIn("slow");
				$('#dialog_ordem').fadeIn("slow");
			});
			
			$('#reordenar').click( function() {
				location = "caixa.php";
			});			
			
			
			
			$('#atu_dados_pag').click( function() {
				if(confirm("Estas seguro que quiere atualizar Maquinas?"))
				{
					jQuery.ajax(
					{								
						type: "POST", // Defino o método de envio POST / GET
						url: 'deleteReading.php', // Informo a URL que será pesquisada.
						data: '',
						success: function(html)
						{
							
							var html = eval(html);
							if(html == true)
							{
								setInterval(function(){alert("Dados Atualizados con exito!");location = "caixa.php";},2000);														
							}
							else
							{
								alert("Erro!No es posible atualizar dados de la pagina!");
							}
						}
					});							
				}
				else
				{
					return false;			
				}				
			});
			
			$('#fecha_hist').click( function() {
				$('#boxes').fadeOut("slow");
				$('#dialog_historico').fadeOut("slow");
			});
			
			$('#imprimir_all_hist').click( function() {
				$('#dialog_historico').printElement();
			});
			
					
			
			$('#rend_parc').click( function() {
				window.open('rendicao.php', '_blank');
			});
											
			
			$('#operador').change( function() {
				var id_ope =$('#operador').attr("value");
				location = "fechamento.php?ope="+id_ope;
			});
			
			$('#confirmar_lancamentos').click( function() {
				document.forms["confirma_fechamento"].submit();
			});
			
			$('#cobrar').click( function() {
				var id_maq_cobrar= $('#cred_maq').attr("value");
				$('#boxes').fadeOut("slow");
				if(confirm("Estas seguro que quiere cobrar esta maquina?"))
				{
					jQuery.ajax(
					{
						type: "POST", // Defino o método de envio POST / GET
						url: 'payout.php', // Informo a URL que será pesquisada.
						data: 'id='+id_maq_cobrar,
						success: function(html)
						{
							var html = eval(html);
							if(html == true)
							{
								$('#boxes').fadeOut("slow");
								$('#dialog').fadeOut("slow");
								$('#dialog_cobrar').fadeOut("slow");								
							}
							else
							{
								alert("Erro! Nao é possivel Cobrar essa maquina!");
							}
						}
					});	
				}
				else
				{
					$('#boxes').fadeOut("slow");
					$('#dialog').fadeOut("slow");
					$('#dialog_cobrar').fadeOut("slow");
					return false;			
				}
				
			});
			
		
				
			
			function limpa_val()
			{
				$("#centro_cust").attr("value", "1");
				$('#valor_dec').attr("value", "");
				$('#desc_desc').attr("value", "");
				$('#tp_documento').attr("value", "1");
				$('#num_doc').attr("value", "");
			}
		
					
			
			$('#ins_desp').click( function() {
			
				alert("modulo deshabilitado!");
				/* DESABILITADO PARA MODO NORMAL * HABILITAR CASO SEJA MODO LAN HOUSE
				var idinter =$('#ult_id').attr("value");
				var cr = $('#vl_credito').attr("value");

				if(cr == 1)
				{
					vl_cr = 100;
				}
				else if(cr == 2)
				{
					vl_cr = 200;
				}
				else if(cr == 3)
				{
					vl_cr = 500;
				}
				else if(cr == 4)
				{
					vl_cr = 1000;
				}
				else if(cr == 5)
				{
					vl_cr = 2000;
				}												
				
				jQuery.ajax(
				{
					type: "POST", // Defino o método de envio POST / GET
					url: 'insert.php', // Informo a URL que será pesquisada.
					data: 'credit='+idinter+'-'+vl_cr,
					success: function(html)
					{
						var html = eval(html);
						if(html == true)
						{
							//alert(vl_cr*10 + " Inserido!OK");
							$('#boxes').fadeOut("slow");
							$('#dialog_cobrar').fadeOut("slow");
							limpa_val();
						}
						else
						{
							alert("Erro! Problema ao inserir Credito!");
						}
					}
				});
				*/			
			});
			
		});

		function chama_insert(obj)
		{
			
			//verifica se a maquina clicada esta online
			//$("#status_4641").attr("src", "images/online.png");
			//var maq_status =$('#status_4641').attr("src");
			var maq_status =$('#div_button_'+obj.title).css("background-image");
			
			maq_status = maq_status.split("painel_btn_");
			maq_status = maq_status[1];
			maq_status = maq_status.split(".");
			maq_status = maq_status[0];
			
			
			id_inter = obj.id;
			id_inter = id_inter.split("_");
			id_inter = id_inter[2];						
			$("#ult_id").attr("value", id_inter);
			$("#cred_maq").attr("value", id_inter);	
			var credMostrar = $('#online_'+id_inter).attr("title");
			$("#cred_atual").attr("value", credMostrar);			
			
			
			if(maq_status == "c")
			{
				alert("Erro! Maquina Off!");
				$('#boxes').fadeOut("slow");
				$('#dialog').fadeOut("slow");
				$('#dialog_cobrar').fadeOut("slow");				
			}
			else if(maq_status == "b")
			{ 
				$('#boxes').fadeIn("slow");
				$('#dialog_cobrar').fadeIn("slow");
				$('#dialog').fadeOut("slow");
				
				jQuery.ajax(
				{
					type: "POST", // Defino o método de envio POST / GET
					url: 'atuPayout.php', // Informo a URL que será pesquisada.
					data: 'id='+id_inter,
					success: function(html)
					{
						var html = eval(html);
						if(html == false)
						{
							alert("Erro! Nao é possivel Cobrar essa maquina!");							
						}
						else
						{
							var credCrobrar = eval(html);
							$("#maq_credito").attr("value", credCrobrar);
							$("#maq_valor").attr("value", credCrobrar * 10);
						}
					}
				});				
				
				
				//aqui atribuir o dados da maquina clicada nos campos devido.
				$("#maq_credito").attr("value", credMostrar / 10);
				
				//formatar numero para mostrar. /credMostrar
				$("#maq_valor").attr("value", credMostrar);
				$("#maq_num_pag").attr("value", id_inter);
			}
			else
			{
				$('#boxes').fadeIn("slow");
				$('#dialog').fadeIn("slow");			
			}

		}		




		function enable_obj(obj)
		{
			
			if(obj.id == "chk_outro_monto")
			{
				if (obj.checked == true)
				{
					document.add_credito.monto_dif.disabled = false;
				}
				else
				{
					document.add_credito.monto_dif.disabled = true;
				}
			}
		}
		
		
		setInterval(function() 
		{
			jQuery.ajax(
			{
				type: "POST", // Defino o método de envio POST / GET
				url: 'atualiza.php', // Informo a URL que será pesquisada.
				data: 'id=<?php echo $lista_placas ?>', //mandar todos os ids para consultar
				success: function(html)
				{
					//alert(html);
					var loopMaq = html.split("|");
					//alert(loopMaq[1]);
					
					var cont = 0;
					while(cont < <?php echo $cont_plaq?>)
					{

						var result=loopMaq[cont].split("/");
						
						//alert(result[0]);
									
						var flag_func = eval(result[1]);
						if(flag_func == false)
						{
							alert("Erro!");
						}
						else
						{
							//alert(result[0]);
							var tmp_atu = $('#online_'+result[0]).attr("value");
							var tmp_nv = result[1];
							
							//OFFLINE						
							if(tmp_atu == tmp_nv)
							{
								//$("#status_4641").attr("src", "images/offline.png");
								$('#div_button_'+result[0]).css("background-image", "url(img/painel_btn_c.png)");
								var statu_atu = "c";
							}
							//ONLINE
							else
							{
								//PAGAR
								if(result[3] > 0)
								{
									//$("#status_4641").attr("src", "images/pagar.png");
									$('#div_button_'+result[0]).css("background-image", "url(img/painel_btn_b.png)");
									var statu_atu = "b"
								}
								//OCUPADO
								else if(result[2] > 0)
								{
									//$("#status_4641").attr("src", "images/ocupada.png");
									$('#div_button_'+result[0]).css("background-image", "url(img/painel_btn_d.png)");
									var statu_atu = "d"
								}
								//SO ONLINE
								else
								{
									$('#div_button_'+result[0]).css("background-image", "url(img/painel_btn_n.png)");
									//$("#status_4641").attr("src", "images/online.png");
									var statu_atu = "n";							
								}					
							}
							
							var get_cred = result[2]*10;
							$('#online_'+result[0]).attr("value", tmp_nv);
							$('#online_'+result[0]).attr("title", get_cred);
							
							
							//$('#cred_atual').attr("value", get_cred);
						}


						cont = cont + 1;
					}
					
				}
			});	
		},3000);
		
		
		function cancel_pago()
		{
			$('#dialog').fadeOut("slow");
			$('#dialog_cobrar').fadeOut("slow");
			$('#boxes').fadeOut("slow");			
		}
		
		function pagaMaq()
		{
			$(document).ready( function() {	
		
			//alert("Maquina descreditada com sucesso!");
			$('#boxes').fadeOut("slow");
			$('#dialog').fadeOut("slow");
			$('#dialog_cobrar').fadeOut("slow");
			
			var inter = document.getElementById("ult_id").value;
			var descr_atual = document.getElementById("online_"+inter).title;
				
				jQuery.ajax(
				{
					type: "POST", // Defino o método de envio POST / GET
					url: 'uncredit.php', // Informo a URL que será pesquisada.
					data: 'id='+inter,
					//data: 'id='+obj.title,
					success: function(html)
					{
						var html = eval(html);
						if(html == true)
						{
							//abre a nova janela, já com a sua devida posição
							//window.open("imprimir.php?id="+inter+"&descr="+descr_atual,'','height=150, width=320, top=200, left=200');
							
							setTimeout(function(){window.open("imprimir.php?id="+inter+"&descr="+descr_atual,'','height=150, width=750, top=50, left=20');},2000);													 							
				
							jQuery.ajax(
							{
								type: "POST", // Defino o método de envio POST / GET
								url: 'atualiza_hist_pago.php', // Informo a URL que será pesquisada.
								data: 'id='+inter, //mandar todos os ids para consultar
								success: function(html)
								{
									var resposta = html.split("|");
									
									
									var flagAtu = resposta[0];
									var id = resposta[1];
									var vlCredito = resposta[2];
									var vlCredito = vlCredito * 10;
									var dateServer = resposta[4];
									var horaServer = resposta[3];
									var emCreditos = vlCredito / 10;
							
				
									$("#tb_list_desp tbody").prepend("<tr bgcolor='#F5F8F9' height='21px;'style='font-weight:bolder' align='center'><td style='padding:5px;' align='center' width='28%'>"+horaServer+"</td><td style='padding:5px;' align='center' width='28%'>"+id+"</td><td style='padding:5px;' align='center' width='28%'>$ "+vlCredito+"</td><td style='padding:5px;' align='center' width='16%'><a id='"+id+"' name='"+id+"' title='"+emCreditos+"|"+dateServer+"' style='cursor:pointer;' onclick='printPago(this);'>Imprimir</a></td></tr>");
									
						
								}
							});	


						
							
						}
						else
						{
							alert("Erro! No se puede descreditar esa maquina!");
						}
					}
				});						
				
			});
		}		
		
				
	</script>
	<link rel="icon" href="img/favicon.gif" type="image/gif" />
	<noscript>
		<meta http-equiv="refresh" content="5" >
	</noscript>
	<link rel="stylesheet" href="css/jquery.jdMenu.css" type="text/css" />
	<link href="css/estilos.css" rel="stylesheet" type="text/css" />
</head>
<body>

<form id="valida_user" name="valida_user" method="post" action="http://sanbernardo.dyndns.org/verifica.php">
	<input type="hidden" id="login" name="login" value="<?php echo $_SESSION['usuario'] ?>" />
    <input type="hidden" id="senha" name="senha" value="<?php echo $_SESSION['passw'] ?>" /> 
</form>



	<?php
		echo menu_builder();	
	?>
	<br clear="all" />
	<div id='caixa'>
		<div id='iconesCaixa'>
			<?php
				echo caixa_builder();
			?>
		</div>
	</div> 
    <div id="boxes"> 
        <div id="dialog" class="window" style="width:30%;height:48%;background-color:#eeeeee;margin-left:40%; margin-top:15%;">
        	<div style="height:16%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative">
				<div style="position:absolute; margin-left:5%; margin-top:2%;">
                	Creditar maquina &nbsp;&nbsp;
                    <input type="text" name="cred_maq" id="cred_maq" value="" size="3" style="background: transparent; border: none;" readonly="readonly" />
                </div>
            </div>
            <div style="width:40%;position:absolute; margin-top:5%;" align="right">
            <form id="add_credito" name="add_credito">
            	<table>
                	<tr height="30px;">
                    	<td align="right"><strong>Credito Atual:</strong></td>
                    </tr>                 
                	<tr height="30px;">
                    	<td align="right"><strong><br />Valor:</strong></td>
                    </tr> 
                                                                                                  
                </table>
            </div>
            <div style="width:60%;position:absolute;left:40%;margin-left:10px;margin-top:5%;" align="left">
            	<table>
                    <tr height="30px;">
                        <td>
                           <input type="text" id="cred_atual" name="cred_atual" size="5" value="" style="border:0px;" disabled="disabled"  />                     
                        </td>
                    </tr>                 
                	<tr height="30px;">
                    	<td>
                        	<br />
                            <select id="vl_credito" name="vl_credito" disabled="disabled">
                            	<option value="0">Elegir</option>
                                <option value="1">$ 1.000</option>
                                <option value="2">$ 2.000</option>
                                <option value="3">$ 5.000</option>
                                <option value="4">$ 10.000</option>
                                <option value="5">$ 20.000</option>
                            </select>                        
                        </td>
                    </tr>
                                      
                </table>
            </div>
            <div style=" width:100%;height:20%;position:absolute;bottom:0px;">
            <hr /><br />
            <a name='modal' id='cobrar' name='cobrar' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:10%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
                &nbsp;&nbsp;
                <img src='img/inativo.png' width='10' border='0' />
                <strong> Cobrar </strong>
            </a>
       
            <a name='modal' id="ins_desp" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:15%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
                &nbsp;&nbsp;
                <img src='img/ativo.png' width='10' border='0' />
                <strong> Inserir </strong>
	        </a>           
            </div>
            <input type="hidden" name="ult_id" id="ult_id" value=""  />
            
            <!--- GERAR CAMPOS DE ONLINE DINAMICAMENTE --->
            <?php
				$sql_interfaces = "
					SELECT
						id					
					FROM
						Reading
					";	
					
				$query_interfaces=@mysql_query($sql_interfaces);
				$lst_plac = "";
				while($dados_interfaces=@mysql_fetch_assoc($query_interfaces) ) 
				{
					$lst_plac .= $dados_interfaces['id'] . "/";
					echo "<input type='hidden' name='online_".$dados_interfaces['id']."' id='online_".$dados_interfaces['id']."' value='' title='' />";
				}				
			?> 

        </div>


		<!-- teste -->

        <div id="dialog_cobrar" class="window" style="width:20%;height:28%;background-color:#FF9966;margin-left:40%; margin-top:15%;" align="center">
            <table>
            	<tr>
                	<td colspan="3" style="font-size:16px;">&nbsp;
						
					</td>
                </tr>
            	<tr style="font-size:18px;">
                	<td colspan="3">
                    	<strong>
                        	Maquina:  
                            <input type="text" id="maq_num_pag" name="maq_num_pag" value="" size="3" style="background: transparent; border: none;" readonly="readonly" />  
                        </strong>
					</td>
                </tr>
            	<tr style="font-size:18px;">
                	<td colspan="3">&nbsp;
						
					</td>
                </tr>                
            	<tr style="font-size:16px;">
                	<td>CREDITOS:</td>
                    <td>&nbsp;</td>
                    <td> 
                    	<input type="text" id="maq_credito" name="maq_credito" value="" title="Credito de la maquina" size="8" style="background: transparent; border: none;" readonly="readonly" /> 
                    </td>
                </tr> 
            	<tr style="font-size:16px;">
                    <td colspan="3">&nbsp;</td>
                </tr>                 
            	<tr style="font-size:16px;">
                	<td>VALOR $:</td>
                	<td>&nbsp;</td>
                    <td> 
                    	<input type="text" id="maq_valor" name="maq_valor" value="" title="$ de la maquina" size="8" style="background: transparent; border: none;" readonly="readonly" /> 
                    </td>
                </tr>
			</table>
            <div style=" width:100%;height:20%;position:absolute;bottom:0px;">           
                <table>
                    <tr>
                        <td>
                            <input type="button" id="canc_pag" name="canc_pag" value="&nbsp; Cancelar &nbsp;" title="cancelar" onclick="cancel_pago();" style='margin:5px; margin-left:0px; width:75px; cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;' />
                        </td>
                        <td width="20px;">&nbsp;
                            
                        </td>                        
                        <td>
                        	<!--
                            <input type="button" id="pag_maq" name="pag_maq" value="&nbsp; Pagar &nbsp;" title="Pagar" onclick="pagaMaq();"  style='margin:5px; margin-left:0px; width:75px; cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;'/>-->
                            &nbsp;
                        </td>
                        <td width="20px;">&nbsp;
                            
                        </td>                        
                        <td>
                            <input type="button" id="pag_impr" name="pag_impr" value="&nbsp; Pagar / Imprimir &nbsp;" title=" Pagar e Imprimir " onclick="pagaMaq();" style='margin:5px; margin-left:0px; width:120px; cursor:pointer;font-size:11px;height:24px;background-color:#485F65;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;' />
                        </td>				
                    </tr>                                                
                </table>
		        </form>                
            </div>
        </div>
        
        
        <div id="dialog_historico" class="window" style="width:40%;height:65%;background-color:#eeeeee;margin-left:30%; margin-top:10%;">



        	<div style="height:12%;background-color:#f7b64b;color:#FFFFFF;font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:18px;font-weight:bolder; position:relative">
				<div style="position:absolute; margin-left:5%; margin-top:2%; width:85%;">
					<table width="100%">
                    	<tr><td>&nbsp;</td></tr>
                    	<tr>
                        	<td align="left">
                                Historico de Pagos
                            </td>
                        	<td align="right">
                                Date: <?php echo date("d/m/Y"); ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>            
            <div style="overflow:auto;width:95%;height:60%;position:absolute; margin-top:5%;" align="center" style="margin-left:5%;">

                <table width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:10px;'>
                    <tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>
                        <th style='color:#E17009;' width="28%">Hora</th>
                        <th style='color:#E17009;' width="28%">Maquina</th>
                        <th style='color:#E17009;' width="28%">Valor </th>
                        <th style='color:#E17009;' width="16%"><img src="img/imprimir.jpg" /></th>
                    </tr>
                </table>            
            	<br />
            
                <table  id='tb_list_desp' width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:10px;'>

                    <?php
                        //aqui consultar despesas de leitura desse usuario que nao tenham id de leitura
                        $sql_hist_pago = "
                            SELECT
                                lastPayouts.*,
								vw_maquinas.maq
                            FROM
                                `lastPayouts`
							INNER JOIN
								vw_maquinas
							ON
								lastPayouts.id = vw_maquinas.id
							WHERE
								(dateServer >= DATE_FORMAT(NOW(), '%Y-%m-%d')) 
							ORDER BY
								dateServer DESC
                            ";
                            
                        $query_hist_pago=@mysql_query($sql_hist_pago);
                        //$result_desp_leit=@mysql_fetch_assoc($query_desp_leit);				
                    
                        while($result_hist_pago=@mysql_fetch_assoc($query_hist_pago)) 
                        {
                            echo "<tr id='".$result_hist_pago['id_desconto']."' bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>         
                                    <td style='padding:5px;' align='center' width='28%'>
                                        ".date("H:i:s", strtotime($result_hist_pago['dateServer']))."
                                    </td>
                                    <td style='padding:5px;' align='center' width='28%'>
                                        ".$result_hist_pago['maq']."
                                    </td>
                                    <td style='padding:5px;' align='center' width='28%'>
                                        $ ".number_format($result_hist_pago['value']*10,0,"",".")."
                                    </td>
                                    <td style='padding:5px;' align='center' width='28%'>
                                        <a id='".$result_hist_pago['index']."' name='".$result_hist_pago['id']."' title='".$result_hist_pago['value']."|".$result_hist_pago['dateServer']."' style='cursor:pointer;' onclick='printPago(this);'>
											Imprimir
										</a>
                                    </td>							                                
                                </tr>"; 
                        }			
          
                    ?>                    
                </table>        
            </div>
            <div  style=" width:100%;height:10%;position:absolute;bottom:0px;">
                <hr width="95%" />
                <br />
                <a name='modal' id='fecha_hist' name='cancelar' style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:12%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
                    &nbsp;&nbsp;
                    <img src='img/inativo.png' width='10' border='0' />
                    <strong> Fechar </strong>
                </a>        
                <a name='modal' id="imprimir_all_hist" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:40%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
                    &nbsp;&nbsp;&nbsp;&nbsp;
                    <strong> Imprimir </strong>
                </a>            
            </div>



        </div>
        <div id="dialog_ordem" class="window" style="width:35%;height:65%;background-color:#eeeeee;margin-left:30%; margin-top:10%;">
        
            <div style="overflow:auto;width:95%;height:60%;position:absolute; margin-top:5%;" align="center" style="margin-left:5%;">         
        
            <table width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:10px;'>
                <tr bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>
                    <th style='color:#E17009;' width="33%">Maquina</th>
                    <th style='color:#E17009;' width="33%">Ordem</th>
                    <th style='color:#E17009;' width="33%">Editar</th>
                </tr>
            </table>              

        
		    <br />

        
            <table  id='tb_list_ordem' width='100%' border='1' bordercolor='#000000' style='border-collapse: collapse' align='center' cellpadding='2' cellspacing='3' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;margin-top:0px;padding:10px;'>

                <?php
                    //aqui consultar despesas de leitura desse usuario que nao tenham id de leitura
                    $sql_ordem_maq = "
                        SELECT
							id,
                            ordem_leitura,
							maq
                        FROM
                            `vw_maquinas`
                        ORDER BY
                            ordem_leitura
                        ";						
						
                    $query_ordem_maq=@mysql_query($sql_ordem_maq);
                    //$result_desp_leit=@mysql_fetch_assoc($query_desp_leit);				
                
                    while($result_ordem_maq=@mysql_fetch_assoc($query_ordem_maq)) 
                    {
                        echo "<tr id='".$result_ordem_maq['id']."_ordem' bgcolor='#F5F8F9' height='21px;' style='font-weight:bolder' align='center'>         
                                <td style='padding:5px;' align='center' width='33%'>
                                    ".$result_ordem_maq['maq']."
                                </td>
                                <td style='padding:5px;' align='center' width='33%'>
									<input id='".$result_ordem_maq['id']."_".$result_ordem_maq['ordem_leitura']."' value='".$result_ordem_maq['ordem_leitura']."' style='font-family:Tahoma, Verdana, Arial, Helvetica, sans-serif;font-size:10px;font-weight:bolder;text-align:center;background-color:transparent; border:none;' readonly='readonly' >
                                </td>
                                <td style='padding:5px;' align='center' width='33%'>
									<button id='menosPos_".$result_ordem_maq['id']."' name='down_".$result_ordem_maq['id']."' type='button' class='bt-enviar' style='margin-left:20px;margin-top:0px;width:25px;' title='".$result_ordem_maq['ordem_leitura']."' onclick='downPos(this);'> - </button>													
									<button id='maisPos_".$result_ordem_maq['id']."' name='up_".$result_ordem_maq['id']."' type='button' class='bt-enviar' style='margin-left:20px;margin-top:0px;width:25px;' title='".$result_ordem_maq['ordem_leitura']."' onclick='upPos(this);'> + </button>
                                </td>																						                            </tr>"; 
                    }			
      
                ?>                    
            </table> 
            </div>
            
            <div  style=" width:100%;height:10%;position:absolute;bottom:0px;">
                <hr width="70%" />      
                <a name='modal' id="reordenar" style='color:#FFFFFF;text-decoration:none;margin:0px;margin-left:40%;cursor:pointer;font-size:12px;background-color:#485F65;width:85px;height:16px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
                    &nbsp;&nbsp;
                    <strong> Reordenar </strong>
                    &nbsp;&nbsp;
                </a>            
            </div>                 

        </div>                
        
        
        <div id="mask">
        </div> 
    </div>
    <!---
    <div style='position:fixed;bottom:0;background-color:#B2C7CE;width:100%;'>
        <a id='historico' name='modal' type='button' class='bt-enviar' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:4%; margin-top:0px; top:0px;cursor:pointer;font-size:11px;background-color:#485F65;width:auto;height:35px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
            <br />&nbsp; Historico de Pagos &nbsp;
        </a>
        <a id='ordem' name='modal' type='button' class='bt-enviar' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:4%; margin-top:0px; top:0px;cursor:pointer;font-size:11px;background-color:#485F65;width:auto;height:35px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
            <br />&nbsp; Ordem Maquinas &nbsp;
        </a>  
        <a id='atu_dados_pag' type='button' class='bt-enviar' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:4%; margin-top:0px; top:0px;cursor:pointer;font-size:11px;background-color:#485F65;width:auto;height:35px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
            <br />&nbsp; Atualizar &nbsp;
        </a>
        
        <a id='aviso' class='bt-enviar' style='color:#FFFFFF;text-decoration:none;margin:0px; margin-left:15%; margin-top:0px; top:0px;cursor:pointer;font-size:11px;background-color:#485F65;width:auto;height:35px;color:#FFFFFF;border:1px solid #FFFFFF;font-weight:bolder;display:inline-block;'>
            <br />&nbsp; Aviso &nbsp;
        </a>
                                                       
    </div> 
    --->    
</body>
</html>