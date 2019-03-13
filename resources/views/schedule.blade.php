@extends('layout')

@section('title')
Rolo | Horario
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="css/schedule-styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
@endsection

@section('content')
    <body style="background-color: #222222">
        <div class="container pt-4">
            <div class="container-fluid pt-4">
                {{-- Instructor Dropdown --}}
                <div class="container mb-4">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="dropdown">
                                <select class="dropdown" style="width: 90%" data-dependent="" role="button" id="ScheduleInstructor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <option value="AllInstructors" selected="selected">Instructor</option>
                                    @foreach ($instructors as $instructor)
                                        <option value="{{$instructor->id}}">{{$instructor->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        {{-- Branch Dropdown --}}
                        <div class="dropdown col-sm-9 d-md-flex">
                            <select class="dropdown" style="width: 30%" data-dependent="" role="button" id="ScheduleBranch" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <option value="Sucursal">Sucursal</option>
                                @foreach ($branches as $branch)
                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
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
                                    <p class="number">{{date('d', strtotime($today->format('d-m-Y')))}}</p>
                                    <p>{{date('l', strtotime($today->format('d-m-Y')))}}</p>
                                </li>
                            </ul>

                            @foreach ($schedules as $schedule)
                                @if ($schedule->day == $today->format('Y-m-d'))
                                    <section>
                                        <li class="scheduleItem">
                                            <p class="scheduleItemText">
                                                {{$schedule->instructor->name}}
                                            </p>
                                            <p class="scheduleItemText">{{ date('g:i A', strtotime($schedule->hour)) }}</p>
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
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
@endsection