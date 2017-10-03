@push ('main')
	@foreach($akta as $k => $v)
		{{$v['judul']}}
	@endforeach
@endpush