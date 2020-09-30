@extends('layouts.main')

@section('title') Home @endsection

@section('content')
    <div class="mainPage fill-height" onclick="location.href='/schedule';">
        <div class="fill-height main-image image-fluid"></div>
        <div class="fill-height right-image image-fluid"></div>
        <div class="fill-height left-image image-fluid"></div>
    </div>
@endsection

@section('extraScripts')
    @if(!Auth::check())
        <script>
            $(document).ready(function () {
                Swal.fire({
                    title: '¡Obtén tu primera clase gratis!',
                    text: "Completa tu registro para recibir una clase gratis",
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'Cerrar',
                    confirmButtonText: 'Ir al registro'
                }).then(function (result) {
                    if (result.value) {
                        window.location.replace("/register");
                    }
                });
            });
        </script>
    @endif
@endSection

@section('extraStyles')
    <style>
        .fill-height {
            position: fixed;
            top: 6em;
            left: 0;
            bottom: 0;
            right: 0;
        }

        .main-image {
            background-image: url('/img/homepage/main.jpg');
            background-size: cover;
            background-attachment: fixed;
        }

        .right-image {
            background-image: url('/img/iconos/LOGO.png');
            left: 35%;
            background-size: 95%;
            background-repeat: no-repeat;
            background-position: center;
        }

        .left-image {
            background-image: url('img/iconos/ICONO_O.png');
            right: 65%;
            background-size: 80%;
            background-repeat: no-repeat;
            background-position: center;
        }
    </style>
@endsection