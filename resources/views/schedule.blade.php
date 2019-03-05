@extends('layout')

@section('title')
Rolo | Horario
@endsection

@section('extraStyles')
    <link rel="stylesheet" type="text/css" href="css/schedule-styles.css">
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
                                <a class="btn dropdown-toggle rounded-pill text-dark text-center bg-white" style="width: 90%" href="#" role="button" id="btnScheduleInstructor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Instructor
                                </a>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                    @foreach ($instructors as $instructor)
                                        <a class="dropdown-item" href="#">{{$instructor->name}}</a>
                                    @endforeach
                                    {{-- <a class="dropdown-item" href="#">Instructor</a>
                                    <a class="dropdown-item" href="#">Santi</a>
                                    <a class="dropdown-item" href="#">Franz</a>
                                    <a class="dropdown-item" href="#">Lili</a>
                                    <a class="dropdown-item" href="#">Regina</a>
                                    <a class="dropdown-item" href="#">Mel</a>
                                    <a class="dropdown-item" href="#">Gabi</a>
                                    <a class="dropdown-item" href="#">Dani</a>
                                    <a class="dropdown-item" href="#">Paola</a>
                                    <a class="dropdown-item" href="#">Tania</a> --}}
                                </div>
                            </div>
                        </div>
                        {{-- Branch Dropdown --}}
                        <div class="dropdown col-sm-9 d-md-flex">
                            <a class="btn dropdown-toggle rounded-pill text-dark text-center bg-white" style="width: 30%" href="#" role="button" id="btnScheduleInstructor" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                PROVIDENCIA
                            </a>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                <a class="dropdown-item" href="#">SUCURSAL 2</a>
                                <a class="dropdown-item" href="#">SUCURSAL 3</a>
                                <a class="dropdown-item" href="#">SUCURSAL 4</a>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Schedule Section --}}
                <div class="container centrarCosas" name="calendar">
                    <div class="row" name="dates">
                        <div class="scheduleColumn">
                            <input type="hidden" name="timezoneSet" value="{{date_default_timezone_set('America/Mexico_City')}}">
                            <input type="hidden" name="actualDay" value="{{$today=now()}}">
                            @for ($i = 0; $i < 7; $i++)
                            <section class="day" id="scheduleDayColumn">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="scheduleDayText">
                                        <div class="dia col text-center">
                                            <div id="day_num"> {{date('l', strtotime($today->format('d-m-Y')))}} </div>
                                            <div id="day_name"> {{date('d', strtotime($today->format('d-m-Y')))}} </div>
                                        </div>
                                        <input type="hidden" value="{{$today->modify('+1 day')}}">
                                    </li>
                                </ul>
                            </section>
                            @endfor
                                <section>
                                    <li class="scheduleItem">
                                        <p class="scheduleItemText">Instructor</p>
                                        <p class="scheduleItemText">09:30 AM</p>
                                    </li>
                                    <li class="scheduleItem">
                                        <p class="scheduleItemText">Instructor</p>
                                        <p class="scheduleItemText">11:30 AM</p>
                                    </li>
                                    <li class="scheduleItem">
                                        <p class="scheduleItemText">Instructor</p>
                                        <p class="scheduleItemText">14:30 PM</p>
                                    </li>
                                    <li class="scheduleItem">
                                        <p class="scheduleItemText">Instructor</p>
                                        <p class="scheduleItemText">16:30 PM</p>
                                    </li>
                                </section>
                            </section>

                        {{-- <section class="day" id="scheduleDayColumn">
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="scheduleDayText">26 Martes</li>
                            </ul>
                            <section>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">09:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">11:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">14:30 PM</p>
                                </li>
                            </section>
                        </section>

                        <section class="day" id="scheduleDayColumn">
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="scheduleDayText">27 Miércoles</li>
                            </ul>
                            <section>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">09:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">11:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">14:30 PM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">16:30 PM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">18:30 PM</p>
                                </li>
                            </section>
                        </section>

                        <section class="day" id="scheduleDayColumn">
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="scheduleDayText">28 Jueves</li>
                            </ul>
                            <section>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">09:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">11:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">14:30 PM
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">16:30 PM</p>
                                </li>
                            </section>
                        </section>

                        <section class="day" id="scheduleDayColumn">
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="scheduleDayText">1 Viernes</li>
                            </ul>
                            <section>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">09:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">11:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">14:30 PM
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">16:30 PM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">18:30 PM</p>
                                </li>
                            </section>
                        </section>

                        <section class="day" id="scheduleDayColumn">
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="scheduleDayText">2 Sábado</li>
                            </ul>
                            <section>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">09:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">11:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">14:30 PM
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">16:30 PM</p>
                                </li>
                            </section>
                        </section>

                        <section class="day" id="scheduleDayColumn">
                            <ul class="list-group list-group-horizontal-sm">
                                <li class="scheduleDayText">3 Domingo</li>
                            </ul>
                            <section>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">09:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">11:30 AM</p>
                                </li>
                                <li class="scheduleItem">
                                    <p class="scheduleItemText">Instructor</p>
                                    <p class="scheduleItemText">14:30 PM
                                </li>
                            </section>
                        </section> --}}
                    </div>
                </div>
            </div>
        </div>
    </body>
@endsection