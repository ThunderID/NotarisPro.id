@extends('templates.basic')

@push('styles')  
@endpush  

@section('content')
	<div class="row">

		@include('helpers.company_sidebar', ['active' => 'Pengaturan developer'])

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
						'store_url' 	=> route('pengaturan.developer.update', ['id' => $page_datas->id]), 
						'update_url' 	=> route('pengaturan.developer.update', ['id' => $page_datas->id]), 
					])

						<div class="row">
							<div class="col-12">
								@include('components.alertbox')
							</div>
						</div>					
						
						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="GCAL"><strong>Google Calendar</strong></label>  
								</div>
								<div class="col-12">
									<label class="control-label" for="gcal_key"><small>Key</small></label>  
									<input name="developer_gcal_key" value="{{ old('gcal_key') ? old('gcal_key') : $page_datas->akun['kantor']['thirdparty']['gcal']['key'] }}" class="form-control" type="text" required>
								</div>
								<div class="col-12">
									<label class="control-label" for="gcal_secret"><small>Secret</small></label>  
									<input name="developer_gcal_secret" class="form-control" type="password" required>
								</div>
							</div>
						</fieldset>	
						
						<div class="clearfix">&nbsp;</div>
						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="BOX"><strong>Dropbox</strong></label>  
								</div>
								<div class="col-12">
									<label class="control-label" for="dbox_token"><small>Access Token</small></label>  
									<input name="developer_dbox_token" value="{{ old('dbox_token') ? old('dbox_token') : $page_datas->akun['kantor']['thirdparty']['dbox']['token'] }}" class="form-control" type="text" required>
								</div>
							</div>
						</fieldset>	
						
						<div class="clearfix">&nbsp;</div>
						<fieldset class="form-group">
							<div class="row">
								<div class="col-12">
									<label class="control-label" for="SMTP"><strong>SMTP Mail<strong></label>  
								</div>
								<div class="col-12">
									<label class="control-label" for="smtp_email"><small>Email</small></label>  
									<input name="developer_smtp_email" value="{{ old('smtp_email') ? old('smtp_email') : $page_datas->akun['kantor']['thirdparty']['smtp']['email'] }}" class="form-control" type="text" required>
								</div>
								<div class="col-12">
									<label class="control-label" for="smtp_password"><small>Password</small></label>  
									<input name="developer_smtp_password" class="form-control" type="password" required>
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
