@extends('layout')

@section('title')
    Rolo | {{$instructor->name}}
@endsection

@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/instructor-info.css')}}">
@endsection

@section('content')
    {{-- Content --}}
    <div class="container-fluid ">
        <div class="container-fluid">
            <!-- Section for the General Info of the Instructor -->
            <div class="row">
                <!-- Image -->
                <div id="instructorImage" class="col-md-5">
                    <img src="/img/instructors/{{$instructor->name}}-body.png" class="img-fluid" alt="Instructor image">
                </div>
                <!-- Name, Description and Phrase -->
                <div class="info col-md-7">
                    <h1 id="instructorName" class="text-info mt-3">{{$instructor->name}}</h1>
                    <div id="instructorDescription" class="text-justify mt-3">
                        {{$instructor->bio}}
                    </div>
                    <div id="instructorPhrase" class="font-weight-bold lead mt-4">
                        "Busca lo que encienda tu alma."
                    </div>
                </div>
            </div>

            <!-- Section for the Dates available of the Instructor and the Music -->
            <div class="row mt-4">
                <div class="dateSelector col-md-7 rounded">
                    <!-- div for the selection of the place -->
                    <div class="places mt-2">
                        <select id="instructorPlace" name="places" class="form-control w-25">
                            <option selected>Providencia</option>
                        </select>
                    </div>
                    <!-- div for the dates available -->
                    <div id="calendar" class="row small mt-3">
                        {{date_default_timezone_set('America/Mexico_City')}}
                        {{$today = now()}}
                        @for ($i = 0; $i < 7; $i++)
                            <div class="dia col text-center">
                                <div id="day_num"> {{date('l', strtotime($today->format('d-m-Y')))}} </div>
                                <div id="day_name"> {{date('d', strtotime($today->format('d-m-Y')))}} </div>
                            </div>
                            <input type="hidden" value="{{$today->modify('+1 day')}}">
                        @endfor
                        {{-- @foreach ($instructor->schedules as $schedule)
                            <input type="hidden" value="{{$date = strtotime($schedule->day)}}">
                            <div class="dia col text-center">
                                <div id="day_num"> {{ date('l', $date)." ".date('d', $date)}} </div>
                                <div id="day_name"> {{ date('F', $date) }} </div>
                                <div class="btn rounded-circle border border-info">
                                    <a href="#" class="link small">
                                        {{ $instructor->name }} <span class="small">{{ date('g:i A', strtotime($schedule->hour)) }}</span>
                                    </a>
                                </div>
                            </div>
                        @endforeach --}}
                    </div>
                </div>
                <!-- Should implement Spotify API here -->
                <div class="col-md-5">
                    <div class="rounded m-2" style="background-color:black; color:white">
                        Implement Spotify API
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection