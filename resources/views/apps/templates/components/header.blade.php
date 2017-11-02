<nav class="navbar navbar-dark navbar-expand-md bg-primary text sticky-top dark-primary-color text-primary-color">

	<button id="togleCollapseNavbarAccount" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavbarAccount" aria-controls="navbarNavbarAccount" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-user-o"></i>
	</button>

	<a class="navbar-brand text-center text-lg-left text-xl-left" href="">
		{{ str_replace("_", " ", env('APP_NAME')) }}
	</a>
	<!-- <div class="collapse navbar-collapse" id="navbarSupportedContent">
		<div class="d-inline-block">
			<select name="level" style="font-size:10pt;background-color: #fff;padding: 7px;border:none">
				<option value="all">Semua Jenis</option>
				@foreach ($filters['jenis'] as $kj => $vj)
				<option value="{{$kj}}">{{$vj}}</option>
				@endforeach
			</select>
		</div>
		<div class="d-inline-block">
			<input class="form-control " placeholder="Jual beli rumah di mengwi" style="font-size:10pt;width:500px;" name="q" type="text">
		</div>
	</div> -->

	<div class="collapse navbar-collapse justify-content-end" id="navbarNavbarAccount">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link text-primary-color" data-toggle="modal" data-target="#menuModal">
					<i class="fa fa-th" aria-hidden="true" style="font-size: 15px;"></i>&emsp;
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link text-primary-color" href="">
					<i class="fa fa-power-off" aria-hidden="true" style="font-size: 15px;"></i>&emsp;
				</a>
			</li>			
		</ul>
	</div>
</nav>

<nav class="navbar navbar-dark navbar-expand-md bg-primary text default-primary-color" style="height: 150px;">
	<a class="navbar-brand text-center text-lg-left text-xl-left" href="">
		<h2 class="text-primary-color">{{ucwords($page_attributes->title)}}<br/><small><small><small>{{$page_attributes->subtitle}}</small></small></small></h2>
	</a>
</nav>


<!-- Modal -->
<div class="modal fade" id="menuModal" tabindex="-1" role="dialog" aria-labelledby="menuModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="menuModalLabel">MENU</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-sm-6 text-center">
						<a href="{{route('akta.index')}}">
							<p>
								<i class="h1 ion-ios-color-wand-outline"></i>
							</p>
							<p>
								Legal Creator
							</p>
						</a>
					</div>
					<div class="col-sm-6 text-center">
						<a href="{{route('arsip.index')}}">
							<p>
								<i class="h1 ion-ios-folder-outline"></i>
							</p>
							<p>
								Arsip Klien
							</p>
						</a>
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-sm-6 text-center">
						<p>
							<i class="h1 ion-ios-calendar-outline"></i>
						</p>
						<p>
							Monitoring BPN
						</p>
					</div>
					<div class="col-sm-6 text-center">
						<p>
							<i class="h1 ion-ios-calculator-outline"></i>
						</p>
						<p>
							Tagihan Klien
						</p>
					</div>
				</div>
				<div class="clearfix">&nbsp;</div>
				<hr class="divider-color">
				<div class="clearfix">&nbsp;</div>
				<div class="row">
					<div class="col-sm-6 text-center">
						<p>
							<i class="h1 ion-ios-gear-outline"></i>
						</p>
						<p>
							Pengaturan
						</p>
					</div>
					<div class="col-sm-6 text-center">
						<p>
							<i class="h1 ion-ios-person-outline"></i>
						</p>
						<p>
							Akun Anda
						</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>