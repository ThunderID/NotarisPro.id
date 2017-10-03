<nav class="navbar navbar-dark navbar-expand-md bg-primary text sticky-top">

	<button id="togleCollapseNavbarAccount" class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarNavbarAccount" aria-controls="navbarNavbarAccount" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-user-o"></i>
	</button>

	<a class="navbar-brand text-center text-lg-left text-xl-left" href="">{{ str_replace("_", " ", env('APP_NAME')) }}</a>
	
	<button id="togleCollapseSupportedContent" class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-align-justify"></i>
	</button>


	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<a class="nav-link {{ in_array(strtolower($active_menu), ['akta']) ? 'active' : '' }}" href="">Akta</a>
			</li>	
			<li class="nav-item">
				<a class="nav-link {{ in_array(strtolower($active_menu), ['tagihan']) ? 'active' : '' }}" href="">Tagihan</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ in_array(strtolower($active_menu), ['jadwal']) ? 'active' : '' }}" href="">Jadwal BPN</a>
			</li>
			<li class="nav-item">
				<a class="nav-link {{ in_array(strtolower($active_menu), ['arsip']) ? 'active': '' }}" href="">Arsip</a>
			</li>
		</ul>
	</div>

	<div class="collapse navbar-collapse justify-content-end" id="navbarNavbarAccount">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="">
					<i class="fa fa-cog" aria-hidden="true" style="font-size: 15px;"></i>&nbsp;
					{{--  <span class="hidden-md-up">Pengaturan</span>	  --}}
					<span class="">Pengaturan</span>
				</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="">
					<i class="fa fa-power-off" aria-hidden="true" style="font-size: 15px;"></i>&nbsp;
					{{--  <span class="hidden-lg-down">Logout</span>  --}}
					<span class="">Logout</span>	
				</a>
			</li>			
		</ul>
	</div>
</nav>