<div id="forgot-modal" class="modal fade" tabindex="-1" style="display: none;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="" method="post">
            <div class="valign-wrapper">
              <div class="col-xs-12 col-md-4 col-md-offset-4 logo-login valign">
                <img src="img/logo-login.png" alt="gecko" class="img-responsive">
              </div>
            </div>
            <div class="form-group">
              <label for="inputEmail" class="col-md-2 control-label"><?php echo _('Insira seu e-mail, para enviar uma senha nova.') ?></label>
              <div class="col-xs-12">
                <input type="email" class="form-control" id="inputEmail" placeholder="<?php echo _('E-mail') ?>" value="">
              </div>
            </div>
            <div class="form-group">
              <div class="col-xs-12">
                <button type="button" id="btnEnviaSenha" class="btn btn-lg btn-raised right"><?php echo _('Trocar Senha') ?></button>
              </div>
            </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" charset="utf-8">
	//envia senha para o email
	$('#btnEnviaSenha').click( function() {
		$.ajax(
		{
			type: "POST", // Defino o método de envio POST / GET
			url: 'functions/enviaSenha.php', // Informo a URL que será pesquisada.
			data: '',
			success: function(html)
			{
				if(html == 0)//usuario com problema
				{
					alert("erro");
				}
				else if(html == 1)//senha com problema
				{
					alert("Funfo! sair do modal");	
				}						
			}
		});
	});

</script>