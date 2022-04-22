<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

@include('partials.header')

<body>
    <div class="gradient"></div>

    <div class="redes-fijas">
        {{-- <a href="https://www.facebook.com/velocyclingmx/" class="red " style="padding-bottom:1em" target="_blank"><img class="network" src="/img/iconos/FACEBOOK.png" alt=""></i></a> --}}
        <br>
        <a href="https://www.instagram.com/velocyclingmx/" class="red " target="_blank"><img  class="network" src="/img/iconos/INSTAGRAM.png" alt=""></i></a>
    </div>

    @include('partials.navbar')

    @include('partials.offcanvas-menu')

    <div class="mainContainer">
        @yield('content')
    </div>

    <script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdn.jsdelivr.net/npm/gasparesganga-jquery-loading-overlay@2.1.6/dist/loadingoverlay.min.js"></script>
    <!-- Automatically provides/replaces `Promise` if missing or broken. -->
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/es6-promise@4/dist/es6-promise.auto.min.js"></script>
    <script src="{{ asset('/js/app.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/layout-scripts.js') }}"></script>
    <script>
        function openSchedule (branchId) {
            document.location.href = '/schedule/' + branchId;
         }

        $('#buttonFormResponse').on('click', function(event) {
            event.preventDefault();
            formResponse();
            $("#buttonFormResponse").attr("disabled", true);
        });

        $('#booking').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            location.href = '/schedule#';
            location.reload();
        });

        $('#buyPackages').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            location.href = '/schedule#packages';
            location.reload();
        });

        function formResponse(){
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
                        $('#name').val('');
                        $('#email').val('');
                        $('#phone').val('');
                        $('#instagram').val('');
                        $("#buttonFormResponse").attr("disabled", false);
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
                        $("#buttonFormResponse").attr("disabled", false);
                    }
                },
                error: function() {
                    $.LoadingOverlay('hide');
                    $('#buttonFormResponse').prop('disabled', false);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al procesar la solicitud',
                        type: 'error',
                        confirmButtonText: 'Aceptar',
                    });
                }
            });
        }
    </script>

    @yield('extraScripts')

    @php
        $alertTitle = "Error";
        $alertMessage = "Ocurrió un error.";
        $alertType = "error";
        $alertButton = "Aceptar";
        if (Session::has('alertTitle')) {
            $alertTitle = session('alertTitle');
        }
        if (Session::has('alertMessage')) {
            $alertMessage = session('alertMessage');
        }
        if (Session::has('alertType')) {
            $alertType = session('alertType');
        }
        if (Session::has('alertButton')) {
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