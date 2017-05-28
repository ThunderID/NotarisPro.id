@extends('templates.basic')

@push('styles')  
	body { 
		background-color: rgba(0, 0, 0, 0.075) !important; 
	}
	a.choice-template:hover .hover{
		display: block;
	}
	a.choice-template .hover {
		display: none;
		background-color: rgba(2, 90, 165, 0.95);
		position: absolute;
	}
	a.choice-template .hover span {
		color: #fff !important;
		position: relative;
		top: 40%;
		padding: 5px 15px;
		border: 1px solid #fff;
	}
@endpush  

@section('akta')
	{{-- active --}}
@stop

@section('template-akta')
	active
@stop

@section('content')
	@component('components.form', [ 
			'data_id'		=> null,
			'store_url' 	=> route('akta.template.store'), 
			'class'			=> 'mb-0'
		])
		<div class="row">
			<div class="col">&nbsp;</div>
			<div class="col-12 col-sm-10 col-md-6 col-xl-6 pl-0 pr-0">
				<ul class="nav nav-pills mt-3 mb-3">
					<li class="nav-item">
						<span data-info="#information" class="nav-link active">1. Informasi Template</span>
					</li>
					<li class="nav-item">
						<span data-info="#choice-doc-template" class="nav-link text-muted">2. Dokumen kelengkapan Template Akta</span>
					</li>
				</ul>	
			</div>
			<div class="col">&nbsp;</div>
		</div>
		<div id="information" style="display: block;">
			<div class="row align-items-center">
				<div class="col">&nbsp;</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel mb-0 pl-3 mt-0 pb-0 mx-auto" style="height: 510px; overflow-y: scroll;">
					<div class="form">
						<h4 class="title">Informasi Template</h4>
						<div class="form-group">
							<label>Judul</label>
							<input type="text" name="nama" class="form-control required set-focus" placeholder="Judul dari template">
						</div>
						<div class="form-group">
							<label>Deskripsi</label>
							<textarea name="deskripsi" class="form-control" cols="15" rows="6" placeholder="Deskripsi dari template"></textarea>
						</div>
						<div class="form-group">
							<label>Jumlah Pihak</label>
							<input type="text" name="jumlah_pihak" class="form-control mask-number-with-min text-left" placeholder="2">
						</div>
						<div class="form-group">
							<label>Jumlah Saksi</label>
							<input type="text" name="jumlah_saksi" class="form-control mask-number-with-min text-left" placeholder="2">
						</div>
					</div>
				</div>
				<div class="col text-right">
					<a href="#choice-doc-template" class="btn btn-primary action-wizard" data-content="#information">Berikutnya &nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
				</div>
			</div>
		</div>
		<div id="choice-doc-template" style="display: none;">
			<div class="row align-items-center">
				<div class="col">
					<a href="#information" class="btn btn-primary action-wizard" data-content="#choice-doc-template"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp; Sebelumnya</a>
				</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel mt-0 mb-0 pb-0 mx-auto scrollable_panel" style="height: 510px; overflow-y: scroll;">
					<div class="form ml-3">
						<h4 class="title mb-0 pb-0">Dokumen Kelengkapan Template Akta</h4>
						<small class="text-muted">Inputkan dokumen yang dibutuhkan untuk generate template akta</small>
						<div class="clearfix">&nbsp;</div>
						<div class="content-choice-doc-template">
							<div class="text-center pb-3 mb-3">
								<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
								<span class="sr-only">Loading...</span>
							</div>
						</div>
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>
				<div class="col text-right">
					<button class="btn btn-primary mr-3" type="submit">
						<i class="fa fa-gears"></i> Generate Template
					</button>
				</div>
			</div>
		</div>
	@endcomponent
@stop

@push('scripts')
	window.selectUI.init();
	window.formUI.setFocus();

	/**
	 * event button action wizard
	 */
	$('.action-wizard').on('click', function(e) {
		e.preventDefault();

		contentTo = $(this).attr('href');
		contentNow = $(this).data('content');

		// hide is current content to show current next
		$(contentNow).hide();
		$(contentTo).show();

		$('span[data-info="' +contentNow+ '"]').removeClass('active').addClass('text-muted');
		$('span[data-info="' +contentTo+ '"]').addClass('active').removeClass('text-muted');

		// check if fillable-mention
		if (contentTo === '#choice-doc-template') {
			jumPihak = $('[name="jumlah_pihak"]').val();
			jumSaksi = $('[name="jumlah_saksi"]').val();

			$('.content-choice-doc-template').html('');
			
			$.ajax({
				url: '{{ route("akta.template.list.document") }}',
				method: 'GET',
				dataType: 'json',
				success: function(result) {
					$temp = $('.content-choice-doc-template');

					// pihak
					for (var i=1; i<=jumPihak; i++) {
						$temp.append('<label>Pihak ' +i+ '</label>');
						selectElement = $('<select></select>');
						selectElement.addClass('form-control custom-select select-multiple mb-3');
						selectElement.attr('name', 'dokumen_pihak[' +i + '][]');
						selectElement.attr('multiple', 'multiple');
						selectElement.attr('placeholder', 'Pilih Dokumen Pihak '+ i).attr('data-placeholder', 'Pilih Dokumen Pihak '+ i);
						$.each(result['pihak'], function(k, v) {
							optionElement = $('<option></option>');
							optionElement.attr('value', v);
							optionElement.html(v.replace(/_/g, ' '));
							selectElement.append(optionElement);
						});
						$temp.append(selectElement);
						$temp.append('<div class="clearfix">&nbsp;</div>');
					}

					// saksi
					for (var i=1; i<=jumSaksi; i++) {
						$temp.append('<label>Saksi ' +i+ '</label>');
						selectElement = $('<select></select>');
						selectElement.addClass('form-control custom-select select-multiple mb-3');
						selectElement.attr('name', 'dokumen_saksi[' +i + '][]');
						selectElement.attr('multiple', 'multiple');
						selectElement.attr('placeholder', 'Pilih Dokumen Saksi').attr('data-placeholder', 'Pilih Dokumen Saksi');
						$.each(result['saksi'], function(k, v) {
							optionElement = $('<option></option>');
							optionElement.attr('value', v);
							optionElement.html(v.replace(/_/g, ' '));
							selectElement.append(optionElement);
						});
						$temp.append(selectElement);
						$temp.append('<div class="clearfix">&nbsp;</div>');
					}

					// objek
					$temp.append('<label>Objek</label>');
					selectElement = $('<select></select>');
					selectElement.addClass('form-control custom-select select-multiple mb-3');
					selectElement.attr('name', 'dokumen_objek[]');
					selectElement.attr('multiple', 'multiple');
					selectElement.attr('placeholder', 'Pilih Dokumen Objek').attr('data-placeholder', 'Pilih Dokumen Objek');
					$.each(result['objek'], function(k, v) {
						optionElement = $('<option></option>');
						optionElement.attr('value', v);
						optionElement.html(v.replace(/_/g, ' '));
						selectElement.append(optionElement);
					});
					$temp.append(selectElement);
					$temp.append('<div class="clearfix">&nbsp;</div>');

					window.selectUI.selectMultiple();
				}
			});
		}

		// trigger event window resize to fix height content
		$(window).resize();
	});

	// mask number with minimun value
	var number = new Inputmask('numeric', {
		mask: "9{1,5}",
		min: 2,
	});
	number.mask($('.mask-number-with-min'));
@endpush 
