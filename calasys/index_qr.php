<?php

	//declara senha QR
	$senhaQR = $_GET['s'];
	$codVer = $_GET['v'];	


?>


<!DOCTYPE html>
<html >
  <head>
    <meta charset="UTF-8">
    <title>Login Form</title>
    
    
    
    
        <style>
					
			* {
			box-sizing: border-box;
			}
			
			*:focus {
				outline: none;
			}
			body {
			font-family: Arial;
			background-color: #ff5e00;
			padding: 50px;
			}
			.login {
			margin: 20px auto;
			width: 300px;
			}
			.login-screen {
			background-color: #FFF;
			padding: 20px;
			border-radius: 5px
			}
			
			.app-title {
			text-align: center;
			color: #777;
			}
			
			.login-form {
			text-align: center;
			}
			.control-group {
			margin-bottom: 10px;
			}
			
			input {
			text-align: center;
			background-color: #ECF0F1;
			border: 2px solid transparent;
			border-radius: 3px;
			font-size: 16px;
			font-weight: 200;
			padding: 10px 0;
			width: 250px;
			transition: border .5s;
			}
			
			input:focus {
			border: 2px solid #3498DB;
			box-shadow: none;
			}
			
			.btn {
			  border: 2px solid transparent;
			  background: #090;
			  color: #ffffff;
			  font-size: 16px;
			  line-height: 25px;
			  padding: 10px 0;
			  text-decoration: none;
			  text-shadow: none;
			  border-radius: 3px;
			  box-shadow: none;
			  transition: 0.25s;
			  display: block;
			  width: 250px;
			  margin: 0 auto;
			}
			
			.btn:hover {
			  background-color: #0C0;	
			}
			
			.login-link {
			  font-size: 12px;
			  color: #444;
			  display: block;
				margin-top: 12px;
			}

		
        </style>
        
	<script type="text/javascript" charset="UTF-8">
    
		function enviaForm()
		{
			document.getElementById("form1").submit();	
		}

    </script>

    
    
    
  </head>

  <body>

	<div class="login">
		<div class="login-screen">
			<div class="app-title">
				<h1>Login</h1>
			</div>

			<div class="login-form">
				<div class="control-group">
                <form id="form1" name="form1" method="post" action="verifica_qr.php?s=<?php echo $senhaQR; ?>&v=<?php echo $codVer; ?>">
                    <input type="text" class="login-field" value="" placeholder="login" id="login" name="login">
                    <label class="login-field-icon fui-user" for="login"></label>
                    </div>
    
                    <div class="control-group">
                    <input type="password" class="login-field" value="" placeholder="contraseña" id="senha" name="senha">
                    <label class="login-field-icon fui-lock" for="login-pass"></label>
                    </div>
    
                    <a class="btn btn-primary btn-large btn-block" href="#" id="entrar" onClick="enviaForm();">Entrar</a>
                </form>
			</div>
		</div>
	</div>

    
  </body>
</html>
