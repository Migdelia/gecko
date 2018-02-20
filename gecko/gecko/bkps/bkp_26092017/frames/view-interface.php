<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('../conn/conn.php');
include('../functions/validaLogin.php');

//recebe id maquina por Get
$idInter = $_GET['id'];

//Lendo a tabela de dongles
$sql_inter = "
	SELECT
		interface.id_interface,
		interface.numero,
		maquinas.numero as maquina,
		jogo.nome,
		interface.excluido,
		interface.serie
	FROM
		interface
	INNER JOIN
		jogo
	ON
		interface.id_jogo = jogo.id_jogo
	INNER JOIN
		maquinas
	ON
		interface.id_maquina = maquinas.id_maquina
	WHERE
		interface.id_interface = ". $idInter;		

$query_inter=@mysql_query($sql_inter);


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
					while($res_inter=@mysql_fetch_assoc($query_inter)) 
					{				
				?>
                  <tr>
                    <th><?php echo _('ID') ?></th>
                    <td><?php echo $res_inter['id_interface']; ?></td>
                    <th><?php echo _('Numero') ?></th>
                    <td><i><?php echo $res_inter['numero'] ?></i></td>
                  </tr>
                  <tr>
                    <th><?php echo _('Juego') ?></th>
                    <td><?php echo $res_inter['nome']; ?></td>
                    <th><?php echo _('Máquina') ?></th>
                    <td><?php echo $res_inter['maquina']; ?></td>
                  </tr>
                  <tr>
                  
					  <?php
                        //
                        if($res_inter['excluido'] == 'N')
                        {
                            $status = "Activo";
                        }
                        else
                        {
                            $status = "Inactivo";
                        }
                      ?>                  
                  
                    <th><?php echo _('Status') ?></th>
                    <td><?php echo $status; ?></td>
                    <th><?php echo _('Serie') ?></th>
                    <td><?php echo $res_inter['serie']; ?></td>
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