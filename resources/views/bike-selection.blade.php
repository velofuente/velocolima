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
    <div class="container-fluid">
        <div class="select">
            <a href="/schedule" id="goBack">Volver al calendario</a>
                <div class="row">
                    <div class="col">
                        <h6 class="first">ESTUDIO: <span id="branch">{{$schedules->room->branch->name}}</span></h6>
                        <?php setlocale(LC_TIME,'es_MX.utf8'); $dt = Carbon::now(); $inicio = strftime("%A %d de %B,", strtotime($schedules->day));?>
                        <h6 class="first"> FECHA: <span id="date">{{$inicio}}</span> <span> {{date('h', strtotime($schedules->hour))}}:{{date('i', strtotime($schedules->hour))}} </span></h6>
                    </div>
                    <div id="sel" class="col">
                        <span id="selection">Selecciona tu bici y entra en el <span>S</span>iclo.</span>
                        <span id="selection">¡Ponte a <span>rodar</span>! </span>
                    </div>
                </div>
            <img id="profilePic" src="{{ asset('img/instructors/' . $schedules->instructor->name . '-Head.png') }}" width="100em" height="100em" alt="">
        </div>
        <div class="main-bikes">
            <div class="row">
                @for ($i = 1; $i <= $schedules->reservation_limit; $i++)
                <div class="col places">
                    <p class="bikes">{{$i}}</p>
                </div>
                @endfor
            </div>
        </div>
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
    </div>

    @include('packages')
@endsection
@section('extraScripts')
    <script src="{{asset('js/bike-selection-script.js')}}"></script>
@endsection