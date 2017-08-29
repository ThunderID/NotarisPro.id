@extends('market_web.layout.master')

@section('content')

	<!-- TOPBAR -->
	<section id="market-web-signin-topbar">
		<div class="container">
			@include('market_web.components.topbar_plain')
		</div>
	</section>
	
	<!-- SLIDE -->
	<section id="market-web-signin-login">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 offset-sm-3 form-box">
					<form role="form" action="" method="post" class="f1">

						<h3>{{$page_attributes->title}}</h3>
						<p>{{$page_attributes->subtitle}}</p>

						<div class="row">
							<div class="col-12">
								@include('components.alertbox')
							</div>
						</div>
						
						<div class="f1-steps">
							<div class="f1-progress">
								<div class="f1-progress-line" data-now-value="16.66" data-number-of-steps="3" style="width: 16.66%;"></div>
							</div>
							<div class="f1-step active">
								<div class="f1-step-icon"><i class="fa fa-user"></i></div>
								<p>kantor</p>
							</div>
							<div class="f1-step">
								<div class="f1-step-icon"><i class="fa fa-key"></i></div>
								<p>akun</p>
							</div>
							<div class="f1-step">
								<div class="f1-step-icon"><i class="fa fa-credit-card"></i></div>
								<p>pembayaran</p>
							</div>
						</div>
						
						<fieldset>
							<!-- <h4>Tell us who you are:</h4> -->
							<div class="form-group">
								<label class="sr-only" for="f1-kantor-nama">Nama Kantor Notaris</label>
								<input type="text" name="kantor[nama]" placeholder="Notaris & PPAT John Doe, SH" class="f1-kantor-nama form-control" id="f1-kantor-nama">
							</div>
							<div class="form-group">
								<label class="sr-only" for="f1-kantor-daerah_kerja">Daerah Kerja</label>
								<input type="text" name="kantor[daerah_kerja]" placeholder="Kabupaten Malang" class="f1-kantor-daerah_kerja form-control" id="f1-kantor-daerah_kerja">
							</div>
							<div class="form-group">
								<label class="sr-only" for="f1-kantor-nomor_sk">Nomor SK</label>
								<input type="text" name="kantor[nomor_sk]" placeholder="Nomor SK" class="f1-kantor-nomor_sk form-control" id="f1-kantor-nomor_sk">
							</div>
							<div class="form-group">
								<label class="sr-only" for="f1-kantor-tanggal_pengangkatan">Tanggal Pengangkatan</label>
								<input type="text" name="kantor[tanggal_pengangkatan]" placeholder="dd/mm/YYYY" class="f1-kantor-tanggal_pengangkatan form-control" id="f1-kantor-tanggal_pengangkatan">
							</div>
							<div class="form-group">
								<label class="sr-only" for="f1-kantor-telepon">Nomor Telepon</label>
								<input type="text" name="kantor[telepon]" placeholder="0341 884400" class="f1-kantor-telepon form-control" id="f1-kantor-telepon">
							</div>
							<div class="form-group">
								<label class="sr-only" for="f1-kantor-alamat">Alamat</label>
								<textarea name="kantor[alamat]" placeholder="Ruko Puri Niaga A10, Araya" class="f1-kantor-alamat form-control" id="f1-kantor-alamat"></textarea>
							</div>
							<div class="f1-buttons">
								<button type="button" class="btn btn-next">Lanjutkan</button>
							</div>
						</fieldset>

						<fieldset>
							<!-- <h4>Set up your account:</h4> -->
							<div class="form-group">
								<label class="sr-only" for="f1-email">Email</label>
								<input type="text" name="akun[email]" placeholder="Email..." class="f1-email form-control" id="f1-email">
							</div>
							<div class="form-group">
								<label class="sr-only" for="f1-password">Password</label>
								<input type="password" name="akun[password]" placeholder="Password..." class="f1-password form-control" id="f1-password">
							</div>
							<div class="form-group">
								<label class="sr-only" for="f1-repeat-password">Repeat password</label>
								<input type="password" name="akun[repeat-password]" placeholder="Repeat password..." class="f1-repeat-password form-control" id="f1-repeat-password">
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="f1-buttons">
								<button type="button" class="btn btn-previous">Kembali</button>
								<button type="button" class="btn btn-next">Lanjutkan</button>
							</div>
						</fieldset>

						<fieldset>
							<!-- <h4>Pembayaran:</h4> -->
							<div class="form-group">
								<label class="sr-only" for="f1-payment-plan">Paket</label>
								<select disabled type="text" name="pembayaran[paket]" class="f1-payment-plan form-control" id="f1-payment-plan">
									<option value="starter" @if($page_datas->datas['plan']=='starter') selected @endif >Starter</option>
									<option value="trial" @if($page_datas->datas['plan']=='trial') selected @endif>Trial {{Config::get('days_of_trial')}} Days</option>
								</select>
							</div>
							<div class="form-group">
								<label class="sr-only" for="f1-payment-method">Metode Pembayaran</label>
								<select disabled type="text" name="pembayaran[metode]" class="f1-payment-method form-control" id="f1-payment-method">
									<option value="midtrans">Midtrans</option>
									<!-- <option value="auto_debet">Auto Debet</option> -->
								</select>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="f1-buttons">
								<button type="button" class="btn btn-previous">Kembali</button>
								<button type="submit" class="btn btn-submit">Submit</button>
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
					<h5><a href="{{route('web.pricing.index')}}"> << Lihat Plan Lainnya</a></h5>
				</div>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	<section id="market-web-signin-footer">
		<div class="container">
			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
@endsection

@push('styles')
	<!-- CSS -->
	<link rel="stylesheet" href="{{url('/assets/login/wizard/css/form-elements.css')}}">
	<link rel="stylesheet" href="{{url('/assets/login/wizard/css/style.css')}}">
@endpush

@push('scripts')
	<!-- Javascript -->
	<script src="{{url('/assets/login/wizard/js/jquery.backstretch.min.js')}}"></script>
	<script src="{{url('/assets/login/wizard/js/retina-1.1.0.min.js')}}"></script>
	<script src="{{url('/assets/login/wizard/js/scripts.js')}}"></script>
@endpush