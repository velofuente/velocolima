@extends('layout')

@section('title')
    Conoce a los Instructores
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/instructors-styles.css')}}">
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/instructors-styles.css')}}">
    <script src="http://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
@endsection

@section('content')
    <body>
        <div class="container-fluid">
            {{-- Header & Search Bar --}}
            <div class="title">
                <div class="display-4 text-center pt-3 pb-3">
                INSTRUCTORES
                </div>
            </div>

            {{-- Instructors --}}
            <div class="container mx-auto mt-4" name="instructors" >
                <div class="row">
                    @foreach ($instructors as $instructor)
                    <div class="col-md-4 col-sm-6 col-xs-6">
                    <a href="/instructors/{{$instructor->id}}" class="h4" style="text-decoration: none">
                        <div class="card border-0 mx-auto my-3">
                            {{-- Image Name: Instructor's Name + "-Head" + ".png" --}}
                            <img src="img/instructors/{{$instructor->name}}-Head.png" class="card-img-top" alt="{{$instructor->name}}">
                            <div class="card-body">
                                <p class="card-text text-center" id="instructorName">
                                    {{$instructor->name}}
                                </p>
                            </div>
                        </div>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
@endsection