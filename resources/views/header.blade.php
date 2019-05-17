<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/dist/hamburgers.css')}}">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/layout-styles.css')}}">
    <link rel="stylesheet" href="{{asset('css/packages.css')}}">
    @yield('extraStyles')
</head>
<div class="gradient"></div>
<nav class="navbar container-fluid" id="nav">
    <div class="home">
        <a class="navbar-brand " href="{{ url('/') }}"><img src="/img/iconos/HOME.png" alt="logo" width="35px" height="35px"></a>
        <a class="navbar-brand hicon" href="{{ url('/') }}"><img src="/img/iconos/LOGO.png" alt="logo" width="100px" height="50px"></a>
    </div>
    @guest
    <div class="links">
        <a href="{{ route('login') }}"><img src="/img/iconos/USUARIO.png" width="35px" height="35px" alt="Ingresar" data-toggle="tooltip" data-placement="bottom" title="Ingresar"></a>
    </div>
    @endguest
    @auth
    <div class="links">
            <a href="{{ url('/user') }}"><img src="/img/iconos/USUARIO.png" width="35px" height="35px" alt="Ingresar" data-toggle="tooltip" data-placement="bottom" title="Mi Cuenta"></a>
        <a class="" href="{{ route('logout') }}"
            onclick="event.preventDefault();
            document.getElementById('logout-form').submit();">
            <img src="/img/iconos/CIERRE.png" width="35px" height="35px" alt="Salir" data-toggle="tooltip" data-placement="bottom" title="Salir"></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
    @endauth
    <div class="hambBtn">
        <button id="hambBtn" class="hamburger hamburger--slider" type="button">
            <img src="{{asset ('/img/iconos/CIRCULOS1.png')}}" alt="tel" width="40px" height="15px">
        </button>
    </div>

    <div id="myNav" class="overlay">
        <div class="overlay-content">
            <a href="">Ubicación</a>
            <a href="{{ url('/instructors') }}">Instructores</a>
            <a href="{{ url('/schedule') }}">Reservar</a>
            <a href="{{ url('/schedule#packages') }}">Comprar clases</a>
            <a href="{{ url('/who-are-we') }}">¿Quiénes somos?</a>
            <a href="#">Legales</a>
            @guest
                <a href="{{ url('/login')}}"> Login </a>
            @endguest
            @auth
            <a class="" href="{{ route('logout') }}"
                onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">
            {{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
            @endauth

        </div>
        <div class="overlay-locations">
            <a href="" class="location">Colima</a>
            <p>Dirección</p>
            <p>Ignacio Sandoval xxxxx</p>
            <p>Teléfono</p>
            <p>xxxxxxx</p>
        </div>
    </div>

</nav>
<div class="row">
    <div class="col-12">
        <div class="redes-fijas">
            <a href="https://www.facebook.com/velocyclingmx/" class="red " style="padding-bottom:1em" target="_blank"><img class="network" src="/img/iconos/FACEBOOK.png" alt=""></i></a>
            <br>
            <a href="https://www.instagram.com/velocyclingmx/" class="red " target="_blank"><img  class="network" src="/img/iconos/INSTAGRAM.png" alt=""></i></a>
        </div>
    </div>
</div>
