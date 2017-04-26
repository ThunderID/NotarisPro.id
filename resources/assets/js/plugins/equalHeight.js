/*
	Equal height
	Thunderlab 2017
	created : Budi 
	-------------
*/
window.equalHeight = new function() {

	/* Adapter */
	this.target = null;
	this.equalTo = 'max';

	// functions
	this.do = function(){
		// init
		var target = this.target;

		// measure
		var newHeight = 0;
		if(this.equalTo == 'max'){
			newHeight = this.countMax();
		}else{
			newHeight = this.countMin();
		}

		// apply new height
		target.css('height',  newHeight + 'px');
	}

	this.reset = function(){
		// init
		var target = this.target;

		// apply initial height
		target.css('height',  'auto');
	}

	this.countMax = function(){
		var _max = 0;

		$.each(this.target, function( index, value ) {
			var h = $(value).outerHeight();

			if(_max < h){
				_max = h;
			}
		});

		return _max; 
	}

	this.countMin = function(){
		var _min = 0;

		$.each(this.target, function( index, value ) {
			var h = $(value).outerHeight();

			if(_min > h){
				_min = h;
			}else if(min == 0){
				_min = h;
			}
		});


		return _min; 
	}	
}