@extends('templates.basic')

@push('styles')  
@endpush  

@section('arsip')
	active
@stop

@section('data-arsip')
	active
@stop

@section('content')
	<div class="row">
		<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-9">
			<h4 class="title">{{$page_attributes->title}}</h4>	
			<h5>{{strtoupper($page_datas->arsip->jenis)}}</h5>	
			@foreach($page_datas->arsip->isi as $key => $value)
				<div class="row">
					<div class="col-sm-3">
						<p>{{ucwords(str_replace('_', ' ', $key))}}</p>
					</div>
					<div class="col-sm-9">
						<p>: {{ucwords($value)}}</p>
					</div>
				</div>
			@endforeach	
			<div class="clearfix">&nbsp;</div>
			@if(count($page_datas->arsip->relasi['dokumen']))
			<h5>Dokumen Terkait</h5>
			<div class="row">
				@foreach((array)$page_datas->arsip->relasi['dokumen'] as $key => $value)
					@foreach($value as $key2 => $value2)
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
							<a href="{{route('arsip.arsip.show', ['value' => $value2['id']])}}">						
								<h1>
									<i class="fa fa-file"></i>
								</h1>
								<p>[{{strtoupper($value2['jenis'])}}] {{$value2['relasi']}}</p>
							</a>
						</div>
					@endforeach
				@endforeach
			</div>
			@endif
			@if(count($page_datas->arsip->relasi['akta']))
			<h5>Akta Terkait</h5>
			<div class="row">
				@foreach((array)$page_datas->arsip->relasi['akta'] as $key => $value)
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-3 col-xl-3">
						<a href="{{route('akta.akta.show', ['value' => $value['id']])}}">						
							<h1>
								<i class="fa fa-file"></i>
							</h1>
							<p>[{{strtoupper($value['jenis'])}}] {{$value['judul']}}</p>
						</a>
					</div>
				@endforeach
			</div>
			@endif
		</div>	
		<div class="col-12 col-sm-12 col-md-4 col-lg-4 col-xl-3 hide-mobile sidebar subset-menu target-menu">
		</div>	
	</div>
@stop