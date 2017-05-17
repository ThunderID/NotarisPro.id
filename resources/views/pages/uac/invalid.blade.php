@extends('templates.blank')

@push('styles')  
@endpush  

@section('content')			
	<div class="row login-dialog">
		<div class="col-12 col-sm-8 col-md-6 col-lg-4 offset-sm-2 offset-md-3 offset-lg-4">
			<div class="form-wrap">
				<h1>{{ str_replace("_", " ", env('APP_NAME')) }}</h1> 
				<hr>

				<p>Silahkan masukkan email. Link reset password akan dikirmkan ke email Anda</p>
				</br>

				@include('components.alertbox')
				
				@component('components.form', [
					'store_url' => route('uac.login.post'),
					'data_id' 	=> null,
					'class'		=> ''
				])

					<div class="form-group">
						<label for="email" class="sr-only">Email</label>
						<input type="email" name="email" id="email" class="form-control set-focus" placeholder="Email Anda" required>
					</div>

					</br>

					<input type="submit" id="btn-login" class="btn btn-primary btn-block" value="Login">

				@endcomponent
		
			</div>
		</div>
	</div>
@stop

@push('scripts')  
	$('document').ready( function() {
		$('.set-focus').focus();
	});
@endpush 

