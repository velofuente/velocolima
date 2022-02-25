@extends('layouts.main')

@section('title') Home @endsection

@section('content')
    <div class="mainPage fill-height" onclick="location.href='/schedule';">
        <div class="fill-height main-image image-fluid"></div>
        <div class="left-image image-fluid"></div>
    </div>
@endsection

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
            position: fixed;
            background-image: url('/img/iconos/ICONO_O.png');
            width: 9em;
            height: 9em;
            z-index: 1;
            right: 1.5em;
            bottom: 1.5em;
            background-size: 100%;
            background-repeat: no-repeat;
            background-position: center;
        }

        .center-image {
            background-image: url('/img/iconos/LOGO.png');
            background-size: 60%;
            background-repeat: no-repeat;
            background-position: center;
        }

        /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            .main-image {
                /* background-position-x: 25%; */
            }
        }

        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (max-width: 768px) {
            .main-image {
                background-position-x: 25%;
            }
        }

    </style>
@endsection