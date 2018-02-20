<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//consulta lista do menu
$sql_menu = "SELECT * FROM menu_novo WHERE excluido = 'N'";

$query_menu=@mysql_query($sql_menu);


?>
<div class="sidebar col-xs-12 col-sm-3">
	<h2 class="titlemenu"><?php echo _('Menú') ?> <div class="arrow right"></div></h2>
	<div class="main-menu btn-group-vertical">
		<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

			<!-- Menú Inicio      --->
			<div class="panel">
				<div class="panel-heading menu-item" role="tab" id="menuHome">
					<a href="home.php" class="btn btn-raised"><i class="fa fa-home"></i> <?php echo _('Início') ?></a>
				</div>
			</div>
            <?php
				while($res_menu=@mysql_fetch_assoc($query_menu)) 
				{
			?>
			<div class="panel">
                <?php
				if($res_menu['link'] !== "")
				{
					//consulta acesso ao id do menu
					$sql_itens_menu = "SELECT id_menu, acesso FROM acesso_novo WHERE id_nivel = ".$_SESSION['usr_nivel']." AND id_menu = " . $res_menu['id_menu'] . " AND id_login = " . $_SESSION['id_login'];
					$query_itens_menu=@mysql_query($sql_itens_menu);
					$res_itens_menu=@mysql_fetch_assoc($query_itens_menu);
					
					
					//verifica se tem permissao
					if($res_itens_menu['acesso'] == 'S')
					{
											
				?>                
                        <!-- Menú Inicio      --->
                        <div class="panel">
                            <div class="panel-heading menu-item" role="tab" id="menuHome">
                                <a href="<?php echo $res_menu['link'] ?>" class="btn btn-raised"><i class="<?php echo $res_menu['class'] ?>"><?php echo $res_menu['icone'] ?></i><?php echo $res_menu['nome'] ?></a>
                            </div>
                        </div>                
                <?php
					}
				}
				else
				{
					//consulta acesso ao id do menu
					$sql_itens_menu = "SELECT id_menu, acesso FROM acesso_novo WHERE id_nivel = ".$_SESSION['usr_nivel']." AND id_menu = " . $res_menu['id_menu'] . " AND id_login = " . $_SESSION['id_login'];
					$query_itens_menu=@mysql_query($sql_itens_menu);
					$res_itens_menu=@mysql_fetch_assoc($query_itens_menu);
					
					//verifica se tem permissao
					if($res_itens_menu['acesso'] == 'S')
					{
				?>
                    <div class="panel-heading menu-item" role="tab" id="menu<?php echo $res_menu['nome_sistema'] ?>">
                        <a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $res_menu['nome_sistema'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $res_menu['nome_sistema'] ?>"><i class="<?php echo $res_menu['class'] ?>"><?php echo $res_menu['icone'] ?></i><?php echo $res_menu['nome'] ?></a>
                    </div>
                    
                <?php
					}
				}

					$qtd_sub_menu = 0;
					//consulta se tem sub menu para esse item
					$sql_sub_menu ="
						SELECT
							*
						FROM
							menu_itens_novo
						WHERE
							id_menu = " . $res_menu['id_menu'] ." 
						AND
							principal = 1
						AND
							excluido = 'N'
						ORDER BY
							ordem";
					$query_sub_menu=@mysql_query($sql_sub_menu);
					$qtd_sub_menu = mysql_num_rows($query_sub_menu);

					//
					if($qtd_sub_menu > 0)
					{
						?>
						<div id="collapse<?php echo $res_menu['nome_sistema'] ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="menu<?php echo $res_menu['nome_sistema'] ?>">
							<div class="list-group">
                        <?php					
						//mostra submenus
						while($res_sub_menu=@mysql_fetch_assoc($query_sub_menu)) 
						{

							//verifica se tem sub itens
							if($res_sub_menu['link'] == "")
							{
								//consulta acesso ao id do menu
								$sql_itens_sub = "SELECT id_menu, acesso FROM acesso_sub WHERE id_nivel = ".$_SESSION['usr_nivel']." AND id_menu = " . $res_sub_menu['id_item_menu'] . " AND id_login = " . $_SESSION['id_login'];
								$query_itens_sub=@mysql_query($sql_itens_sub);
								$res_itens_sub=@mysql_fetch_assoc($query_itens_sub);
								
								
								//echo $res_itens_sub['acesso'] . "<br />";
								//verifica se tem permissao
								if($res_itens_sub['acesso'] == 'S')
								{									
									echo "<div class='panel-heading menu-item' role='tab' id='menuMaquina'>";							
									echo "<a class='btn btn-raised collapsed' role='button' data-toggle='collapse' data-parent='#menuMaquina' href='#collapseMaquina' aria-expanded='false' aria-controls='collapseMaquina'><i class='".$res_sub_menu['icone']."'></i>".$res_sub_menu['nome']."</a>";
									echo "</div>";	
									echo "<div id='collapseMaquina' class='panel-collapse collapse' role='tabpanel' aria-labelledby='menuMaquina'>";
									echo "<div class='list-group'>";	
									
									//consulta se tem sub menu para esse item
									$sql_itens_menu ="
										SELECT
											*
										FROM
											menu_itens_novo
										WHERE
											id_menu = " . $res_menu['id_menu'] ." 
										AND
											principal = 0
										AND
											excluido = 'N'
										ORDER BY
											ordem";
									$query_itens_menu=@mysql_query($sql_itens_menu);								
									
									//
									while($res_itens_menu=@mysql_fetch_assoc($query_itens_menu)) 
									{
										//consulta acesso ao id do menu
										$sql_itens_sub = "SELECT id_menu, acesso FROM acesso_sub WHERE id_nivel = ".$_SESSION['usr_nivel']." AND id_menu = " . $res_itens_menu['id_item_menu'] . " AND id_login = " . $_SESSION['id_login'];
										$query_itens_sub=@mysql_query($sql_itens_sub);
										$res_itens_sub=@mysql_fetch_assoc($query_itens_sub);
										
										//verifica se tem permissao
										if($res_itens_sub['acesso'] == 'S')
										{
											echo "<a href='".$res_itens_menu['link']."' class='list-group-item'><span>".$res_itens_menu['nome']."</span></a>";																	
										}
									}								
									echo "</div>";
									echo "</div>";
								}
							}
							else
							{
								//consulta acesso ao id do menu
								$sql_itens_sub = "SELECT id_menu, acesso FROM acesso_sub WHERE id_nivel = ".$_SESSION['usr_nivel']." AND id_menu = " . $res_sub_menu['id_item_menu'] . " AND id_login = " . $_SESSION['id_login'];
								$query_itens_sub=@mysql_query($sql_itens_sub);
								$res_itens_sub=@mysql_fetch_assoc($query_itens_sub);
								
								//verifica se tem permissao
								if($res_itens_sub['acesso'] == 'S')
								{								
									echo "<a href='".$res_sub_menu['link']."' class='list-group-item'><span>".$res_sub_menu['nome']."</span></a>";
								}
							}
						}						
						?>
                            </div>
                        </div>                        
                        <?php	
					}
				?>
			</div>            
            <?php
				}			
			?>
		</div>
	</div>
</div>