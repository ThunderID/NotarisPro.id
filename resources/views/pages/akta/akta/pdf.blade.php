@extends('templates.print')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  
	html{
		margin:0;
	}

	p, ul, ol, h5 {
		margin-top: 0;
		margin-bottom: 0;
	}
	body {
		font-family: 'Inconsolata', monospace !important;
	}
@endpush  

@section('content')

	<div class="form font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 0cm; padding-left: 5cm; padding-right: 1cm; ">
		<div class="form-group editor">
			@foreach($page_datas->datas['paragraf'] as $key => $value)
				{!!$value['konten']!!}
			@endforeach
		</div>	
	</div>

@stop