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
		background-color: rgba(2, 90, 165, 0.6);
		position: absolute;
	}
	a.choice-template .hover span {
		color: #fff !important;
		position: relative;
		top: 40%;
		padding: 5px 15px;
		//border: 1px solid #fff;
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
		// dd($page_datas);
	@endphp
	@component('components.form', [ 
			'data_id'		=> null,
			'store_url' 	=> route('akta.akta.store'), 
			'class'			=> 'mb-0'
		])
		<div id="list-template" class="mt-1" style="{{ is_null($page_datas->template_id) ? 'display: block;' : 'display: none;' }}">
			<div class="row align-items-center">
				<div class="col text-left">&nbsp;
				</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel m-0 pt-0 pb-0 scrollable_panel" style="height: 90%;">
					<div class="row">
						<div class="col-12">
							<h4 class="title ml-3">{{ $page_attributes->title }}</h4>
							<div class="form-group has-feedback pl-3 pr-3">
								<input type="text" class="search search-input form-control" placeholder="cari nama template">
								<span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
							</div>
						</div>
					</div>
					<div class="row p-3 list-card-template">
						@if (isset($page_datas->datas) && !is_null($page_datas->datas))
							@foreach ($page_datas->datas as $k => $v)
								<div class="col-md-4 mb-3">
									<div class="card">
										<a href="#" data-id="{{ $v['id'] }}" class="choice-template card-link text-muted">
											<div class="hover text h-100 w-100 text-center">
												<span>Pilih</span>
											</div>
											<div class="card-block">
												<h4 class="card-title text-center pb-3"><i class="fa fa-file-text fa-2x"></i></h4>
												<p class="card-text"><small class="search-list">{{ !is_null($v['judul']) ? $v['judul'] : '' }}</small></p>
											</div>
										</a>
										{{-- <a href="#" class="btn btn-primary btn-sm btn-block choice-template" data-id="{{ $v['id'] }}">Pilih</a> --}}
									</div>
								</div>
							@endforeach
						@endif
						<input type="hidden" name="template_id" class="template-id" value="{{ !is_null($page_datas->template_id) ? $page_datas->template_id : null }}">
					</div>
					{{-- <div class="clearfix">&nbsp;</div> --}}
					{{-- <div class="row">
						<div class="col-6">
							<a href="#information" class="btn btn-primary action-wizard" data-content="#list-template"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp; Sebelumnya</a>
						</div>
						<div class="col-6 text-right">
							<a href="#fillable" class="btn btn-primary action-wizard" data-content="#list-template">Berikutnya &nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
						</div>
					</div>
					<div class="clearfix">&nbsp;</div> --}}
				</div>
				<div class="col text-right">
					<a href="#fillable" class="btn btn-primary action-wizard" data-content="#list-template">Berikutnya &nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
				</div>
			</div>
		</div>
		<div id="fillable" style="{{ is_null($page_datas->template_id) ? 'display: none;' : 'display: block;' }} height: 90%;">
			<div class="row align-items-center">
				<div class="col text-left">
					@if (is_null($page_datas->template_id))
						<a href="#list-template" class="btn btn-primary action-wizard" data-content="#fillable"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp; Sebelumnya</a>
					@endif
				</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 mx-auto input_panel pb-0 scrollable_panel m-0 pt-0 pb-0 pl-3">
					<div class="form">
						<h4 class="title">Form Fillable Template</h4>
						<div class="content-fillable-template"></div>
					</div>
				</div>
				<div class="col text-right">
					<a href="#information" class="btn btn-primary action-wizard" data-content="#fillable">Berikutnya &nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
				</div>
			</div>
		</div>
		<div id="information" style="display: none;">
			<div class="row align-items-center">
				<div class="col text-left">
					<a href="#fillable" class="btn btn-primary action-wizard" data-content="#information"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp; Sebelumnya</a>
				</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel pb-0">
					<div class="form">
						<h4 class="title">Form Informasi Akta</h4>
						<div class="form-group mb-3 pb-3">
							<label>Judul Akta</label>
							<input type="text" name="judul" class="form-control required" placeholder="Judul dari Akta">
						</div>
						<div class="clearfix">&nbsp;</div>
						{{-- <div class="form-group text-right pb-3">
							<a href="#list-template" class="btn btn-primary action-wizard" data-content="#information">Berikutnya &nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
						</div> --}}
					</div>
				</div>
				<div class="col text-right">
					<button class="btn btn-primary" type="submit">
						<i class="fa fa-gears"></i> Generate Akta
					</button>
				</div>
			</div>
		</div>
	@endcomponent
@stop

@push('scripts')  
	/* functions */

	// equal height
	var eh = window.equalHeight;
	eh.target = $('.card-block');

	function alignHeight(){
		eh.do();	
	}

	function alignHeightReset(){
		eh.reset();
	}

	/* Handlers */
	$(document).ready(function(){
	    alignHeight();
	});
	$( window ).resize(function() {
		alignHeightReset();
	    alignHeight();
	});	


	searchList = searchList;

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
		if (contentTo === '#fillable') {
			template_id = $('.template-id').val() !== null ? $('.template-id').val() : null;
			$('.content-fillable-template').html('');

			$.ajax({
				url: '{{ route("akta.akta.list.mentionable") }}',
				method: 'GET',
				dataType: 'json',
				data: {template_id: template_id},
				success: function(result) {
					var tempGroup = '', i=0;
					$.each(result['data'], function(k, v) {
						label = v.substr(1);
						group = label.split('.');
						labelNew = label.replace(/_|\./g, ' ');
						tempForm = $('<div class="form-group"></div>');
						tempForm.append('<label>' + labelNew + '</label>');
						tempForm.append($('<input type="text" value="" />')
						.attr('name', 'mentionable['+ v +']').attr('class', 'form-control'));
						//tempForm.prepend('<h5>' + group[0] + '</h5>');

						$('.content-fillable-template').append(tempForm);
					});
				}
			});
		}

		// trigger event window resize to fix height content
		$(window).resize();
	});

	@if (!is_null($page_datas->template_id))
		$(document).ready (function() {
			template_id = $('.template-id').val() !== null ? $('.template-id').val() : null;
			$('.content-fillable-template').html('');

			$.ajax({
				url: '{{ route("akta.akta.list.mentionable") }}',
				method: 'GET',
				dataType: 'json',
				data: {template_id: template_id},
				success: function(result) {
					var tempGroup = '', i=0;
					$.each(result['data'], function(k, v) {
						label = v.substr(1);
						group = label.split('.');
						labelNew = label.replace(/_|\./g, ' ');
						tempForm = $('<div class="form-group"></div>');
						tempForm.append('<label>' + labelNew + '</label>');
						tempForm.append($('<input type="text" value="" />')
						.attr('name', 'mentionable['+ v +']').attr('class', 'form-control'));
						//tempForm.prepend('<h5>' + group[0] + '</h5>');

						$('.content-fillable-template').append(tempForm);
					});
				}
			});
		});
	@endif

	/**
	 * event click link class choice-template
	 */
	$('.choice-template').on('click', function(e) {
		e.preventDefault();

		id = $(this).data('id');
		$('.template-id').val(id);

		$('.list-card-template').find('.hover').css('display', 'none').removeClass('active');
		$('.list-card-template').find('span').css('border', '1px solid #fff').html('Pilih');

		if ($(this).hasClass('active')) {
			$(this).removeClass('active');
			$(this).find('.hover').css('display', 'none').removeClass('active');
			$(this).find('span').css('border', '1px solid #fff').html('Pilih');
		}
		else {
			$(this).addClass('active');
			$(this).find('.hover').css('display', 'block');
			$(this).find('span').html('<i class="fa fa-check"></i>').css('border', 0);
		}
	});

	/**
	 * event hover link class choice-template
	 */

	$('.choice-template').hover(function(){
		if (!$(this).hasClass('active')) {
			$(this).find('.hover').css('display', 'block');
		}
	}, function() {
		if (!$(this).hasClass('active')) {
			$(this).find('.hover').css('display', 'none');
		}
	});

	var selector = document.getElementsByClassName('datetime');
	var datetime = new Inputmask('datetime', {
		mask: "1-2-y h:s", 
		placeholder: "dd-mm-yyyy hh:mm",  
		separator: "-", 
		alias: "dd/mm/yyyy"
	});
	datetime.mask(selector);


	

@endpush 
