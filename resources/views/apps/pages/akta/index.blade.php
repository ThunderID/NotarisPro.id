@push ('main')
	<div id="akta_show" class="row" style="display: none;">
		@include ('apps.pages.akta.show')
	</div>
	<div id="akta_index" class="row">
		<div class="col-12 col-sm-12 col-md-3 sidebar">
			@stack ('page_sidebar')
		</div>
		<div class="col-12 col-sm-12 col-md-9">
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
					<a href="#" data-url="{{ route('akta.akta.choose') }}" class="btn btn-primary btn-sm mb-3 btn-new-akta">Buat Akta</a>
					@include ('apps.pages.akta.components.table')
				</div>
			</div>
		</div>
	</div>
@endpush

{{-- use tag <script></script> --}}
@push ('scripts')
	<script type="text/javascript">
		// table row action
		$('table.table-action').on('click', 'tr', function(e) {
			e.preventDefault();

			var linkUrlShow = $(this).attr('data-url');
			var linkUrlIndex = '';
			var dataID = $(this).attr('id');

			window.history.pushState(null, null, '/akta/' + dataID);
			window.aktaShow.getData(linkUrlShow);
		});

		// button create new akta
		$('a.btn-new-akta').on('click', function(e) {
			e.preventDefault();

			linkUrl = $(this).attr('data-url');
			var wEditor = window.open(linkUrl, 'new_window', 'width=' +screen.width+ ',height=768');
			var pollTimer = window.setInterval(function() {
				if (wEditor.closed !== false) { // !== is required for compatibility with Opera
					window.clearInterval(pollTimer);
					location.reload();
				}
			}, 200);
		})
	</script>
@endpush