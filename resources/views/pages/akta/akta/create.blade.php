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
	<div class="hidden-sm-down">
		<div id="DataList" style="
			display: none;
			position: fixed;
			right: 0;
			top: 0;
			bottom: 0;
			background-color: #fff;
			z-index: 99;
			border-left: 3px solid #eee;
			width: 250px;
			padding: 20px;
		">
			<ul class="list-unstyled">
				@foreach($page_datas->dokumen_lists as $k => $v)
					@foreach($v['isi'] as $k2 => $v2)
						<li>
							<a href="#" class="data-mention" data-value="{{ '@' . str_replace('_', '_', $v2) . '@' }}">{{ str_replace('_', '_', $v2) }}</a>
						</li>
					@endforeach
				@endforeach
			</ul>
		</div>
		<div class="row" style="padding-top: 15px;">
			<div class="col">
				<div id="toolbarPane" style="width: 210mm; margin: 0 auto;">
					<button class="ql-bold"></button>
					<button class="ql-italic"></button>
					<button class="ql-underline mr-2"></button>
					
					<button class="ql-script" value="sub"></button>
					<button class="ql-script mr-2" value="super"></button>

					<button class="ql-header" value="1"></button>
					<button class="ql-header mr-2" value="2"></button>

					<button class="ql-list" value="ordered"></button>
					<button class="ql-list mr-2" value="bullet"></button>

					<button class="ql-indent" value="-1"></button>
					<button class="ql-indent mr-2" value="+1"></button>

					<select class="ql-align">
						<option selected></option>
						<option value="center"></option>
						<option value="right"></option>
						<option value="justify"></option>
					</select>

					<button class="ql-openData" data-flag="close"><i class="fa fa-square"></i></button>
				</div>
			</div>
		</div>
		<div class="row justify-content-center">
			<div class="col">
				<div id="editor" style="background-color: #fff; width: 210mm; min-height: 97mm; margin: 0 auto;"></div>
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
@endpush 
