@extends('layout')

@section('title')
    Rolo | Primera visita
@endsection

@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/first-visit.css')}}">
@endsection

@section('content')
    <div class="container-fluid">
        {{-- Div for the titles --}}
        <div class="text-center">
            <div id="title1" class="col-md-12">
                LET'S GET READY TO ROLO
            </div>
            <div id="title2" class="col-md-12">
                PRIMERA VISITA
            </div>
        </div>
        {{-- Row for the blocks --}}
        <div class="row mx-auto">
            <div class="block col">
                <div id="icon1">
                    <i class="icon fas fa-tshirt"></i>
                </div>
                <div class="header">
                    <h4>
                        Vìstete list@ para rodar
                    </h4>
                </div>
                <div id="description" class="description">
                    <p> ¿No tienes tenis con grapas? </p>
                    <p> No hay problema, nosotros te prestamos. </p>
                    <p> ¿No trajiste toalla? </p>
                    <p> No pasa nada, encontraràs una en cada bicicleta al entrar a clase. </p>
                </div>
            </div>
            <div class="block col">
                <div id="icon2">
                    <i class="icon fas fa-apple-alt"></i>
                </div>
                <h4 class="header">
                    Vìstete list@ para rodar
                </h4>
                <div id="description" class="description">
                    <p> ¿No tienes tenis con grapas? </p>
                    <p> No hay problema, nosotros te prestamos. </p>
                    <p> ¿No trajiste toalla? </p>
                    <p> No pasa nada, encontraràs una en cada bicicleta al entrar a clase. </p>
                </div>
            </div>
            <div class="block col">
                <div id="icon3">
                    <i class="icon fas fa-clock"></i>
                </div>
                <div class="header">
                    <h4>
                        Vìstete list@ para rodar
                    </h4>
                </div>
                <div id="description" class="description">
                    <p> ¿No tienes tenis con grapas? </p>
                    <p> No hay problema, nosotros te prestamos. </p>
                    <p> ¿No trajiste toalla? </p>
                    <p> No pasa nada, encontraràs una en cada bicicleta al entrar a clase. </p>
                </div>
            </div>
            <div class="block col">
                <div id="icon4">
                    <i class="icon fas fa-comment-alt"></i>
                </div>
                <div class="header">
                    <h4>
                        Vìstete list@ para rodar
                    </h4>
                </div>
                <div id="description" class="description">
                    <p> ¿No tienes tenis con grapas? </p>
                    <p> No hay problema, nosotros te prestamos. </p>
                    <p> ¿No trajiste toalla? </p>
                    <p> No pasa nada, encontraràs una en cada bicicleta al entrar a clase. </p>
                </div>
            </div>
        </div>
    </div>
@endsection