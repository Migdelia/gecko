$(function(){

	carregar(0, 2, 'load.php');

	$("a.carregar-mais").click(function(evento){
		evento.preventDefault();
		var init = $("ol li").length;

		carregar(init, 2, 'load.php');
	});

	function carregar(init, max, url){
		var dados = { init : init, max : max };

		$("ol").append('<li>Carregando...</li>');

		$.post(url, dados, function (data) {

			$("ol li").last().remove();

			for(i = 0; i < data.dados.length; i++){
				$("ol").append('<li>'+data.dados[i].nome+'</li>');
			}

			var conta = $("ol li").length;

			if(conta == data.totalResults) {
				$("a.carregar-mais").hide();
			}

		}, "json");
	}

});