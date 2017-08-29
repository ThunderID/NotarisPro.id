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
	<div id="arsip_show" class="row" style="{{ $page_datas->id == null ? 'display:none;' : '' }};background-color: white;z-index: 10; position:absolute; top:54px; overflow-y: hidden;">
		@include('pages.arsip.arsip.show')
	</div>
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

					@foreach($page_datas->filters as $key => $filter)
					<div class="panel">
						@include('components.filter',[
							'title' => 'Filter ' . ucWords($key) . ' Arsip',
							'alias' => $key,
							'qs'	=> [ 'cari','status' ],
							'lists' => $filter
						])
					</div>
					@endforeach						

					<div class="panel hidden-md-up">
						@include('components.filter',[
							'title'	=> 'Urutkan',
							'alias' => 'urutkan',
							'qs'	=> [ 'cari','status' ],
							'lists' => [
								'nama a - z' 	=> null,
								'nama z - a' 	=> 'nama-desc'
							]
						])
					</div>

				</div>
			</div>
		</div>	
		<div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel">
			<div class="row">
				<div class="col-6">
					<h4 class="title">{{$page_attributes->title}}</h4>
				</div>
				<div class="col-6 hidden-sm-down text-right">
					@include('components.sort',[
						'alias' => 'urutkan',
						'qs'	=> [ 'q','status' ],
						'lists' => [
							'nama a - z' 	=> null,
							'nama z - a' 	=> 'nama-desc',
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
				<div class="col-12">
					<table class="table table-hover">
						<thead>
							<tr>
								<th style="width: 20%;"">Jenis Arsip</th>
								<th style="width: 80%">Nama</th>
							</tr>
						</thead>
						<tbody>
							@forelse($page_datas->arsips as $key => $value)
							<tr onclick="showArsip(this);" data_id_arsip="{{ $value['id'] }}" style="cursor: pointer;">
								<td id="judul">
									@if(strtoupper($value['jenis']) == 'KTP')
										<i class="fa fa-id-card" aria-hidden="true"></i>
									@else
										<i class="fa fa-file" aria-hidden="true"></i>
									@endif
									&nbsp;
									{{ strtoupper($value['jenis']) }}
								</td>
								<td>
									{{ $value['isi']['nama'] }}
								</td>				
							</tr>
			                @empty
			                <tr>
			                    <td colspan="2" class="text-center">
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
	</div>	
@stop