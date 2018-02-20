<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idPlaca = $_GET['id'];

//consulta dados dessa maquina
$sql_placa = "
	SELECT
		placa_mae.id_placa,
		placa_mae.serie,
		modelos_placa_mae.descricao,
		maquinas.numero
	FROM
		placa_mae
	INNER JOIN
		modelos_placa_mae
	ON
		placa_mae.modelo_id = modelos_placa_mae.id_modelo
	INNER JOIN
		maquinas
	ON
		placa_mae.id_maquina = maquinas.id_maquina
	WHERE
		placa_mae.id_placa = " . $idPlaca;	


$query_placa=@mysql_query($sql_placa);

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
					while($res_placa=@mysql_fetch_assoc($query_placa)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_placa['id_placa']; ?></td>
                    <th><?php echo _('Modelo') ?></th>
                    <td><i><?php echo $res_placa['descricao']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Serie') ?></th>
                    <td><?php echo $res_placa['serie']; ?></td>
                    <th><?php echo _('Maquina') ?></th>
                    <td><?php echo $res_placa['numero']; ?></td>
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