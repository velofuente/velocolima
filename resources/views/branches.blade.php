@extends('layout')

@section('title')
    Sucursales
@endsection
@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/branches-styles.css')}}">
@endsection
@section('content')
    {{-- Content --}}
    <div class="container-fluid pt-3">
        <!-- Section for the General Info of the Instructor -->
        <div class="row mx-4">
            @foreach ($branches as $branch)
                {{-- <div class="marco centrado_vertical" >
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
                                <div>
                                    Tel: {{ $branch->phone }}
                                </div>
                            </address>
                        </div>
                        <div class="btn btn-primary botones_ub_ind">
                            <a class="btn azul btnubica" href="/reservar/?theidofstore=120973">Reservar</a>
                        </div>
                    </div>
                </div> --}}
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border border mx-auto">
                    <div class="row">
                        <div class="col-6 border border-light">
                            <p class="branchName">{{$branch->name}}</p>
                            <span class="branchInfo">{{$branch->address}}</span>
                            {{-- <p>{{$branch->phone}}</p> --}}
                            <p class="branchInfo">{{$branch->phone}}</p>
                            {{-- <button class="button-primary">Reservar</button> --}}
                            <p class="text-center mx-auto"> <a class="btnReservar" href="{{url("/schedule")}}">Reservar</a> </p>
                        </div>
                        <div class="col-6 border border justify-content-center">
                            <img src="{{asset('/img/footer/3.jpg')}}" class="img-fluid " id="branchImage">
                            {{-- <img src="{{asset('img/iconos/CroppedLogo.png')}}" id="welcomeLogo" class="mx-auto text-center"> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @include("info_footer")
    </div>
@endsection