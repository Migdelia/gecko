<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idLoc = $_GET['id'];

//consulta dados desse local
$sql_loc = "
	SELECT
		*
	FROM
		vw_local
	WHERE
		id_local = " . $idLoc;	
$query_loc=@mysql_query($sql_loc);



//consulta quantas maquinas tem ativas nesse local
$sql_qtdMaq = "
SELECT
	COUNT(id_maquina) as qtd_maq
FROM
	maquinas
WHERE
	id_local = ". $idLoc ."
AND 
	excluido = 'N'";	
$query_qtdMaq=@mysql_query($sql_qtdMaq);
$res_qtdMaq=@mysql_fetch_assoc($query_qtdMaq);

?>

<!DOCTYPE html>
<html>
    <head>
    	<title>Gecko</title>
    	<?php include("../inc/headings_frames.php"); // se llaman todos los metatags, css y librerías js ?>
    </head>
  
  <body class="body innerpages">
  <div class="modal-dialog">
  <div class="modal-content" style="border:0; border-radius:0;">
  <div class="modal-body">
  <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <tbody>
            	<?php
					while($res_loc=@mysql_fetch_assoc($query_loc)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_loc['id_local']; ?></td>
                    <th><?php echo _('Nome') ?></th>
                    <td><i><?php echo $res_loc['nome']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Operador') ?></th>
                    <td><?php echo $res_loc['operador']; ?></td>
                    <th><?php echo _('Rut') ?></th>
                    <td><?php echo $res_loc['rut']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Razon Social') ?></th>
                    <td><?php echo $res_loc['razao_social']; ?></td>
                    <th><?php echo _('Activo') ?></th>
                    <td><?php echo $res_loc['excluido']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Direccion') ?></th>
                    <td><?php echo $res_loc['endereco']; ?></td>
                    <th><?php echo _('Rasponsable') ?></th>
                    <td><?php echo $res_loc['responsavel']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Contacto') ?></th>
                    <td><?php echo $res_loc['contacto']; ?></td>
                    <th><?php echo _('Porcentaje') ?></th>
                    <td><?php echo $res_loc['percentual']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Ciudad') ?></th>
                    <td><?php echo $res_loc['nome_cidade']; ?></td>
                    <th><?php echo _('Tipo Local') ?></th>
                    <td><?php echo $res_loc['id_tp_local']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Gerente') ?></th>
                    
                    <?php
							//consulta nome do gerente
							$sql_gerente = "SELECT nome FROM logins WHERE id_login = " . $res_loc['id_gerente'];
							$query_gerente=@mysql_query($sql_gerente);
							$res_gerente=@mysql_fetch_assoc($query_gerente)
					?>
                    
                    <td><?php echo $res_gerente['nome']; ?></td>
                    <th><?php echo _('Porcentaje Operador') ?></th>
                    <td><?php echo number_format($res_loc['pct_operador'],0,"","."); ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Administrador') ?></th>
                    
                    
                    <?php
							//consulta nome do gerente
							$sql_admin = "SELECT nome FROM logins WHERE id_login = " . $res_loc['id_admin'];
							$query_admin=@mysql_query($sql_admin);
							$res_admin=@mysql_fetch_assoc($query_admin)
					?>
                                        
                    
                    <td><?php echo $res_admin['nome']; ?></td>
                    <th><?php echo _('Cantidad Máquinas') ?></th>
                    <td><?php echo $res_qtdMaq['qtd_maq']; ?></td>
                  </tr>                  
                  <tr>
                    <th><?php echo _('Porcentaje Gerente') ?></th>
                    <td><?php echo $res_loc['pct_gerente']; ?></td>
                    <th>&nbsp;</th>
                    <td>&nbsp;</td>
                  </tr>                  
            	<?php
					}			
				?>              
              

            </tbody>
          </table>
   	</div>
          
    </div>
    </div>
    </div>
</body>
    

</html>