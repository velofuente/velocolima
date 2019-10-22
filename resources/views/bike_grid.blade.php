@extends('layout')

@section('title')
    Reservar bici
@endsection

@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/style-bike.css')}}">
@endsection
@section('content')
    X: <input type="text" name="x" id="x">
    Y: <input type="text" name="y" id="y">
    day: <input type="date" name="day" id="day">
    hour: <input type="time" name="hour" id="hour">
    <div class="row" id="main-bikes">
        <div class="centeredDiv" id="bikes-div">
        </div>
    </div>
@endsection
@section('extraScripts')
    <script type="text/javascript">
        var crfsToken = '{{ csrf_token() }}';
    </script>
    <script src="{{asset('js/bike-grid-script.js')}}"></script>
@endsection