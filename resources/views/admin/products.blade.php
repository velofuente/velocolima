@extends('admin.app')

@section('extra_styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/css/select2.min.css" rel="stylesheet"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap-theme/0.1.0-beta.10/select2-bootstrap.css" rel="stylesheet"/>
    <style>
        .pagination {
            margin: 10px auto;
            align-content: center;
        }
    </style>
@stop

@section('content')
{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Productos</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addProductModal">Añadir Producto</button>
</div>

{{-- Table  --}}
@if (count($products) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Clases</th>
                <th scope="col">Precio</th>
                <th scope="col">Descripción</th>
                <th scope="col">Vigencia</th>
                <th scope="col">Tipo</th>
                <th scope="col">Días</th>
                <th scope="col">Horario</th>
                <th scope="col">Estatus</th>
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr style="font-size: 0.9em;">
                    <td>{{$product->id}}</td>
                    <td>{{$product->n_classes}}</td>
                    <td>${{$product->price}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->expiration_days}}</td>
                    <td>{{$product->type}}</td>
                    <td>{{$product->availableDays}}</td>
                    <td>{{$product->schedules}}</td>
                    <td>{{$product->status}}</td>
                    <td><button class="btn btn-primary btn-sm editProduct" id="editProduct-{{ $product->id }}" value="{{$product->id}}" data-id="{{ $product->id }}" data-toggle="modal" data-target="#editProductModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteProduct" id="deleteProduct-{{ $product->id }}" value="{{$product->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="pagination">{{$products}}</div>
@else
    <h2 class="text-center">No hay productos agregados</h2>
@endif

{{-- Modal Add Product --}}
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Añadir producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addProduct') }}" class="registration"> --}}
                    @csrf
                      {{-- Product's Type --}}
                      <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="typeProduct">Tipo de producto: </label>
                            <select name="typeProduct" id="typeProduct">
                                <option value="Deals" class="text-center">Promoción</option>
                                <option value="Packages" class="text-center">Paquete</option>
                                <option value="Souvenir" class="text-center">Mercancía</option>
                                <option value="Free" class="text-center">Clase Gratis</option>
                            </select>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's n_classes --}}
                    <div class="form-group row mb-1" id="divClassesQuantity">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="nClasses" class="mr-sm-2">Cantidad de clases:</label>
                            <input id="nclassesProduct" type="number" placeholder="Cantidad de Clases" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- Product's Price --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="price" class="mr-sm-2">Precio:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-secondary bg-white">$</span>
                                </div>
                                <input id="priceProduct" placeholder="Precio" type="number" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price') }}" required autofocus>
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                                <div class="input-group-append">
                                    <span class="input-group-text text-secondary bg-white">MX</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                    {{-- Product's Description --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="description" class="mr-sm-2">Descripción:</label>
                            <input id="Description" placeholder="Descripción" type="text" class="form-control{{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" value="{{ old('description') }}" required>
                            @if ($errors->has('description'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('description') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <label for="descriptionInput" class="font-weight-light text-center mx-auto" style="font-size: 14px">(máximo 20 caracteres)</label>
                    </div>

                    {{-- Product's Day Availables --}}
                    <div class="form-group row mb-3" id="divClassAvailableDays">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="availableDays" class="mr-sm-2">Días disponibles:</label>
                            <div class="form-group">
                                <select name="availableDays" id="availableDays" multiple>
                                    <option value="0">Domingo</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miércoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                </select>
                                @if ($errors->has('availableDays'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('availableDays') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's schedules --}}
                    <div class="form-group row mb-3" id="divClassSchedule">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto group-inline" id="editDivClassScheduleContainer">
                            <label for="schedule" class="mr-sm-2">Horario:</label>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <select name="beginAt" id="beginAt">
                                        @php
                                            for($i=0; $i<24; $i++) {
                                                $hours = str_pad($i, 2, 0, STR_PAD_LEFT);
                                                printf("<option value='{$i}'>{$hours}:00</option>");
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <select name="endAt" id="endAt">
                                        @php
                                            for($i=0; $i<24; $i++) {
                                                $hours = str_pad($i, 2, 0, STR_PAD_LEFT);
                                                printf("<option value='{$i}'>{$hours}:00</option>");
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's Expiration --}}
                    <div class="form-group row mb-3" id="divClassesExpiration">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Vigencia:</label>
                            <div class="input-group">
                                <input id="expirationProduct" placeholder="Vigencia" type="number" class="form-control{{ $errors->has('expiration') ? ' is-invalid' : '' }}" name="expiration" value="{{ old('expiration') }}" required >
                                @if ($errors->has('expiration'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('expiration') }}</strong>
                                </span>
                                @endif
                                <div class="input-group-append">
                                    <span class="input-group-text text-secondary bg-white">días</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="addProductButton">Añadir producto</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Product --}}
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addProduct') }}" class="registration"> --}}
                    @csrf

                    {{-- Product's Type v2.0 --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="editTypeProduct" class="control-label">Tipo de prodcuto: </label>
                            <select name="editTypeProduct" id="editTypeProduct" >
                                <option value="Deals" class="text-center">Promoción</option>
                                <option value="Packages" class="text-center">Paquetes</option>
                                <option value="Souvenir" class="text-center">Mercancia</option>
                                <option value="Free" class="text-center">Clase gratis</option>
                            </select>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's Classes --}}
                    <div class="form-group row mb-3" id="editDivClassesQuantity">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Cantidad de clases:</label>
                            <input id="editnclassesProduct" data-mytitle="" type="text" placeholder="Cantidad de Clases" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ old('name') }}" required autofocus >
                            @if ($errors->has('name'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('name') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's Price --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="price" class="mr-sm-2">Precio:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text text-secondary bg-white">$</span>
                                </div>
                                <input id="editPriceProduct" placeholder="Precio" type="text" class="form-control{{ $errors->has('price') ? ' is-invalid' : '' }}" name="price" value="{{ old('price') }}" required>
                                @if ($errors->has('price'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                                <div class="input-group-append">
                                    <span class="input-group-text text-secondary bg-white">$</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's Description --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="email" class="mr-sm-2">Descripción:</label>
                            <input id="editDescriptionProduct" placeholder="Descripción" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>
                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <label for="descriptionInput" class="font-weight-light text-center mx-auto" style="font-size: 14px">(máximo 20 caracteres)</label>
                    </div>

                    {{-- Product's Day Availables --}}
                    <div class="form-group row mb-3" id="editDivClassAvailableDays">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="editAvailableDays" class="mr-sm-2">Días disponibles:</label>
                            <div class="form-group">
                                <select name="editAvailableDays" id="editAvailableDays" multiple>
                                    <option value="0">Domingo</option>
                                    <option value="1">Lunes</option>
                                    <option value="2">Martes</option>
                                    <option value="3">Miércoles</option>
                                    <option value="4">Jueves</option>
                                    <option value="5">Viernes</option>
                                    <option value="6">Sábado</option>
                                </select>
                                @if ($errors->has('availableDays'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('availableDays') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's schedules --}}
                    <div class="form-group row mb-3" id="editDivClassSchedule">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto group-inline" id="editDivClassScheduleContainer">
                            <label for="schedule" class="mr-sm-2">Horario:</label>
                            <div class="form-row">
                                <div class="form-group col-6">
                                    <select name="editBeginAt" id="editBeginAt">
                                        @php
                                            for($i=0; $i<24; $i++) {
                                                $hours = str_pad($i, 2, 0, STR_PAD_LEFT);
                                                printf("<option value='{$i}'>{$hours}:00</option>");
                                            }
                                        @endphp
                                    </select>
                                </div>
                                <div class="form-group col-6">
                                    <select name="editEndAt" id="editEndAt">
                                        @php
                                            for($i=0; $i<24; $i++) {
                                                $hours = str_pad($i, 2, 0, STR_PAD_LEFT);
                                                printf("<option value='{$i}'>{$hours}:00</option>");
                                            }
                                        @endphp
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product'Expiration --}}
                    <div class="form-group row mb-3" id="editDivClassesExpiration">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Vigencia:</label>
                            <div class="input-group">
                                <input id="editExpirationProduct" placeholder="Vigencia" type="number" class="form-control{{ $errors->has('birth_date') ? ' is-invalid' : '' }}" name="birth_date" value="{{ old('birth_date') }}" required>
                                @if ($errors->has('birth_date'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('birth_date') }}</strong>
                                </span>
                                @endif
                                <div class="input-group-append">
                                    <span class="input-group-text text-secondary bg-white">días</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's Status --}}
                    {{-- TODO: Fix the Status Selector to show the correct type --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="statusProduct" class="mr-sm-2">Estatus</label>
                            <select name="statusProduct" id="editStatusProduct">
                                <option value="1" class="text-center">Habilitado</option>
                                <option value="0" class="text-center">Deshabilitado</option>
                            </select>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="editProductButton">Editar producto</button>
            </div>
        </div>
    </div>
</div>
@stop

@section('extra_scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.12/dist/js/select2.min.js"></script>
{{-- Add, Delete & Edit Products Scripts --}}
<script>
    $(document).ready(function (){
        var product_id = null;
        var nClasses = null;
        var price = null;
        var description = null;
        var expiration_days = null;
        var type = null;
        var status = null;

        // myid mynclasses myprice mydescription myexpiration mytype mystatus
        // product_id n_classes price description expiration_days type status

        $('select:not(.swal2-select)').select2({theme: 'bootstrap'});
        // Hide Classes input & Classes expiration if Mercancía/Souvenir is selected
        $('#typeProduct').on('change', function(event) {
            if( $('#typeProduct').val() == 'Souvenir' ) {
                $('#divClassesQuantity').hide('fast');
                $('#divClassesExpiration').hide('fast');
                $('#divClassAvailableDays').hide('fast');
                $('#divClassSchedule').hide('fast');
            } else if ($('#typeProduct').val() == 'Free') {
                $('#divClassAvailableDays').hide('fast');
                $('#divClassSchedule').hide('fast');
            } else {
                $('#divClassesQuantity').show('fast');
                $('#divClassesExpiration').show('fast');
                $('#divClassAvailableDays').show('fast');
                $('#divClassSchedule').show('fast');
            }
        });

        //OnClick Add Product Button
        $('#addProductButton').on('click', function(event) {
            event.preventDefault();
            addProduct();
            $('#addProductButton').attr('disabled', true);
        })

        //OnClick Delete Product Button
        $('.deleteProduct').on('click', function(event) {
            $(this).prop("disabled", true)
            event.preventDefault();

            //Get Full ID of the button (which contains the instructor ID)
            var fullId = this.id;
            //Split the ID of the fullId by his dash
            var splitedId = fullId.split("-");
            if(splitedId.length > 1){
                // console.log(splitedId);
                var instructorId = splitedId[1];
                deleteProduct(instructorId, this);
            } else {
                $(this).prop("disabled", false)
                console.log("Malformed ID")
            }
            // $('#deleteProductButton').attr('disabled', true);
        })

        // Edit Product Button Inside Modal
        $('#editProductButton').on('click', function(){
            $('#editProductButton').prop("disabled", true)
            event.preventDefault();

            nClasses = $('#editnclassesProduct').val(); // Extract info from data-* attributes
            price = $('#editPriceProduct').val();
            description = $('#editDescriptionProduct').val();
            expiration_days = $('#editExpirationProduct').val();
            type = $('#editTypeProduct').val();
            status = $('#editStatusProduct').val();
            available_days = $('#editAvailableDays').val();
            begin_at = $('#editBeginAt').val();
            end_at = $('#editEndAt').val();
            var button = $(this);

            editProduct(productId, button);
        })

        function addProduct(){
            nClasses = $('#nclassesProduct').val()
            price = $('#priceProduct').val()
            description = $('#Description').val()
            expiration_days = $('#expirationProduct').val()
            type = $('#typeProduct').val()
            available_days = $('#availableDays').val();
            beginAt = $('#beginAt').val();
            endAt = $('#endAt').val();
            status = 1

            $.ajax({
                url: '/addProduct',
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
                    available_days: available_days,
                    begin_at: beginAt,
                    end_at: endAt,
                },
                success: function(result) {
                    $.LoadingOverlay("hide");
                    if(result.status == "OK"){
                        $('.modal-backdrop').remove();
                        $('select:not(.swal2-select)').select2({theme: 'bootstrap'});
                        $('#addProductModal').modal('hide');
                        Swal.fire({
                            title: 'Producto añadido',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                    $('body').removeClass('modal-open');
                    window.location.replace('/admin/products');
                    }
                    else {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                        $('body').removeClass('modal-open');
                    }
                },
                error: function(result) {
                    $.LoadingOverlay("hide");
                }
            });
        }

        function editProduct(product_id, button){
            $.ajax({
                url: "/editProduct",
                type: 'POST',
                cache: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                beforeSend: function() {
                    $.LoadingOverlay("show");
                },
                data: {
                    product_id: productId,
                    n_classes: nClasses,
                    price: price,
                    description: description,
                    expiration_days: expiration_days,
                    type: type,
                    status: status,
                    available_days: available_days,
                    begin_at: begin_at,
                    end_at: end_at,
                },
                success: function(result) {
                    $.LoadingOverlay("hide");
                    if(result.status == "OK"){
                        $('.modal-backdrop').remove();
                        // $('.active-menu').trigger('click');
                        $('#editProductModal').modal('hide');
                        Swal.fire({
                            title: 'Producto Editado',
                            text: result.message,
                            type: 'success',
                            confirmButtonText: 'Aceptar'
                        })
                        $('body').removeClass('modal-open');
                        window.location.replace('/admin/products');
                    }
                    else {
                        $.LoadingOverlay("hide");
                        Swal.fire({
                            title: 'Error',
                            text: result.message,
                            type: 'warning',
                            confirmButtonText: 'Aceptar'
                        })
                        $('body').removeClass('modal-open');
                        $(button).prop('disabled', false);
                    }
                },
                complete: function() {
                    $('select:not(.swal2-select)').select2({theme: 'bootstrap'});
                },
                error: function(result) {
                    $.LoadingOverlay("hide");
                    Swal.fire({
                        title: 'Error',
                        type: 'error',
                        text: 'Ha ocurrido un error al procesar la petición.',
                        confirmButtonText: 'Aceptar',
                    });
                    $('select:not(.swal2-select)').select2({theme: 'bootstrap'});
                    $(button).prop('disabled', false);
                },
            });
        };

        function deleteProduct(product_id, button){
            // product_id = $('#deleteProductButton').val();
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¡No se podrán revertir los cambios!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, Eliminar Producto'
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: '/deleteProduct',
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
                                $('.modal-backdrop').remove();
                                // $('.active-menu').trigger('click');
                                Swal.fire({
                                    title: 'Producto Eliminado',
                                    text: result.message,
                                    type: 'success',
                                    confirmButtonText: 'Aceptar'
                                })
                                window.location.replace('/admin/products');
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
                        error: function(result) {
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
    })

    $('.editProduct').on('click', function (event) {
        event.preventDefault();
        event.stopPropagation();

        storeProduct($(this));
    });

    function storeProduct(element) {
        productId = element.data('id');
        url = '/products/'+productId;

        formData = new FormData;
        formData.append('product_id', productId);

        ajaxCall(url, formData, 'GET', '.editProduct', function (response) {
            if (response.status === 'OK') {
                loadEditProductModal(response.data.product);
            }
        });
    }

    function loadEditProductModal(data) {
        schedules = null;
        daysAvailables = null;

        type = data.type;
        price = data.price;
        productId = data.id;
        status = data.status;
        nClasses = data.n_classes;
        description = data.description;
        expirationDays = data.expiration_days;
        productSchedules = data.product_schedule;

        clearEditForm();
        clearScheduleForm();

        if (productSchedules) {
            daysAvailables = productSchedules.available_days.split(",");
            schedules = productSchedules.schedules.split(';');
        }

        $('#editPriceProduct').val(price);
        $('#editStatusProduct').val(status);
        $('#editnclassesProduct').val(nClasses);
        $('#editDescriptionProduct').val(description);
        $('#editExpirationProduct').val(expirationDays);

        if (type === 'Souvenir' || nClasses === '' && expirationDays === '') {
            $('#editDivClassSchedule').hide();
            $('#editDivClassesQuantity').hide();
            $('#editDivClassesExpiration').hide();
            $('#editDivClassAvailableDays').hide();
            drawSelectType('Souvenir');
        } else if (type === 'Free') {
            drawSelectType(type);
            $('#editDivClassAvailableDays').hide();
            $('#editDivClassSchedule').hide();
        } else {
            drawSelectType(type);
            $('#editDivClassSchedule').show();
            $('#editDivClassesQuantity').show();
            $('#editDivClassesExpiration').show();
            $('#editDivClassAvailableDays').show();

            if (daysAvailables || schedules) {
                loadSchedulesForm(daysAvailables, schedules);
            }
        }

        $('#editTypeProduct > option').each(function (key, element) {
            if (element.getAttribute('value') == type) {
                    $(element).prop('selected', true);
            } else {
                element.removeAttribute('selected');
            }
        });
        $('select:not(.swal2-select)').select2({theme: 'bootstrap'});
        $('#editProductModal').modal();
    }

    function drawSelectType(type) {
        $('#editTypeProduct > option').remove();
        var options = "";
        if (type != "Souvenir") {
            options += '<option value="Deals" class="text-center">Promoción</option>';
            options += '<option value="Packages" class="text-center">Paquetes</option>';
            options += '<option value="Free" class="text-center">Clase gratis</option>';
        } else {
            options += '<option value="Souvenir" class="text-center">Mercancia</option>';
        }
        $('#editTypeProduct').append(options);
    }

    function loadSchedulesForm(daysAvailables, schedules) {
        var isFirstSchedule = true;

        $('#editAvailableDays > option').each(function (key, element) {
            if (daysAvailables.includes(element.getAttribute('value'))) {
                $(element).prop('selected', true);
            }
        });

        schedules.forEach(function (schedule, scheduleKey) {
            schedule = schedule.split('-');
            if (isFirstSchedule) {
                $('#editDivClassSchedule #editBeginAt > option').each(function (key, element) {

                    if (schedule[0] == element.getAttribute('value')) {
                        $(element).prop('selected', true);
                    }
                });
                $('#editDivClassSchedule #editEndAt > option').each(function (key, element) {
                    if (schedule[1] === element.getAttribute('value')) {
                        $(element).prop('selected', true);
                    }
                });
                isFirstSchedule = false;
            } else {
                options = "<div class='input-group'>"
                options += "<select class='' name='editBeginAt"+scheduleKey+"' id='editBeginAt"+scheduleKey+"'>";
                for(i = 0; i < 24; i++) {
                    if (schedule[0] == i) {
                        options += "<option value='"+i+"' selected>"+('0'+i).slice(-2)+":00</option>";
                    } else {
                        options += "<option value='"+i+"'>"+('0'+i).slice(-2)+":00</option>";
                    }
                }
                options += "</select>";
                options += "<select class='' name='editEndAt"+scheduleKey+"' id='editEndAt"+scheduleKey+"'>";
                for(i = 0; i < 24; i++) {
                    if (schedule[1] == i) {
                        options += "<option value='"+i+"' selected>"+('0'+i).slice(-2)+":00</option>";
                    } else {
                        options += "<option value='"+i+"'>"+('0'+i).slice(-2)+":00</option>";
                    }
                }
                options += "</select>";
                options += "</div>";
                $("#editDivClassSchedule > #editDivClassScheduleContainer").append(options);
            }
        });
    }

    function clearScheduleForm() {
        $('#editAvailableDays > option').each(function (key, element) {
            element.removeAttribute('selected');
        });

        $('#editDivClassSchedule #editBeginAt > option').each(function (key, element) {
            element.removeAttribute('selected');
        });
        $('#editDivClassSchedule #editEndAt > option').each(function (key, element) {
            element.removeAttribute('selected');
        });
    }

    function clearEditForm() {
        $('#editTypeProduct').val(null);
        $('#editPriceProduct').val(null);
        $('#editStatusProduct').val(null);
        $('#editnclassesProduct').val(null);
        $('#editExpirationProduct').val(null);
        $('#editDescriptionProduct').val(null);
        $('#editDivClassSchedule').val(null);
        $('#editDivClassesQuantity').val(null);
        $('#editDivClassesExpiration').val(null);
        $('#editDivClassAvailableDays').val(null);
    }

    function ajaxCall(url, formData, method, disabledButton, callBack) {
        $.ajax({
            url: url,
            method: method,
            accepts: 'application/json',
            data: formData,
            cache: false,
            enctype: 'multipart/form-data',
            processData: false,
            contentType: false,
            beforeSend: function() {
                $.LoadingOverlay("show");
                if(disabledButton) {
                    $(disabledButton).addClass('disabled');
                }
            },
            success: callBack,
            error: function(header) {
                //TODO: Mostrar toast de error
                $('select:not(.swal2-select)').select2({theme: 'bootstrap'});
            },
            complete: function() {
                $('select:not(.swal2-select)').select2({theme: 'bootstrap'});
                if (disabledButton) {
                    $(disabledButton).removeClass('disabled');
                }
                $.LoadingOverlay("hide");
            }
        });
    }
</script>

{{-- Validate input number to only allow numbers --}}
<script>
    // Select all input number on Add Modal.
    var classesNumber = document.getElementById('nclassesProduct');
    var priceNumber = document.getElementById('priceProduct');
    var expirationNumber = document.getElementById('expirationProduct');
    // Select all input number on Edit Modal
    var editClassesNumber = document.getElementById('editnclassesProduct');
    var editPriceNumber = document.getElementById('editPriceProduct');
    var editExpirationNumber = document.getElementById('editExpirationProduct');
    // Lock the input only to numbers.
    classesNumber.onkeydown = function validateNumberInput(event) {
        if(!((event.keyCode > 95 && event.keyCode < 106)
        || (event.keyCode > 47 && event.keyCode < 58)
        || event.keyCode == 8 || event.keyCode == 9)) {
            return false;
        }
    }
    priceNumber.onkeydown = function validateNumberInput(event) {
        if(!((event.keyCode > 95 && event.keyCode < 106)
        || (event.keyCode > 47 && event.keyCode < 58)
        || event.keyCode == 8 || event.keyCode == 9)) {
            return false;
        }
    }
    expirationNumber.onkeydown = function validateNumberInput(event) {
        if(!((event.keyCode > 95 && event.keyCode < 106)
        || (event.keyCode > 47 && event.keyCode < 58)
        || event.keyCode == 8 || event.keyCode == 9)) {
            return false;
        }
    }
    editClassesNumber.onkeydown = function validateNumberInput(event) {
        if(!((event.keyCode > 95 && event.keyCode < 106)
        || (event.keyCode > 47 && event.keyCode < 58)
        || event.keyCode == 8 || event.keyCode == 9)) {
            return false;
        }
    }
    editPriceNumber.onkeydown = function validateNumberInput(event) {
        if(!((event.keyCode > 95 && event.keyCode < 106)
        || (event.keyCode > 47 && event.keyCode < 58)
        || event.keyCode == 8 || event.keyCode == 9)) {
            return false;
        }
    }
    editExpirationNumber.onkeydown = function validateNumberInput(event) {
        if(!((event.keyCode > 95 && event.keyCode < 106)
        || (event.keyCode > 47 && event.keyCode < 58)
        || event.keyCode == 8 || event.keyCode == 9)) {
            return false;
        }
    }
</script>
@stop