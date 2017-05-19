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
					<li class="nav-item">
						<a class="nav-link input-submit" href="#" data-toggle="modal" data-target="#form-title"><i class="fa fa-save"></i> Simpan</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div id="page" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 scrollable_panel subset-2menu">
				<div id="page-breaker" class="row page-breaker"></div>
				<div id="l-margin" class="margin margin-v"></div>
				<div id="r-margin" class="margin margin-v"></div>
				<div id="h-margin"></div>				
				<div class="row">
					<div class="d-flex justify-content-center mx-auto">
						<div class="form mt-3 mb-3 font-editor page-editor bg-white" style="width: 21cm; min-height: 29.7cm; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
							<div class="editor">
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
																dd($temp[$i]);
															} else {
																$pattern = '/text-danger">@(.*?)<\/span>/';
																$temp[$i] = ' text-primary'.preg_replace($pattern, $data_mention. '</span>', $j);
															}
														@endphp
													@endif
												@endif
											@endif
										@endforeach
										@if (!isset($v['lock']))
											<div>
												<i class="fa fa-unlock-alt text-success float-right" style="margin-top: 0.15em; margin-right: -1em; cursor:not-allowed;"></i>
												<textarea name="template[{{ $k }}]" class="editor">
													{!! implode('<span class="medium-editor-mention-at', $temp) !!}
												</textarea>
											</div>
										@else
											<div class="bg-faded text-muted" style="cursor:not-allowed;">
												<i class="fa fa-lock text-muted float-right" style="margin-top: 0.15em; margin-right: -1em; cursor:not-allowed;"></i>
												{!! implode('<span class="medium-editor-mention-at', $temp) !!}
											</div>
										@endif
									@else
										@if (!isset($v['lock']))
											<div>
												<i class="fa fa-unlock-alt text-success float-right" style="margin-top: 0.15em; margin-right: -1em; cursor:not-allowed;"></i>
												<textarea name="template[{{ $k }}]" class="editor">
													{!! $v['konten'] !!}
												</textarea>
											</div>
										@else
											<div class="bg-faded text-muted" style="cursor:not-allowed;">
												<i class="fa fa-lock text-muted float-right" style="margin-top: 0.15em; margin-right: -1em; cursor:not-allowed;"></i>
												{!! $v['konten'] !!}
											</div>
										@endif
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
@stop

@push('scripts')  
	var dataListWidgets = {};
	var url = "{{ (!is_null($page_datas->akta_id)) ? route('akta.akta.automatic.store', ['id' => $page_datas->akta_id]) : route('akta.akta.automatic.store')  }}";
	var form = $('.form-akta');
	var urlFillMention = "{{ (!is_null($page_datas->akta_id)) ? route('akta.akta.simpan.mention', ['akta_id' => $page_datas->akta_id]) : route('akta.akta.simpan.mention')  }}";
	window.editorUI.init(url, form);

	window.widgetEditorUI.init();
	window.modalUI.init();
	window.formUI.init();

	$('.input-submit').on('click', function(el) {
		el.preventDefault();
		$('form.form-akta').submit();
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
	function pageBreak(){
		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);
	}


	// Adapter 
	var editor = $('.editor');
	var page_editor = $('.page-editor');


	// Handlers 
	editor.keyup(function(){
		pageBreak();
		drawMargin();
	});	

	$(document).ready(function(){
		pageBreak();
		drawMargin();
	});	

	$( window ).resize(function() {
		drawMargin();
	});

@endpush 