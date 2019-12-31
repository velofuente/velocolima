@extends('admin.app')

@section('extra_styles')
@stop

@section('content')
{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3 class="mr-4">Reportes</h3>
</div>
<div class="form-group row text-center ml-1">
    <div class="col-xs-3">
        <div class="input-group">
            <label for="fromDate" class="mr-sm-2">De:</label>
            {{-- <input id="fromDate" min="1900-01-01" max="2100-12-31" type="date" class="form-control{{ $errors->has('fromDate') ? ' is-invalid' : '' }}" name="fromDate" value="{{ old('fromDate') }}" required > --}}
            <input id="fromDate"  type="text" class="form-control{{ $errors->has('fromDate') ? ' is-invalid' : '' }}" name="fromDate" value="{{ old('fromDate') }}" placeholder="mm/dd/yyyy" required >
            @if ($errors->has('fromDate'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('fromDate') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <div class="col-xs-3 ml-1">
        <div class="input-group">
            <label for="toDate" class="mr-sm-2">Al:</label>
            {{-- <input id="toDate" min="1900-01-01" max="2100-12-31" type="date" class="form-control{{ $errors->has('toDate') ? ' is-invalid' : '' }}" name="toDate" value="{{ old('toDate') }}" required > --}}
            <input id="toDate"  type="text" class="form-control{{ $errors->has('toDate') ? ' is-invalid' : '' }}" name="toDate" value="{{ old('Date') }}" placeholder="mm/dd/yyyy" required >
            @if ($errors->has('toDate'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('toDate') }}</strong>
            </span>
            @endif
        </div>
    </div>
    <button class="btn btn-success btn-sm mx-4 justify-content-right" id="searchButton">Buscar</button>
</div>

{{-- Table  --}}
{{-- @if (count($sales) > 0) --}}
    <table class="table table-striped table-hover" style="margin: 0 0">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Fecha y hora de compra</th>
                <th scope="col">Cliente</th>
                <th scope="col">Correo</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Realizado por:</th>
                <th scope="col">Tipo de compra</th>
            </tr>
        </thead>
        <tbody id="tableBody">
            @php
                $total = 0;
            @endphp
            @foreach ($sales as $sale)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$sale->id}}</td>
                    <td>{{$sale->created_at}}</td>
                    {{-- <td>{{date('g:i:s A', strtotime($sale->purchase->created_at))}}</td> --}}
                    <td>{{$sale->client->name}} {{$sale->client->last_name}}</td>
                    <td>{{$sale->client->email}}</td>
                    <td>{{$sale->productWithTrashed->description}}</td>
                    <td>${{$sale->productWithTrashed->price}}</td>
                    @if($sale->sales)
                        <td>{{$sale->sales->admin->name}} {{$sale->sales->admin->last_name}}</td>
                    @else
                        <td>N/A</td>
                    @endif

                    @if($sale->card_id || $sale->card_token)
                        <td>Online</td>
                    @else
                        <td>Mostrador</td>
                    @endif
                    <input type="hidden" class="sum" value="{{$sale->productWithTrashed->price}}">
                </tr>
                @php
                    $total += $sale->productWithTrashed->price;
                @endphp
            @endforeach
        </tbody>
    </table>
    <div class="row text-center mx-0 py-4">
        <h3 class="mr-4" id="total">Total: ${{$total}}</h3>
    </div>
{{-- @else
    <h2 class="text-center">Aún no se ha realizado ninguna venta</h2>
@endif --}}
@stop

@section('extra_scripts')
<script>
    var user_id = null;
    var fromDate = null;
    var toDate = null;
    $(document).ready(function (){

        $('#fromDate, #toDate').datepicker({
            // showButtonPanel: true,
            dayNamesMin: ["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa", "Do"],
            dayNamesShort: ["Dom", "Lun", "Mar", "Mie", "Jue", "Vie", "Sab", "Dom"],
            dayNames: ["Domingo", "Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"],
            monthNames: ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"],
            monthNamesShort: ["Ene", "Feb", "Mar", "Abr", "May", "Jun", "Jul", "Ago", "Sep", "Oct", "Nov", "Dic"],
            currentText: "Hoy",
            changeMonth: true,
            changeYear: true,
            yearRange: '1920:2019',
            dateFormat: 'yy-mm-dd',
            onSelect: function(dateText, inst) {
                $(inst).val(dateText); // Write the value in the input
            }
        });

        // $('#selectReport').change(function() {
        //     getReports($(this).val());
        // });

        $('#searchButton').on('click', function(){
            getReports();
        });

        //getuserinfo click
        $(document).on('click', '.userRow', function(event) {
            console.log("clicked a row");
            var user_id = this.id;
            console.log(user_id);
            getUserInfoReports(user_id);
        });
    });
</script>
<script>
    function getReports(){
        fromDate = $('#fromDate').val();
        toDate = $('#toDate').val();
        $.ajax({
            url: 'getReports',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                fromDate: fromDate,
                toDate: toDate,
            },
            success: function(result) {
                console.log(result);
                $('#tableBody').empty();
                $.each (result, function(index, value){
                    console.log(value);
                    var admin ="N/A"; 
                    var saleText  = "Mostrador";
                    if(value.card_id){
                        saleText  = "Online";
                    }
                    
                    //verificar si fue administrador
                    if(value.sales){
                        admin = value.sales.admin.name+" "+value.sales.admin.last_name
                    }
                    $('#tableBody').append(
                        "<tr class='userRow' id='"+value.user_id+"' style='font-size: 0.9em;''>"+
                            "<td>"+value.id+"</td>"+
                            "<td>"+value.created_at+"</td>"+
                            // "<td>"+value.date+"</td>"+
                            "<td>"+value.client.name+" "+value.client.last_name+"</td>"+
                            "<td>"+value.client.email+"</td>"+
                            "<td>"+value.product_with_trashed.description+"</td>"+
                            "<td>$"+value.product_with_trashed.price+"</td>"+
                            "<td>"+admin+"</td>"+
                            "<td>"+saleText+"</td>"+
                            "<input type='hidden' class='sum' value='"+value.product_with_trashed.price+"'>"+
                        "</tr>"
                    );
                });
                sum();
            },
            error: function(result) {
                console.log("error");
                console.log(result);
            }
        });
    }
</script>
<script>
    function getUserInfoReports(user_id){
        console.log("entró a getuserinfoReports");
        console.log(user_id);
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
                        "<th>Vigencia</th>"+
                        "<th>Importe</th>"+
                        "<th>Tipo de compra</th>"+
                    "</tr>"+
                "</thead>"+
                "<tbody>"
                result[3].forEach(function(element) {
                    var saleType = "";
                    saleType += (element.saleType == null ? 'Mostrador' : 'Online');
                    purchases_table += "<tr>"+
                        "<td>"+element.saleDate+"</td>"+
                        "<td>"+element.product+"</td>"+
                        "<td>"+element.purchasedClasses+"</td>"+
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
    function sum(){
        var elements = document.getElementsByClassName("sum");
        var sum = 0;
        for(var i=0; i<elements.length; i++) {
            sum += parseInt(elements[i].value);
        }
        document.getElementById("total").innerHTML = "Total: $"+sum;
    }
</script>
@stop