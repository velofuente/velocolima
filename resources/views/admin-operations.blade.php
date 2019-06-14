{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3>Operaciones</h3>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" data-toggle="modal" data-target="#addProductModal">Añadir Producto</button>
</div>

@foreach ($schedules as $schedule)
    @if ($schedule->day != date('Y-m-d'))
        <ul class="list-group mb-4">
            <li class="list-group-item" style="width: 40%;">{{$schedule->day}}</li>
        </ul>
    @else
        <h4 class="text-left">No hay horarios creados el día de hoy</h4>
    @endif
@endforeach

{{-- Table  --}}
@if (count($schedules) > 0)
    <table class="table table-striped table-hover">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Día</th>
                <th scope="col">Hora</th>
                <th scope="col">Límite de Reservación</th>
                <th scope="col">Instructor</th>
                <th scope="col">Sucursal</th>
                {{-- <th scope="col">Información</th> --}}
                <th scope="col" colspan="2" class="text-center">Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($schedules as $schedule)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$schedule->id}}</th> --}}
                    <td>{{$schedule->id}}</td>
                    <td>{{$schedule->day}}</td>
                    <td>{{$schedule->hour}}</td>
                    <td>${{$schedule->reservation_limit}}</td>
                    <td>{{$schedule->instructor->name}}</td>
                    <td>{{$schedule->branch->name}}</td>
                    {{-- <td>{{$schedule->type}}</td> --}}
                    {{-- <td>{{$schedule->status}}</td> --}}
                    <td><button class="btn btn-primary btn-sm editProduct" id="editProduct-{{ $schedule->id }}" value="{{$schedule->id}}" data-myid="{{ $schedule->id }}" data-myday="{{ $schedule->day }}" data-toggle="modal" data-target="#editProductModal">Editar</button></td>
                    <td><button class="btn btn-danger btn-sm deleteProduct" id="deleteProduct-{{ $schedule->id }}" value="{{$schedule->id}}">Eliminar</button></td>
                </tr>
            @endforeach
        </tbody>
    </table>
@else
    <h2 class="text-center">No hay Productos Agregados</h2>
@endif

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
                text: "No se podrán revertir los cambios!",
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