@extends('templates.basic')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet" />
@endpush

@push('styles')  
	body { background-color: rgba(0, 0, 0, 0.075) !important; }
	.editor {
		min-height: 29.7cm;
		border: 2px dashed #ececec;
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
	<div class="hidden-sm-down">
		@component('components.form', [ 
			'data_id'		=> $page_datas->akta_id,
			'store_url' 	=> route('akta.akta.store', ['template_id' => $page_datas->template_id]), 
			'update_url' 	=> route('akta.akta.update', ['id' => $page_datas->akta_id]), 
			'class'			=> 'form-akta mb-0'
		])
			<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
				@include('components.submenu', [
					'title' 		=> isset($page_datas->id) ? $page_datas->datas['judul'] : '',
					'back_route'	=> route('akta.akta.show',['id' => $page_datas->akta_id]),
					'menus' 		=> [
						[
							"title" 			=> "Simpan",	
							"class" 			=> "input-submit save-content",	
							"icon" 				=> "fa-save",
						]
					]
				])

				<div id="page" class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-2menu">
					<div class="row">
						<div class="d-flex justify-content-center mx-auto">
							<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm; ">
								<textarea name="template" class="editor" id="doc-content-mention">
									@php $i=0; @endphp
									@forelse ($page_datas->datas['paragraf'] as $k => $v)
											@php
												// $newText = preg_replace('/<span(.*?)>(.*?)<\/span>/', '$2', $v['konten']);
											@endphp
											<span class="text-muted">{!! $v['konten'] !!}</span>
										@php $i++; @endphp
									@empty
									@endforelse
								</textarea>
							</div>
						</div>
					</div>
				</div>
				<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 sidebar sidebar-right subset-2menu">
					<div class="panel">
						<h5>List Fillable Mention</h5>
						<div class="list-group list-widgets">
							@if (isset($page_datas->datas['mentionable']))
								@php
									$sort_mentionable = array_sort_recursive($page_datas->datas['mentionable']);
									// $i=0;
								@endphp
								@forelse ($sort_mentionable as $k => $v)
									@php
										// if ($i==2) {
										// 	dd(explode('.', $v));
										// }
									@endphp
									<a class="list-group-item list-group-item-action justify-content-between p-2 mb-2" href="#" data-toggle="modal" data-target="#fill-mention" style="font-size: 14px;" data-widget="{{ $v }}">
										{{ $v }}
										<span class="{{ (array_has($page_datas->datas['fill_mention'], $v)) ? 'active' : '' }}"><i class="fa fa-check"></i></span>
									</a>
									@php
										// $i++;
									@endphp
								@empty
								@endforelse
							@else
								<p>Tidak ada fillable mention</p>
							@endif
						</div>
					</div>
				</div>				
			</div>
		@endcomponent
		@component('components.modal', [
			'id'		=> 'fill-mention',
			'title'		=> '',
			'settings'	=> [
				'modal_class'	=> '',
				'hide_buttons'	=> 'true',
				'hide_title'	=> 'true',
			]
		])
			<form class="form-widgets text-right form" action="#">
				<fieldset class="from-group">
					<input type="text" name="" class="form-control parsing set-focus" />
				</fieldset>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
					<button type="button" class="btn btn-primary" data-save="true">Simpan</button>
				</div>
			</form>
		@endcomponent
	</div>
	<div class="hidden-md-up subset-menu">
		<div class="text-center" style="padding-top: 25vh;">
			<p>Silahkan akses melalui perangkat komputer untuk dapat menggunakan fitur ini.</p>
		</div>
	</div>	
@stop

@push('scripts')  
	var dataListWidgets = {};
	var urlAutoSave = "{{ (!is_null($page_datas->akta_id)) ? route('akta.akta.automatic.store', ['id' => $page_datas->akta_id]) : route('akta.akta.automatic.store')  }}";
	var form = $('.form-akta');
	var urlFillMention = "{{ (!is_null($page_datas->akta_id)) ? route('akta.akta.simpan.mention', ['akta_id' => $page_datas->akta_id]) : route('akta.akta.simpan.mention')  }}";
	var listFillMention = {!! json_encode($page_datas->datas['fill_mention']) !!};
	
	window.editorUI.init(urlAutoSave, form, {disable: true});
	window.loadingAnimation.init();

	window.widgetEditorUI.init(urlFillMention);

	$('.input-submit').on('click', function(el) {
		el.preventDefault();
		$('form.form-akta').submit();
	});

	/* Script call modal widget */
	$('.modal').on('shown.bs.modal', function(e) {
		window.formUI.init();
	});

	window.modalUI.init();

	$(document).ready( function() {
		$('.editor').find('span.medium-editor-mention-at').each( function(k, v) {
			value = $(v).html();
			mentionValue = $(v).attr('data-value');

			$(v).html(listFillMention[value]).attr('data-mention', value).attr('data-value', listFillMention[value]);

			// check data value
			if ($(v).attr('data-value')) {
				$(v).removeClass('text-danger').addClass('text-primary');
			}
			else {
				$(v).addClass('text-danger');
			}
		});
	});
@endpush 
