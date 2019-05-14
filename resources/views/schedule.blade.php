@extends('layout')

@section('title')
    Horario
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/schedule-styles.css')}}">
@endsection

@section('content')
        <div class="container-fluid pt-4 mb-4 main">
            <div class="row" id="topNavBar">
                {{-- Empty Section at the Far LeftNavBar --}}
                <div class="col-1">
                    <span class="weekShown">
                    </span>
                </div>
                {{-- Message Actual Week --}}
                <div class="col-2">
                    <input type="hidden" name="timezoneSet" value="{{setlocale(LC_TIME,'es_MX.utf8')}}">
                    <input type="hidden" name="WeekShown" value="{{$weekShown=now()}}">
                    <input type="hidden" name="setMonth" value="{{$month=strftime('%B', strtotime($weekShown))}}">
                    <span class="weekShown">
                        del {{date('d')}} al {{date('d', strtotime($weekShown->modify("+6 days")))}} de {{$month}}
                    </span>
                </div>
                {{-- Empty Section at the Middle of the NavBar --}}
                <div class="col-6">
                    <span class="weekShown">
                    </span>
                </div>
                {{-- Instructor Dropdown --}}
                <div class="col-2">
                    <div class="container-fluid">
                        <select class="dropdown" id="ScheduleInstructor" onchange="scheduleByInstructor()">
                            <option value="allInstructors" selected="selected">Instructores</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{$instructor->name}}">{{$instructor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Empty Section at the Far Right NavBar --}}
                <div class="col-1">
                    <span class="weekShown">
                    </span>
                </div>
            </div>

            {{-- Schedule Section --}}
            <input type="hidden" name="timezoneSet" value="{{date_default_timezone_set('America/Mexico_City')}}">
            <input type="hidden" name="actualDay" value="{{$today=now()}}">
            <input type="hidden" name="thisDay" value="{{$thisDay=now()}}">
            <div class="container" name="calendar">
                <div class="row" name="dates">
                    @for ($i = 0; $i < 7; $i++)
                    <section class="col" id="scheduleDayColumn">
                        <ul>
                            <li class="scheduleDayText">
                                <input type="hidden" name="langLocal" value="<?php setlocale(LC_TIME,'es_MX.utf8'); $dayNumber=strftime('%d', strtotime($today));?>">
                                <input type="hidden" name="langLocal" value="<?php $dayName = strftime("%a", strtotime($today));?>">
                            <span class="number"> {{$dayName}}.{{$dayNumber}}</span>
                            </li>
                            @foreach ($schedules as $schedule)
                                @if ($schedule->day == $today->format('Y-m-d'))
                                    {{-- If the Schedule Day == Actual (Real) Day of the Week then check the hour scheduled --}}
                                    @if ($schedule->day == $thisDay->format('Y-m-d'))
                                        @if ($schedule->hour < $today->format('H:i:s'))
                                            {{-- Disabled Boxes --}}
                                            <span class="scheduleItemLinkDisabled">
                                                <li class="scheduleItemDisabled" id="{{$schedule->instructor->name}}">
                                                    <p class="scheduleItemTextInstructor">
                                                        {{$schedule->instructor->name}}
                                                    </p>
                                                    <p class="scheduleItemTextHourDisabled">
                                                        {{ date('g:i A', strtotime($schedule->hour)) }}
                                                    </p>
                                                </li>
                                            </span>
                                        @else
                                            {{-- Enabled Boxes --}}
                                            <a href="/bike-selection/{{$schedule->id}}" class="scheduleItemLink">
                                                <li class="scheduleItem" id="{{$schedule->instructor->name}}">
                                                    <p class="scheduleItemTextInstructor">
                                                        {{$schedule->instructor->name}}
                                                    </p>
                                                    <p class="scheduleItemTextHour">
                                                        {{ date('g:i A', strtotime($schedule->hour)) }}
                                                    </p>
                                                </li>
                                            </a>
                                        @endif
                                    @else
                                        {{-- Enabled Boxes --}}
                                        <a href="/bike-selection/{{$schedule->id}}" class="scheduleItemLink">
                                            <li class="scheduleItem" id="{{$schedule->instructor->name}}">
                                                <p class="scheduleItemTextInstructor">
                                                    {{$schedule->instructor->name}}
                                                </p>
                                                <p class="scheduleItemTextHour">
                                                    {{ date('g:i A', strtotime($schedule->hour)) }}
                                                </p>
                                            </li>
                                        </a>
                                    @endif
                                @endif
                            @endforeach
                        </ul>
                    </section>
                    <input type="hidden" value="{{$today->modify('+1 day')}}">
                    @endfor
                </div>
            </div>
        </div>
    @include('packages')
    @include('footer')
@endsection

@section('extraScripts')
    <script type="text/javascript" src="https://openpay.s3.amazonaws.com/openpay.v1.min.js"></script>
    <script type='text/javascript' src="https://openpay.s3.amazonaws.com/openpay-data.v1.min.js"></script>
    <script type="text/javascript">
        var crfsToken = '{{ csrf_token() }}';
    </script>
    <script src="{{asset('js/openpay-script.js')}}"></script>
    <script src="{{ asset('/js/schedule-script.js') }}"></script>
@endsection