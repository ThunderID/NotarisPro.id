/*
	Footer Generator
	Thunderlab 2017
	created : Budi 
	-------------
*/

window.footerGenerator = new function(){

	// init
	this.docLeft = 0;
	this.docWidth = 0;
	this.docHeight = 0;
	this.pageHeight = 0;

	this.title = 'Title';
	this.content1 = 'content1';
	this.content2 = 'content2';
	this.target = $('#page');

	// devinition
	this.footer = function(top,left,width,page, content){
		return "<div class='auto-footer' style='font-family: Inconsolata, monospace; border-top: 1px solid black; top:" + top + "px;left:" + left + "px;width:" + width + "px; position:absolute;'><p style='text-align:left;margin-bottom: 0.3rem;'><i>" + this.title + "</i><span style='float:right'>" + page + "</span></p><p style='text-align:left;margin-bottom: 0rem;'>" + this.content1 + "</p><p style='text-align:left;'>" + this.content2 + "</p></div>";
	}

	// converter
    this.convertCM = function(px){
    	return parseFloat((px/37.795276).toFixed(2));
    }

    this.convertPX = function(cm){
    	return parseFloat((cm*37.795276).toFixed(2));
    }

    // display
	this.display = function(bottom){

		/* init */
    	var inner_h = this.docHeight;
    	var outer_h = this.pageHeight;
    	var gap = outer_h;

    	/* Draw */
		var ctr = 0;
    	ctr = this.docHeight /this.pageHeight;
    	for(i = 0; i < ctr; i++){

    		var t_page = "Halaman " + (i + 1);

			this.target.append(this.footer(bottom, this.docLeft, this.docWidth, t_page));

			//set new top
		 	bottom = bottom + this.pageHeight;
    	}

	}

	this.updateDisplay = function(){
		$('.auto-footer').css('left', this.docLeft + 'px');
	}
}