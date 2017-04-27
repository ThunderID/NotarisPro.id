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
		'update_url' 	=> route('akta.template.update', ['id' => $page_datas->id]), 
		'class'			=> 'form-template mb-0'
	])
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
		<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 sidebar" style="height:calc(100% - 94px);">
				<div class="panel">
					<h5>Info List Widgets</h5>
					<div class="list-widgets">
						@if (isset($page_datas->list_widgets))
							@forelse ($page_datas->list_widgets as $k => $v)
								<p class="mt-2 mb-2" style="font-size: 14px;">{{ $v }}</p>
								{{-- <a class="justify-content-between p-2" href="#" data-toggle="modal" data-target="#list-widgets" style="font-size: 14px;" data-widget="{{ $v }}">
									
									<span class="{{ (array_has($page_datas->datas['fill_mention'], $v)) ? 'active' : '' }}"><i class="fa fa-check"></i></span>
								</a> --}}
							@empty
							@endforelse
						@else
							<p>Tidak ada widget</p>
						@endif
					</div>
				</div>
			</div>
			<div id="page" class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel" style="height:calc(100% - 94px);">
				<div id="page-breaker" class="row page-breaker"></div>
				<div id="l-margin" class="margin margin-v"></div>
				<div id="r-margin" class="margin margin-v"></div>
				<div id="h-margin"></div>
				<div class="row">
					<div class="col">&nbsp;</div>
					<div class="col-11 d-flex justify-content-center">
						<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
							<textarea name="template" class="editor">
								@if (!is_null($page_datas->id))
									@if (!empty($page_datas->datas['paragraf']))
										@forelse ($page_datas->datas['paragraf'] as $k => $v)
											{!! $v['konten'] !!}
										@empty
										@endforelse
									@endif
								@endif
							</textarea>
						</div>
					</div>
					<div class="col">&nbsp;</div>	
				</div>
			</div>
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
	var url = "{{ (!is_null($page_datas->id)) ? route('akta.template.automatic.store', ['id' => $page_datas->id]) : route('akta.template.automatic.store')  }}";
	var form = $('.form-template');
	window.editorUI.init(url, form);


	//	functions

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

	/* Page Break */
	function pageBreak(){
		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);
	}

	// adapter
	var editor = $('.editor');
	var page_editor = $('.page-editor');

	// handlers
	$(document).ready(function(){
		pageBreak();
		drawMargin();
	});

	$( window ).resize(function() {
		drawMargin();
	});

	editor.keyup(function(){
		pageBreak();
		drawMargin()
	});

@endpush 