@extends('layout')
@section('title')
    Quienes Somos
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/who.css')}}">
@endsection
@section('content')
    <div class="container-fluid who">
        <h3>Nos inspiramos en la música.</h3>
        <h3>Nos gusta sudar y exigirnos siempre un poco más, impulsándonos con cada pedaleada hacia nuestra mejor versión.</h3>
        <h3>Convertimos lo que te quita el sueño en lo que te hace soñar, soñar en grande y lograr en grande.</h3>
        <h3>Nos apasiona rodar y sentirnos vivos, somos esa sensación de adrenalina que siempre quieres volver a experimentar.</h3>
        <h3>Por eso estamos aquí.</h3>
        <h3>@siclo</h3>
    </div>
@endsection