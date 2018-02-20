<?php
session_start();
include('conn/conn.php');
include('functions/functions.php');
include('functions/validaLogin.php');
$tabela = base64_decode($_POST['param']);
$tabela = @mysql_real_escape_string($tabela);

//Verifica se o usuario tem acesso para proceder as inclusões de nivel/Usuario
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
	//Caso não tenha acesso
	if ( $tabela=='nivel' || $tabela=='usuario' )
	{
		exit(utf8_encode("Usuario restrito para esta operação."));
	}
}

//ate aqui esta OK




//Tratando os dados recebidos por POST
foreach($_POST AS $k=>$v)
{
	//$var[$k] = @mysql_real_escape_string(strip_tags(RetirarAcentos ($v)));
	$var[$k] = @mysql_real_escape_string($v);
}


$semSelecionada = $var['semana'];
if($semSelecionada == "")
{
	$semSelecionada = 0;
}

$dataRef = date("Y-m-d", strtotime($var['dia_fecha']));



//consulta os dados atuais do local, para historico. * id Local= $var['loc'] *alterado 060417
$sql_dados_loc = "SELECT id_login, id_gerente, percentual, id_tp_local, pct_operador, pct_gerente, id_admin FROM `local` WHERE id_local = " . $var['loc'];
$qry_dados_loc=@mysql_query($sql_dados_loc);
$rst_dados_loc=@mysql_fetch_assoc($qry_dados_loc);





//adiciona valores por maquina

//array de ids
$id_maquinas = explode(",", $var['ids']); 

//
$i = 1;
$flag_troca = "true";

while ($i <= $var['qtd']) 
{ 
	//adiciona UM ao valor encontrado (para que seja a proxima)
	//$id_leit_ins = $idLeitura;	
	$id_leit_ins = $var['idLeit'];	
	
	//atibui o id atual de qual maquina esta fazendo o looping	
	$id_atual = $id_maquinas[$i - 1];

	//separa os valores dessa mesma maquina
	$valores = explode("/", $var['vl_maq']);
	$ent_sai = explode(",", $valores[$i - 1]);
	$entrada = $ent_sai[0];
	$saida = $ent_sai[1];
	
	
	//busca valores anteriores de esa leitura
	$sql_leit_ant = "SELECT
						entrada_oficial_atual - valor_entrada AS ent_ant,
						saida_oficial_atual - valor_saida AS sai_ant
					FROM
						leitura_por_maquina
					WHERE
						id_leitura = ".$id_leit_ins."
					AND
						id_maquina = " . $id_atual;

	$qry_leit_ant=@mysql_query($sql_leit_ant);
	$rst_leit_ant=@mysql_fetch_assoc($qry_leit_ant);
	
	
	//
	$ent_ant = $rst_leit_ant['ent_ant'];
	$sai_ant = $rst_leit_ant['sai_ant'];
	
	
	//calcula lectura parcial
	$ent_parc = $entrada - $ent_ant;
	$sai_parc = $saida - $sai_ant;
	
	
	//
	$sql_upd_leit= "UPDATE 
		leitura_por_maquina
	SET 
		valor_entrada = '".$ent_parc."',
		entrada_oficial_atual = '".$entrada."',
		valor_saida = '".$sai_parc."',
		saida_oficial_atual = '".$saida."'
	WHERE
		id_leitura = ".$id_leit_ins."
	AND 
		id_maquina = " . $id_atual;
	
	@mysql_query($sql_upd_leit);
	
	
	//actualiza valores oficiales de la maquina

    $sql_leitura = "SELECT 
     max(id_leitura) as id_leitura
     FROM
	leitura
	where 
	id_local=" . $var['loc'];
	

$query_lec1 = @mysql_query($sql_leitura);
$result_lec1=@mysql_fetch_assoc($query_lec1);

$lectura1 =$result_lec1['id_leitura'];


if ($lectura1 == $id_leit_ins) {
	
	$sql_upd_maquina= "UPDATE 
		maquinas 
	SET 
		entrada_oficial = '".$entrada."',
		saida_oficial = '".$saida."'
	WHERE
		id_maquina = " . $id_atual;
	
		//		
		if(@mysql_query($sql_upd_maquina) )
		{
			//$retorno=1;
		}
		else
		{
			exit(utf8_encode(0));
		}
		
	}

    $i++; 

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
						'".$var['subtotalanterior']."',
						'".$var['subttl']."',
						'Edicion',
						'0',
						".$id_leit_ins."		
						)";

    if(@mysql_query($sql_insert_historico) )
		{
			//$retorno=1;
		}
		else
		{
			exit(utf8_encode(0));
		}

exit(utf8_encode($id_leit_ins));



?>