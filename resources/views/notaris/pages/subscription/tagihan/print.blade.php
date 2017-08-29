<!DOCTYPE html>
<html>
<head>
	<title>PRINT INVOICE</title>

	<!-- Bootstrap Core CSS -->
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />

	<!-- Fa Icon -->
	<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

	<!-- Font -->
	<link href="https://fonts.googleapis.com/css?family=Muli:200,400,600" rel="stylesheet">

	<link rel="stylesheet" href="{{url('/assets/tagihan/invoice/css/style.css')}}">
	<link rel="stylesheet" href="{{url('/assets/tagihan/invoice/css/print.css')}}">
</head>
<body>
	<div id="page-wrap">
		@include('notaris.pages.subscription.tagihan.small_pieces_invoice', ['data' => $page_datas->tagihan, 'kantor' => $page_datas->active_office['kantor']])
	</div>
</body>
</html>