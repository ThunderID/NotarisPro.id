@push ('main')
	<div class="row">
		<div class="col-12 text-center">
			<h3>{{ $page_attributes->title }}</h3>
			<p>Silahkapn pilih untuk membuat draft atau akta baru</p>
		</div>
	</div>
	<div class="row align-items-center">
		<div class="col-6">
			<div class="row justify-content-center">
				<div class="col-6">
					<p>Berupa draft akta kosong</p>
					<a href="#" class="btn btn-primary btn-block">Akta Baru</a>
				</div>
			</div>
		</div>
		<div class="col-6">
			<div class="row justify-content-center">
				<div class="col-6">
					<p>Mengambil dari akta yang sudah tersimpan</p>
					<a href="#" class="btn btn-primary btn-block" data-toggle="modal" data-target="#choose-modal">Pilih Akta Lama</a>
				</div>
			</div>
		</div>
	</div>

	@component ('bootstrap.modal', [
		'id' 	=> 'choose-modal',
		'size'	=> 'modal-lg'
	])
		@slot ('title')
			Daftar akta
		@endslot

		@slot ('body')
			@include ('apps.pages.akta.components.table')
		@endslot

		@slot ('footer')
		@endslot
	@endcomponent
@endpush