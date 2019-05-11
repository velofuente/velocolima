@extends('layout')
@section('title')
Reservar Bici
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/style-bike.css')}}">
@endsection
@section('content')
<?php
use Carbon\Carbon;
?>
    <div class="container-fluid main">
        <div class="select">
            <a href="/schedule" id="goBack">Volver al calendario</a>
                <div class="row">
                    <div class="col-5 bnd">
                        <?php setlocale(LC_TIME,'es_MX.utf8'); $dt = Carbon::now(); $inicio = strftime("%A %d de %B,", strtotime($schedules->day));?>
                        <h6 class="first" id="branch">ESTUDIO: <span>{{$schedules->room->branch->name}}</span></h6>
                        <h6 class="first" id="date"> FECHA: <span>{{$inicio}}</span> <span> {{date('h', strtotime($schedules->hour))}}:{{date('i', strtotime($schedules->hour))}} </span></h6>
                    </div>
                    <div class="col-2"></div>
                    <div class="col">
                        <h5 class="ent">Selecciona tu bici y entra a
                                <img class="cropLogo" src="/img/iconos/CroppedLogo.png" alt="">
                        </h5>
                    </div>
                </div>
            <div class="description">
                <img class="resClass" src="/img/iconos/2.png" alt="">
            </div>
            <img id="profilePic" src="{{ asset('img/instructors/' . $schedules->instructor->name . '-Head.png') }}" alt="">
        </div>
      
        <div class="main-bikes">
            <div class="row">
                @for ($i = 1; $i <= $schedules->reservation_limit; $i++)
                <div class="col places">
                    <p onclick="location.href='#packages'; " class="bikes">{{$i}}</p>
                </div>
                @endfor
            </div>
        </div> 
        <!--
        <div class="details">
            <input type="hidden" name="actualDay" value="{{$day=now()}}">
            <div class="row">
                <div class="col">
                    <div>
                        <h5 class="first" >INSTRUCTOR</h5>
                        <h5>{{$schedules->instructor->name}}</h5>
                    </div>
                    <div>
                        <h5 class="first">NO. DE LUGAR</h5>
                        <h5 id="placeNum">--</h5>
                    </div>
                </div>
            </div>
        </div>
    -->
    <!--
        <div id="dinamicTable">
        </div>
    -->
    </div>

    @include('packages')
    @include('footer')
@endsection
@section('extraScripts')
    <script src="{{asset('js/bike-selection-script.js')}}"></script>
@endsection