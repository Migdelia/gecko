<script type="text/javascript" src="js/ajax.js"></script>

<?php
session_start();
include('../conn/conn.php');
include('../functions/functions.php');
include('../functions/lg_validador.php');

//Preparando os campos para a atualizaçao
$erro="";
$all_ok=true;

foreach($_POST as $chave=>$valor) {
	$_POST[$chave] = mysql_real_escape_string(RetirarAcentos($valor));
	if ( ($chave=='')||($valor=='') ) {
		$all_ok = false;
		$erro.= "Erro na atualizaçao\\n";
	}
}


//Validando os campos
if ($all_ok)
{
	if ($_POST['table']=='regiao')
	{
		$_POST['value'] = $_POST['value'];
	}elseif ($_POST['table']=='local')
	{
		switch (strtolower($_POST['id']))
		{
			case "rut":
				if( RUT($_POST['value']) )
				{
					$_POST['value'] = preg_replace('/[^0-9]/i', '', $_POST['value']);
				}else
				{
					$erro.= "RUT invalido\\n";
				}
			break;
		
			case "operador":
				$_POST['id'] = 'id_login';
				$_POST['value'] = preg_replace('/[^0-9]/i', '', $_POST['value']);
			break;
		
		}
	}elseif ($_POST['table']=='maquinas')
	{
		switch (strtolower($_POST['id']))
		{
			case "codigo":
				$_POST['value'] = RetirarAcentos($_POST['value']);
			break;
		
			case "numero":
				$_POST['value'] = preg_replace('/[^0-9]/i', '', $_POST['value']);
			break;
		
			case "nome":
				$_POST['id']='id_local';
				$_POST['value'] = str_replace(' ','',$_POST['value']);
			break;
		}
	}elseif ($_POST['table']=='interface')
	{
		switch (strtolower($_POST['id'])) {
			case "interface":
				$_POST['id'] = 'id_maquina';
				$int = $_POST['value'];				
				$_POST['value']= (int)$_POST['row_id'];
				$_POST['row_id']=$int;
				
				//consulta a interface antesda troca
				$sql_int_atual = "SELECT id_interface, numero FROM ".$_POST['table']." WHERE ".$_POST['id']." = ".$_POST['value']."";
					
				$query_int_atual=@mysql_query($sql_int_atual);
				$res_int_atual=@mysql_fetch_assoc($query_int_atual);
				
				//efetua a troca de plaquinha
				$upd_cmd = "UPDATE ".$_POST['table']." SET ".$_POST['id']."='0' WHERE ".$_POST['id']."='".($_POST['value'])."'";												
				if (!@mysql_query($upd_cmd) ) 
				{
					$erro.= "Erro ao desvincular interface\\nEntre em contato com o Administrador.";
					echo "<script language='javascript'>alert('".$erro."');</script>";
				}
				
				
				
				//Retirada a mensagem “cadastro alterado com sucesso” para cada alteraçao. 
				/*echo "<script language='javascript'>alert('INTERFACE!.');location.reload()</script>";	*/	
				
				//consulta o numero da nova plaquinha
				$sql_inter = "
					SELECT
						interface.numero,
						interface.id_interface
					FROM
						interface
					WHERE
						interface.id_interface=".$_POST['row_id']."
					";
				
				$query_inter=@mysql_query($sql_inter);
				$res_inter=@mysql_fetch_assoc($query_inter);
				
				/*
				
				//mosta a sequencia de mensagens responsavel pela troca de plaquinha
				echo "<script language='javascript'>var ent_1 = prompt('Informe a ENTRADA da placa SACADA: ". $res_int_atual['numero'] ."', '0');</script>";
				echo "<script language='javascript'>var sai_1 = prompt('Informe a SAIDA da placa SACADA: ". $res_int_atual['numero'] ."', '0');</script>";	
	
				echo "<script language='javascript'>var ent_2 = prompt('Informe a ENTRADA da placa INSERIDA: ". $res_inter['numero'] ."', '0');</script>";
				echo "<script language='javascript'>var sai_2 = prompt('Informe a SAIDA da placa INSERIDA: ". $res_inter['numero'] ."', '0');</script>";
				
				
								
				//mostra valores antes para confirmar
				echo "<script language='javascript'>alert('Interface Ant: ".$res_int_atual['numero']." E: ' + ent_1 +  ' S: ' + sai_1 + 'Interface Nova: ".$res_inter['numero']." E: ' + ent_2 +  ' S: ' + sai_2);location.reload() </script>";
				*/
				
				
				//continuar daquii AQUIIII
				//consultar id da ultima leitura da plaquinha que vai ser trocada
				$sql_ult_leit_int = "
					SELECT
						MAX(leitura_por_maquina.id_leitura) AS id_leitura
					FROM
						leitura_por_maquina
					WHERE
						leitura_por_maquina.id_maquina=".$_POST['value']."
					";
				
				$query_ult_leit=@mysql_query($sql_ult_leit_int);
				$res_ult_leit=@mysql_fetch_assoc($query_ult_leit);				
				

				?>
                
                <script>

				alterar_nivel();
			
				
				function alterar_nivel(ant){
				
							var ant = "<?=$res_int_atual['id_interface']?>";
							var nov = "<?=$res_inter['id_interface']?>";
							var id_maq = "<?=$_POST['value']?>";
							var ult_leit = "<?=$res_ult_leit['id_leitura']?>";
							
							
								
							new Ajax({
								Url:"functions/cadastra_hist_interface.php?ent1=0&sai1=0&ent2=0&sai2=0&int_ant="+ant+"&int_nov="+nov+"&idmaq="+id_maq+"&id_leit="+ult_leit,
								funcao:function(a){
									var vc =(a.responseText);
									if(vc == 'no'){
										alert('ATENCAO. Ocorreu um problema ao atualizar o Acesso.');
										//$("#"+v).attr("src",ant);
									}else{
										//$("#"+v).attr("src","img/"+vc);
										//alert("cadastrou OK.")
									}
								},
								ajaxErro: function(){
									return false;
								}
							});
						}
				</script>
                
                <?php 								

				
			break;
		}
	}elseif ($_POST['table']=='logins')
	{
		switch (strtolower($_POST['id'])) {
			case "email":
				$conta = "^[a-zA-Z0-9\._-]+@";
				$domino = "[a-zA-Z0-9\._-]+.";
				$extensao = "([a-zA-Z]{2,4})$";
				$pattern = $conta.$domino.$extensao;
				$mail_valido=false;
				$_POST['value']=strtolower($_POST['value']);
				
				if (!ereg($pattern, $_POST['value'])) {
					$erro.="E-Mail Invalido\\n";
				}
			break;
		
			case "usuario":
				$_POST['value']=str_replace(' ','',$_POST['value']);
			break;
		
			case "nivel":
				$_POST['id']='id_nivel';
				$_POST['value']=str_replace(' ','',$_POST['value']);
			break;
		}
	}elseif ($_POST['table']=='bla')
	{
		switch (strtolower($_POST['id'])) {
			case "email":
				$conta = "^[a-zA-Z0-9\._-]+@";
				$domino = "[a-zA-Z0-9\._-]+.";
				$extensao = "([a-zA-Z]{2,4})$";
				$pattern = $conta.$domino.$extensao;
				$mail_valido=false;
				$_POST['value']=strtolower($_POST['value']);
				
				if (!ereg($pattern, $_POST['value'])) {
					$erro.="E-Mail Invalido\\n";
				}
			break;
		
			case "usuario":
				$_POST['value']=str_replace(' ','',$_POST['value']);
			break;
		
			case "nivel":
				$_POST['id']='id_nivel';
				$_POST['value']=str_replace(' ','',$_POST['value']);
			break;
		
			case "rut":
				if( RUT($_POST['value']) )
				{
					$_POST['value'] = preg_replace('/[^0-9]/i', '', $_POST['value']);
				}else{
					$erro.= "RUT invalido\\n";
				}
			break;
		}
	}
}

//Gravando os dados
if ($erro=='') {
	
	$valorFormat=str_replace("_","",$_POST['value']);
	
	
	$upd_cmd = "UPDATE ".$_POST['table']." SET ".$_POST['id']."='".($valorFormat)."' WHERE ".$_POST['mkey']."='".$_POST['row_id']."'";
	
	//	$upd_cmd = "UPDATE ".$_POST['table']." SET ".$_POST['id']."='".($_POST['value'])."' WHERE ".$_POST['mkey']."='".$int."'";

		
	if (@mysql_query($upd_cmd) ) {

		//Retirada a mensagem “cadastro alterado com sucesso” para cada alteraçao. 
		echo "<script language='javascript'>alert('Atualizado com sucesso!');location.reload()</script>";
		
	}else{
		$erro.= "Erro na atualizaçao\\nEntre em contato com o Administrador.";
		echo "<script language='javascript'>alert('".$erro."');</script>";
	}
}else{
	echo "<script language='javascript'>alert('".$erro."');</script>";
}
?>