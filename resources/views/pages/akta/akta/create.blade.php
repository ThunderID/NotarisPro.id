@extends('templates.blank')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet" />
@endpush

@push('styles')  
	body { background-color: rgba(0, 0, 0, 0.075) !important; }
	.editor {
		min-height: 29.7cm;
		border: 2px dashed #ececec;
		font-family: 'Inconsolata', monospace;
	}
	.tooltip {
		font-size: 11px !important;
	}
	input {
		font-family: 'Muli' sans-serif;
	}
	button {
		outline: none !important;
	}
	.form-data-mention input.form-control,
	.form-data-mention .btn,
	.form-data-kategori input.form-control,
	.form-data-kategori .btn {
		font-size: 13px !important;
	}
	.list-data-dokumen {
		right: -300px;
		position: fixed;
		opacity: 0;

		-webkit-transition: all 0.3s ease;
		-moz-transition: all 0.3s ease;
		-o-transition: all 0.3s ease;
		transition: all 0.3s ease;
	}
	.list-data-dokumen.open {
		right: 0;
		opacity: 1;
	}
	.menu-dokumen, .submenu-dokumen {
		position: absolute;
		top: 0;
		right: -300px;
		overflow: hidden;
		overflow-y: scroll;
		visibility: hidden;
		opacity: 0;
		width: 260px;

		-webkit-transition: all 0.3s ease;
		-moz-transition: all 0.3s ease;
		-o-transition: all 0.3s ease;
		transition: all 0.3s ease;
	}
	.menu-dokumen.active {
		visibility: visible;
		opacity: 1;
		right: 20px;
	}
	.submenu-dokumen.active {
		right: 20px;
		visibility: visible;
		opacity: 1;
	}
@endpush  

@section('akta')
	active
@stop

@section('buat-akta')
	active
@stop

@section('content')
	<div class="row" style="background-color: #fff;">
		<div class="col-md-9 col-lg-9">
			<div class="mt-1 mb-1">
				<i class="fa fa-file-text-o mr-3"></i> 
				<span class="label-judul-akta" data-flag="show" style="display: inline;">{{ $page_datas->judul_akta }}</span>
				<form action="#" class="form-inline form-judul-akta" data-flag="hide" style="display: none;">	
					<input type="text" class="form-control input-judul-akta" style="border: 0px; padding: 0.28em 0.75em;" value="{{ $page_datas->judul_akta }}">
					<a href="#" class="btn btn-default btn-sm text-faded form-judul-akta-cancel">Batal</a>
					<a href="#" class="btn btn-default btn-sm form-judul-akta-save">Simpan</a>
				</form>
				<div class="loading-save ml-2" style="display: none; font-size: 12px; color: #999;">
					<i class="fa fa-circle-o-notch fa-spin"></i> Menyimpan
				</div>
			</div>
		</div>
		<div class="col-md-3 col-lg-3 text-right">
			<a href="javascript:void(0);" data-toggle="modal" data-target="#SimpanDokumen" class="btn btn-default text-faded">
				<i class="fa fa-times" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col pl-0 pr-0">
			<div id="toolbarPane" class="text-center">
				{{-- button file --}}
				<span class="ql-formats">
					<button class="ql-new ml-1" style="margin-top: -2px;" data-toggle="modal" data-target="#SimpanDokumen" data-url="" data-tooltip="tooltip" title="Buat Baru"><i class="fa fa-file-o"></i></button>
					<button class="ql-save form-editor-akta-save" style="margin-top: -2px; outline: none;" data-tooltip="tooltip" data-url="{{ route('akta.akta.store') }}" title="Save"><i class="fa fa-save"></i></button>
				</span>
				<span class="ql-formats">
					<button class="ql-bold" data-tooltip="tooltip" title="Bold"></button>
					<button class="ql-italic" data-tooltip="tooltip" title="Italic"></button>
					<button class="ql-underline mr-2" data-tooltip="tooltip" title="Underline"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-script" value="sub" data-tooltip="tooltip" title="Subscript"></button>
					<button class="ql-script mr-2" value="super" data-tooltip="tooltip" title="Superscript"></button>
					<button class="ql-header" value="1" data-tooltip="tooltip" title="Header 1"></button>
					<button class="ql-header mr-2" value="2" data-tooltip="tooltip" title="Header 2"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-list" value="ordered" data-tooltip="tooltip" title="Numbering"></button>
					<button class="ql-list mr-2" value="bullet" data-tooltip="tooltip" title="Bullet"></button>
				</span>
				<span class="ql-formats">
					<select class="ql-align" data-tooltip="tooltip" title="Text Align">
						<option selected></option>
						<option value="center"></option>
						<option value="right"></option>
						<option value="justify"></option>
					</select>
					<button class="ql-indent" value="-1" data-tooltip="tooltip" title="Decrease Indent"></button>
					<button class="ql-indent mr-2" value="+1" data-tooltip="tooltip" title="Increase Indent"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-open-arsip" data-flag="close" style="margin-top: -3px; outline: none;" data-tooltip="tooltip" title="Open Arsip"><i class="fa fa-archive"></i></button>
				</span>
			</div>
		</div>
	</div>
	<div class="hidden-sm-down">
		<div class="list-data-dokumen pt-3" id="DataList" style="
			top: 82px;
			bottom: 0;
			background-color: #fff;
			z-index: 99;
			border-left: 2px solid #eee;
			width: 300px;
			height: calc(100vh - 82px);
			padding: 10px;
		">
			<ul class="list-unstyled menu-dokumen mt-2">
				<a href="#" class="btn-close-mention text-faded mt-1 mb-3 float-right" style="z-index: 999;">
					<i class="fa fa-times-rectangle"></i>
				</a>
				<h5 class="mt-2 mb-3">Data Dokumen</h5>
				@forelse ($page_datas->dokumen_lists as $k => $v)
					<li class="mb-3">
						<p class="text-capitalize mb-0"><strong>{{ $v['jenis_dokumen'] }}</strong></p>
						<a class="text-default ml-2 data-dokumen" href="#{{ $v['jenis_dokumen'] }}-{{ $k }}" data-toggle="collapse" aria-expanded="false" aria-controls="{{ $v['jenis_dokumen'] }}-{{ $k }}">
							<strong><i class="fa fa-plus-square-o align-baseline" style="font-size: 11px;"></i> {{ $v['kepemilikan'] }}</strong>
						</a>
						<ul id="{{ $v['jenis_dokumen'] }}-{{ $k }}" class="collapse list-unstyled ml-3 pl-2">
							@foreach($v['isi'] as $k2 => $v2)
								<li class="">
									<div class="">
										<a href="#" class="dokumen-item" id="dropdownData" data-item="{{ $v['jenis_dokumen'] }}.{{ $v['kepemilikan'] }}.{{ $v2 }}">
											{{ str_replace('_', '_', $v2) }}
										</a>
									</div>
								</li>
							@endforeach
						</ul>
					</li>
				@empty
				@endforelse
				<li class="mt-3 pt-2" style="font-size: 13px;">
					<a href="#" class="btn-add-data-mention" data-form="{{ $v['jenis_dokumen'] }}">
						<i class="fa fa-plus-circle"></i> Tambah Data Dokumen
					</a>
					<div class="form-data-mention" data-url="{{ route('akta.mention.store') }}" style="font-size: 13px !important; display: none;">
						<p class="text-small mb-1"><strong>Tambah Data Dokumen</strong></p>
						<input name="data-dokumen" type="text" class="form-control" placeholder="data dokumen" style="width: 100%;">
						<div class="mt-2 mb-2 float-right">
							<a href="#" class="btn btn-text btn-sm btn-cancel" style="font-size: 13px !important;">Batal</a>
							<button class="btn btn-primary btn-sm btn-save" style="font-size: 13px !important;">Simpan</button>
						</div>
					</div>
				</li>
			</ul>
			<ul class="list-unstyled submenu-dokumen mt-2">
				<div class="menu-header d-flex justify-content-start pt-2">
					<a href="#" class="btn-dokumen-previous text-faded">
						<i class="fa fa-chevron-left"></i>
					</a>
					<h5 class="ml-2" style="margin-top: 2px;">Pilih Kategori</h5>
					<a href="#" class="btn-close-mention text-faded ml-auto">
						<i class="fa fa-times-rectangle"></i>
					</a>
				</div>
				<li class="mb-2">
					<a href="#" class="data-mention" data-value="pihak.1.">
						Pihak 1
					</a>
				</li>
				<li class="mb-2">
					<a href="#" class="data-mention" data-value="pihak.2.">
						Pihak 2
					</a>
				</li>
				<li class="mb-2">
					<a href="#" class="data-mention" data-value="pihak.3.">
						Pihak 3
					</a>
				</li>
				<li class="mt-3 pt-2" style="font-size: 13px;">
					<a href="#" class="btn-add-data-kategori" data-form="{{ $v['jenis_dokumen'] }}">
						<i class="fa fa-plus-circle"></i> Tambah Kategori
					</a>
					<div class="form-data-kategori" data-url="{{ route('akta.mention.store') }}" style="font-size: 13px !important; display: none;">
						<p class="text-small mb-1"><strong>Tambah Kategori</strong></p>
						<input name="data-kategori" type="text" class="form-control form-control" placeholder="Kategori" style="width: 100%;">
						<div class="mt-2 mb-2 float-right">
							<a href="#" class="btn btn-text btn-sm btn-cancel" style="font-size: 13px !important;">Batal</a>
							<button class="btn btn-primary btn-sm btn-save" style="font-size: 13px !important;">Simpan</button>
						</div>
					</div>
				</li>
			</ul>

		</div>
		<div class="row justify-content-center mt-5" style="min-height: 146mm;">
			<div class="col">
				<div id="editor" class="editor form-paragraf-akta" style="background-color: #fff; width: 210mm; min-height: 120mm; margin: 0 auto; " data-url="{{ route('akta.akta.store') }}">
					@if (isset($page_datas->akta))
						@forelse ($page_datas->akta['paragraf'] as $k => $v)
							{!! $v['konten'] !!}
						@empty
						@endforelse
					@endif
				</div>
			</div>
		</div>
	</div>

	@component('components.modal', [
		'id'		=> 'SimpanDokumen',
		'title'		=> 'Simpan Dokumen',
		'settings'	=> [
			'modal_class'	=> '',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'false',
		]
	])
		<form id="save_dokumen" class="form-widgets text-right form" action="{{ route('akta.akta.store') }}" onSubmit="showLoader();" method="GET">
			<input type="hidden" id="id_akta" name="id_akta" value="null"/>
			<p>Apakah ingin menyimpan Akta Dokumen ini?</p>
			<fieldset class="from-group pb-2 pt-3">
				<button type="button" class="btn btn-secondary btn-discard" data-dismiss="modal">Tidak</button>
				<button type="submit" class="btn btn-primary" data-save="true">Simpan</button>
			</fieldset>
		</form>	
	@endcomponent	
@stop

@push('scripts')  
	window.editorUI.init();

	$(function() {
		$('[data-tooltip="tooltip"]').tooltip();

		$('.input-judul-akta').css('width', $('.label-judul-akta').width() + 25);
		$('.menu-dokumen').addClass('active');
	});

	$('.dokumen-item').on('click', function(e) {
		let item = $(this).attr('data-item');
		e.preventDefault();

		$('.menu-dokumen').removeClass('active');
		$('.submenu-dokumen').addClass('active');

		$('.data-mention').attr('data-item', item);
	});

	$('.btn-dokumen-previous').on('click', function(e) {
		e.preventDefault();

		$('.submenu-dokumen').removeClass('active');
		$('.menu-dokumen').addClass('active');
	});

	$('.label-judul-akta').on('click', function(e) {
		e.preventDefault();

		toggle_visibility( $(this) );
		toggle_visibility( $('.form-judul-akta') );
	});

	$('.btn-close-mention').on('click', function() {
		buttonOpenArsip = $('button.ql-open-arsip');

		$('#DataList').removeClass('open');
		buttonOpenArsip.attr('data-flag', 'close');
		buttonOpenArsip.removeClass('ql-active');
		$('.submenu-dokumen').removeClass('active');
		$('.menu-dokumen').addClass('active');
	});
	
	$('.form-judul-akta-cancel').on('click', function(e) {
		e.preventDefault();

		toggle_visibility( $('.form-judul-akta') )
		toggle_visibility( $('.label-judul-akta') )
	});

	$('.btn-discard').on('click', function(e) {
		e.preventDefault();

		window.close();
	});

	$('.btn-add-data-mention').on('click', function(e) {
		e.preventDefault();

		toggle_visibility ($('.form-data-mention'), 'block')
		toggle_visibility ($(this), 'block');
	});

	$('.btn-add-data-kategori').on('click', function(e) {
		e.preventDefault();

		toggle_visibility ($('.form-data-kategori'), 'block');
		toggle_visibility ($(this), 'block');
	});

	$('.form-data-mention .btn-cancel').on('click', function(e) {
		e.preventDefault();
		
		toggle_visibility( $('.btn-add-data-mention') );
		toggle_visibility( $('.form-data-mention') );
	});

	$('.form-data-kategori .btn-cancel').on('click', function(e) {
		e.preventDefault();
		
		toggle_visibility ($('.btn-add-data-kategori'), 'block');
		toggle_visibility ($('.form-data-kategori'), 'block');
	});

	$('.form-data-mention .btn-save').on('click', function(e) {
		let dataMention = $('.form-data-mention').find('input').val();
		let dataURL = $('.form-data-mention').attr('data-url');

		let ajax_akta = window.ajax;

		//ajax_akta.post(dataURL, )

		if ((typeof (dataMention) !== null) && (dataMention !== '')) {
			$.ajax({
				url: dataURL,
				method: 'POST',
				data: {mention: '@' + dataMention + '@'},
			});
		} 

	});
	
	function toggle_visibility (elem, properties) {
		if (elem.css('display') == 'none') {
			elem.css('display', (typeof properties !== 'undefined') ? properties : 'inline');
		} else {
			elem.css('display', 'none');
		}
	}

	window.onbeforeunload = function() {
		return "Dude, are you sure you want to refresh? Think of the kittens!";
	}
@endpush 
