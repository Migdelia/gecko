<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//$id_assoc = 77;
$id_leitura = $_GET['id'];

$sql_leitura = "
SELECT * 
from leitura_por_maquina
 where 
 id_leitura = '".$id_leitura."' ";

$query_lec = @mysql_query($sql_leitura);

while ($result_lec=@mysql_fetch_assoc($query_lec)) {

	$id_assoc= $result_lec['id_local'];
}



$sql_loc = "
	SELECT
		local.nome,
		local.percentual,
		local.id_tp_local
	FROM
		`local`
	WHERE
		local.id_local IS NOT NULL
		AND `id_local` = '".$id_assoc."'
	";



	
$query_loc=@mysql_query($sql_loc);
$result_loc=@mysql_fetch_assoc($query_loc);


//consulta ultima leitura desse local
$sql_ult_id = "
	select * from 
 local where 
id_local= ".$id_assoc."
	";

$query_ult_id=@mysql_query($sql_ult_id);
$rst_ult_id=@mysql_fetch_assoc($query_ult_id);

$id_local= $rst_ult_id["id_local"];

//
$sql_maq = "	SELECT
	leitura.id_local,
  leitura.id_operador,
	leitura.id_admin,
	leitura.id_gerente,
	leitura.id_login,
	leitura.id_tipo_local,
	leitura.pct_gerente,
	leitura.pct_local,
	leitura.pct_operador,
	leitura.semana,
  leitura.data_fechamento,
  leitura.fechada
FROM
	leitura
WHERE
leitura.id_local = '".$id_assoc."'
AND leitura.id_leitura = '".$id_leitura."'";

//echo $sql_maq;
$query_maq=@mysql_query($sql_maq);
while($result_lec = mysql_fetch_array($query_maq)) 
	
	{

		$local = $result_lec["id_tipo_local"];
		$operador = $result_lec["id_operador"];
		$admin = $result_lec["id_admin"];
		$gerente = $result_lec["id_gerente"];
		$login = $result_lec["id_login"];
		$por_gerente = $result_lec["pct_gerente"];
		$por_local = $result_lec["pct_local"];
		$por_operador = $result_lec["pct_operador"];
		$semana = $result_lec["semana"];
		$fechamento = $result_lec["data_fechamento"];
    $fechada = $result_lec["fechada"];
		

	}


$originalDate = $fechamento;
$fechamento = date("d-m-Y", strtotime($originalDate));


?>
<!DOCTYPE html>
<html>
<head>
  <title>Gecko</title>
  <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
</head>

<body class="body innerpages">
  <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
  <?php $file_name = "lectura" // ingresar la palabra clave de cada modal ?>

  <div class="container-fluid innpage-<?php echo $filenameID; ?>">
    <div class="row">
      <?php include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
    </div>
    <div class="row">
      <?php include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
      <div class="inner-content col-xs-12 col-sm-9">
        <div class="page<?php echo $filenameID; ?>">
          <div class="row">
            <div class="col-xs-12 col-lg-6">
              <h3 class="main-title">
                <span class="fa-stack fa-md">
                </span>
          
                <?php
      	        echo "<a href='ver-informe-lectura.php?id=$id_leitura'  title='Volver a la lectura'><i class='fa fa-arrow-circle-left' style='font-size:30px;'></i></a> (".$result_loc['nome'].")";
					
      
				       ?> 
              </h3>
            </div>
            <div class="col-xs-12 col-lg-6">

              <?php  if ($fechada==1) {

                echo "<a href='#' class='btn' data-toggle='modal' data-target='#massaction-modal' title='Abrir Lectura'><i class='fa fa-lock' style='font-size:20px;'>  Abrir Lectura</i></a>";
                include("inc/modals/modal-actions-abrir-lectura.php"); 

              }else{
                include('inc/buttons-editar-configuracion-lectura.php');
                include("inc/modals/modal-actions-lectura-edit.php"); // modal para agregar contenido 
                include("inc/modals/modal-actions-lectura-alert.php");
              }
            ?>
            </div>
          </div>
   
          <div class="row">
            <div class="col-xs-12 col-md-8">
              <div class="panel">
                <div class="panel-heading">
                  <div class="input-wrap">
                    <!-- dropdown de selects -->
                    <div class="btn-group white-btn">
                      <i class=" fa fa-gears"></i> <b><?php echo _('Edición de configuración de Lectura ');  ?></b>

                    </div>                                      
                  </div>                 
                </div>
                <div class="panel-body">
                  <div class="col-xs-12 col-sm-12 col-md-12">
                    <div class="table-responsive">
                      <form  action="" method="post">
                        <div class="row">
                       <div class="col-xs-12 col-md-6">
                                 <div class="form-group">
                                <label for="nombre">Tipo de Local</label>
                                <?php if ($fechada==1) {
                                 echo "<select disabled name='local'  id='local' class='form-control'>";
                           
                                
                                 $resultw = mysql_query("SELECT * FROM tipo_local order by tp_local ");
                                   while($roww = mysql_fetch_array($resultw))
                                  { 
                            echo "<option value='".$roww["id_tp_local"]."' ";
                            if ($roww["id_tp_local"] == $local)
                            {
                               echo " selected='".$roww["tp_local"]."' />";
                              $val =$roww["tp_local"]."</option>"; 
                            }
                            else
                            {
                              echo " />";
                              $val = $roww["tp_local"]."</option>"; 
                            }
                            echo $val;  
                            }
                      
                  echo" </select>";
                  }else{
                        echo "<select  name='local'  id='local' class='form-control'>";
                           $resultw = mysql_query("SELECT * FROM tipo_local order by tp_local ");
                                   while($roww = mysql_fetch_array($resultw))
                                  { 
                            echo "<option value='".$roww["id_tp_local"]."' ";
                            if ($roww["id_tp_local"] == $local)
                            {
                               echo " selected='".$roww["tp_local"]."' />";
                              $val =$roww["tp_local"]."</option>"; 
                            }
                            else
                            {
                              echo " />";
                              $val = $roww["tp_local"]."</option>"; 
                            }
                            echo $val;  
                            }

                          echo" </select>";
                          }

                          ?>
                          
                      </div>
                   </div>

           				  <div class="col-xs-12 col-md-6">
                                 <div class="form-group">
                                <label for="nombre">Operador</label>
                                   <?php  if ($fechada==1) {
            
                                 echo"<select disabled name='operador' id='operador' class='form-control'>";
                            
                            		 $resultw = mysql_query("SELECT * FROM logins where excluido = 'N' AND id_nivel= '8' ");
                           				 while($roww = mysql_fetch_array($resultw))
                          				{
               				 			echo "<option value='".$roww["id_login"]."' ";
               							if ($roww["id_login"] == $operador)
                						{
                   						 echo " selected='".$roww["nome"]."' />";
                    					$val =$roww["nome"]."</option>"; 
                						}
                						else
               				 			{
                    					echo " />";
                   			 			$val = $roww["nome"]."</option>"; 
               				 			}
                						echo $val;  
          			  					}
                        echo "</select>";
                      }else{
                          echo"<select name='operador' id='operador' class='form-control'>"; 

                          $resultw = mysql_query("SELECT * FROM logins where excluido = 'N' AND id_nivel= '8' ");
                                   while($roww = mysql_fetch_array($resultw))
                                  {
                            echo "<option value='".$roww["id_login"]."' ";
                            if ($roww["id_login"] == $operador)
                            {
                               echo " selected='".$roww["nome"]."' />";
                              $val =$roww["nome"]."</option>"; 
                            }
                            else
                            {
                              echo " />";
                              $val = $roww["nome"]."</option>"; 
                            }
                            echo $val;  
                            }
                        echo "</select>";
                      }
 
								?>
                       		 
                			</div>
           				 </div>

          			</div>
          			<div class="row">
          			  <div class="col-xs-12 col-md-6">
                                 <div class="form-group">
                                <label for="nombre">Gerente</label>
                                    <?php if ($fechada==1) {
                                 echo"<select disabled name='gerente' id='gerente' class='form-control'>";
                           
            
                            		 $resultw = mysql_query("SELECT * FROM logins where excluido = 'N' AND id_nivel= '8' ");
                           				 while($roww = mysql_fetch_array($resultw))
                          				{
               				 			echo "<option value='".$roww["id_login"]."' ";
               							if ($roww["id_login"] == $gerente)
                						{
                   						 echo " selected='".$roww["nome"]."' />";
                    					$val =$roww["nome"]."</option>"; 
                						}
                						else
               				 			{
                    					echo " />";
                   			 			$val = $roww["nome"]."</option>"; 
               				 			}
                						echo $val;  
          			  					}
                           echo "</select>";
                           }else{
                                 echo"<select  name='gerente' id='gerente' class='form-control'>";
                                   
                                 $resultw = mysql_query("SELECT * FROM logins where excluido = 'N' AND id_nivel= '8' ");
                                   while($roww = mysql_fetch_array($resultw))
                                  {
                            echo "<option value='".$roww["id_login"]."' ";
                            if ($roww["id_login"] == $gerente)
                            {
                               echo " selected='".$roww["nome"]."' />";
                              $val =$roww["nome"]."</option>"; 
                            }
                            else
                            {
                              echo " />";
                              $val = $roww["nome"]."</option>"; 
                            }
                            echo $val;  
                            }
                      echo "</select>"; 

                      }
      
								?>
                       		 </select>
                			</div>
           				 </div>
           				 <div class="col-xs-12 col-md-6">
                                 <div class="form-group">
                                <label for="nombre">Administrador</label>
                                 <?php if ($fechada==1) {
                                 echo"<select disabled name='admin' id='admin' class='form-control'>";
                              
            
                            		 $resultw = mysql_query("SELECT * FROM logins where excluido = 'N' AND id_nivel= '9' ");
                           				 while($roww = mysql_fetch_array($resultw))
                          				{
               				 			echo "<option value='".$roww["id_login"]."' ";
               							if ($roww["id_login"] == $admin)
                						{
                   						 echo " selected='".$roww["nome"]."' />";
                    					$val =$roww["nome"]."</option>"; 
                						}
                						else
               				 			{
                    					echo " />";
                   			 			$val = $roww["nome"]."</option>"; 
               				 			}
                						echo $val;  
          			  					}
                            echo "</select>"; 
                         } else{
                            echo"<select name='admin' id='admin' class='form-control'>";
                            $resultw = mysql_query("SELECT * FROM logins where excluido = 'N' AND id_nivel= '9' ");
                             while($roww = mysql_fetch_array($resultw))
                            {
                            echo "<option value='".$roww["id_login"]."' ";
                            if ($roww["id_login"] == $admin)
                            {
                               echo " selected='".$roww["nome"]."' />";
                              $val =$roww["nome"]."</option>"; 
                            }
                            else
                            {
                              echo " />";
                              $val = $roww["nome"]."</option>"; 
                            }
                            echo $val;  
                            }
                            echo "</select>"; 

                         }
								?>
                       		 </select>
                			</div>
           				 </div>		

          			</div>		
					<div class=" row">
						<div class="col-xs-12 col-md-6">
                                 <div class="form-group">
                                <label for="nombre">Login</label>
                                  <?php  if ($fechada==1) {

                                 echo "<select disabled name='login' id='login' class='form-control'>";
                             
            
                            		 $resultw = mysql_query("SELECT * FROM logins where excluido = 'N'  ");
                           				 while($roww = mysql_fetch_array($resultw))
                          				{
               				 			echo "<option value='".$roww["id_login"]."' ";
               							if ($roww["id_login"] == $login)
                						{
                   						 echo " selected='".$roww["nome"]."' />";
                    					$val =$roww["nome"]."</option>"; 
                						}
                						else
               				 			{
                    					echo " />";
                   			 			$val = $roww["nome"]."</option>"; 
               				 			}
                						echo $val;  
          			  					}
                             echo "</select>"; 

                         }else{

                                echo "<select name='login' id='login' class='form-control'>";
                             
            
                                 $resultw = mysql_query("SELECT * FROM logins where excluido = 'N'  ");
                                   while($roww = mysql_fetch_array($resultw))
                                  {
                            echo "<option value='".$roww["id_login"]."' ";
                            if ($roww["id_login"] == $login)
                            {
                               echo " selected='".$roww["nome"]."' />";
                              $val =$roww["nome"]."</option>"; 
                            }
                            else
                            {
                              echo " />";
                              $val = $roww["nome"]."</option>"; 
                            }
                            echo $val;  
                            }
                             echo "</select>"; 

                         }
      
								?>
                       		 </select>
                			</div>
           				 </div>	
           				 <div class="col-xs-12 col-md-6">
           				 	<div class="form-group">
                 	          <label for="por_local">Porcentaje del local  </label>
                            <?php if ($fechada==1){
                              echo "<input name='por_local' type='text' required class='form-control' id='por_local' placeholder='Porcentaje del Local' maxlength='3' value=' $por_local' disabled>";

                            }else{
                              echo "<input name='por_local' type='text' required class='form-control' id='por_local' placeholder='Porcentaje del Local' maxlength='3' value='$por_local'>";
                            }  

                            ?>
                   		     </div>
           				 </div>
					       </div>
					       <div class="row">
					          <div class="col-xs-12 col-md-6">
						            <div class="form-group">
                 	          <label for="por_gerente">Porcentaje del gerente  </label>
                               <?php if ($fechada==1){
                              echo "<input name='por_gerente' type='text' required class='form-control' id='por_gerente' placeholder='Porcentaje del Gerente' maxlength='3' value=' $por_gerente' disabled>";

                            }else{
                              echo "<input name='por_gerente' type='text' required class='form-control' id='por_gerente' placeholder='Porcentaje del Gerente' maxlength='3' value=' $por_gerente'>";
                            }  

                            ?>
            	         </div>
          				</div>
				        	<div class="col-xs-12 col-md-6">
					         	<div class="form-group">
                 	          <label for="por_operador">Porcentaje del Operador  </label>
                              <?php if ($fechada==1){
                              echo "<input name='por_operador' type='text' required class='form-control' id='por_operador' placeholder='Porcentaje del Gerente' maxlength='3' value=' $por_operador' disabled>";

                            }else{
                              echo "<input name='por_operador' type='text' required class='form-control' id='por_operador' placeholder='Porcentaje del Gerente' maxlength='3' value='$por_operador'>";
                            }  
                            ?>
                   	</div>
      					</div>
					     </div>
					     <div class="col-xs-12 col-md-6">
                <div class="row">
                  <label for="tags">Fecha de Cierre </label>
                      <?php if ($fechada==1){
                              echo " <input type='text' id='datepicker' name='datepicker' size='23' placeholder='dd-mm-aaaa' value='$fechamento'  readonly disabled>";

                            }else{
                              echo "<input type='text' id='datepicker' name='datepicker' size='23' placeholder='dd-mm-aaaa' value='$fechamento' onchange='verificaDia(this);' readonly ";
                            }  
                            ?>
                 
                </div>             
               </div>
		           </form>
                     
                    </div>
                  </div>

                </div>
              </div>

            </div>

            <div class="col-xs-12 col-md-4">

              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
</body>
</html>

<script>
	//edita Bruto

	$('select').select2();

	$('#confirmar').click( function ()
	{
		
		//verifica se foi selecionada uma semana 	
		var flagSemana = $ ("#datepicker").val();
  	var diaFecha = $ ("#datepicker").val();
  	


   //alert(diaFecha);

  
    var id_fechamento = "<?=$id_fechamento?>";
    var id_leitura = "<?=$id_leitura?>";
    var id_operador =$ ("#operador").val();
    var id_gerente =$ ("#gerente").val();

   
    var id_login =$ ("#login").val();
    var id_admin =$ ("#admin").val();
    


  
    var por_gerente = $("#por_gerente").val();
    var por_local = $("#por_local").val();

    var por_operador = $("#por_operador").val();
    var id_tipo_local = $("#local").val();

  

		//
		var semSel = flagSemana.split(",");
    semSel = semSel[0].split("-");
		semSel = semSel[0];
		//alert(semSel);
		//calcula semana
		semSel = eval(semSel) / 7;


		if((parseFloat(semSel) == parseInt(semSel)) && !isNaN(semSel))
		{
			semSel = semSel;
		} 
		else
		{
			var semSel = semSel.toString();
			var semSel = semSel.split(".");
			semSel = eval(semSel[0]) + 1;
		}
		
		//var semSel = '2'; // verificar aqui **** erico
		
		$("#confirmar").attr('disabled','disabled');

		//
		$.post('functions/edit-config-leitura.php',{id_leitura:id_leitura,id_operador:id_operador,id_gerente:id_gerente,id_login:id_login,id_admin:id_admin,id_fechamento:id_fechamento,id_tipo_local:id_tipo_local,por_gerente:por_gerente,por_local:por_local,semana:semSel,dia_fecha:diaFecha,por_operador:por_operador},function(json){

      //alert(json);
     
    	if(json>0)
			{
        $('#massaction-modal').modal('hide');
        $('#modal-alert').modal({});
          //location="ver-informe-lectura.php?id="+id_leitura;
			}
			else
			{
				alert("Error!");
		    	location.reload();
			}

		});

	});


$('#btnabrir').click( function ()
  {
      var id_leitura = "<?=$id_leitura?>";
      var fechada = null;
      var data_fechamento = "0";
      var id_fechamento="0";
  
    $.post('functions/abrir_lectura.php',{id_leitura:id_leitura,fechada:fechada,data_fechamento:data_fechamento,id_fechamento:id_fechamento},function(json){
      
  
       if(json>0)
        {
          location="lectura-edit-configuracion.php?id="+<?=$id_leitura?>;  
        } else
        {
        alert("Error!");
        location.reload();
        }  
   

    }); 

      
  });

	
	//
	$('#btnOk').click( function ()
	{
		location="ver-informe-lectura.php?id="+<?=$id_leitura?>;	
	});
	
	$(function() {
		$("#datepicker").datepicker({dateFormat: 'dd-mm-yy, DD'});
	});	

	function verificaDia(obj)
	{

		var diaSemana = obj.value;
		var diaSemana = diaSemana.split(",");
		var diaMes = diaSemana[0].replace(" ","");
		var diaSemana = diaSemana[1].replace(" ","");

		//
		if(diaSemana !== "Friday")
		{
			alert("ERROR! Ese dia no es valido para la Fecha. Elija un VIERNES!");
			document.getElementById("datepicker").value = '';
		}
		else
		{
			var diaMes = diaMes.split("-");
			var diaRef = diaMes[0];
			diaRef = diaRef.replace(" ","");
			diaRef = eval(diaRef);
			diaRef = diaRef / 7;
			
			//
			if((parseFloat(diaRef) == parseInt(diaRef)) && !isNaN(diaRef))
			{
				diaRef = diaRef;
			} 
			else
			{
				var diaRef = diaRef.toString();
				var diaRef = diaRef.split(".");
				diaRef = eval(diaRef[0]) + 1;
			}

			$('#semMes').attr("value", diaRef);
		}
	}
		
</script>