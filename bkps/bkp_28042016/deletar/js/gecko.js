$(document).ready(function() {
	// iniciar materialize-bootstrap
	$.material.init();

	// Para que funcione datatable
	$('#datatable').DataTable({
		"iDisplayLength": 5
	});



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

/*$(document).ready( function () {
    $('#datatable').DataTable();
} );*/