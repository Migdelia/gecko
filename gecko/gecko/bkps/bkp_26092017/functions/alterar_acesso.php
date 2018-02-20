<?php
session_start();
include('../conn/conn.php');
include('../functions/lg_validador.php');

$ids = explode('_',($_GET['ida']) );
//Verifica se o acesso a ser alterado é o de uma regional.
if ($ids[0]=='reg') {
	//Selecionando o Acesso da Regional Fornecido
	$sql_ace_reg = "
		SELECT
			acesso_local.id_acesso_local,
			acesso_local.acesso
		FROM
			acesso_local
		WHERE
			acesso_local.id_nivel=".$ids[1]."
			AND acesso_local.id_local=".$ids[2];
	
	//Verificando se existe o Acesso.
	//A Tabela de acesso_regional deve conter Apenas acesso='S'.
	//Para negar o acesso, basta excluir o registro.
	if ( $query_ace_reg=@mysql_query($sql_ace_reg) ) {
		//Caso haja o acesso=S, ele deve remover o acesso.
		if (@mysql_num_rows($query_ace_reg)>=1 ) {
			while ($acesso_reg = @mysql_fetch_assoc($query_ace_reg) ) {	
				if (strtoupper($acesso_reg['acesso'])=='S') {
					$sql_aterar_reg="DELETE FROM acesso_local WHERE acesso_local.id_nivel=".$ids[1]." AND acesso_local.id_local=".$ids[2];
					if ( @mysql_query($sql_aterar_reg) ) {
						echo "inativo.png";
					}else{
						echo "no";
					}
				}else{
					echo "no";
				}
			}
		}else{
			//Caso nao haja o Acesso, ele adiciona
			$sql_aterar="INSERT INTO acesso_local (id_nivel,id_local) VALUES (".$ids[1].",".$ids[2].")";	
			if ( @mysql_query($sql_aterar) ) {
				echo "ativo.png";
			}else{
				echo "no";
			}
		}
	}else{
		echo "no";
	}
}else if (is_numeric($ids[0])) {
	//Selecionando o Acesso Fornecido
	$sql_ace = "
		SELECT
			acesso.id_acesso,
			acesso.acesso
		FROM
			acesso
		WHERE
			acesso.id_nivel=".$ids[0]."
			AND acesso.id_menu=".$ids[1];
	
	//Verificando se existe o Acesso.
	//A Tabela de Acesso deve conter Apenas acesso='S'.
	//Para negar o acesso, basta excluir o registro.
	if ( $query_ace=@mysql_query($sql_ace) ) {
		//Caso haja o acesso=S, ele deve remover o acesso.
		if (@mysql_num_rows($query_ace)>=1 ) {
			while ($acesso = @mysql_fetch_assoc($query_ace) ) {	
				if (strtoupper($acesso['acesso'])=='S') {
					$sql_aterar="DELETE FROM acesso WHERE acesso.id_nivel=".$ids[0]." AND acesso.id_menu=".$ids[1];
					if ( @mysql_query($sql_aterar) ) {
						echo "inativo.png";
					}else{
						echo "no";
					}
				}else{
					echo "no";
				}
			}
		}else{
			//Caso nao haja o Acesso, ele adiciona
			$sql_aterar="INSERT INTO acesso (id_nivel,id_menu) VALUES (".$ids[0].",".$ids[1].")";	
			if ( @mysql_query($sql_aterar) ) {
				echo "ativo.png";
			}else{
				echo "no";
			}
		}
	}else{
		echo "no";
	}
}else{
	echo "no";
}
?>