<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<title>{{ str_replace("_", " ", env('APP_NAME')) }}</title>

		<!-- Bootstrap Core CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
		<!-- Fa Icon -->
		<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
		<!-- Font -->
		<link href="https://fonts.googleapis.com/css?family=Quicksand:200,400,600" rel="stylesheet">

		<!-- Styles -->
        <style>
            html, body {
                font-family: 'Quicksand', sans-serif !important;
            }

            .container, .container-fluid{
            	font-size:10pt !important;
            }
            /* Palette generated by Material Palette - materialpalette.com/deep-purple/orange */
			.dark-primary-color    { background: #512DA8 !important; }
			.default-primary-color { background: #673AB7 !important; }
			.light-primary-color   { background: #D1C4E9 !important; }
			.text-primary-color    { color: #FFFFFF !important; }
			.accent-color          { background: #FF9800; }
			.primary-text-color    { color: #212121 !important; }
			.secondary-text-color  { color: #757575 !important; }
			.divider-color         { border-color: #BDBDBD; }
			.gray-color 		   { background-color: #EDECEC; }

			.btn-circle {
			  width: 30px;
			  height: 30px;
			  text-align: center;
			  padding: 6px 0;
			  font-size: 12px;
			  line-height: 1.428571429;
			  border-radius: 15px;
			}
			.btn-circle.btn-lg {
			  width: 50px;
			  height: 50px;
			  padding: 10px 16px;
			  font-size: 18px;
			  line-height: 1.33;
			  border-radius: 25px;
			}
			.btn-circle.btn-xl {
			  width: 70px;
			  height: 70px;
			  padding: 10px 16px;
			  font-size: 24px;
			  line-height: 1.33;
			  border-radius: 35px;
			}
        </style>

		@stack('fonts')

		<!-- Themes -->
		<link rel="stylesheet" href="{{ mix('css/app.css') }}">
		<!-- Custom Css -->
		@stack('styles')
	</head>
	<body>
		<!-- header -->
		@include ('apps.templates.components.header')

		<div class="container-fluid">
			<div class="row">
				<div class="col-12">
					@stack ('main')
				</div>
			</div>
		</div>

		<!-- Jquery -->
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js" integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4" crossorigin="anonymous"></script>

		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1" crossorigin="anonymous"></script>

		@stack('plugins')

		<!-- App -->
		<script src="{{ mix('js/app.js') }}"></script>

		<!-- Custom jQuery -->
		@stack('scripts')
	</body>
</html>