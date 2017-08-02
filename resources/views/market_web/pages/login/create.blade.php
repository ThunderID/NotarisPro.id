@extends('market_web.layout.master')

@section('content')

	<!-- TOPBAR -->
	<section id="market-web-trial-topbar">
		<div class="container">
			@include('market_web.components.topbar_plain')
		</div>
	</section>
	
	<!-- SLIDE -->
	<section id="market-web-trial-login">
		<div class="container">
			<div class="row">
				<div class="col-sm-4 offset-sm-4 text-center" style="padding-top:75px;padding-bottom:180px;">
					<h2>{{$page_attributes->title}}</h2>
					<p> 
						{{$page_attributes->subtitle}}
					</p>

					<form class="text-left" action="{{route('uac.login.store')}}" method="POST">

						<div class="form-group">
							<!-- <label for="exampleInputEmail1">Email address</label> -->
							<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" />
							<!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
						</div>

						<div class="form-group">
							<!-- <label for="exampleInputPassword1">Password</label> -->
							<input type="password" class="form-control" id="exampleInputPassword1" aria-describedby="passwordHelp" placeholder="Enter password" name="password" />
						</div>
						<div class="form-group">
							<div class="row">
								<div class="col-sm-6 text-left">
									<a href="{{route('uac.reset.create')}}">Lupa Password ?</a>
								</div>
								<div class="col-sm-6 text-right">
									<a href="{{route('uac.signup.create')}}">Sign Up</a>
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
	<section id="market-web-trial-footer">
		<div class="container">
			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
@endsection