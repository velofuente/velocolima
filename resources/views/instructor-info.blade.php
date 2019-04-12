@extends('layout')

@section('title')
    {{$instructor->name}}
@endsection

@section('extraStyles')
    <link rel="stylesheet" href="{{asset('css/instructor-info.css')}}">
@endsection

@section('content')
    {{-- Content --}}
    <div class="container-fluid main">
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
                    @php
                        //date_default_timezone_set('America/Mexico_City');
                        $today = now();
                    @endphp
                    @for ($i = 0; $i < 7; $i++)
                        <div class="dia col text-center">
                            <div id="day_num"> {{date('l', strtotime($today->format('d-m-Y')))}} </div>
                            <div id="day_name"> {{date('d', strtotime($today->format('d-m-Y')))}} </div>
                            @foreach ($instructor->schedules as $schedule)
                                @if ($schedule->day == $today->format('Y-m-d'))
                                    <div class="btn rounded-circle border border-info link">
                                        <a href="/bike-selection/{{$schedule->id}}" class="small">
                                            {{ $instructor->name }} <span class="small">{{ date('g:i A', strtotime($schedule->hour)) }}</span>
                                        </a>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        @php $today->modify('+1 day'); @endphp
                    @endfor
                </div>
            </div>
            <!-- Should implement Spotify API here -->
            <div class="col-md-5">
                <div class="rounded m-2" style="background-color:black; color:white">
                    Implement Spotify API
                </div>
            </div>
        </div>
@endsection