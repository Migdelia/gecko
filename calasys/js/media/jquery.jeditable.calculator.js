/*
 * Jeditable - with date-picker
 *
 */
$.editable.addInputType('calculator', {
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
		var oCalculator = $(this).find('input').calculator( {
			showOn			:	'both',
			buttonImageOnly	:	true,
			buttonImage		:	'img/calculator.png'
		})
		oCalculator.bind('click', function() {
			//$(this).attr('readonly', true);
			$(this).calculator('show');
			return false;
		}).bind('dateSelected', function(e, selectedDate, $td) {
			$(form).submit();
		});
	}
});