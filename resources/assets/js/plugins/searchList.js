/* List Search */
window.searchList = new function(){
	// adapter
	input = $('.search-input');
	list = $('.search-list');

	//events
	input.keyup(function(){
		getSearch(); 
	});	

	// functions
	function getSearch(){
		//reset
		reset();

		// get search text
		var q = input.val();

		// find needle from stack
		$.each(list, function( index, value ) {

			var txt = $(value).text();

			if (txt.indexOf(q) < 0){
				hide($(this).parent().parent().parent());		
			}
		});
	}


	// ui
	reset = function(){
		list.parent().parent().parent().show();
	}
	hide = function(e){
		e.hide();
	}		
}