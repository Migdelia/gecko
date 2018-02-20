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
		chapas.id_chapa,
		modelos_chapa.codigo,
		modelos_chapa.descricao as modelo,
		maquinas.numero as maquina
	FROM
		chapas
	INNER JOIN
		modelos_chapa
	ON
		chapas.id_modelo = modelos_chapa.id_modelo
	INNER JOIN
		maquinas
	ON
		chapas.id_maquina = maquinas.id_maquina
	WHERE
		id_chapa = " . $idChapa;	


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
                    <td><?php echo $res_chapa['id_chapa']; ?></td>
                    <th><?php echo _('Modelo') ?></th>
                    <td><i><?php echo $res_chapa['modelo']; ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Codigo') ?></th>
                    <td><?php echo $res_chapa['codigo']; ?></td>
                    <th><?php echo _('Maquina') ?></th>
                    <td><?php echo $res_chapa['maquina']; ?></td>                    
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