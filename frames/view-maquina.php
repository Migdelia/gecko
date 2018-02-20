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
                    <td><?php echo $res_maq['interface']; ?></td>
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
                  
                  <!--- PERIFERICOS --->
                  <?php
				  	//consulta o gabinete dessa maquina
					$sqlGab = "	SELECT
									descricao
								FROM
									tipo_maquina
								INNER JOIN
									maquinas
								ON
									tipo_maquina.id_tipo_maquina = maquinas.id_tipo_maquina
								WHERE
									maquinas.id_maquina =  " . $idMaq . "";
					
					$query_gab=@mysql_query($sqlGab);
					$res_gab=@mysql_fetch_assoc($query_gab);
					
				  	//consulta a placa dessa maquina
					$sqlPlacaMae = "SELECT
										modelos_placa_mae.descricao,
										placa_mae.serie
									FROM
										modelos_placa_mae
									INNER JOIN
										placa_mae
									ON
										modelos_placa_mae.id_modelo = placa_mae.modelo_id
									WHERE
										placa_mae.id_maquina =  " . $idMaq . "";
					
					$query_placaMae=@mysql_query($sqlPlacaMae);
					$res_placaMae=@mysql_fetch_assoc($query_placaMae);	
				  ?>
                  
                  <tr>
                    <th><?php echo _('Gabinete') ?></th>
                    <td><?php echo $res_gab['descricao']; ?></td>
                    <th><?php echo _('Placa Madre') ?></th>
                    <td><?php echo $res_placaMae['descricao'] . " &nbsp;(Serie: " . $res_placaMae['serie'] . ")"; ?></td>
                  </tr>

                  <?php
				  	//consulta bilheteiro dessa maquina
					$sqlBill = "SELECT
										modelos_bilheteiro.descricao,
										bilheteiros.serie
									FROM
										modelos_bilheteiro
									INNER JOIN
										bilheteiros
									ON
										modelos_bilheteiro.id_modelo = bilheteiros.modelo_id
									WHERE
										bilheteiros.id_maquina =  " . $idMaq . "";
					
					$query_bill=@mysql_query($sqlBill);
					$res_bill=@mysql_fetch_assoc($query_bill);	
					
					//consulta a placa dessa maquina
					$sqlPen = "SELECT
									modelos_pendrive.marca, 
									modelos_pendrive.descricao,
									pendrives.serie
								FROM
									modelos_pendrive
								INNER JOIN
									pendrives
								ON
									modelos_pendrive.id_modelo = pendrives.modelo_id
								WHERE
									pendrives.id_maquina =  " . $idMaq . "";
					
					$query_pen=@mysql_query($sqlPen);
					$res_pen=@mysql_fetch_assoc($query_pen);	

				  ?>

                  <tr>
                    <th><?php echo _('Billetero') ?></th>
                    <td><?php echo $res_bill['descricao'] . " &nbsp;(Serie: " . $res_bill['serie'] . ")"; ?></td>
                    <th><?php echo _('Pendrive') ?></th>
                    <td><?php echo $res_pen['marca'] . " - " . $res_pen['descricao'] . " &nbsp;(Serie: " . $res_pen['serie'] . ")"; ?></td>
                  </tr>
                  
                  <?php
				  	//consulta bilheteiro dessa maquina
					$sqlMon = "SELECT
									modelos_monitor.descricao,
									monitores.serie
								FROM
									modelos_monitor
								INNER JOIN
									monitores
								ON
									modelos_monitor.id_modelo = monitores.id_modelo
								WHERE
									monitores.id_maquina =  " . $idMaq . "";
					
					$queryMon=@mysql_query($sqlMon);
					$resMon=@mysql_fetch_assoc($queryMon);	
					
					//consulta a placa dessa maquina
					$sqlChapas = "SELECT
									modelos_chapa.descricao, 
									modelos_chapa.codigo
								FROM
									modelos_chapa
								INNER JOIN
									chapas
								ON
									modelos_chapa.id_modelo = chapas.id_modelo
								WHERE
									chapas.id_maquina = " . $idMaq . "";
					$queryChapas=@mysql_query($sqlChapas);

				  ?>
                  
                  <tr>
                    <th><?php echo _('Monitor') ?></th>
                    <td><?php echo $resMon['descricao'] . " &nbsp;(Serie: " . $resMon['serie'] . ")"; ?></td>
                    <th><?php echo _('Chapas') ?></th>
                    <td>
						<?php
							while($resChapas=@mysql_fetch_assoc($queryChapas))
							{
								echo $resChapas['codigo'] . ", "; 
							}
						?>
                    </td>
                  </tr>
                  
                  <!--- PERIFERICOS --->                  
                      
                  <tr>
                    <th><?php echo _('Entrada oficial') ?></th>
                    <td>$ <?php echo number_format($res_maq['entrada_oficial'],0,"","."); ?></td>
                    <th><?php echo _('Salida oficial') ?></th>
                    <td>$ <?php echo number_format($res_maq['saida_oficial'],0,"","."); ?></td>
                  </tr>
             
              

            </tbody>
          </table>
   	</div>
    
    
    <div class="table-responsive">
          <table class="table table-striped table-bordered table-hover">
            <tbody>
            	<tr>
                	<th>Observacion:</th>
                </tr>
                <tr height="63px">
                	<td><?php echo $res_maq['obs']; ?></td>
                </tr>
            </tbody>
   	</div>    
               <?php
					}			
				?> 
          
    </div>
    </div>
    </div>
</body>
    

</html>