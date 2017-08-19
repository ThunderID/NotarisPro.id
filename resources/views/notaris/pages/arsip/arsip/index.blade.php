@extends('templates.basic')

@push('styles')  
@endpush  

@section('arsip')
	active
@stop

@section('data-arsip')
	active
@stop

@section('content')
	<div class="row">

		<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 pt-0 hide-mobile sidebar subset-menu target-menu" style="overflow-y: hidden;">
			<div class="row" style="padding-top:16px;overflow-y: scroll;height: calc(100% - 39px);">
				<div class="col-md-12">

					<div class="panel hidden-md-up text-right">
						<a href="javascript:void(0);" class="btn btn-outline-primary btn-default btn-toggle-menu-off">
							<i class="fa fa-times" aria-hidden="true"></i>
						</a>
					</div>

					<div class="panel">
						@include('components.search',[
							'title' => 'Cari Akta',
							'qs'	=> [ 'status','urutkan' ],
							'action_url' => route(Route::currentRouteName(), Request::only('status','sort'))
						])
					</div>

					<div class="panel">
						@foreach($page_datas->filters as $key => $value)
							@include('components.filter',[
								'title' => $key,
								'alias' => 'status',
								'qs'	=> [ 'cari','urutkan' ],
								'lists' => $value
							])
						@endforeach
					</div>	

					<div class="panel hidden-md-up">
						@include('components.filter',[
							'title'	=> 'Urutkan',
							'alias' => 'urutkan',
							'qs'	=> [ 'cari','status' ],
							'lists' => [
								'tanggal sunting terbaru' 	=> null,
								'tanggal sunting terlama' 	=> 'tanggal_sunting-asc', 
								'tanggal pembuatan terbaru' => 'tanggal_pembuatan-desc',
								'tanggal pembuatan terlama' => 'tanggal_pembuatan-asc',
								'judul a - z' 	=> 'judul-asc',
								'judul z - a' 	=> 'judul-desc',
								'status a - z'	=> 'status-asc',
								'status z - a'	=> 'status-desc',
							]
						])
					</div>

				</div>
			</div>
		</div>	
		<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel">
			<h4 class="title">{{$page_attributes->title}}</h4>

			<div class="row">
				@foreach($page_datas->arsips as $key => $value)
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
						<a href="{{route('arsip.arsip.show', ['value' => $value['id']])}}">						
							<h1>
								<i class="fa fa-file"></i>
							</h1>
							<p>[{{strtoupper($value['jenis'])}}] {{$value['isi']['nama']}}</p>
						</a>
					</div>
				@endforeach
			</div>
		</div>	
	</div>	
@stop
