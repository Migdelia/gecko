$(document).ready(function() {
	// https://github.com/Modernizr/Modernizr/issues/572
	// Similar to http://jsfiddle.net/FWeinb/etnYC/
	$(function(Modernizr) {
		.addTest('cssvhunit')
			var bool;
			Modernizr.testStyles("#modernizr { height: 50vh; }", function(elem, rule) {
				var height = parseInt(window.innerHeight/2,10),
				compStyle = parseInt((window.getComputedStyle ?
					getComputedStyle(elem, null) :
					elem.currentStyle)["height"],10);

				bool= !!(compStyle == height);
			});
			return bool;
			);
	});
	$(function() {
		if (!Modernizr.cssvhunit) {
		  var windowH = $(window).height();
		  $('.vhAttr').css({'height':($(window).height())+'px'});
		}
	});
});