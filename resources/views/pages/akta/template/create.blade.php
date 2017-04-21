@extends('templates.basic')

@push('styles')  
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
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col">&nbsp;</div>
					<div class="col-11 d-flex justify-content-center">
						<div class="form mt-3 mb-3 font-editor" style="width: 21cm !important; height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
							<div class="form-group p-3">
								<textarea name="template" class="editor"></textarea>
							</div>
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

	$(".editor").keyup(function(){

		var cursorPosition = $('#myTextarea').prop("selectionStart");
		console.log(cursorPOsition);


		/*
		var h = $(this).height();

		if(h > 904 * (h/904)){
			console.log(h);
		}
		*/
	});

(function ($) {
    $.fn.getCursorPosition = function () {
        var input = this.get(0);
        if (!input) return; // No (input) element found
        if ('selectionStart' in input) {
            // Standard-compliant browsers
            return input.selectionStart;
        } else if (document.selection) {
            // IE
            input.focus();
            var sel = document.selection.createRange();
            var selLen = document.selection.createRange().text.length;
            sel.moveStart('character', -input.value.length);
            return sel.text.length - selLen;
        }
    }
})(jQuery);

@endpush 