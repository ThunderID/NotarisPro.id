<nav class="navbar navbar-expand-lg bg-white pt-3 pb-4">
	<p class="navbar-brand mb-0 ml-3 mr-0" style="">
		<i class="fa fa-file mt-2" style="position: absolute; margin-left: -30px; font-size: 32px;"></i>&nbsp; {{ $akta['judul'] }}
		<span class="text-white badge badge-secondary">{{ str_replace('_', ' ', $akta['jenis']) }}</span>
	</p>
	<ul class="navbar-nav mr-auto" style="">
		<li class="nav-item"><a href="#" class="nav-link pl-1"><sup><i class="fa fa-pencil"></i> Ubah</sup></a></li>
	</ul>
	<form action="#" class="form-inline" style="display: none">
		<i class="fa fa-file-o"></i>&nbsp;
		{!! Form::text('judul', $akta['judul'], ['class' => 'form-control mr-sm-2 border-0', 'placeholder' => 'judul akta']) !!}
		<a href="#" class="btn btn-link text-secondary btn-sm my-2 my-sm-0">Batal</a>
		<button type="button" class="btn btn-link text-primary btn-sm my-2 my-sm-0">Ubah</button>
	</form>
	<ul class="navbar-nav ml-auto">
		<li class="nav-item">
			<a href="#" class="nav-link text-secondary">
				<i class="fa fa-times fa-lg"></i>
			</a>
		</li>
	</ul>
</nav>