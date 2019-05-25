<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- {{ csrf_token() }} --}}
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
</head>
    @include('header')
    <body>
        <nav class="navbar navbar-dark fixed-top" id="nav">
            <div class="container-fluid">
                <div class="home">
                    <a class="navbar-brand homeIcon" href="{{ url('/') }}"><img src="/img/iconos/HOME.png" alt="logo" width="35px" height="35px"></a>
                    <a class="navbar-brand hicon" href="{{ url('/') }}"><img src="/img/iconos/LOGO.png" class="logoNavBar" alt="logo" width="100px" height="50px"></a>
                </div>
                @guest
                    <div class="links guestLinks">
                        <a href="{{ route('login') }}"><img src="/img/iconos/USUARIO.png" width="35px" height="35px" alt="Ingresar" data-toggle="tooltip" data-placement="bottom" title="Ingresar"></a>
                    </div>
                @endguest
                @auth
                    <div class="links authLinks">
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
            </div>
        </nav>
        <div class="mainContainer">
            @yield('content')
        </div>

        <script src="{{asset('/js/app.js')}}" charset="utf-8"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="{{asset('js/layout-scripts.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
        <script>
            {{-- var crfsToken = '{{ csrf_token() }}'; --}}
        $('#buttonFormResponse').on('click', function(event) {
            event.preventDefault();
            formResponse();
            $("#buttonFormResponse").attr("disabled", true);
            // $("#buttonFormResponse").prop( "disabled", true);
        });
        function formResponse(){
            // console.log('si entra a la funcion');
            $.ajax({
                method: 'POST',
                url: '/sendMail',
                data: {
                    _token: crfsToken,
                     name: $('#name').val(),
                     email: $('#email').val(),
                     phone: $('#phone').val(),
                     instagram: $('#instagram').val()
                },
                beforeSend: function(){
                    $.LoadingOverlay("show");
                },
                success: function (result) {
                    $.LoadingOverlay("hide");
                    if(result.status == "OK"){
                        $.LoadingOverlay("hide");
                        console.log(result.status);
                        Swal.fire({
                            title: 'Email Enviado',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                    } else {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                        $("#buttonFormResponse").attr("disabled", true);
                    }
                },
                error: function() {
                    console.log(data);
                    // alert('no jala');
                }
            });
        }
        </script>
        @yield('extraScripts')

        @php
            $alertTitle = "Woops!";
            $alertMessage = "Ocurrió un error.";
            $alertType = "error";
            $alertButton = "Aceptar";
            if(Session::has('alertTitle')){
                $alertTitle = session('alertTitle');
            }
            if(Session::has('alertMessage')){
                $alertMessage = session('alertMessage');
            }
            if(Session::has('alertType')){
                $alertType = session('alertType');
            }
            if(Session::has('alertButton')){
                $alertButton = session('alertButton');
            }
        @endphp
        @if (Session::has('alertMessage'))
            <script>
                $(document).ready(function() {
                    Swal.fire({
                        title: '{!! $alertTitle !!}',
                        text: '{!! $alertMessage !!}',
                        type: '{!! $alertType !!}',
                        confirmButtonText: '{!! $alertButton !!}'
                    })
                });
            </script>
        @endif
    </body>
</html>