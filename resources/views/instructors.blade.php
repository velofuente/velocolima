@extends('layout')

@section('title')
Rolo | Conoce a los Instructores
@endsection

@section('content')
    <body style="background-color: #222222">
        <div class="container-fluid">
            <div class="title">
                <div class="display-4 font-weight-bold text-center pt-3 pb-3">
                    ROLO TRIBE
                </div>
            </div>

            <div class="container mx-auto mt-3" name="instructors" >
                <div class="row">
                    @foreach ($instructors as $instructor)
                    <div class="col-md-4 col-sm-6 col-xs-6">
                        <div class="card border-0 mx-auto my-5" style="width:90%; background-color: #222222">
                            <a href="/instructor-info">
                            <img src="img/instructors/{{$instructor->name}}-Head.png" class="card-img-top" style="border-radius: 50%; background-color:#222222" alt="Instructor 1">
                                <div class="card-body" style="background-color: #222222">
                                    <p class="card-text text-center">
                                        <a href="/instructor-info" class="h4" style="text-decoration: none; color: #7FDCE0">{{$instructor->name}}</a>
                                    </p>
                                </div>
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </body>
@endsection