@extends('layout')

@section('title')
    Conoce a los Instructores
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/instructors-styles.css')}}">
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
                    @if (count($instructors) > 0)
                        @foreach ($instructors as $instructor)
                        <div class="col-md-4 col-sm-6 col-xs-6">
                        <a href="/instructors/{{$instructor->id}}" class="h4" style="text-decoration: none">
                            <div class="card border-0 mx-auto my-3">
                                {{-- Image Name: Instructor's Name + "-Head" + ".png" --}}
                                @if($instructor->profile_image)
                                    <img src="{{$instructor->profile_image}}" class="card-img-top" alt="{{$instructor->name}}">
                                @else
                                    <img src="img/instructors/Instructor-Head.png" class="card-img-top" alt="{{$instructor->name}}">
                                @endif
                                <div class="card-body">
                                    <p class="card-text text-center" id="instructorName">
                                        {{$instructor->name}}
                                    </p>
                                </div>
                            </div>
                            </a>
                        </div>
                        @endforeach
                    @else
                        <h3 class="text-center text-white">Aún no hay instructores agregados</h3>
                    @endif
                </div>
            </div>
        </div>
    </body>
@endsection