@extends('admin.app')

@section('extra_styles')
@stop

@section('content')
{{-- Table with the Info --}}
<div class="row text-center mx-0 py-4">
    <h3 class="mr-4">Reportes</h3>
        <select class="dropdown" id="selectReport">
            <option value="hoy" selected="selected">Hoy</option>
            <option value="semana">Esta semana</option>
            <option value="mes">Este mes</option>
        </select>
    {{-- <button class="btn btn-success btn-sm mx-4 justify-content-right" id="Imprimir">Imprimir</button> --}}
</div>

{{-- Table  --}}
{{-- @if (count($sales) > 0) --}}
    <table class="table table-striped table-hover" style="margin: 0 0">
        <thead style="font-size: 1em;">
            <tr style="font-size: 1em;">
                <th scope="col">ID</th>
                <th scope="col">Fecha Compra</th>
                <th scope="col">Hora Compra</th>
                <th scope="col">Cliente</th>
                <th scope="col">Correo</th>
                <th scope="col">Producto</th>
                <th scope="col">Precio</th>
                <th scope="col">Realizado por:</th>
            </tr>
        </thead>
        <tbody class="tableBody">
            @foreach ($sales as $sale)
                <tr style="font-size: 0.9em;">
                    {{-- <th scope="row">{{$product->id}}</th> --}}
                    <td>{{$sale->id}}</td>
                    <td>{{date('d-M-Y', strtotime($sale->purchase->created_at))}}</td>
                    <td>{{date('g:i:s A', strtotime($sale->purchase->created_at))}}</td>
                    <td>{{$sale->purchase->client->name}} {{$sale->purchase->client->last_name}}</td>
                    <td>{{$sale->purchase->client->email}}</td>
                    <td>{{$sale->purchase->productWithTrashed->description}}</td>
                    <td>${{$sale->purchase->productWithTrashed->price}}</td>
                    <td>{{$sale->admin->name}} {{$sale->admin->last_name}}</td>
                    <input type="hidden" class="sum" value="{{$sale->purchase->productWithTrashed->price}}">
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="row text-center mx-0 py-4">
        <h3 class="mr-4" id="total">Total: $</h3>
    </div>
{{-- @else --}}
    {{-- <h2 class="text-center">Aún no se ha realizado ninguna venta</h2> --}}
{{-- @endif --}}
@stop

@section('extra_scripts')
{{-- <script>
    $(document).ready(function (){
        // Dropdown Selected Option
        $('.dropdown-menu a').click(function(){
            $('#selectedSchedule').text($(this).text());

            // Active Schedule Dropdown
            $(activeDropdownSchedule).removeClass('active');
            $(this).addClass('active');
            activeDropdownSchedule = this;

            previousSchedule = this;
        });

        $('.scheduleList').on('click', function(event){
            $('#tableBody').empty();
            event.preventDefault();
            schedule_id = $(this).attr('id');
            // showClients(schedule_id);
            showClientsTable(schedule_id);
        });
    });
    getReports(range){
        $.ajax({
            url: 'getReports',
            type: 'POST',
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                range: range,
            },
            success: function(result) {
                console.log(result);
                $('.tableBody').empty();
                $.each (result, function(index, value){
                    console.log(value);
                    $('#tableBody').append(
                        "<tr style='font-size: 0.9em;''>"+
                            "<td>{{$sale->id}}</td>"+
                            "<td>{{date('d-M-Y', strtotime($sale->purchase->created_at))}}</td>"
                            "<td>{{date('g:i:s A', strtotime($sale->purchase->created_at))}}</td>"+
                            "<td>{{$sale->purchase->client->name}} {{$sale->purchase->client->last_name}}</td>"+
                            "<td>{{$sale->purchase->client->email}}</td>"+
                            "<td>{{$sale->purchase->productWithTrashed->description}}</td>"+
                            "<td>${{$sale->purchase->productWithTrashed->price}}</td>"+
                            "<td>{{$sale->admin->name}} {{$sale->admin->last_name}}</td>"+
                            "<input type='hidden' class='sum' value='{{$sale->purchase->productWithTrashed->price}}'>"+
                        "</tr>"
                    );
                });
            },
            error: function(result) {
                console.log(result);
            }
        });
    }
</script> --}}
<script>
    var elements = document.getElementsByClassName("sum");
    var sum = 0;
    for(var i=0; i<elements.length; i++) {
        sum += parseInt(elements[i].value);
    }
    document.getElementById("total").innerHTML += sum;
</script>
@stop