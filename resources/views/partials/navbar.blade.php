<nav class="navbar navbar-dark fixed-top" id="nav">
    <div class="container-fluid">
        <div class="home">
            <a class="navbar-brand homeIcon" href="{{ url('/') }}"><img src="/img/iconos/HOME.png" alt="logo" width="35px" height="35px"></a>
            <a class="navbar-brand hicon" onclick="openSchedule({{ config('constants.promotionalVeloBranchId') }})"><img src="/img/iconos/LOGO.png" class="logoNavBar" alt="logo" width="100px" height="50px"></a>
             <a class="navbar-brand hicon forte" onclick="openSchedule({{ config('constants.promotionalForteBranchId') }})"><img src="/img/iconos/logo_forte.png" class="logoNavBar" alt="logo" width="100px" height="50px"></a>
        </div>
        @guest
            <div class="links guestLinks">
                <a href="{{ route('login') }}"><img src="/img/iconos/USUARIO.png" width="35px" height="35px" alt="Ingresar" data-toggle="tooltip" data-placement="bottom" title="Ingresar"></a>
            </div>
        @endguest
        @auth
            <div class="links authLinks">
                <a href="{{ url('/user') }}"><img src="/img/iconos/USUARIO.png" class="userNavBar" width="35px" height="35px" alt="Ingresar" data-toggle="tooltip" data-placement="bottom" title="Mi Cuenta"></a>
                <a class="" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                <img src="/img/iconos/CIERRE.png" class="logoutNavBar" width="35px" height="35px" alt="Salir" data-toggle="tooltip" data-placement="bottom" title="Salir"></a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        @endauth
        <div class="hambBtn">
            <button id="hambBtn" class="hamburger hamburger--slider" type="button">
                <img src="{{asset ('/img/iconos/CIRCULOS1.png')}}" class="menuNavBar" alt="tel" width="40px" height="15px">
            </button>
        </div>
    </div>
</nav>