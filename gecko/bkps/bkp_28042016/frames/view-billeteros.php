<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idBill = $_GET['id'];

//consulta dados dessa maquina
$sql_bill = "
	SELECT
		bilheteiros.id_bilheteiro,
		bilheteiros.serie,
		modelos_bilheteiro.descricao,
		maquinas.numero
	FROM
		bilheteiros
	INNER JOIN
		modelos_bilheteiro
	ON
		bilheteiros.modelo_id = modelos_bilheteiro.id_modelo
	INNER JOIN
		maquinas
	ON
		bilheteiros.id_maquina = maquinas.id_maquina
	WHERE
		bilheteiros.id_bilheteiro = " . $idBill;	


$query_bill=@mysql_query($sql_bill);


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
					while($res_bill=@mysql_fetch_assoc($query_bill)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_bill['id_bilheteiro']; ?></td>
                    <th><?php echo _('Modelo') ?></th>
                    <td><i><?php echo $res_bill['descricao']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Serie') ?></th>
                    <td><?php echo $res_bill['serie']; ?></td>
                    <th><?php echo _('Maquina') ?></th>
                    <td><?php echo $res_bill['numero']; ?></td>
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