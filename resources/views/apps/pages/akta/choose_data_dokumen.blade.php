@push ('main')
	<div class="row justify-content-center">
		<div class="col-6">
			<div class="row">
				<div class="col-12">
					<h3 class="text-center">{{ $page_attributes->title }}</h3>
					<p class="text-center text-secondary">Silahkan isi dan lengkapi data-data dokumen akta</p>
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
			<div class="row">
				<div class="col-12">
					{!! Form::open(['url' => route('akta.akta.create'), 'method' => 'get']) !!}
						{!! Form::bsText('judul akta', 'judul', null, ['class' => 'form-control', 'placeholder' => 'masukkan judul akta']) !!}
						{!! Form::bsSelect('jenis akta', 'jenis', [
							'' => 'Pilih', 
							'akta_fidusia' => 'Akta fidusia', 
							'akta_jual_beli' => 'Akta jual beli', 
							'akta_pendirian' => 'Akta pendirian'
						], null, ['class' => 'custom-select form-control select-tag-add']) !!}
						{!! Form::bsSelect('pilih pihak', null, [], null, ['class' => 'form-control custom-select select-tag-custom select-pihak', 'multiple' => 'multiple', 'data-container' => '.pihak-selected']) !!}
						<div class="pihak-selected"></div>
						<div class="clearfix">&nbsp;</div>
						<div class="clearfix">&nbsp;</div>

						{{-- {!! Form::bsSelect('pilih saksi', 'search_name_saksi', [], null, ['class' => 'form-control custom-select select-tag-custom select-saksi', 'multiple' => 'multiple', 'data-container' => '.saksi-selected']) !!}
						<div class="saksi-selected"></div>
						<div class="clearfix">&nbsp;</div>
						<div class="clearfix">&nbsp;</div> --}}
						<div class="form-group text-right">
							<button type="submit" class="btn btn-primary text-right"><i class="fa fa-gears"></i> Buat akta</button>
						</div>
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>

	{{-- call component modal for detail list data --}}
	@component ('bootstrap.modal', [
		'id' 	=> 'choose-data-modal',
	])
		@slot ('title')
			Daftar data dokumen
		@endslot

		@slot ('body')
			{!! Form::open(['data-action' => route('arsip.arsip.index'), 'class' => 'form', 'id' => 'form-arsip']) !!}
				<div class="content-data-dokumen"></div>
				<div class="clearfix">&nbsp;</div>
				<div class="clearfix">&nbsp;</div>
				<div class="form-group text-right">
					<button type="submit" class="btn btn-primary">Simpan</button>
				</div>
			{!! Form::close() !!}
			{{-- <p class="">KTP</p>
			<div class="form">
				<div class="form-group">
					<label for="">No. Ktp</label>
					{!! Form::bsText(null, 'nomor_ktp', null, ['class' => 'form-control']) !!}
				</div>
			</div> --}}
		@endslot

		@slot ('footer')
		@endslot
	@endcomponent
@endpush

@push('styles')
	<style>
		.select2-selection__choice {
			display: none;
		}
		.tag-selected {
			list-style: none;
			background-color: #e4e4e4;
			border: 1px solid #aaa;
			border-radius: 4px;
			cursor: default;
			float: left;
			margin-right: 5px;
			margin-top: 5px;
			padding: 0 5px;
		}
		.destroy-tag-selected {
			color: #999;
			cursor: pointer;
			display: inline-block;
			font-weight: bold;
			margin-right: 2px;
		}
		.destroy-tag-selected:hover {
			text-decoration: none;
		}
	</style>
@endpush

@push('scripts')
	<script type="text/javascript">
		let urlArsipIndex = '{{ route("arsip.arsip.index") }}';
		// call module list arsip (data) dokumen
		window.ArsipList.init(urlArsipIndex, '.select-pihak');
		window.ArsipList.init(urlArsipIndex, '.select-saksi');
		window.Select2Input.init();
		window.ModuleModal.modalDataDokumen(urlArsipIndex);
		window.formArsip.init();
	</script>
@endpush