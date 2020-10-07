@extends('layouts.main')

@section('title')
    Sucursales
@endsection

@section('content')
    {{-- Content --}}
    <div class="container-fluid pt-3">
        <!-- Section for the General Info of the Instructor -->
        <div class="row mx-4">
            @foreach ($branches as $branch)
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 border border mx-auto">
                    <div class="row">
                        <div class="col-6 border border-light">
                            <p class="branchName">{{ $branch->name }}</p>
                            <span class="branchInfo">{{ $branch->address }}</span>
                            <p class="branchInfo">{{ $branch->phone }}</p>
                            <p class="text-center mx-auto"> <a class="btnReservar" href="{{ url("/schedule") }}">Reservar</a> </p>
                        </div>
                        <div class="col-6 border border justify-content-center">
                            <img src="{{ asset('/img/footer/3.jpg') }}" class="img-fluid " id="branchImage">
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        @include('partials.info_footer')
    </div>
@endsection

@section('extraStyles')
    <link rel="stylesheet" href="{{ asset('css/branches-styles.css') }}">
@endsection