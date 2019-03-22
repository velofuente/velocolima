@extends('layout')

@section('title')
    Horario
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/schedule-styles.css')}}">
@endsection

@section('content')
    <body style="background-color: #222222">
        <div class="container pt-4 main">
            <div class="container-fluid pt-4">
                {{-- Instructor Dropdown --}}
                <div class="container mb-4">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="dropdown">
                                <select class="dropdown" style="width: 90%" href="#" role="button" id="btnScheduleInstructor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <option value="AllInstructors" selected="selected">Instructor</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{$instructor->id}}">{{$instructor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Branch Dropdown --}}
                        <div class="dropdown col-sm-9 d-md-flex">
                            <select class="dropdown" style="width: 30%" href="#" role="button" id="btnScheduleInstructor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                @foreach ($branches as $branch)
                                    <option value="{{$branch->name}}">{{$branch->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Schedule Section --}}
                <input type="hidden" name="timezoneSet" value="{{date_default_timezone_set('America/Mexico_City')}}">
                <input type="hidden" name="actualDay" value="{{$today=now()}}">
                <div class="container centrarCosas" name="calendar">
                    <div class="row" name="dates">
                        @for ($i = 0; $i < 7; $i++)
                        <section class="col" id="scheduleDayColumn">
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="scheduleDayText">
                                    <?php setlocale(LC_TIME,'es_MX.utf8'); $dayNumber=strftime('%d', strtotime($today));?>
                                    <p class="number">{{$dayNumber}}</p>
                                    <?php $dayName = strftime("%A", strtotime($today));?>
                                    <p>{{$dayName}}</p>
                                </li>
                            </ul>

                            @foreach ($schedules as $schedule)
                                @if ($schedule->day == $today->format('Y-m-d'))
                                    <section>
                                        <li class="scheduleItem">
                                            <a href="/bike-selection/{{$schedule->id}}" class="scheduleItemText">{{$schedule->instructor->name}}</a>
                                            <a href="/bike-selection/{{$schedule->id}}" class="scheduleItemText">{{ date('g:i A', strtotime($schedule->hour)) }}</a>
                                        </li>
                                    </section>
                                @endif
                            @endforeach
                        </section>
                        <input type="hidden" value="{{$today->modify('+1 day')}}">
                        @endfor
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection

@section('extraScripts')
    <script src="{{asset('js/schedule-script.js')}}"></script>
@endsection