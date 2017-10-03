@push ('page_content')
	<div class="row mt-4">
		<div class="col-12 col-sm-12 col-md-6 d-flex align-items-center">
			<h4 class="mb-0">{{ $page_attributes->title }}</h4>
		</div>
		<div class="col-12 col-sm-12 col-md-6 text-right d-flex align-items-center justify-content-end">
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
			<a href="#" class="btn btn-primary btn-sm mb-3">Buat Akta Baru</a>
			@include ('apps.pages.akta.components.table')
		</div>
	</div>
@endpush