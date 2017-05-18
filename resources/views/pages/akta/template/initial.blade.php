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
		top: 45%;
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
		<div id="information" style="display: block;">
			<div class="row align-items-center">
				<div class="col">&nbsp;</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel pb-0 mx-auto">
					<div class="form">
						<h4 class="title">Informasi Template</h4>
						<div class="form-group">
							<label>Judul</label>
							<input type="text" name="nama" class="form-control required" placeholder="Judul dari template">
						</div>
						<div class="form-group">
							<label>Deskripsi</label>
							<textarea name="deskripsi" class="form-control" cols="15" rows="6" placeholder="Deskripsi dari template"></textarea>
						</div>
						<div class="form-group">
							<label>Jumlah Pihak</label>
							<input type="text" name="jumlah_pihak" class="form-control mask-number" placeholder="0">
						</div>
						<div class="form-group">
							<label>Jumlah Saksi</label>
							<input type="text" name="jumlah_saksi" class="form-control mask-number" placeholder="0">
						</div>
						<div class="clearfix">&nbsp;</div>
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
					<a href="#information" class="btn btn-primary action-wizard" data-content="#choice-doc-template">Sebelumnya &nbsp;&nbsp;<i class="fa fa-chevron-circle-left"></i></a>
				</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel pb-0 mx-auto scrollable_panel">
					<div class="form ml-3">
						<h4 class="title mb-0 pb-0">Dokumen Kelengkapan Template Akta</h4>
						<small>Centang dokumen yang dibutuhkan untuk generate template akta</small>
						<div class="clearfix">&nbsp;</div>
						<div class="content-choice-doc-template"></div>
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

	var number = new Inputmask({
		mask: "9{1,5}", 
	});
	number.mask($('.mask-number'));
@endpush 
