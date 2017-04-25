/*
	Margin Drawer
	Thunderlab 2017
	created : Budi 
	-------------
*/

window.Margin = new function(){

	this.docLeft = 0;
	this.docTop = 0;
	this.docWidth = 0;
	this.docHeight = 0;
	this.pageHeight = 0;
	this.pageWidth = 0;

    this.convertCM = function(px){
    	return parseFloat((px/37.795276).toFixed(2));
    }

    this.convertPX = function(cm){
    	return parseFloat((cm*37.795276).toFixed(2));
    }

	this.toggleOff = function(){
		$('.margin').css('display', 'none');
	}

	this.toggleOn = function(){
		$('.margin').css('display', 'block');
	}

	this.displayMargin = function(left,top,right,bottom){
		// left & right margin
		$('#l-margin').css('left', left);
		$('#r-margin').css('left', right);

		// Top & Bottom
    	/* init */
    	var inner_h = this.docHeight;
    	var outer_h = this.pageHeight;
    	var gap = outer_h;

    	/* clean */
    	$(".margin-h").remove();

    	/* top draw */
    	var ctr_top = 0;
    	ctr_top = this.docHeight /this.pageHeight;

    	for(i = 0; i < ctr_top; i++){

			temp = $('#h-margin').clone();
			temp.addClass('margin');
			temp.addClass('margin-h');
			temp.css('top', top + 'px');
			temp.css('display', 'block');
			temp.css('width', this.docWidth + 'px');
			temp.css('margin-left', this.docLeft);
			$('#page').append(temp);

			//set new top
			console.log(this.pageHeight);
		 	top = top + this.pageHeight;
    	}

    	/* bottom draw */
    	var ctr_bottom = 0;
    	ctr_bottom = this.docHeight /this.pageHeight;
    	for(i = 0; i < ctr_bottom; i++){

			temp = $('#h-margin').clone();
			temp.addClass('margin');
			temp.addClass('margin-h');
			temp.css('top', bottom + 'px');
			temp.css('display', 'block');
			temp.css('width', this.docWidth + 'px');
			temp.css('margin-left', this.docLeft);
			$('#page').append(temp);

			//set new top
			console.log(bottom);
			console.log(this.pageHeight);
		 	bottom = bottom + this.pageHeight;
    	}	    	
	}
}