<?php
session_start();

/* verificacao se esta logado*/
if($_SESSION['nome'] == "")
{
	//direcionar para tela de login (qr)
	//include('../functions/validaLogin.php');
}
else
{
	//declara senha QR
	$senhaQR = $_GET['s'];
	$codVer = $_GET['v'];
	
	if($codVer == '')
	{
		$codVer = 0;	
	}
	
	//verifica se ingresso pelo leitor de codigo QR
	if($senhaQR == NULL)
	{
		//include('../functions/validaLogin.php');	
	}
	else
	{
		$arraySenha = (explode("-",$senhaQR));
	}
}


?>

<div class="dashboard">
	<div class="row">
		<!-- Panel dashboard 01 -->
		<div class="col-xs-12">
			<div class="panel validateScreen">
				<div class="panel-heading">
					<i class="fa fa-check-circle-o"></i> <?php echo _('Validación') ?>
				</div>
				<div class="panel-body">
					<div class="validate row">
						<div class="col-xs-12 col-sm-2">
							<a href="#" class="btn red darken-1 btn-md btn-block"><?php echo _('Clave 1') ?></a>
						</div>
						<div class="col-xs-12 col-sm-10">
							<form id="validation" class="val-input">
                            <input type="hidden" id="username" name="username" value="<?php echo $_SESSION['nome'];?>"  />
                        <div class="form-group">
                          <?php
						  	//verifica se venho cod QR
							if($senhaQR == NULL)
							{
								$i = 1;
								while ($i <= 8) {
									echo "<input type='text' id='senha".$i."' name='senha".$i."' maxlength='4' class='form-control'  style='text-transform:uppercase;'>
									";
									$i++;
								}
							}
							else
							{
								//declara contador
								$i = 1;
								while ($i <= 8) {
									$posArray = $i - 1;
									echo "<input type='text' id='senha".$i."' name='senha".$i."' maxlength='4' class='form-control' value=".$arraySenha[$posArray]."  style='text-transform:uppercase;'>
									";
									$i++;
								}							
							}
						  ?>
                        </div>
                     </form>
						</div>
					</div>
					<div class="validate row">
						<div class="col-xs-12 col-sm-2">
							<a href="#" class="btn teal darken-1 btn-md btn-block"><?php echo _('clave 2') ?></a>
						</div>
						<div class="col-xs-12 col-sm-10">
							<form id="validation" class="val-input">
                        <div class="form-group">
                          <?php
						  	
						  	//verifica se venho cod QR
							if($senhaQR == NULL)
							{
								$i = 9;
								while ($i <= 16) {
									echo "<input type='text' id='senha".$i."' name='senha".$i."' maxlength='4' class='form-control'  style='text-transform:uppercase;'>
									";
									$i++;
								}
							}
							else
							{
								//declara contador
								$i = 9;
								while ($i <= 16) {
									$posArray = $i - 1;
									echo "<input type='text' id='senha".$i."' name='senha".$i."' maxlength='4' class='form-control' value=".$arraySenha[$posArray]."  style='text-transform:uppercase;'>
									";
									$i++;
								}							
							}
						  ?>
                        </div>
                     </form>
						</div>
					</div>
					<div class="validate row">
						<div class="col-xs-12 col-sm-2">
							<a href="#" class="btn blue darken-1 btn-md btn-block"><?php echo _('clave 3') ?></a>
						</div>
						<div class="col-xs-12 col-sm-10">
							<form id="validation" class="val-input">
                        <div class="form-group">
                        	
                          <?php
						  	
						  	//verifica se venho cod QR
							if($senhaQR == NULL)
							{
								$i = 17;
								while ($i <= 22) {
									echo "<input type='text' id='senha".$i."' name='senha".$i."' maxlength='4' class='form-control'  style='text-transform:uppercase;'>
									";
									$i++;
								}
							}
							else
							{
								//declara contador
								$i = 17;
								while ($i <= 22) {
									$posArray = $i - 1;
									echo "<input type='text' id='senha".$i."' name='senha".$i."' maxlength='4' class='form-control' value=".$arraySenha[$posArray]."  style='text-transform:uppercase;'>
									";
									$i++;
								}							
							}
						  ?>
                        </div>
                     </form>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-4 col-md-offset-4"><a id="btn_valida" class="btn btn-raised btn-block"><?php echo _('Validar') ?></a></div>
					</div>
					<!-- Sección donde se imprime el mensaje -->
					<div class="row">
						<div id="resultValidacao" class="valueResult  col-xs-12 col-md-4 col-md-offset-4">
							<?php echo _('') ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="carregando" class="loading-message" style="display:none;">
	<center>
		<i class="fa fa-cog fa-spin fa-4x"></i>
		<h5><?php echo _('Cargando Información') ?></h5>
	</center>
</div>

	<script type="text/javascript" charset="utf-8">
		jQuery(document).ready( function( $ ) {

			$('#btn_valida').click(function(){

				
				//aguarde
				$('#carregando').fadeIn("slow");
				
				//declara o nome do usuario
				var nomeUsuario = $('#username').attr("value");

				
				//pegar o id do usuario logado.
				var usuarioId = <?=$_SESSION['id_login']?>;
				var nivel = <?=$_SESSION['usr_nivel']?>;
				
				
				//verifica se é master
				if(nivel !== 1)
				{
					nivel = 0;	
				}
		
								
				//concatena campos para unificar na senha 1
				var key1 = $(senha1).val();

				var key1 = key1 + $(senha2).val();

				var key1 = key1 + $(senha3).val();

				var key1 = key1 + $(senha4).val();

				var key1 = key1 + $(senha5).val();

				var key1 = key1 + $(senha6).val();

				var key1 = key1 + $(senha7).val();

				var key1 = key1 + $(senha8).val();

				var key1 = key1 + $(senha9).val();

				var key1 = key1 + $(senha10).val();

				var key1 = key1 + $(senha11).val();


				//concatena campos para unificar na senha 2

				var key2 = $(senha12).val();

				var key2 = key2 + $(senha13).val();

				var key2 = key2 + $(senha14).val();

				var key2 = key2 + $(senha15).val();

				var key2 = key2 + $(senha16).val();

				var key2 = key2 + $(senha17).val();

				var key2 = key2 + $(senha18).val();

				var key2 = key2 + $(senha19).val();

				var key2 = key2 + $(senha20).val();

				var key2 = key2 + $(senha21).val();

				var key2 = key2 + $(senha22).val();

				
				var key1 = key1.toUpperCase();
				var key2 = key2.toUpperCase();

				
				//versao do coigo
				var codVer = <?=$codVer?>;



				//
				$.ajax(
				{								
					type: "POST", // Defino o método de envio POST / GET
					url: 'functions/validaMaquina.php', // Informo a URL que será pesquisada.
					data: 'senha1='+key1+'&senha2='+key2+'&nameUsuario='+nomeUsuario+'&idUsuario='+usuarioId+'&flagNivel='+nivel+'&codVer='+codVer, //passar id do usuario (session)
					success: function(html)
					{
						//
						var codVal = html;
						
						//aguarde
						$('#carregando').fadeOut("slow");						
					  
					  
					  	//
					  	if(codVal == 0)
						{
							$("#resultValidacao").html("Server Local Error!");
						}
						else if(codVal == 10)
						{
							$("#resultValidacao").html("Server Dongle Error!");	
						}
						else if(codVal == 1)
						{
							$("#resultValidacao").html("Codigo Errado!");	
						}
						else if(codVal == 2)
						{
							$("#resultValidacao").html("Usuario no autorizado!");	
						}
						else if(codVal == 3)
						{
							$("#resultValidacao").html("Error del Sistema!");	
						}
						else
						{
							$("#resultValidacao").html(codVal);
						}				
					}
				});
				
			});
			
			$("input[type='text']").keypress( function() {
				var txtAtual = this.value;
				var qtdCarac = txtAtual.length;
				qtdCarac = qtdCarac + 1;
				if(qtdCarac > 3)
				{
					var objId = this.id;
					var res = objId.substr(5);
					var novoObjId = "senha" + (eval(res) + 1);
					document.getElementById(novoObjId).focus();
				}
			});
		});

    </script>  