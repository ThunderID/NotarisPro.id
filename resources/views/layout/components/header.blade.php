<!-- first layer -->
<!-- <nav class="navbar navbar-toggleable-md navbar-light bg-faded">
	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>
	<a class="navbar-brand" href="#">NotarisPro</a>
</nav> -->

<!-- second layer -->
<nav class="navbar navbar-toggleable-sm navbar-inverse bg-primary text">

	<button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarCollapseAccount" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<i class="fa fa-user-o"></i>
	</button>

	<a class="navbar-brand text-center text-lg-left text-xl-left" href="#">{{ Config::get('app.name') }} </a>
	
	<button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-align-justify"></i>
	</button>


	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<div class="dropdown">
					<a class="nav-link" href="#" data-toggle="dropdown" id="dropdownMenuAkta" aria-haspopup="true" aria-expanded="false">Akta</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuAkta">
						<a class="dropdown-item" href="#">Draft Akta</a>
						<a class="dropdown-item" href="#">Pengajuan Akta</a>
						<a class="dropdown-item" href="#">Renvoi Akta</a>
						<a class="dropdown-item" href="#">Akta</a>
						<a class="dropdown-item" href="#">Minuta Akta</a>
					</div>
				</div>
			</li>
			<li class="nav-item">
				<div class="dropdown">
					<a class="nav-link" href="#" data-toggle="dropdown" id="dropdownMenuJadwal" aria-haspopup="true" aria-expanded="false">Jadwal</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuJadwal">
						<a class="dropdown-item" href="#">BPN</a>
						<a class="dropdown-item" href="#">Klien</a>
					</div>
				</div>				
			</li>	
			<li class="nav-item">
				<a class="nav-link" href="#">Klien</a>
			</li>	
			<li class="nav-item">
				<a class="nav-link" href="#">Billing</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Employee</a>
			</li>											
		</ul>
	</div>

	<div class="collapse navbar-collapse justify-content-end" id="navbarCollapseAccount">
		<ul class="navbar-nav">
			<li class="nav-item">
				<a class="nav-link" href="#">Organisasi</a>
			</li>
			<li class="nav-item">
				<a class="nav-link" href="#">Akun</a>
			</li>			
		</ul>
	</div>

</nav>
