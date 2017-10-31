@push ('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet" />	
@endpush

@push ('main')
	<form action="#" class="akta-create form mx-auto" style="width: 21cm;">
		@include ('apps.pages.akta.components.create.nav')
		<div class="row h-100">
			<div class="hidden-sm-down sidebar list-data-dokumen p-0" id="DataList">
				<div id="sidebar-header" class="pt-3 col-12" style="border-bottom: 1px solid #eee;">
					<div id="arsip" class="d-flex justify-content-start pr-2"> 
						<h5 class="pt-1 align-middle">Data Dokumen</h5>
						<a href="#" class="close-data-dokumen text-faded ml-auto align-middle" style="z-index: 999;">
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
					<h6 class="mb-0 show-on-error" style="display: none;">
						Tidak dapat mengambil data!<br><br><small>Pastikan Anda dapat terhubung dengan internet dan cobalah beberapa saat lagi. Bila masalah ini terus berlanjut, silahkan hubungi Costumer Service kami untuk mendapatkan bantuan.</small>
					</h6>
					<h6 class="pt-2 show-on-error" style="display: none;">
						<small>Kode Error: <span id="loader-error-code">500</span></small>
					</h6>
				</div>
				<div id="sidebar-content" class="hide-before-load" style="display: none; font-size: 13px !important; height: calc(100vh - 50px); overflow-y: scroll;">
					<div id="add-arsip" class="mt-2 mb-1" style="display: none;">
						<a id="btn-add" class="btn-add text-capitalize" href="#" data-parent="#add-arsip" style="font-size: 13px;">
							<i class="fa fa-plus"></i> Tambah Arsip
						</a>
						<div id="form-add" class="form-add form-inline mb-3" data-url="{{ route('arsip.ajax.store') }}" style="font-size: 13px !important; display: none;">
							<p class="text-muted text-small text-capitalize mb-1">Tambah Arsip</p>
							<input name="arsip_dokumen" type="text" class="form-control form-control-sm" placeholder="data arsip" data-field="" style="width: 75%; font-size: 13px;">
								<a id="btn-cancel" href="#" class="btn btn-text btn-sm btn-cancel text-default p-1 ml-2" data-parent="#add-arsip" style="font-size: 13px !important;">
									<i class="fa fa-times"></i>
								</a>
								<a id="btn-save" href="#" class="btn btn-text btn-sm btn-save text-default p-1" style="font-size: 13px !important;" data-parent="#add-arsip" data-url="{{ route('arsip.ajax.store') }}">
									<i class="fa fa-save"></i>
								</a>
						</div>
					</div>
					<div id="list-arsip" class="d-none">
						<a id="parent-link" href="#" class="text-capitalize"></a>
					</div>
					<div id="arsip-item--one" class="active">
						<div class="list-unstyled pl-2 mt-2 mb-2">
							<a href="#" class="text-capitalize btn btn-link btn-sm" data-toggle="modal" data-target="#modal-data-dokumen"><i class="fa fa-plus-circle"></i> Data</a>
						</div>
					</div>
					<div id="arsip-item--two"></div>
				</div>
			</div>
			<div class="col-12">
				<div id="toolbar-editor" class="text-center bg-white p-0">
					<span class="ql-formats">
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
						<a href="#" class="text-secondary align-items-middle open-data-dokumen" data-flag="close"><i class="fa fa-chevron-left"></i> data dokumen</a>
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

	@component ('bootstrap.modal', [
		'id' 	=> 'modal-data-dokumen',
		'size'	=> 'w-75'
	])

	@slot ('title')
		tambah dokumen
	@endslot

	@slot ('body')
		<div class="form">
			<div class="form-group row">
				<div class="col-12">
					<label>Nama Pemilik</label>
					{!! Form::text('nama', null, ['class' => 'form-control mb-2', 'placeholder' => 'nama pemilik']) !!}
				</div>
			</div>
			<div class="form-group row">
				<div class="col-12">
					<label>Jenis</label>
					{!! Form::select('jenis', ['ktp' => 'ktp', ], null, ['class' => 'form-control custom-select mb-2']) !!}
				</div>
			</div>
			<div class="row mb-2">
				<div class="col-12">
					<p class="text-capitalize mb-3">Isi dokumen</p>
					<div id="content-dokumen">
						@isset ($akta['dokumen']['ktp'])
							@foreach ($akta['dokumen']['ktp'] as $k => $v)
								<div class="form-group row mb-1">
									<div class="col-4">
										{!! Form::bsText(null, 'field['. $v .']', $v, ['class' => 'form-control', 'placeholder' => 'nama dokumen']) !!}
									</div>
									<div class="col-8">
										{!! Form::bsText(null, 'value['. $v .']', null, ['class' => 'form-control', 'placeholder' => 'isi dokumen']) !!}
									</div>
								</div>
							@endforeach
						@endisset
					</div>
					<a href="#" class="btn btn-default btn-sm btn-add-isi-dokumen" data-template-clone="#item-dokumen-clone" data-content-clone="#content-dokumen">Tambah dokumen</a>
					<div class="form-group row mb-1" id="item-dokumen-clone" style="display: none;">
						<div class="col-4">
							{!! Form::bsText(null, 'field', null, ['class' => 'form-control', 'placeholder' => 'nama dokumen']) !!}
						</div>
						<div class="col-8">
							{!! Form::bsText(null, 'value', null, ['class' => 'form-control', 'placeholder' => 'isi dokumen']) !!}
						</div>
					</div>
				</div>
			</div>
		</div>
	@endslot

	@slot ('footer')
		<a href="#" class="btn btn-default" data-dismiss="modal">Batal</a>
		<a href="#" class="btn btn-primary">Simpan</a>
	@endslot
	
	@endcomponent
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
		.list-group-item:first-child, .list-group-item:last-child {
			border-radius: 0;
		}
		.list-data-dokumen {
			top: 0;
			bottom: 0;
			right: -300px;
			background-color: #fff;
			border-left: 2px solid #eee;
			height: 100vh;
			width: 300px;
			position: fixed;
			opacity: 0;
			z-index: 99;

			-webkit-transition: all 0.5s ease;
			-moz-transition: all 0.5s ease;
			-o-transition: all 0.5s ease;
			transition: all 0.5s ease;
		}
		.list-data-dokumen.open {
			right: 0px;
			opacity: 1;
		}
		#arsip-item--one, #arsip-item--two {
			visibility: hidden;
			height: 0;
			-webkit-transition: all 0.5s ease;
			-moz-transition: all 0.5s ease;
			-o-transition: all 0.5s ease;
			transition: all 0.5s ease;
		}
		#arsip-item--one.active, #arsip-item--two.active {
			visibility: visible;
			height: 100%;
		}
		button {
			outline: none !important;
		}
		.modal#modal-data-dokumen .modal-dialog {
			max-width: 560px !important;
		}

	</style>
@endpush

{{-- use tag <script></script> --}}
@push ('scripts')
	<script type="text/javascript">
		window.editorUI.init();

		arsipUrlIndex = '{{ route('arsip.index') }}';
		arsipAjx = window.ajax;

		arsipAjx.defineOnSuccess(function(respon){
			let section = $(document.getElementById('arsip-item--one'));
			let itemOne = $('<div></div>');
			let itemTwo = $(document.getElementById('arsip-item--two'));
			let templateCollapse = $(document.getElementById('list-arsip'));
			let templateForm = $(document.getElementById('add-arsip'));
			var temp = [];

			itemOne.addClass('list-group');
			$.map(respon, function (value, index) {
				tmpForm = templateForm.clone();
				tmpCollapse = templateCollapse.clone();
				tmpCollapse.attr('id', templateCollapse.attr('id') + '-parent')
					.addClass('mb-0 list-group-item border-left-0 border-right-0 border-top-0 pt-2 pb-2')
					.removeClass('d-none');


				tmpCollapse.find('a#parent-link')
					.attr('href', '#arsip--' + value._id)
					.attr('data-toggle', 'collapse')
					.attr('data-animation', 'false')
					.attr('aria-expanded', 'false')
					.addClass('d-flex d-flex align-items-center border-0 text-secondary')
					.append('<strong>' + value.pemilik.nama + '</strong>')
					.append('<i class="fa fa-chevron-circle-right ml-auto"></i>')
					.css('text-decoration', 'none');
				// tmpCollapse.append('&nbsp;( <a href="#" class="text-primary"><i class="fa fa-plus-circle"></i> dokumen</a> )');

				if (index == 0) {
					tmpCollapse.removeClass('border-top-0');
				}
				// set list collapse arsip
				// and link collapse
				collapseChild = $('<div></div>');
				collapseChild.attr('id', 'arsip--' + value._id)
					.addClass('collapse mb-2 pt-2')
					.css('border-top', '4px solid #eee');

				tmpCollapseChild = templateCollapse.children().clone();

				$.map(value.lists, function(value2, index2) {
					arsipDataAjx = window.ajax;

					if (index2 < 1) {
						link = tmpCollapseChild;
					} else {
						link = $('<a href="#" id="parent-link" class="text-default text-capitalize"></a>');
					}

					link.append('<i class="fa fa-plus-square-o"></i> ' + value2)
						.append('<button class="btn-link edit-dokumen" data-toggle="modal" data-target="#modal-data-dokumen" data-id-pemilik="'+ value._id +' data-dokumen-jenis="' + value2 + '">ubah</button>')
						.attr('id', 'parent-link--one--' + value2)
						.attr('data-toggle', 'collapse')
						.attr('data-expand', 'false')
						.addClass('d-block pt-1 pb-1 pl-1 arsip-dokumen-collapse text-dark')
						.attr('href', '#' + templateCollapse.attr('id') + '--' + value._id + '--' + index2)
						.attr('data-url', arsipUrlIndex + '/' + value._id + '?jenis=' + value2)
						.css('text-decoration', 'none');
					collapseChild.append(link);

					tmpCollapseGrandChild = $('<ul class="list-unstyled collapse pl-2 mb-2"></ul>');
					tmpCollapseGrandChild.attr('id', templateCollapse.attr('id') + '--' + value._id + '--' + index2)
						.addClass('ml-2');

					collapseChild.append(tmpCollapseGrandChild);
				});
				tmpCollapse.append(collapseChild);
				itemOne.append(tmpCollapse);
			});

			section.append(itemOne);

			$('.loader').hide('fast');
			$('.hide-before-load').show();
		});

		arsipAjx.defineOnError(function(respon){
			// console.log(respon);
		});

		arsipAjx.get(arsipUrlIndex);

		$(document).on('click', '.arsip-dokumen-collapse', function(e){
			e.preventDefault();

			selector = $(this).attr('href');
			urlDokumen = $(this).attr('data-url');
			ajxDokumen = window.ajax;

			$(selector).html('<i class="fa fa-circle-o-notch fa-spin"></i>');

			console.log($(this));

			ajxDokumen.defineOnSuccess(function(respon){
				setTimeout(function(){
					$(selector).html('');
					var iteration = 0;
					$.map(respon, function(value, index){
						field = index.split('.');
						field = field[field.length - 1].replace('@', '').replace('_', ' ');
						if (iteration == 0) {
							$(selector).append('<li class="border border-left-0 border-right-0 d-flex ">' + field + '  <a href="#" class="data-dokumen ml-auto" data-dokumen-item="' + index + '">' + value + '</a></li>');
						} else {
							$(selector).append('<li class="border border-left-0 border-right-0 border-top-0 d-flex ">' + field + '  <a href="#" class="data-dokumen ml-auto" data-dokumen-item="' + index + '">' + value + '</a></li>');
						}
						iteration++;
					});
				}, '500');
			});

			ajxDokumen.defineOnError(function(respon2){
			});
			ajxDokumen.get(urlDokumen);
		});


		$('.open-data-dokumen').on('click', function(e){
			e.preventDefault();

			let flag = $(this).attr('data-flag');

			if (flag == 'close') {
				$('#DataList').addClass('open');
				$(this).attr('data-flag', 'open')
					.addClass('ql-active');
			} else {
				$('#DataList').removeClass('open');
				$(this).attr('data-flag', 'close')
					.removeClass('ql-active');
			}
		});

		$('.close-data-dokumen').on('click', function(e){
			e.preventDefault();
			$('.open-data-dokumen').trigger('click');
		});

		$(document).on('click', '.btn-change-title', function(e){
			e.preventDefault();

			$(this).closest('ul').hide();
			$('.judul-akta').hide();
			$('.input-judul-akta').show();
		});

		$('.input-judul-akta').find('input').on('change', function(e){
			$('.judul-akta').html($(this).val());
		});

		$('.btn-cancel-change-title, .btn-save-change-title').on('click', function(e){
			e.preventDefault();

			$(this).parent().hide();
			$('.judul-akta').show();
			$('.btn-change-title').closest('ul').show();
		});

		// event collapse show
		// to change icon on link collapse
		$(document).on('show.bs.collapse', '.collapse', function(e) {
			e.stopPropagation();
			elemId = e.currentTarget.id;
			// set icon
			// fa fa-plus-square-o
			if ($('a[href="#'+ elemId +'"] > i').hasClass('fa-chevron-circle-right')) {
				$('a[href="#'+ elemId +'"] > i').removeClass('fa-chevron-circle-right')
					.addClass('fa-chevron-circle-down');
			} else {
				$('a[href="#'+ elemId +'"] > i').removeClass('fa-plus-square-o')
					.addClass('fa-minus-square-o');
			}
		});

		// event collapse hide
		// to change icon on link collapse
		$(document).on('hide.bs.collapse', '.collapse', function(e) {
			e.stopPropagation();
			elemId = e.currentTarget.id;
			// set icon
			if ($('a[href="#'+ elemId +'"] > i').hasClass('fa-chevron-circle-down')) {
				$('a[href="#'+ elemId +'"] > i').removeClass('fa-chevron-circle-down')
					.addClass('fa-chevron-circle-right');
			} else {
				$('a[href="#'+ elemId +'"] > i').removeClass('fa-minus-square-o')
					.addClass('fa-plus-square-o');
			}
		});

		$(document).on('click', 'button.edit-dokumen', function(e){
			e.stopPropagation();
			console.log('tes');
		})

		$('.btn-add-isi-dokumen').on('click', function(e){
			e.preventDefault();

			selectorTemplateClone = $(this).attr('data-template-clone');
			selectorContentClone = $(this).attr('data-content-clone');

			addCloneForm(selectorTemplateClone, selectorContentClone);
		});

		function addCloneForm (template, content){
			templateClone = $(template).clone();
			templateClone.show();

			$(content).append(templateClone);
		}
	</script>
@endpush