<?php
//Fechamento de sessao ao fechar o navegador
session_start();
include('conn/conn.php');
include('functions/validaLogin.php');

//consulta lista do menu
$sql_menu = "SELECT * FROM menu WHERE excluido = 'N'";

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
				?>
                    <!-- Menú Inicio      --->
                    <div class="panel">
                        <div class="panel-heading menu-item" role="tab" id="menuHome">
                            <a href="<?php echo $res_menu['link'] ?>" class="btn btn-raised"><i class="<?php echo $res_menu['class'] ?>"><?php echo $res_menu['icone'] ?></i> <?php echo $res_menu['nome'] ?></a>
                        </div>
                    </div>                
                <?php					
				}
				else
				{
				
				?>
                    <div class="panel-heading menu-item" role="tab" id="menu<?php echo $res_menu['nome_sistema'] ?>">
                        <a class="btn btn-raised collapsed" role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $res_menu['nome_sistema'] ?>" aria-expanded="false" aria-controls="collapse<?php echo $res_menu['nome_sistema'] ?>"><i class="<?php echo $res_menu['class'] ?>"><?php echo $res_menu['icone'] ?></i> <?php echo $res_menu['nome'] ?></a>
                    </div>
                    
                <?php
				}

					$qtd_sub_menu = 0;
					//consulta se tem sub menu para esse item
					$sql_sub_menu ="
						SELECT
							*
						FROM
							menu_itens
						WHERE
							id_menu = " . $res_menu['id_menu'] ." 
						AND
							principal = 1
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
								echo "<div class='panel-heading menu-item' role='tab' id='menuMaquina'>";							
								echo "<a class='btn btn-raised collapsed' role='button' data-toggle='collapse' data-parent='#menuMaquina' href='#collapseMaquina' aria-expanded='false' aria-controls='collapseMaquina'><i class='".$res_sub_menu['icone']."'></i> ".$res_sub_menu['nome']."</a>";
								echo "</div>";	
								echo "<div id='collapseMaquina' class='panel-collapse collapse' role='tabpanel' aria-labelledby='menuMaquina'>";
								echo "<div class='list-group'>";	
								
								//consulta se tem sub menu para esse item
								$sql_itens_menu ="
									SELECT
										*
									FROM
										menu_itens
									WHERE
										id_menu = " . $res_menu['id_menu'] ." 
									AND
										principal = 0
									ORDER BY
										ordem";
								$query_itens_menu=@mysql_query($sql_itens_menu);								
								
								//
								while($res_itens_menu=@mysql_fetch_assoc($query_itens_menu)) 
								{
									echo "<a href='".$res_itens_menu['link']."' class='list-group-item'><span>".$res_itens_menu['nome']."</span></a>";									
								}								
								echo "</div>";
								echo "</div>";	
							}
							else
							{
								echo "<a href='".$res_sub_menu['link']."' class='list-group-item'><span>".$res_sub_menu['nome']."</span></a>";									
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