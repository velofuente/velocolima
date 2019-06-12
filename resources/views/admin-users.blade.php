{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Usuarios</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addUserModal">Añadir Usuario</button>
</div>

{{-- Table  --}}
@if (count($users) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Correo</th>
                <th scope="col">Fecha de nacimiento</th>
                <th scope="col">Teléfono</th>
                <th scope="col">Género</th>
                <th scope="col">Sucursal</th>
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}} {{$user->last_name}}</td>
                    <td>{{$user->email}}</td>
                    <td>${{$user->birth_date}}</td>
                    <td>{{$user->phone}}</td>
                    <td>{{$user->gender}}</td>
                    <td>{{$user->branch->name}}</td>
                    <td><button class="btn btn-primary btn-sm editUser" id="editUser-{{ $user->id }}" value="{{$user->id}}" data-myid="{{ $user->id }}" data-myname="{{ $user->name }}" data-mylastname="{{ $user->last_name }}" data-mybirthday="{{ $user->birth_day }}" data-myphone="{{$user->phone}}" data-myemail="{{$user->email}}" data-toggle="modal" data-target="#editUserModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteUser" id="deleteUser-{{ $user->id }}" value="{{$user->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Usuarios Agregados</h2>
@endif

{{-- Modal Add User --}}
<div class="modal fade" id="addUserModal" tabindex="-1" role="dialog" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Añadir Usuario</h5>
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
                            <input id="addName" type="text" placeholder="Nombre" class="form-control{{ $errors->has('addName') ? ' is-invalid' : '' }}" name="name" value="{{ old('addName') }}" required autofocus >
                            @if ($errors->has('addName'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addName') }}</strong>
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
                                <input id="addLastName" placeholder="Apellido" type="text" class="form-control{{ $errors->has('addLastName') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('addLastName') }}" required autofocus>
                                @if ($errors->has('addLastName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('addLastName') }}</strong>
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
                            <input id="addEmail" placeholder="Correo" type="text" class="form-control{{ $errors->has('addEmail') ? ' is-invalid' : '' }}" name="email" value="{{ old('addEmail') }}" required>
                            @if ($errors->has('addEmail'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addEmail') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Password --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="password" class="mr-sm-2">Contraseña:</label>
                            <input id="addPassword" placeholder="Contraseña" minlength="7" type="password" class="form-control{{ $errors->has('addPassword') ? ' is-invalid' : '' }}" name="addPassword" value="{{ old('addPassword') }}" required>
                            @if ($errors->has('addPassword'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addPassword') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Password Confirmation --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="password-confirm" class="mr-sm-2">Confirmar contraseña:</label>
                            <input id="password-confirm" placeholder="Confirmar contraseña" minlength="7" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Birthday --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="birth_date" class="mr-sm-2">Fecha de nacimiento:</label>
                            <div class="input-group">
                                <input id="addBirthDate" placeholder="Fecha de Nacimiento" type="date" class="form-control{{ $errors->has('addBirthDate') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('addBirthDate') }}" required >
                                @if ($errors->has('addBirthDate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addBirthDate') }}</strong>
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
                                <input id="addPhone" placeholder="Teléfono" type="number" class="form-control{{ $errors->has('addPhone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('addPhone') }}" required >
                                @if ($errors->has('addPhone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('addPhone') }}</strong>
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
                            <select class="form-control" name="gender" id="addGender">
                                <option value="Hombre" class="text-center">Hombre</option>
                                <option value="Mujer" class="text-center">Mujer</option>
                            </select>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="addUserButton">Añadir Usuario</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit User --}}
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Información</h5>
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
                            <input id="editName" type="text" placeholder="Nombre" class="form-control{{ $errors->has('editName') ? ' is-invalid' : '' }}" name="name" value="{{ old('editName') }}" required autofocus >
                            @if ($errors->has('editName'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editName') }}</strong>
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
                                <input id="editLastName" placeholder="Apellido" type="text" class="form-control{{ $errors->has('editLastName') ? ' is-invalid' : '' }}" name="last_name" value="{{ old('editLastName') }}" required autofocus>
                                @if ($errors->has('editLastName'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('editLastName') }}</strong>
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
                            <input id="editEmail" placeholder="Correo" type="text" class="form-control{{ $errors->has('editEmail') ? ' is-invalid' : '' }}" name="email" value="{{ old('editEmail') }}" required>
                            @if ($errors->has('editEmail'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editEmail') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- User's Birthday --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="birth_date" class="mr-sm-2">Fecha de nacimiento:</label>
                            <div class="input-group">
                                <input id="editBirthDate" placeholder="Fecha de Nacimiento" type="date" class="form-control{{ $errors->has('editBirthDate') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('editBirthDate') }}" required >
                                @if ($errors->has('editBirthDate'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editBirthDate') }}</strong>
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
                                <input id="editPhone" placeholder="Teléfono" type="number" class="form-control{{ $errors->has('editPhone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('editPhone') }}" required >
                                @if ($errors->has('editPhone'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('editPhone') }}</strong>
                                </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="editUserButton">Editar Usuario</button>
            </div>
        </div>
    </div>
</div>

{{-- Add, Delete & Edit User Scripts --}}
<script>
    $(document).ready(function (){
        var user_id = null;
        var name = null;
        var last_name = null;
        var email = null;
        var password = null;
        var birth_date = null;
        var phone = null;
        var gender = null;

        // myid mynclasses myprice mydescription myexpiration mytype mystatus
        // product_id n_classes price description expiration_days type status

        //OnClick Add User Button
        $('#addUserButton').on('click', function(event) {
            event.preventDefault();
            addUser();
            $('#addUserButton').attr('disabled', true);
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
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            // Load the Inputs with the respective information
            var modal = $(this)
            modal.find('.modal-body #editName').val(name)
            modal.find('.modal-body #editLastName').val(last_name)
            modal.find('.modal-body #editEmail').val(email)
            modal.find('.modal-body #editPhone').val(phone)
            modal.find('.modal-body #editBirthDate').val(birth_date)
        })

        //Edit User Button Inside Modal
        $('#editUserButton').on('click', function(){
            $('#editUserButton').prop("disabled", true)
            event.preventDefault();

            nClasses = $('#editnclassesUser').val(); // Extract info from data-* attributes
            price = $('#editPriceUser').val();
            description = $('#editDescriptionUser').val();
            expiration_days = $('#editExpirationUser').val();
            type = $('#editTypeUser').val();
            status = $('#editStatusUser').val();

            editUser(product_id);
        })

        function addUser(){
            nClasses = $('#nclassesUser').val()
            price = $('#priceUser').val()
            description = $('#Description').val()
            expiration_days = $('#expirationUser').val()
            type = $('#typeUser').val()
            status = 1

            $.ajax({
                url: 'addUser',
                type: 'POST',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    n_classes: nClasses,
                    price: price,
                    description: description,
                    expiration_days: expiration_days,
                    type: type,
                    status: status,
                },
                success: function(result) {
                    $.LoadingOverlay("hide");
                    if(result.status == "OK"){
                        // console.log(result.status);
                        Swal.fire({
                            title: 'Producto Añadido',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                        window.location.reload();
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

        function editUser(product_id){
            $.ajax({
                url: "editUser",
                type: 'POST',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function(){
                    $.LoadingOverlay("show");
                },
                data: {
                    product_id: product_id,
                    n_classes: nClasses,
                    price: price,
                    description: description,
                    expiration_days: expiration_days,
                    type: type,
                    status: status,
                },
                success: function(result) {
                    $.LoadingOverlay("hide");
                    if(result.status == "OK"){
                        // console.log(result.status);
                        Swal.fire({
                            title: 'Producto Editado',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                        window.location.reload();
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
                    console.log(product_id, nClasses, price, description, expiration_days, type, status);
                }
            });
        };

        function deleteUser(product_id, button){
            // product_id = $('#deleteUserButton').val();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "No se podrán revertir los camstatuss!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Eliminar Producto'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: 'deleteUser',
                        type: 'POST',
                        cache: false,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            product_id: product_id,
                        },
                        success: function(result) {
                            $.LoadingOverlay("hide");
                            if (result.status == "OK") {
                                console.log(result.status);
                                Swal.fire({
                                    title: 'Producto Eliminado',
                                    text: result.message,
                                    type: 'success',
                                    confirmButtonText: 'Aceptar'
                                })
                                window.location.reload();
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