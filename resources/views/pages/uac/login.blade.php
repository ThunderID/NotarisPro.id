@extends('templates.blank')

@push('styles')  
@endpush  

@section('content')			
	<div class="row" style="padding-top:21vh;">
		<div class="col-4 offset-4">
			<div class="form-wrap">
				<h1>{{ Config::get('app.name') }}</h1> 
				<hr>

				<p>Silahkan masukkan email dan password Anda!</p>
				</br>

				@include('components.alertbox')
				
				@component('components.form', [
					'store_url' => 'uac.login.post',
					'data_id' 	=> null
				])

					<div class="form-group">
						<label for="email" class="sr-only">Email</label>
						<input type="email" name="email" id="email" class="form-control" placeholder="Email Anda" required>
					</div>
					<div class="form-group">
						<label for="key" class="sr-only">Password</label>
						<input type="password" name="key" id="key" class="form-control" placeholder="Password" required>
					</div>

					</br>

					<input type="submit" id="btn-login" class="btn btn-primary btn-block" value="Login">

				@endcomponent
		
			</div>
		</div>
	</div>
@stop

@push('scripts')  
@endpush 

