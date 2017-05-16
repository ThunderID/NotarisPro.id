@extends('templates.basic')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')
.page-breaker{
	position: absolute; 
	height: 1.52px; 
	background-color: #ececec; 
	width: 100%;
}  
@endpush  

@section('akta')
	active
@stop

@section('template-akta')
	active
@stop

@section('content')
	<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			{{-- COMPONENT MENUBAR --}}
			<div class="row bg-faded">
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<ul class="nav menu-content justify-content-start">
						<li class="nav-item">
							<span class="navbar-text">{{ isset($page_datas->datas['id']) ? $page_datas->datas['judul'] : '' }}</span>
						</li>
					</ul>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 pr-0">
					<ul class="nav menu-content justify-content-end">
						@if(str_is($page_datas->datas['status'], 'draft'))
							<li class="nav-item">
								<a class="nav-link text-danger" href="" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Hapus</a>
							</li>
						
							<li class="nav-item hidden-sm-down">
								<a class="nav-link" href="{{route('akta.template.edit', ['id' => $page_datas->datas['id']])}}" ><i class="fa fa-pencil"></i> Edit</a>
							</li>

							<li class="nav-item">
								<a class="nav-link" href="{{route('akta.template.publish', ['id' => $page_datas->datas['id']])}}" ><i class="fa fa-cloud-upload"></i> Publish</a>
							</li>
						@elseif(str_is($page_datas->datas['status'], 'publish'))
							<li class="nav-item">
								<span class="nav-link">Published</span>
							</li>
						@endif
					</ul>
				</div>
			</div>
			{{-- END COMPONENT MENUBAR --}}
		</div>
		<div id="page" class="col-xs-12 col-sm-12 col-md-9 col-lg-9 scrollable_panel subset-2menu"">
			<div id="page-breaker" class="row page-breaker"></div>
			<div class="row">
				<div class="d-flex justify-content-center mx-auto">
					<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
						<div class="form-group editor">
							@foreach((array)$page_datas->datas['paragraf'] as $key => $value)
								{!!$value['konten']!!}
							@endforeach
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-3 col-lg-3 sidebar sidebar-right subset-2menu">
			<div class="panel">
				<h5 class="text-capitalize">Deskripsi Template</h5>
				<p>{{ $page_datas->datas['deskripsi'] }}</p>
			</div>
		</div>
	</div>


	@include('components.deleteModal',[
		'title' => 'Menghapus Draft Template',
		'route' => route('akta.template.destroy', ['id' => $page_datas->datas['id']])
	])
@stop

@push('scripts')
	/* call plugin */
	window.formUI.init();

	/* Auto Page Break */
	$(document).ready(function(){
		/* Adapter */
		var editor = $('.editor');
		var page_editor = $('.page-editor');

		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);
	});

	/* Script call modal delete */
	$('#deleteModal').on('shown.bs.modal', function(e) {
		window.formUI.setFocus();
	});
@endpush 