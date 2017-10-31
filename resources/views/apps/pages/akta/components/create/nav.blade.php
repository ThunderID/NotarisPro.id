<nav class="navbar navbar-expand-lg bg-white pt-3 pb-4">
	<p class="navbar-brand mb-0 ml-3 mr-0" style="">
		<i class="fa fa-file mt-2" style="position: absolute; margin-left: -30px; font-size: 32px;"></i>&nbsp; 
		<span class="judul-akta" style="">{{ $akta['judul'] }}</span>
		<span class="text-white badge badge-secondary">{{ str_replace('_', ' ', $akta['jenis']) }}</span>
		{!! Form::hidden('jenis', $akta['jenis'], ['class' => 'input-jenis-akta']) !!}
		<div class="input-judul-akta w-75" style="display:none;">
			{!! Form::text('judul', $akta['judul'], ['class' => 'form-control mr-sm-2 border-0 d-inline w-50', 'placeholder' => 'judul akta', 'style' => 'font-size:1.25rem; font-weight:400;']) !!}
			<a href="#" class="btn btn-link text-secondary btn-sm my-2 my-sm-0 btn-cancel-change-title">Batal</a>
			<button type="button" class="btn btn-link text-primary btn-sm my-2 my-sm-0 btn-save-change-title">Ubah</button>
		</div>
	</p>
	<ul class="navbar-nav mr-auto" style="">
		<li class="nav-item"><a href="#" class="nav-link pl-1 btn-change-title"><sup><i class="fa fa-pencil"></i> Ubah</sup></a></li>
	</ul>
	{{-- <div class="form-inline form-title" style="display: none">
		{!! Form::text('judul', $akta['judul'], ['class' => 'form-control mr-sm-2 border-0 input-judul-akta', 'placeholder' => 'judul akta']) !!}
	</div> --}}
	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a href="#" class="nav-link text-secondary">
				<i class="fa fa-times fa-lg"></i>
			</a>
		</li>
	</ul>
	<div class="loading-save alert p-1 text-center" style=" font-size: 12px; position: absolute !important; top: 5px; left: calc(50vw / 2) !important; width: 180px !important; "></div>
</nav>