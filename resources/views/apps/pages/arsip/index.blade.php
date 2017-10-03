@push ('main')
	@foreach($arsip as $k => $v)
		{{$v['pemilik']['nama']}}
	@endforeach
@endpush