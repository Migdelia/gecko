<?php
session_start();
include('../conn/conn.php');
include('../functions/lg_validador.php');

$ids = explode('_',($_GET['ida']) );

//Verifica se o relatorio ja esta nos favoritos. Caso esteja, remove senao adiciona
$sql_fav = "
	SELECT 
		vw_favoritos.* 
	FROM 
		vw_favoritos 
	WHERE 
		vw_favoritos.id_relatorio=".$ids[1]."
		AND vw_favoritos.id_login=".$ids[2]."
		AND vw_favoritos.favorito='".$_SESSION['usuario']."'";

$query_fav= @mysql_query($sql_fav);
$qtde_fav = @mysql_num_rows($query_fav);
$resul_fav= @mysql_fetch_assoc($query_fav);

//Verifica se o acesso a ser alterado é o de uma regional.
if ( $qtde_fav>=1 ) {
	
	//Removendo o relatorio dos Favoritos
	$sql_del_fav = "
		DELETE
		FROM
			favoritos
		WHERE
			favoritos.id_relatorio=".$ids[1]."
			AND favoritos.id_login=".$_SESSION['id_login']."
		LIMIT 1
	";

	//Para remover o favorito, basta excluir o registro.
	if ( $query_ace_reg=@mysql_query($sql_del_fav) ) {
		//Verifica se o relatorio é padrao do sistema (tipo<>nome_usuario)
		//Se tipo=nome_usuario é um relatorio personalizado e pode ser excluido também junto com o favorito.
		if ( $resul_fav['favorito']==$_SESSION['usuario']) {
			$sql_del_relat = "UPDATE relatorio SET excluido='S' WHERE relatorio.id_relatorio=".$ids[1]." LIMIT 1";
			@mysql_query($sql_del_relat);
		}
		echo "Excluido:".$ids[1].":".$ids[2];
	}else{
		echo "no";
	}
}else{
	//Caso nao haja o Favorito, ele adiciona
	//Pega o nome do relatorio para exibir nos Favoriots
	$sql_nome = "
		SELECT 
			vw_favoritos.* 
		FROM 
			vw_favoritos 
		WHERE 
			vw_favoritos.id_relatorio=".$ids[1];
	
	$query_nome= @mysql_query($sql_nome);
	$qtde_nome = @mysql_num_rows($query_nome);
	$resul_nome= @mysql_fetch_assoc($query_nome);
	$relatorio = $resul_nome['nome'];
	
	$sql_aterar="INSERT INTO favoritos (id_relatorio,id_login) VALUES (".$ids[1].",".$_SESSION['id_login'].")";	
	if ( @mysql_query($sql_aterar) ) {
		echo "Adiciona:".$ids[1].":".$ids[2].":".$relatorio;
	}else{
		echo "no";
	}
}
?>