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
        <link rel="stylesheet" href="{{asset('css/app.css')}}">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
        <link rel="stylesheet" href="{{asset('css/layout-styles.css')}}">
        @yield('extraStyles')
    </head>
    <nav class="navbar flex-center top-fixed">
        <div class="home">
            <a href="{{ url('/') }}">Rolo</a>
        </div>
        <div class="top-center links d-none d-lg-block">
            <a href="{{ url('/first-visit') }}">PRIMERA VISITA</a>
            <a href="{{ url('/instructors') }}">INSTRUCTORES</a>
            <a href="{{ url('/#packages') }}">COMPRAR CLASES</a>
            <a href="{{ url('/book') }}">RESERVAR</a>
        </div>
        <div class="top-center dropdown account d-block d-lg-none">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <i class="fa fa-bars" aria-hidden="true"></i>    <span class="caret"></span>
            </a>
            <div class="dropdown-menu account" aria-labelledby="dropdownMenuButton">
                <a href="{{ url('/first-visit') }}">PRIMERA VISITA</a>
                <a href="{{ url('/instructors') }}">INSTRUCTORES</a>
                <a href="{{ url('/#packages') }}">COMPRAR CLASES</a>
                <a href="{{ url('/book') }}">RESERVAR</a>
            </div>
        </div>
        @guest
        <div class="top-right links">
                <a href="{{ route('login') }}">INICIAR SESIÓN</a>
            @if (Route::has('register'))
                <a href="{{ route('register') }}">REGÍSTRATE</a>
            @endif
        </div>
        @endguest
        @auth
        <div class="top-right dropdown account2">
            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                {{ Auth::user()->name }}    <span class="caret"></span>
            </a>
            <div class="dropdown-menu account2" aria-labelledby="dropdownMenuButton">
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

    </nav>
    <body>
        @yield('content')
        <script src="{{asset('js/app.js')}}" charset="utf-8"></script>
        <script src="{{asset('js/layout-scripts.js')}}"></script>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        @yield('extraScripts')
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
