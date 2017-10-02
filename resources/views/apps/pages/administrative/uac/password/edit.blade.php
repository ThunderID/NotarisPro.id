@push ('main')
	<section id="market-web-trial-login">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-5">
					<h4 class="text-center pb-4">Ubah Password</h2>
					<p>Silahkan isi password baru Anda :</p>

					{!! Form::open(['url' => route('uac.reset.update', ['token' => $page_datas->datas['token']]), 'method' => 'post']) !!}
						{!! Form::bsPassword(null, 'password', ['placeholder' => 'Masukkan password baru']) !!}
						{!! Form::bsPassword(null, 'repeat_password', ['placeholder' => 'Masukkan lagi password baru']) !!}
						{!! Form::bsSubmit('Ubah Password', ['class' => 'btn btn-primary btn-block']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endpush