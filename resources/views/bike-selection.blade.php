@extends('layout')
@section('title')
Reservar Bici
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/style-bike.css')}}">
@endsection
@section('content')

    <div class="container-fluid">
        <div class="select">
            <a href="/schedule"id="goBack">Regresar al calendario</a>
            <h3 id="selection">SELECCIONA TU BICI</h3>
                <img id="profilePic" src="{{ asset('img/instructors/' . $schedules->instructor->name . '-Head.png') }}" width="100em" height="100em" alt="">
        </div>
        <div class="places">
            <div class="row">
                @for ($i = 1; $i <= $schedules->reservation_limit; $i++)
                <div class="col">
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
                        <h5 class="first">UBICACIÓN</h5>
                        <h5>{{$schedules->room->branch->name}}</h5>
                    </div>
                    <div>
                        <h5 class="first">FECHA & HORA</h5>
                        <h5><?php
                            setlocale(LC_TIME, 'es_ES.utf8');
                            Carbon::now()->formatLocalized('%A %d %B %Y');
                         ?>
                         </h5>
                        <h5>{{date('l', strtotime($schedules->day))}} {{date('d', strtotime($schedules->day))}} {{date('F', strtotime($schedules->day))}} {{date('Y', strtotime($schedules->day))}}</h5>
                        <h5>{{date('h', strtotime($schedules->hour))}}:{{date('i', strtotime($schedules->hour))}}</h5>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <h5 class="first">INSTRUCTOR</h5>
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
@endsection
@section('extraScripts')
    <script src="{{asset('js/bike-selection-script.js')}}"></script>
@endsection