<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idPen = $_GET['id'];

//consulta dados dessa maquina
$sql_pen = "
	SELECT
		pendrives.id_pendrive,
		pendrives.serie,
		modelos_pendrive.descricao,
		maquinas.numero
	FROM
		pendrives
	INNER JOIN
		modelos_pendrive
	ON
		pendrives.modelo_id = modelos_pendrive.id_modelo
	INNER JOIN
		maquinas
	ON
		pendrives.id_maquina = maquinas.id_maquina
	WHERE
		pendrives.id_pendrive = " . $idPen;	


$query_pen=@mysql_query($sql_pen);


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
					while($res_pen=@mysql_fetch_assoc($query_pen)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_pen['id_pendrive']; ?></td>
                    <th><?php echo _('Modelo') ?></th>
                    <td><i><?php echo $res_pen['descricao']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Serie') ?></th>
                    <td><?php echo $res_pen['serie']; ?></td>
                    <th><?php echo _('Maquina') ?></th>
                    <td><?php echo $res_pen['numero']; ?></td>
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