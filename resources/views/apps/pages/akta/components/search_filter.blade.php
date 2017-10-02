@push ('page_sidebar')

	{{--  <div class="panel hidden-md-up text-right">
		<a href="javascript:void(0);" class="btn btn-outline-primary btn-default btn-toggle-menu-off">
			<i class="fa fa-times" aria-hidden="true"></i>
		</a>
	</div>  --}}

	<div class="card border-0 mt-3">
		<div class="card-body p-0">
			@include('apps.pages.akta.components.search',[
				'title' => 'Cari Akta',
				'qs'	=> [ 'status','jenis','urutkan' ],
				'action_url' => route(Route::currentRouteName(), Request::only('status','sort'))
			])
		</div>
	</div>

	@isset ($page_datas->filters)
		@foreach ($page_datas->filters as $key => $filter)
			@if ($key == 'jenis')
				@php $qs_helper = 'status'; @endphp
			@else
				@php $qs_helper = 'jenis'; @endphp
			@endif
		
			<div class="card border-0 mt-3">
				<div class="card-body p-0">
					@include('apps.pages.akta.components.filter',[
						'title' => 'Filter ' . ucWords($key),
						'alias' => $key,
						'qs'	=> [ 'cari','urutkan', $qs_helper ],
						'lists' => $filter
					])
				</div>
			</div>
		@endforeach	
	@endisset

	<div class="card border-0 mt-3">
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



	{{-- link trash  --}}
	<div class="card border-0 mt-3">
		<div class="card-body p-0">
			<ul class="list-unstyled">
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
@endpush