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
				<div class="col-sm-4 offset-sm-4 text-center" style="padding-top:75px;padding-bottom:240px;">
					<h2>Forgot Password</h2>
					<p> 
						Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
					</p>

					<form class="text-left" action="{{route('uac.reset.store')}}" method="POST">

						<div class="form-group">
							<!-- <label for="exampleInputEmail1">Email address</label> -->
							<input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email" name="email" />
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
	<section id="market-web-trial-footer">
		<div class="container">
			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
@endsection