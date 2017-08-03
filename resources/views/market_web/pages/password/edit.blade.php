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
					<h2>Change Password</h2>
					<p> 
						Neque porro quisquam est qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit...
					</p>

					<form class="text-left" action="{{route('uac.reset.update', ['token' => $page_datas->datas['token']])}}" method="POST">
						<div class="form-group">
							<input type="password" class="form-control" id="exampleInputPassword1" aria-describedby="passwordHelp" placeholder="New password" name="password"/>
						</div>
						<div class="form-group">
							<input type="password" class="form-control" id="exampleInputRepeatPassword1" aria-describedby="repeatPasswordHelp" placeholder="Repeat password" name="repeat-password"/>
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