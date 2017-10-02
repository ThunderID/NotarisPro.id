@push ('main')
	<section id="market-web-trial-login">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-4 text-center">
					<h1><a href="">{{ str_replace("_", " ", env('APP_NAME')) }}</a></h1> 
					<hr>
				</div>		
			</div>
			<div class="row justify-content-center">	
				<div class="col-4 text-center">
					<h4 class="pb-4">Forgot Password</h4>
					<p class="text-left"> 
						Kami akan mengirimkan link reset password ke Email Anda :
					</p>

					{!! Form::open(['url' => route('uac.login.store'), 'method' => 'post']) !!}
						{!! Form::bsText(null, 'email', !is_null($page_datas->datas['email'] ? $page_datas->datas['email'] : null), ['class' => 'form-control', 'placeholder' => 'Enter email']) !!}
						{!! Form::bsSubmit('Send Link Reset Password', ['class' => 'btn btn-primary btn-block']) !!}
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
@endpush