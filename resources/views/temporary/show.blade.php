<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
		<head>
				<meta charset="utf-8">
				<meta http-equiv="X-UA-Compatible" content="IE=edge">
				<meta name="viewport" content="width=device-width, initial-scale=1">

				<title>Laravel</title>

				<link href="https://fonts.googleapis.com/css?family=Inconsolata" rel="stylesheet">

				<style type="text/css">
					body {
						font-family: Inconsolata
					}
				</style> 
		</head>
		<body>
			@foreach($new_text as $key => $value)
				{{$value}}
			@endforeach
		</body>
</html>
