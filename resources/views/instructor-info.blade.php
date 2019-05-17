@extends('layout')

@section('title')
    {{$instructor->name}}
@endsection

@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/instructor-info.css')}}">
@endsection

@section('content')
    {{-- Content --}}
    <div class="container main">
        <!-- Section for the General Info of the Instructor -->
        <div class="row">
            <!-- Image -->
            <div id="instructorImage" class="col-md-5">
                <img src="/img/instructors/{{$instructor->name}}-body.png" class="img-fluid" alt="Instructor image">
            </div>
            <!-- Name, Description and Phrase -->
            <div class="info col-md-7">
                <h1 id="instructorName" class="mt-0">{{$instructor->name}}</h1>
                <div id="instructorDescription" class="text-justify mt-3">
                    {{$instructor->bio}}
                </div>
                {{-- <div class="rounded m-2 spotify">
                    VELO MUSIC
                </div> --}}
            </div>
        </div>
    </div>
@endsection