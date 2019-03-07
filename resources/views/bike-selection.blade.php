@extends('layout')
@section('title')
Reservar Bici
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="css/style-bike.css">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="select">
            <a href=""id="goBack">Regresar al calendario</a>
            <h3 id="selection">SELECCIONA TU BICI</h3>
            <img id="profilePic" src="/img/lili.png" width="100em" height="100em" alt="">
        </div>
        <div class="places">
            <div class="row">
                @foreach ($instructors->schedules as $schedule)
                <div class="col">
                    @for ($i = 0; $i < $schedule->reservation_limit; $i++)
                        <p class="bikes">{{$i}}</p>
                    @endfor
                </div>
                @endforeach
            </div>
        </div>
        <div class="details">
            <div class="row">
                <div class="col">
                    <div>
                        <h5 class="first">UBICACIÓN</h5>
                        <h5>PROVIDENCIA</h5>
                    </div>
                    <div>
                        <h5 class="first">FECHA & HORA</h5>
                        <h5>Miércoles 27 de Febrero / 08:00am</h5>
                    </div>
                </div>
                <div class="col">
                    <div>
                        <h5 class="first">INSTRUCTOR</h5>
                        <h5>Lili</h5>
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
    <script src="js/bike-selection-script.js"></script>
@endsection