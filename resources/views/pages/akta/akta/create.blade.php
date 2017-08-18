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
@endpush  

@section('akta')
	active
@stop

@section('buat-akta')
	active
@stop

@section('content')
	@php
		foreach($page_datas->dokumen_lists as $k => $v)
		{
			$list = json_encode($v['isi'], true);
		}
	@endphp
	<div class="row" style="background-color: #fff;">
		<div class="col-md-9 col-lg-9">
			<div class="mt-1 mb-1">
				<i class="fa fa-file-text-o mr-3"></i> 
				<span class="label-title" data-flag="show" style="display: inline;">{{ $page_datas->judul_akta }}</span>
				<form action="#" class="form-inline form-title" data-flag="hide" style="display: none;">	
					<input type="text" class="form-control" style="border: 0px; padding: 0.28em 0.75em;" value="{{ $page_datas->judul_akta }}">
					<a href="#" class="btn btn-default btn-sm text-faded form-title-cancel">Batal</a>
					<a href="#" class="btn btn-default btn-sm form-title-save">Simpan</a>
				</form>
			</div>
		</div>
		<div class="col-md-3 col-lg-3 text-right">
			<a href="javascript:void(0);" data-toggle="modal" data-target="#SimpanDokumen" class="btn btn-default">
				<i class="fa fa-times" aria-hidden="true"></i>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col pl-0 pr-0">
			<div id="toolbarPane" class="text-center">
				{{-- button file --}}
				<span class="ql-formats">
					<button class="ql-new ml-1" style="margin-top: -2px;" data-toggle="tooltip" title="Buat Baru"><i class="fa fa-file-o"></i></button>
					<button class="ql-save" style="margin-top: -2px; outline: none;" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
				</span>
				<span class="ql-formats">
					<button class="ql-bold" data-toggle="tooltip" title="Bold"></button>
					<button class="ql-italic" data-toggle="tooltip" title="Italic"></button>
					<button class="ql-underline mr-2" data-toggle="tooltip" title="Underline"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-script" value="sub" data-toggle="tooltip" title="Subscript"></button>
					<button class="ql-script mr-2" value="super" data-toggle="tooltip" title="Superscript"></button>
					<button class="ql-header" value="1" data-toggle="tooltip" title="Header 1"></button>
					<button class="ql-header mr-2" value="2" data-toggle="tooltip" title="Header 2"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-list" value="ordered" data-toggle="tooltip" title="Numbering"></button>
					<button class="ql-list mr-2" value="bullet" data-toggle="tooltip" title="Bullet"></button>
				</span>
				<span class="ql-formats">
					<select class="ql-align" data-toggle="tooltip" title="Text Align">
						<option selected></option>
						<option value="center"></option>
						<option value="right"></option>
						<option value="justify"></option>
					</select>
					<button class="ql-indent" value="-1" data-toggle="tooltip" title="Decrease Indent"></button>
					<button class="ql-indent mr-2" value="+1" data-toggle="tooltip" title="Increase Indent"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-open-arsip" data-flag="close" style="margin-top: -3px; outline: none;" data-toggle="tooltip" title="Open Arsip"><i class="fa fa-archive"></i></button>
				</span>
			</div>
		</div>
	</div>
	<div class="hidden-sm-down">
		<div id="DataList" style="
			display: none;
			position: fixed;
			right: 0;
			top: 40px;
			bottom: 0;
			background-color: #fff;
			z-index: 99;
			border-left: 3px solid #eee;
			width: 250px;
			padding: 20px;
		">
			<ul class="list-unstyled">
				@foreach($page_datas->dokumen_lists as $k => $v)
					<li><strong>{{ $v['jenis_dokumen'] }}</strong></li>
					<ul>
						@foreach($v['isi'] as $k2 => $v2)
							<li>
								<a href="#" class="data-mention" data-value="{{ '@' . str_replace('_', '_', $v2) . '@' }}">{{ str_replace('_', '_', $v2) }}</a>
							</li>
						@endforeach
					</ul>
				@endforeach
			</ul>
		</div>
		<div class="row justify-content-center mt-5">
			<div class="col">
				<div id="editor" class="editor" style="background-color: #fff; width: 210mm; min-height: 150mm; margin: 0 auto; ">
					@foreach ($page_datas->akta['paragraf'] as $k => $v)
						{!! $v['konten'] !!}
					@endforeach
				</div>
			</div>
		</div>
	</div>

	@component('components.modal', [
		'id'		=> 'SimpanDokumen',
		'title'		=> 'Informasi',
		'settings'	=> [
			'modal_class'	=> '',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'false',
		]
	])
		<form id="save_dokumen" class="form-widgets text-right form" action="{{ route('akta.akta.store') }}" onSubmit="showLoader();" method="GET">
			<input type="hidden" id="id_akta" name="id_akta" value="null"/>
			<p>Apakah Anda ingin menyimpan Akta Dokumen?</p>
			<fieldset class="from-group pb-2 pt-3">
				<a href="#" class="btn btn-secondary float-left btn-discard">Buang</a>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary" data-save="true">Simpan</button>
			</fieldset>
		</form>	
	@endcomponent	
@stop

@push('scripts')  
	var listMention = {!! $list !!};
	window.editorUI.init();

	$(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});

	$('.label-title').on('click', function(e) {
		e.preventDefault();

		$(this).css('display', 'none');
		$('.form-title').css('display', 'inline');
	});
	
	$('.form-title-cancel').on('click', function(e) {
		e.preventDefault();

		$('.form-title').css('display', 'none');
		$('.label-title').css('display', 'inline');
	});

	$('.btn-discard').on('click', function(e) {
		e.preventDefault();

		window.close();
	});

	window.onbeforeunload = function() {
		return "Dude, are you sure you want to refresh? Think of the kittens!";
	}
@endpush 
