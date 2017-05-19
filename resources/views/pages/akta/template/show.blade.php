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
	{{-- active --}}
@stop

@section('template-akta')
	active
@stop


@section('content')
	<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">

		{{-- Predefine Sub Menu --}}
		<?php
			$title = isset($page_datas->datas['id']) ? $page_datas->datas['judul'] : '';

			if(str_is($page_datas->datas['status'], 'publish')){
				// badge title
				$title 		= "<span class='text-success'>[Published]</span> " . $title;

				// menu
				$menus 		= [
					[
						"title" 			=> "Buat Akta",	
						"route" 			=> route('akta.akta.choose.template', ['template_id' => $page_datas->datas['id']]),
						"icon" 				=> "fa-file-text-o",
					]
				];
			}else{
				// menu
				$menus 		= [
					[
						"title" 			=> "Hapus",	
						"class" 			=> "text-danger",	
						"trigger_modal" 	=> "#deleteModal",
						"icon" 				=> "fa-trash",
					],
					[
						"title" 			=> "Edit",	
						"hide_on" 			=> "hidden-sm-down",	
						"route" 			=> route('akta.template.edit', ['id' => $page_datas->datas['id']]),
						"icon" 				=> "fa-edit",
					],
					[
						"title" 			=> "Publish",	
						"route" 			=> route('akta.template.publish', ['id' => $page_datas->datas['id']]),
						"icon" 				=> "fa-check",
					],						
				];
			}

		?>
		@include('components.submenu', [
			'title' 		=> $title,
			'back_route'	=> route('akta.template.index'),
			'menus' 		=> $menus
		])

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
		'title' => 'Menghapus draft Template',
		'route' => route('akta.template.destroy', ['id' => $page_datas->datas['id']])
	])
@stop

@push('scripts')
	/* call plugin */
	window.formUI.init();

	{{--
	/* Auto Page Break */
	$(document).ready(function(){
		/* Adapter */
		var editor = $('.editor');
		var page_editor = $('.page-editor');

		var ep = editorPaging;
		ep.pageHeight =  editorPaging.convertPX(29.7);
		ep.autoAdjustHeight(page_editor, editorPaging.convertPX(2), editor, 0);
	});
	--}}

	/* Script call modal delete */
	$('#deleteModal').on('shown.bs.modal', function(e) {
		window.formUI.setFocus();
	});
@endpush 