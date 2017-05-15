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
	    	Daerah Kerja : 
	    </p>
	</div>

	<div class="form font-editor page-editor" style="width: 17cm; min-height: 29.7cm; background-color: #fff;">
		<div class="form-group editor" style="page-break-inside: auto;">
			@foreach($page_datas->datas['paragraf'] as $key => $value)
				{!!$value['konten']!!}
			@endforeach

			<div style="page-break-after: always;"></div>

			<div style="width: 14.5cm;">
				<div style="padding-top: 1.5cm;margin-bottom: 1cm;">
					<p style="text-align: right;">...................,...........................</p>			
				</div>		
			</div>

			<table border="0" style="">
				<tr>
					<th style="width:7.5cm;"></th>
					<th style="width:7.5cm;"></th>
				</tr>
				<tr>
					<td>
						<div class="text-center">
							<p><b>TANDA TANGAN</b></p>
							<p>PIHAK 1</p>
							<br> 
							<br> 
							<br> 
							<p>......................</p>
						</div>
					</td>
					<td>
						<div class="text-center">
							<p><b>TANDA TANGAN</b></p>
							<p>PIHAK 1</p>
							<br> 
							<br> 
							<br> 
							<p>......................</p>
						</div>						
					</td>
				</tr>
			</table>						

			<!-- <div class="col-md-12" style="padding-top: 3cm;"></div>	 -->
		</div>	
	</div>

@stop