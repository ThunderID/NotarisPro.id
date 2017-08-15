/*
	=====================================================================
	loader
	=====================================================================
	Version		: 0.1
	Author 		: Budi
	Requirement : jQuery

	Notes:
	1. to use this plugin, call loader.show(target) API
	2. target -> where the loader should appended to your page. could target to body, class, or id
*/

// var loader = function(){
window.loader = new function(){

	// Settings behavior
	/*
		1. scroll to top
		Description 	: while show loader, scroll page to top?
	*/	
	const scroll_to_top = true;


	// html template
	/*
		1. html over
		Description 	: loader html + css
	*/		
	var html_over =  '<div id="loader" style=" position: absolute;left: 0;top: 0;bottom: 0;right: 0;background: #000;opacity: 0.8;filter: alpha(opacity=80); z-index:1052;">' +
		            '<h3 style=" width: 272px;height: 57px;position: absolute;top: 50%;left: 50%;margin: -28px 0 0 -25px;transform:translateX(-20%);"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Memuat</h3>' +
		            '</div>';


	// interface class
	this.show = function(target){
		console.log(target);
	    $(html_over).appendTo(target);
	    if(scroll_to_top == true){
			window.scrollTo(0,0);
		    $('body').css('overflow', 'hidden');
	    }

	}
}

// This the interface
// window.thunder.loader = new loader();