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
					<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
						&nbsp;
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<ul class="nav menu-content justify-content-end">
							<li class="nav-item">
								<span class="nav-link">&nbsp;</span>
							</li>
							<!--<li class="nav-item">
								<span class="nav-link">Zoom</span>
							</li>
							<li class="nav-item">
								<span class="nav-link">Halaman</span>
							</li>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">A4</a>
								<div class="dropdown-menu dropdown-menu-right">
									<a class="dropdown-item" href="#">A4</a>
									<a class="dropdown-item" href="#">F4</a>
								</div>
							</li> -->
							<!-- <li class="nav-item">
								<a class="nav-link" href="#" data-toggle="modal" data-target="#form-title"><i class="fa fa-save"></i> Simpan</a>
							</li> -->
						</ul>
					</div>
				</div>
				{{-- END COMPONENT MENUBAR --}}
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<div class="col">&nbsp;</div>
					<div class="col-9 d-flex justify-content-center">
						<div class="form mt-3 mb-3 font-editor" style="width: 21cm; height: 29.7cm; background-color: #fff; padding-top: 2cm; padding-bottom: 3cm; padding-left: 5cm; padding-right: 1cm;">
							<div class="form-group p-3">
								@foreach($page_datas->datas['akta']['paragraf'] as $key => $value)
									{!!$value['konten']!!}
								@endforeach
							</div>
						</div>
					</div>
					<div class="col">&nbsp;</div>	
				</div>
			</div>
			<div class="clearfix">&nbsp;</div>
		</div>
@stop

@push('scripts')
@endpush 