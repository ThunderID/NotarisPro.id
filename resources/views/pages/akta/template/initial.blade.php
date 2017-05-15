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
	active
@stop

@section('buat-akta')
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
							<select name="jumlah_pihak" class="form-control c-select select2">
								<option>1</option>
								<option>2</option>
								<option>3</option>
								<option>4</option>
								<option>5</option>
								<option>6</option>
								<option>7</option>
								<option>8</option>
							</select>
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
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel pb-0 mx-auto scrollable_panel pl-3">
					<div class="form">
						<h4 class="title">Dokumen Kelengkapan Template Akta<br/>
							<small><small><small>Centang dokumen yang dibutuhkan untuk generate template akta</small></small></small>
						</h4>
						<div class="content-choice-doc-template ml-3"></div>
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
	window.callSelect2.init();

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
			
			$.ajax({
				url: '{{ route("akta.template.list.document") }}',
				method: 'GET',
				dataType: 'json',
				success: function(result) {
					$temp = $('.content-choice-doc-template');

					// pihak
					for (var i=1; i<=jumPihak; i++) {
						$temp.append('<h5 class="text-muted">Pihak ' +i+ '</h5>');
						$.each(result['pihak'], function(k, v) {
							input = $('<input type="checkbox" />');
							input.addClass('form-check-input');
							input.attr('name', v);
							$temp.append(input);
							$temp.append(v);
							$temp.append('<br>');
						});
						$temp.append('<br>');
					}

					// saksi
					$temp.append('<h5 class="text-muted">Saksi</h5>');
					$.each(result['saksi'], function(k, v) {
						input = $('<input type="checkbox" />');
						input.addClass('form-check-input');
						input.attr('name', v);
						$temp.append(input);
						$temp.append(v);
						$temp.append('<br>');
					});
					$temp.append('<br>');

					// objek
					$temp.append('<h5 class="text-muted">Objek</h5>');
					$.each(result['objek'], function(k, v) {
						input = $('<input type="checkbox" />');
						input.addClass('form-check-input');
						input.attr('name', v);
						$temp.append(input);
						$temp.append(v);
						$temp.append('<br>');
					});
					$temp.append('<br>');
				}
			});
		}

		// trigger event window resize to fix height content
		$(window).resize();
	});
@endpush 
