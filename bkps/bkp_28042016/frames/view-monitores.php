<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idMon = $_GET['id'];

//consulta dados dessa maquina
$sql_mon = "
	SELECT
		monitores.id_monitor,
		monitores.serie,
		modelos_monitor.descricao,
		maquinas.numero
	FROM
		monitores
	INNER JOIN
		modelos_monitor
	ON
		monitores.id_modelo = modelos_monitor.id_modelo
	INNER JOIN
		maquinas
	ON
		monitores.id_maquina = maquinas.id_maquina
	WHERE
		monitores.id_monitor = " . $idMon;	


$query_mon=@mysql_query($sql_mon);


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
					while($res_mon=@mysql_fetch_assoc($query_mon)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_mon['id_monitor']; ?></td>
                    <th><?php echo _('Modelo') ?></th>
                    <td><i><?php echo $res_mon['descricao']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Serie') ?></th>
                    <td><?php echo $res_mon['serie']; ?></td>
                    <th><?php echo _('Maquina') ?></th>
                    <td><?php echo $res_mon['numero']; ?></td>
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