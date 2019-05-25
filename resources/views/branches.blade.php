@extends('layout')

@section('title')
    Sucursales
@endsection
@section('extraStyles')
    <style>
    .marco {
        height: 264px;
        background-size: cover;
        background-position: center;
        background-blend-mode: multiply;
        color: #fff;
        position: relative;
        border-radius: 3px;
        margin: 20px;
    }
    .margin-topMain {
        padding-top: 100px !important;
    }
    </style>
@endsection
@section('content')
    {{-- Content --}}
    <div class="container main margin-topMain">
        <!-- Section for the General Info of the Instructor -->
        <div class="row">
            @foreach ($branches as $branch)
                <div class="marco centrado_vertical" >
                    <div class="elemento_centrado">
                        <a href="/schedule">
                            <div class="en_menu color_a_claro selected_ub r_claro" data-id_menu="120973">
                            <div class="r_claro">{{ $branch->name }}
                            </div>
                        </div>
                        </a>
                        <div class="info_ubi_loop">
                            <address>
                                <div> 
                                    {{ $branch->address }} 
                                </div> 
                                <br>
                                <div>
                                    Tel: {{ $branch->phone }}
                                </div>
                            </address>
                        </div>
                        <div class="botones_ub_ind">
                            <a class="btn azul btnubica" href="/reservar/?theidofstore=120973">Reservar</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection