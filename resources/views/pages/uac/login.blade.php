@extends('templates.blank')

@push('styles')  
@endpush  

@section('content')			
	<div class="row login-dialog">
		<div class="col-4 offset-4">
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

