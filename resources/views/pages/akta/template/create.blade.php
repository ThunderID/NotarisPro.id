@extends('templates.basic')

@push('styles')  
.page-breaker{
	position: absolute; 
	height: 1.52px; 
	background-color: #ececec; 
	width: 100%;
}

.margin{
	position: absolute;
    z-index: 2;
}

.margin-v{
    height: calc(100% - 2rem);
    width: 2px;
    border-left: 2px dashed #ececec;
    margin-top: 1.1rem;
}

.margin-h{
    height: 2px;
    width: 100%;
    border-top: 2px dashed #ececec;
    dislay:none;
}

@endpush  

@section('akta')
	active
@stop

@section('buat-template')
	active
@stop

@section('content')
	@component('components.form', [ 
		'data_id'		=> $page_datas->id,
		'store_url' 	=> route('akta.template.store'), 
		'update_url' 	=> route('akta.template.update', ['id', $page_datas->id]), 
		'class'			=> 'mb-0'
	])
		<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				{{-- COMPONENT MENUBAR --}}
				<div class="row bg-faded">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						&nbsp;
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<ul class="nav menu-content justify-content-end">
							{{-- <li class="nav-item">
								<span class="nav-link">Zoom</span>
							</li>
							<li class="nav-item">
								<span class="nav-link">Halaman</span>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">A4</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">A4</a>
									<a class="dropdown-item" href="#">F4</a>
								</div>
							</li> --}}
							<li class="nav-item">
								<a class="nav-link" href="#" data-toggle="modal" data-target="#form-title"><i class="fa fa-save"></i> Simpan</a>
							</li>
						</ul>
					</div>
				</div>
				{{-- END COMPONENT MENUBAR --}}
			</div>
			<div id="page" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div id="page-breaker" class="row page-breaker"></div>
				<div id="l-margin" class="margin margin-v"></div>
				<div id="r-margin" class="margin margin-v"></div>
				<div id="h-margin"></div>
				<div class="row">
					<div class="col">&nbsp;</div>
					<div class="col-9 d-flex justify-content-center">
						<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
							<textarea name="template" class="editor"></textarea>
						</div>
					</div>
					<div class="col">&nbsp;</div>	
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
		</div>
		{{-- COMPONENT MODAL TITLE TEMPLATE --}}
		<div class="modal fade" id="form-title">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h4 class="modal-title">Template</h4>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
							<span class="sr-only">Close</span>
						</button>
					</div>
					<div class="modal-body">
						<div class="form">
							<fieldset class="from-group">
								<label class="text-capitalize">judul template</label>
								<div class="row">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
										<input type="text" name="title" class="form-control">
									</div>
								</div>
							</fieldset>
						</div>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
						<button type="submit" class="btn btn-primary">Simpan</button>
					</div>
				</div>
			</div>
		</div>
	@endcomponent
@stop

@push('scripts')
	var dataListWidgets = {!! json_encode($page_datas->list_widgets) !!};
	window.editorUI.init();


	function drawMargin(){
		// init
		var pivot_pos = $('.page-editor').offset();
		var pivot_h = $('.page-editor').outerHeight();
		var pivot_w = $('.page-editor').outerWidth();
		var template_h = Margin.convertPX(29.7);

		var margin = Margin;
		var ml = Margin.convertPX(5) + pivot_pos.left - 2;
		var mr = pivot_pos.left + pivot_w - margin.convertPX(1) + 2;
		var mt = 16 + margin.convertPX(2) - 2;
		var mb = template_h - (margin.convertPX(2) + margin.convertPX(3) - 16);

		margin.docLeft = pivot_pos.left - 15;
		margin.docWidth = pivot_w;
		margin.docHeight = pivot_h;
		margin.pageHeight = template_h;

		margin.displayMargin(ml,mt,mr,mb);
	}


	$(document).ready(function(){
		drawMargin();
	});

	/*
		Editor
		-----------
	*/

	/* Adapter */
	var editor = $('.editor');
	var page_editor = $('.page-editor');

	/* Event Handlers */
	editor.keyup(function(){
		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);

		drawMargin()
	});








	/*
		Editor Paging
		-------------
	*/
	var editorPaging = new function() {

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

	    	/* init */
	    	var inner_h = editor.height() + editor_padding  + target_padding;
	    	var outer_h = this.pageHeight;
	    	var gap = outer_h - inner_h;

	    	/* measure ideal height */
			do {
				if(gap < 0){
					this.autoPageBreak(outer_h);

				    /* add new page */
				    outer_h = outer_h + this.pageHeight;
				    gap = outer_h - inner_h;
				}
			}
			while (gap < 0);

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



	var Margin = new function(){

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
@endpush 