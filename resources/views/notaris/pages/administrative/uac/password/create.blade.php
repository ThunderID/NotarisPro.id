@extends('market_web.layout.master')

@section('content')

	<!-- TOPBAR -->
	{{--
	<section id="market-web-trial-topbar">
		<div class="container">
			@include('market_web.components.topbar_plain')
		</div>
	</section>
	--}}
	
	<!-- SLIDE -->
	<section id="market-web-trial-login">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 offset-sm-4 text-center" style="padding-top:85px;padding-bottom:10px;">
					<h1><a href="{{route('web.home.index')}}">{{ str_replace("_", " ", env('APP_NAME')) }}</a></h1> 
					<hr>
				</div>			
				<div class="col-sm-4 offset-sm-4 text-center" style="padding-top:0px;padding-bottom:180px;">
					<h3 class="pb-4">Forgot Password</h3>
					<p class="text-left"> 
						Kami akan mengirimkan link reset password ke Email Anda :
					</p>

					<form class="text-left" action="{{route('uac.reset.store')}}" method="POST">

						<div class="form-group">
							<!-- <label for="exampleInputEmail1">Email address</label> -->
							<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" value="{{$page_datas->datas['email']}}" />
							<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
						</div>

						<div class="form-group">
							<div class="row">
								<div class="col-sm-6 text-left">
									<a href="{{route('uac.login.create')}}">Sign In</a>
								</div>
							</div>
						</div>

						<button type="submit" class="btn btn-primary" style="width:100%;">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>

	<!-- FOOTER -->
	{{--
	<section id="market-web-trial-footer">
		<div class="container">
			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
	--}}
@endsection