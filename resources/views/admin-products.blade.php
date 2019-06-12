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
                <th scope="col">Cantidad de Clases</th>
                <th scope="col">Precio</th>
                <th scope="col">Descripción</th>
                <th scope="col">Vigencia</th>
                <th scope="col">Tipo</th>
                {{-- <th scope="col">Información</th> --}}
                <th scope="col">Estatus</th>
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$product->id}}</td>
                    <td>{{$product->n_classes}}</td>
                    <td>${{$product->price}}</td>
                    <td>{{$product->description}}</td>
                    <td>{{$product->expiration_days}} días</td>
                    {{-- <td>{{$product->type}}</td> --}}
                    @if ($product->type == 'Deals')
                        <td>Promoción</td>
                    @else
                        <td>Paquete</td>
                    @endif
                    {{-- <td>{{$product->status}}</td> --}}
                    @if ($product->status != "1")
                        <td>Deshabilitado</td>
                    @else
                        <td>Habilitado</td>
                    @endif
                    <td><button class="btn btn-primary btn-sm editProduct" id="editProduct-{{ $product->id }}" value="{{$product->id}}" data-myid="{{ $product->id }}" data-mynclasses="{{ $product->n_classes }}" data-myprice="{{ $product->price }}" data-mydescription="{{ $product->description }}" data-myexpiration="{{$product->expiration_days}}" data-mytype="{{ $product->type }}" data-mystatus="{{$product->status}}" data-toggle="modal" data-target="#editProductModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteProduct" id="deleteProduct-{{ $product->id }}" value="{{$product->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Productos Agregados</h2>
@endif

{{-- Modal Add Product --}}
<div class="modal fade" id="addProductModal" tabindex="-1" role="dialog" aria-labelledby="addProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addProductModalLabel">Añadir Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addProduct') }}" class="registration"> --}}
                    @csrf
                    {{-- Product's n_classes --}}
                    <div class="form-group row mb-1">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="nClasses" class="mr-sm-2">Cantidad de Clases:</label>
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
                    </div>
                    {{-- Product's Expiration --}}
                    <div class="form-group row mb-3">
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
                    {{-- Product's Type --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="typeProduct">Tipo de Producto: </label>
                            <select class="form-control" name="typeProduct" id="typeProduct">
                                <option value="Deals" class="text-center">Promoción</option>
                                <option value="Packages" class="text-center">Paquete</option>
                            </select>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's Status --}}
                    {{-- <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="status" class="mr-sm-2">Estatus</label>
                            <input id="statusProduct" placeholder="Estatus" type="text" class="form-control{{ $errors->has('statusProduct') ? ' is-invalid' : '' }}" name="statusProduct" value="{{ old('statusProduct') }}" required autofocus></input>
                            @if ($errors->has('statusProduct'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('statusProduct') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div> --}}
                {{-- </form> --}}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-success" id="addProductButton">Añadir Instructor</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Product --}}
<div class="modal fade" id="editProductModal" tabindex="-1" role="dialog" aria-labelledby="editProductModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Editar Producto</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {{-- <form method="POST" action="{{ route('addProduct') }}" class="registration"> --}}
                    @csrf
                    {{-- Product's Classes --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Cantidad de Clases:</label>
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
                    </div>
                    {{-- Product'Expiration --}}
                    <div class="form-group row mb-3">
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
                    {{-- Product's Type --}}
                    {{-- <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="name" class="mr-sm-2">Tipo de Producto:</label>
                            <input id="editTypeProduct" placeholder="Tipo de Producto" type="text" min="0" minlength="10" class="form-control{{ $errors->has('phone') ? ' is-invalid' : '' }}" name="phone" value="{{ old('phone') }}" required>
                            @if ($errors->has('phone'))
                                <span class="invalid-feedback" style="display: block !important" role="alert">
                                    <strong>{{ $errors->first('phone') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div> --}}

                    {{-- Product's Type v2.0 --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="editTypeProduct">Tipo de Producto: </label>
                            <select class="form-control" name="editTypeProduct" id="editTypeProduct">
                                <option value="Deals" class="text-center">Promoción</option>
                                <option value="Packages" class="text-center">Paquetes</option>
                            </select>
                        </div>
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                    </div>

                    {{-- Product's Status --}}
                    {{-- TODO: Fix the Status Selector to show the correct type --}}
                    <div class="form-group row mb-3">
                        <div class="col-1 col-xs-1 col-sm-1 col-md-2"></div>
                        <div class="col-10 col-xs-10 col-sm-10 col-md-8 mx-auto">
                            <label for="statusProduct" class="mr-sm-2">Estatus</label>
                            <select class="form-control" name="statusProduct" id="editStatusProduct">
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
                <button type="button" class="btn btn-success" id="editProductButton">Editar Producto</button>
            </div>
        </div>
    </div>
</div>

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

        //OnClick Edit Product Button
        $('.editProduct').on('click', function (){
            // $(this).prop('disabled', true);
            event.preventDefault();

            //Get Full ID of the button (which contains the instructor ID)
            var fullId = this.id;
            //Split the ID of the fullId by his dash
            var splitedId = fullId.split("-");
            if(splitedId.length > 1){
                // console.log(splitedId);
                var instructorId = splitedId[1];
                // editProduct(instructorId, this);
            } else {
                $(this).prop("disabled", false)
                console.log("Malformed ID")
            }
            })

        //OnClick editProductModal Button

        //When Edit Product Modal Opened...
        $('#editProductModal').on('show.bs.modal', function (event) {
            // Button that triggered the modal
            var button = $(event.relatedTarget)
            // Extract info from data-* attributes
            product_id = button.data('myid')
            nClasses = button.data('mynclasses') // Extract info from data-* attributes
            price = button.data('myprice');
            description = button.data('mydescription');
            expiration_days = button.data('myexpiration');
            type = button.data('mytype');
            status = button.data('mystatus');
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.

            // Load the Inputs with the respective information
            var modal = $(this)
            modal.find('.modal-body #editnclassesProduct').val(nClasses)
            modal.find('.modal-body #editPriceProduct').val(price)
            modal.find('.modal-body #editDescriptionProduct').val(description)
            modal.find('.modal-body #editExpirationProduct').val(expiration_days)
            modal.find('.modal-body #editTypeProduct').val(type)
            modal.find('.modal-body #editStatusProduct').val(status)
        })

        //Edit Product Button Inside Modal
        $('#editProductButton').on('click', function(){
            $('#editProductButton').prop("disabled", true)
            event.preventDefault();

            nClasses = $('#editnclassesProduct').val(); // Extract info from data-* attributes
            price = $('#editPriceProduct').val();
            description = $('#editDescriptionProduct').val();
            expiration_days = $('#editExpirationProduct').val();
            type = $('#editTypeProduct').val();
            status = $('#editStatusProduct').val();

            editProduct(product_id);
        })

        function addProduct(){
            nClasses = $('#nclassesProduct').val()
            price = $('#priceProduct').val()
            description = $('#Description').val()
            expiration_days = $('#expirationProduct').val()
            type = $('#typeProduct').val()
            status = 1

            $.ajax({
                url: 'addProduct',
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

        function editProduct(product_id){
            $.ajax({
                url: "editProduct",
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

        function deleteProduct(product_id, button){
            // product_id = $('#deleteProductButton').val();
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
                        url: 'deleteProduct',
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