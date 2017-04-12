<!DOCTYPE html>
<html>
    <head>
        <title>{{ Config::get('app.name') }} </title>

        <!-- Bootstrap Core CSS -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-alpha.6/css/bootstrap.css" />

        <!-- Fa Icon -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">

        <!-- Font -->
        <link href="https://fonts.googleapis.com/css?family=Muli:200,400,600" rel="stylesheet">

        <!-- Custom Css -->
        <style>
            /*general*/
            body{
                font-family: 'Muli', sans-serif;
            }

            /*navbar*/
            .navbar{
                letter-spacing: 0.5pt;
            }

            .navbar .dropdown-menu {
                font-size: 0.8rem;
                border-radius: 0px;
                margin-top: 9px;
                margin-left: -3px;
                padding: 0px;
                border-top: transparent;
            }

            .navbar .dropdown-item {
                padding-left: 15px;
                padding-right: 15px;
                padding-top: 5px;
                padding-bottom: 5px;
            }

            .navbar .nav-item .nav-link{
                padding-right: 0.9rem;
                padding-left: 0.9rem;
                font-size: 0.9rem;
                padding-top: 0.7rem;
                padding-bottom: 0.3rem;                
            }
            .navbar-inverse .navbar-toggler{
                border-color: transparent;
                padding-top: 8px;
            }

            .navbar-inverse .navbar-toggler:focus{
                outline: none;
            }            

            .navbar .menu-mobile{
                padding-top: 30px;
                height: 100vh;
            }

            .navbar .menu-mobile .menu-item > div{
                height: 100px; 
                background-color: white;
            }

            .navbar .dropdown-item.active{
                color: #0275d8;
                text-decoration: none;
                background-color: white;
            } 

            @stack('styles')

        </style>


    </head>
    <body>
        <!-- template -->
        @yield('template')           

        <!-- Jquery -->
        <script src="https://code.jquery.com/jquery-3.2.1.min.js" type="text/javascript"></script>

        <!-- Bootstrap -->
        <script src="https://npmcdn.com/tether@1.2.4/dist/js/tether.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/js/bootstrap.min.js" type="text/javascript"></script>

        <!-- Custom jQuery -->
        <script type="text/javascript">
            @stack('scripts')
        </script>        
    </body>
</html>