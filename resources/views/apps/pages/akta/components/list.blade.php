<div class="row ml-1 mr-1 border border-top-0 border-left-0 border-right-0">
	<div class="col-sm-4 mb-2">
		<h5 class="mb-0"><strong>DOKUMEN</strong></h5>
	</div>
	<div class="col-sm-2 mb-2 text-center">
		<h5 class="mb-0"><strong>JENIS</strong></h5>
	</div>
	<div class="col-sm-4 mb-2">
		<h5 class="mb-0"><strong>KLIEN</strong></h5>
	</div>
	<div class="col-sm-2 mb-2">
		<h5 class="mb-0"><strong>STATUS</strong></h5>
	</div>
</div>
<!-- @foreach ($akta as $k => $v)
	<div class="row ml-1 mr-1 mt-2 mb-2" id="{{ $v['id'] }}" @if (!isset($mode)) style="cursor: pointer" data-url="{{ route('akta.show', ['id' => $v['id']]) }}" @endif>
		<div class="col-sm-4"><i class="fa fa-file-o"></i> {{ $v['judul'] }}</div>
		<div class="col-sm-2">{{ str_replace('_', ' ', $v['jenis']) }}</div>
		<div class="col-sm-4">
			@isset ($v['pemilik']['klien'])
				<ol>
					@foreach ($v['pemilik']['klien'] as $k2 => $v2)
						<li>{{ $v2['nama'] }}</li>
					@endforeach
				</ol>
			@endisset
		</div>
		<div class="col-sm-2">{{ str_replace('_', ' ', $v['status']) }} {{ $v['tangal_pembuatan'] }}</div>
	</div>
@endforeach -->

@foreach ($akta as $k => $v)
<div class="row ml-1 mr-1 mt-2 mb-3 primary-text-color" id="{{ $v['id'] }}" @if (!isset($mode)) class="border-top-0 border-left-0 border-right-0" style=" cursor: pointer;" data-url="{{ route('akta.show', ['id' => $v['id']]) }}" @else class="border-top-0 border-left-0 border-right-0" @endif >
	<div class="col-sm-4 pt-2">
		<div class="d-flex align-items-center">
			<i class="fa fa-file-o fa-3x"></i> &emsp;
			<h6 class="text-dark">{{ $v['judul'] }} <br/><small><i class="text-secondary">Terakhir diubah {{ $v['updated_at']->diffForHumans() }}</i></small></h4>
		</div>
	</div>
	<div class="col-sm-2 pt-2 text-center">
		{{ str_replace('_', ' ', $v['jenis']) }}
	</div>
	<div class="col-sm-4">
		<ol class="pl-2">
			@foreach ($v['klien'] as $kp => $vp)
			<li class="pt-2">{{ $vp['pemilik']['nama'] }} <br/><i class="fa fa-phone"></i> {{ $vp['pemilik']['telepon'] }}</li>
			@endforeach
		</ol>
	</div>
	<div class="col-sm-2 pt-2">
		{{ $v['status'] }} <i class="text-danger fa fa-exclamation"></i>
	</div>
</div>
@endforeach
<!-- <div class="row ml-1 mr-1 mt-2 mb-2 primary-text-color" id="{{ $v['id'] }}" @if (!isset($mode)) style="cursor: pointer; border-bottom:1px solid #eee" data-url="{{ route('akta.show', ['id' => $v['id']]) }}" @else style="border-bottom:1px solid #eee;" @endif >
	<div class="col-sm-4 pt-2">
		<div style="align-items:center;display: flex;">
			<i class="fa fa-file-o fa-3x"></i> &emsp;
			<h6 class="primary-text-color">PENDIRIAN PT. TIGA PUTRA KEMBAR KABUPATEN BADUNG <br/><small><i class="secondary-text-color">Terakhir diubah 1 hari yang lalu</i></small></h4>
		</div>
	</div>
	<div class="col-sm-2 pt-2">
		Akta Pendirian Perusahaan
	</div>
	<div class="col-sm-4">
		<ol class="pl-2">
			<li class="pt-2">Tuan Mulyo Agung <br/><i class="fa fa-phone"></i> 0873 2344 1450</li>
			<li class="pt-2">Tuan Galung Wuluh <br/><i class="fa fa-phone"></i> 031 591200</li>
			<li class="pt-2">PT Investama Surya Permai <br/><i class="fa fa-phone"></i> 0341 447558</li>
		</ol>
	</div>
	<div class="col-sm-2 pt-2">
		renvoi <i class="text-danger fa fa-exclamation"></i>
	</div>
</div> -->
