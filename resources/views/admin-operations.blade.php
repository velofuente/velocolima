{{-- Show the Schedules (ordered by Hour) for today --}}
<input type="hidden" name="langUnix" value="{{date_default_timezone_set('America/Mexico_City')}}">
<input type="hidden" name="langWindows" value="{{setlocale(LC_TIME, 'es_MX.UTF-8')}}">
<input type="hidden" name="langLocal" value="{{setlocale(LC_TIME, 'spanish')}}">

@php
    $indexScheduleId = 0;
@endphp
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
            <span id="selectedSchedule">Seleccionar Horario</span>
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownSchedule">
        @if (count($userSchedules) > 0)
            @foreach ($schedules as $schedule)
                {{-- @if ($schedule->day == date('Y-m-d')) --}}
                    {{-- @if ($schedule->hour >= date('H:i:s')) --}}
                        <a class="dropdown-item" href="javascript:showClients({{$schedule->id}})" id="{{$schedule->id}}">
                            {{-- <span class="col-4 text-center">{{ date('l', strtotime($schedule->day)) }}</span> --}}
                            <span class="col-4">{{strftime("%a", strtotime($schedule->day))}}</span>
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
              <h3>No hay Horarios Creados<h3>
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
    <div class="col-md-2">
        @if (count($userSchedules) > 0)
            <table class="table table-striped table-hover">
                <thead style="font-size: 1em;">
                    <tr style="font-size: 1em;">
                        <th scope="col">Nombre</th>
                        <th scope="col">Email</th>
                        <th scope="col">Asiento</th>
                        <th scope="col">Talla de Calzado</th>
                        <th scope="col">Teléfono</th>
                        {{-- <th scope="col">ScheduleID</th> --}}
                        <th scope="col">Acción</th>
                    </tr>
                </thead>
                <tbody>
                    {{-- the Value of each Row contains its respective schedule_id --}}
                    @foreach ($userSchedules as $userSchedule)
                        @if ($userSchedule->status != 'cancelled')
                            <tr style="font-size: 0.9em;" id="tableBodyRow">
                                <input type="hidden" value="{{$userSchedule->schedule_id}}" id="hiddenUsers">
                                <td>{{$userSchedule->user->name}} {{$userSchedule->user->last_name}}</td>
                                <td>{{$userSchedule->user->email}}</td>
                                <td>{{$userSchedule->bike}}</td>
                                <td>{{$userSchedule->user->shoe_size}}</td>
                                <td> {{$userSchedule->user->phone}} </td>
                                <td>{{$userSchedule->schedule_id}}</td>
                                <td><button class="btn btn-success btn-sm userAssist" id="userAssist-{{ $userSchedule->user->id }}" value="{{$userSchedule->user->id}}" data-id="{{$userSchedule->user->id}}" data-toggle="modal" data-target="#editInstructorModal">Asistencia</button></td>
                            </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        @else
            <h2 class="text-center">No hay usuarios en esta sesión</h2>
        @endif
    </div>
</div>


{{-- Modal Search Registered User --}}
<div class="modal" id="addOpUserModal" tabindex="-1" role="dialog" aria-labelledby="addOpUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addOpUserModalLabel">Buscar Usuario</h5>
                {{-- Search Bar Div--}}
                <div class="mx-auto">
                    <input id="nameInstructor" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                    @if ($errors->has('name'))
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('name') }}</strong>
                        </span>
                    @endif
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
                            <th scope="col">Talla de Calzado</th>
                            {{-- <th scope="col">ScheduleID</th> --}}
                            <th scope="col">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- the Value of each Row contains its respective schedule_id --}}
                        @foreach ($users as $user)
                            <tr style="font-size: 0.9em;" id="opSearchUser">
                                <td>{{$user->name}} {{$user->last_name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->shoe_size}}</td>
                                <td>{{$user->id}}</td>
                                <td><button class="btn btn-success btn-sm userAssist" id="userAssist-{{ $user->id }}" value="{{$user->id}}" data-id="{{$user->id}}" data-toggle="modal" data-target="#editInstructorModal">Asistencia</button></td>
                            </tr>
                        @endforeach
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
                <h5 class="modal-title" id="registerOpUserModalLabel">Registrar Nuevo Usuario</h5>
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
                            <label for="birth_date" class="mr-sm-2">Fecha de Nacimiento:</label>
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
                                <label for="shoe_size" class="mr-sm-2">Talla de Calzado:</label>
                            <div class="input-group">
                                <select class="form-control" id="opRegShoeSize" name="shoe_size" placeholder="Talla de Calzado" value="{{ old('shoe_size') }}" required>
                                    <option disabled selected hidden>Talla de Calzado</option>
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
                                <label for="shoe_size" class="mr-sm-2">Lugares Disponibles:</label>
                            <div class="input-group">
                                <select class="form-control" id="opRegBike" name="shoe_size" placeholder="Talla de Calzado" value="{{ old('shoe_size') }}" required>
                                    <option disabled selected hidden>Lugares Disponibles</option>
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
                <button type="button" class="btn btn-primary" id="registerUserOpButton">Registrar Usuario</button>
            </div>
        </div>
    </div>
</div>

{{-- Add, Delete & Edit Products Scripts --}}
<script>
    var schedule_id = null;
    var variable2 = [];
    var availableBikes = [];
    var cols = null;
    var allUsers = null;

    var name = null;
    var last_name = null;
    var email = null;
    var birth_date = null;
    var gender = null;
    var phone = null;
    var shoeSize = null;
    var bike = null;

    $(document).ready(function (){
        $('#main-bikes').hide();
        $('#addOpUserButton').hide()

        // Dropdown Selected Option
        $('.dropdown-menu a').click(function(){
            $('#selectedSchedule').text($(this).text());
        });

        // Cols = HTMLTableElement
        cols = document.querySelectorAll('#tableBodyRow');
        allUsers = document.querySelectorAll('#opSearchUser');
        // console.log(cols);
    });

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
        // variable2 = document.getElementById("tableBodyRow");
        console.log('ID guardado (Schedule): ' + id);
        var i = 0;
        $('tr:hidden').show();
        cols.forEach(element => {
            // Hide a Column, which contains the Id of the User
            cols[i].cells[5].style.display = 'none';
            if (cols[i].cells[5].innerText != id) {
                cols.item(i).style.display = 'none';
                // cols.item(i).remove();
            }
            i++;
        });

        //Línea para Eliminar la Fila de la Tabla
        // cols.item(0).remove();
        $('#main-bikes').show('fast');
        $('#addOpUserButton').show('fast');
        $('#opRegBike').empty();
        getOperationBikes(schedule_id);
        // showUnscheduledUsers()
    }


    // function showUnscheduledUsers(){
    //     var index = 0;
    //     // $('tr:hidden').show();
    //     allUsers.forEach(element => {
    //         // Hide a Column, which contains the Id of the Users
    //         allUsers[index].cells[3].style = 'none';
    //         if (allUsers[index].cells[3].innerText )
    //         // if (allUsers[index].cells[3].innerText != id ){
    //             allUsers.item(index).style.display = 'none';
    //             // allUsers.item(index).remove()
    //         }
    //         index++;
    //     });
    // };


    //AJAX Get Available Bikes
    function getOperationBikes(id){
        $.ajax({
            url: 'getOperationBikes',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                schedule_id: id
            },
            success: function(response) {
                //availableBikes = response;
                $.each(response, function(index, value){
                    $('#opRegBike').append('<option value="'+value+'">'+value+'</option>');
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
        shoeSize = $('#opRegShoeSize').val()
        bike = $('#opRegBike').val()
        $.ajax({
            url: 'preRegister',
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
                shoeSize: shoeSize,
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
                    $('.active-menu').trigger('click');
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

</script>