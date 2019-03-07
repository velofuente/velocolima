@extends('layout')
@section('title')
    Reservar
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="css/book-styles.css">
@endsection
@section('content')
    <div class="container-fluid">
        <div class="row main">
            <div id="branch-col" class="col-md-4">
                <div class="branch">
                    <div class="mx-auto">
                        <h4 class="text-info text-center">PROVIDENCIA</h4>
                    </div>
                    <div class="center">
                        <address class="text-center text-white mx-auto">
                            Av. Providencia 2388<br>
                            Col. Providencia CP:44630<br>
                            Guardalajara<br>
                            Tel:3311995890
                        </address>
                    </div>
                    <div class="float-sm-right">
                        <button class="btn btn-info" role="button">RESERVAR</button>
                    </div>
                </div>
            </div>
            <div id="branch-col" class="col-md-4">
                <div class="branch">
                    <div class="mx-auto">
                        <h4 class="text-info text-center">SAN FERNANDO</h4>
                    </div>
                    <div class="center">
                        <address class="text-center text-white mx-auto">
                            Av. San Fernando 690<br>
                            Col. Lomas Vista Hermosa CP:99911<br>
                            Colima<br>
                            Tel:3121110022
                        </address>
                    </div>
                    <div class="float-sm-right">
                        <button class="btn btn-info" role="button">RESERVAR</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('extraScripts')
@endsection