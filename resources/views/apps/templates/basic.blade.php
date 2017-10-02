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
		<link href="https://fonts.googleapis.com/css?family=Muli:200,400,600" rel="stylesheet">

		@stack('fonts')

		<!-- Themes -->
		<link rel="stylesheet" href="{{ mix('css/app.css') }}">
		<!-- Custom Css -->
		<style>
			@stack('styles')
		</style>


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
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
		<!-- Bootstrap -->
		<script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js" type="text/javascript"></script>

		@stack('plugins')

		<!-- App -->
		<script src="{{ mix('js/app.js') }}"></script>

		<!-- Custom jQuery -->
		<script type="text/javascript">
			@stack('scripts')
		</script>        
	</body>
</html>