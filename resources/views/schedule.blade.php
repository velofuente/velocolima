@extends('layout')

@section('title')
Rolo | Horario
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="{{asset('css/schedule-styles.css')}}">
@endsection

@section('content')
    <body>
        <div class="container-fluid pt-4 mb-4">
            <div class="row" id="topNavBar">
                {{-- Message Actual Week --}}
                <div class="col-4">
                    <input type="hidden" name="timezoneSet" value="{{date_default_timezone_set('America/Mexico_City')}}">
                    <input type="hidden" name="actualDay" value="{{$weekShown=now()}}">
                    <p class="weekShown">
                        del {{date('d')}} al {{date('d', strtotime($weekShown->modify("+6 days")))}} de {{date('F')}}
                    </p>
                </div>
                {{-- Instructor Dropdown --}}
                <div class="col-4">
                    <div class="dropdown">
                        <select class="dropdown" data-dependent="" role="button" id="ScheduleInstructor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onchange="scheduleByInstructor()">
                            <option value="allInstructors" selected="selected">Instructores</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{$instructor->name}}">{{$instructor->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                {{-- Branch Dropdown --}}
                <div class="col-4">
                    <div class="dropdown">
                        <select class="dropdown" data-dependent="" role="button" id="ScheduleBranch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" onchange="scheduleByBranch()">
                            <option value="allBranches">Sucursal</option>
                            @foreach ($branches as $branch)
                                <option value="{{$branch->name}}">{{$branch->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            {{-- Schedule Section --}}
            {{-- Set TimeZone to México --}}
            <input type="hidden" name="actualDay" value="{{$today=now()}}">
            <div class="container-fluid mt-4" id="calendar">
                <div class="row" name="dates">
                    @for ($i = 0; $i < 7; $i++)
                    <section class="col" id="scheduleDayColumn">
                        <ul class="text-center list-unstyled">
                            <li >
                                <p class="scheduleDayText">
                                    {{date('D', strtotime($today->format('d-m-Y')))}}.
                                    <span class="number">
                                        {{date('d', strtotime($today->format('d-m-Y')))}}
                                    </span>
                                </p>
                            </li>
                        </ul>

                        @foreach ($schedules as $schedule)
                            @if ($schedule->day == $today->format('Y-m-d'))
                                <section>
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
                                </section>
                            @endif
                        @endforeach
                    </section>
                    <input type="hidden" value="{{$today->modify('+1 day')}}">
                    @endfor
                </div>
            </div>
        </div>

        <script>
            function scheduleByInstructor() {
                var selectInstructor = document.getElementById("ScheduleInstructor").value;
                var scheduleBox = document.getElementsByClassName("scheduleItem");

                if (selectInstructor == "allInstructors"){
                    for (let item of scheduleBox){
                        item.style.display = 'block';
                    }
                } else {
                    for (let item of scheduleBox){
                        if (selectInstructor === item.id){
                            item.style.display = 'block';
                        }
                        else {
                            item.style.display = 'none';
                        }
                    }
                }
            }
            function scheduleByBranch(){
                var selectBranch = document.getElementById("ScheduleBranch").value;
                var scheduleBox = document.getElementsByClassName("scheduleItem");

                if (selectBranch == "allBranches"){
                    for (let item of scheduleBox){
                        item.style.display = 'block';
                    }
                } else {
                    for (let item of scheduleBox) {
                        if (selectBranch === item.id_rooms){
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    }
                }
            }
        </script>
    </body>
@endsection

@section('extraScripts')
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@endsection