@extends('templates.print')

@push('fonts')
	<link href="https://fonts.googleapis.com/css?family=Inconsolata:400,700" rel="stylesheet">
@endpush

@push('styles')  

	p, ul, ol, h5 {
		margin-top: 0;
		margin-bottom: 0;
	}
	h4{
		text-align: left !important;
		padding:0px !important; 
		margin:0px !important; 
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

<?php
	// dd($page_datas);
?>

	<div class="footer">
	    <p>
			{{ $page_datas->notaris['nama'] }}
	    	<span style="float:right;">Halaman <span class="pagenum"></span>
	    </p>
	    <p>
	    	Daerah Kerja : {{ $page_datas->notaris['notaris']['daerah_kerja'] }}
	    </p>
	</div>

	<div class="form font-editor page-editor" style="width: 15cm; min-height: 29.7cm; background-color: #fff;">
		<div class="form-group editor" style="page-break-inside: auto;">
			@foreach($page_datas->datas['paragraf'] as $key => $value)
				{!!$value['konten']!!}
			@endforeach

			<div style="page-break-after: always;"></div>

			<div style="width: 14.5cm;">
				<div style="padding-top: 1.5cm;margin-bottom: 1.5cm;">
					<p style="text-align: right;">...................,...........................</p>			
				</div>		
			</div>

			<table border="0" style="">
				<tr>
					<th style="width:7.5cm;"></th>
					<th style="width:7.5cm;"></th>
				</tr>
				@for($i = 0; $i < $page_datas->datas['jumlah_pihak']; $i++)

					@if($i % 2 == 0)
						<tr>
					@endif

					<td>
						<div class="text-center">
							<p><b>TANDA TANGAN</b></p>
							<p>PIHAK {{$i++}}</p>
							<br> 
							<br> 
							<br> 
							<p>......................</p>
						</div>
					</td>

					@if(!$i % 2 == 0)
						</tr>
					@endif

				@endfor
			</table>						

			<!-- <div class="col-md-12" style="padding-top: 3cm;"></div>	 -->
		</div>	
	</div>

@stop