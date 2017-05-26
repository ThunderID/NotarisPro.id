
<!-- first layer -->
<!-- <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="#">NotarisPro</a>
</nav> -->

<!-- second layer -->
<nav class="navbar navbar-toggleable-sm navbar-inverse bg-primary text fixed-top">

	<button id="togleCollapseNavbarAccount" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavbarAccount" aria-controls="navbarNavbarAccount" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-user-o"></i>
	</button>

	<a class="navbar-brand text-center text-lg-left text-xl-left" href="{{route('home.dashboard')}}">{{ str_replace("_", " ", env('APP_NAME')) }}</a>
	
	<button id="togleCollapseSupportedContent" class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-align-justify"></i>
	</button>


	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item @yield('template-akta')">
				<a class="nav-link" href="{{route('akta.template.index')}}">Template</a>
			</li>				
			<li class="nav-item @yield('akta')">
				<a class="nav-link" href="{{route('akta.akta.index')}}">Akta</a>
			</li>	

			<li class="nav-item">
				<div class="dropdown">
					<a class="nav-link yield('pos')" href="javascript::void(0);" data-toggle="dropdown" id="dropdownMenuPOS" aria-haspopup="true" aria-expanded="false">POS</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuPOS">
						<a class="dropdown-item @yield('pos-bkk')" href="{{ route('pos.bkk.index') }}">Kas Keluar</a>
						<a class="dropdown-item @yield('pos-bkm')" href="{{ route('pos.bkm.index') }}">Kas Masuk</a>
						<a class="dropdown-item @yield('pos-billing')" href="{{ route('pos.billing.index') }}">Tagihan</a>
					</div>
				</div>				
			</li>	
			<!-- <li class="nav-item @yield('klien')">
				<a class="nav-link" href="{{route('klien.index')}}">Klien</a>
			</li> -->
		</ul>
	</div>

	<div class="collapse navbar-collapse justify-content-end" id="navbarNavbarAccount">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="{{route('billing.index')}}">
					<i class="fa fa-cog" aria-hidden="true" style="font-size: 15px;"></i>&nbsp;
					<span class="hidden-md-up">Pengaturan & Tagihan</span>	
					<span class="hidden-md-down">Pengaturan & Tagihan</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="{{route('uac.logout.any')}}">
					<i class="fa fa-power-off" aria-hidden="true" style="font-size: 15px;"></i>&nbsp;
					<span class="hidden-lg-down">Logout</span>
					<span class="hidden-md-up">Logout</span>	
				</a>
			</li>			
		</ul>
	</div>
</nav>

@push('scripts') 
	$('#togleCollapseSupportedContent').on('click', function(){
		$('#navbarNavbarAccount').collapse('hide'); 
	});
	$('#togleCollapseNavbarAccount').on('click', function(){
		$('#navbarSupportedContent').collapse('hide'); 
	});
@endpush 
