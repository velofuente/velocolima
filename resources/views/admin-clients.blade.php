{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Clientes</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#registerClientModal">Añadir Cliente</button>
</div>

{{-- Table  --}}
@if (count($clients) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Correo</th>
                <th scope="col">Fecha de nacimiento</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Talla de Calzado</th>
                <th scope="col">Clases disponibles</th>
                <th scope="col">Clases Reservadas</th>
            </tr>
        </thead>
        <tbody id="table-clients">
            @foreach ($clients as $client)
                <tr style="font-size: 0.9em;">
                    <td>{{$client->id}}</td>
                    <td>{{$client->name}}</td>
                    <td>{{$client->last_name}}</td>
                    <td>{{$client->email}}</td>
                    <td>{{$client->birth_date}}</td>
                    <td>{{$client->phone}}</td>
                    <td>{{$client->shoe_size}}</td>
                    <td>{{($client->availableClasses->clases) ? $client->availableClasses->clases : 'N/D'}}</td>
                    <td>{{($client->bookedClasses) ? $client->bookedClasses : 'N/D'}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Clientes Agregados</h2>
@endif
{{-- /Table  --}}
{{-- Modal Register New Client --}}
<div class="modal fade" id="registerClientModal" tabindex="-1" role="dialog" aria-labelledby="registerClientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerClientModalLabel">Registrar Nuevo Cliente</h5>
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
                            <input id="RegName" type="text" placeholder="Nombre(s)" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus>
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
                            <input id="RegLastName" placeholder="Apellido(s)" type="text" class="form-control{{ $errors->has('last_name') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('last_name') }}" required>
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
                            <input id="RegEmail" placeholder="E-Mail" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
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
                            <label for="password" class="mr-sm-2">Password:</label>
                            <input id="RegPassword" placeholder="Contraseña" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>
                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                            <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                            <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                                <label for="password-confirm" class="mr-sm-2">Confirmar Contraseña:</label>
                                <input id="password-confirm" placeholder="Confirmar Contraseña" type="password" class="form-control" name="password_confirmation" required>
                            </div>
                            <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="birth_date" class="mr-sm-2">Fecha de Nacimiento:</label>
                            <div class="input-group">
                                <input id="RegBirthDate" min="1900-01-01" max="2100-12-31" type="date" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required >
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
                            <select class="form-control" id="RegGender" name="gender" placeholder="Sexo" value="{{ old('gender') }}" required>
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
                            <input id="RegPhone" placeholder="Teléfono" type="number" min="0" minlength="10" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
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
                                <select class="form-control" id="RegShoeSize" name="shoe_size" placeholder="Talla de Calzado" value="{{ old('shoe_size') }}" required>
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
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                {{-- <button type="button" class="btn btn-success" id="addInstructorButton">Añadir Instructor</button> --}}
                <button type="button" class="btn btn-primary" id="registerClientButton">Registrar Usuario</button>
            </div>
        </div>
    </div>
</div>
<script>
    var name = null;
    var last_name = null;
    var email = null;
    var password = null;
    var birth_date = null;
    var gender = null;
    var phone = null;
    var shoe_size = null;

    $(document).ready(function (){
        // On Click Register New User to Schedule
        $('#registerClientButton').on('click', function(){
            register();
        });
    });
    // AJAX Register New User
    function register(){
        name = $('#RegName').val()
        last_name = $('#RegLastName').val()
        email = $('#RegEmail').val()
        password = $('#RegPassword').val()
        birth_date = $('#RegBirthDate').val()
        phone = $('#RegPhone').val()
        gender = $('#RegGender').val()
        shoe_size = $('#RegShoeSize').val()
        $.ajax({
            url: 'addClient',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                name: name,
                last_name: last_name,
                email: email,
                password: password,
                birth_date: birth_date,
                phone: phone,
                gender: gender,
                shoe_size: shoe_size,
            },
            beforeSend: function(){
                $.LoadingOverlay("show");
            },
            success: function(result) {
                $.LoadingOverlay("hide");
                if(result.status == "OK"){
                    $('.modal-backdrop').remove();
                    $('.active-menu').trigger('click');
                    $('#registerClientModal').modal('hide');
                    Swal.fire({
                        title: 'Cliente Registrado',
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
                Swal.fire({
                    title: 'Error',
                    text: "No se pudo procesar la solicitud.",
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                })
            }
        });
    }
</script>