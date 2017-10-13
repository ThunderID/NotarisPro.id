@push ('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet" />	
@endpush

@push ('main')
	<form action="#" class="akta-create form">
		@include ('apps.pages.akta.components.create.nav')
		<div class="row h-100">
			<div class="col-12">
				<div id="toolbar-editor" class="text-center bg-white p-0">
					{{-- <span class="ql-formats p-2 bg-secondary text-light mr-2 float-left">
						<strong>{{ str_replace('_', ' ', ucwords($akta['jenis'])) }}</strong>
					</span> --}}
					<span class="ql-formats">
						{{-- <button class="ql-new ml-1" style="margin-top: -2px;" data-toggle="modal" data-target="#SimpanDokumen" data-tooltip="tooltip" title="Buat Baru" data-animation="false" data-action-button="new" data-url="{{ route('akta.akta.choooseTemplate') }}"><i class="fa fa-file-o"></i></button> --}}
						<button class="ql-save form-editor-akta-save" style="margin-top: -2px; outline: none;" data-tooltip="tooltip" data-url="{{ (Route::is('akta.akta.create') ? route('akta.akta.store') : route('akta.akta.update', $page_datas->akta['id'])) }}" title="Save" data-animation="false"><i class="fa fa-save"></i></button>
					</span>
					<span class="ql-formats p-2">
						<button class="ql-bold" data-tooltip="tooltip" title="Bold" data-animation="false"></button>
						<button class="ql-italic" data-tooltip="tooltip" title="Italic" data-animation="false"></button>
						<button class="ql-underline mr-2" data-tooltip="tooltip" title="Underline" data-animation="false"></button>
					</span>
					<span class="ql-formats p-2">
						<button class="ql-script" value="sub" data-tooltip="tooltip" title="Subscript" data-animation="false"></button>
						<button class="ql-script mr-2" value="super" data-tooltip="tooltip" title="Superscript" data-animation="false"></button>
						<button class="ql-header" value="1" data-tooltip="tooltip" title="Header 1" data-animation="false"></button>
						<button class="ql-header mr-2" value="2" data-tooltip="tooltip" title="Header 2" data-animation="false"></button>
					</span>
					<span class="ql-formats p-2">
						<button class="ql-list" value="ordered" data-tooltip="tooltip" title="Numbering" data-animation="false"></button>
						<button class="ql-list mr-2" value="bullet" data-tooltip="tooltip" title="Bullet" data-animation="false"></button>
					</span>
					<span class="ql-formats p-2">
						<select class="ql-align" data-tooltip="tooltip" title="Text Align" data-animation="false">
							<option selected></option>
							<option value="center"></option>
							<option value="right"></option>
							<option value="justify"></option>
						</select>
						<button class="ql-indent" value="-1" data-tooltip="tooltip" title="Decrease Indent" data-animation="false"></button>
						<button class="ql-indent mr-2" value="+1" data-tooltip="tooltip" title="Increase Indent" data-animation="false"></button>
					</span>
					<span class="ql-formats p-2 float-right">
						<a href="#" class="text-secondary align-items-middle"><i class="fa fa-chevron-left"></i> data dokumen</a>
					</span>
				</div>
					@isset ($akta['pemilik'])
						@foreach ($akta['pemilik'] as $k => $v)
							{!! Form::hidden('pemilik['. $k .'][id]', $v['id']) !!}
							{!! Form::hidden('pemilik['. $k .'][nama]', $v['nama']) !!}
						@endforeach
					@endisset
					<div id="editor" class="editor bg-white" data-url="{{ Route::is('akta.akta.create') ? route('akta.akta.ajax.store') : route('akta.akta.update.ajax', ['id' => $page_datas->akta['id']]) }}"></div>
				</div>
			</div>
		</form>
@endpush

@push ('styles')
	<style>
		body {
			background-color: rgba(0, 0, 0, 0.075) !important;
		}
		.editor {
			/*min-height: 29.7cm;*/
			/*border: 2px dashed #ececec;*/
			font-family: 'Inconsolata', monospace;
			font-size: 14px;
			/*padding: 1cm 1cm 2cm 5cm;*/
			border: 0 !important;
		}
		.ql-toolbar {
			border-top: 1px solid #eee !important;
			border-bottom: 1px solid #eee !important;
			border-right: 0 !important;
			border-left: 0 !important;
		}
		p.navbar-brand {
			margin-left: 2rem !important;
		}
		p.navbar-brand i{
			position: absolute; 
			margin-left: -30px; 
			font-size: 32px;
		}
		p.navbar-brand .badge {
			position: absolute;
			left: 0;
			margin-left: 3.7rem;
			margin-top: 26px;
			font-size: 11px;
			padding: 2px;
			padding-left: 8px;
			padding-right: 8px;
		}
	</style>
@endpush

{{-- use tag <script></script> --}}
@push ('scripts')
	<script type="text/javascript">
		window.editorUI.init();
	</script>
@endpush