@push ('page_content')
	<div class="row mt-3">
		<div class="col-6">
			<h5>{{ $page_attributes->title }}</h5>
		</div>
		<div class="col-6 text-right">
			@include ('apps.pages.akta.components.sort', [
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
	</div>
	<div class="row mt-3">
		<div class="col-12">
			@include ('apps.pages.akta.components.table')
		</div>
	</div>
@endpush