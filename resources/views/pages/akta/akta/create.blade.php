@extends('templates.basic')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  
	body {background-color: rgba(0, 0, 0, 0.075) !important;}
@endpush  

@section('akta')
	active
@stop

@section('buat-akta')
	active
@stop

@section('content')
	<div class="hidden-sm-down">
		@component('components.form', [ 
			'data_id'		=> $page_datas->akta_id,
			'store_url' 	=> route('akta.akta.store', ['template_id' => $page_datas->template_id]), 
			'update_url' 	=> route('akta.akta.update', ['id' => $page_datas->akta_id]), 
			'class'			=> 'form-akta mb-0'
		])
			<div class="row bg-faded">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 pl-0">
					<ul class="nav menu-content justify-content-start">
						<li class="nav-item">
							<a class="nav-link" href="{{ route('akta.akta.show', ['id' => $page_datas->akta_id]) }}"><i class="fa fa-angle-left"></i> &nbsp;Kembali</a>
						</li>
					</ul>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pr-0">
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
							<a class="nav-link input-submit save-content" href="#" data-toggle="modal" data-target="#form-title"><i class="fa fa-save"></i> Simpan</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 sidebar subset-2menu">
					<div class="panel">
						<h5>List Fillable Mention</h5>
						<div class="list-group list-widgets">
							@if (isset($page_datas->datas['mentionable']))
								@php
									$sort_mentionable = array_sort_recursive($page_datas->datas['mentionable']);
								@endphp
								@forelse ($sort_mentionable as $k => $v)
									<a class="list-group-item list-group-item-action justify-content-between p-2 mb-2" href="#" data-toggle="modal" data-target="#list-widgets" style="font-size: 14px;" data-widget="{{ $v }}">
										{{ $v }}
										<span class="{{ (array_has($page_datas->datas['fill_mention'], $v)) ? 'active' : '' }}"><i class="fa fa-check"></i></span>
									</a>
								@empty
								@endforelse

								@component('components.modal', [
									'id'		=> 'list-widgets',
									'title'		=> '',
									'settings'	=> [
										'modal_class'	=> '',
										'hide_buttons'	=> 'true',
										'hide_title'	=> 'true',
									]
								])
									<form class="form-widgets text-right form" action="#">
										<fieldset class="from-group">
											<input type="text" name="" class="form-control parsing set-focus" />
										</fieldset>
										<div class="modal-footer">
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
											<button type="button" class="btn btn-primary" data-save="true">Simpan</button>
										</div>
									</form>
								@endcomponent
							@else
								<p>Tidak ada fillable mention</p>
							@endif
						</div>
					</div>
				</div>
				<div id="page" class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-2menu">
					<div id="page-breaker" class="row page-breaker"></div>
					<div id="l-margin" class="margin margin-v"></div>
					<div id="r-margin" class="margin margin-v"></div>
					<div id="h-margin"></div>				
					<div class="row">
						<div class="d-flex justify-content-center mx-auto">
							<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
								<div class="editor" id="doc-content-mention">
									@forelse ($page_datas->datas['paragraf'] as $k => $v)
										@php
											$temp = explode('<span class="medium-editor-mention-at', $v['konten']);
										@endphp
										@if (!is_null($temp) && !empty($temp))
											@foreach ($temp as $i => $j)
												@php
													$pattern = "/@(.*?)<\/span>/";
													preg_match($pattern, $j, $match);
												@endphp
												@if (!empty($match))
													@if (isset($match[1]) && !empty($match[1]))
														@if (array_get($page_datas->datas['fill_mention'], '@'.$match[1]) != null)
															@php
																$data_mention 	= array_get($page_datas->datas['fill_mention'], '@'.$match[1]);
																if (strpos($data_mention, '@') !== false) {
																	$temp[$i] = preg_replace($pattern, $data_mention. '</span>', $j);
																} else {
																	$pattern = '/@(.*?)<\/span>/';
																	$temp[$i] = preg_replace($pattern, $data_mention. '</span>', $j);
																}
															@endphp
														@endif
													@endif
												@endif
											@endforeach
											{!! implode('<span class="medium-editor-mention-at', $temp) !!}
										@else
											{!! $v['konten'] !!}
										@endif
									@empty
									@endforelse
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endcomponent
		@component('components.modal', [
			'id'		=> 'widget',
			'title'		=> 'Form Widgets',
			'settings'	=> [
				'modal_class'	=> '',
				'hide_buttons'	=> 'true',
				'hide_title'	=> 'true',
			]
		])
		@endcomponent
	</div>
	<div class="hidden-md-up subset-menu">
		<div class="text-center" style="padding-top: 25vh;">
			<p>Silahkan akses melalui perangkat komputer untuk dapat menggunakan fitur ini.</p>
		</div>
	</div>	
@stop

@push('scripts')  
	var dataListWidgets = {};
	var urlAutoSave = "{{ (!is_null($page_datas->akta_id)) ? route('akta.akta.automatic.store', ['id' => $page_datas->akta_id]) : route('akta.akta.automatic.store')  }}";
	var form = $('.form-akta');
	var urlFillMention = "{{ (!is_null($page_datas->akta_id)) ? route('akta.akta.simpan.mention', ['akta_id' => $page_datas->akta_id]) : route('akta.akta.simpan.mention')  }}";
	window.editorUI.init(urlAutoSave, form, {disable: true});
	window.loadingAnimation.init();

	window.widgetEditorUI.init();
	window.modalUI.init();

	$('.input-submit').on('click', function(el) {
		el.preventDefault();
		$('form.form-akta').submit();
	});

	/* Script call modal widget */
	$('.modal').on('shown.bs.modal', function(e) {
		window.formUI.init();
	});


	// Functions

	/* Margin Drawer */
	function drawMargin(){
		// init
		var pivot_pos = $('.page-editor').offset();
		var pivot_h = $('.page-editor').outerHeight();
		var pivot_w = $('.page-editor').outerWidth();
		var template_h = window.Margin.convertPX(29.7);
		var margin_document = 47;

		var margin = window.Margin;
		var ml = margin.convertPX(5) + pivot_pos.left - margin_document  - $('.sidebar').width() - 4;
		var mr = pivot_pos.left + pivot_w - margin.convertPX(1) - margin_document  - $('.sidebar').width() + 2;
		var mt = 16 + margin.convertPX(2) - 2;
		var mb = template_h - (margin.convertPX(2) + margin.convertPX(3) - 16);

		margin.docLeft = pivot_pos.left - 45 - $('.sidebar').width();
		margin.docWidth = pivot_w;
		margin.docHeight = pivot_h;
		margin.pageHeight = template_h;

		margin.displayMargin(ml,mt,mr,mb);
	}

	/* Auto page break */
	/*
	function pageBreak(){
		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);
	}
	*/


	// Adapter 
	var editor = $('.editor');
	var page_editor = $('.page-editor');


	// Handlers 
	editor.keyup(function(){
		drawMargin();
	});	

	$(document).ready(function(){
		drawMargin();
	});	

	$( window ).resize(function() {
		drawMargin();
	});


	/* Hotkeys */
	var res = window.hotkey.init($('.editor'));	

@endpush 
