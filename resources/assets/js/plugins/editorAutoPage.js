/*
	Auto Editor Paging
	Thunderlab 2017
	created : Budi 
	-------------
*/
window.editorPaging = new function() {

	/* Adapter */
	this.pageHeight = 29.7;
	this.pagePadd = 5;

	/* Binded to class page, which is the element holder of your text editor. */ 
    this.getOuterHeight = function(){
	    return parseFloat($('.page-editor').height().toFixed(2));
    }

	/* editor pages */ 
    this.getEditorHeight = function() {
    	return Math.floor(this.getOuterHeight()/this.pageHeight);
	}	    

    /* Function */

    // Converter

    this.convertCM = function(px){
    	return parseFloat((px/37.795276).toFixed(2));
    }

    this.convertPX = function(cm){
    	return parseFloat((cm*37.795276).toFixed(2));
    }	    


    // Page Adjuster

    this.autoAdjustHeight = function (target, target_padding, editor, editor_padding) {


    	/* init 
    	var inner_h = editor.height() + editor_padding  + target_padding;
    	var outer_h = this.pageHeight;
    	var gap = outer_h - inner_h;

    	/* measure ideal height 
		do {
			if(gap < 0){
				this.autoPageBreak(outer_h);

			    /* add new page 
			    outer_h = outer_h + this.pageHeight;
			    gap = outer_h - inner_h;
			}
		}
		while (gap < 0);

		/* apply height 
    	target.css('min-height', outer_h);
    	*/

    	var inner_h = editor.height() + editor_padding  + target_padding;
    	var outer_h = this.pageHeight;

		do {
			if(outer_h < inner_h){
				this.autoPageBreak(outer_h);

			    /* add new page */
			    outer_h = outer_h + this.pageHeight;
			}
		}
		while (outer_h < inner_h);    	

		/* apply height */ 
    	target.css('min-height', outer_h);
    };


    // Page Break
    // require html binded : [id] page-breaker. This will be your page break html.
    // require html binded : [id] page. This will be your base canvas.

    this.autoPageBreak = function(h){
		// append page break
		temp = $('#page-breaker').clone();
		temp.addClass('page-break');
		temp.css('top', (h - 1 + 16) + 'px' );
		$('#page').append(temp);
    }
}	