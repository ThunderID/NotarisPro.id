@push ('main')
	<div class="row justify-content-center">
		<div class="col-8 text-center">
			<div class="row">
				<div class="col-12">
					<h3 class="text-center">{{ $page_attributes->title }}</h3>
					<p class="text-left">Silahkan pilih &amp; isi data untuk akta yang akan dibuat</p>
				</div>
			</div>
			
			{!! Form::open() !!}
				{!! Form::bsText() !!}
			{!! Form::close() !!}
		</div>
	</div>
@endpush