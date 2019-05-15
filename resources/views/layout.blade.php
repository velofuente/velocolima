<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    {{-- {{ csrf_token() }} --}}
</head>
    @include('header')
    <body>
        @yield('content')
        <script src="{{asset('/js/app.js')}}" charset="utf-8"></script>
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <script src="{{asset('js/layout-scripts.js')}}"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
        <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
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
