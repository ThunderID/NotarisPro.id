@extends('market_web.layout.master')

@section('content')

	<!-- TOPBAR -->
	<section id="market-web-service-topbar">
		<div class="container">
			@include('market_web.components.topbar')
		</div>
	</section>
	
	<!-- VIDEO -->
	<section id="market-web-service-video">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center" style="padding-top:150px;padding-bottom:150px;">
					<h1>TAKE A TOUR<br>&#9658;</h1>
				</div>
			</div>
		</div>
	</section>
	
	<!-- FITUR -->
	<section id="market-web-service-fitur">
		<div class="container">
			<div class="row" style="border-top:1px solid;padding-top:50px;padding-bottom:20px;">
				<div class="col-sm-12 text-center">
					<h3><u>BEKERJA LEBIH EFISIEN</u></h3>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12" style="padding:30px;padding-bottom:40px;">
					<div class="row">
						<div class="col-sm-7">
							<div style="background-color:#ccc;padding:30px;">
								<h5><u>LEGAL DOCUMENT CREATOR</u></h5>
								<p>Cek Renvoi lebih mudah, sistem membantu mengecek dokumen yang belum lengkap, menyimpan semua versi minuta dan salinan serta back up salinan akta.</p>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div style="background-color:rgb(239, 239, 239);padding:30px;">
								<h5><u>BILLING GENERATOR</u></h5>
								<p>Cetak invoice untuk klien, dan fungsi export untuk membantu pembukuan.</p>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div style="background-color:rgb(239, 239, 239);padding:30px;">
								<h5><u>CLIENT ARCHIVE</u></h5>
								<p>Penyimpanan dokumen legalitas klien, seperti; akta pendirian, ktp, dan lainnya, lengkap dengan riwayat perubahannya.</p>
							</div>
						</div>
						<div class="col-sm-5">
							<img src="https://placeholdit.co//i/432x501?&bg=1111=&fc=fff&text=432%20*%20510" style="width:100%;height:100%">
						</div>
					</div>
				</div>
			</div>

			<div class="row" style="border-top:1px solid;padding-top:10px;padding-bottom:10px;">
				<div class="col-sm-6 text-center" style="padding:30px;">
					<img src="https://placeholdit.co//i/500x200?&bg=1111=&fc=fff&text=500%20*%20160">
				</div>
				<div class="col-sm-6 text-right" style="padding:30px;">
					<h3 style="line-height: 150%;">PEGANG KENDALI PENUH<br/>AKSES DIMANA SAJA</h3>
					<p style="line-height: 150%;">Praesent volutpat dui eros, ac convallis nisl malesuada ut. Proin interdum quis sem et sodales. Fusce gravida sodales efficitur. Mauris vel elementum ipsum. Fusce finibus nisl sed dolor ultricies, nec faucibus massa condimentum.</p>
				</div>
			</div>

			<div class="row" style="padding-top:10px;padding-bottom:20px;">
				<div class="col-sm-6 text-left" style="padding:30px;">
					<h3 style="line-height: 150%;">YELLOW PAGES<br/>NOTARIS DI INDONESIA</h3>
					<p style="line-height: 150%;">Praesent volutpat dui eros, ac convallis nisl malesuada ut. Proin interdum quis sem et sodales. Fusce gravida sodales efficitur. Mauris vel elementum ipsum. Fusce finibus nisl sed dolor ultricies, nec faucibus massa condimentum.</p>
				</div>
				<div class="col-sm-6 text-center" style="padding:30px;">
					<img src="https://placeholdit.co//i/500x200?&bg=1111=&fc=fff&text=500%20*%20160">
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 text-center" style="padding:30px;padding-bottom:70px;">
					<h2> 
						<a href="{{route('uac.tsignup.create')}}" class="btn btn-default" style="border:1px solid;">
							TRY FOR FREE
						</a>
					</h2>
				</div>
			</div>
		</div>
	</section>

	<!-- KONTAK -->
	<section id="market-web-service-kontak" style="background:url('https://placeholdit.co//i/1366x400?&bg=1111=&fc=fff&text=1366%20*%20400')">
		<div class="container">
			<div class="row" style="padding:30px;">
				<div class="col-sm-6 text-left" style="background-color:#fff;padding:50px;">
					<form>
						<div class="form-group">
							<label for="exampleInputEmail1">Email address</label>
							<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" />
							<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
						</div>

						<div class="form-group">
							<label for="exampleInputNama1">Nama</label>
							<input type="text" class="form-control" id="exampleInputNama1" aria-describedby="NamaHelp" placeholder="Enter Nama" name="nama" />
						</div>

						<div class="form-group">
							<label for="examplePesan">Pesan</label>
							<textarea class="form-control" id="examplePesan" rows="3" name="pesan"></textarea>
						</div>

						<button type="submit" class="btn btn-primary">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</section>

	<!-- FOOTER -->
	<section id="market-web-service-footer" style="background-color:rgb(239, 239, 239)">
		<div class="container">
			<!-- CONTACT INFORMATION -->
			@include('market_web.components.contact_information')

			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
@endsection