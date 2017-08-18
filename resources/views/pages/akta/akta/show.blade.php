<div class="col-12 subset-menu" style="width:100vw;">
	<div class="row">

		@include('components.submenu', [
			'title' 		=> "Judul Akta",
			'back_route'	=> route('akta.akta.index'),
			'menus' 		=> [
					[
						"title" 			=> "",		
						"route" 			=> "javascript:hideAkta();",
						"icon" 				=> "fa-times",
						"class" 			=> "akta_close"
					]				
			]
		])
	</div>

	<div class="row subset-2menu full-on-mobile" style="background-color: rgba(0, 0, 0, 0.075);">


		<div id="page" class="scrollable_panel" style="width: calc(100vw - 297px); float: right;">
			
			<div id="page-loader" style="width: calc(100vw - 297px); background: #000;opacity: 0.8; height:100%; position: absolute;">
				<h4 style=" width: 272px;height: 57px;position: absolute;top: 50%;left: 50%;margin: -28px 0 0 -25px;transform:translateX(-20%);"><i class="fa fa-circle-o-notch fa-spin fa-fw"></i> Memuat</h4>'
			</div>
			<div class="d-flex justify-content-center mx-auto">
				<div class="form mt-3 mb-3 font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
					<div class="form-group editor">	
					</div>
				</div>
			</div>			
		</div>

		<div class="hidden-sm-down sidebar sidebar-right subset-2menu" style="width: 297px;">

			<div class="col-12 pt-2 pb-2">
				<h5>
					<b>Akta Pendirian Teguh Jaya Selalu Noto Boto Limo Merongos Sedoyo</b>
				</h5>

				<div class="row">
					<div class="col-12">
						<h6>
							<a href="#" class="text-primary">
								<span class="fa-stack">
									<i class="fa fa-pencil-square-o" aria-hidden="true"></i>
								</span>
								Sunting
							</a>
						</h6>
						<h6>
							<a href="#" class="text-primary">
								<span class="fa-stack">
									<i class="fa fa-copy"></i>
								</span>
								Salin & Sunting
							</a>
						</h6>
						<h6>
							<a href="#" class="text-primary disabled">
								<span class="fa-stack">
									<i class="fa fa-print" aria-hidden="true"></i>
								</span>
								Cetak
							</a>							
						</h6>
						<h6>
							<a href="#" data-toggle="modal" data-target="#deleteModal" class="text-danger">
								<span class="fa-stack">
									<i class="fa fa-trash" aria-hidden="true"></i>
								</span>
								Hapus
							</a>				
						</h6>
					</div>
				</div>
			</div>

			<div id="sidebar-loader" class="col-12 pt-3 pb-2">
				<h6 class="mb-0">
					<i class="fa fa-circle-o-notch fa-spin"></i>&nbsp;<b>Memuat</b>
				</h6>
			</div>

			<div class="col-12 pt-3 pb-2">
				<h5 class="mb-0">
					<b>Informasi</b>
				</h5>

				<div class="row">
					<div class="col-12">
						<h7 class="text-muted">Status Akta</h7>
						<h6>Renvoi</h6>
					</div>
				</div>				

				<div class="row">
					<div class="col-12">
						<h7 class="text-muted">Pihak</h7>
						<h6>1. borneo</h6>
						<h6>2. parinho</h6>
					</div>
				</div>	

				<div class="row">
					<div class="col-12">
						<h7 class="text-muted">Dibuat Pada</h7>
						<h6>17 Agustus 2016</h6>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<h7 class="text-muted">Oleh</h7>
						<h6>John Dai</h6>
					</div>
				</div>								

				<div class="row">
					<div class="col-12">
						<h7 class="text-muted">Sunting Terakhir</h7>
						<h6>17 Agustus 2016</h6>
					</div>
				</div>

				<div class="row">
					<div class="col-12">
						<h7 class="text-muted">Versi Akta</h7>
						<h6>1</h6>
					</div>
				</div>
			</div>

			<div class="col-12 pt-3 pb-2">
				<h5>
					<b>Kelengkapan Dokumen Akta</b>
				</h5>

				<div class="row">
					<div class="col-12">
						<h6 class="mb-0">
							<span class="fa-stack">
								<i class="fa fa-check-square-o" aria-hidden="true"></i>
							</span>
							KTP Pihak 1
						</h6>
					</div>
					<div class="col-12">
						<h6 class="mb-0">
							<span class="fa-stack">
								<i class="fa fa-check-square-o" aria-hidden="true"></i>
							</span>
							KTP Pihak 2
						</h6>
					</div>
					<div class="col-12">
						<h6 class="mb-0">
							<span class="fa-stack">
								<i class="fa fa-square-o" aria-hidden="true"></i>
							</span>
							KK Pihak 1
						</h6>
					</div>
					<div class="col-12">
						<h6 class="mb-0">
							<span class="fa-stack">
								<i class="fa fa-check-square-o" aria-hidden="true"></i>
							</span>
							KK Pihak 2
						</h6>
					</div>					
				</div>

			</div>

			<div class="col-12 pt-3 pb-2">
				<h5 class="mb-0">
					<b>Histori Status</b>
				</h5>

				<div class="row">
					<div class="col-12">
						<h7 class="text-muted">12 Agustus 2017</h7>
						<h6 class="mb-1">Renvoi</h6>
						<h6>Mr. Bo</h6>
					</div>
				</div>	

				<div class="row">
					<div class="col-12">
						<h7 class="text-muted">10 Agustus 2017</h7>
						<h6 class="mb-1">Draft</h6>
						<h6>Mr. Dal</h6>
					</div>
				</div>				

			</div>	

			<div class="col-12 pt-3 pb-2">

				<div class="row clearfix"></div>

			</div>	
		</div>

	</div>
</div>

@section('modal')
	@include('components.deleteModal',[
		'title' => 'Menghapus Akta',
		'route' => route('akta.akta.index')
	])
@stop


@push('scripts')

	function showAkta(e){
		/* re-init */
		// empty val

		// reset state
		$('#page-loader').show();
		$('#sidebar-loader').show();

		// ui display
		$('#akta_show').fadeIn('fast');
		$('#akta_show').find('#judul_akta').text($(e).attr('data_judul_akta'));
	}

	function hideAkta(e){
		$('#akta_show').fadeOut('fast');
	}
@endpush