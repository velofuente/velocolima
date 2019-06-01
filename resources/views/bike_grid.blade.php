@extends('layout')

@section('title')
    Reservar Bici
@endsection

@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/style-bike.css')}}">
@endsection
@section('content')
    <div class="row" id="main-bikes">
        <div class="centeredDiv" id="bikes-div">
        </div>
    </div>
@endsection
@section('extraScripts')
    <script src="{{asset('js/bike-grid-script.js')}}"></script>
@endsection