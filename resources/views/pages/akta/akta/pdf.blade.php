@extends('templates.print')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  
	html{ margin: 2cm 1cm 3cm 5cm; }

	p, ul, ol, h5 {
		margin-top: 0;
		margin-bottom: 0;
	}
	body {
		font-family: 'Inconsolata', monospace !important;
	}

	@page { margin: 2cm 1cm 3cm 5cm; }

	.header,
	.footer {
	    width: 100%;
	    text-align: left;
	    position: fixed;
	    border-top: 1px solid black;
	    font-size: 0.8rem;
	}
	.header {
	    top: 0px;
	}
	.footer {
	    bottom: 0px;
	}
	.pagenum:before {
	    content: counter(page);
	}	
@endpush  

@section('content')

	<div class="footer">
	    <p>
			{{ $page_datas->notaris['nama'] }}
	    	<span style="float:right;">Halaman <span class="pagenum"></span>
	    </p>
	    <p>
			Daerah Kerja {{ $page_datas->notaris['daerah_kerja'] }}
	    </p>
	</div>

	<div class="form font-editor page-editor" style="width: 21cm; min-height: 29.7cm; background-color: #fff;">
		<div class="form-group editor">
			@foreach($page_datas->datas['paragraf'] as $key => $value)
				{!!$value['konten']!!}
			@endforeach
		</div>	
	</div>

@stop