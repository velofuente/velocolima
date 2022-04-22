<div id="myNav" class="overlay">
    <div class="overlay-content">
        <div class="col-md-12 overlay-links">
            <a href="{{ url('/branches') }}">Ubicación</a>
            <a href="{{ url('/instructors') }}">Instructores</a>
            <a id="booking" href="#">Reservar</a>
        </div>
        <div class="col-md-12 overlay-links">
            <a id="buyPackages" href="#packages">Comprar clases</a>
            <a href="{{ url('/legales') }}">Legales</a>
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

    </div>
</div>