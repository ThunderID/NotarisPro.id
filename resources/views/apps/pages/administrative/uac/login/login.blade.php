@push ('main')
	<div class="row justify-content-center">
		<div class="col-4 text-center">
			<h1><a href="">{{ str_replace("_", " ", env('APP_NAME')) }}</a></h1> 
			<hr>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-4 text-center">
			<h3 class="pb-4">{{ $page_attributes->title }}</h3>
			<p class="text-left"> {!! $page_attributes->subtitle !!}</p>
		</div>
	</div>
	<div class="row justify-content-center">
		<div class="col-4">
			{!! Form::open(['url' => route('uac.login.store'), 'method' => 'post']) !!}
				{!! Form::bsText(null, 'email', null, ['placeholder' => 'Masukkan email']) !!}
				{!! Form::bsPassword(null, 'password', ['placeholder' => 'Masukkan password']) !!}
				{!! Form::bsSubmit('LOGIN', ['class' => 'btn btn-primary btn-block mb-3']) !!}
				<a href="#" class="float-text">Lupa Password?</a>
				<a href="#" class="float-right">Sign Up</a>

			{!! Form::close() !!}
		</div>
	</div>
		{{-- <div class="col-sm-4 offset-sm-4 text-center" style="padding-top:0px;padding-bottom:180px;">
			<h3 class="pb-4"></h3>
			<p class="text-left"> 
				
			</p>
				
			<div class="row">
				<div class="col-12">
					
				</div>
			</div>

			<form class="text-left" action="{{route('uac.login.store')}}" method="POST">

				<div class="form-group">
					<!-- <label for="exampleInputEmail1">Email address</label> -->
					<input type="email" class="form-control set-focus" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" />
					<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
				</div>

				<div class="form-group">
					<!-- <label for="exampleInputPassword1">Password</label> -->
					<input type="password" class="form-control" id="exampleInputPassword1" aria-describedby="passwordHelp" placeholder="Enter password" name="password" />
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-sm-6 text-left">
							<a href="">Lupa Password ?</a>
						</div>
						<div class="col-sm-6 text-right">
							<a href="">Sign Up</a>
						</div>
					</div>
				</div>

				<button type="submit" class="btn btn-primary" style="width:100%;">Submit</button>
			</form>
		</div>
	</div> --}}
@endpush