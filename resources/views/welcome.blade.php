@extends('layouts.main')

@section('title') Home @endsection

@section('content')
    <div class="mainPage fill-height">
        <div class="fill-height main-image image-fluid"></div>
        <div class="left-image image-fluid"></div>
        <div class="main-container">
            <div class="row" style="padding: 1em;" onclick="openSchedule({{ config('constants.promotionalVeloBranchId') }})">
                <div class="col-md-6">
                    <img src="{{ asset('img/iconos/LOGO.png') }}" style="width: 100%;"/>
                </div>
                <div class="col-md-6">
                    <h3>Indoor Cycling</h3>
                </div>
            </div>
            <div class="row" style="padding: 1em;" onclick="openSchedule({{ config('constants.promotionalForteBranchId') }})">
                <div class="col-md-6">
                    <img src="{{ asset('img/iconos/logo_forte.png') }}" style="width: 100%;"/>
                </div>
                <div class="col-md-6">
                    <h3>Functional Training</h3>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('extraStyles')
    <style>
        .main-container {
             margin: 0;
             left: 5vw;
             position: absolute;
             bottom: 25%;
             width:50vw;
         }

         .main-container h3 {
             position:relative;
             top:50%;
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

            .main-container {
                 position: absolute;
                 top: 5vh;
                 width:100vw;
                 left: 0;
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
                background-position-x: 25%;
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