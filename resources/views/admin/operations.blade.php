@extends('admin.app')

@section('content')
{{-- Show the Schedules (ordered by Hour) for today --}}
<input type="hidden" name="langUnix" value="{{date_default_timezone_set('America/Mexico_City')}}">
<input type="hidden" name="langWindows" value="{{setlocale(LC_TIME, 'es_MX.UTF-8')}}">
<input type="hidden" name="langLocal" value="{{setlocale(LC_TIME, 'spanish')}}">

{{--
    xs: phones
    sm: tablets
    md: notebooks
    lg: laptops
--}}

{{-- Main Title & Schedules Button --}}
<div class="row text-center mx-0 pt-3">
    <h3 class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mx-auto">Operaciones</h3>
    <div class="col-xs-0 col-sm-0 col-md-1 col-lg-1 mx-auto"></div>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 mx-auto dropdown ">
        <button class="btn btn-info dropdown-toggle" id="dropdownSchedule" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <span id="selectedSchedule">Seleccionar horario</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownSchedule">
        @if (count($schedules) > 0)
            @foreach ($schedules as $schedule)
                {{-- @if ($schedule->day == date('Y-m-d')) --}}
                    {{-- @if ($schedule->hour >= date('H:i:s')) --}}

                        {{-- <a class="dropdown-item" href="javascript:showClients({{$schedule->id}})" id="{{$schedule->id}}"> --}}
                        <a class="dropdown-item scheduleList" href="#" id="{{$schedule->id}}">
                            {{-- <span class="col-4 text-center">{{ date('l', strtotime($schedule->day)) }}</span> --}}
                            {{-- <span class="col-4">{{ iconv('ISO-8859-1','UTF-8', strftime("%a", strtotime($schedule->day)))}}</span> --}}
                            <span class="col-4">{{ strftime("%a", strtotime($schedule->day))}}</span>
                            <span class="col-4">{{date('g:i A', strtotime($schedule->hour))}} </span>
                            <span class="col-4">{{$schedule->instructor->name}}</span>
                            {{-- <img width="60%" height="60%" src="{{ asset('img/instructors/' . $schedule->instructor->name . '-Head.png') }}" alt=""> --}}
                        </a>
                    {{-- @else
                        <a class="dropdown-item text-danger" href="#">
                            <span>{{ date('g:i A', strtotime($schedule->hour)) }}</span>
                            <span>{{$schedule->instructor->name}}</span>
                        </a> --}}
                    {{-- @endif --}}
                {{-- @else --}}
                    {{-- <h3 class="text-left">No hay horarios creados el día de hoy</h3> --}}
                {{-- @endif --}}
            @endforeach
        @else
              <h5 class="text-center mx-2">No hay horarios creados<h5>
        @endif
        </div>
    </div>
    <div class="col-xs-0 col-sm-0 col-md-1 col-lg-1 mx-auto"></div>
    {{-- <button class="col-xs-12 col-sm-12 col-md-3 col-lg-3 btn btn-success mx-4" data-toggle="modal" data-target="#addOpUserModal">Añadir</button> --}}
    <button class="col-xs-12 col-sm-12 col-md-3 col-lg-3 btn btn-success mx-4" id="addOpUserButton" data-toggle="modal" data-target="#addOpUserModal">Añadir</button>
</div>

{{-- Bike Grid & Table of Users--}}
<div class="row" id="main-bikes">
    {{-- <div class="centeredDiv col-md-10" id="bikes-div" style="width: 100%">
        <h1>System Grid Test</h1>
    </div> --}}
    {{-- @if (count($userSchedules) > 0) --}}
        <div class="col-md-2">
            <table class="table table-striped table-hover" id="tableClasses">
                <thead style="font-size: 1em;">
                    <tr style="font-size: 1em;">
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Asiento</th>
                        <th scope="col">Talla de calzado</th>
                        <th scope="col">Teléfono</th>
                        {{-- <th scope="col">ScheduleID</th> --}}
                        <th scope="col" colspan="3" class="text-center">Acción</th>
                    </tr>
                </thead>
                <tbody id="tableBody">
                    {{-- the Value of each Row contains its respective schedule_id --}}
                    @foreach ($userSchedules as $userSchedule)
                        @if ($userSchedule->status != 'cancelled')
                            <tr style="font-size: 0.9em;" class="tableBodyRow">
                                <input type="hidden" value="{{$userSchedule->schedule_id}}" id="hiddenUsers">
                                <td>{{$userSchedule->user->name}} {{$userSchedule->user->last_name}}</td>
                                <td>{{$userSchedule->user->email}}</td>
                                {{-- <td>{{$userSchedule->bike}}</td> --}}
                                @switch($userSchedule->bike)
                                    @case(2)
                                        <td>1</td>
                                        @break
                                    @case(10)
                                        <td>2</td>
                                        @break
                                    @case(12)
                                        <td>3</td>
                                        @break
                                    @case(14)
                                        <td>4</td>
                                        @break
                                    @case(20)
                                        <td>5</td>
                                        @break
                                    @case(22)
                                        <td>6</td>
                                        @break
                                    @case(24)
                                        <td>7</td>
                                        @break
                                    @case(26)
                                        <td>8</td>
                                        @break
                                    @case(30)
                                        <td>9</td>
                                        @break
                                    @case(32)
                                        <td>10</td>
                                        @break
                                    @case(36)
                                        <td>11</td>
                                        @break
                                    @case(38)
                                        <td>12</td>
                                        @break
                                    @case(40)
                                        <td>13</td>
                                        @break
                                    @case(42)
                                        <td>14</td>
                                        @break
                                    @default
                                        <td>14</td>
                                @endswitch
                                <td>{{$userSchedule->user->shoe_size}}</td>
                                <td> {{$userSchedule->user->phone}} </td>
                                <td>{{$userSchedule->schedule_id}}</td>
                                @if($userSchedule->status == 'active')
                                    <td class="assistButton" id="assistButton-{{ $userSchedule->id }}"><button class="btn btn-success btn-sm userAssist" id="userAssist-{{ $userSchedule->id }}" value="{{$userSchedule->id}}" data-id="{{$userSchedule->id}}">Asistencia</button></td>
                                    <td class="absentButton" id="absentButton-{{ $userSchedule->id }}"><button class="btn btn-info    btn-sm userAbsent" id="userAbsent-{{ $userSchedule->id }}" value="{{$userSchedule->id}}" data-id="{{$userSchedule->id}}">Ausente</button></td>
                                    <td class="cancelButton" id="cancelButton-{{ $userSchedule->id }}"><button class="btn btn-danger  btn-sm userCancel" id="userCancel-{{ $userSchedule->id }}" value="{{$userSchedule->id}}" data-id="{{$userSchedule->id}}">Cancelar</button></td>
                                @elseif ($userSchedule->status == 'taken')
                                    <td></td>
                                    <td>Asistencia</td>
                                    <td></td>
                                @elseif ($userSchedule->status == 'absent')
                                    <td></td>
                                    <td>Ausente</td>
                                    <td></td>
                                @elseif ($userSchedule->status == 'cancelled')
                                    <td></td>
                                    <td>Cancelado</td>
                                    <td></td>
                                @endif
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    {{-- @else
        <h2 class="text-left ml-4 mt-4">No hay reservaciones en este horario</h2>
    @endif --}}
</div>

{{-- Modal Search Registered User --}}
<div class="modal" id="addOpUserModal" tabindex="-1" role="dialog" aria-labelledby="addOpUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOpUserModalLabel">Buscar usuario</h5>
                {{-- Search Bar Div--}}
                <div class="mx-auto">
                    <input id="opSearchInput" type="text" onkeyup="searchUsers()" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
                </div>
                <div class="row mx-auto">
                    <h5 class="col-8">Seleccionar lugar</h5>
                    <select class="col-4" name="bikesSelect" id="bikesSelect"></select>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-hover">
                    <thead style="font-size: 1em;">
                        <tr style="font-size: 1em;">
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Talla de calzado</th>
                            {{-- <th scope="col">ScheduleID</th> --}}
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="table-clients">
                        {{-- the Value of each Row contains its respective schedule_id --}}
                        <tr style="font-size: 0.9em;" id="opSearchUser">
                            @foreach ($users as $user)
                                <td>{{$user->name}} {{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->shoe_size}}</td>
                                <td>{{$user->id}}</td>
                                <td>
                                    <select class="form-control" id="bikesSelect" name="bikesSelect" placeholder="bikesSelect" value="{{ old('bikesSelect') }}" required>
                                        <option disabled selected hidden>Lugares disponibles</option>
                                    </select>
                                </td>
                                <td><button class="btn btn-success btn-sm "  id="clientAssist-{{ $user->id }}" value="{{$user->id}}" data-id="{{$user->id}}">Asistencia</button></td>
                            @endforeach
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                {{-- <button type="button" class="btn btn-primary" id="registerOpModalButton" data-toggle="modal" data-target="#registerOpUserModal">Nuevo</button> --}}
                <button type="button" class="btn btn-primary" id="registerOpModalButton">Nuevo</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Register New User --}}
<div class="modal fade" id="registerOpUserModal" tabindex="-1" role="dialog" aria-labelledby="registerOpUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerOpUserModalLabel">Registrar nuevo usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addInstructor') }}" class="registration"> --}}
                    @csrf
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Nombre:</label>
                            <input id="opRegName" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
                            {{-- <ul class="input-requirements">
                                <li id="nameError1">Mínimo 3 caracteres</li>
                                <li id="nameError2">Solamente números y letras (no caracteres especiales)</li>
                            </ul> --}}
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                                <label for="last_name" class="mr-sm-2">Apellido(s):</label>
                            <input id="opRegLastName" placeholder="Apellido(s)" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
                            {{-- <ul class="input-requirements">
                                <li id="lastNameError1">Mínimo 3 caracteres</li>
                                <li id="lastNameError2">Solamente números y letras (no caracteres especiales)</li>
                            </ul> --}}
                            @if ($errors->has('last_name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('last_name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="email" class="mr-sm-2">E-Mail:</label>
                            <input id="opRegEmail" placeholder="E-Mail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="birth_date" class="mr-sm-2">Fecha de nacimiento:</label>
                            <div class="input-group">
                                <input id="opRegBirthDate" min="1900-01-01" max="2100-12-31" type="date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required >
                                @if ($errors->has('birth_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('birth_date') }}</strong>
                                </span>
                                @endif
                                <div class="input-group-append" id="birth-date-append">
                                    <span class="input-group-text text-secondary bg-white">Nacimiento</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <input type="hidden" id="height" name="height" value="186" required >
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="gender" class="mr-sm-2">Sexo:</label>
                            <select class="form-control" id="opRegGender" name="gender" placeholder="Sexo" value="{{ old('gender') }}" required>
                                <option disabled selected hidden>Sexo</option>
                                <option>Hombre</option>
                                <option>Mujer</option>
                            </select>
                            @if ($errors->has('gender'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('gender') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="phone" class="mr-sm-2">Teléfono:</label>
                            <input id="opRegPhone" placeholder="Teléfono" type="number" min="0" minlength="10" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                                <label for="shoe_size" class="mr-sm-2">Talla de calzado:</label>
                            <div class="input-group">
                                <select class="form-control" id="opRegShoeSize" name="shoe_size" placeholder="Talla de Calzado" value="{{ old('shoe_size') }}" required>
                                    <option disabled selected hidden>Talla de calzado</option>
                                    <option value="23">23</option>
                                    <option value="23.5">23.5</option>
                                    <option value="24">24</option>
                                    <option value="24.5">24.5</option>
                                    <option value="25">25</option>
                                    <option value="25.5">25.5</option>
                                    <option value="26">26</option>
                                    <option value="26.5">26.5</option>
                                    <option value="27">27</option>
                                    <option value="27.5">27.5</option>
                                    <option value="28">28</option>
                                    <option value="28.5">28.5</option>
                                    <option value="29">29</option>
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text text-secondary bg-white">cm</span>
                                </div>
                            </div>
                            @if ($errors->has('shoe_size'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('shoe_size') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                                <label for="shoe_size" class="mr-sm-2">Selecciona lugar:</label>
                            <div class="input-group">
                                <select class="form-control" id="opRegBike" name="opRegBike" placeholder="opRegBike" value="{{ old('opRegBike') }}" required>
                                    <option disabled selected hidden>Lugares disponibles</option>
                                    {{-- @foreach ($userSchedules as $userSchedule)
                                        @if($userSchedule->schedule_id == El Id del schedule del primer Dropdown)
                                        @endif
                                    @endforeach --}}
                                    {{-- <option value="2">2</option>
                                    <option value="10">10</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="25">25</option>
                                    <option value="26">26</option>
                                    <option value="30">30</option>
                                    <option value="31">31</option>
                                    <option value="37">37</option>
                                    <option value="38">38</option>
                                    <option value="40">40</option>
                                    <option value="41">41</option> --}}
                                </select>
                            </div>
                            @if ($errors->has('shoe_size'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('shoe_size') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                {{-- <button type="button" class="btn btn-success" id="addInstructorButton">Añadir Instructor</button> --}}
                <button type="button" class="btn btn-primary" id="registerUserOpButton">Registrar usuario</button>
            </div>
        </div>
    </div>
</div>
@endsection

@section('extra_scripts')
{{-- Add, Delete & Edit Products Scripts --}}
<script>
    var schedule_id = null;
    var scheduled_users = [];
    var variable2 = [];
    var cols = null;
    var allUsers = null;

    var name = null;
    var last_name = null;
    var email = null;
    var birth_date = null;
    var gender = null;
    var phone = null;
    var shoe_size = null;
    var bike = null;

    var assistButton = null;
    var id = null;

    $(document).ready(function (){

        $('#main-bikes').hide();
        $('#addOpUserButton').hide()

        // If this was a call from the Admin-Schedules row, then show the Ops for that schedule
        var selected_schedule = @if (isset($selected_schedule)) {!! $selected_schedule !!} @else null; @endif ;
        if (selected_schedule != null){
            schedule_id = selected_schedule;
            showClientsTable(selected_schedule);
            $('a[id="'+schedule_id+'"]').addClass('active');
            selected_schedule = null;
        }
        // if (scheduleOperations){
        //     schedule_id = scheduleOperations;
        //     showClientsTable(scheduleOperations);
        //     $('a[id="'+schedule_id+'"]').addClass('active');
        //     scheduleOperations = null;
        // }

        // Dropdown Selected Option
        $('.dropdown-menu a').click(function(){
            $('#selectedSchedule').text($(this).text());

            // Active Schedule Dropdown
            $(activeDropdownSchedule).removeClass('active');
            $(this).addClass('active');
            activeDropdownSchedule = this;

            previousSchedule = this;
        });

        // Cols = HTMLTableElement
        cols = document.querySelectorAll('.tableBodyRow');
        allUsers = document.querySelectorAll('#opSearchUser');
        // console.log(cols);

        //OnClick attendClass Button
        // $('.userAssist').on('click', function(event) {
        $(document).on('click', '.userAssist', function(event) {
            $(this).prop("disabled", true)
            event.preventDefault();

            //Get Full ID of the button (which contains the instructor ID)
            var fullId = this.id;
            //Split the ID of the fullId by his dash
            var splitedId = fullId.split("-");
            if(splitedId.length > 1){
                // console.log(splitedId);
                var reservation_id = splitedId[1];
                attendClass(reservation_id, this);
            } else {
                $(this).prop("disabled", false);
                console.log("Malformed ID");
            }
        });

        //getuserinfo click
        $(document).on('click', '.tableBodyRow', function(event) {
            console.log("click a row");
            var schedule_id = this.id;
            console.log(schedule_id);
            getUserInfo(schedule_id);
        });

        // $('.userAbsent').on('click', function(event){
        $(document).on('click', '.userAbsent', function(event){
            event.preventDefault();
            $(this).prop('disabled', true);
            var fullId = this.id;
            var splittedId = fullId.split('-');
            if(splittedId.length > 1){
                var schedule_id = splittedId[1];
                absentClass(schedule_id, this);
            } else {
                $(this).prop('disabled', false);
                console.log('Malformed ID');
            }
        });


        // $('.userCancel').on('click' , function(event){
        $(document).on('click', '.userCancel', function(event){
            event.preventDefault();
            $(this).prop('disabled', true);
            var fullId = this.id;
            var splittedId = fullId.split('-');
            if (splittedId.length > 1){
                var schedule_id = splittedId[1];
                cancelClass(schedule_id, this);
            }
        });

        $('.scheduleList').on('click', function(event){
            $('#tableBody').empty();
            event.preventDefault();
            schedule_id = $(this).attr('id');
            // showClients(schedule_id);
            showClientsTable(schedule_id);
        });

        function cancelClass(schedule_id, button){
            $.ajax({
                url: "/cancelClass",
                method: 'POST',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    id: schedule_id,
                },
                success: function(result){
                    $(button).prop('disabled', false);
                    $('#userAssist-'+schedule_id).remove();
                    $('#userAbsent-'+schedule_id).remove();
                    $('#userCancel-'+schedule_id).remove();
                    $('#absentButton-'+schedule_id).html('Cancelado');
                    $('.active').click();
                    $('body').removeClass('modal-open');
                    // Swal.fire({
                    //     title: 'Cancelado con éxito',
                    //     text: result.message,
                    //     type: 'success',
                    //     confirmButtonText: 'Aceptar'
                    // });
                },
                error: function(result){
                    $(button).prop('disabled', false);
                    Swal.fire({
                        title: 'Error',
                        text: 'Ha ocurrido un error al procesar la solicitud',
                        type: 'warning',
                        confirmButtonText: 'Aceptar'
                    })
                }
            });
        }
        // $(document).on('click', '.active', function(){ console.log($(this).attr('id')) })

        // Jquery UI DatePicker (Safari)
        if ( $('[type="date"]').prop('type') != 'date' ) {
            $('[type="date"]').datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '-110:+0',
                dateFormat: 'yy-mm-dd',
                // showButtonPanel: true,
            });
        }

    });

    function getUserInfo(userSchedule_id){
        $.ajax({
            url: "getUserInfo",
            method: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                userSchedule_id: userSchedule_id,
            },
            success: function(result){
                var purchases_table = "";
                purchases_table += "<table class='table'>"+
                "<thead>"+
                    "<tr>"+
                        "<th>Fecha de compra</th>"+
                        "<th>Producto</th>"+
                        "<th>Horas compradas</th>"+
                        "<th>Vigencia</th>"+
                        "<th>Importe</th>"+
                        "<th>Tipo de compra</th>"+
                    "</tr>"+
                "</thead>"+
                "<tbody>"
                result[3].forEach(function(element) {
                    purchases_table += "<tr>"+
                        "<td>"+element.saleDate+"</td>"+
                        "<td>"+element.product+"</td>"+
                        "<td>"+element.purchasedClasses+"</td>"+
                        "<td>"+element.expiration+"</td>"+
                        "<td>"+element.price+"</td>"+
                        "<td>"+element.saleType+"</td>"+
                    "</tr>"
                    //     "<li><ul>" +
                    //     "<li>"+element.product_id+"</li>"+
                    //     "<li>Venta: "+typeSale+"</li>"+
                    //     "<li>Clases restantes: "+element.n_classes+"</li>"+
                    //     "<li>Exipra en "+element.expiration_days+" dias</li>"+
                    //     "<li>Realizada el:"+element.created_at+"</li>"+
                    // "</ul></li>"
                });
                purchases_table +="</tbody></table>";
                saleType = "";
                Swal.fire({
                title: result[0],
                html: "<h6>Clases disponibles: " + (result[1] == null ? 0 : result[1]) + "</h6>"  +
                "<h6>Clases expiradas: " + (result[2] == null ? 0 : result[2]) + "</h6>"  +
                purchases_table,
                type: 'info',
                confirmButtonText: 'Aceptar',
                width: '150%',
                });
            },
            error: function(result){
                console.log(result);
                Swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error al procesar la solicitud.',
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                })
            }
        });
    }

    // Search Registered User
    function searchUsers() {
        var input, filter, table, tr, name, email, i;
        input = document.getElementById("opSearchInput");
        filter = input.value.toUpperCase();
        table = document.getElementById("table-clients");
        tr = table.getElementsByTagName("tr");
        for (i = 0; i < tr.length; i++) {
            name = tr[i].getElementsByTagName("td")[0];
            email = tr[i].getElementsByTagName("td")[1];
            if (name) {
                if (name.innerHTML.toUpperCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
        $('#table-clients').show();
    }

    // On Click Register New User to Schedule
    $('#registerUserOpButton').on('click', function(){
        preRegister();
    });

    // Close Search User and Open Register User
    $('#registerOpModalButton').on('click', function(event) {
        $('#addOpUserModal').modal('hide');
        $('#registerOpUserModal').modal('show');
    });

    // Show Table Clients
    function showClients(id){
        schedule_id = id;
        var scheduled_users = []
        // variable2 = document.getElementById("tableBodyRow");
        var i = 0;
        $('tr:hidden').show();
        // cols contains the whole HTMLTableElement of the scheduled users
        cols.forEach(element => {
            // Hide a Column, which contains the Id of the User
            cols[i].cells[5].style.display = 'none';
            // cols[i].cells[6].style.display = 'none';
            if (cols[i].cells[5].innerText != id) {
                cols.item(i).style.display = 'none';
                // cols.item(i).remove();
            } else {
                // Array that contains the ID of the scheduled users
                scheduled_users.push(cols[i].cells[6].innerText);
            }
            i++;
        });

        //Command Line to delete the whole row of the table: cols.item(0).remove();
        $('#main-bikes').show('fast');
        $('#addOpUserButton').show('fast');
        $('#opRegBike').empty();
        $('#opSearchUser').empty();
        getOperationBikes(schedule_id);
        getNonScheduledUsers(schedule_id);
    }

    function selectedClientAssist(user_id){
        $(this).prop("disabled", true)
        event.preventDefault();
        var bike = $('#bikesSelect').val();
        //Get Full ID of the button (which contains the instructor ID)
        var fullId = this.id;
        //Split the ID of the fullId by his dash
        if(user_id > 0){
            claimClass(schedule_id,bike,user_id, this);
        } else {
            $(this).prop("disabled", false);
        }
    }

    //AJAX Get Non Scheduled Users
    function getNonScheduledUsers(id){
        $.ajax({
            url: '/getNonScheduledUsers',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                schedule_id: id
            },
            success: function(response) {
                $('#table-clients').empty();
                $.each(response, function(index, value){
                    $('#table-clients').append('<tr style="font-size: 0.9em;" id="opSearchUser">'+
                    '<td value="'+value.id+'">'+value.name+' '+value.last_name+'</td>'+
                    '<td>'+value.email+'</td>'+
                    '<td>'+value.shoe_size+'</td>'+
                    '<td><button class="btn btn-success btn-sm" onclick="javascript:selectedClientAssist('+value.id+');return false;" id="clientAssist-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Asistencia</button></td>'+
                    '</tr>');
                });
                $('#table-clients').hide();
            },
            error: function(response){
                $.LoadingOverlay("hide");
                // alert(result);
                Swal.fire({
                    title: 'Error',
                    text: "No se pudo procesar la solicitud.",
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                })
            }
        });
    }

    //AJAX Get Available Bikes
    function getOperationBikes(id){
        $.ajax({
            url: '/getOperationBikes',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                schedule_id: id
            },
            success: function(response) {
                $('#bikesSelect').empty();
                $('#opRegBike').empty();
                $.each(response, function(index, value){
                    // $('#opRegBike').append('<option value="'+value+'">'+value+'</option>');
                    // $('#bikesSelect').append('<option value="'+value+'">'+value+'</option>');
                    switch (value) {
                        case 2:
                            $('#opRegBike').append('<option value="'+value+'">'+1+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+1+'</option>');
                            break;
                        case 10:
                            $('#opRegBike').append('<option value="'+value+'">'+2+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+2+'</option>');
                            break;
                        case 12:
                            $('#opRegBike').append('<option value="'+value+'">'+3+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+3+'</option>');
                            break;
                        case 14:
                            $('#opRegBike').append('<option value="'+value+'">'+4+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+4+'</option>');
                            break;
                        case 20:
                            $('#opRegBike').append('<option value="'+value+'">'+5+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+5+'</option>');
                            break;
                        case 22:
                            $('#opRegBike').append('<option value="'+value+'">'+6+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+6+'</option>');
                            break;
                        case 24:
                            $('#opRegBike').append('<option value="'+value+'">'+7+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+7+'</option>');
                            break;
                        case 26:
                            $('#opRegBike').append('<option value="'+value+'">'+8+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+8+'</option>');
                            break;
                        case 30:
                            $('#opRegBike').append('<option value="'+value+'">'+9+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+9+'</option>');
                            break;
                        case 32:
                            $('#opRegBike').append('<option value="'+value+'">'+10+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+10+'</option>');
                            break;
                        case 36:
                            $('#opRegBike').append('<option value="'+value+'">'+11+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+11+'</option>');
                            break;
                        case 38:
                            $('#opRegBike').append('<option value="'+value+'">'+12+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+12+'</option>');
                            break;
                        case 40:
                            $('#opRegBike').append('<option value="'+value+'">'+13+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+13+'</option>');
                            break;
                        case 42:
                            $('#opRegBike').append('<option value="'+value+'">'+14+'</option>');
                            $('#bikesSelect').append('<option value="'+value+'">'+14+'</option>');
                            break;
                        default:
                            break;
                    }
                })
            },
            error: function(response){
                $.LoadingOverlay("hide");
                // alert(result);
                Swal.fire({
                    title: 'Error',
                    text: "No se pudo procesar la solicitud.",
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                })
            }
        });
    }

    // AJAX Register New User
    function preRegister(){
        name = $('#opRegName').val()
        last_name = $('#opRegLastName').val()
        email = $('#opRegEmail').val()
        birth_date = $('#opRegBirthDate').val()
        gender = $('#opRegGender').val()
        phone = $('#opRegPhone').val()
        shoe_size = $('#opRegShoeSize').val()
        bike = $('#opRegBike').val()
        $.ajax({
            url: '/preRegister',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
                last_name: last_name,
                email: email,
                birth_date: birth_date,
                phone: phone,
                gender: gender,
                shoe_size: shoe_size,
                schedule_id: schedule_id,
                bike: bike,
            },
            beforeSend: function(){
                $.LoadingOverlay("show");
            },
            success: function(result) {
                $.LoadingOverlay("hide");
                if(result.status == "OK"){
                    $('.modal-backdrop').remove();
                    // $('.active-menu').trigger('click');
                    $('.modal').hide();
                    $('.active').click();
                    $('body').removeClass('modal-open');
                    $('#registerOpUserModal').modal('hide');
                    Swal.fire({
                        title: 'Usuario Registrado',
                        text: result.message,
                        type: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                }
                else {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        type: 'warning',
                        confirmButtonText: 'Aceptar'
                    })
                }
            },
            error: function(result){
                $.LoadingOverlay("hide");
                // alert(result);
                Swal.fire({
                    title: 'Error',
                    text: "No se pudo procesar la solicitud.",
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                })
                $('#editInstructorButton').prop("disabled", false);
            }
        });
    }
    function attendClass(reservation_id, button){
        $.ajax({
            url: '/attendClass',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                reservation_id: reservation_id,
            },
            success: function(result) {
                $.LoadingOverlay("hide");
                if (result.status == "OK") {
                    // $('.modal-backdrop').remove();
                    // $('.active-menu').trigger('click');
                    $('#userAssist-' + reservation_id).remove();
                    $('#userAbsent-'+reservation_id).remove();
                    $('#userCancel-'+reservation_id).remove()
                    $('#absentButton-' + reservation_id).html('Asistencia');
                    // showClients(id);
                    // Swal.fire({
                    //     title: 'Asistencia registrada',
                    //     text: result.message,
                    //     type: 'success',
                    //     confirmButtonText: 'Aceptar'
                    // })
                } else {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        type: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    $(button).prop("disabled", false)
                }
            },
            error: function(result){
                $.LoadingOverlay("hide");
                Swal.fire({
                    title: 'Error',
                    text: "No se pudo procesar la solicitud.",
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                $(button).prop("disabled", false)
                // alert(result);
            }
        });
    }

    function absentClass(schedule_id, button){
        $.ajax({
            url: "/absentUserClass",
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                schedule_id: schedule_id,
            },
            success: function(result){
                if (result.status == 'OK'){
                    $(button).prop('disabled', false);
                    $('#userAssist-'+schedule_id).remove();
                    $('#userAbsent-'+schedule_id).remove();
                    $('#userCancel-'+schedule_id).remove();
                    $('#absentButton-'+schedule_id).html('Ausente');
                    // Swal.fire({
                    //     title: 'Llamada Exitosa',
                    //     text: result.message,
                    //     type: 'success',
                    //     confirmButtonText: 'Aceptar',
                    // });
                }
                else {
                    $(button).prop('disabled', false);
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        type: 'warning',
                        confirmButtonText: 'Aceptar',
                    })
                }
            },
            error: function (result){
                $(button).prop('disabled', false),
                Swal.fire({
                    title: 'Error',
                    text: 'Ocurrió un error al procesar la solicitud',
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                });
            }
        });
    }

    function showClientsTable(schedule_id){
        $.ajax({
            url: '/showClientsTable',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                schedule_id: schedule_id,
            },
            success: function(result) {
                var today = new Date();
                var dd = String(today.getDate()).padStart(2, '0');
                var mm = String(today.getMonth() + 1).padStart(2, '0');
                today = mm + "-" + dd;
                console.log(today);
                $('tr:hidden').show();
                $('.tableBodyRow').empty();
                console.log(result);
                $.each (result, function(index, value){
                    console.log(value);
                    if (value.status != 'cancelled'){
                        if(value.status == 'taken'){
                            console.log(today);
                            if(value.birth_date.substr(5) == value.daySchedule.substr(5)){
                                if(value.type == 'Free'){
                                    $('#tableBody').append(
                                    '<tr class="tableBodyRow" id="'+value.id+'" style="background-color: #73e340;"><td><img src="/img/iconos/cake.png" height="25" width="25">'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td></td><td>Asistió</td><td></td></tr>',
                                    );
                                }else{
                                    $('#tableBody').append(
                                    '<tr class="tableBodyRow" id="'+value.id+'"><td><img src="/img/iconos/cake.png" height="25" width="25">'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td></td><td>Asistió</td><td></td></tr>',
                                    );
                                }
                            }else{
                                if(value.type == 'Free'){
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'" style="background-color: #73e340;"><td>'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td></td><td>Asistió</td><td></td></tr>',
                                    );
                                }else{
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'"><td>'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td></td><td>Asistió</td><td></td></tr>',
                                    );
                                }
                            }
                        } else if (value.status == 'absent'){
                            if(value.birth_date.substr(5) == value.daySchedule.substr(5)){
                                if(value.type == 'Free'){
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'" style="background-color: #73e340;"><td><img src="/img/iconos/cake.png" height="25" width="25">'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td></td><td>Ausente</td><td></td></tr>',
                                    );
                                }else{
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'"><td><img src="/img/iconos/cake.png" height="25" width="25">'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td></td><td>Ausente</td><td></td></tr>',
                                    );
                                }
                            }else{
                                if(value.type == 'Free'){
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'" style="background-color: #73e340;"><td>'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td></td><td>Ausente</td><td></td></tr>',
                                    );
                                }else{
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'"><td>'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td></td><td>Ausente</td><td></td></tr>',
                                    );
                                }
                            }
                        } else {
                            if(value.birth_date.substr(5) == value.daySchedule.substr(5)){
                                if(value.type == 'Free'){
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'" style="background-color: #73e340;"><td><img src="/img/iconos/cake.png" height="25" width="25">'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td class="assistButton" id="assistButton-'+value.id+'"><button class="btn btn-success btn-sm userAssist" id="userAssist-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Asistencia</button></td><td class="absentButton" id="absentButton-'+value.id+'"><button class="btn btn-info    btn-sm userAbsent" id="userAbsent-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Ausente</button></td><td class="cancelButton" id="cancelButton-'+value.id+'"><button class="btn btn-danger  btn-sm userCancel" id="userCancel-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Cancelar</button></td></tr>',
                                    );
                                }else{
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'"><td><img src="/img/iconos/cake.png" height="25" width="25">'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td class="assistButton" id="assistButton-'+value.id+'"><button class="btn btn-success btn-sm userAssist" id="userAssist-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Asistencia</button></td><td class="absentButton" id="absentButton-'+value.id+'"><button class="btn btn-info    btn-sm userAbsent" id="userAbsent-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Ausente</button></td><td class="cancelButton" id="cancelButton-'+value.id+'"><button class="btn btn-danger  btn-sm userCancel" id="userCancel-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Cancelar</button></td></tr>',
                                    );
                                }
                            }else{
                                if(value.type == 'Free'){
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'" style="background-color: #73e340;"><td>'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td class="assistButton" id="assistButton-'+value.id+'"><button class="btn btn-success btn-sm userAssist" id="userAssist-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Asistencia</button></td><td class="absentButton" id="absentButton-'+value.id+'"><button class="btn btn-info    btn-sm userAbsent" id="userAbsent-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Ausente</button></td><td class="cancelButton" id="cancelButton-'+value.id+'"><button class="btn btn-danger  btn-sm userCancel" id="userCancel-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Cancelar</button></td></tr>',
                                    );
                                }else{
                                    $('#tableBody').append(
                                        '<tr class="tableBodyRow" id="'+value.id+'"><td>'+value.name+' '+value.last_name+'</td><td>'+value.email+'</td><td class="tdBikeNumber">'+value.bike+'</td><td>'+value.shoe_size+'</td><td>'+value.phone+'</td><td class="assistButton" id="assistButton-'+value.id+'"><button class="btn btn-success btn-sm userAssist" id="userAssist-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Asistencia</button></td><td class="absentButton" id="absentButton-'+value.id+'"><button class="btn btn-info    btn-sm userAbsent" id="userAbsent-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Ausente</button></td><td class="cancelButton" id="cancelButton-'+value.id+'"><button class="btn btn-danger  btn-sm userCancel" id="userCancel-'+value.id+'" value="'+value.id+'" data-id="'+value.id+'">Cancelar</button></td></tr>',
                                    );
                                }
                            }
                        }
                    }
                });
                $('#main-bikes').show('fast');
                $('#addOpUserButton').show('fast');
                $('#opRegBike').empty();
                $('#opSearchUser').empty();
                getOperationBikes(schedule_id);
                getNonScheduledUsers(schedule_id);
                switchBike();
            },
            error: function(result) {
                console.log(result);
            }
        })
    }

    function switchBike(){
        var bikeNumber = null;
        $.each($('.tdBikeNumber'), function( index, value ) {
            bikeNumber = $(value).text();
            switch (bikeNumber) {
                case '2':
                    $(value).text('1')
                    break;
                case '10':
                    $(value).text('2')
                    break;
                case '12':
                    $(value).text('3')
                    break;
                case '14':
                    $(value).text('4')
                    break;
                case '20':
                    $(value).text('5')
                    break;
                case '22':
                    $(value).text('6')
                    break;
                case '24':
                    $(value).text('7')
                    break;
                case '26':
                    $(value).text('8')
                    break;
                case '30':
                    $(value).text('9')
                    break;
                case '32':
                    $(value).text('10')
                    break;
                case '36':
                    $(value).text('11')
                    break;
                case '38':
                    $(value).text('12')
                    break;
                case '40':
                $(value).text('13')
                    break;
                case '42':
                    $(value).text('14')
                    break;
                default:
                    break;
            }
        });
    }

    function claimClass(schedule_id,bike,user_id, button){
        $.ajax({
            url: '/claimClass',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                schedule_id: schedule_id,
                bike: bike,
                user_id: user_id
            },
            success: function(result) {
                $.LoadingOverlay("hide");
                if (result.status == "OK") {
                    $('.modal-backdrop').remove();
                    $('.modal').hide();
                    $('.modal-open').removeClass('.modal-open');
                    // $('.active-menu').trigger('click');
                    $('.active').click();
                    $('body').removeClass('modal-open');
                    $('#opSearchInput').val('');
                    // $(activeDropdownSchedule).removeClass('active');
                    // $(activeDropdownSchedule).click();
                    Swal.fire({
                        title: 'Asignado con éxito',
                        text: result.message,
                        type: 'success',
                        confirmButtonText: 'Aceptar'
                    })
                } else {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Error',
                        text: result.message,
                        type: 'warning',
                        confirmButtonText: 'Aceptar'
                    });
                    $(button).prop("disabled", false)
                }
            },
            error: function(result){
                $.LoadingOverlay("hide");
                Swal.fire({
                    title: 'Error',
                    text: "No se pudo procesar la solicitud.",
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                });
                $(button).prop("disabled", false)
                // alert(result);
            }
        });
    }
</script>
@endsection