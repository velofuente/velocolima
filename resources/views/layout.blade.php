<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>@yield('title')</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
         <!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">-->
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        <!-- Styles -->
        <link rel="stylesheet" href="css/app.css">
        <style>
            html, body {
                background-color: #222222;
                color: #87d9de;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 2em;
            }

            .content {
                text-align: center;
                padding-left: 0;
                padding-right: 0;
                padding-top: 2em;
            }

            .title {
                font-size: 84px;
            }

            .links > a{
                color: #87d9de;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                margin-bottom: 1em;
            }
            .home >a{
                color: #87d9de;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
                margin-right: 80em;
                margin-top: -2em;
            }

            .m-b-md {
                margin-bottom: 30px;
            }

            .responsive {
                width: 100%;
                height: 40em;
                top: 0;
            }

            nav{
                position: fixed;
                top: 0;
                width: 100%;
                height: 5em;
            }

            .packages{
                padding-top: 3em;
                padding-left: 2em;
            }

            .classes{
                justify-content: center;
            }

            .content-normal{
                color: #ffffff;
                margin-top: 2em;
            }

            #content-normal{
                text-align: center;
                border: solid #87d9de;
                border-radius: 120px;
                padding-top: 2.5em;
                margin-left: 2.5em;
                margin-top: 2em;
                width: 60%;
                height: 100%;
            }

            #content-special{
                text-align: center;
                border: solid #ff8e69;
                border-radius: 120px;
                padding-top: 2.5em;
                margin-left: 2.5em;
                margin-top: 2em;
                width: 60%;
                height: 100%;
            }

            #content-normal:hover{
                background-color: #87d9de;
            }

            #content-special:hover{
                background-color: #ff8e69;
            }

            .info-footer{
                color: white;
                margin-top: 9em;
                text-align: center;
            }
        </style>
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
        @yield('carousel')
        @yield('packages')
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
