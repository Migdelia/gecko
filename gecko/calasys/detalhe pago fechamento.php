<?php 
		
		//inseri forma de pagamento 
		$sql_pago = "INSERT INTO 
							pago_fechamento(
											`id_fechamento`,
											`valor_din`,
											`valor_dep`,
											`valor_cheq`
											) 
											VALUES 
											(
											'".$idf."',
											'".$_POST['tot_din']."',
											'".$_POST['tot_dep']."',
											'".$_POST['tot_cheq']."'																							
											)";
		@mysql_query($sql_pago);
		
		
		//efetuar um loop de 5x por forma de pago, verificando se tem dados ou nao
		$contador = 6;
		$i = 1;
		
		//dados de forma de pagamentos
		while($contador > $i)
		{
			//
			$obj = 'din_'.$i;
			$obs = 'obs_'.$i;
			$vl_din = $_POST[$obj];
			$obs_din = $_POST[$obs];	
			
			
			if($vl_din != 0)
			{
				//inseri detalhe do pagamento 
				$sql_det_pago = "INSERT INTO 
									detalhe_pago(
													`id_fechamento`,
													`tipo_pago`,
													`detalhe`,
													`valor_pago`
													) 
													VALUES 
													(
													'".$idf."',
													'din',
													'".$obs_din."',
													'".$vl_din."'																						
													)";
				@mysql_query($sql_det_pago);			
			}

			
			//cadastra detalhe de deposito.
			$obj = 'dep_'.$i;
			$obs = 'num_comp_'.$i;
			$vl_dep = $_POST[$obj];
			$num_comp = $_POST[$obs];	
			
			
			if($vl_dep != 0)
			{
				//inseri detalhe do pagamento 
				$sql_det_pago = "INSERT INTO 
									detalhe_pago(
													`id_fechamento`,
													`tipo_pago`,
													`detalhe`,
													`valor_pago`
													) 
													VALUES 
													(
													'".$idf."',
													'dep',
													'".$num_comp."',
													'".$vl_dep."'																						
													)";
				@mysql_query($sql_det_pago);			
			}


			
			//cadastra detalhe de cheque.
			$obj = 'cheq_'.$i;
			$obs = 'num_cheq_'.$i;
			$vl_cheq = $_POST[$obj];
			$num_cheq = $_POST[$obs];	
			
			
			if($vl_cheq != 0)
			{
				//inseri detalhe do pagamento 
				$sql_det_pago = "INSERT INTO 
									detalhe_pago(
													`id_fechamento`,
													`tipo_pago`,
													`detalhe`,
													`valor_pago`
													) 
													VALUES 
													(
													'".$idf."',
													'cheq',
													'".$num_cheq."',
													'".$vl_cheq."'																						
													)";
				@mysql_query($sql_det_pago);			
			}							
			$i++;
		}	
		
		
?>