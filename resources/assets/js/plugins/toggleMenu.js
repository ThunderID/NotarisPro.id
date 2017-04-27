// adapter
var toggle_on = $('.btn-toggle-menu-on');
var toggle_off = $('.btn-toggle-menu-off');
var menu = $('.target-menu');
var panel = $('.target-panel');

// functions
toggle_on.on( "click", function() {
	menu.slideDown();
	panel.hide();
});

toggle_off.on( "click", function() {
	panel.show();
	menu.slideUp();
});	


// custom
$( window ).resize(function() {
	if ($(window).width() > 768) {
		menu.show();
	}else{
		menu.hide();
		panel.show();
	}
});