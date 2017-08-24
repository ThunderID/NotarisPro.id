@extends('market_web.layout.master')

@section('content')

	<!-- TOPBAR -->
	<section id="market-web-pricing-topbar">
		<div class="container">
			@include('market_web.components.topbar')
		</div>
	</section>
	
	<!-- DAFTAR NOTARIS DI INDONESIA -->
	<section id="market-web-pricing-video">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center" style="padding-top:50px;padding-bottom:50px;">
					<h1>DAFTAR NOTARIS DI INDONESIA</h1>
				</div>
			</div>

			<div class="row" style="padding-bottom:50px;">
				<div class="col-sm-12">
					<table class="table table-striped">
						<thead>
							<tr>
								<th>No</th>
								<th>Nama</th>
								<th>Daerah Kerja</th>
								<th>Alamat</th>
								<th>Telepon</th>
							</tr>
						</thead>
						<tbody>
							@foreach($page_datas->notaris as $key => $value)
								<tr>
									<td>{{$key+1}}</td>
									<td>{{$value['notaris']['nama']}}</td>
									<td>{{$value['notaris']['daerah_kerja']}}</td>
									<td>{{$value['notaris']['alamat']}}</td>
									<td>{{$value['notaris']['telepon']}}</td>
								</tr>
							@endforeach
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</section>

	<!-- FOOTER -->
	<section id="market-web-pricing-footer" style="background-color:rgb(239, 239, 239)">
		<div class="container">
			<!-- CONTACT INFORMATION -->
			@include('market_web.components.contact_information')

			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
@endsection