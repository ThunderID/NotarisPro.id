@extends('templates.basic')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  
@endpush  

@section('akta')
	active
@stop

@section('data-akta')
	active
@stop

@section('content')
	
		<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				{{-- COMPONENT MENUBAR --}}
				<div class="row bg-faded">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin-left:-15px;">
						<ul class="nav menu-content justify-content-start">
							<li class="nav-item">
								<a class="nav-link" href="{{ route('akta.akta.show', ['id' => $page_datas->id]) }}"><i class="fa fa-angle-left"></i> &nbsp;Kembali</a>
							</li>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6" style="padding-right:0px;">
						<ul class="nav menu-content justify-content-end">
							<li class="nav-item">
								<span class="nav-link">Revisi Oleh : {{ $page_datas->datas['terbaru']['penulis']['nama'] }}</span>
							</li>	
							<li class="nav-item">
								<span id="revisi-ctr" class="nav-link"></span>
							</li>	
						</ul>
					</div>
				</div>
				{{-- END COMPONENT MENUBAR --}}
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scrollable_panel subset-2menu">
				<div id="page-breaker" class="row page-breaker"></div>
				<div class="row">
					<div class="d-flex justify-content-center mx-auto">
						<div class="form mt-3 mb-3 font-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
							<div class="form-group">
								<?php $revisi_ctr = 0; ?>
								@foreach($page_datas->datas['terbaru']['paragraf'] as $key => $value)
									@if($value['konten'] == $page_datas->datas['original']['paragraf'][$key]['konten'])
										{!!$value['konten']!!}
									@else
										<?php $revisi_ctr++; ?>
										<a href="javascript:void(0);" class="version-current" data-toggle="modal" data-target="#content_{{ $key }}" >
											<div>
												<i class="fa fa-history float-right" style="margin-top: 0.25em; margin-right: -1.25em;"></i>
												{!!$value['konten']!!}
											</div>
										</a>										
									@endif
								@endforeach
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	@foreach($page_datas->datas['terbaru']['paragraf'] as $key => $value)

		@if($value['konten'] != $page_datas->datas['original']['paragraf'][$key]['konten'])

			@component('components.modal', [
					'id'		=> 'content_' . $key,
					'title'		=> 'Detail Histori Revisi',
					'large'		=> true,
					'settings'	=> [
						'modal_class'	=> '',
						'hide_buttons'	=> 'true',
						'hide_title'	=> 'true',
					]
				])
				<div class="row mb-4">
					<div class="col-md-12">
						<h5>Revisi Sebelumnya</h5>
						<div style="max-height: 25%; border: 1px solid #eceeef;">
							<div style="background-color: white;padding-left: 25px; padding-right: 10px; padding-top: 10px;">
								<div class="form-group editor">	
									{!!$page_datas->datas['original']['paragraf'][$key]['konten']!!}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="row mb-4">
					<div class="col-md-12">
						<h5>Revisi Final</h5>
						<div style="max-height: 25%; border: 1px solid #eceeef;">
							<div style="background-color: white;padding-left: 25px; padding-right: 10px; padding-top: 10px;">
								<div class="form-group editor">	
									{!!$value['konten']!!}
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-primary" data-dismiss="modal">Tutup</button>	
				</div>										
			@endcomponent	
		@endif
	@endforeach				
@stop

@push('scripts')

	/* Udate Revisi Count */
	$(document).ready(function(){
		/* Adapter */
		var revisi_count = {{ $revisi_ctr }};
		$('#revisi-ctr').text('Jumlah Revisi : ' + revisi_count);
	});

@endpush 