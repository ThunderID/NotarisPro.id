@push ('main')
	<section id="market-web-signin-login">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-6 form-box">
					{!! Form::open(['url' => null, 'class' => 'f1', 'method' => 'post']) !!}
						<h3>{{ $page_attributes->title }}</h3>
						<p>{{ $page_attributes->subtitle }}</p>

						<div class="row">
							<div class="col-12">
								{{--  untuk alert box  --}}
							</div>
						</div>

					<form role="form" action="" method="post" class="f1">
						<div class="row">
							<div class="col-12">
								{{--  @include('components.alertbox')  --}}
							</div>
						</div>
						
						<ul class="list-inline f1-steps">
							<li class="f1-step active list-inline-item">
								<i class="fa fa-user"></i> Kantor
							</li>
							<li class="f1-step list-inline-item">
								<i class="fa fa-key"></i> Akun
							</li>
							<li class="f1-step list-inline-item">
								<i class="fa fa-credit-card"></i> Pembayaran
							</li>
						</ul>
						
						<fieldset>
							<!-- <h4>Tell us who you are:</h4> -->
							{!! Form::bsText('nama kantor notaris', 'kantor[nama]', null, ['class' => 'form-control', 'placeholder' => 'Nama kantor notaris']) !!}
							{!! Form::bsText('daerah kerja', 'kantor[daerah_kerja]', null, ['class' => 'form-control', 'placeholder' => 'Daerah kerja']) !!}
							{!! Form::bsText('Nomor SK', 'kantor[nomor_sk]', null, ['class' => 'form-control', 'placeholder' => 'Nomor SK']) !!}
							{!! Form::bsText('Tanggal Pengangkatan', 'kantor[tanggal_pengangkatan]', null, ['class' => 'form-control', 'placeholder' => 'Tanggal Pengangkatan']) !!}
							{!! Form::bsText('nomor telepon', 'kantor[telepon]', null, ['class' => 'form-control', 'placeholder' => '']) !!}
							{!! Form::bsTextarea('Alamat', 'kantor[alamat]', null, ['class' => 'form-control', 'placeholder' => '', 'rows' => '4', 'style' => 'resize: none;']) !!}
								
							<div class="f1-buttons">
								<button type="button" class="btn btn-next btn-primary">Lanjutkan</button>
							</div>
						</fieldset>

						<fieldset>
							<!-- <h4>Set up your account:</h4> -->
							{!! Form::bsText('email', 'akun[email]', null, ['class' => 'form-control', 'placeholder' => '']) !!}
							{!! Form::bsPassword('password', 'akun[password]', null, ['class' => 'form-control', 'placeholder' => '']) !!}
							{!! Form::bsPassword('ulangi password', 'akun[repeat_password]', null, ['class' => 'form-control', 'placeholder' => '']) !!}

							<div class="clearfix">&nbsp;</div>
							<div class="f1-buttons">
								<button type="button" class="btn btn-previous btn-default">Kembali</button>
								<button type="button" class="btn btn-next btn-primary">Lanjutkan</button>
							</div>
						</fieldset>

						<fieldset>
							<!-- <h4>Pembayaran:</h4> -->
							{!! Form::bsSelect('paket', 'pembayaran[paket]', ['starter' => 'Starter', 'trial' => 'Trial '. Config::get('days_of_trial') . ' Hari'], null, ['class' => 'form-control custom-control', 'placeholder' => '']) !!}
							{!! Form::bsSelect('metode pembayaran', 'pembayaran[metode]', ['midtrans' => 'Midtrans'], null, ['class' => 'form-control custom-control', 'placeholder' => '']) !!}
							
							<div class="clearfix">&nbsp;</div>
							<div class="f1-buttons">
								<button type="button" class="btn btn-previous btn-default">Kembali</button>
								<button type="submit" class="btn btn-submit btn-primary">Submit</button>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="clearfix">&nbsp;</div>
							<div class="clearfix">&nbsp;</div>
						</fieldset>
					
					</form>
				</div>
			</div>


			<div class="row">
				<div class="col-sm-12 text-left">
					<h5><a href="">Lihat Plan Lainnya</a></h5>
				</div>
			</div>
		</div>
	</div>
@endpush