<div class="row ml-1 mr-1" style="border-bottom:1px solid #eee">
	<div class="col-sm-4 mb-2">
		<strong>DOKUMEN</strong>
	</div>
	<div class="col-sm-2 mb-2">
		<strong>JENIS</strong>
	</div>
	<div class="col-sm-4 mb-2">
		<strong>PIHAK</strong>
	</div>
	<div class="col-sm-2 mb-2">
		<strong>STATUS</strong>
	</div>
</div>
<!-- @foreach ($akta as $k => $v)
	<div class="row ml-1 mr-1 mt-2 mb-2" id="{{ $v['id'] }}" @if (!isset($mode)) style="cursor: pointer" data-url="{{ route('akta.akta.ajax.show', ['id' => $v['id']]) }}" @endif>
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
<div class="row ml-1 mr-1 mt-2 mb-2 primary-text-color" id="{{ $v['id'] }}" @if (!isset($mode)) style="cursor: pointer; border-bottom:1px solid #eee" data-url="{{ route('akta.akta.ajax.show', ['id' => $v['id']]) }}" @else style="border-bottom:1px solid #eee;" @endif >
	<div class="col-sm-4 pt-2">
		<div style="align-items:center;display: flex;">
			<i class="fa fa-file-o fa-3x"></i> &emsp;
			<h6 class="primary-text-color">{{$v['judul']}} <br/><small><i class="secondary-text-color">Terakhir diubah {{$v['updated_at']->diffForHumans()}}</i></small></h4>
		</div>
	</div>
	<div class="col-sm-2 pt-2">
		{{$v['jenis']}}
	</div>
	<div class="col-sm-4">
		<ol class="pl-2">
			@foreach($v['pihak'] as $kp => $vp)
			<li class="pt-2">{{$vp['nama']}} <br/><i class="fa fa-phone"></i> {{$vp['telepon']}}</li>
			@endforeach
		</ol>
	</div>
	<div class="col-sm-2 pt-2">
		{{$v['status']}} <i class="text-danger fa fa-exclamation"></i>
	</div>
</div>
@endforeach
<!-- <div class="row ml-1 mr-1 mt-2 mb-2 primary-text-color" id="{{ $v['id'] }}" @if (!isset($mode)) style="cursor: pointer; border-bottom:1px solid #eee" data-url="{{ route('akta.akta.ajax.show', ['id' => $v['id']]) }}" @else style="border-bottom:1px solid #eee;" @endif >
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
