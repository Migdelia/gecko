/*
 * Jeditable - with date-picker
 *
 */
$.editable.addInputType('datepicker', {
	element : function(settings, original) {
		var input = $('<input>');
		if (settings.width  != 'none') {
			input.width(settings.width);
		}
		if (settings.height != 'none') {
			input.height(settings.height);
		}
		input.attr('autocomplete','off');
		$(this).append(input);
		return(input);
	},
	plugin : function(settings, original) {
		/* Workaround for missing parentNode in IE */
		var form = this;
		settings.onblur = 'ignore';
		var oCalendario = $(this).find('input').datepicker( {
			dateFormat		:	'dd/mm/yy',
			dayNames		:	['Domingo','Segunda','Ter�a','Quarta','Quinta','Sexta','S�bado','Domingo'],
			dayNamesMin		:	['D','S','T','Q','Q','S','S','D'],
			dayNamesShort	:	['Dom','Seg','Ter','Qua','Qui','Sex','S�b','Dom'],
			monthNames		:	['Janeiro','Fevereiro','Mar�o','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
			monthNamesShort	:	['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
			nextText		:	'Pr�ximo',  
			prevText		:	'Anterior'
		})
		oCalendario.bind('click', function() {
			//$(this).attr('readonly', true);
			$(this).datepicker('show');
			return false;
		}).bind('dateSelected', function(e, selectedDate, $td) {
			$(form).submit();
		});
	}
});