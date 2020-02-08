@extends('admin.app')

@section('extra_styles')
@stop

@section('content')
{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Usuarios</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addUserModal">Añadir usuario</button>
</div>

{{-- Table  --}}
@if (count($users) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellido</th>
                <th scope="col">Correo</th>
                <th scope="col">Fecha de nacimiento</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Género</th>
                {{-- <th scope="col">Sucursal</th> --}}
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->birth_date}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->gender}}</td>
                    {{-- <td>{{$user->branch->name}}</td> --}}
                    <td><button class="btn btn-primary btn-sm editUser" id="editUser-{{ $user->id }}" value="{{$user->id}}" data-myid="{{ $user->id }}" data-myname="{{ $user->name }}" data-mylastname="{{ $user->last_name }}" data-myemail="{{$user->email}}" data-mybirthdate="{{ $user->birth_date }}" data-myphone="{{$user->phone}}" data-mygender="{{$user->gender}}" data-toggle="modal" data-target="#editUserModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteUser" id="deleteUser-{{ $user->id }}" value="{{$user->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay usuarios agregados</h2>
@endif

{{-- Modal Add User --}}
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Añadir usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addUser') }}" class="registration"> --}}
                    @csrf
                    {{-- User's Name --}}
                    <div class="form-group row mb-1">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Nombre:</label>
                            <input id="addUserName" type="text" placeholder="Nombre" class="form-control{{ $errors->has('addUserName') ? ' is-invalid' : '' }}" name="name" value="{{ old('addUserName') }}" required autofocus >
                            @if ($errors->has('addUserName'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addUserName') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Lastname --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="last_name" class="mr-sm-2">Apellido:</label>
                            <div class="input-group">
                                <input id="addUserLastName" placeholder="Apellido" type="text" class="form-control{{ $errors->has('addUserLastName') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('addUserLastName') }}" required>
                                @if ($errors->has('addUserLastName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('addUserLastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Email --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="email" class="mr-sm-2">Correo:</label>
                            <input id="addUserEmail" placeholder="Correo" type="email" class="form-control{{ $errors->has('addUserEmail') ? ' is-invalid' : '' }}" name="email" value="{{ old('addUserEmail') }}" required>
                            @if ($errors->has('addUserEmail'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addUserEmail') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Password --}}
                    {{-- <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="password" class="mr-sm-2">Contraseña:</label>
                            <input id="addUserPassword" placeholder="Contraseña" minlength="7" type="password" class="form-control{{ $errors->has('addUserPassword') ? ' is-invalid' : '' }}" name="addUserPassword" value="{{ old('addUserPassword') }}" required>
                            @if ($errors->has('addUserPassword'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addUserPassword') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div> --}}
                    {{-- User's Password Confirmation --}}
                    {{-- <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="password-confirm" class="mr-sm-2">Confirmar contraseña:</label>
                            <input id="password-confirm" placeholder="Confirmar contraseña" minlength="7" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div> --}}
                    {{-- User's Birth Date --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="birth_date" class="mr-sm-2">Fecha de nacimiento:</label>
                            <div class="input-group">
                                <input id="addUserBirthDate" min="1900-01-01" max="2100-12-31" placeholder="Fecha de Nacimiento" type="date" class="form-control{{ $errors->has('addUserBirthDate') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('addUserBirthDate') }}" required >
                                @if ($errors->has('addUserBirthDate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addUserBirthDate') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Phone --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="phone" class="mr-sm-2">Teléfono:</label>
                            <div class="input-group">
                                <input id="addUserPhone" placeholder="Teléfono" maxlength="15" type="number" class="form-control{{ $errors->has('addUserPhone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('addUserPhone') }}" required >
                                @if ($errors->has('addUserPhone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addUserPhone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Gender --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="gender">Género: </label>
                            <select class="form-control" name="gender" id="addUserGender" required>
                                <option value="Hombre" class="text-center">Hombre</option>
                                <option value="Mujer" class="text-center">Mujer</option>
                            </select>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="addUserButton">Añadir usuario</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit User --}}
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar información</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addProduct') }}" class="registration"> --}}
                    @csrf
                    {{-- User's Name --}}
                    <div class="form-group row mb-1">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Nombre:</label>
                            <input id="editUserName" type="text" placeholder="Nombre" class="form-control{{ $errors->has('editUserName') ? ' is-invalid' : '' }}" name="name" value="{{ old('editUserName') }}" required autofocus >
                            @if ($errors->has('editUserName'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editUserName') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Lastname --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="editUserLastName" class="mr-sm-2">Apellido:</label>
                            <div class="input-group">
                                <input id="editUserLastName" placeholder="Apellido" type="text" class="form-control{{ $errors->has('editLastName') ? ' is-invalid' : '' }}" name="editUserLastName" value="{{ old('editLastName') }}" required autofocus>
                                @if ($errors->has('editUserLastName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('editUserLastName') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Email --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="email" class="mr-sm-2">Correo:</label>
                            <input id="editUserEmail" placeholder="Correo" type="email" class="form-control{{ $errors->has('editUserEmail') ? ' is-invalid' : '' }}" name="email" value="{{ old('editUserEmail') }}" required>
                            @if ($errors->has('editUserEmail'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editUserEmail') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                     {{-- User's Birth Date --}}
                     <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="birth_date" class="mr-sm-2">Fecha de nacimiento:</label>
                            <div class="input-group">
                                <input id="editUserBirthDate" min="1900-01-01" max="2100-12-31" placeholder="Fecha de Nacimiento" type="date" class="form-control{{ $errors->has('editUserBirthDate') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('editUserBirthDate') }}" required >
                                @if ($errors->has('editUserBirthDate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editUserBirthDate') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Birth Date --}}
                    {{-- <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="birth_date" class="mr-sm-2">Fecha de nacimiento:</label>
                            <div class="input-group">
                                <input id="editUserBirthDate" min="1900-01-01" max="2100-12-31" placeholder="Fecha de Nacimiento" type="date" class="form-control{{ $errors->has('editUserBirthDate') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('editUserBirthDate') }}" required >
                                @if ($errors->has('editUserBirthDate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editUserBirthDate') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div> --}}
                    {{-- User's Phone --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="phone" class="mr-sm-2">Teléfono:</label>
                            <div class="input-group">
                                <input id="editUserPhone" maxlength="15" placeholder="Teléfono" type="number" class="form-control{{ $errors->has('editUserPhone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('editUserPhone') }}" required >
                                @if ($errors->has('editUserPhone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editUserPhone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Gender --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="gender">Género: </label>
                            <select class="form-control" name="gender" id="editUserGender" required>
                                <option value="Hombre" class="text-center">Hombre</option>
                                <option value="Mujer" class="text-center">Mujer</option>
                            </select>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="editUserButton">Editar usuario</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('extra_scripts')
{{-- Add, Delete & Edit User Scripts --}}
<script>
    $(document).ready(function (){
        var user_id = null;
        var name = null;
        var last_name = null;
        var email = null;
        var password = null;
        var password_confirm = null;
        var birth_date = null;
        var phone = null;
        var gender = null;

        // Select the Phone Input.
        var phone = document.getElementById('addUserPhone');
        var editPhone = document.getElementById('editUserPhone');

        // Lock the input only to numbers.
        phone.onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8 || e.keyCode == 9)) {
                return false;
            }
        }
        // Lock the input only to numbers.
        editPhone.onkeydown = function(e) {
            if(!((e.keyCode > 95 && e.keyCode < 106)
            || (e.keyCode > 47 && e.keyCode < 58)
            || e.keyCode == 8 || e.keyCode == 9)) {
                return false;
            }
        }

        // // Jquery UI DatePicker (Safari)
        if ( $('[type="date"]').prop('type') != 'date' ) {
            $('[type="date"]').datepicker({
                changeMonth: true,
                changeYear: true,
                yearRange: '-110:+0',
                dateFormat: 'yy-mm-dd',
                // showButtonPanel: true,
            });
        }

        //OnClick Add User Button
        $('#addUserButton').on('click', function(event) {
            event.preventDefault();
            $('#addUserButton').attr('disabled', true);
            name = $('#addUserName').val();
            last_name =  $('#addUserLastName').val();
            email =  $('#addUserEmail').val();
            password =  $('#addUserPassword').val();
            password_confirm =  $('#password-confirm').val();
            birth_date =  $('#addUserBirthDate').val();
            phone =  $('#addUserPhone').val();
            gender =  $('#addUserGender').val();
            addUser();
        })

        //OnClick Delete User Button
        $('.deleteUser').on('click', function(event) {
            $(this).prop("disabled", true)
            event.preventDefault();

            //Get Full ID of the button (which contains the user ID)
            var fullId = this.id;
            //Split the ID of the fullId by his dash
            var splitedId = fullId.split("-");
            if(splitedId.length > 1){
                // console.log(splitedId);
                var userId = splitedId[1];
                deleteUser(userId, this);
            } else {
                $(this).prop("disabled", false)
                console.log("Malformed ID")
            }
            // $('#deleteUserButton').attr('disabled', true);
        })

        //OnClick Edit User Button
        $('.editUser').on('click', function (){
            // $(this).prop('disabled', true);
            event.preventDefault();

            //Get Full ID of the button (which contains the user ID)
            var fullId = this.id;
            //Split the ID of the fullId by his dash
            var splitedId = fullId.split("-");
            if(splitedId.length > 1){
                // console.log(splitedId);
                var userId = splitedId[1];
                // editUser(instructorId, this);
            } else {
                $(this).prop("disabled", false)
                console.log("Malformed ID")
            }
            })

        //OnClick editUserModal Button

        //When Edit User Modal Opened...
        $('#editUserModal').on('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = $(event.relatedTarget)
            // Extract info from data-* attributes
            user_id = button.data('myid')
            name = button.data('myname')
            last_name = button.data('mylastname') // Extract info from data-* attributes
            email = button.data('myemail');
            phone = button.data('myphone');
            birth_date = button.data('mybirthdate');
            gender = button.data('mygender');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            // Load the Inputs with the respective information
            var modal = $(this)
            modal.find('.modal-body #editUserName').val(name)
            modal.find('.modal-body #editUserLastName').val(last_name)
            modal.find('.modal-body #editUserEmail').val(email)
            modal.find('.modal-body #editUserPhone').val(phone)
            modal.find('.modal-body #editUserBirthDate').val(birth_date)
            modal.find('.modal-body #editUserGender').val(gender);
        })

        //Edit User Button Inside Modal
        $('#editUserButton').on('click', function(){
            $('#editUserButton').prop("disabled", true)
            event.preventDefault();

            // Extract info from data-* attributes
            name = $('#editUserName').val();
            last_name = $('#editUserLastName').val();
            email = $('#editUserEmail').val();
            phone = $('#editUserPhone').val();
            birth_date = $('#editUserBirthDate').val();
            gender = $('#editUserGender').val();

            editUser(user_id);
        })

        function addUser(){
            $.ajax({
                url: '/addUser',
                type: 'POST',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    name: name,
                    last_name: last_name,
                    email: email,
                    // password: password,
                    birth_date: birth_date,
                    phone: phone,
                    gender: gender
                },
                success: function(result) {
                    $.LoadingOverlay("hide");
                    if(result.status == "OK"){
                        // console.log(result.status);
                        // $('#users').trigger('click');
                        $('.modal-backdrop').remove();
                        // $('.active-menu').trigger('click');
                        $('#addUserModal').modal('hide');
                        Swal.fire({
                            title: 'Usuario Añadido',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                        window.location.replace('/admin/users');
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
                }
            });
        }

        function editUser(user_id){
            $.ajax({
                url: "/editUser",
                type: 'POST',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $.LoadingOverlay("show");
                },
                data: {
                    user_id: user_id,
                    name: name,
                    last_name: last_name,
                    email: email,
                    phone: phone,
                    birth_date: birth_date,
                    gender: gender,
                },
                success: function(result) {
                    $.LoadingOverlay("hide");
                    if(result.status == "OK"){
                        // console.log(result.status);
                        $('.modal-backdrop').remove();
                        // $('.active-menu').trigger('click');
                        $('#editUserModal').modal('hide');
                        Swal.fire({
                            title: 'Usuario editado',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                        window.location.replace('/admin/users');
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
                }
            });
        };

        function deleteUser(user_id, button){
            // user_id = $('#deleteUserButton').val();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No se podrán revertir los cambios!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminar usuario'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '/deleteUser',
                        type: 'POST',
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            user_id: user_id,
                        },
                        success: function(result) {
                            $.LoadingOverlay("hide");
                            if (result.status == "OK") {
                                console.log(result.status);
                                $('.modal-backdrop').remove();
                                // $('.active-menu').trigger('click');
                                Swal.fire({
                                    title: 'Usuario eliminado',
                                    text: result.message,
                                    type: 'success',
                                    confirmButtonText: 'Aceptar'
                                })
                                window.location.replace('/admin/users');
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
                } else {
                    $(button).prop("disabled", false)
                }
            })
        }
    })
</script>
@stop