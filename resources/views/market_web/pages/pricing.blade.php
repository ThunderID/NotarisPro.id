@extends('market_web.layout.master')

@section('content')

	<!-- TOPBAR -->
	<section id="market-web-pricing-topbar">
		<div class="container">
			@include('market_web.components.topbar')
		</div>
	</section>
	
	<!-- PRICING -->
	<section id="market-web-pricing-video">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center" style="padding-top:50px;padding-bottom:50px;">
					<h1>PRICING GUIDE</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-3 offset-sm-2 text-center" style="border:1px solid;padding:30px;">
					<h1 style="padding:40px;">FREE<br/>TRIAL</h1>
					<h3> 
						<a href="{{route('uac.tsignup.create')}}" class="btn btn-default" style="border:1px solid;">
							SUBSCRIBE
						</a>
					</h3>

					<ul class="text-justify" style="margin-top:50px;padding-top:15px;border-top:1px solid;padding-left:15px;">
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet nibh metus. Suspendisse sodales non ligula consectetur lobortis. Aliquam egestas dui quis elementum gravida.</li>
						<li> Nulla dictum ornare ultricies. Aliquam nec turpis eros. Etiam risus purus, tempus sed consequat sed, consectetur at ex. Cras sit amet viverra leo, ac bibendum est.</li>
						<li>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed interdum nisi sed elit auctor maximus. Vestibulum id dui leo.</li>
					</ul>
				</div>
				<div class="col-sm-3 offset-sm-2 text-center" style="border:1px solid;padding:30px;">
					<h5 style="padding:15px;">STARTER</h5>
					<h1 style="padding:30px;"><sup><small><small><small>IDR</small></small></small></sup>500K</h1>
					<h3 style="padding-top:5px;"> 
						<a href="{{route('uac.signup.create')}}" class="btn btn-default" style="border:1px solid;">
							SUBSCRIBE
						</a>
					</h3>

					<ul class="text-justify" style="margin-top:50px;padding-top:15px;border-top:1px solid;padding-left:15px;">
						<li>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur sit amet nibh metus. Suspendisse sodales non ligula consectetur lobortis. Aliquam egestas dui quis elementum gravida.</li>
						<li> Nulla dictum ornare ultricies. Aliquam nec turpis eros. Etiam risus purus, tempus sed consequat sed, consectetur at ex. Cras sit amet viverra leo, ac bibendum est.</li>
						<li>Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Sed interdum nisi sed elit auctor maximus. Vestibulum id dui leo.</li>
						<li>Nulla pellentesque dolor id nibh tincidunt sodales. Integer eget magna eu odio mattis volutpat et in sapien. Cras sed rhoncus nisi. Duis feugiat mi eget efficitur gravida.</li>
					</ul>
				</div>
			</div>
		</div>
	</section>
	
	<!-- PARTNER -->
	<section id="market-web-pricing-partner" style="padding-bottom:100px;">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 text-center" style="padding-top:100px;padding-bottom:50px;">
					<h1>OUR PARTNERS</h1>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12 text-center">
					<img style="max-width:150px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/4/4e/Warren_Buffett_Signature.svg/150px-Warren_Buffett_Signature.svg.png">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img style="max-width:150px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/3/34/Bill_Gates_signature.svg/594px-Bill_Gates_signature.svg.png">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img style="max-width:150px" src="http://www.theworldofhandwriting.com/uploads/3/3/8/3/3383553/1667056.png">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img style="max-width:150px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d4/Mark_Zuckerberg_Signature.svg/150px-Mark_Zuckerberg_Signature.svg.png">
				</div>
				<div class="col-sm-12 text-center">
					<img style="max-width:150px" src="https://upload.wikimedia.org/wikipedia/commons/1/19/Elon_Musk_Signature.png">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img style="max-width:150px" src="http://www.justfamilylaw.com/wp-content/uploads/2014/09/John-Bledsoe-signature-rotated.jpg">
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img style="max-width:150px" src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2f/C_Coolidge_signature.svg/381px-C_Coolidge_signature.svg.png">
				</div>
				<div class="col-sm-12 text-center" style="padding-top:25px;">
					<h2> 
						<a href="#" class="btn btn-default" style="border:1px solid;">
							TRY FOR FREE
						</a>
					</h2>
				</div>
			</div>
		</div>
	</section>

	<!-- FOOTER -->
	<section id="market-web-pricing-footer" style="background-color:rgb(239, 239, 239)">
		<div class="container">
			<!-- CONTACT INFORMATION -->
			@include('market_web.components.contact_information')

			<!-- FOOTER -->
			@include('market_web.components.footer')
		</div>
	</section>
@endsection