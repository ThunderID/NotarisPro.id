@extends('templates.basic')

@push('styles')  
	body { 
		background-color: rgba(0, 0, 0, 0.075) !important; 
	}
	a.choice-template:hover .hover{
		display: block;
	}
	a.choice-template .hover {
		display: none;
		background-color: rgba(2, 90, 165, 0.95);
		position: absolute;
	}
	a.choice-template .hover span {
		color: #fff !important;
		position: relative;
		top: 45%;
		padding: 5px 15px;
		border: 1px solid #fff;
	}
@endpush  

@section('akta')
	active
@stop

@section('buat-akta')
	active
@stop

@section('content')
	@component('components.form', [ 
			'data_id'		=> null,
			'store_url' 	=> route('akta.template.create'), 
			'class'			=> 'mb-0'
		])
		<div id="information" style="display: block;">
			<div class="row align-items-center">
				<div class="col-12 col-sm-10 col-md-6 col-xl-6 input_panel pb-0 mx-auto">
					<div class="form">
						<h4 class="title">Form Informasi Template</h4>
						<div class="form-group">
							<label>Judul</label>
							<input type="text" name="nama" class="form-control required" placeholder="Judul dari Template Klien">
						</div>
						<div class="clearfix">&nbsp;</div>
						<div class="form-group text-right pb-3">
							<button class="btn btn-primary" type="submit">
								<i class="fa fa-gears"></i> Generate Template
							</button>
						</div>
					</div>
				</div>
				
			</div>
		</div>
	@endcomponent
@stop

@push('scripts')  
	
@endpush 
