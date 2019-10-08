{{-- Search Input --}}
<div class="row text-center mx-0 py-1">
    <div class="col-md-4">
        <h3 class="text-center">Ventas</h3>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" name="searchUser" id="searchUser" placeholder="Buscar Usuario" class="form-control" />
        </div>
    </div>
    <div class="col-md-4">
        <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#registerClientModal">Añadir Cliente</button>
    </div>
</div>


{{-- User's Table --}}
<table class="table table-striped table-hover table-bordered" style="margin: 0 0">
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
            <th scope="col" colspan="2" class="text-center">Acción</th>
        </tr>
    </thead>
    <tbody>
        @include('pagination_data')
    </tbody>
</table>
<input type="hidden" name="hidden_page" id="hidden_page" value="1" />
<input type="hidden" name="hidden_column_name" id="hidden_column_name" value="id" />
<input type="hidden" name="hidden_sort_type" id="hidden_sort_type" value="asc" />

{{-- Packages Modal --}}
<div class="modal fade" id="addSaleUserModal" tabindex="-1" role="dialog" aria-labelledby="addSaleUserModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Seleccionar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                @csrf
                    <h5 class="text-center mx-auto">Promociones</h5>
                    <div class="form-group row mb-3">
                        @foreach ($products as $product)
                        {{-- <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div> --}}
                            @if ($product->price != 0 && $product->type == "Deals")
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 my-3 productList">
                                    <a href="javascript:makeSaleUser({{$product->id}})">
                                        {{$product->description}} <br />
                                        Clases: {{$product->n_classes}} <br />
                                        Precio: ${{$product->price}} <br />
                                        Vigencia: {{$product->expiration_days}} días <br />
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <h5 class="text-center mx-auto">Paquetes básicos</h5>
                    <div class="form-group row mb-3">
                        @foreach ($products as $product)
                            @if ($product->price != 0 && $product->type == "Packages")
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 my-3 productList">
                                    <a href="javascript:makeSaleUser({{$product->id}})">
                                        -Paquete- <br />
                                        Clases: {{$product->n_classes}} <br />
                                        Precio: ${{$product->price}} <br />
                                        Vigencia: {{$product->expiration_days}} días <br />
                                    </a>
                                </div>
                            @endif
                        @endforeach
                    </div>
                    <h5 class="text-center mx-auto">Mercancía</h5>
                    <div class="form-group row mb-3">
                        @foreach($products as $product)
                            @if ($product->price != 0 && $product->type == "Souvenir")
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 my-3 productList">
                                    <a href="javascript:makeSaleUser({{$product->id}})">
                                        -Mercancía-
                                        Producto: {{$product->description}} <br />
                                        Precio: ${{$product->price}} <br />
                                        Tipo: Mercancia <br />
                                    </a>
                                </div>
                            @endif
                        @endforeach
                        {{-- <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div> --}}
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
    </div>
</div>
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

{{-- Scripts Section --}}
<script>
var name = null;
var last_name = null;
var email = null;
var password = null;
var birth_date = null;
var gender = null;
var phone = null;
var shoe_size = null;

var product_id = null;
var client_id = null;
$(document).ready(function(){
    function clear_icon(){
        $('#id_icon').html('');
        $('#users_name_icon').html('');
    }

     // On Click Register New User to Schedule
     $('#registerClientButton').on('click', function(){
            register();
        });

    if ( $('[type="date"]').prop('type') != 'date' ) {
        $('[type="date"]').attr('placeholder', 'yyyy-mm-dd')
        // Use datepicker on the date inputs
        $("input[type=date]").datepicker({
            dateFormat: 'yy/mm/dd',
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
            dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
            dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            currentText: "Hoy",
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:2019',
            onSelect: function(dateText, inst) {
                $(inst).val(dateText); // Write the value in the input
            }
        });
    }

    // Fetch Data from Query
    function fetch_data(page, sort_type, sort_by, query){
        $.ajax({
            url:"/admin-sales/fetch_data?page="+page+"&sortby="+sort_by+"&sorttype="+sort_type+"&query="+query,
            success:function(data){
                $('tbody').html('');
                $('tbody').html(data);
            }
        })
    }

    // On KeyUp Search Input
    $(document).on('keyup', '#searchUser', function(){
        var query = $('#searchUser').val();
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();
        var page = $('#hidden_page').val();
        fetch_data(page, sort_type, column_name, query);
    });

    // Sort by Clicked Column
    $(document).on('click', '.sorting', function(){
        var column_name = $(this).data('column_name');
        var order_type = $(this).data('sorting_type');
        var reverse_order = '';
        if(order_type == 'asc')
            {
                $(this).data('sorting_type', 'desc');
                reverse_order = 'desc';
                clear_icon();
                $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-bottom"></span>');
            }
        if(order_type == 'desc')
        {
            $(this).data('sorting_type', 'asc');
            reverse_order = 'asc';
            clear_icon
            $('#'+column_name+'_icon').html('<span class="glyphicon glyphicon-triangle-top"></span>');
        }
        $('#hidden_column_name').val(column_name);
        $('#hidden_sort_type').val(reverse_order);
        var page = $('#hidden_page').val();
        var query = $('#searchUser').val();
        fetch_data(page, reverse_order, column_name, query);
    });

    // Pagination
    $(document).on('click', '.pagination a', function(event){
        event.preventDefault();
        var page = $(this).attr('href').split('page=')[1];
        $('#hidden_page').val(page);
        var column_name = $('#hidden_column_name').val();
        var sort_type = $('#hidden_sort_type').val();

        var query = $('#searchUser').val();

        $('li').removeClass('active');
        $(this).parent().addClass('active');
        fetch_data(page, sort_type, column_name, query);
    });
});

//Make Purchase
function makeSaleUser(id){
    product_id = id;
    Swal.fire({
        title: '¿Comprar Paquete?',
        text: "Estás a punto de realizar una compra",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, Comprar Producto'
    }).then((result) => {
        if (result.value) {
            $.ajax({
                url: 'sale',
                type: 'POST',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    product_id: product_id,
                    client_id: client_id
                },
                success: function(result) {
                    $.LoadingOverlay("hide");
                    if (result.status == "OK") {
                        $('.modal-backdrop').remove();
                        $('#reports').trigger('click');
                        $('#addSaleUserModal').modal('hide');
                        Swal.fire({
                            title: 'Producto Comprado',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                        $('body').removeClass('modal-open');
                    } else {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        });
                        $('body').removeClass('modal-open');
                        // $(button).prop("disabled", false)
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
                    $('body').removeClass('modal-open');
                    // $(button).prop("disabled", false)
                    // alert(result);
                }
            });
        }
    })
}
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