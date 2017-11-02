@push ('main')
	<div id="akta_show" class="row" style="display: none;">
		@include ('apps.pages.akta.show')
	</div>

	<div class="row">
		<div class="col-12">
			<a href="#" data-url="{{ route('akta.create') }}" class="btn accent-color text-primary-color btn-circle btn-lg btn-new-akta" style="position: absolute; top: -25px;right: 15px;padding: 10px;"><i class="fa fa-plus" style="font-size:12px;"></i> </a>
		</div>
	</div>
	<div class="clearfix">&nbsp;</div>
	<div class="clearfix">&nbsp;</div>
	<div class="row mt-3">
		<div class="col-8">
			{!!Form::open(['method' => 'GET', 'class' => 'form-inline'])!!}
				{!! Form::bsSelect(null, 'jenis', $filters['jenis'], null, ["style" => "font-size:10pt !important;border-radius:0px;border-color:#868e96;"]) !!}&emsp;
				{!! Form::bsText(null, 'q', null, ['placeholder' => "Jual beli rumah di mengwi", "style" => "font-size:10pt !important;width:500px;max-width:100%;padding:10px;border-color:#868e96;"]) !!}&emsp;
				{!! Form::bsSubmit('&nbsp;<i class="fa fa-search"></i>&nbsp;', ['class' => 'btn btn btn-outline-secondary float-right', "style" => "font-size:10pt !important;padding:10px;"]) !!}
			{!!Form::close()!!}
		</div>
		<div class="col-4 text-right">
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
	<div class="clearfix">&nbsp;</div>
	<div id="akta_index" class="row mt-3">
		<div class="col-12">
			@include ('apps.pages.akta.components.list')
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