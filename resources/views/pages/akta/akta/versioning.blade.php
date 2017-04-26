@extends('templates.basic')

@push('styles')  
@endpush  

@section('akta')
	active
@stop

@section('data-akta')
	active
@stop

@section('content')
	
		<div class="row" style="background-color: rgba(0, 0, 0, 0.075);">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				{{-- COMPONENT MENUBAR --}}
				<div class="row bg-faded">
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6" style="margin-left:-15px;">
						<ul class="nav menu-content justify-content-start">
							<li class="nav-item">
								<a class="nav-link" href=""><i class="fa fa-undo"></i> Kembali</a>
							</li>
						</ul>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						&nbsp;
					</div>
				</div>
				{{-- END COMPONENT MENUBAR --}}
			</div>
		</div>
	</div>

@stop