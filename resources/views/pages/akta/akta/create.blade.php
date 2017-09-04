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
		padding: 1cm 1cm 2cm 5cm;
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
		top: 82px;
		bottom: 0;
		right: -300px;
		background-color: #fff;
		border-left: 2px solid #eee;
		height: calc(100vh - 82px);
		width: 300px;
		position: fixed;
		opacity: 0;
		z-index: 99;

		-webkit-transition: all 0.3s ease;
		-moz-transition: all 0.3s ease;
		-o-transition: all 0.3s ease;
		transition: all 0.3s ease;
	}
	.list-data-dokumen.open {
		right: 0;
		opacity: 1;
	}
	#arsip-item--one, #arsip-item--two {
		visibility: hidden;
		height: 0;
		-webkit-transition: all 0.3s ease;
		-moz-transition: all 0.3s ease;
		-o-transition: all 0.3s ease;
		transition: all 0.3s ease;
	}
	#arsip-item--one.active, #arsip-item--two.active {
		visibility: visible;
		height: 100%;
	}
@endpush  

@section('akta')
	active
@stop

@section('buat-akta')
	active
@stop

@php
	// dd($page_datas);
@endphp

@section('content')
	<div class="row" style="background-color: #fff;">
		<div class="col-md-9 col-lg-9">
			<div class="mt-2 mb-1">
				<i class="fa fa-file-text-o mr-3"></i> 
				<span class="label-judul-akta" data-flag="show" style="display: inline;">
					{{ (isset($page_datas->akta['id'])) ? $page_datas->akta['judul'] : $page_datas->judul_akta }}
					<a href="#" class="btn btn-default btn-sm text-faded">Ubah</a>
				</span>
				<form action="#" class="form-inline form-judul-akta" data-flag="hide" style="display: none;">	
					<input type="text" class="form-control input-judul-akta pl-0" style="border: 0px; padding: 0.28em 0.75em;" value="{{ (isset($page_datas->akta['id'])) ? $page_datas->akta['judul'] : $page_datas->judul_akta }}">
					<a href="#" class="btn btn-default btn-sm text-faded form-judul-akta-cancel">Batal</a>
					<a href="#" class="btn btn-default btn-sm form-judul-akta-ubah">Ubah</a>
				</form>
				<div class="loading-save alert p-1 text-center" style="display: none; font-size: 12px; position: absolute !important; top: 5px; right: 50% !important; left: 50% !important; width: 180px !important; "></div>
			</div>
		</div>
		<div class="col-md-3 col-lg-3 text-right">
			<a href="javascript:void(0);" data-toggle="modal" data-target="#SimpanDokumen" class="btn btn-default text-faded">
				<span aria-hidden="true" style="font-size: 20px;">&times;</span>
			</a>
		</div>
	</div>
	<div class="row">
		<div class="col pl-0 pr-0">
			<div id="toolbarPane" class="text-center">
				{{-- button file --}}
				<span class="ql-formats">
					<button class="ql-new ml-1" style="margin-top: -2px;" data-toggle="modal" data-target="#SimpanDokumen" data-url="" data-tooltip="tooltip" title="Buat Baru" data-animation="false"><i class="fa fa-file-o"></i></button>
					<button class="ql-save form-editor-akta-save" style="margin-top: -2px; outline: none;" data-tooltip="tooltip" data-url="{{ (Route::is('akta.akta.create') ? route('akta.akta.store') : route('akta.akta.update', $page_datas->akta['id'])) }}" title="Save" data-animation="false"><i class="fa fa-save"></i></button>
				</span>
				<span class="ql-formats">
					<button class="ql-bold" data-tooltip="tooltip" title="Bold" data-animation="false"></button>
					<button class="ql-italic" data-tooltip="tooltip" title="Italic" data-animation="false"></button>
					<button class="ql-underline mr-2" data-tooltip="tooltip" title="Underline" data-animation="false"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-script" value="sub" data-tooltip="tooltip" title="Subscript" data-animation="false"></button>
					<button class="ql-script mr-2" value="super" data-tooltip="tooltip" title="Superscript" data-animation="false"></button>
					<button class="ql-header" value="1" data-tooltip="tooltip" title="Header 1" data-animation="false"></button>
					<button class="ql-header mr-2" value="2" data-tooltip="tooltip" title="Header 2" data-animation="false"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-list" value="ordered" data-tooltip="tooltip" title="Numbering" data-animation="false"></button>
					<button class="ql-list mr-2" value="bullet" data-tooltip="tooltip" title="Bullet" data-animation="false"></button>
				</span>
				<span class="ql-formats">
					<select class="ql-align" data-tooltip="tooltip" title="Text Align" data-animation="false">
						<option selected></option>
						<option value="center"></option>
						<option value="right"></option>
						<option value="justify"></option>
					</select>
					<button class="ql-indent" value="-1" data-tooltip="tooltip" title="Decrease Indent" data-animation="false"></button>
					<button class="ql-indent mr-2" value="+1" data-tooltip="tooltip" title="Increase Indent" data-animation="false"></button>
				</span>
				<span class="ql-formats">
					<button class="ql-list-arsip" data-flag="close" style="margin-top: -3px; outline: none;" data-tooltip="tooltip" title="Daftar Arsip" data-animation="false"><i class="fa fa-archive"></i></button>
					@if (Route::is('akta.akta.edit'))
						<button class="ql-input-arsip" data-flag="close" style="margin-top: -3px; outline: none;" data-tooltip="tooltip" title="Isi Arsip" data-animation="false" data-toggle="modal" data-target="#isiDokumen">
							<i class="fa fa-file-text-o"></i>
						</button>
					@endif
				</span>
			</div>
		</div>
	</div>
	<div class="hidden-sm-down sidebar list-data-dokumen p-0" id="DataList">
		<div id="sidebar-header" class="pt-3 col-12" style="border-bottom: 1px solid #eee;">
			<div id="arsip" class="d-flex justify-content-start pr-2"> 
				<h5 class="pt-1 align-middle">Arsip Dokumen</h5>
				<a href="#" class="btn-close-arsip text-faded ml-auto align-middle" style="z-index: 999;">
					<span aria-hidden="true" style="font-size: 20px;">&times;</span>
				</a>
			</div>
			<div id="sub-arsip" class="justify-content-start pr-2" style="display: none !important;">
				<a href="#" class="btn-arsip-previous text-faded align-middle" style="margin-top: 2px; margin-left: -10px;">
					<i class="fa fa-chevron-left"></i>
				</a>
				<h5 class="pt-1 ml-2 align-middle">Pilih Kategori</h5>
				<a href="#" class="btn-close-arsip text-faded ml-auto align-middle">
					<span aria-hidden="true" style="font-size: 20px;">&times;</span>
				</a>
			</div>
		</div>
		<div id="sidebar-loader" class="col-12 pt-3 pb-2 loader">
			<h6 class="mb-0 show-before-load">
				<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;<b>Memuat</b>
			</h6>
			<h6 class="mb-0 show-before-save">
				<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;<b>Simpan</b>
			</h6>
			<h6 class="mb-0 show-on-error" style="display: none;">
				Tidak dapat mengambil data!<br><br><small>Pastikan Anda dapat terhubung dengan internet dan cobalah beberapa saat lagi. Bila masalah ini terus berlanjut, silahkan hubungi Costumer Service kami untuk mendapatkan bantuan.</small>
			</h6>
			<h6 class="pt-2 show-on-error" style="display: none;">
				<small>Kode Error: <span id="loader-error-code">500</span></small>
			</h6>
		</div>
		<div id="sidebar-content" class="hide-before-load" style="display: none; font-size: 13px !important;">
			<div id="add-arsip" class="mt-2 mb-1" style="display: none;">
				<a id="btn-add" class="btn-add text-capitalize" href="#" data-parent="#add-arsip" style="font-size: 13px;">
					<i class="fa fa-plus"></i> Tambah Arsip
				</a>
				<div id="form-add" class="form-add form-inline mb-3" data-url="{{ route('akta.mention.store') }}" style="font-size: 13px !important; display: none;">
					<p class="text-muted text-small text-capitalize mb-1">Tambah Arsip</p>
					<input name="arsip_dokumen" type="text" class="form-control form-control-sm" placeholder="data arsip" data-field="" style="width: 75%; font-size: 13px;">
						<a id="btn-cancel" href="#" class="btn btn-text btn-sm btn-cancel text-default p-1 ml-2" data-parent="#add-arsip" style="font-size: 13px !important;">
							<i class="fa fa-times"></i>
						</a>
						<a id="btn-save" href="#" class="btn btn-text btn-sm btn-save text-default p-1" style="font-size: 13px !important;" data-parent="#add-arsip" data-url="{{ route('akta.mention.store') }}">
							<i class="fa fa-save"></i>
						</a>
				</div>
			</div>
			<div id="list-arsip" class="list-unstyled mt-1" style="display: none;">
				<a id="parent-link" href="#" class="text-default text-capitalize"></a>
			</div>
			<div id="arsip-item--one" class="active"></div>
			<div id="arsip-item--two"></div>
		</div>
	</div>
	<div class="row justify-content-center mt-5" style="min-height: 146mm;">
		<div class="col">
			<div id="editor" class="editor form-paragraf-akta" style="background-color: #fff; width: 210mm; min-height: 120mm; margin: 0 auto; " data-url="{{ route('akta.akta.store.test') }}">
				@if (isset($page_datas->akta))
					@forelse ($page_datas->akta['paragraf'] as $k => $v)
						{!! $v['konten'] !!}
					@empty
					@endforelse
				@endif
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

	@component('components.modal', [
		'id' 		=> 'isiDokumen',
		'title'		=> 'Isi Dokumen',
		'large'		=> 'true',
		'settings'	=> [
			'modal_class'	=> '',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'false',
		]
	])
		<form id="save_dokumen" class="form-widgets form" action="{{ route('akta.akta.store') }}" onSubmit="showLoader();" method="GET">
			<fieldset class="from-group pb-2 pt-3">
				@if (Route::is('akta.akta.edit'))
					@forelse ($page_datas->akta['mentionable'] as $k => $v)
						<div class="form-group row">
							<label class="col-sm-5 col-form-label">{{ $k }}</label>
							<div class="col-sm-7">
								<input type="text" class="form-control" name="{{ $k }}" value="{{ $v }}">
							</div>
						</div>
					@empty
					@endforelse
				@endif
			</fieldset>
			<fieldset class="from-group pb-2 pt-3 text-right">
				<button type="button" class="btn btn-secondary btn-discard" data-dismiss="modal">Batal</button>
				<button type="button" class="btn btn-primary" data-save="true">Simpan</button>
			</fieldset>
		</form>		
	@endcomponent()
@stop

@push('scripts')  
	var arsipDokumen = {!! (isset($page_datas->dokumen_notaris)) ? json_encode($page_datas->dokumen_notaris) : '' !!}
	window.editorUI.init();
	modulShowArsipDokumen();

	$(document).on('click', '.btn-add', function(e) {
		e.preventDefault();
		let parentElement = $(this).attr('data-parent');

		$(parentElement).find('.form-add').show();
		$(this).hide();
	});

	$(document).on('click', '.btn-cancel', function(e) {
		e.preventDefault();
		let parentElement = $(this).attr('data-parent');

		$(parentElement).find('.form-add').hide();
		$(parentElement).find('input').val('');
		$(parentElement).find('.btn-add').show();
	});

	$(document).on('click', '.btn-save', function(e) {
		e.preventDefault();
		let url = $(this).attr('data-url');
		let ajaxArsip = window.ajax;
		let parentElement = $(this).attr('data-parent');
		let valueArsip = $(parentElement).find('input').val();
		let prefixArsip = $(parentElement).find('input').attr('data-prefix');

		$('.hide-before-load').fadeOut('fast', function() {
			$('.show-before-load').hide();
			$('.show-before-save').show();
			$('.loader').fadeIn();
		});

		if ((typeof (valueArsip) !== null) && (valueArsip !== '')) {
			let formData = new FormData();
			formData.append('mention', '@' + prefixArsip + valueArsip + '@');

			ajaxArsip.defineOnSuccess( function(respon) {
				$(document.getElementById('arsip-item--one')).empty();
				$(document.getElementById('arsip-item--two')).empty();
				modulShowArsipDokumen();
			});

			ajaxArsip.defineOnError(function(respon){
				$('.show-before-load').hide();
				$('.show-on-error').show();
				$(document.getElementById('loader-error-code')).text(respon.status);
			});

			ajaxArsip.post(url, formData);
		}
	})

	// event collapse show
	// to change icon on link collapse
	$(document).on('show.bs.collapse', '.collapse', function(e) {
		e.stopPropagation();
		elemId = e.currentTarget.id;
		// set icon
		$('a[href="#'+ elemId +'"]').find('i')
			.removeClass('fa-plus-square-o')
			.addClass('fa-minus-square-o');
	});

	// event collapse hide
	// to change icon on link collapse
	$(document).on('hide.bs.collapse', '.collapse', function(e) {
		e.stopPropagation();
		elemId = e.currentTarget.id;
		// set icon
		$('a[href="#'+ elemId +'"]').find('i')
			.removeClass('fa-minus-square-o')
			.addClass('fa-plus-square-o');
	});

	function modulShowArsipDokumen () {
		setArsipDokumen();
		setArsipPrefixDokumen();
	}

	// function to set (id & data attribute)
	// for form arsip
	function setFormArsip (element, parent) {
		element.attr('id', parent);
		element.find('.btn-add')
			.attr('data-parent', '#' + parent)
		element.find('.btn-cancel')
			.attr('data-parent', '#' + parent)
		element.find('.btn-save')
			.attr('data-parent', '#' + parent)
	}

	// function set arsip dokumen
	// get data from ajax
	function setArsipDokumen () {
		let urlArsip = "{{ route('akta.mention.index') }}";
		let ajaxArsip = window.ajax;

		// ajax respon 
		// status success dari server
		ajaxArsip.defineOnSuccess( function(respon) {
			let sidebarContent = $(document.getElementById('sidebar-content'));
			let itemOne = $(document.getElementById('arsip-item--one'));
			let itemTwo = $(document.getElementById('arsip-item--two'));
			let templateCollapse = $(document.getElementById('list-arsip'));
			let templateForm = $(document.getElementById('add-arsip'));

			var temp = [];
			
			if (typeof (arsipDokumen) != 'undefined') {
				tmpCollapseDefault = templateCollapse.clone(); 

				tmpCollapseDefault.attr('id', templateCollapse.attr('id') + '-default')
					.addClass('pl-3 mt-2 mb-2')
					.show();

				tmpCollapseDefault.find('a#parent-link')
					.attr('href', '#' + templateCollapse.attr('id') + '-notaris')
					.attr('data-toggle', 'collapse')
					.attr('data-animation', 'false')
					.attr('aria-expanded', 'false')
					.attr('aria-controls', templateCollapse.attr('id') + '-notaris')
					.append('<i class="fa fa-plus-square-o"></i> Notaris');

				var i = 0;
				tmpCollapseDefaultChild = templateCollapse.clone();
				tmpCollapseDefaultChild.attr('id', templateCollapse.attr('id') + '-notaris')
					.addClass('pl-3 mb-0')
					.show();
				$.map(arsipDokumen, function(value, index) {

					if (i < 1) {
						link = tmpCollapseDefaultChild.find('a#parent-link');
						link.removeClass('text-default');
					} else {
						link = $('<a class="text-capitalize"></a>');
					}

					link.attr('id', 'parent-link--default-' + index)
						.attr('href', '#')
						.attr('data-value', 'notaris.')
						.attr('data-item', index)
						.addClass('d-block arsip-mention')
						.append(index);

					tmpCollapseDefaultChild.append(link);
					tmpCollapseDefaultChild.addClass('collapse');
					tmpCollapseDefault.append(tmpCollapseDefaultChild);
					itemOne.append(tmpCollapseDefault);
					i++;
				});
				itemOne.append('<hr class="mt-1 mb-1">');
			}

			$.map(respon, function (value, index) {
				if (temp.indexOf(value.jenis_dokumen) == -1) {
					tmpForm = templateForm.clone();
					tmpCollapse = templateCollapse.clone();

					// set list collapse arsip
					// and link collapse
					tmpCollapse.attr('id', templateCollapse.attr('id') + '-parent')
						.addClass('pl-3 mb-0')
						.show();
					tmpCollapse.find('a#parent-link')
						.attr('href', '#' + templateCollapse.attr('id') + '-' + value.jenis_dokumen)
						.attr('data-toggle', 'collapse')
						.attr('data-animation', 'false')
						.attr('aria-expanded', 'false')
						.attr('aria-controls', templateCollapse.attr('id') + '-' + value.jenis_dokumen)
						.append('<i class="fa fa-plus-square-o"></i> ' + value.jenis_dokumen);
					
					// set form add arsip
					if (index < 1) {
						setFormArsip(tmpForm, templateForm.attr('id') + '-parent')
						tmpForm.show();
						tmpForm.find('input[name="arsip_dokumen"]')
							.attr('data-prefix', '');
						tmpCollapse.prepend(tmpForm);
					}

					// get data list from data json 
					// data arsip child (kepemilikan)
					tmpFormChild = templateForm.clone();
					tmpCollapseChild = templateCollapse.clone();
					// set form add arsip child
					setFormArsip(tmpFormChild, templateForm.attr('id') + '-' + value.jenis_dokumen)
					tmpFormChild.show();

					tmpFormChild.find('input[name="arsip_dokumen"]')
						.attr('data-prefix', value.jenis_dokumen + '.');
					tmpFormChild.find('a#btn-add')
						.append(' ' + value.jenis_dokumen);
					tmpFormChild.find('p')
						.append(' ' + value.jenis_dokumen);
					tmpCollapseChild.prepend(tmpFormChild);
					tmpCollapseChild.attr('id', templateCollapse.attr('id') + '-' + value.jenis_dokumen)
						.addClass('pl-3 mb-0')
						.show();

					if (value.kepemilikan.length >= 1) {
						$.map(value.kepemilikan, function(value2, index2) {

							if (index2 < 1) {
								link = tmpCollapseChild.find('a#parent-link');
							} else {
								link = $('<a class="text-default text-capitalize"></a>');
							}

							link.attr('id', 'parent-link--one-' + value2)
								.attr('href', '#' + templateCollapse.attr('id') + '-' + value2)
								.attr('data-toggle', 'collapse')
								.attr('data-animation', 'collapse')
								.attr('aria-expanded', 'false')
								.attr('aria-controls', templateCollapse.attr('id') + '-' + value2)
								.addClass('d-block')
								.append('<i class="fa fa-plus-square-o"></i> ' + value2);

							tmpCollapseChild.append(link);
							tmpCollapseChild.addClass('collapse');
							tmpCollapse.append(tmpCollapseChild);

							// get clone from template form
							// and set to variable form grand child
							tmpFormGrandChild = templateForm.clone();

							// set form add arsip grand child
							setFormArsip(tmpFormGrandChild, templateForm.attr('id') + '-' + value2)
							tmpFormGrandChild.show();
							tmpFormGrandChild.find('input[name="arsip_dokumen"]')
								.attr('data-prefix', value.jenis_dokumen + '.' + value2 + '.');
							tmpFormGrandChild.find('a#btn-add')
								.append(' ' + value2);
							tmpFormGrandChild.find('p')
								.append(' ' + value2);

							// set list collapse grand child
							// and link collapse grand child
							tmpCollapseGrandChild = $('<ul class="list-unstyled collapse"></ul>');
							tmpCollapseGrandChild.append(tmpFormGrandChild);
							tmpCollapseGrandChild.attr('id', templateCollapse.attr('id') + '-' + value2)
								.addClass('pl-3 mb-0 collapse');
	
							if (value.isi.length >= 1) {
								$.map(value.isi, function(value3, index3) {
									tmpCollapseGrandChild.append('<li><a href="#" class="dokumen-item" data-item="' + value.jenis_dokumen + '.' + value2 + '.' + value3 + '">' + value3 + '</a></li>');
								});	
							}

							tmpCollapseChild.append(tmpCollapseGrandChild);
						})
					} else {
						tmpCollapseChild.addClass('collapse');
						tmpCollapse.append(tmpCollapseChild);
					}
					itemOne.append(tmpCollapse);
				}
			});

			$('.loader').fadeOut('fast', function(){
				$('.hide-before-load').fadeIn();
			});
		});

		// ajax respon 
		// status error dari server
		ajaxArsip.defineOnError( function(respon) {
			$('.show-before-load').hide();
			$('.show-on-error').show();
			$(document.getElementById('loader-error-code')).text(respon.status);
		});

		ajaxArsip.get(urlArsip);
	}

	function setArsipPrefixDokumen () {
		let urlArsipPrefix = "{{ route('akta.mention_prefix.index') }}";
		let ajaxArsipPrefix = window.ajax;
		let sidebarContent = $(document.getElementById('sidebar-content'));
		let itemTwo = $(document.getElementById('arsip-item--two'));
		let templateCollapse = $(document.getElementById('list-arsip'));
		let templateForm = $(document.getElementById('add-arsip'));

		ajaxArsipPrefix.defineOnSuccess( function(respon) {
			$.map(respon, function (value, index) {
				var tmpCollapse = templateCollapse.clone();
				// set list collapse arsip
				// and link collapse
				tmpCollapse.attr('id', templateCollapse.attr('id') + '-parent')
					.addClass('pl-3 mb-0')
					.show();
				tmpCollapse.find('a#parent-link')
					.attr('href', '#' + templateCollapse.attr('id') + '-' + index)
					.attr('data-toggle', 'collapse')
					.attr('aria-expanded', 'false')
					.attr('data-animation', 'false')
					.attr('aria-controls', templateCollapse.attr('id') + '-' + index)
					.append('<i class="fa fa-plus-square-o"></i> ' + index);

				var tmpCollapseChild = templateCollapse.clone();
				tmpCollapseChild.attr('id', templateCollapse.attr('id') + '-' + index)
					.addClass('pl-3 mt-2 mb-1 collapse')
					.show();
				$.map(value.current, function(value2, index2) {
					if (index2 < 1) {
						link = tmpCollapseChild.find('a#parent-link');
						link.removeClass('text-default');
					} else {
						link = $('<a class="text-capitalize"></a>');
					}

					link.attr('id', 'parent-link--one-' + index + '-' + value2)
						.attr('href', '#')
						.attr('data-value', index + '.' + value2 + '.')
						.attr('data-item', '')
						.addClass('d-block arsip-mention')
						.append(index + ' ' + value2);

					tmpCollapseChild.append(link);
					tmpCollapse.append(tmpCollapseChild);
				});
				linkAdd = $('<a href="#"></a>');
				linkAdd.addClass('text-capitalize add-arsip-prefix')
					.attr('data-value', index + '.' + value.next)
					.attr('data-item', '')
					.append('<i class="fa fa-plus"></i> ' + index);
				tmpCollapseChild.prepend(linkAdd);
				tmpCollapse.append(tmpCollapseChild);
				itemTwo.append(tmpCollapse);
			});

			$('.loader').fadeOut('fast', function(){
				$('.hide-before-load').fadeIn();
			});
		});

		ajaxArsipPrefix.defineOnError( function(respon) {
			$('.show-before-load').hide();
			$('.show-on-error').show();
			$(document.getElementById('loader-error-code')).text(respon.status);
		})

		ajaxArsipPrefix.get(urlArsipPrefix);
	}

	$(document).on('click', '.add-arsip-prefix', function(e) {
		e.preventDefault();

		addArsipPrefixDokumen($(this));
		
		$('.loader').fadeOut('fast', function(){
			$('.hide-before-load').fadeIn();
		});
	});

	function addArsipPrefixDokumen (el) {
		let urlStoreArsipPrefix = "{{ route('akta.mention_prefix.store') }}";
		let ajaxArsipPrefix = window.ajax;
		let formData = new FormData();

		$('.hide-before-load').fadeOut('fast', function() {
			$('.show-before-load').hide();
			$('.show-before-save').show();
			$('.loader').fadeIn();
		});

		ajaxArsipPrefix.defineOnSuccess( function(respon) {
			setArsipPrefixDokumen();
		});

		ajaxArsipPrefix.defineOnError( function(respon) {
			$('.show-before-load').hide();
			$('.show-on-error').show();
			$(document.getElementById('loader-error-code')).text(respon.status);
		});

		formData.append('mention', '@' + el.attr('data-value') + '@');
		ajaxArsipPrefix.post(urlStoreArsipPrefix, formData);
		$(document.getElementById('arsip-item--two')).empty();
	}

	$(function() {
		$('[data-tooltip="tooltip"]').tooltip();
		$('button[disabled]').tooltip();
		$('.input-judul-akta').css('width', $('.label-judul-akta').width() + 25);
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
	
	$('.form-judul-akta-cancel').on('click', function(e) {
		e.preventDefault();

		toggle_visibility( $('.form-judul-akta') )
		toggle_visibility( $('.label-judul-akta') )
	});

	$(document).on('click', '.form-judul-akta-ubah', function(e) {
		e.preventDefault();
		let title = $('.input-judul-akta').val();

		$('.label-judul-akta').html(title);
		toggle_visibility( $('.form-judul-akta') )
		toggle_visibility( $('.label-judul-akta') )
	})
	
	function toggle_visibility (elem, properties) {
		if (elem.css('display') == 'none') {
			elem.css('display', (typeof properties !== 'undefined') ? properties : 'inline');
		} else {
			elem.css('display', 'none');
		}
	}
@endpush 
