<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idLoc = $_GET['id'];

//consulta dados dessa maquina
$sql_loc = "
	SELECT
		*
	FROM
		local
	WHERE
		id_local = " . $idLoc;	


$query_loc=@mysql_query($sql_loc);

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
                    <td><?php echo $res_loc['id_login']; ?></td>
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
                    <td><?php echo $res_loc['id_regiao']; ?></td>
                    <th><?php echo _('Tipo Local') ?></th>
                    <td><?php echo $res_loc['id_tp_local']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Gerente') ?></th>
                    <td><?php echo $res_loc['id_gerente']; ?></td>
                    <th><?php echo _('Porcentaje Operador') ?></th>
                    <td><?php echo number_format($res_loc['pct_operador'],0,"","."); ?></td>
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