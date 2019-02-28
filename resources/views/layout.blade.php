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
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
        <link rel="stylesheet" href="css/layout-styles.css">
        @yield('extraStyles')
    </head>
    <nav class="navbar flex-center top-fixed">
        <div class="home">
            <a href="{{ url('/') }}">Rolo</a>
        </div>
        <div class="top-center links">
            <a href="{{ url('/first-visit') }}">PRIMERA VISITA</a>
            <a href="{{ url('/instructors') }}">INSTRUCTORES</a>
            <a href="{{ url('/') }} .packages">COMPRAR CLASES</a>
            <a href="{{ url('/book') }}">RESERVAR</a>
        @guest
                <a href="{{ route('login') }}">INICIAR SESIÓN</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">REGÍSTRATE</a>
            @endif
        @endguest
        @auth
            <div class="top-right dropdown account">
                <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    {{ Auth::user()->name }}    <span class="caret"></span>
                </a>
                <div class="dropdown-menu account" aria-labelledby="dropdownMenuButton">
                    <a href="{{ url('/user') }}">Mi Cuenta</a>
                    <a class="" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </div>
            </div>
        @endauth
        </div>
    </nav>
    <body>
        @yield('content')
        <script src="js/app.js" charset="utf-8"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
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
