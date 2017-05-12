@extends('templates.print')

@push('fonts')
	<!-- <link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet"> -->
@endpush

@push('styles')  
	
	body {
		font-family: 'monospace';
	}
	html{
		margin:0;
	}
	html p {
		font-family: monospace;
		font-size: 1rem;
	}

	p, ul, ol, h5 {
		margin-top: 0;
		margin-bottom: 0;
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