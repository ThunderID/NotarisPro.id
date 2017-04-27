@extends('templates.basic')

@push('styles')  
	body {background-color: rgba(0, 0, 0, 0.075) !important;}

}

@media screen and (min-width: 800px) {
  
@endpush  

@section('akta')
	active
@stop

@section('buat-akta')
	active
@stop

@section('content')
	<div class="row">
		<div class="container">
			<div class="col-12 col-sm-10 col-md-8 col-xl-8 offset-sm-1 offset-md-2 offset-xl-2 input_panel">
				<div class="row">
					<div class="col-12">
						<h4 class="title ml-3">{{ $page_attributes->title }}</h4>
					</div>
				</div>
				<div class="col-12">
					<div class="form-group has-feedback">
						<input type="text" class="search form-control" placeholder="cari nama template">
						<span class="glyphicon glyphicon-search form-control-feedback" aria-hidden="true"></span>
					</div>
				</div>
				<div class="row p-3">

					@foreach ($page_datas->datas as $k => $v)
						<div class="col-md-4 mb-3">
							<div class="card">
								<div class="card-block">
									<h4 class="card-title text-center pb-3"><i class="fa fa-file-text fa-2x"></i></h4>
									<p class="card-text"><small>{{ !is_null($v['judul']) ? $v['judul'] : '' }}</small></p>
								</div>
								<a href="{{ route('akta.akta.create', ['template_id' => $v['id']]) }}" class="btn btn-primary btn-sm btn-block">Pilih</a>
							</div>
						</div>
					@endforeach

				</div>
				<div class="clearfix">&nbsp;</div>
			</div>
		</div>
	</div>
@stop

@push('scripts')  
	/* functions */

	// equal height
	var eh = window.equalHeight;
	eh.target = $('.card-block');

	function alignHeight(){
		eh.do();	
	}

	function alignHeightReset(){
		eh.reset();
	}

	/* Handlers */
	$(document).ready(function(){
	    alignHeight();
	});
	$( window ).resize(function() {
		alignHeightReset();
	    alignHeight();
	});	
@endpush 
