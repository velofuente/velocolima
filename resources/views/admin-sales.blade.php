{{-- Search Input --}}
<div class="row text-center mx-0 py-1">
    <div class="col-md-8">
        <h3 class="text-center">Ventas</h3>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            <input type="text" name="searchUser" id="searchUser" placeholder="Buscar Usuario" class="form-control" />
        </div>
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
            <th scope="col">Teléfono</th>
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
                        @foreach ($products as $product)
                            @if ($product->price != 0 && $product->type == "Packages")
                                <div class="col-4 col-xs-4 col-sm-4 col-md-4 my-3 productList">
                                    <a href="javascript:makeSaleUser({{$product->id}})">
                                        Clases: {{$product->n_classes}} <br />
                                        Precio: ${{$product->price}} <br />
                                        Vigencia: {{$product->expiration_days}} días <br />
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

{{-- Scripts Section --}}
<script>
var product_id = null;
var client_id = null;
$(document).ready(function(){
    function clear_icon(){
        $('#id_icon').html('');
        $('#users_name_icon').html('');
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
        confirmButtonText: 'Sí, Comprar Clases'
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
                            title: 'Clases Compradas',
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
                    // $(button).prop("disabled", false)
                    // alert(result);
                }
            });
        }
    })
}
</script>