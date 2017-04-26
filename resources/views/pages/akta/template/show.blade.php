@extends('templates.basic')

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
					&nbsp;
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ul class="nav menu-content justify-content-end">
						<li class="nav-item">
							<span class="nav-link">&nbsp;</span>
						</li>
						<!--<li class="nav-item">
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
						</li> -->
						@if(str_is($page_datas->datas['template']['status'], 'draft'))
						<li class="nav-item">
							<a class="nav-link text-danger" href="" data-toggle="modal" data-target="#deleteModal"><i class="fa fa-trash"></i> Hapus</a>
						</li>

						<li class="nav-item">
							<a class="nav-link" href="{{route('akta.template.publish', ['id' => $page_datas->datas['template']['id']])}}" ><i class="fa fa-check"></i> Publish</a>
						</li>
						@elseif(str_is($page_datas->datas['template']['status'], 'publish'))
						<li class="nav-item">
							<span class="nav-link">Published</span>
						</li>
						@endif
					</ul>
				</div>
			</div>
			{{-- END COMPONENT MENUBAR --}}
		</div>
		<div id="page" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div id="page-breaker" class="row page-breaker"></div>
			<div class="row">
				<div class="col">&nbsp;</div>
				<div class="col-9 d-flex justify-content-center">
					<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm;">
						<div class="form-group p-3 editor">
							@foreach($page_datas->datas['template']['paragraf'] as $key => $value)
								{!!$value['konten']!!}
							@endforeach
						</div>
					</div>
				</div>
				<div class="col">&nbsp;</div>	
			</div>
		</div>
		<div class="clearfix">&nbsp;</div>
	</div>


	@include('components.deleteModal',[
		'title' => 'Menghapus Draft Template',
		'route' => route('akta.template.destroy', ['id' => $page_datas->datas['template']['id']])
	])
@stop

@push('scripts')

	/* Auto Page Break */
	$(document).ready(function(){
		/* Adapter */
		var editor = $('.editor');
		var page_editor = $('.page-editor');

		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);
	});

@endpush 