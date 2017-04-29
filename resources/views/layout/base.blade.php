<!DOCTYPE html>
<html>
    <head>
        <title>{{ str_replace("_", " ", env('APP_NAME')) }}</title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />

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
        <!-- template -->
        @yield('template')           

        <!-- Jquery -->
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

        <!-- Bootstrap -->
        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- App -->
        <script src="{{ mix('js/app.js') }}"></script>

        <!-- Custom jQuery -->
        <script type="text/javascript">
            @stack('scripts')
        </script>        
    </body>
</html>