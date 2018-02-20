<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');


?>

<!DOCTYPE html>
<html>
  <head>
    <title>Gecko</title>
    <?php include("inc/headings.php"); // se llaman todos los metatags, css y librerías js ?>
  </head>

  <body class="body innerpages">
    <?php include("inc/commons.php"); // se declarán los directorios usados en los archivos y el lenguaje utilizado en la aplicación con su archivo .po  ?>
    <?php $file_name = "niveles" // ingresar la palabra clave de cada modal ?>

    <div class="container-fluid innpage-<?php echo $filenameID; ?>">
      <div class="row">
        <?php include("inc/navbar.php"); // primera sección de contenido, barra de navegación ?>
      </div>
      <div class="row">
        <?php include("inc/sidebar.php"); // segunda sección de contenido, el menú lateral ?>
        <div class="inner-content col-xs-12 col-sm-9">
          <div class="lectura">
            <div class="row">
              <div class="col-xs-12 col-lg-6">
                <h3 class="main-title">
                  <span class="fa-stack fa-md">
                    <i class="fa fa-circle fa-stack-2x"></i>
                    <i class="fa fa-list-ul fa-stack-1x fa-inverse"></i>
                  </span>
                  <?php echo _('Niveles') ?>
                </h3>
              </div>
              <div class="col-xs-12 col-lg-6">
                <?php //include("inc/buttons.php"); // btns paneles ?>
                <?php include("inc/modals/modal-add-" . $file_name . ".php"); // modal para agregar contenido ?>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-12">
                <div class="panel">
                  <div class="panel-heading">
                    <div class="input-wrap">
                      <div class="btn-group-horizontal left">
                      	
                        <?php 
							//consulta niveis
							$sql_nv = "
								SELECT
									*
								FROM
									nivel
								WHERE
									excluido = 'N'
								ORDER BY
									nivel.id_nivel
								";
							$query_nv=@mysql_query($sql_nv);
							
							//mostra todos os niveis em botoes
							while($res_nv=@mysql_fetch_assoc($query_nv)) 
							{
								//
								if($res_nv['id_nivel'] == 1)
								{
									echo "<a id='btn_" . $res_nv['id_nivel'] . "' class='btn btn-raised active' onClick='mostraUsuarios(this);'>" . $res_nv['descricao'] . "</a>\n";									
								}
								else
								{
									echo "<a id='btn_" . $res_nv['id_nivel'] . "' class='btn btn-raised' onClick='mostraUsuarios(this);'>" . $res_nv['descricao'] . "</a>\n";										
								}
							}											
						?>
                        <!---
                        <a id="btn_0" class="btn btn-raised active" onClick='mostraUsuarios(this);'><?php echo _('Todos') ?></a>
                        

                        <a href="#" class="btn btn-raised active"><?php echo _('Master') ?></a>
                        <a href="#" class="btn btn-raised"><?php echo _('Operador') ?></a>
                        <a href="#" class="btn btn-raised"><?php echo _('Administrador') ?></a>
                        <a href="#" class="btn btn-raised"><?php echo _('Gerente') ?></a>
                        <a href="#" class="btn btn-raised"><?php echo _('Todos') ?></a>-->
                      </div>
                      <!-- input formulario de busqueda 
                      <form id="table-1" class="white-form right">
                        <div class="form-group">
                          <input type="text" class="form-control col-md-8" placeholder="<?php echo _('Búsqueda') ?>">
                        </div>
                      </form>-->
                    </div>
                  </div>
                  <div class="panel-body">
                    <div class="col-xs-12">

                    
                    <?php
					
					$query_nv=@mysql_query($sql_nv);
					//mostra todos os niveis em botoes
					while($res_nv=@mysql_fetch_assoc($query_nv)) 
					{
						if($res_nv['id_nivel'] == 1)
						{
							echo "<div id='nivel_".$res_nv['id_nivel']."' class='table-responsive' >";
						}
						else
						{
							echo "<div id='nivel_".$res_nv['id_nivel']."' class='table-responsive' style='display:none;' >";
						}
					?>
                    		
                            
                      
                        <table class="table table-striped table-hover">
                          <thead>
                            <tr>
                              <th class="left-align">
                                <a ><?php echo _('Nome') ?></a>
                              </th>
                              <th class="sort-none" colspan="3">
                              </th>
                              <th class="center-align">
                                <a ><?php echo _('Ativar') ?></a>
                              </th>
                            </tr>
                          </thead>
                          <tbody>

						

							<?php
							

                            //consulta usuarios
                            $sql_usu = "
                                SELECT
									id_login,
                                    nome,
									id_nivel
                                FROM
                                    logins
                                WHERE
                                    excluido = 'N'
								AND
									id_nivel = ".$res_nv['id_nivel']."
                                ORDER BY
                                    logins.nome
                                ";
                            $query_usu=@mysql_query($sql_usu);
                            
                            //mostra todos os niveis em botoes
							$arrayNome = array();
							$arrayId = array();
							$arrayNivel = array();
                            while($res_usu=@mysql_fetch_assoc($query_usu)) 
                            {
                                $arrayNome[] = $res_usu['nome'];
								$arrayId[] = $res_usu['id_login'];
								$arrayNivel[] = $res_usu['id_nivel'];
                            }
														
                            //consulta menu
                            $sql_menu = "
									SELECT
										id_menu,
										id_menu as menu_principal,
										nome,
										icone,
										class,
										'P' as tipo
									FROM
										menu_novo
									WHERE
										excluido = 'N'
								UNION
									SELECT
										id_item_menu as id_menu,
										id_menu AS menu_principal,
										nome,
										icone,
										icone as class,
										'S' as tipo
									FROM
										menu_itens_novo
									WHERE
										excluido = 'N'
								ORDER BY
									menu_principal,
									id_menu
                                ";
                            $query_menu=@mysql_query($sql_menu);
							
							
                            //mostra todos os niveis em botoes
							$arrayMenu = array();
							$arrayTipoMenu = array();
							$arrayMenuId = array();
                            while($res_menu=@mysql_fetch_assoc($query_menu)) 
                            {
                                $arrayMenu[] = $res_menu['nome'];
								$arrayTipoMenu[] = $res_menu['tipo'];
								$arrayMenuId[] = $res_menu['id_menu'];
								$arrayMenuIcone[] = $res_menu['class'];
                            }							
							
                            
                            //monta tabela
							//verifica quantos usuarios
							$resultUsu = count($arrayId);
							$resultItens = count($arrayMenuId);

							//verifica o tamanho do looping
							if($resultUsu > $resultItens)
							{
								$looping = $resultUsu;
							}
							else
							{
								$looping = $resultItens;
							}						
							
							
							
							//verificar aqui * erico
							
							$i = 0;
                            while($i<$looping) 
                            {
                                echo "<tr>";
								echo "<td id='li_".$arrayId[$i]."_".$arrayNivel[$i]."' class='left-align borded-row' onClick='mostraFuncUsu(this);' style='cursor:pointer'><a class='select-user'>".$arrayNome[$i]."</a></td>";
								
								if($arrayMenu[$i] == "")
								{
									echo "<td class='left-align access-row' colspan='3'>&nbsp;</td>";	
									echo "<td class='center-align'>";
									echo "&nbsp;";
									echo "</td>";									
								}
								else
								{
									echo "<td class='left-align access-row' colspan='3'>";
									echo "<i class='".$arrayMenuIcone[$i]."'></i>";
									
									//verifica se é menu principal
									if($arrayTipoMenu[$i] == 'P')
									{
										echo "<font size='3'><strong>".$arrayMenu[$i]."</strong></font>";
									}
									else
									{	
										echo $arrayMenu[$i];										
									}

									
									
									
									echo "</td>";									
									echo "<td class='center-align'>";
									echo "<div class='togglebutton'>";
									echo "<label>";

									
									echo "<input type='checkbox' id='check_".$res_nv['id_nivel']."_".$arrayMenuId[$i]."' >";		
									
									
									echo "</label>";
									echo "</div>";
									echo "</td>";
								}				
								echo "</tr>";
								$i++;
                            }								
							
																	
                            ?>
                    
                          </tbody>
                        </table>
                      </div>
                      <input type="hidden" id="ultNvSelc" name="ultNvSelc" value="1">
                      <input type="hidden" id="ultUsuSelc" name="ultNvSelc" value="1">
                      
				<?php
                    }
                ?>
  
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
<script language="javascript">
	function mostraUsuarios(obj)
	{
		var ultObjSelct = $('#ultNvSelc').attr("value");
		var idNivel = obj.id.split("_");
		var idNivel = idNivel[1];

		
		//verifica se o botao clicado nao eh o que esta selecionado
		if(idNivel == ultObjSelct)
		{
			return false;	
		}
		else
		{
			$('#nivel_'+ultObjSelct).slideUp("slow");
			$('#nivel_'+idNivel).slideDown("slow");
			$('#ultNvSelc').attr("value", idNivel);
			
			//tira a class botao que estava selecionado
			$("#btn_"+ultObjSelct).removeClass("btn btn-raised active");
			$("#btn_"+ultObjSelct).addClass("btn btn-raised");
			
			
			$("#btn_"+idNivel).removeClass("btn btn-raised");
			$("#btn_"+idNivel).addClass("btn btn-raised active");			

		}
		
	}
	
	//
	function mostraFuncUsu(obj)
	{
		//
		var ultUsuSelct = $('#ultUsuSelc').attr("value");
		
		
		$("#"+obj.id).removeClass('left-align borded-row');
		$("#"+obj.id).addClass('left-align borded-row active');

	/*
		//
		if(ultUsuSelct !== 1)
		{
			$("#"+ultUsuSelct).toggleClass('left-align borded-row active left-align borded-row');
			$("#"+obj.id).toggleClass('left-align borded-row left-align borded-row active');
		}
		else
		{
			$("#"+obj.id).toggleClass('left-align borded-row active');
		}
		*/
		//
		$('#ultUsuSelc').attr("value", obj.id);	
		
		

		//consulta os niveis desse usuario
		var idUsu = obj.id.split("_");
		idUsu = idUsu[1];
		
		var idNivel = obj.id.split("_");
		idNivel = idNivel[2];		
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/consulta_acessos_usuario.php', // Informo a URL que será pesquisada.
			data: 'id='+idUsu,
			success: function(html)
			{
				arrayDados = html.split(",");
				
				//efetuar looping na array arrayDados
				var i = 0;
				while (i < (arrayDados.length - 1))  // mudar valor dinamico
				{
					arrayItem = arrayDados[i].split("-");
					idMenu = arrayItem[0];
					acesso = arrayItem[1];	
					
					//alert(idMenu + " = " + acesso);	
								
					if(acesso == "S")
					{
						$("#check_"+idNivel+"_"+idMenu).prop("checked", "checked");
					}
					else
					{
						$("#check_"+idNivel+"_"+idMenu).prop("checked", "");	
					}
					i++;
				}
				
			}
		});
		
	}
	
	//
	$('input[type="checkbox"]').click(function () {
		var status = $( this ).prop( "checked" );
		if(status == true)
		{
			status = "S";	
		}
		else
		{
			status = "N";
		}
		//
		var ultUsuSelct = $('#ultUsuSelc').attr("value");
		var idUsu = ultUsuSelct.split("_");
		idUsu = idUsu[1];
		
		
		var objId = this.id;
		var id_nivel = objId.split("_");
		id_nivel = id_nivel[2];

		
		//
		$.ajax(
		{								
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/altera_acessos_usuario.php', // Informo a URL que será pesquisada.
			data: 'id='+idUsu+'&nivel='+id_nivel+'&status='+status,
			//data: 'id='+id+'&flag=1&pos='+obj.title,
			success: function(html)
			{
				if(html == 0)
				{
					alert("Server Error!");
				}
			}
		});
	});	
	
</script>