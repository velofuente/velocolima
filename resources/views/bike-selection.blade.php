@extends('layout')
@section('title')
Reservar Bici
@endsection
@section('style')
    <link rel="stylesheet" href="css/style-bike.css">
@endsection
@section('bikes')
    <div class="container-fluid">
        <div class="select">
            <a href=""id="regresa">Regresar al calendario</a>
            <h3 id="seleciona">SELECCIONA TU BICI</h3>
            <img id="profilePic" src="/img/lili.png" width="100em" height="100em" alt="">
        </div>
        <div class="places">

        </div>
    </div>
@endsection
@section('info_confirmation')
    <div class="container-fluid">

    </div>
@endsection