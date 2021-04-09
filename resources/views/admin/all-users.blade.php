@extends('admin.layouts.main')

@section('content')
<style>
    th, td {
        /* width: 100px; */
        /* word-wrap: break-word; */
        text-align: center;
    }

    /* table.dataTable.dataTable_width_auto {
        width: auto;
    } */
    
    .botn{
        margin-right: 10px;
    }
</style>
    {{-- Table with the Info --}}
    <div class="row text-center mx-0 py-4">
        <h3>Clientes</h3>
        {{-- <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addUserModal">Añadir Cliente</button> --}}
    </div>
    {{-- <div id="pager" class="px-2">
        <ul id="pagination" class="pagination-sm"></ul>
    </div> --}}
        {{-- <input type="text" class="form-control my-2" id="formulario" placeholder="..." name="buscar"> --}}
        {{-- <input class="form-control my-2" list="datalistOptions" id="formulario" placeholder="Buscar..."> --}}
        {{-- <button class="btn btn-info mb-2" id="boton" type="submit">Buscar</button> --}}
        {{-- <datalist id="datalistOptions">
            @foreach ($users as $user)
                <option value="{{ $user->name." ".$user->last_name }}">
            @endforeach
        </datalist> --}}
   
    {{-- Table  --}}
    {{-- @if (count($users) > 0) --}}
            <table id="customersTable" class="table table-striped table-hover">
            {{-- <thead style="font-size: 1em;"> --}}
            <thead>
                {{-- <tr style="font-size: 1em;"> --}}
                <tr>
                    {{-- <th scope="col">ID</th> --}}
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Apellidos</th>
                    <th scope="col">Correo</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Acción</th>
                    {{-- <th>&nbsp</th> --}}
                </tr>
            </thead>
            {{-- <tbody>
                @foreach ($users as $user)
                    <tr style="font-size: 0.9em;">
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->last_name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td><button class="btn btn-primary btn-sm editUser" id="editUser-{{ $user->id }}" value="{{$user->id}}" data-myid="{{ $user->id }}" data-myname="{{ $user->name }}" data-mylastname="{{ $user->last_name }}" data-myemail="{{$user->email}}" data-mybirthdate="{{ $user->birth_date }}" data-myphone="{{$user->phone}}" data-mygender="{{$user->gender}}" data-mypass="{{ $user->password }}" data-toggle="modal" data-target="#editUserModal">Editar</button></td>
                        <td><button class="btn btn-danger btn-sm deleteUser" id="deleteUser-{{ $user->id }}" value="{{ $user->id }}">Eliminar</button></td>
                    </tr>
                @endforeach
            </tbody> --}}
        </table>
        {{-- Para mostrar la paginación de láravel --}}
        {{-- {{ $users->links() }} --}}
    {{-- @else
        <h2 class="text-center">No hay usuarios registrados</h2>
    @endif --}}

    {{-- <table id="customersTable" class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Nombre</th>
                <th scope="col">Apellidos</th>
                <th scope="col">Correo</th>
                <th scope="col">Teléfono</th>
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody id="emp_body"> --}}
            {{-- <tr style="font-size: 0.9em;"> --}}
            {{-- Aquí se inserta el código obtenido de javascript --}}
        {{-- </tbody>
    </table> --}}

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
                            <label for="last_name" class="mr-sm-2">Apellidos:</label>
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

                    {{-- User's Password --}}
                    <div class="form-group row mb-3">                        
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div> 
                        <div class="row">
                            ¿Desea cambiar su contraseña? 
                            <div class="col">
                                <div class="form-check">                            
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault1" value="1">
                                    <label class="form-check-label" for="flexRadioDefault">
                                      Sí
                                    </label>
                                  </div>
                            </div>
                            <div class="col">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="flexRadioDefault" id="flexRadioDefault2" value="2" checked>
                                    <label class="form-check-label" for="flexRadioDefault">
                                      No
                                    </label>
                                  </div>
                            </div>
                          </div>
                          <div class="col pass" id="showInputs1">
                            <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                                <label for="pass" class="mr-sm-2">Escriba su nueva contraseña:</label>
                                <input id="editUserPassword" placeholder="" type="password" class="form-control{{ $errors->has('editUserPassword') ? ' is-invalid' : '' }}" name="pass">                                

                                <label for="pass" class="mr-sm-2">Confirme su nueva contraseña:</label>
                                <input id="editUserPassword2" placeholder="" type="password" class="form-control{{ $errors->has('editUserPassword2') ? ' is-invalid' : '' }}" name="pass">                                
                                {{-- Validar si la pass ingresada es la pass correcta --}}
                                <span id="mensaje_error"></span>
                                @if ($errors->has('editUserPassword2'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('editUserPassword2') }}</strong>
                                    </span>
                                @endif
                            </div>
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
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-success" id="editUserButton">Editar usuario</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        //mando el objeto users a la sección de extra_scripts abajo
        var users = '{!! json_encode($users) !!}';  

    </script>
@endsection

@section('extra_scripts')
  {{-- Add, Delete & Edit User Scripts --}}
    <script> 
        $("#all-users").children().addClass('active');

        //obtengo el objeto de todos los clientes
        var clientes = JSON.parse(users);
        // console.log(typeof clientes);
        // console.log(clientes);

        //Guarda función para borrar usuario
        var deleteUser;

$(document).ready(function (){  
            //DataTables
            $('#customersTable').DataTable({
                responsive: false,
                autoWidth: false,
                "language": {
                    "processing": "Procesando...",
                    // "lengthMenu": "Mostrar _MENU_ usuarios por página",
                    "lengthMenu": "Mostrar " + 
                            `<select class="custom-select custom-select-sm from-control form-control-sm">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                                <option value="-1">Todos</option>
                            </select>` 
                            + " usuarios por página",
                    "zeroRecords": "No hay usuarios registrados",
                    "info": "Página _PAGE_ de _PAGES_",
                    "infoEmpty": "No hay registros que coincidan con su búsqueda",
                    "infoFiltered": "(Total de registros: _MAX_)",
                    "search": "Buscar:",
                    "loadingRecords": "Cargando...",
                    "paginate": {
                        "next": "Siguiente",
                        "previous": "Anterior"
                    }
                },
                "ajax": "{{ route('datatable.users') }}",
                processing: true,
                serverSide: true,
                // "deferRender": true,
                // searchDelay: 350,
                "columns": [
                    { data: 'id' },
                    { data: 'name' },
                    { data: 'last_name' },
                    { data: 'email' },
                    { data: 'phone' },
                    { data: '' }
                ],
                'columnDefs': [
                    {
                        'targets': -1,
                        'defaultContent': '-',
                        'searchable': false,
                        'orderable': false,
                        'width': '100%',
                        'render': function (data, type, full_row, meta){
                            return '<div class="btn-group">' +
                                        '<button type="button" class="btn btn-primary btn-sm editUser botn" id="editUser-' + full_row.id + '" value="' + full_row.id + '" data-myid="' + full_row.id + '" data-myname="' + full_row.name + '" data-mylastname="' + full_row.last_name + '" data-myemail="' + full_row.email + '" data-mybirthdate="' + full_row.birth_date + '" data-myphone="' + full_row.phone + '" data-mygender="' + full_row.gender + '" data-mypass="' + full_row.password + '" data-toggle="modal" data-target="#editUserModal">Editar</button>' +
                                        // '<button onclick="deleteUser(this, ' + full_row.id + ')" type="button" class="btn btn-danger btn-sm botn" id="deleteUser-' + full_row.id + '" value="' + full_row.id + '">Eliminar</button>' +
                                    '</div>'; 
                        }

                    }
                ]

            });
            // =============================================
            // Opción #1
            // Call datatables, and return the API to the variable for use in our code
            // Binds datatables to all elements with a class of datatable
            var dtable = $("#customersTable").dataTable().api();            
            
            // // Grab the datatables input box and alter how it is bound to events
            $(".dataTables_filter input")
                .unbind() // Unbind previous default bindings
                .bind("input", function(e) { // Bind our desired behavior
                    // If the length is 3 or more characters, or the user pressed ENTER, search
                    if(this.value.length >= 3 || e.keyCode == 13) {
                    //if(e.keyCode == 13) {
                        // Call the API search function
                        dtable.search(this.value).draw();
                    }
                    // Ensure we clear the search if they backspace far enough
                    if(this.value == "") {
                        dtable.search("").draw();
                    }
                    return;
                });

            // =============================================
            // Opción #2
            //Para evitar que se tarde tanto en procesar las búsquedas 
            // var tableId = $('#customersTable').attr('id');
            
            // function debounceSearch(tableId) {
            //     var $searchBox = $(tableId + "_filter input[type='search']");
            //     $searchBox.off();
            
            //     var searchDebouncedFn = _.debounce(function() {
            //         $(tableId).DataTable().search($searchBox.val()).draw();
            //     }, 80); //milisegundos
            
            //     $searchBox.on("keyup", searchDebouncedFn);
            // }
            // ============================================

            //const formulario = document.querySelector('#formulario');
            //const boton = document.querySelector('#boton');
            //const resultado = document.querySelector('#customersTable tbody');

            //const filtrar = ()=>{
                //console.log(table.value);
                //resultado.innerHTML = '';

            //     const texto = formulario.value.toLowerCase();
            //     for(let cliente of clientes){
            //         let nombre = cliente.name.toLowerCase();
            //         if(nombre.indexOf(texto) !== -1){
            //         resultado.innerHTML += `
            //         <tr style="font-size: 0.9em;">
            //             <td>${cliente.id}</td>
            //             <td>${cliente.name}</td>
            //             <td>${cliente.last_name}</td>
            //             <td>${cliente.email}</td>
            //             <td>${cliente.phone}</td>
            //             <td><button class="btn btn-primary btn-sm editUser" id="editUser-${cliente.id}" value="${cliente.id}" data-myid="${cliente.id}" data-myname="${cliente.name}" data-mylastname="${cliente.last_name}" data-myemail="${cliente.email}" data-mybirthdate="${cliente.birth_date}" data-myphone="${cliente.phone}" data-mygender="${cliente.gender}" data-mypass="${cliente.password}" data-toggle="modal" data-target="#editUserModal">Editar</button></td>
            //             <td><button class="btn btn-danger btn-sm deleteUser" id="deleteUser-${cliente.id}" value="${cliente.id}">Eliminar</button></td>
            //         </tr>
            //         `
            //         }
            //     }  
            //     if(resultado.innerHTML === ''){
            //         customersTable.innerHTML = `
            //         <p class="text-center" style="font-size: 1.5em;">Cliente no encontrado...</p>
            //         `
            //     }
            // }
            
            //boton.addEventListener('click', filtrar);
            //formulario.addEventListener('keyup', filtrar);
            //filtrar();
            
            //-------------------------------------------
            // Control de la paginación
            //--------------------------------------------
            // var $pagination = $('#pagination'),
            //     totalRecords = 0,
            //     records = [],
            //     displayRecords = [],
                // recPerPage = 6, //controla el número de registros a mostrar por página
                // page = 1,
                // totalPages = 0;
                // //==============
                // records = clientes;
                // console.log(records);
                // totalRecords = records.length;
                // totalPages = Math.ceil(totalRecords / recPerPage);
                // apply_pagination();
                //===============
                // $.ajax({
                //     url: "http://dummy.restapiexample.com/api/v1/employees",
                //     async: true,
                //     dataType: 'json',
                //     success: function (data) {
                //                 records = data;
                //                 console.log(records);
                //                 totalRecords = records.length;
                //                 totalPages = Math.ceil(totalRecords / recPerPage);
                //                 apply_pagination();
                //     }
                // });

            //     function generate_table() {
            //     var tr;
            //     $('#emp_body').html('');                
            //     for (var i = 0; i < displayRecords.length; i++) {
            //             tr = $('<tr/>');
            //             tr.append("<td>" + displayRecords[i].id + "</td>");
            //             tr.append("<td>" + displayRecords[i].name + "</td>");
            //             tr.append("<td>" + displayRecords[i].last_name + "</td>");
            //             tr.append("<td>" + displayRecords[i].email + "</td>");
            //             tr.append("<td>" + displayRecords[i].phone + "</td>");
            //             tr.append("<td>" + `<button class="btn btn-primary btn-sm editUser" id="editUser-${displayRecords[i].id}" value="${displayRecords[i].id}" data-myid="${displayRecords[i].id}" data-myname="${displayRecords[i].name}" data-mylastname="${displayRecords[i].last_name}" data-myemail="${displayRecords[i].email}" data-mybirthdate="${displayRecords[i].birth_date}" data-myphone="${displayRecords[i].phone}" data-mygender="${displayRecords[i].gender}" data-mypass="${displayRecords[i].password}" data-toggle="modal" data-target="#editUserModal">Editar</button>` + "</td>");
            //             tr.append("<td>" + `<button class="btn btn-danger btn-sm deleteUser" id="deleteUser-${displayRecords[i].id}" value="${displayRecords[i].id}">Eliminar</button>` + "</td>");
            //             $('#emp_body').append(tr);
            //     }
            // }

        //     function apply_pagination() {
        //     $pagination.twbsPagination({
        //             totalPages: totalPages,
        //             visiblePages: 15, //links visibles de la paginación
        //             onPageClick: function (event, page) {
        //                 displayRecordsIndex = Math.max(page - 1, 0) * recPerPage;
        //                 endRec = (displayRecordsIndex) + recPerPage;
                        
        //                 displayRecords = records.slice(displayRecordsIndex, endRec);
        //                 generate_table();
        //             }
        //     });
        // }
        //--------------------------------------------
        // Control del modal que edita al cliente. 
        // Muestra u oculta los inputs del password a editar
        $("div.pass").hide();
        $("input[name$='flexRadioDefault']").click(function() {
            var test = $(this).val();
            $("div.pass").hide();
            $("#showInputs" + test).show();
            $('#editUserPassword').prop("required", true) 
            $('#editUserPassword2').prop("required", true)

            if($(this).val() == '2'){
                $('#editUserPassword').prop("required", false) 
                $('#editUserPassword').val('');
                $('#editUserPassword2').prop("required", false)
                $('#editUserPassword2').val('');
                $('#editUserButton').prop("disabled", false)
                $('#mensaje_error').hide();
            }else{
                $('#editUserButton').prop("disabled", true)
            }
        });
        //---------------------------------------------

            var user_id = null;
            var name = null;
            var last_name = null;
            var email = null;
            var password = null;
            var password_confirm = null;
            var birth_date = null;
            var phone = null;
            var gender = null;
            var thisID = null;

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
            });

            //OnClick Delete User Button
            /* Funciona hasta la cantidad de registros mostrados por default
             en la paginación de DataTables (10 registros), en adelante ya no detecta
             el id del botón  de los demás registros. Esto sin usar ajax de DataTables */
            $('.deleteUser').on('click', function(event) {
                event.preventDefault();
                $(this).prop("disabled", true);
                //Get Full ID of the button (which contains the user ID)
                var fullId = this.id;
                //console.log(fullId);
                //Split the ID of the fullId by his dash
                var splitedId = fullId.split("-");
                if(fullId.length > 1){
                    var userId = splitedId[1];  
                    //console.log(userId);                  
                    //deleteUser(userId, this);
                    
                } else {
                    $(this).prop("disabled", false)
                    console.log("Malformed ID")
                }
            });

            //OnClick Edit User Button
            $('.editUser').on('click', function (){
                event.preventDefault();
                //Get Full ID of the button (which contains the user ID)
                var fullId = this.id;
                //Split the ID of the fullId by his dash
                var splitedId = fullId.split("-");
                if(splitedId.length > 1) {
                    var userId = splitedId[1];
                    // editUser(userId, this);
                } else {
                    $(this).prop("disabled", false)
                    console.log("Malformed ID")
                }
            });

            //OnClick editUserModal Button

            //When Edit User Modal Opened...
            $('#editUserModal').on('show.bs.modal', function (event) {
                $("div.pass").hide();
                $("#flexRadioDefault2").prop("checked", true);
                $('#editUserButton').prop("disabled", false)
                $('#editUserPassword').val('');
                $('#editUserPassword2').val('');

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
                password = button.data('mypass');
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
                //modal.find('.modal-body #editUserPassword2').val(password);

                //Evalúo si los passwords coinciden o no
                $('#mensaje_error').hide();

                var cambioDePass = function() {
                    var pass1 = $('#editUserPassword').val();
                    var pass2 = $('#editUserPassword2').val();
                    //console.log(pass1);
                    //console.log(pass2);
                    if (pass1 == pass2 &&  pass1 != '' && pass2 != '' ) {
                        $('#mensaje_error').hide();
                        $('#mensaje_error').attr("class", "control-label valid-feedback");
                        $('#mensaje_error').show();
                        $('#mensaje_error').html("&#10004;");
                        $('#editUserButton').prop("disabled", false)
                    }else if(pass1 == '' && pass2 == ''){
                        $('#mensaje_error').hide();
                    }
                    else {
                        $('#mensaje_error').attr("class", "control-label col-md-12 invalid-feedback");
                        $('#mensaje_error').html("Las contraseñas no coinciden");
                        $('#mensaje_error').show();
                        $('#editUserButton').prop("disabled", true)
                    }
                }

                $("#editUserPassword").on('keyup', cambioDePass);
                $("#editUserPassword2").on('keyup', cambioDePass);

                
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
                password = $('#editUserPassword2').val();
                
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
                        password: password,
                        birth_date: birth_date,
                        phone: phone,
                        gender: gender
                    },
                    success: function(result) {
                        $.LoadingOverlay("hide");
                        if(result.status == "OK"){
                            $('.modal-backdrop').remove();
                            $('#addUserModal').modal('hide');
                            Swal.fire({
                                title: 'Usuario Añadido',
                                text: result.message,
                                type: 'success',
                                confirmButtonText: 'Aceptar'
                            })
                            window.location.replace('/admin/all-users');
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
                        gender: gender,
                        email: email,
                        password: password,
                        birth_date: birth_date,
                        phone: phone
                    },
                    success: function(result) {
                        $.LoadingOverlay("hide");
                        if(result.status == "OK"){
                            $('.modal-backdrop').remove();
                            $('#editUserModal').modal('hide');
                            Swal.fire({
                                title: 'Usuario editado',
                                text: result.message,
                                type: 'success',
                                confirmButtonText: 'Aceptar'
                            })
                            window.location.replace('/admin/all-users');
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
                    }
                });
            };

            // function deleteUser(user_id, button){
           deleteUser = function(button, user_id){
                $(button).prop("disabled", true);
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
                                    Swal.fire({
                                        title: 'Usuario eliminado',
                                        text: result.message,
                                        type: 'success',
                                        confirmButtonText: 'Aceptar'
                                    })
                                    window.location.replace('/admin/all-users');
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
                            }
                        });
                    } else {
                        $(button).prop("disabled", false)
                    }
                })
        }
    });
    </script>
@stop