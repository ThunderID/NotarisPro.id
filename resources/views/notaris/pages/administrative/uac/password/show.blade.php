@extends('market_web.layout.master')

@section('content')

	<!-- TOPBAR -->
	{{--
	<section id="market-web-trial-topbar">
		<div class="container">
			@include('market_web.components.topbar_plain')
		</div>
	</section>
	--}}
	
	<!-- SLIDE -->
	<section id="market-web-trial-login">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 offset-sm-4 text-center" style="padding-top:85px;padding-bottom:10px;">
					<h1><a href="{{route('web.home.index')}}">{{ str_replace("_", " ", env('APP_NAME')) }}</a></h1> 
					<hr>
				</div>				
				<div class="col-sm-4 offset-sm-4 text-center" style="padding-top:0px;padding-bottom:180px;">
					<h3 class="pb-4">Permintaan Diterima</h3>
						Email berisi langkah - langkah untuk reset password Anda telah dikirim ke Email Anda.
					</p>
					<p>&nbsp;</p>
					<p>Tidak ada Email masuk ? </p>
					<div class="row">
						<div class="col-sm-6 text-left">
							<a href="{{route('uac.reset.create', ['email' => $page_datas->datas->email])}}"> << Cek Email </a>
						</div>
						<div class="col-sm-6 text-right">
							<a href="{{route('uac.reset.store', ['email' => $page_datas->datas->email])}}"> Kirim Ulang >> </a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	{{--
	<section id="market-web-trial-footer">
		<div class="container">
			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
	--}}
@endsection