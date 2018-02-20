<script type="text/javascript" src="js/ajax.js"></script>

<?php
session_start();
include('../conn/connDongle.php');
include('../functions/functions.php');
//include('../functions/lg_validador.php');

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



//mostra mensagem
echo "<script language='javascript'>
	var goiaba = confirm('Replicar para todas as Dongles Local?');
	alert(goiaba);
</script>";
		
/*

//mosta a sequencia de mensagens responsavel pela troca de plaquinha
echo "<script language='javascript'>var ent_1 = prompt('Informe a ENTRADA da placa SACADA: ". $res_int_atual['numero'] ."', '0');</script>";
echo "<script language='javascript'>var sai_1 = prompt('Informe a SAIDA da placa SACADA: ". $res_int_atual['numero'] ."', '0');</script>";	

echo "<script language='javascript'>var ent_2 = prompt('Informe a ENTRADA da placa INSERIDA: ". $res_inter['numero'] ."', '0');</script>";
echo "<script language='javascript'>var sai_2 = prompt('Informe a SAIDA da placa INSERIDA: ". $res_inter['numero'] ."', '0');</script>";


				
//mostra valores antes para confirmar
echo "<script language='javascript'>alert('Interface Ant: ".$res_int_atual['numero']." E: ' + ent_1 +  ' S: ' + sai_1 + 'Interface Nova: ".$res_inter['numero']." E: ' + ent_2 +  ' S: ' + sai_2);location.reload() </script>";
*/
		


//Gravando os dados
if ($erro=='') {
	$upd_cmd = "UPDATE ".$_POST['table']." SET ".$_POST['id']."='".($_POST['value'])."' WHERE ".$_POST['mkey']."='".$_POST['row_id']."'";
	
	//	$upd_cmd = "UPDATE ".$_POST['table']." SET ".$_POST['id']."='".($_POST['value'])."' WHERE ".$_POST['mkey']."='".$int."'";

		
	if (@mysql_query($upd_cmd) ) {

		//Retirada a mensagem “cadastro alterado com sucesso” para cada alteraçao. 
		echo "<script language='javascript'>alert('Atualizado com sucesso!.');location.reload()</script>";
		
	}else{
		$erro.= "Erro na atualizaçao\\nEntre em contato com o Administrador.";
		echo "<script language='javascript'>alert('".$erro."');</script>";
	}
}else{
	echo "<script language='javascript'>alert('".$erro."');</script>";
}
?>