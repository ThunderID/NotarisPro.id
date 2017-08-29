@extends('templates.basic')

@push('styles') 
@endpush  

@section('akta')
	active
@stop

@section('data-akta')
	active
@stop

@section('content')

<div id="akta_show" class="row" style="{{ $page_datas->id == null ? 'display:none;' : '' }};background-color: white;z-index: 10; position:absolute; top:54; overflow-y: hidden;">
	@include('pages.akta.akta.show')
</div>
<div id="akta_index" class="row">
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
						'qs'	=> [ 'status','jenis','urutkan' ],
						'action_url' => route(Route::currentRouteName(), Request::only('status','sort'))
					])
				</div>

				@foreach($page_datas->filters as $key => $filter)
				<?php
					if($key == 'jenis'){
						$qs_helper = 'status';
					}else{
						$qs_helper = 'jenis';
					}
				?>
				<div class="panel">
					@include('components.filter',[
						'title' => 'Filter ' . ucWords($key),
						'alias' => $key,
						'qs'	=> [ 'cari','urutkan', $qs_helper ],
						'lists' => $filter
					])
				</div>
				@endforeach	

				<div class="panel hidden-md-up">
					@include('components.filter',[
						'title'	=> 'Urutkan',
						'alias' => 'urutkan',
						'qs'	=> [ 'cari','status','jenis' ],
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

		<div class="row hidden-sm" style="height: 39px;">
			<div class="col-md-12 pl-0 pr-0">
				<!-- <h5>Keranjang Sampah</h5> -->
				<div class="filter">
					<ul class="mb-0">
						<a href="{{ route('akta.akta.trash') }}">
							<li>
								Keranjang Sampah
								<span class="indicator float-right">
									<i class="fa fa-trash"></i>
								</span>
							</li>
						</a>	
					</ul>
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
					'qs'	=> [ 'cari','status','jenis' ],
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
						'cari' 		=> 'Cari Akta',
						'status' 	=> 'Status Akta',
						'jenis' 	=> 'Jenis Akta'
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
				<a href="javascript:void(0);" onclick="window.open('{{ route('akta.akta.choooseTemplate') }}', 'newwindow', 'width=' +screen.width+ ',height=768'); return false;" class="btn btn-primary btn-sm">Buat Akta</a>
				<!-- <a href="javascript:void(0);" onclick="showAkta(this);" data_judul_akta="testing" data_id_akta="111" class="btn btn-primary btn-sm">Buat Akta</a> -->
			</div>
		</div>
		@endif
		<div class="row">
			<div class="col-md-12">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Dokumen</th>
							<th style="width: 20%;">Pihak</th>
							<th style="width: 15%;"">Status</th>
							<th style="width: 20%;">Dokumen</th>
						</tr>
					</thead>
					<tbody>
		                @forelse((array)$page_datas->aktas as $key => $data)
						<tr onclick="showAkta(this);" data_id_akta="{{ $data['id'] }}" style="cursor: pointer;">
							<td>
								<i class="fa fa-file"></i>
								&nbsp;
								<span id="judul">{{ $data['judul'] }}</span>
							</td>
							<td>
								@if(isset($data['pemilik']['klien']))
									<ol style="padding-left: 5px;margin-bottom: 0px;">
										@foreach($data['pemilik']['klien'] as $key => $value)
											<li> {{ $value['nama'] }} </li>
										@endforeach
									</ol>
								@endif
							</td>
							<td id="status">{{ str_replace('_', ' ', $data['status']) }}</td>
							<td>
								{{ $data['tanggal_pembuatan'] }}
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
@yield('modal')
@stop