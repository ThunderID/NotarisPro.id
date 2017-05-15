@extends('templates.basic')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  
	body {background-color: rgba(0, 0, 0, 0.075) !important;}
	.editor { border: 2px dashed #ececec; }
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
					</ul>
				</div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 flex-last sidebar sidebar-right subset-2menu">
					<div class="panel">
						<h5>Toolbar</h5>
						<div id="toolbarMedium" style="position: relative; margin-bottom: 180px;">&nbsp;</div>
						<h5>Informasi Variable Mention</h5>
						<div class="list-widgets">
							@if (isset($page_datas->list_widgets))
								{{-- objek --}}
								@forelse ($page_datas->list_widgets as $k => $v)
									<div class="mt-1 mb-0 p-2 text-capitalize" style="font-size: 14px;">
										{{ str_replace('_', ' ', $k) }}
										<a class="float-right" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $k }}" aria-expanded="true" aria-controls="collapse-{{ $k }}"><i class="fa fa-angle-down mt-1"></i></a>
										<div id="collapse-{{ $k }}" class="collapse ml-2" role="tabpanel" aria-labelledby="headingOne">
											@foreach ($v as $k2 => $v2)
												@foreach ($v2 as $k3 => $v3)
													@php
														{{-- dd($page_datas->list_widgets); --}}
														if ($k == 'objek')
														{
															$sub_title 	= substr($v3, 1);
															$temp 		= explode('.', $sub_title);
															$title 		= $temp[0];
														}
														else if ($k == 'saksi')
														{
															$sub_title 	= substr($v3, 1);
															$temp 		= explode('.', $sub_title);
															$title 		= $temp[0];
														}
														else
														{
															$sub_title 	= substr($v3, 1);
															$temp 		= explode('.', $sub_title);
															$title 		= $temp[2];
														}
													@endphp

													@if (count($temp) > 2)
														@if (array_first($v2) == $v3)
															<div class="mt-1 mb-1 text-lowercase" style="font-size: 12px;">
																<a class="text-muted" data-toggle="collapse" data-parent="#accordion" href="#collapse-{{ $temp[0].'-'.$temp[1].'-'.$temp[2] }}" aria-expanded="true" aria-controls="collapse-{{ $temp[0].'-'.$temp[1].'-'.$temp[2] }}" style="text-decoration: none;">
																	{{ str_replace('_', ' ', $title) }}
																	<span class="float-right text-primary">
																		<i class="fa fa-angle-down mt-1"></i>
																	</span>
																</a>
																<div id="collapse-{{ $temp[0].'-'.$temp[1].'-'.$temp[2] }}" class="collapse ml-2" role="tabpanel" aria-labelledby="headingOne">
														@elseif (array_last($v2) == $v3)
																</div>
															</div>
														@else
															<p class="mt-1 mb-1 text-lowercase" style="font-size: 12px; word-break: break-word; width: 75%;">{{ $v3 }}</p>
														@endif

													@else
														<p class="mt-1 mb-1 text-lowercase" style="font-size: 12px; word-break: break-word; width: 75%;">{{ $v3 }}</p>	
													@endif
												@endforeach
											@endforeach
										</div>
									</div>
								@empty
								@endforelse
							@else
								<p>Tidak ada Fillable Mention</p>
							@endif
						</div>
					</div>
				</div>
				<div id="page" class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 flex-start pl-0 scrollable_panel subset-2menu">
					{{-- <div id="page-breaker" class="row page-breaker"></div>
					<div id="l-margin" class="margin margin-v"></div>
					<div id="r-margin" class="margin margin-v"></div>
					<div id="h-margin"></div> --}}
					<div class="row">
						<div class="d-flex justify-content-center mx-auto">
							<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
								<textarea name="template" class="editor" style="border: 2px dashed #ececec;">
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
	var dataListWidgets = {!! json_encode(array_flatten($page_datas->list_widgets)) !!};
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