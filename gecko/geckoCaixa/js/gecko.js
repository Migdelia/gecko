$(document).ready(function() {
	// iniciar materialize-bootstrap
	$.material.init();

	// Para que funcione datatable
	$('#datatable').DataTable({
		"iDisplayLength": 15,
		"dom": '<"top"i<"clear">>rt<"bottom"i<"clear">>',
		"language": {
			"sProcessing":     "Procesando...",
			"sLengthMenu":     "Mostrar _MENU_ registros",
			"sZeroRecords":    "No se encontraron resultados",
			"sEmptyTable":     "Ningún dato disponible en esta tabla",
			"sInfo":           "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
			"sInfoEmpty":      "Mostrando registros del 0 al 0 de un total de 0 registros",
			"sInfoFiltered":   "(filtrado de un total de _MAX_ registros)",
			"sInfoPostFix":    "",
			"sSearch":         "Buscar:",
			"sUrl":            "",
			"sInfoThousands":  ",",
			"sLoadingRecords": "Cargando...",
			"oPaginate": {
				"sFirst":    "Primero",
				"sLast":     "Último",
				"sNext":     "Siguiente",
				"sPrevious": "Anterior"
			},
			"oAria": {
				"sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
				"sSortDescending": ": Activar para ordenar la columna de manera descendente"
			}
		}
	});

	$('#datatable1').DataTable({
		"iDisplayLength": 15,
		"dom": '<"top"i<"clear">>rt<"bottom"i<"clear">>',
		"language" : {
			"sEmptyTable": "Nenhum registro encontrado",
			"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
			"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
			"sInfoFiltered": "(Filtrados de _MAX_ registros)",
			"sInfoPostFix": "",
			"sInfoThousands": ".",
			"sLengthMenu": "_MENU_ resultados por página",
			"sLoadingRecords": "Carregando...",
			"sProcessing": "Processando...",
			"sZeroRecords": "Nenhum registro encontrado",
			"sSearch": "Pesquisar",
			"oPaginate": {
				"sNext": "Próximo",
				"sPrevious": "Anterior",
				"sFirst": "Primeiro",
				"sLast": "Último"
			},
			"oAria": {
				"sSortAscending": ": Ordenar colunas de forma ascendente",
				"sSortDescending": ": Ordenar colunas de forma descendente"
			}
		}
	});

	oTable = $('#datatable').DataTable();
	$('#myInputSearchField').keyup(function(){
		oTable.search($(this).val()).draw() ;
	});

	/*$("div.top").html('<a href="#" class="btn btn-default" role="button" style="color: white">Cargar Todos</a>');*/


	// ISOTOPE


	var $grid = $('.grid-1').isotope({
		itemSelector: '.grid-item',
		layoutMode: 'cellsByRow',
		// 	filter: '.selector',
		// layout mode options
		cellsByRow: {
	    	columnWidth: 110,
		    rowHeight: 130
	  	},
	});

	// var $grid = $('.grid-1').isotope({
	// 	itemSelector: '.grid-item',
	// 	layoutMode: 'cellsByRow',
	// 	// 	filter: '.selector',
	// 	// layout mode options
	// 	cellsByRow: {
	//     	columnWidth: 100,
	// 	    rowHeight: 130
	//   	},
	// });

	$('.filter-button-group').on( 'click', 'button', function() {
  		var filterValue = $(this).attr('data-filter');
  		$grid.isotope({ filter: filterValue });
	});
	// filter .metal items
	// $grid.isotope({ filter: '.maquina1' });
	//
	// // filter .alkali OR .alkaline-earth items
	// $grid.isotope({ filter: '.maquina2' });
	//
	// // filter .metal AND .transition items
	// $grid.isotope({ filter: '.maquina3' });
	//
	// // show all items
	// $grid.isotope({ filter: '.maquina4' });
	// $grid.isotope({ filter: '*' });
	//
	// $grid.isotope({
	//   // filter element with numbers greater than 50
	//   filter: function() {
	//     // _this_ is the item element. Get text of element's .number
	//     var number = $(this).find('.number').text();
	//     // return true to show, false to hide
	//     return parseInt( number, 10 ) > 50;
	//   }
	// })


	// $('.filter-button-group').on( 'click', 'button', function() {
	// 	var filterValue = $(this).attr('data-filter');
	// 	console.log(filterValue);
	// 	$grid.isotope({ filter: filterValue });
	// });

	$('.button-group').each( function( i, buttonGroup ) {
		var $buttonGroup = $( buttonGroup );
		$buttonGroup.on( 'click', 'button', function() {
			$buttonGroup.find('.is-checked').removeClass('is-checked');
			$( this ).addClass('is-checked');
		});
	});







	// Input Autocompletable
	var availableTags = [
	"Antofagasta",
	"Angol",
	"Arica",
	"Atacama",
	"Aysén",
	"Buin",
	"Calama",
	"Colina",
	"Copiapó",
	"Lampa",
	"Linares",
	"Los Andes",
	"Osorno",
	"Peñaflor",
	"Punta Arenas",
	"Rengo",
	"San Carlos",
	"San Felipe",
	"San Fernando",
	"Talagante",
	"Valdivia",
	"Villarrica"
	];

	$("#myInputSearchField").autocomplete({
		source: availableTags
	});

	/*$grid.isotope({ filter: '.maquina1' });

	// filter .alkali OR .alkaline-earth items
	$grid.isotope({ filter: '.maquina2, .maquina3' });

	// filter .metal AND .transition items
	$grid.isotope({ filter: '.maquina4.maquina5' });

	// show all items
	$grid.isotope({ filter: '*' });


	var $grid = $('.grid').isotope({
  // options
	});


	// filter items on button click
	$('.filter-button-group').on( 'click', 'button', function() {
		var filterValue = $(this).attr('data-filter');
		$grid.isotope({ filter: filterValue });
	});*/





	// quitar margin-bottom a los rows del login
	if($('.login-component').length){
		$('.row').attr('style', 'margin-bottom: 0px;');
	}

	$(function() {
		var currentparent = $('.sidebar .menu-item .btn[href^="' + window.location.pathname.split( '/' )[3] + '"]')
		var currentchild = $('.sidebar .list-group .list-group-item[href^="' + window.location.pathname.split( '/' )[3] + '"]');
		// evento para menú sidebar padre
		currentparent.addClass('active');
		// evento para menu sidebar hijos
		currentchild.addClass('active');
		if($('.sidebar .list-group-item').hasClass('active')) {
			currentchild.parentsUntil('panel-collapse').addClass('in');
			currentchild.parentsUntil('panel').addClass('current');
		}
	});

	$( '.sidebar .menu-item .btn' ).click(function(){
		if($('.sidebar .menu-item .btn.selected').length){
			$('.sidebar .menu-item .btn').removeClass('selected');
		}
		$(this).toggleClass('selected');
	});

	$( '.innerpages .sidebar .titlemenu .arrow' ).click(function(){
		$('.innerpages .sidebar').toggleClass('closed');
		$('.innerpages .sidebar .arrow').toggleClass('left');
		$('.innerpages .sidebar .arrow').toggleClass('right');
		$('.inner-content').toggleClass('wider');
	});

	//cambiar clase del usuario en niveles
	$( '.table > tbody > tr .borded-row .select-user' ).click(function(){
		if($('.table > tbody > tr .borded-row.active').length){
			$('.table > tbody > tr .borded-row').removeClass('active');
		}
		$(this).parent().addClass('active');
	});

	//ajustar el alto de los div
	var currentTallest = 0,
	currentRowStart = 0,
	rowDivs = new Array(),
	$el,
	topPosition = 0;

	$('.dashboard .panel').each(function() {
		$el = $(this);
		topPosition = $el.position().top;
		if (currentRowStart != topPosition) {
		// we just came to a new row.  Set all the heights on the completed row
		for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
		}
		// set the variables for the new row
		rowDivs.length = 0; // empty the array
		currentRowStart = topPosition;
		currentTallest = $el.height();
		rowDivs.push($el);
	} else {
			// another div on the current row.  Add it to the list and check if it's taller
			rowDivs.push($el);
			currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
		}
		// do the last row
		for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
			rowDivs[currentDiv].height(currentTallest);
		}
	});

});

// Locales
$(document).on('click', 'table.locales tr td', function(event) {
	event.preventDefault();
	$('table.maquinas').show();
})
// Locales maquinas
$(document).on('click', 'table.maquinas tr td', function(event) {
	event.preventDefault();
	$('.info-maquina').show();
})
