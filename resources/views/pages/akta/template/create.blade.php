@extends('templates.basic')

@push('styles')  
@endpush  

@section('akta')
	active
@stop

@section('buat-template')
	active
@stop

@section('content')
<div class="row">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 bg-faded">
		<ul class="nav menu-content">
			<li class="nav-item">
				<a class="nav-link" href="#"><i class="fa fa-save"></i> Simpan</a>
			</li>
			<li class="nav-item">
				<span class="nav-link">Halaman</span>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">A4</a>
				<div class="dropdown-menu">
					<a class="dropdown-item" href="#">A4</a>
					<a class="dropdown-item" href="#">F4</a>
				</div>
			</li>
			<li class="nav-item">
				<span class="nav-link">Zoom</span>
			</li>
		</ul>
	</div>
</div>
<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
	<div class="col">&nbsp;</div>
	<div class="col-9 d-flex justify-content-center">
		<form action="#" class="form mt-2 font-editor" style="width: 21cm; height: 29.7cm; background-color: #fff">
			<div class="form-group p-3">
				{!! Form::textarea('template', null, ['class' => 'editor']) !!}
			</div>
		</form>
	</div>
	<div class="col">&nbsp;</div>
</div>
@stop

@push('scripts')
	var dataListWidgets = {!! json_encode($page_datas->list_widgets) !!};
	window.editorUI.init();
@endpush 
