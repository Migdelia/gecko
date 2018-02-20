<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/connDongle.php');
//include('../functions/validaLogin.php');

//recebe id maquina por Get
$idDongle = $_GET['id'];

//Lendo a tabela de dongles
$sql_dongle = "
	SELECT
		MachineId,
		GameId,
		period,
		expirationDate,
		lastUpdate,
		userId,
		creditIn,
		creditOut
	FROM
		StreetDongle
	WHERE
		MachineId = ". $idDongle ."
	ORDER BY
		MachineId
	";		


	
$query_dongle=@mysql_query($sql_dongle);
$limitRegistros = mysql_num_rows($query_dongle);

include('conn/conn.php');
include('functions/validaLogin.php');




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
					while($res_disp=@mysql_fetch_assoc($query_dongle)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_disp['MachineId']; ?></td>
                    <th><?php echo _('Fecha') ?></th>
                    <td><i><?php echo date("d-m-Y H:i:s") ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Juego') ?></th>
                    <td><?php echo $res_disp['GameId']; ?></td>
                    <th><?php echo _('Periodo') ?></th>
                    <td><?php echo $res_disp['period']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Fecha de Expiracion') ?></th>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($res_disp['expirationDate'])); ?></td>
                    <th><?php echo _('Ultima Atualizacion') ?></th>
                    <td><?php echo date('d-m-Y H:i:s', strtotime($res_disp['lastUpdate'])); ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Entrada') ?></th>
                    <td><?php echo "$ " . number_format($res_disp['creditIn']*10,0,"","."); ?></td>
                    <th><?php echo _('Salida') ?></th>
                    <td><?php echo "$ " . number_format($res_disp['creditOut']*10,0,"","."); ?></td>
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