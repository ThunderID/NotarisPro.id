@extends('templates.blank')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet" />
@endpush

@push('styles')  
	body { background-color: rgba(0, 0, 0, 0.075) !important; }
	.editor {
		min-height: 29.7cm;
		border: 2px dashed #ececec;
	}
	.tooltip {
		font-size: 11px !important;
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
			<p class="mt-2 mb-1">
				<i class="fa fa-file-text-o"></i> 
				Untitled
			</p>
		</div>
		<div class="col-md-3 col-lg-3 text-right">
			<a href="#" class="btn btn-default">Close</a>
		</div>
	</div>
	<div class="row">
		<div class="col pl-0 pr-0">
			<div id="toolbarPane" class="text-center">
				<button class="ql-new-file ml-1" style="margin-top: -2px;" data-toggle="tooltip" title="Buat Baru">
					<i class="fa fa-file-o"></i>
				</button>
				<button class="ql-bold" data-toggle="tooltip" title="Bold"></button>
				<button class="ql-italic" data-toggle="tooltip" title="Italic"></button>
				<button class="ql-underline mr-2" data-toggle="tooltip" title="Underline"></button>
				
				<button class="ql-script" value="sub" data-toggle="tooltip" title="Subscript"></button>
				<button class="ql-script mr-2" value="super" data-toggle="tooltip" title="Superscript"></button>

				<button class="ql-header" value="1" data-toggle="tooltip" title="Header 1"></button>
				<button class="ql-header mr-2" value="2" data-toggle="tooltip" title="Header 2"></button>

				<button class="ql-list" value="ordered" data-toggle="tooltip" title="Numbering"></button>
				<button class="ql-list mr-2" value="bullet" data-toggle="tooltip" title="Bullet"></button>

				<button class="ql-indent" value="-1" data-toggle="tooltip" title="Decrease Indent"></button>
				<button class="ql-indent mr-2" value="+1" data-toggle="tooltip" title="Increase Indent"></button>

				<select class="ql-align" data-toggle="tooltip" title="Text Align">
					<option selected></option>
					<option value="center"></option>
					<option value="right"></option>
					<option value="justify"></option>
				</select>

				<button class="ql-save" style="margin-top: -2px; outline: none;" data-toggle="tooltip" title="Save"><i class="fa fa-save"></i></button>
				<button class="ql-openData" data-flag="close" style="margin-top: -2px; outline: none;" data-toggle="tooltip" title="Open Data"><i class="fa fa-archive"></i></button>
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
					<p>+ {{ $v['jenis_dokumen'] }}</p>
					@foreach($v['isi'] as $k2 => $v2)
						<li>
							<a href="#" class="data-mention" data-value="{{ '@' . str_replace('_', '_', $v2) . '@' }}">{{ str_replace('_', '_', $v2) }}</a>
						</li>
					@endforeach
				@endforeach
			</ul>
		</div>
		<div class="row justify-content-center mt-5">
			<div class="col">
				<div id="editor" style="background-color: #fff; width: 210mm; min-height: 140mm; margin: 0 auto;">saya sudah</div>
			</div>
			{{-- <div class="col-sm-3 col-md-3">
				<ul class="nav nav-tabs">
					<li class="nav-item">
						<a href="#toolbarItem" class="nav-link active" data-toggle="tab" role="tab">Toolbar</a>
					</li>
					<li class="nav-item">
						<a href="#mentionItem" class="nav-link" data-toggle="tab" role="tab">Mention</a>
					</li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="toolbarItem" role="tabpanel">
					</div>
					<div class="tab-pane" id="mentionItem" role="tabpanel">
						mention
					</div>
				</div>
			</div> --}}
		</div>
	</div>
@stop

@push('scripts')  
	var listMention = {!! $list !!};
	window.editorUI.init();

	$(function() {
		$('[data-toggle="tooltip"]').tooltip();
	});
@endpush 
