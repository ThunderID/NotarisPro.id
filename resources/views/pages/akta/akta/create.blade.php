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
	<div class="row">
		<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2 sidebar">
			<div class="panel">
				<h5>List Widgets</h5>
				<div class="list-group">
					@foreach ($page_datas->list_widgets as $k => $v)
						<a class="list-group-item list-group-item-action p-1" href="#">{{ $v }}</a>
					@endforeach
				</div>
			</div>

			<div class="panel">
				@include('components.sidebarmenu',[
					'title' => 'Menu',
					'lists' => [
						'tambah widget' 	=> [
							'url' 	=> route('klien.create'),
							'icon' 	=> 'fa-plus'
						]
					]
				])
			</div>
		</div>
		<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-10 scrollable_panel">
			<div class="row">
				<div class="col-6">
					<h4 class="title">Data Widgets</h4>		
				</div>
			</div>
		</div>
	</div>
@stop

@push('scripts')  
@endpush 
