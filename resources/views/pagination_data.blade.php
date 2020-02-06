@foreach($data as $row)
    <tr>
        <td class='userRow' id='{{$row->id}}'>{{ $row->id}}</td>
        <td class='userRow' id='{{$row->id}}'>{{ $row->name }}</td>
        <td class='userRow' id='{{$row->id}}'>{{ $row->last_name }}</td>
        <td class='userRow' id='{{$row->id}}'>{{ $row->email }}</td>
        <td class='userRow' id='{{$row->id}}'>{{ $row->birth_date }}</td>
        <td class='userRow' id='{{$row->id}}'>{{ $row->phone }}</td>
        <td class='userRow' id='{{$row->id}}'>{{ $row->shoe_size }}</td>
        <td class='userRow' id='{{$row->id}}'>{{ ($row->availableClasses->clases) ? $row->availableClasses->clases : 'N/D' }}</td>
        <td class='userRow' id='{{$row->id}}'>{{ ($row->bookedClasses) ? $row->bookedClasses : 'N/D' }}</td>
        <td><button class="btn btn-success btn-sm salesUser" id="salesUser-{{ $row->id }}" value="{{$row->id}}" data-toggle="modal" data-target="#addSaleUserModal">Venta</button></td>
    </tr>
@endforeach
<tr>
    <td colspan="6">
        {!! $data->links() !!}
    </td>
</tr>
<script>
    var user_id = null;
    // var pagination_lastPage = "{{ $data->lastPage() }}";
    // var pagination_nextPage = "{{ $data->nextPageUrl() }}";
    // var pagination_prevPage = "{{ $data->previousPageUrl() }}";
    // var pagination_firstPage = "{{ $data->url(1) }}";
    $(document).ready(function (){
        //getuserinfo click
        $('.userRow').on('click', function(event) {
            console.log("clicked a row");
            var user_id = this.id;
            console.log(user_id);
            getUserInfoReports(user_id);
        });
    });
</script>
<script>
    function getUserInfoReports(user_id){
        $.ajax({
            url: "getUserInfoReports",
            method: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                user_id: user_id,
            },
            success: function(result){
                var purchases_table = "";
                purchases_table += "<table class='table'>"+
                "<thead>"+
                    "<tr>"+
                        "<th>Fecha de compra</th>"+
                        "<th>Producto</th>"+
                        "<th>Horas compradas</th>"+
                        "<th>Clases Disponibles</th>"+
                        "<th>Vigencia</th>"+
                        "<th>Importe</th>"+
                        "<th>Tipo de compra</th>"+
                    "</tr>"+
                "</thead>"+
                "<tbody>"
                result[3].forEach(function(element) {
                    var saleType = "";
                    saleType += element.saleType;
                    purchases_table += "<tr>"+
                        "<td>"+element.saleDate+"</td>"+
                        "<td>"+element.product+"</td>"+
                        "<td>"+element.purchasedClasses+"</td>"+
                        "<td>"+element.remainingClasses+"</td>"+
                        "<td>"+element.expiration+"</td>"+
                        "<td>"+element.price+"</td>"+
                        "<td>"+saleType+"</td>"+
                    "</tr>"
                    //     "<li><ul>" +
                    //     "<li>"+element.product_id+"</li>"+
                    //     "<li>Venta: "+typeSale+"</li>"+
                    //     "<li>Clases restantes: "+element.n_classes+"</li>"+
                    //     "<li>Exipra en "+element.expiration_days+" dias</li>"+
                    //     "<li>Realizada el:"+element.created_at+"</li>"+
                    // "</ul></li>"
                });
                purchases_table +="</tbody></table>";
                saleType = "";
                Swal.fire({
                title: result[0],
                html: "<h6>Clases disponibles: " + (result[1] == null ? 0 : result[1]) + "</h6>"  +
                "<h6>Clases expiradas: " + (result[2] == null ? 0 : result[2]) + "</h6>"  +
                purchases_table,
                type: 'info',
                confirmButtonText: 'Aceptar',
                width: '150%',
                });
            },
            error: function(result){
                console.log(result);
                Swal.fire({
                    title: 'Error',
                    text: 'Ha ocurrido un error al procesar la solicitud.',
                    type: 'warning',
                    confirmButtonText: 'Aceptar'
                })
            }
        });
    }
</script>
<script>
    //OnClick Sales User Button
    $('.salesUser').on('click', function(event) {
        $('#addSaleUserModal').modal('show');
        // $(this).prop("disabled", true)
        event.preventDefault();

        //Get Full ID of the button (which contains the instructor ID)
        var fullId = this.id;
        //Split the ID of the fullId by his dash
        var splitedId = fullId.split("-");
        if(splitedId.length > 1){
            // console.log(splitedId);
            var userId = splitedId[1];
            client_id = userId;
        } else {
            $(this).prop("disabled", false)
            console.log("Malformed ID")
        }
    });
</script>