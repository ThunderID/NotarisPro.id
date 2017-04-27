@extends('templates.basic')

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
	@php
		dd($page_datas);
	@endphp
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
						<a class="nav-link input-submit" href="#" data-toggle="modal" data-target="#form-title"><i class="fa fa-save"></i> Simpan</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 sidebar" style="height:calc(100% - 94px);">
				<div class="panel">
					<h5>List Widgets</h5>
					<div class="list-group list-widgets">
						@if (isset($page_datas->datas['mentionable']))
							@forelse ($page_datas->datas['mentionable'] as $k => $v)
								<a class="list-group-item list-group-item-action justify-content-between p-2" href="#" data-toggle="modal" data-target="#list-widgets" style="font-size: 14px;" data-widget="{{ $v }}">
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
										<input type="text" name="" class="form-control parsing" />
									</fieldset>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
										<button type="button" class="btn btn-primary" data-save="true">Simpan</button>
									</div>
								</form>
							@endcomponent
						@else
							<p>Tidak ada widget</p>
						@endif
					</div>
				</div>
			</div>
			<div id="page" class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel" style="height:calc(100% - 94px);">
				<div id="page-breaker" class="row page-breaker"></div>
				<div id="l-margin" class="margin margin-v"></div>
				<div id="r-margin" class="margin margin-v"></div>
				<div id="h-margin"></div>				
				<div class="row">
					<div class="col">&nbsp;</div>
					<div class="col-11 d-flex justify-content-center">
						<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
						@php
							// dd($page_datas);
						@endphp
							<textarea name="template" class="editor">
								@forelse ($page_datas->datas['paragraf'] as $k => $v)
									@php
										$pattern = "/<b class=\"medium-editor-mention-at?.*\">(.*)<\/b>/";
										preg_match($pattern, $v['konten'], $matches);
									@endphp
									@if (!empty($matches))
										@if (isset($matches[1]) && !empty($matches[1]))
											@if (isset($matches[1]) && !empty($matches[1]))
												@php
													$data_mention = array_get($page_datas->datas['fill_mention'], $matches[1], $matches[1]);
													$new_konten = preg_replace('/<b (.*?)>(.*?)<\/b>/i', '<b $1>'.$data_mention.'</b>', $v['konten']);
												@endphp
												{!! $new_konten !!}
											@endif
										@endif
									@endif
									{!! $v['konten'] !!}
								@empty
								@endforelse
							</textarea>
						</div>
					</div>
					<div class="col">&nbsp;</div>	
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

//	var widget = $('.form-akta').find('b.medium-editor-mention-at');
//	$.each(widget, function(k, v) {
//		widgetMention = $(v).html();
//		if (widgetMention.search('@') != -1) {
//			$(v).css('color', '#d9534f');
//		}
//	});


	// Functions

	/* Margin Drawer */
	function drawMargin(){
		// init
		var pivot_pos = $('.page-editor').offset();
		var pivot_h = $('.page-editor').outerHeight();
		var pivot_w = $('.page-editor').outerWidth();
		var template_h = window.Margin.convertPX(29.7);

		var margin = window.Margin;
		var ml = margin.convertPX(5) + pivot_pos.left - 45  - $('.sidebar').width() - 4;
		var mr = pivot_pos.left + pivot_w - margin.convertPX(1) - 45  - $('.sidebar').width() + 2;
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
