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

	<a class="navbar-brand text-center text-lg-left text-xl-left" href="#">{{ str_replace("_", " ", env('APP_NAME')) }}</a>
	
	<button class="navbar-toggler navbar-toggler-left" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<i class="fa fa-align-justify"></i>
	</button>


	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav mr-auto">
			<li class="nav-item">
				<div class="dropdown">
					<a class="nav-link @yield('akta')" href="javascript:void(0);" data-toggle="dropdown" id="dropdownMenuAkta" aria-haspopup="true" aria-expanded="false">Akta</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuAkta">
						<a class="dropdown-item @yield('buat-akta')" href="{{ route('akta.akta.choose.template') }}">Buat Akta</a>
						<a class="dropdown-item @yield('data-akta')" href="{{ route('akta.akta.index') }}">Data Akta</a>
						<a class="dropdown-item @yield('buat-template')" href="{{ route('akta.template.create') }}">Buat Template</a>
						<a class="dropdown-item @yield('template-akta')" href="{{ route('akta.template.index') }}">Template Akta</a>
					</div>
				</div>
			</li>
			<li class="nav-item">
				<div class="dropdown">
					<a class="nav-link yield('jadwal')" href="javascript::void(0);" data-toggle="dropdown" id="dropdownMenuJadwal" aria-haspopup="true" aria-expanded="false">Jadwal</a>
					<div class="dropdown-menu" aria-labelledby="dropdownMenuJadwal">
						<a class="dropdown-item @yield('jadwal-bpn')" href="{{ route('jadwal.bpn.index') }}">BPN</a>
						<a class="dropdown-item @yield('jadwal-klien')" href="{{ route('jadwal.klien.index') }}">Klien</a>
					</div>
				</div>				
			</li>	
			<li class="nav-item @yield('klien')">
				<a class="nav-link" href="{{ route('klien.index') }}">Klien</a>
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
				<a class="nav-link" href="javascript:void(0);"  data-toggle="modal" data-target="#modal-change-org">
					<i class="fa fa-building" aria-hidden="true" style="font-size: 15px;"></i>&nbsp;
					<span class="hidden-lg-down">
						{{TAuth::activeOffice()['kantor']['nama']}}
					</span>
					<span class="hidden-md-up">
						{{TAuth::activeOffice()['kantor']['nama']}}
					</span>					
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


{{-- modal change org --}}
@component('components.modal', [
		'id'			=> 'modal-change-org',
		'title'			=> 'Pilih Organisasi',
		'settings'		=> [
			'hide_buttons'	=> true
		]
	])
	<div id="list-koperasi">
		<div class="form-group has-feedback">
			<input type="text" class="search form-control" placeholder="cari nama koperasi">
			<span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
		</div>
		<ul class="list-group list">
			@foreach(TAuth::loggedUser()['visas'] as $key => $value)			
				<li class="list-group-item">
					<a class="name" href="{{ route('uac.office.activate', $value['id']) }}" ><i class="fa fa-building"></i>&nbsp;&nbsp; {{ $value['kantor']['nama'] }}</a>
				</li>
			@endforeach
		</ul>

		<hr/>

		<div style="float: left;">
			<p class="text-left">
				<span class="label">Aktif : &nbsp;&nbsp;{{ TAuth::activeOffice()['kantor']['nama'] }}
				</span>
			</p>
		</div>		
	</div>
	
@endcomponent

