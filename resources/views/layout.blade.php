<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <!-- Styles -->
        <link rel="stylesheet" href="css/app.css">
        <link rel="stylesheet" href="css/layout-styles.css">
        @yield('extraStyles')
    </head>
    <nav class="navbar flex-center position-ref ">
        <div class="top-left home">
            <a href="{{ url('/') }}">Rolo</a>
        </div>
        <div class="top-right links">
            <a href="">PRIMERA VISITA</a>
            <a href="">INSTRUCTORES</a>
            <a href="">COMPRAR CLASES</a>
            <a href="">RESERVAR</a>
            <a href="{{ route('login') }}">Inicia Sesión</a>
            <a href="{{ route('register') }}">Regístrate</a>
        </div>
    </nav>
    <body>
        @yield('content')
        <script src="js/app.js" charset="utf-8"></script>
        <!--<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>-->
    </body>
    <footer>
        <div class="footer container-fluid">
            <div class="row info-footer">
                <div class="col-md-4">
                    <p>AVENIDA PROVIDENCIA 2388,</p>
                    <p>COL. PROVIDENCIA, 44630,</p>
                    <p>GUADALAJARA</p>
                    <p>INFO@ROLO.COM.MX</p>
                    <p>33 11995890</p>
                </div>
                <div class="col-md-4">
                    <p>NOSOTROS</p>
                    <p>FAQ's</p>
                    <p>PRENSA</p>
                </div>
                <div class="col-md-4">
                    <p>TÉRMINOS Y CONDICIONES</p>
                    <p>AVISO DE PRIVACIDAD</p>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <i class="fab fa-facebook" ></i>
                    <i class="fab fa-instagram" ></i>
                    <i class="fab fa-spotify" ></i>
                </div>
            </div>
        </div>
    </footer>
</html>
