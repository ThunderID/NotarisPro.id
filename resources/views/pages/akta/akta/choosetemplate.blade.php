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
		<div class="row">
			<div class="col">&nbsp;</div>
			<div class="col-12 col-sm-10 col-md-6 col-xl-6 pl-0 pr-0">
				<ul class="nav nav-pills mt-3 mb-3">
					<li class="nav-item">
						<span data-info="#list-template" class="nav-link {{ is_null($page_datas->template_id) ? 'active' : '' }}">1. Pilih Template</span>
					</li>
					<li class="nav-item">
						<span data-info="#information" class="nav-link {{ !is_null($page_datas->template_id) ? 'active' : 'text-muted' }}">2. Informasi Akta</span>
					</li>
					<li class="nav-item">
						<span data-info="#fillable" class="nav-link text-muted">3. Fillable Mention Template</span>
					</li>
				</ul>	
			</div>
			<div class="col">&nbsp;</div>
		</div>
		<div id="list-template" class="mt-1" style="{{ is_null($page_datas->template_id) ? 'display: block;' : 'display: none;' }}">
			<div class="row align-items-center">
				<div class="col text-left">&nbsp;
				</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel m-0 pt-0 pb-0 scrollable_panel" style="max-height: 510px; overflow-y: scroll;">
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
				</div>
				<div class="col text-right">
					<a href="#information" class="btn btn-primary action-wizard" data-content="#list-template">Berikutnya &nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
				</div>
			</div>
		</div>
		<div id="information" style="{{ is_null($page_datas->template_id) ? 'display: none;' : 'display: block;' }}">
			<div class="row align-items-center">
				<div class="col text-left">
					@if (is_null($page_datas->template_id))
						<a href="#list-template" class="btn btn-primary action-wizard" data-content="#information"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp; Sebelumnya</a>
					@endif
				</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel pb-0">
					<div class="form">
						<h4 class="title">Informasi Akta</h4>
						<div class="form-group mb-3 pb-3">
							<label>Judul Akta</label>
							<input type="text" name="judul" class="form-control required set-focus" placeholder="Judul dari Akta">
						</div>
						<div class="clearfix">&nbsp;</div>
					</div>
				</div>
				<div class="col text-right">
					<a href="#fillable" class="btn btn-primary action-wizard" data-content="#information">Berikutnya &nbsp;&nbsp;<i class="fa fa-chevron-circle-right"></i></a>
				</div>
			</div>
		</div>
		<div id="fillable" style="display: none; height: 80%;">
			<div class="row align-items-center">
				<div class="col text-left">
					<a href="#information" class="btn btn-primary action-wizard" data-content="#fillable"><i class="fa fa-chevron-circle-left"></i>&nbsp;&nbsp; Sebelumnya</a>
				</div>
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 mx-auto input_panel pb-0 scrollable_panel m-0 pt-0 pb-0 pl-3" style="max-height: 510px; overflow-y: scroll;">
					<div class="form">
						<h4 class="title">Fillable Mention Template</h4>
						<div class="content-fillable-template">
							<div class="text-center pb-3 mb-3">
								<i class="fa fa-spinner fa-pulse fa-2x fa-fw"></i>
								<span class="sr-only">Loading...</span>
							</div>
						</div>
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

		// info header active form-wizard
		$('span[data-info="' +contentNow+ '"]').removeClass('active').addClass('text-muted');
		$('span[data-info="' +contentTo+ '"]').addClass('active').removeClass('text-muted');

		// check if fillable-mention
		if (contentTo === '#fillable') {
			template_id = $('.template-id').val() !== null ? $('.template-id').val() : null;
			//$('.content-fillable-template').html('');

			callListMention(template_id);
		}

		// trigger event window resize to fix height content
		$(window).resize();
	});

	function callListMention(templateID) {
		$.ajax({
			url: '{{ route("akta.akta.list.mentionable") }}',
			method: 'GET',
			dataType: 'json',
			data: {template_id: templateID},
			success: function(result) {
				$('.content-fillable-template').html('');
				$.each(result.data, function(k, v) {
					tempForm = $('<div class="form-group pb-3" style="border-bottom: 1px solid #ccc; margin-bottom: 35px;"></div>');
					tempForm.append('<h5 class="mb-2 pb-2 text-capitalize">' +k.replace(/_/g, ' ')+ '</h5>');
					$.each(v, function (k2, v2) {
						linkCollapse = $('<a class="text-muted mb-0" data-toggle="collapse" href="#collapse-' +k+'-'+k2+ '" aria-expanded="true" aria-controls="collapse-' +k+'-'+k2+ '"></a>');
						linkCollapse.html(k2.replace(/_/g, ' '));
						linkCollapse.css('display', 'block');
						linkCollapse.append('<span class="float-right text-primary"><i class="fa fa-angle-down mt-1"></i></span>');
						tempForm.append(linkCollapse);
						divCollapse = $('<div id="collapse-' +k+'-'+k2+ '" class="collapse pt-3 pb-3 mb-2" role="tabpanel"></div>');
						$.each(v2, function (k3, v3) {
							tempTitle = v3.split('.');
							label = tempTitle[tempTitle.length - 1];
							divCollapse.append('<label class="text-capitalize">' +label.replace(/_/g, ' ')+ '</label>');
							divCollapse.append($('<input type="text" value="" />')
							.attr('name', 'mentionable['+ v3 +']').attr('class', 'form-control mb-3'));
						});
						tempForm.append(divCollapse);
					});

					$('.content-fillable-template').append(tempForm);
				});
			}
		});
	}

	@if (!is_null($page_datas->template_id))
		$(document).ready (function() {
			template_id = $('.template-id').val() !== null ? $('.template-id').val() : null;
			$('.content-fillable-template').html('');


			callListMention(template_id);
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

	var datetime = new Inputmask('datetime', {
		mask: "1-2-y h:s", 
		placeholder: "dd-mm-yyyy hh:mm",  
		separator: "-", 
		alias: "dd/mm/yyyy"
	});
	datetime.mask($('.mask-datetime'));


	

@endpush 
