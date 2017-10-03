@push ('page_sidebar')
	<div class="row" style="height: calc(100% - 54px); overflow-y: scroll;">
		<div class="col-12">
			<div class="card border-0 mt-1" style="background-color: transparent">
				<div class="card-body p-0">
					@include('apps.pages.akta.components.search',[
						'title' => 'Cari Akta',
						'qs'	=> [ 'status','jenis','urutkan' ],
						'action_url' => route(Route::currentRouteName(), Request::only('status','sort'))
					])
				</div>
			</div>
		</div>
		@isset ($page_datas->filters)
			@foreach ($page_datas->filters as $key => $filter)
				@if ($key == 'jenis')
					@php $qs_helper = 'status'; @endphp
				@else
					@php $qs_helper = 'jenis'; @endphp
				@endif
				
				<div class="col-12">
					<div class="card border-0 mt-1" style="background-color: transparent">
						<div class="card-body p-0">
							@include('apps.pages.akta.components.filter',[
								'title' => 'Filter ' . ucWords($key),
								'alias' => $key,
								'qs'	=> [ 'cari','urutkan', $qs_helper ],
								'lists' => $filter
							])
						</div>
					</div>
				</div>
			@endforeach	
		@endisset

		<div class="col-12">
			<div class="card border-0 mt-1" style="background-color: transparent">
				<div class="card-body p-0">
					@include ('apps.pages.akta.components.filter', [
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
	</div>

	<div class="row">
		<div class="col-12">
			{{-- link trash  --}}
			<div class="card border-0" style="background-color: transparent">
				<div class="card-body p-0 filter">
					<ul class="list-unstyled mb-0">
						<a href="#">
							<li>
								Akta Terhapus
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
@endpush