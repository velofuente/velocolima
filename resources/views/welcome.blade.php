@extends('layouts.main')

@section('title') Home @endsection

@section('content')
    <div class="mainPage fill-height">
        <div class="fill-height main-image image-fluid"></div>
        <div class="left-image image-fluid"></div>
        {{-- <div class="main-container">
            <div class="row" style="padding: 1em;" onclick="openSchedule({{ config('constants.promotionalVeloBranchId') }})">
                <div class="col-md-5" style="">
                    <img src="{{ asset('img/iconos/LOGO.png') }}" style="width: 80%;"/>
                </div>
                <div class="col-md-6">
                    <h3>Indoor Cycling</h3>
                </div>
            </div>
            <div class="row" style="margin-top: 1em; padding: 1em;" onclick="openSchedule({{ config('constants.promotionalForteBranchId') }})">
                <div class="col-md-5">
                    <img src="{{ asset('img/iconos/logo_forte.png') }}" style="width: 80%;"/>
                </div>
                <div class="col-md-6">
                    <h3>Functional Training</h3>
                </div>
            </div>
        </div> --}}
    </div>
@endsection

@section('extraStyles')
    <style>
        .main-container {
            position: flex;
             margin: 0 auto;
             margin-top: 5%;
             width:80vw;
         }

         .main-container img {
             margin-left: 10%;
         }

         .main-container h3 {
            display: none;
            position:relative;
            margin: 0.1em auto;
            text-align: center;
            font-weight:bold;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
         }

         .main-container>div:hover {
             border-radius: .5em;
             background-color: rgba(255,255,255, .4);
         }

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
            background-position-x: 25vw;
            background-repeat: no-repeat;
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

        .main-container>div div {
            display: flex;
        }

        /* Extra small devices (phones, 600px and down) */
        @media only screen and (max-width: 600px) {
            .main-image {
                background-position-x: -25vw;
                background-size: cover;
                background-repeat: no-repeat;
            }

            .main-container {
                 position: absolute;
                 top: 5vh;
                 width:100vw;
                 left: 0;
                 font-size: 1em;
             }

             .main-container h3 {
                 display: none;
                 position:relative;
                 margin: 0.1em auto;
                 text-align: center;
                 font-weight:bold;
                 text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
             }

             .left-image {
                 display: none;
             }

        }

        /* Medium devices (landscape tablets, 768px and up) */
        @media only screen and (max-width: 768px) {
            .main-image {
                background-position-x: -25vw;
                background-repeat: no-repeat;
            }
        }

        @media only screen and (min-width: 768px) {
            .main-container {
                position: flex;
                margin: 0 auto;
                margin-top: 5%;
                width:70vw;
            }

            .main-container h3 {
                display: flex;
                position:relative;
                font-weight:bold;
                vertical-align: middle;
                font-size: 1.5em;
                align-items: center;
                justify-content: center;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            }
        }

        @media only screen and (min-width: 1024px) {
            .main-container {
                position: relative;
                margin: 0 auto;
                margin-top: 5%;
                width:60vw;
            }

            .main-container h3 {
                display: flex;
                position:relative;
                font-weight:bold;
                font-size: 1.5em;
                align-items: center;
                justify-content: center;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            }
        }

        @media only screen and (min-width: 1365px) {
            .main-container {
                position: relative;
                margin: 0 auto;
                margin-top: 5%;
                width:60vw;
            }

            .main-container h3 {
                display:flex;
                position:relative;
                font-weight:bold;
                font-size: 2em;
                align-items: center;
                justify-content: center;
                text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
            }
        }

    </style>
@endsection

@section('extraScripts')

 <script type="text/javascript">
     function openSchedule (branchId) {
         document.location.href = '/schedule/' + branchId;
     }
 </script>
@endsection