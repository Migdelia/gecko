<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idGab = $_GET['id'];

//consulta dados dessa maquina
$sql_gab = "
	SELECT
		*
	FROM
		tipo_maquina
	WHERE
		id_tipo_maquina = " . $idGab;	


$query_gab=@mysql_query($sql_gab);

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
					while($res_gab=@mysql_fetch_assoc($query_gab)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_gab['id_tipo_maquina']; ?></td>
                    <th><?php echo _('Descripcion') ?></th>
                    <td><i><?php echo $res_gab['descricao']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Codigo') ?></th>
                    <td><?php echo $res_gab['codigo']; ?></td>
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