@extends('templates.basic')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  
	.medium-editor-toolbar {
	  visibility: visible;
	}
@endpush  

@section('akta')
	active
@stop

@section('buat-template')
	active
@stop

@section('content')
	<div class="hidden-sm-down">
		@component('components.form', [ 
			'data_id'		=> $page_datas->id,
			'store_url' 	=> route('akta.template.store'), 
			'update_url' 	=> route('akta.template.update', ['id' => $page_datas->id]), 
			'class'			=> 'form-template mb-0  form'
		])
			<div class="row bg-faded action-bar">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<ul class="nav menu-content justify-content-start">
						<li class="nav-item">
							<span class="navbar-text">{{ isset($page_datas->id) ? $page_datas->datas['judul'] : '' }}</span>
						</li>
					</ul>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pr-0">
					<ul class="nav menu-content justify-content-end">
						<li class="nav-item">
							<a class="nav-link input-submit save-content" href="#"><i class="fa fa-save"></i> Simpan</a>
						</li>
						{{-- <li class="nav-item">
							<a class="nav-link save-as-content" href="#" data-toggle="modal" data-target="#form-title"><i class="fa fa-save"></i> Simpan Sebagai</a>
						</li> --}}
					</ul>
				</div>
			</div>
			<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
				{{-- <div id="page" class="col-xs-12 col-sm-12 col-md-12 col-lg-12 scrollable_panel subset-2menu">
					<div id="page-breaker" class="row page-breaker"></div>
					<div class="row justify-content-center mt-3">
						<div class="col-12">
							<div class="tab-content">
								<div class="tab-pane active" id="judul" role="tabpanel">
									<div class="row mt-3">
										<div class="col-6 mx-auto">
											<div class="card">
												<div class="card-block">
													<div class="form">
														<div class="form-group">
															<label>Judul Template</label>
															<input type="text" name="title" class="form-control" />
														</div>
														<div class="form-group pt-3 text-right">
															<a href="#" class="btn btn-primary btn-sm">Berikutnya</a>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="tab-pane" id="template" role="tabpanel">
									<div class="d-flex mx-auto">
										<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
											<textarea name="template" class="editor"></textarea>
										</div>
									</div>
								</div>
							</div>
							
						</div>
					</div>
				</div> --}}

				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 flex-last sidebar subset-2menu">
					<div class="panel">
						<h5>Informasi Variable Mention</h5>
						<div class="list-widgets">
							@php
							// dd($page_datas);
							@endphp
							@if (isset($page_datas->list_widgets))
								@php $i=0; @endphp
								@forelse ($page_datas->list_widgets as $k => $v)
									@if ($i <= 10)
										<p class="mt-2 mb-2" style="font-size: 14px;">
											{{ $v }} 
											<a class="float-right" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne"><i class="fa fa-angle-down mt-1"></i></a>
											<div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne">
												Anim pariatur cliche reprehenderit
											</div>
										</p>
									@endif
									@php $i++; @endphp
								@empty
								@endforelse
							@else
								<p>Tidak ada Fillable Mention</p>
							@endif
						</div>
						<div id="toolbarMedium">tes</div>
					</div>
				</div>
				<div id="page" class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 flex-start pl-0 scrollable_panel subset-2menu">
					<div id="page-breaker" class="row page-breaker"></div>
					<div id="l-margin" class="margin margin-v"></div>
					<div id="r-margin" class="margin margin-v"></div>
					<div id="h-margin"></div>
					<div class="row">
						<div class="d-flex justify-content-center mx-auto">
							<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
								<textarea name="template" class="editor">
									@if (!is_null($page_datas->id))
										@if (!empty($page_datas->datas['paragraf']))
											@forelse ($page_datas->datas['paragraf'] as $k => $v)
												{!! $v['konten'] !!}
											@empty
											@endforelse
										@endif
									@endif
								</textarea>
							</div>
						</div>
					</div>
				</div>
			</div>
		@endcomponent
	</div>
	<div class="hidden-md-up subset-menu">
		<div class="text-center" style="padding-top: 25vh;">
			<p>Silahkan akses melalui perangkat komputer untuk dapat menggunakan fitur ini.</p>
		</div>
	</div>
@stop

@push('scripts')
	var dataListWidgets = {!! json_encode($page_datas->list_widgets) !!};
	var url = "{{ (!is_null($page_datas->id)) ? route('akta.template.automatic.store', ['id' => $page_datas->id]) : route('akta.template.automatic.store', ['id' => null])  }}";
	var form = $('.form-template');
	window.editorUI.init(url, form);
	window.loadingAnimation.init();

	$('.input-submit').on('click', function(el) {
		el.preventDefault();
		$('form.form-template').submit();
	});


	//	functions
	/* Hotkeys */
	//var res = window.hotkey.init($('.editor'));	
@endpush 