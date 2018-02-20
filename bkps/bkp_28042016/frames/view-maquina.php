<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idMaq = $_GET['id'];

//consulta dados dessa maquina
$sql_maq = "
	SELECT
		*
	FROM
		vw_maquinas
	WHERE
		id_maquina = " . $idMaq;	


$query_maq=@mysql_query($sql_maq);

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
					while($res_maq=@mysql_fetch_assoc($query_maq)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_maq['id_maquina']; ?></td>
                    <th><?php echo _('Fecha') ?></th>
                    <td><i><?php echo date("d-m-Y H:i:s") ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Codigo') ?></th>
                    <td><?php echo $res_maq['codigo']; ?></td>
                    <th><?php echo _('Número') ?></th>
                    <td><?php echo $res_maq['numero']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Local') ?></th>
                    <td><?php echo $res_maq['nome']; ?></td>
                    <th><?php echo _('Juego') ?></th>
                    <td><?php echo $res_maq['jogo']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Dispositivo de Seguridad') ?></th>
                    <td><?php echo $res_maq['id_interface']; ?></td>
                    <th><?php echo _('Por máquina esp') ?></th>
                    <td><?php echo $res_maq['porc_maquina']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Máquina de socio') ?></th>
                    <td><?php echo $res_maq['maq_socio']; ?></td>
                    <th><?php echo _('Porcentaje socio') ?></th>
                    <td><?php echo $res_maq['porc_socio']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Operador') ?></th>
                    <td><?php echo $res_maq['operador']; ?></td>
                    <th><?php echo _('Máquina Parceiro') ?></th>
                    <td><?php echo $res_maq['parceiro']; ?></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Entrada oficial') ?></th>
                    <td>$ <?php echo number_format($res_maq['entrada_oficial'],0,"","."); ?></td>
                    <th><?php echo _('Salida oficial') ?></th>
                    <td>$ <?php echo number_format($res_maq['saida_oficial'],0,"","."); ?></td>
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