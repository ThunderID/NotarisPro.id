@extends('templates.blank')

@push('styles')  
@endpush  

@section('content')			
	<div class="row login-dialog">
		<div class="col-12 col-sm-8 col-md-6 col-lg-4 offset-sm-2 offset-md-3 offset-lg-4">
			<div class="form-wrap">
				<h1>{{ str_replace("_", " ", env('APP_NAME')) }}</h1> 
				<hr>

				<p>Silahkan masukkan email dan password Anda!</p>
				</br>

				@include('components.alertbox')
				
				@component('components.form', [
					'store_url' => route('uac.login.post'),
					'data_id' 	=> null,
					'class'		=> 'mt-3'
				])

					<div class="form-group">
						<label for="email" class="sr-only">Email</label>
						<input type="email" name="email" id="email" class="form-control set-focus" placeholder="Email Anda" required>
					</div>
					<div class="form-group">
						<label for="password" class="sr-only">Password</label>
						<input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
					</div>
					<div class="form-group text-right">
						<a href="javascript:void(0);" data-toggle="modal" data-target="#reset_pwd">Reset Password</a>
					</div>

					</br>

					<input type="submit" id="btn-login" class="btn btn-primary btn-block" value="Login">

				@endcomponent
		
			</div>
		</div>
	</div>
@stop

	@component('components.modal', [
		'id'		=> 'reset_pwd',
		'title'		=> 'Reset Password',
		'settings'	=> [
			'modal_class'	=> '',
			'hide_buttons'	=> 'true',
			'hide_title'	=> 'true',
		]
	])
		<form class="form-widgets text-left form" action="{{ route('uac.reset.send') }}" method="POST">
			<fieldset class="from-group mb-2">
				<span class="label label-default">Email Anda</span>
				<input type="email" name="email" class="form-control parsing set-focus" required />
				<span>
					<small>
						* kami akan mengirimkan tautan reset password ke email Anda
					</small>
				</span>
			</fieldset>

			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
				<button type="submit" class="btn btn-primary" data-save="true">Ok</button>
			</div>
		</form>	
	@endcomponent	

@push('scripts')  
	$('document').ready( function() {
		$('.set-focus').focus();
	});
@endpush 

