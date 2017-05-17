@extends('templates.basic')

@push('styles')  
@endpush  

@section('content')
	<div class="row">

		@include('helpers.company_sidebar', ['active' => 'Pengaturan Akun'])

		<div class="col-12 col-sm-12 col-md-8 col-lg-8 col-xl-9 scrollable_panel subset-menu subset-sidebar target-panel">
			<div class="row">
				<div class="col-6">
					<h4 class="title">{{$page_attributes->title}}</h4>		
				</div>
				<div class="col-6 hidden-md-up text-right mobile-toggle-search">
					<a href="javascript:void(0);" class="btn btn-outline-primary btn-default btn-toggle-menu-on">
						<i class="fa fa fa-ellipsis-v" aria-hidden="true"></i>
					</a>
				</div>					
			</div>	
			<div class="row">
				<div class="col-12">
					@include('components.alertbox')
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-lg-10 col-xl-8">
					@component('components.form', [ 
						'data_id' 		=> $page_datas->id,
						'store_url' 	=> route('akun.store'), 
						'update_url' 	=> route('akun.update', ['id' => $page_datas->id]), 
					])

						<div class="row">
							<div class="col-12">
								@include('components.alertbox')
							</div>
						</div>					

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="email">Email</label>  
									<input name="akun_email" value="{{ old('email') ? old('email') : $page_datas->datas['email'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>

						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="password">Password</label>  
									<input name="akun_password" class="form-control" type="password" required>
								</div>
							</div>
						</fieldset>	
						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="password_confirmation">Konfirmasi Password</label>  
									<input name="akun_password_confirmation" class="form-control" type="password" required>
								</div>
							</div>
						</fieldset>	

						<fieldset class="form-group">
							</br>
						</fieldset>						
					
						<fieldset class="form-group">
							<div class="row">
								<div class="col-6">
									<button type="submit" class="btn btn-primary">Update</button>
								</div>
							</div>
						</fieldset>	
							
						<fieldset class="form-group">
							</br>
						</fieldset>
					@endcomponent	
				</div>
			</div>
		</div>	
	</div>	
@stop

@push('scripts')  
@endpush 
