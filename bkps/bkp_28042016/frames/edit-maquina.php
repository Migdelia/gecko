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
$res_maq=@mysql_fetch_assoc($query_maq);


// ingresar la palabra clave de cada modal
$modal_item = "Maquina";

?>

<!DOCTYPE html>
<html>
    <head>
    	<title>Gecko</title>
    	<?php include("../inc/headings_frames.php");// se llaman todos los metatags, css y librerías js ?>
    </head>
  
  <body class="body innerpages">
  <div class="modal-dialog">
  <div class="modal-content" style="border:0; border-radius:0;">
  <div class="modal-body">
  <div class="table-responsive" style="border:0; border-radius:0;">


        <form class="form-horizontal" method="post" action="../functions/alteraMaquina.php" target="_parent">
          <input type="hidden" id="id_maquina" name="id_maquina" value="<?php echo $res_maq['id_maquina'] ?>" >
          <div class="row">
            <div class="col-xs-6 col-md-6">
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Número de máquina') ?></label>
                <input type="text" class="form-control" id="input_num_<?php echo $modal_item ?>" name="input_num_<?php echo $modal_item ?>" placeholder="<?php echo _('Número de máquina') ?>" value="<?php echo $res_maq['numero'] ?>">
              </div>
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Codigo Maquina') ?></label>
                <input type="text" class="form-control" id="input_cod_<?php echo $modal_item ?>" name="input_cod_<?php echo $modal_item ?>" placeholder="<?php echo _('Codigo Maquina') ?>" value="<?php echo $res_maq['codigo'] ?>" disabled>
              </div>
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('Jogo') ?></label>
                <input type="text" class="form-control" id="input_jogo_<?php echo $modal_item ?>" name="input_jogo_<?php echo $modal_item ?>" placeholder="<?php echo _('Jogo') ?>" value="<?php echo $res_maq['jogo'] ?>" disabled>
              </div>  
              
              
              <?php
			  	//monsta lista de locais
				$sql_loc = "
					SELECT
						id_local,
						nome
					FROM
						local
					ORDER BY
						nome";	
				
				
				$query_loc=@mysql_query($sql_loc);			
			  ?>
              
                                       
              <div class="row form-group">
                <label for="input_mod<?php echo $modal_item ?>" class="control-label"><?php echo _('Local') ?></label>
                <input type="hidden" id="input_local_<?php echo $modal_item ?>" name="input_local_<?php echo $modal_item ?>" value="<?php echo $res_maq['id_local'] ?>" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_local_<?php echo $modal_item ?>" name="select_local_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo $res_maq['nome'] ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                
                <?php
					//
					while($res_loc=@mysql_fetch_assoc($query_loc)) 
					{
						echo "<li>";
						echo "<a href='#' id='local_".$res_loc['id_local']."' class='mass-act' onClick='atribuiValor(this);'> ". $res_loc['nome'] ." </a>";
						echo "</li>";
						echo "<li class='divider'></li>";
					}
				?>          
                </ul>
              </div>
              
              <?php
			  	//
				if($res_maq['excluido'] == 'N')
				{
					$status = "Activo";
				}
				else
				{
					$status = "Inactivo";
				}
			  ?>
              
              <div class="row form-group">
                <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo _('Status') ?></label>
                <input type="hidden" id="input_status_<?php echo $modal_item ?>" name="input_status_<?php echo $modal_item ?>" value="<?php echo $res_maq['excluido'] ?>" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_status_<?php echo $modal_item ?>" name="select_status_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo $status ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
                  <li>
                    <a id="status_s" href="#" class="mass-act" onClick='atribuiValor(this);'><?php echo _('Activo') ?></a>
                  </li>
                  <li class="divider"></li>
                  <li>
                    <a id="status_n" href="#" class="mass-act" onClick='atribuiValor(this);'><?php echo _('Inactivo') ?></a>
                  </li>
                  <li class="divider"></li>
                </ul>
              </div>
              
              
              <?php
			  	//monsta lista de dispositivos de seguranca
				$sql_disp = "
					SELECT
						id_interface,
						numero
					FROM
						interface
					ORDER BY
						numero";	
				
				
				$query_disp=@mysql_query($sql_disp);				
			  ?>              
              
              
              <div class="row form-group">
                <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo _('Disp de Seguridad') ?></label>
                <input type="hidden" id="input_disp_<?php echo $modal_item ?>" name="input_disp_<?php echo $modal_item ?>" value="<?php echo $res_maq['interface'] ?>" >
                <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="select_disp_<?php echo $modal_item ?>" name="select_disp_<?php echo $modal_item ?>" class="btn dropdown-btn"><?php echo $res_maq['interface'] ?><div class="ripple-container"></div></a>
                <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
                <ul class="dropdown-menu">
					<?php
                        //
                        while($res_disp=@mysql_fetch_assoc($query_disp)) 
                        {
                            echo "<li>";
                            echo "<a href='#' id='disp_".$res_disp['id_interface']."' class='mass-act' onClick='atribuiValor(this);'> ". $res_disp['numero'] ." </a>";
                            echo "</li>";
							echo "<li class='divider'></li>";
                        }
                    ?>  
                </ul>
              </div> 
              
              <div class="row form-group">
                <label for="input_obsm<?php echo $modal_item ?>" class="control-label"><?php echo _('Ordem Leitura') ?></label>
                <input type="text" class="form-control" id="input_ordem_<?php echo $modal_item ?>" name="input_ordem_<?php echo $modal_item ?>" placeholder="<?php echo _('Ordem Leitura') ?>" value="<?php echo $res_maq['ordem_leitura'] ?>">
              </div>                           
                            
              <div class="row form-group">
                <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Entrada Oficial') ?></label>
                <input type="text" class="form-control" id="input_entrada_<?php echo $modal_item ?>" name="input_entrada_<?php echo $modal_item ?>" placeholder="<?php echo _('Entrada Oficial') ?>" value="<?php echo number_format($res_maq['entrada_oficial'],0,"",".") ?>">
              </div> 
              <div class="row form-group">
                <label for="input_obs<?php echo $modal_item ?>" class="control-label"><?php echo _('Saida Oficial') ?></label>
                <input type="text" class="form-control" id="input_saida_<?php echo $modal_item ?>" name="input_saida_<?php echo $modal_item ?>" placeholder="<?php echo _('Saida Oficial') ?>" value="<?php echo number_format($res_maq['saida_oficial'],0,"",".") ?>">
              </div>                                                                          
            </div>
            <div class="col-xs-6 col-md-6">
              <div class="row form-group">
                <h6><?php echo _('Registros especiales') ?></h6>
              </div>
              
                          
              
              <div class="row form-group">
                <div class="checkbox">
                  <?php echo _('Maquina Parceiro');
				  	//
					if($res_maq['parceiro'] == 1)
					{
				  		echo "<label><input id='check_parce' name='check_parce' type='checkbox' checked><span class='checkbox-material'></span></label>";
					}
					else
					{
						echo "<label><input id='check_parce' name='check_parce' type='checkbox'><span class='checkbox-material'></span></label>";	
					}
				  ?>
                </div>
              </div>               
              
              <div class="row form-group">
                <div class="checkbox">
                  <?php echo _('Maquina Socio &nbsp; &nbsp;&nbsp;');
				  	//
					if($res_maq['maq_socio'] == "true")
					{
				  		echo "<label><input id='check_maquina_socio' name='check_maquina_socio' type='checkbox' checked><span class='checkbox-material'></span></label>";
					}
					else
					{
						echo "<label><input id='check_maquina_socio' name='check_maquina_socio' type='checkbox'><span class='checkbox-material'></span></label>";	
					}				  
				  ?>
                </div>
              </div>              
                             
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Socio') ?></label>
                <input type="text" class="form-control" id="input_pctSocio_<?php echo $modal_item ?>" name="input_pctSocio_<?php echo $modal_item ?>" placeholder="<?php echo _('% Socio') ?>" value="<?php echo $res_maq['porc_socio'] ?>" >
              </div>
              
              <div class="row form-group">
                <label for="input_num<?php echo $modal_item ?>" class="control-label"><?php echo _('% Especial') ?></label>
                <input type="text" class="form-control" id="input_pctEspecial_<?php echo $modal_item ?>" name="input_pctEspecial_<?php echo $modal_item ?>" placeholder="<?php echo _('% Especial') ?>" value="<?php echo $res_maq['porc_maquina'] ?>">
              </div>              
              
              <div class="row form-group">
                <h6><?php echo _('Perifericos') ?></h6>
              </div>
     
              
<?php

	//seleciona todos os perifericos dessa maquina
	$sql_per = "
	SELECT
		id_tipo_maquina as id_per,
		'Gabinete' as tipo,
		descricao as serie,
		'tipo_maquina' as tabela
	FROM
		tipo_maquina
	WHERE
		id_tipo_maquina = 3
UNION	
	SELECT
		id_placa as id_per,
		'Placa Madre' as tipo,
		serie,
		'placa_mae' as tabela
	FROM
		placa_mae
	WHERE
		id_maquina = " . $idMaq . "
UNION
	SELECT
		id_bilheteiro as id_per,
		'Bilheteiro' as tipo,
		serie,
		'bilheteiros' as tabela
	FROM
		bilheteiros
	WHERE
		id_maquina = " . $idMaq . "
UNION
	SELECT
		id_pendrive as id_per,
		'Pendrive' as tipo,
		serie,
		'pendrives' as tabela
	FROM
		pendrives
	WHERE
		id_maquina = " . $idMaq . "
UNION
	SELECT
		id_monitor as id_per,
		'Monitor' as tipo,
		serie,
		'monitores' as tabela
	FROM
		monitores
	WHERE
		id_maquina = " . $idMaq . "
UNION
	SELECT
		id_chapa as id_per,
		'Chapa' as tipo,
		id_chapa as serie,
		'chapas' as tabela
	FROM
		chapas
	WHERE
		id_maquina = " . $idMaq;	
	
	
	$query_per=@mysql_query($sql_per);
	//$res_per=@mysql_fetch_assoc($query_per);
	
	//echo $sql_per;
	
	while($res_per=@mysql_fetch_assoc($query_per)) 
	{
?>
      <div class="row form-group">
        <label for="input_interface<?php echo $modal_item ?>" class="control-label"><?php echo $res_per['tipo'] ?></label>
        <input type="hidden" id="input_per_<?php echo $res_per['tabela'] ?>" name="input_per_<?php echo $res_per['tabela'] ?>" value="<?php echo $res_per['id_per'] ?>" >
        <a href="#" data-target="#" data-toggle="dropdown" aria-expanded="false" id="input_tipo_<?php echo $res_per['tabela'] . $modal_item ?>" name="input_tipo_<?php echo $res_per['tabela'] . $modal_item ?>" class="btn dropdown-btn"><?php echo $res_per['serie'] ?><div class="ripple-container"></div></a>
        <a href="#" data-target="#" class="btn dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class="caret"></span><div class="ripple-container"></div></a>
        <ul class="dropdown-menu">
        
<?php
		$sql_lista_per = "
			SELECT
				serie
			FROM
				". $res_per['tabela'] ."
			";
		$query_lista_per=@mysql_query($sql_lista_per);
		
		//
		while($res_lista_per=@mysql_fetch_assoc($query_lista_per)) 
		{
			echo "<li>";
			echo "<a href='#' class='mass-act'>".$res_lista_per['serie']."</a>";
			echo "</li>";
			echo "<li class='divider'></li>";			
		}		
		
?>      
        </ul>
      </div>
<?php				
	}
?>              
              
              
              
              
              
                         
            </div>
          </div>
          
          
          
          <div class="row form-group">
          	<div class="col-xs-10">
            	<label for="input_resp<?php echo $modal_item ?>" class="control-label"><?php echo _('Observacion maquina') ?></label>
            	<input type="text" class="form-control" id="input_obs_<?php echo $modal_item ?>" name="input_obs_<?php echo $modal_item ?>" placeholder="<?php echo _('Observacion maquina') ?>" value="<?php echo $res_maq['obs'] ?>">
            </div>
          </div>          
          
          <div class="row form-group">
            <div class="col-xs-6">
              <button type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Guardar ') . $modal_item ?></button>
            </div>
          </div>
        </form>	
   	</div>
          
    </div>
    </div>
    </div>
</body>
    

</html>

<script>
//
function atribuiValor(obj)
{
	//
	var tpCombo = obj.id.split("_");
	tpCombo = tpCombo[0];
	
	//
	$('#select_'+tpCombo+'_Maquina').text(obj.text);
}
</script>