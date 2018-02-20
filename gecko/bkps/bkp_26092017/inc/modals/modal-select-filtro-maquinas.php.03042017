<?php $modal_item = "Lectura" // ingresar la palabra clave de cada modal ?>
<div id="select-periodo" class="modal fade" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h5><?php echo _('Elegir Local ') . $modal_item ?></h5>
      </div>
      <div class="modal-body">

        <form id="formInfoLeitura" class="form-horizontal" method="post" action="detalle-local.php">
          <div class="row">
          	<div class="col-xs-12 col-md-6">
                <div class="row">              
                      <label for="input_add_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Local') ?></label>    
                      <div class="form-group is-empty ui-widget">
                      
                      	<?php
						
							//consulta lista de locais
							$sql_locais = "SELECT id_local, nome FROM `local` WHERE excluido = 'N' ORDER BY nome";
							$query_locais=@mysql_query($sql_locais);
						?>
                      
                      
                        <label for="tags"></label>
                        <select id="input_local" name="input_local" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                        <?php
							echo "<option value=''>&nbsp;</option>";
						
                            //
                            while($res_locais=@mysql_fetch_assoc($query_locais)) 
                            {
                                echo "<option value='".$res_locais['id_local']."'>".$res_locais['nome']."</option>";
                            }
                        ?>                 
        
                        </select>
                        <span class="material-input"></span>
                      </div> 
                      
                      <label for="input_add_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Gabinete') ?></label>    
                      <div class="form-group is-empty ui-widget">
                      
                      
                      	<?php
							//consulta lista de gabinetes
							$sql_gab = "SELECT id_tipo_maquina, descricao FROM tipo_maquina ORDER BY descricao";
							$query_gab=@mysql_query($sql_gab);							
						?>                      
                      
                        <label for="tags"></label>
                        <select id="input_gabinete" name="input_gabinete" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                        <?php
						
							echo "<option value=''>&nbsp;</option>";
                            //
                            while($res_gab=@mysql_fetch_assoc($query_gab)) 
                            {
                                echo "<option value='".$res_gab['id_tipo_maquina']."'>".$res_gab['descricao']."</option>";
                            }
                        ?>                 
        
                        </select>
                        <span class="material-input"></span>
                      </div>                       
                      
                </div>          
            </div>
          	<div class="col-xs-12 col-md-6">
                <div class="row">
                      <label for="input_add_cidade<?php echo $modal_item ?>" class="control-label"><?php echo _('Operador') ?></label>    
                      <div class="form-group is-empty ui-widget">
                      
                      	<?php
						
							//consulta lista de operadores
							$sql_ope = "SELECT id_login, nome FROM logins ORDER BY nome";
							$query_ope=@mysql_query($sql_ope);										
						?>                      
                      
                      
                        <label for="tags"></label>
                        <select id="input_operador" name="input_operador" type="text" class="form-control col-xs-6" placeholder="Búsqueda">
                        <?php
						
							echo "<option value=''>&nbsp;</option>";
                            //
                            while($res_ope=@mysql_fetch_assoc($query_ope)) 
                            {
                                echo "<option value='".$res_ope['id_login']."'>".$res_ope['nome']."</option>";
                            }
                        ?>                 
        
                        </select>
                        <span class="material-input"></span>
                      </div> 
                </div>             
            </div>
            <div class="col-xs-12">
            	<div class="row form-group">
             		<a id="btnRecarregar" type="submit" class="btn btn-sm btn-raised col-xs-12 col-md-5 right"><?php echo _('Siguiente') ?></a>
           		</div>
            </div>                          
        </div>      
      </form>
    </div>
  </div>
</div>
</div>

<script type="text/javascript">
    //
	$(document).ready(function() {
        $('select').select2();
    });	

	//
	$(function() {
		$("#dataInicio").datepicker({dateFormat: 'dd-mm-yy'});
		$("#dataFinal").datepicker({dateFormat: 'dd-mm-yy'});		
	});		
	
	//
	$("#btnRecarregar").click( function (){
		//pegar data inicio 
		local = $("#input_local").val();
		gabinete = $("#input_gabinete").val();
		operador = $("#input_operador").val();


		//
		location="info-maquinas.php?ope="+operador+"&loc="+local+"&gab="+gabinete;
	});

	
</script>