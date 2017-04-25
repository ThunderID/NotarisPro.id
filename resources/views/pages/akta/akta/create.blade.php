@extends('templates.basic')

@push('styles')  
	body {background-color: rgba(0, 0, 0, 0.075) !important;}
@endpush  

@section('akta')
	active
@stop

@section('buat-akta')
	active
@stop

@section('content')
		<div class="row bg-faded">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				&nbsp;
			</div>
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<ul class="nav menu-content justify-content-end">
					{{-- <li class="nav-item">
						<span class="nav-link">Zoom</span>
					</li>
					<li class="nav-item">
						<span class="nav-link">Halaman</span>
					</li>
					<li class="nav-item dropdown">
						<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">A4</a>
						<div class="dropdown-menu dropdown-menu-right">
							<a class="dropdown-item" href="#">A4</a>
							<a class="dropdown-item" href="#">F4</a>
						</div>
					</li> --}}
					<li class="nav-item">
						<a class="nav-link input-submit" href="#" data-toggle="modal" data-target="#form-title"><i class="fa fa-save"></i> Simpan</a>
					</li>
				</ul>
			</div>
		</div>
		<div class="row">
			<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 sidebar">
				<div class="panel">
					<h5>List Widgets</h5>
					<div class="list-group list-widgets">
						@if (isset($page_datas->datas['mentionable']))
							@forelse ($page_datas->datas['mentionable'] as $k => $v)
								<a class="list-group-item list-group-item-action justify-content-between p-2" href="#" data-toggle="modal" data-target="#list-widgets" style="font-size: 14px;" data-widget="{{ $v }}">
									{{ $v }}
									<span><i class="fa fa-check"></i></span>
								</a>
							@empty
							@endforelse

							@component('components.modal', [
								'id'		=> 'list-widgets',
								'title'		=> '',
								'settings'	=> [
									'modal_class'	=> '',
									'hide_buttons'	=> 'true',
									'hide_title'	=> 'true',
								]
							])
								<form class="form-widgets text-right form" action="#">
									<fieldset class="from-group">
										<input type="text" name="" class="form-control parsing" />
									</fieldset>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
										<button type="button" class="btn btn-primary" data-save="true">Simpan</button>
									</div>
								</form>
							@endcomponent
						@else
							<p>Tidak ada widget</p>
						@endif
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel">
				<div class="row">
					<div class="col">&nbsp;</div>
					<div class="col-11 d-flex justify-content-center">
						@component('components.form', [ 
							'data_id'		=> $page_datas->akta_id,
							'store_url' 	=> route('akta.akta.store', ['template_id' => $page_datas->template_id]), 
							'update_url' 	=> route('akta.akta.update', ['id' => $page_datas->akta_id]), 
							'class'			=> 'form-akta mb-0'
						])
						<div class="form mt-3 mb-3 font-editor" style="width: 21cm !important; height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
							<textarea name="template" class="editor">
								@forelse ($page_datas->datas['paragraf'] as $k => $v)
									{!! $v['konten'] !!}
								@empty
								@endforelse
							</textarea>
						</div>
						@endcomponent
					</div>
					<div class="col">&nbsp;</div>	
				</div>
			</div>
		</div>
	@component('components.modal', [
		'id'		=> 'widget',
		'title'		=> 'Form Widgets',
		'settings'	=> [
			'modal_class'	=> '',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'true',
		]
	])
	@endcomponent
@stop

@push('scripts')  
	var dataListWidgets = {};
	window.editorUI.init();
	window.widgetEditorUI.init();
	window.modalUI.init();
	window.formUI.disableEnter();

	$('.input-submit').on('click', function(el) {
		el.preventDefault();
		$('form.form-akta').submit();
	});
@endpush 
