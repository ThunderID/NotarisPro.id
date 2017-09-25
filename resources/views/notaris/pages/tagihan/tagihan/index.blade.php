@extends('templates.basic')

@push('styles') 
@endpush  

@section('tagihan')
	active
@stop

@section('tagihan')
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
						'title' => 'Cari Nomor Tagihan',
						'qs'	=> [ 'status','urutkan' ],
						'action_url' => route(Route::currentRouteName(), Request::only('status','sort'))
					])
				</div>

				<div class="panel hidden-md-up">
					@include('components.filter',[
						'title'	=> 'Urutkan',
						'alias' => 'urutkan',
						'qs'	=> [ 'q','status' ],
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
<!-- 	<div class="col-12 sidebar-togler">
		<h4> Filter & Pencarian<span class="text-right">v</span></h4>
	</div>	 -->

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel">
		<div class="row">
			<div class="col-6">
				<h4 class="title">{{ $page_attributes->title }}</h4>		
			</div>
			<div class="col-6 hidden-sm-down text-right">
				@include('components.sort',[
					'alias' => 'urutkan',
					'qs'	=> [ 'q','status' ],
					'lists' => [
						'judul a - z' 	=> 'judul-asc',
						'judul z - a' 	=> 'judul-desc',
						'status a - z'	=> 'status-asc',
						'status z - a'	=> 'status-desc',
						'tanggal sunting terbaru' 	=> null,
						'tanggal sunting terlama' 	=> 'tanggal_sunting-asc', 
						'tanggal pembuatan terbaru' => 'tanggal_pembuatan-desc',
						'tanggal pembuatan terlama' => 'tanggal_pembuatan-asc',
					]
				])
			</div>
			<div class="col-6 hidden-md-up text-right mobile-toggle-search">
				<a href="javascript:void(0);" class="btn btn-outline-primary btn-default btn-toggle-menu-on">
					<!-- <i class="fa fa-binoculars" aria-hidden="true"></i> -->
					<i class="fa fa fa-ellipsis-v" aria-hidden="true"></i>
				</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12 mb-2">
				@include('components.filterIndicator',[
					'lists' => 	[
						'q' 		=> 'Cari Data',
						'status' 	=> 'Status Data'
					]
				])
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				@include('components.alertbox')
			</div>
		</div>		
		@if(!isset($page_attributes->hide['create']))
		<div class="row mt-2 mb-3">
			<div class="col-12">
				<a href="{{ route('tagihan.tagihan.create') }}" class="btn btn-primary btn-sm">Buat Tagihan</a>
			</div>
		</div>
		@endif
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Nomor Transaksi</th>
							<th style="width: 20%;">Klien</th>
							<th style="width: 25%;"">Jatuh Tempo</th>
							<th style="width: 20%;">Lunas</th>
						</tr>
					</thead>
					<tbody>
		                @forelse($page_datas->tagihans as $key => $data)
						<tr class="clickable-row" data-href="{{ route('tagihan.tagihan.edit', ['id' => $data['id']]) }}">
							<td>
								<i class="fa fa-file"></i>
								&nbsp;
								{{ $data['nomor'] }}
							</td>
							<td>
								{{ $data['klien']['nama'] }}
							</td>
							<td>
								{{ $data['tanggal_dikeluarkan'] }}
							</td>					
							<td>
								{{ $data['status'] }}
							</td>
						</tr>
		                @empty
		                <tr>
		                    <td colspan="4" class="text-center">
		                        Tidak Ada Data
		                    </td>
		                </tr>
		                @endforelse
					</tbody>
				</table>
			</div>
	        @include('components.paginate')
		</div>
	</div>
</div>
@stop

@push('scripts')  

@endpush 
