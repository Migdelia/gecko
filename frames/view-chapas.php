<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idChapa = $_GET['id'];

//consulta dados dessa maquina
$sql_chapa = "
	SELECT
		id_modelo,
		codigo,
		descricao as modelo
	FROM
		modelos_chapa
	WHERE
		id_modelo = " . $idChapa;	
		


$query_chapa=@mysql_query($sql_chapa);

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
					while($res_chapa=@mysql_fetch_assoc($query_chapa)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_chapa['id_modelo']; ?></td>
                    <th><?php echo _('Modelo') ?></th>
                    <td><i><?php echo $res_chapa['modelo']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Codigo') ?></th>
                    <td><?php echo $res_chapa['codigo']; ?></td>
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