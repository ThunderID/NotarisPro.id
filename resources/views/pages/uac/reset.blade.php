@extends('templates.blank')

@push('styles')  
@endpush  

@section('content')			
	<div class="row login-dialog">
		<div class="col-12 col-sm-8 col-md-6 col-lg-4 offset-sm-2 offset-md-3 offset-lg-4">
			<div class="form-wrap">
				<h1>{{ str_replace("_", " ", env('APP_NAME')) }}</h1> 
				<hr>

				<p>{{ $page_attributes->title }}</p>
				</br>

				@include('components.alertbox')
				
				@component('components.form', [
					'store_url' => route('uac.reset.post', ['token' => $page_datas->token]),
					'data_id' 	=> null,
					'class'		=> ''
				])

					<div class="form-group">
						<label for="password" class="sr-only">Password</label>
						<input type="password" name="password" class="form-control set-focus" placeholder="Password baru Anda" required>
					</div>

					<div class="form-group">
						<label for="confirm_password" class="sr-only">Konfirmasi Password</label>
						<input type="password" name="confirm_password" class="form-control" placeholder="Konfirmasi password baru Anda" required>
					</div>

					</br>

					<input type="submit" id="btn-login" class="btn btn-primary btn-block" value="Reset Password">

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

