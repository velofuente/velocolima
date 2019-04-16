<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Laravel') }} | @yield('title')</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
    <!-- Styles -->
    <link rel="stylesheet" href="{{asset('css/app.css')}}">
    <link rel="stylesheet" href="{{asset('css/dist/hamburgers.css')}}">
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="{{asset('css/layout-styles.css')}}">
    @yield('extraStyles')
</head>
<div class="fixed-top line" ><img src="/img/iconos/LINEA.png" alt="" width="100%" height="10px"></div>
<nav class="navbar container-fluid" id="nav">
    <div class="home">
        <a class="navbar-brand " href="{{ url('/') }}"><img src="/img/iconos/HOME.png" alt="logo" width="35px" height="35px"></a>
        <a class="navbar-brand hicon" href="{{ url('/') }}"><img src="/img/iconos/LOGO.png" alt="logo" width="100px" height="50px"></a>
    </div>
    <div class="dropdown account d-block d-lg-none">
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
   <!-- <div class="locations">
        <select name="" id="">
            <option value="">Colima</option>
        </select>
    </div>
    <div class="branches">
        <select name="" id="">
            <option value="">Zentralia</option>
            <option value="">Providencia</option>
        </select>
    </div>-->
    @guest
    <div class="links">
            <a href="{{ route('login') }}"><img src="/img/iconos/USUARIO.png" width="35px" height="35px" alt="Ingresar" data-toggle="tooltip" data-placement="bottom" title="Ingresar"></a>
       <!-- @if (Route::has('register'))
            <a href="{{ route('register') }}">REGÍSTRATE</a>
            @endif
        -->
    </div>
    @endguest
    @auth
    <div class="links">
            <a href="{{ url('/user') }}"><i class="far fa-user fa-2x" data-toggle="tooltip" data-placement="bottom" title="Mi Cuenta"></i></a>
       <!-- @if (Route::has('register'))
            <a href="{{ route('register') }}">REGÍSTRATE</a>
            @endif
        -->
        <a class="" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            <i class="fas fa-sign-out-alt fa-2x" data-toggle="tooltip" data-placement="bottom" title="Salir"></i></a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
  <!--  <div class="top-right dropdown account2">
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
    </div>-->
    @endauth
    <div class="hambBtn">
        <button id="hambBtn" class="hamburger hamburger--slider" type="button">
            <img src="/img/iconos/CIRCULOS1.png" alt="tel" width="40px" height="15px">
        </button>
    </div>

    <div id="myNav" class="overlay">
        <div class="overlay-content">
            <a href="">Ubicaciones</a>
            <a href="{{ url('/instructors') }}">Instructores</a>
            <a href="{{ url('/book') }}">Reservar</a>
            <a href="{{ url('/#packages') }}">Comprar clases</a>
            <a href="{{ url('/who-are-we') }}">¿Quiénes somos?</a>
            <a href="#">Legales</a>
            <a class="" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
            {{ __('Logout') }}</a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>

</nav>
<div class="row">
    <div class="col-12">
        <div class="redes-fijas">
            <a href="https://www.facebook.com/Siclomx" class="red " style="padding-bottom:1em" target="_blank"><img src="/img/iconos/FACEBOOK.png" width="50px" height="50px" alt=""></i></a>
            <br>
            <a href="https://www.instagram.com/siclo/" class="red " target="_blank"><img src="/img/iconos/INSTAGRAM.png" width="50px" height="50px" alt=""></i></a>
        </div>
    </div>
</div>
