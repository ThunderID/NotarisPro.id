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
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>

			<div class="row">
				<div class="col-sm-6 offset-sm-3 form-box">
					<form role="form" action="{{route('uac.tsignup.update')}}" method="post" class="text-center">

						<h3>{{$page_attributes->title}}</h3>
						<p>{{$page_attributes->subtitle}}</p>

						<div class="row">
							<div class="col-12">
								@include('components.alertbox')
							</div>
						</div>
				
						<div class="clearfix">&nbsp;</div>
						<fieldset>
							<div class="f1-buttons">
								<button type="submit" class="btn btn-submit">Ya</button>
							</div>
						</fieldset>
					
					</form>
				</div>
			</div>

			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
			<div class="clearfix">&nbsp;</div>
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
