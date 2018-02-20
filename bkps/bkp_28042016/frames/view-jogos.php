<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idJogo = $_GET['id'];

//consulta dados dessa maquina
$sql_jogo = "
	SELECT
		*
	FROM
		jogo
	WHERE
		id_jogo = " . $idJogo;	


$query_jogo=@mysql_query($sql_jogo);

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
					while($res_jogo=@mysql_fetch_assoc($query_jogo)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_jogo['id_jogo']; ?></td>
                    <th><?php echo _('Nombre Juego') ?></th>
                    <td><i><?php echo $res_jogo['nome']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Codigo') ?></th>
                    <td><?php echo $res_jogo['codigo']; ?></td>
                    <th><?php echo _('Porcentaje') ?></th>
                    <td><?php echo $res_jogo['porcentagem']; ?></td>
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