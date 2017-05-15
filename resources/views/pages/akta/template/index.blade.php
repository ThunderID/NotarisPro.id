@extends('templates.basic')

@push('styles')  
@endpush  

@section('akta')
	active
@stop

@section('template-akta')
	active
@stop

@section('content')
<div class="row">

	<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3 hide-mobile sidebar subset-menu target-menu" style="overflow-y: hidden;">
		<div class="row" style="overflow-y: scroll;height: calc(100% - 65px);">
			<div class="col-md-12">
				<div class="panel hidden-md-up text-right">
					<a href="javascript:void(0);" class="btn btn-outline-primary btn-default btn-toggle-menu-off">
						<i class="fa fa-times" aria-hidden="true"></i>
					</a>
				</div>

				<div class="panel">
					@include('components.search',[
						'title' => 'Cari Template',
						'qs'	=> [ 'status','sort' ],
						'action_url' => route(Route::currentRouteName(), Request::only('status','sort'))
					])		
				</div>

				<div class="panel">
					@include('components.filter',[
						'title' => 'Filter Template',
						'alias' => 'status',
						'qs'	=> [ 'q','sort' ],
						'lists' => [
							'semua status' 	=> null,
							'draft' 		=> 'draft', 
							'publish' 		=> 'publish',
						]
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
		<div class="row" style="height: 65px;">
			<div class="col-md-12 pt-2">
				<!-- <h5>Keranjang Sampah</h5> -->
				<div class="filter">
					<ul>
						<a href="{{ route('akta.template.trash') }}">
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

	<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel">
		<div class="row">
			<div class="col-6">
				<h4 class="title">Template Dokumen</h4>		
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
		<div class="row mt-3 mb-3">
			<div class="col-12">
				<a href="{{ route('akta.template.initial') }}" class="btn btn-primary btn-sm">Buat Template</a>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<table class="table table-hover">
					<thead>
						<tr>
							<th>Dokumen</th>
							<th style="width: 15%;"">Status</th>
							<th style="width: 20%;">Tanggal Sunting</th>
							<th style="width: 20%;">Tanggal Pembuatan</th>
						</tr>
					</thead>
					<tbody>
		                @forelse((array)$page_datas->datas as $key => $data)
						<tr class="clickable-row" data-href="{{ route('akta.template.show', ['id' => $data['id']]) }}">
							<td>
								<i class="fa fa-file"></i>
								&nbsp;
								{{ $data['judul'] }}
							</td>
							<td class="{{ ($data['status'] == 'publish') ? 'text-success' : '' }}">
								{{ $data['status'] }}
							</td>
							<td>
								{{ $data['tanggal_sunting'] }}
							</td>
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
		        @include('components.paginate')
			</div>
		</div>
	</div>

<!-- 	<div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-2" style="height: calc(100% - 54px); background-color: #ddd; ">
		<h5 style="padding-top: 2rem; padding-bottom: 0.5rem;">Cari Data</h5>

		<div class="search">
			<form class="form" action="" data-pjax=true data-ajax-submit=false>
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Cari" aria-describedby="basic-addon1" name="q">
					<span class="input-group-addon" id="basic-addon1">
						<i class="fa fa-search" aria-hidden="true"></i>
					</span>
				</div>
			</form>
		</div>
	</div>	 -->

</div>
@stop

@push('scripts')  
@endpush 
