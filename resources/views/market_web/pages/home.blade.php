@extends('market_web.layout.master')

@section('content')

	<!-- TOPBAR -->
	<section id="market-web-home-topbar">
		<div class="container">
			@include('market_web.components.topbar')
		</div>
	</section>
	
	<!-- SLIDE -->
	<section id="market-web-home-slider">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center" style="padding-top:150px;padding-bottom:150px;">
					<h1>Kesulitan Melacak<br>Dokumen Klien ?</h1>
					<h2> 
						<a href="#" class="btn btn-default" style="border:1px solid;">
							TRY FOR FREE
						</a>
					</h2>
				</div>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	<section id="market-web-home-footer" style="background-color:rgb(239, 239, 239)">
		<div class="container">
			<!-- CONTACT INFORMATION -->
			@include('market_web.components.contact_information')

			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
@endsection